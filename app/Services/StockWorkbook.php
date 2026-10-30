<?php

namespace App\Services;

use App\Models\StockFileExport;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Cell\FormulaCell;
use OpenSpout\Common\Entity\Cell\StringCell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Reader\XLSX\Reader;
use OpenSpout\Writer\XLSX\Entity\SheetView;
use OpenSpout\Writer\XLSX\Writer;
use ZipArchive;

class StockWorkbook
{
    public const HEADERS = ['Номер', 'Название', 'Производитель', 'Страна производства', 'Модель', 'Физический остаток, шт.', 'Цена'];

    public function write(StockFileExport $export): string
    {
        $path = tempnam(sys_get_temp_dir(), 'autobagaz-stock-');
        $writer = new Writer;
        try {
            $writer->openToFile($path);
            $header = (new Style)->setFontBold()->setBackgroundColor('243746')->setFontColor('FFFFFF');
            $editable = (new Style)->setBackgroundColor('FFF2CC');
            $price = (clone $editable)->setFormat('#,##0.00');
            $groups = collect($export->products)->groupBy('type');
            if ($groups->isEmpty()) {
                $groups->put('Товары', collect());
            }
            foreach ($groups as $index => $products) {
                $sheet = $writer->getCurrentSheet();
                // Prefix with an ordinal to keep arbitrary type names unique within Excel's 31-character limit.
                $number = count($writer->getSheets());
                $sheet->setName($number.'. '.mb_substr(preg_replace('~[\\\\/?:*\[\]]~u', '', $index), 0, 26));
                $sheet->setColumnWidth(12, 1);
                $sheet->setColumnWidth(55, 2);
                $sheet->setColumnWidthForRange(24, 3, 5);
                $sheet->setColumnWidth(26, 6);
                $sheet->setColumnWidth(18, 7);
                $sheet->setSheetView((new SheetView)->setFreezeRow(2)->setShowGridLines(false));
                $writer->addRow(Row::fromValues(self::HEADERS, $header));
                foreach ($products as $product) {
                    $values = [$product['id'], $product['name'], $product['manufacturer'], $product['country'], $product['model'], $product['stock'], (float) $product['price']];
                    $cells = [];
                    foreach ($values as $column => $value) {
                        $style = match ($column) {
                            5 => $editable, 6 => $price, default => null
                        };
                        // Product text must never be interpreted as an Excel formula.
                        $cells[] = is_string($value) ? new StringCell($value, $style) : Cell::fromValue($value, $style);
                    }
                    $writer->addRow(new Row($cells));
                }
                $writer->addNewSheetAndMakeItCurrent();
            }
            $writer->getCurrentSheet()->setName('Сведения');
            $writer->getCurrentSheet()->setColumnWidth(100, 1);
            $writer->getCurrentSheet()->setColumnWidth(45, 2);
            foreach ([
                ['Автобагаж: остатки, версия 1', $export->id],
                ['Дата выгрузки', $export->created_at->timezone(config('app.display_timezone'))->toIso8601String()],
                ['Меняйте только жёлтые колонки: физический остаток и цена.'],
                ['Пустая ячейка — не менять. Ноль — установить ноль.'],
                ['Отсутствующие товары не изменяются и не удаляются.'],
                ['Сохраните лист «Сведения»: он нужен для проверки конфликтов.'],
            ] as $values) {
                $writer->addRow(Row::fromValues($values));
            }
            $writer->close();

            return $path;
        } catch (\Throwable $error) {
            $writer->close();
            @unlink($path);
            throw $error;
        }
    }

    /** @return array{export_id: string, rows: array} */
    public function read(string $path): array
    {
        $zip = new ZipArchive;
        if ($zip->open($path) !== true) {
            $this->fail('Файл не является исправной книгой XLSX.');
        }
        try {
            $size = 0;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $size += $zip->statIndex($i)['size'];
                if ($size > 50 * 1024 * 1024 || $zip->numFiles > 1000) {
                    $this->fail('Книга слишком большая. Максимум 50 МБ после распаковки и 1000 файлов внутри архива.');
                }
            }
        } finally {
            $zip->close();
        }

        $reader = new Reader;
        $rows = [];
        $exportId = null;
        $count = 0;
        try {
            $reader->open($path);
            foreach ($reader->getSheetIterator() as $sheet) {
                $first = true;
                foreach ($sheet->getRowIterator() as $rowNumber => $row) {
                    if (++$count > 10020) {
                        $this->fail('В книге допускается не более 10 000 строк товаров.');
                    }
                    $values = $row->toArray();
                    if ($sheet->getName() === 'Сведения') {
                        if ($first) {
                            if (($values[0] ?? null) !== 'Автобагаж: остатки, версия 1' || $exportId !== null) {
                                $this->fail('Некорректные сведения о выгрузке.');
                            }
                            $exportId = $values[1] ?? null;
                        }
                    } elseif ($first) {
                        if (array_slice($values, 0, 7) !== self::HEADERS) {
                            $this->fail('Заголовки колонок изменены. Используйте файл, выгруженный из раздела «Остатки».');
                        }
                    } else {
                        foreach ([0, 5, 6] as $column) {
                            if ($row->getCellAtIndex($column) instanceof FormulaCell) {
                                $this->fail('Номер, остаток и цена должны быть значениями, без формул.');
                            }
                        }
                        $rows[] = ['id' => $values[0] ?? null, 'stock' => $values[5] ?? null, 'price' => $values[6] ?? null, 'location' => $sheet->getName().', строка '.$rowNumber];
                    }
                    $first = false;
                }
            }
        } finally {
            $reader->close();
        }
        if (! is_string($exportId) || ! Str::isUuid($exportId)) {
            $this->fail('Не найден идентификатор выгрузки. Сохраните лист «Сведения».');
        }

        return ['export_id' => $exportId, 'rows' => $rows];
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['file' => $message]);
    }
}
