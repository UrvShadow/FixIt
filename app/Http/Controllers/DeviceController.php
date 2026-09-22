<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function index(): View
    {
        $devices = auth()->user()->devices()->latest()->get();

        return view('devices.index', compact('devices'));
    }

    public function create(): View
    {
        return view('devices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:100'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['device_code'] = 'DEV-' . strtoupper(uniqid());

        auth()->user()->devices()->create($validated);

        return redirect()
            ->route('devices.index')
            ->with('success', 'Device berhasil ditambahkan.');
    }
    public function edit(Device $device): View
{
    abort_unless($device->user_id === auth()->id(), 403);

    return view('devices.edit', compact('device'));
}

    public function update(Request $request, Device $device): RedirectResponse
    {
        abort_unless($device->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:100'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

    $device->update($validated);

    return redirect()
        ->route('devices.index')
        ->with('success', 'Device berhasil diperbarui.');
}

    public function destroy(Device $device): RedirectResponse
    {
        abort_unless($device->user_id === auth()->id(), 403);

        $device->delete();

        return redirect()
            ->route('devices.index')
            ->with('success', 'Device berhasil dihapus.');
}
}