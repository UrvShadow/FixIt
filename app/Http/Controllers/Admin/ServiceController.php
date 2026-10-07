<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display all services.
     */
    public function index(): View
    {
        $services = Service::orderBy('name')->get();

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show create form.
     */
    public function create(): View
    {
        return view('admin.services.create');
    }

    /**
     * Store a new service.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'slug' => [
                'required',
                'string',
                'max:120',
                'unique:services,slug',
            ],

            'category' => [
                'required',
                'string',
                'max:50',
            ],

            'description' => [
                'required',
                'string',
            ],

            'starting_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        Service::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'starting_price' => $validated['starting_price'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service berhasil ditambahkan.');
    }

    /**
     * Show edit form.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update an existing service.
     */
    public function update(
        Request $request,
        Service $service
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'slug' => [
                'required',
                'string',
                'max:120',
                'unique:services,slug,' . $service->id,
            ],

            'category' => [
                'required',
                'string',
                'max:50',
            ],

            'description' => [
                'required',
                'string',
            ],

            'starting_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $service->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'starting_price' => $validated['starting_price'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service berhasil diperbarui.');
    }

    /**
     * Toggle service availability.
     */
    public function toggleStatus(Service $service): RedirectResponse
    {
        $service->update([
            'is_active' => ! $service->is_active,
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with(
                'success',
                $service->is_active
                    ? 'Service berhasil diaktifkan.'
                    : 'Service berhasil dinonaktifkan.'
            );
    }
}