<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepairRequestController extends Controller
{
    public function index(): View
    {
        $repairRequests = auth()->user()
            ->repairRequests()
            ->with('device')
            ->latest()
            ->get();

        return view('repairs.index', compact('repairRequests'));
    }

    public function show(RepairRequest $repair): View
    {
    abort_unless($repair->user_id === auth()->id(), 403);

    $repair->load([
        'user',
        'device',
        'repairHistories' => function ($query) {
            $query->with('createdBy')->latest();
        },
        'invoice',
    ]);

    return view('repairs.show', compact('repair'));
}

    public function create(): View
    {
        $devices = auth()->user()
            ->devices()
            ->latest()
            ->get();

        return view('repairs.create', compact('devices'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'device_id' => ['required', 'integer'],
            'issue' => ['required', 'string', 'max:5000'],
        ]);

        $device = auth()->user()
            ->devices()
            ->findOrFail($validated['device_id']);

        $repairRequest = RepairRequest::create([
            'device_id' => $device->id,
            'user_id' => auth()->id(),
            'issue' => $validated['issue'],
            'status' => 'pending',
        ]);

        $repairRequest->repairHistories()->create([
            'status' => 'pending',
            'note' => 'Repair request submitted by user.',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('repairs.index')
            ->with('success', 'Repair request berhasil dibuat.');
    }
}