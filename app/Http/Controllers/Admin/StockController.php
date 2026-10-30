<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockFileExport;
use App\Models\StockFileImport;
use App\Services\StockFileService;
use App\Services\StockWorkbook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StockController extends Controller
{
    public function index(): View
    {
        return view('admin.stock.index', [
            'count' => Product::query()->count(),
            'imports' => StockFileImport::query()->with('user')->whereNotNull('applied_at')->latest('applied_at')->paginate(20),
        ]);
    }

    public function export(Request $request, StockFileService $service, StockWorkbook $workbook): BinaryFileResponse
    {
        $export = $service->export($request->user());

        return response()->download($workbook->write($export), 'autobagaz-stock-'.now()->timezone(config('app.display_timezone'))->format('Y-m-d-His').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'private, no-store',
        ])->deleteFileAfterSend();
    }

    public function preview(Request $request, StockFileService $service, StockWorkbook $workbook): RedirectResponse
    {
        $request->validate(['file' => ['required', 'file', 'extensions:xlsx', 'max:5120']]);
        try {
            $data = $workbook->read($request->file('file')->getRealPath());
        } catch (ValidationException $error) {
            throw $error;
        } catch (\Throwable $error) {
            report($error);
            throw ValidationException::withMessages(['file' => 'Не удалось прочитать XLSX. Проверьте файл и сохраните его заново без пароля.']);
        }
        $import = $service->preview($request->user(), $request->file('file')->getClientOriginalName(), $data);

        return redirect()->route('admin.stock.show', $import);
    }

    public function show(Request $request, StockFileImport $import): View
    {
        abort_unless($import->applied_at || $import->user_id === $request->user()->id, 403);

        return view('admin.stock.show', [
            'import' => $import->load('user'),
            'export' => StockFileExport::query()->findOrFail($import->stock_file_export_id),
        ]);
    }

    public function apply(Request $request, StockFileImport $import, StockFileService $service): RedirectResponse
    {
        $data = $request->validate([
            'decisions' => ['sometimes', 'array'],
            'decisions.*' => ['array'],
            'decisions.*.*' => ['required', 'in:site,file'],
        ]);
        $service->apply($import, $request->user(), $data['decisions'] ?? []);

        return redirect()->route('admin.stock.show', $import)->with('success', 'Импорт применён. Цены и физические остатки обновлены.');
    }
}
