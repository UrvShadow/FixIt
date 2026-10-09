<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display the service catalog.
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));

        $services = Service::query()
            ->where('is_active', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('services.index', compact('services', 'search'));
    }

    /**
     * Display a service detail.
     */
    public function show(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('services.show', compact('service'));
    }
}