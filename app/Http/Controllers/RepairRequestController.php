<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepairRequestController extends Controller
{
    public function index(): View
    {
        $repairRequests = auth()->user()
            ->repairRequests()
            ->with([
                'device',
                'service',
            ])
            ->latest()
            ->get();

        return view('repairs.index', compact('repairRequests'));
    }

    public function show(RepairRequest $repair): View
    {
        abort_unless(
            $repair->user_id === auth()->id(),
            403
        );

        $repair->load([
            'user',
            'device',
            'service',
            'repairHistories' => function ($query) {
                $query->with('createdBy')->latest();
            },
            'invoice',
        ]);

        return view('repairs.show', compact('repair'));
    }

    public function create(Request $request): View
    {
        $devices = auth()->user()
            ->devices()
            ->latest()
            ->get();

        $service = null;

        if ($request->filled('service')) {
            $service = Service::where('slug', $request->service)
                ->where('is_active', true)
                ->first();
        }

        return view('repairs.create', compact(
            'devices',
            'service'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'device_id' => [
                'required',
                'integer',
            ],

            'service_id' => [
                'nullable',
                'integer',
                'exists:services,id',
            ],

            'preferred_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],

            'issue' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify Device Ownership
        |--------------------------------------------------------------------------
        */

        $device = auth()->user()
            ->devices()
            ->findOrFail($validated['device_id']);

        /*
        |--------------------------------------------------------------------------
        | Verify Service
        |--------------------------------------------------------------------------
        */

        $service = null;

        if (!empty($validated['service_id'])) {
            $service = Service::where('id', $validated['service_id'])
                ->where('is_active', true)
                ->firstOrFail();
        }

        /*
        |--------------------------------------------------------------------------
        | Create Repair Request
        |--------------------------------------------------------------------------
        */

        $repairRequest = RepairRequest::create([
            'device_id' => $device->id,
            'user_id' => auth()->id(),
            'service_id' => $service?->id,
            'preferred_date' => $validated['preferred_date'] ?? null,
            'issue' => $validated['issue'],
            'status' => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Initial Repair History
        |--------------------------------------------------------------------------
        */

        $repairRequest->repairHistories()->create([
            'status' => 'pending',
            'note' => 'Repair request submitted by user.',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('repairs.index')
            ->with(
                'success',
                'Repair request berhasil dibuat.'
            );
    }
}