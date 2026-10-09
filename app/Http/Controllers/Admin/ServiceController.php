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
     * Display and search services.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';

        $query = Service::query();

        // Search by service name, description, category, or slug.
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $term = '%' . $search . '%';

                $q->where('name', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('slug', 'like', $term);
            });
        }

        // Filter by availability.
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $services = $query
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.services.index', compact(
            'services',
            'search',
            'status'
        ));
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
     * Preserve the current search and status filters.
     */
    public function toggleStatus(
        Request $request,
        Service $service
    ): RedirectResponse {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        $service->update([
            'is_active' => ! $service->is_active,
        ]);

        $query = array_filter(
            $filters,
            static fn ($value) => $value !== null && $value !== ''
        );

        return redirect()
            ->route('admin.services.index', $query)
            ->with(
                'success',
                $service->is_active
                    ? 'Service berhasil diaktifkan.'
                    : 'Service berhasil dinonaktifkan.'
            );
    }
}