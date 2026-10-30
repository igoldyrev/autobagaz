<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentalRequestStoreRequest;
use App\Models\RentalRequest;
use App\Models\RentalService;
use App\Services\OrderWorkflow;
use App\Support\PersonalDataConsent;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RentalController extends Controller
{
    public function index(): View
    {
        $token = session('rental_submission_token');
        if (! $token || RentalRequest::query()->where('submission_token', $token)->exists()) {
            $token = (string) Str::uuid();
            session(['rental_submission_token' => $token]);
        }

        return view('rental', ['service' => RentalService::current(), 'submissionToken' => $token]);
    }

    public function document(string $kind): BinaryFileResponse
    {
        abort_unless(in_array($kind, ['contract', 'rules'], true), 404);
        $path = RentalService::current()->getAttribute($kind.'_path');
        $file = $path ? Storage::disk('local')->path($path) : public_path('content/prokat/'.($kind === 'contract' ? 'Dogovor_prokata.doc' : 'Pravila_ekspluatacii_avtoboksov.doc'));
        abort_unless(is_file($file), 404);

        return response()->download($file, ($kind === 'contract' ? 'Dogovor_prokata' : 'Pravila_ekspluatacii_avtoboksov').'.'.pathinfo($file, PATHINFO_EXTENSION), ['X-Content-Type-Options' => 'nosniff']);
    }

    public function store(RentalRequestStoreRequest $request): RedirectResponse
    {
        abort_unless(hash_equals((string) $request->session()->get('rental_submission_token'), $request->string('submission_token')->toString()), 419);
        $service = RentalService::current();
        abort_unless($service->is_available, 422, 'Приём заявок на прокат временно отключён.');
        $data = $request->validated();
        $days = (int) CarbonImmutable::parse($data['starts_on'])->diffInDays(CarbonImmutable::parse($data['ends_on'])) + 1;
        $price = $service->dailyPrice((int) $data['group'], $days);
        $total = RentalRequest::cents($price) * $days * $data['quantity'];
        if ($total > 999999999999) {
            throw ValidationException::withMessages(['quantity' => 'Расчётная стоимость слишком велика. Уточните количество или срок проката.']);
        }
        $record = RentalRequest::query()->firstOrCreate(['submission_token' => $data['submission_token']], [
            ...$request->safe()->only(['name', 'phone', 'vehicle', 'comment', 'starts_on', 'ends_on', 'quantity']),
            ...PersonalDataConsent::attributes(),
            'assignee_id' => app(OrderWorkflow::class)->defaultAssigneeId(),
            'equipment' => $service->groups[$data['group']],
            'daily_price' => $price,
            'rental_total' => number_format($total / 100, 2, '.', ''),
            'original_request' => [...$request->safe()->only(['name', 'phone', 'vehicle', 'comment', 'starts_on', 'ends_on', 'quantity']), 'equipment' => $service->groups[$data['group']], 'daily_price' => $price, 'days' => $days],
        ]);

        return redirect()->to(route('rental').'#rental-success')->with('rental_success', 'Заявка на прокат №'.$record->id.' принята. Менеджер свяжется с вами для подтверждения оборудования, сроков и залога.');
    }
}
