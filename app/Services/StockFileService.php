<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\Product;
use App\Models\StockFileExport;
use App\Models\StockFileImport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockFileService
{
    public function export(User $user): StockFileExport
    {
        $products = Product::query()->with(['productType', 'roofRack.manufacturer', 'autoBox.manufacturer', 'bikeRack.manufacturer', 'skiRack.manufacturer'])
            ->orderBy('product_type_id')->orderBy('id')->get()->mapWithKeys(fn (Product $product) => [
                $product->id => [
                    'id' => $product->id,
                    'type' => $product->productType?->name ?? 'Другие товары',
                    'name' => $product->name,
                    'manufacturer' => $product->roofRack?->manufacturer?->name ?? $product->autoBox?->manufacturer?->name ?? $product->bikeRack?->manufacturer?->name ?? $product->skiRack?->manufacturer?->name ?? $product->manufacturer ?? '',
                    'country' => $product->country_of_origin ?? '',
                    'model' => $product->product_model ?? '',
                    'stock' => $product->stock,
                    'price' => $product->price,
                ],
            ])->all();

        return StockFileExport::query()->create(['user_id' => $user->id, 'products' => $products]);
    }

    public function preview(User $user, string $filename, array $data): StockFileImport
    {
        $export = StockFileExport::query()->find($data['export_id']);
        if (! $export) {
            $this->fail('Выгрузка не найдена на этом сайте. Скачайте новый файл.');
        }
        $baseline = $export->products;
        $rows = [];
        $errors = [];
        foreach ($data['rows'] as $row) {
            $id = $row['id'];
            if ($id === null && blank($row['stock']) && blank($row['price'])) {
                continue;
            }
            if ((! is_int($id) && ! is_float($id) && ! is_string($id)) || ! preg_match('/^[1-9]\d*$/D', (string) $id) || ! isset($baseline[$id])) {
                $errors[] = $row['location'].': неизвестный номер товара.';

                continue;
            }
            if (isset($rows[$id])) {
                $errors[] = $row['location'].': повторяется номер товара '.$id.'.';

                continue;
            }
            $rows[$id] = [];
            foreach (['stock', 'price'] as $field) {
                try {
                    $rows[$id][$field] = $this->number($row[$field], $field);
                } catch (\InvalidArgumentException) {
                    $errors[] = $row['location'].': некорректное значение «'.($field === 'stock' ? 'Физический остаток' : 'Цена').'».';
                }
            }
        }
        if ($errors) {
            throw ValidationException::withMessages(['file' => array_slice($errors, 0, 30)]);
        }
        $current = Product::query()->whereIn('id', array_keys($rows))->get()->keyBy('id');
        $changes = [];
        foreach ($rows as $id => $values) {
            if (! isset($current[$id])) {
                $this->fail('Товар №'.$id.' удалён с сайта. Уберите его строку и загрузите файл снова.');
            }
            $fields = [];
            foreach ($values as $field => $value) {
                $original = $this->number($baseline[$id][$field], $field);
                $now = $this->number($current[$id]->$field, $field);
                if ($value === null || $value === $original || $value === $now) {
                    continue;
                }
                $fields[$field] = ['original' => $original, 'current' => $now, 'value' => $value, 'conflict' => $now !== $original];
            }
            if ($fields) {
                $changes[] = ['id' => (int) $id, 'name' => $current[$id]->name, 'fields' => $fields];
            }
        }
        if (! $changes) {
            $this->fail('Изменений цен и остатков для применения нет.');
        }

        return StockFileImport::query()->create([
            'user_id' => $user->id,
            'stock_file_export_id' => $export->id,
            'filename' => mb_substr(basename($filename), 0, 255),
            'changes' => $changes,
        ]);
    }

    public function apply(StockFileImport $import, User $user, array $decisions): void
    {
        DB::transaction(function () use ($import, $user, $decisions): void {
            $import = StockFileImport::query()->lockForUpdate()->findOrFail($import->id);
            abort_unless($import->user_id === $user->id, 403);
            if ($import->applied_at) {
                $this->fail('Этот импорт уже применён. Повторное применение запрещено.');
            }
            $changes = $import->changes;
            $products = Product::query()->whereIn('id', array_column($changes, 'id'))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            foreach ($changes as &$change) {
                $product = $products[$change['id']] ?? null;
                if (! $product) {
                    $this->fail('Состав товаров изменился. Загрузите файл заново для нового предпросмотра.');
                }
                $query = Product::query()->whereKey($product->id);
                $updates = [];
                $history = [];
                foreach ($change['fields'] as $field => &$values) {
                    if ($this->number($product->$field, $field) !== $values['current']) {
                        $this->fail('Данные товара №'.$product->id.' изменились после предпросмотра. Загрузите файл заново. Ничего не применено.');
                    }
                    $decision = $decisions[$product->id][$field] ?? null;
                    if ($values['conflict'] && ! in_array($decision, ['site', 'file'], true)) {
                        $this->fail('Выберите решение для каждого конфликта.');
                    }
                    $values['applied'] = ! $values['conflict'] || $decision === 'file';
                    $query->where($field, $values['current']);
                    if ($values['applied']) {
                        $updates[$field] = $values['value'];
                        $history[] = ($field === 'stock' ? 'остаток' : 'цена').': '.$values['current'].' → '.$values['value'];
                    }
                }
                unset($values);
                // Conditional UPDATE also protects against writers that do not take an explicit row lock.
                if ($updates && $query->update($updates) !== 1) {
                    $this->fail('Остатки или цены изменились во время применения. Загрузите файл заново. Ничего не применено.');
                }
                if ($updates) {
                    app(AdminActivityLogger::class)->record($user, AdminActivityLog::ACTION_UPDATED,
                        'Импорт «'.$import->filename.'», товар №'.$product->id.': '.implode('; ', $history),
                        'product', $product->id, $product->name);
                }
            }
            unset($change);
            $import->update(['changes' => $changes, 'applied_at' => now()]);
        });
    }

    private function number(mixed $value, string $field): int|string|null
    {
        if ($value === null || $value === '' || (is_string($value) && trim($value) === '')) {
            return null;
        }
        if (! is_int($value) && ! is_float($value) && ! is_string($value)) {
            throw new \InvalidArgumentException;
        }
        $value = str_replace(',', '.', trim((string) $value));
        if ($field === 'stock') {
            if (! preg_match('/^\d+$/D', $value) || (float) $value > 4294967295) {
                throw new \InvalidArgumentException;
            }

            return (int) $value;
        }
        if (! preg_match('/^\d+(?:\.\d{1,2})?$/D', $value) || (float) $value > 9999999999.99) {
            throw new \InvalidArgumentException;
        }

        return number_format((float) $value, 2, '.', '');
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['file' => $message]);
    }
}
