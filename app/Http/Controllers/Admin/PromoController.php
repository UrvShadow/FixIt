<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function index(): View
    {
        $promos = Promo::orderBy('created_at', 'desc')->get();

        return view(
            'admin.promos.index',
            compact('promos')
        );
    }

    public function create(): View
    {
        return view('admin.promos.create');
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:promos,code',
            ],

            'discount_type' => [
                'required',
                'in:percentage,fixed',
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0',
            ],

            'minimum_transaction' => [
                'required',
                'numeric',
                'min:0',
            ],

            'expires_at' => [
                'nullable',
                'date',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Percentage Validation
        |--------------------------------------------------------------------------
        */

        if (
            $validated['discount_type'] === 'percentage' &&
            $validated['discount_value'] > 100
        ) {
            return back()
                ->withErrors([
                    'discount_value' =>
                        'Percentage discount tidak boleh lebih dari 100%.',
                ])
                ->withInput();
        }

        Promo::create([
            'code' => strtoupper(
                trim($validated['code'])
            ),

            'discount_type' =>
                $validated['discount_type'],

            'discount_value' =>
                $validated['discount_value'],

            'minimum_transaction' =>
                $validated['minimum_transaction'],

            'expires_at' =>
                $validated['expires_at'] ?? null,

            'is_active' =>
                $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.promos.index')
            ->with(
                'success',
                'Promo berhasil ditambahkan.'
            );
    }

    public function edit(
        Promo $promo
    ): View {
        return view(
            'admin.promos.edit',
            compact('promo')
        );
    }

    public function update(
        Request $request,
        Promo $promo
    ): RedirectResponse {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:promos,code,' . $promo->id,
            ],

            'discount_type' => [
                'required',
                'in:percentage,fixed',
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0',
            ],

            'minimum_transaction' => [
                'required',
                'numeric',
                'min:0',
            ],

            'expires_at' => [
                'nullable',
                'date',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Percentage Validation
        |--------------------------------------------------------------------------
        */

        if (
            $validated['discount_type'] === 'percentage' &&
            $validated['discount_value'] > 100
        ) {
            return back()
                ->withErrors([
                    'discount_value' =>
                        'Percentage discount tidak boleh lebih dari 100%.',
                ])
                ->withInput();
        }

        $promo->update([
            'code' => strtoupper(
                trim($validated['code'])
            ),

            'discount_type' =>
                $validated['discount_type'],

            'discount_value' =>
                $validated['discount_value'],

            'minimum_transaction' =>
                $validated['minimum_transaction'],

            'expires_at' =>
                $validated['expires_at'] ?? null,

            'is_active' =>
                $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.promos.index')
            ->with(
                'success',
                'Promo berhasil diperbarui.'
            );
    }

    public function toggleStatus(
        Promo $promo
    ): RedirectResponse {
        $promo->update([
            'is_active' => ! $promo->is_active,
        ]);

        return redirect()
            ->route('admin.promos.index')
            ->with(
                'success',
                $promo->is_active
                    ? 'Promo berhasil diaktifkan.'
                    : 'Promo berhasil dinonaktifkan.'
            );
    }
}