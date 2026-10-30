<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RentalUpdateRequest;
use App\Models\AdminActivityLog;
use App\Models\RentalRequest;
use App\Services\OrderWorkflow;
use App\Services\RentalWorkflow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RentalRequestController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', Rule::in(array_keys(RentalRequest::statusLabels()))],
            'response' => ['nullable', Rule::in(['waiting', 'overdue', 'answered'])],
            'assignee_id' => ['nullable', 'integer'],
            'overdue' => ['nullable', 'boolean'], 'mine' => ['nullable', 'boolean'],
        ]);
        $records = RentalRequest::query()->with('assignee')
            ->responseState($filters['response'] ?? null)
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->when($request->boolean('mine'), fn ($q) => $q->where('assignee_id', $request->user()->id))
            ->when(! $request->boolean('mine') && ($filters['assignee_id'] ?? null), fn ($q) => $q->where('assignee_id', $filters['assignee_id']))
            ->when($request->boolean('overdue'), fn ($q) => $q->where('status', 'rented')->where('ends_on', '<', now(config('app.display_timezone'))->toDateString()))
            ->when($filters['search'] ?? null, function ($q, $search): void {
                $phone = preg_replace('/[^0-9]/', '', $search);
                $literal = '%'.str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $search).'%';
                $q->where(function ($q) use ($search, $phone, $literal): void {
                    $q->where('id', ctype_digit($search) ? (int) $search : 0)->orWhereRaw("name LIKE ? ESCAPE '!'", [$literal]);
                    if ($phone !== '') {
                        $q->orWhereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '+', ''), '-', ''), '(', ''), ')', '') LIKE ?", ['%'.$phone.'%']);
                    }
                });
            })->latest('id')->paginate(30)->withQueryString();

        return view('admin.rental-requests.index', ['records' => $records, 'managers' => app(OrderWorkflow::class)->managers()]);
    }

    public function show(RentalRequest $rentalRequest): View
    {
        return view('admin.rental-requests.show', [
            'rental' => $rentalRequest->load('assignee'), 'managers' => app(OrderWorkflow::class)->managers(),
            'history' => AdminActivityLog::query()->where('subject_type', 'rental_request')->where('subject_id', $rentalRequest->id)->latest('id')->paginate(20),
        ]);
    }

    public function update(RentalUpdateRequest $request, RentalRequest $rentalRequest, RentalWorkflow $workflow): RedirectResponse
    {
        $workflow->update($rentalRequest, $request->user(), $request->validated());

        return back()->with('success', 'Заявка на прокат обновлена.');
    }
}
