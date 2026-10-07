<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display the service catalog.
     */
    public function index(): View
    {
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('services.index', compact('services'));
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