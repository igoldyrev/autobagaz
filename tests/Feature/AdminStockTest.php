<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\RoofRackManufacturer;
use App\Models\StockFileExport;
use App\Models\StockFileImport;
use App\Models\User;
use App\Services\StockWorkbook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Reader\XLSX\Reader;
use OpenSpout\Writer\XLSX\Writer;
use Tests\TestCase;

class AdminStockTest extends TestCase
{
    use RefreshDatabase;

    private array $files = [];

    protected function tearDown(): void
    {
        foreach ($this->files as $file) {
            @unlink($file);
        }
        parent::tearDown();
    }

    public function test_export_includes_hidden_products_grouped_by_type_and_manufacturer(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $type = ProductType::query()->where('code', 'roof_rack')->firstOrFail();
        $product = $this->product('rack', ['product_type_id' => $type->id, 'is_active' => false, 'country_of_origin' => 'Россия', 'product_model' => 'A-1']);
        $manufacturer = RoofRackManufacturer::query()->create(['name' => 'Производитель']);
        $product->roofRack()->create(['manufacturer_id' => $manufacturer->id]);
        $other = $this->product('other');

        $this->get(route('admin.stock.index'))->assertOk()->assertSee('Выгрузить товары')->assertSee('История загрузок');
        $path = $this->export();
        $data = app(StockWorkbook::class)->read($path);
        $this->assertCount(2, $data['rows']);
        $snapshot = StockFileExport::query()->findOrFail($data['export_id']);
        $this->assertSame('Производитель', $snapshot->products[$product->id]['manufacturer']);
        $this->assertSame('Россия', $snapshot->products[$product->id]['country']);
        $this->assertSame('A-1', $snapshot->products[$product->id]['model']);
        $this->assertArrayHasKey($other->id, $snapshot->products);
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_import_updates_only_edited_fields_and_never_deletes_absent_products(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $first = $this->product('first');
        $omitted = $this->product('omitted');
        $unchanged = $this->product('unchanged');
        $path = $this->export();
        $addedLater = $this->product('later');
        $unchanged->update(['stock' => 3]);
        $file = $this->edit($path, function (array $values) use ($first, $omitted) {
            if (($values[0] ?? null) === $omitted->id) {
                return null;
            }
            if (($values[0] ?? null) === $first->id) {
                $values[1] = 'Попытка изменить название';
                $values[5] = 0;
                $values[6] = '250,50';
            }

            return $values;
        });
        $import = $this->preview($file);
        $this->assertCount(1, $import->changes);
        $this->assertSame(5, $first->fresh()->stock);
        $this->get(route('admin.stock.show', $import))->assertOk()->assertSee('Проверка импорта');
        $this->post(route('admin.stock.apply', $import))->assertSessionDoesntHaveErrors()->assertRedirect();
        $this->assertSame(0, $first->fresh()->stock);
        $this->assertSame('250.50', $first->fresh()->price);
        $this->assertSame('first', $first->fresh()->name);
        $this->assertSame(5, $omitted->fresh()->stock);
        $this->assertSame(5, $addedLater->fresh()->stock);
        $this->assertSame(3, $unchanged->fresh()->stock);
        $this->assertDatabaseHas('admin_activity_logs', ['subject_type' => 'product', 'subject_id' => $first->id]);
        $this->get(route('admin.stock.show', $import))->assertOk()->assertSee('Применено из файла');
        $this->post(route('admin.stock.apply', $import))->assertSessionHasErrors('file');
        $this->assertSame(0, $first->fresh()->stock);
    }

    public function test_conflicts_require_explicit_per_field_decisions(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $product = $this->product('conflict');
        $path = $this->export();
        $product->update(['stock' => 3, 'price' => '120.00']);
        $import = $this->preview($this->edit($path, function ($values) use ($product) {
            if (($values[0] ?? null) === $product->id) {
                $values[5] = 8;
                $values[6] = 150;
            }

            return $values;
        }));
        $this->get(route('admin.stock.show', $import))->assertSee('Конфликт');
        $this->post(route('admin.stock.apply', $import))->assertSessionHasErrors('file');
        $this->assertSame(3, $product->fresh()->stock);
        $this->post(route('admin.stock.apply', $import), ['decisions' => [$product->id => ['stock' => 'site', 'price' => 'file']]])
            ->assertSessionDoesntHaveErrors();
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame('150.00', $product->fresh()->price);
    }

    public function test_changes_after_preview_abort_the_entire_import(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $first = $this->product('first');
        $second = $this->product('second');
        $import = $this->preview($this->edit($this->export(), function ($values) use ($first, $second) {
            if (in_array($values[0] ?? null, [$first->id, $second->id], true)) {
                $values[5] = 10;
            }

            return $values;
        }));
        $second->update(['stock' => 2]);
        $this->post(route('admin.stock.apply', $import))->assertSessionHasErrors('file');
        $this->assertSame(5, $first->fresh()->stock);
        $this->assertSame(2, $second->fresh()->stock);
        $this->assertNull($import->fresh()->applied_at);
        $this->assertDatabaseMissing('admin_activity_logs', ['subject_type' => 'product', 'subject_id' => $first->id]);
    }

    public function test_invalid_numbers_unknown_ids_and_duplicate_ids_reject_the_file(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $product = $this->product('invalid');
        $path = $this->export();
        foreach ([['stock', -1], ['stock', 1.5], ['stock', '=1+1'], ['price', 'abc'], ['price', '10.123'], ['price', -5], ['id', 999999]] as [$field, $value]) {
            $file = $this->edit($path, function ($values) use ($product, $field, $value) {
                if (($values[0] ?? null) === $product->id) {
                    $values[match ($field) {
                        'id' => 0, 'stock' => 5, 'price' => 6
                    }] = $value;
                }

                return $values;
            });
            $this->post(route('admin.stock.preview'), ['file' => $file])->assertSessionHasErrors('file');
        }
        $second = $this->product('second');
        $duplicate = $this->edit($this->export(), function ($values) use ($product, $second) {
            if (($values[0] ?? null) === $second->id) {
                $values[0] = $product->id;
            }

            return $values;
        });
        $this->post(route('admin.stock.preview'), ['file' => $duplicate])->assertSessionHasErrors('file');
        $this->assertSame(0, StockFileImport::query()->count());
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_blank_values_are_skipped_and_unknown_or_missing_export_is_rejected(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $product = $this->product('blank');
        $path = $this->export();
        $import = $this->preview($this->edit($path, function ($values) use ($product) {
            if (($values[0] ?? null) === $product->id) {
                $values[5] = null;
                $values[6] = 0;
            }

            return $values;
        }));
        $this->post(route('admin.stock.apply', $import))->assertSessionDoesntHaveErrors();
        $this->assertSame(5, $product->fresh()->stock);
        $this->assertSame('0.00', $product->fresh()->price);
        foreach ([null, '00000000-0000-4000-8000-000000000000'] as $id) {
            $file = $this->edit($path, function ($values) use ($id) {
                if (($values[0] ?? null) === 'Автобагаж: остатки, версия 1') {
                    $values[1] = $id;
                }

                return $values;
            });
            $this->post(route('admin.stock.preview'), ['file' => $file])->assertSessionHasErrors('file');
        }
    }

    public function test_access_is_restricted_and_another_manager_cannot_apply_a_pending_import(): void
    {
        $this->get(route('admin.stock.index'))->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER, 'permissions' => []]));
        $this->get(route('admin.stock.index'))->assertForbidden();
        $this->post(route('admin.stock.export'))->assertForbidden();
        $this->post(route('admin.stock.preview'))->assertForbidden();

        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $product = $this->product('private');
        $import = $this->preview($this->edit($this->export(), function ($values) use ($product) {
            if (($values[0] ?? null) === $product->id) {
                $values[5] = 9;
            }

            return $values;
        }));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get(route('admin.stock.show', $import))->assertForbidden();
        $this->post(route('admin.stock.apply', $import))->assertForbidden();
    }

    private function product(string $name, array $attributes = []): Product
    {
        return Product::query()->create([...['name' => $name, 'slug' => $name, 'price' => '100.00', 'stock' => 5], ...$attributes]);
    }

    private function export(): string
    {
        $response = $this->post(route('admin.stock.export'))->assertOk()->assertDownload();
        $path = $response->baseResponse->getFile()->getPathname();
        $this->files[] = $path;

        return $path;
    }

    private function preview(UploadedFile $file): StockFileImport
    {
        $this->post(route('admin.stock.preview'), ['file' => $file])->assertSessionDoesntHaveErrors()->assertRedirect();

        return StockFileImport::query()->latest('created_at')->firstOrFail();
    }

    private function edit(string $source, callable $edit): UploadedFile
    {
        $target = tempnam(sys_get_temp_dir(), 'stock-test-');
        $this->files[] = $target;
        $reader = new Reader;
        $writer = new Writer;
        $reader->open($source);
        $writer->openToFile($target);
        $first = true;
        foreach ($reader->getSheetIterator() as $sheet) {
            if (! $first) {
                $writer->addNewSheetAndMakeItCurrent();
            }
            $first = false;
            $writer->getCurrentSheet()->setName($sheet->getName());
            foreach ($sheet->getRowIterator() as $row) {
                $values = $edit($row->toArray());
                if ($values !== null) {
                    $writer->addRow(Row::fromValues($values));
                }
            }
        }
        $reader->close();
        $writer->close();

        return UploadedFile::fake()->createWithContent('stock.xlsx', file_get_contents($target));
    }
}
