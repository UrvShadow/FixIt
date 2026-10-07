<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Repair #{{ $repair->id }} — FixIT</title>

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('favicon.png') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/style.css') }}"
    >
</head>

<body>

    {{-- =====================================================
         NAVBAR
         ===================================================== --}}

    <header class="nav">

        <div class="container">

            <a
                href="{{ route('home') }}"
                class="brand"
            >
                <span class="mark">FX</span>FixIT
            </a>

            <nav class="nav-links">

                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <a
                    href="{{ route('admin.repairs.index') }}"
                    class="active"
                >
                    Repairs
                </a>

                <a href="{{ route('admin.services.index') }}">
                    Services
                </a>

            </nav>

            <div class="nav-actions">

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="btn -secondary -sm"
                    >
                        Log out
                    </button>
                </form>

            </div>

        </div>

    </header>


    {{-- =====================================================
         MAIN
         ===================================================== --}}

    <main>

        <section class="admin-repair-detail">

            <div class="container">


                {{-- Back --}}
                <div class="admin-repair-back">

                    <a
                        href="{{ route('admin.repairs.index') }}"
                        class="btn -ghost -sm"
                    >
                        ← Repair Requests
                    </a>

                </div>


                {{-- =================================================
                     HEADER
                     ================================================= --}}

                <div class="admin-repair-head">

                    <div>

                        <div class="admin-repair-head-meta">

                            <span class="ticket-code">
                                REPAIR #{{ $repair->id }}
                            </span>

                            <span class="repair-device-code">
                                {{ $repair->device->device_code }}
                            </span>

                        </div>

                        <h1>
                            {{ $repair->device->name }}
                        </h1>

                        <p>
                            Review booking details, monitor service progress,
                            and manage this repair request.
                        </p>

                    </div>

                    <span
                        class="status-badge status-{{ $repair->status }}"
                    >
                        {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                    </span>

                </div>


                {{-- =================================================
                     FLASH MESSAGES
                     ================================================= --}}

                @if (session('success'))

                    <div class="admin-repair-success">
                        {{ session('success') }}
                    </div>

                @endif


                @if ($errors->any())

                    <div class="admin-repair-errors">

                        <strong>
                            Please fix the following:
                        </strong>

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- =================================================
                     MAIN LAYOUT
                     ================================================= --}}

                <div class="admin-repair-layout">


                    {{-- =================================================
                         MAIN CONTENT
                         ================================================= --}}

                    <main class="admin-repair-main">


                        {{-- Customer --}}
                        <article class="admin-repair-card">

                            <div class="section-tag">
                                CUSTOMER
                            </div>

                            <h2>
                                {{ $repair->user->name }}
                            </h2>

                            <div class="admin-info-grid">

                                <div>

                                    <span>
                                        EMAIL
                                    </span>

                                    <strong>
                                        {{ $repair->user->email }}
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        PHONE
                                    </span>

                                    <strong>
                                        {{ $repair->user->phone ?? '—' }}
                                    </strong>

                                </div>

                            </div>

                        </article>


                        {{-- Booking Information --}}
                        <article class="admin-repair-card">

                            <div class="section-tag">
                                BOOKING INFORMATION
                            </div>

                            <div class="admin-booking-grid">

                                <div>

                                    <span>
                                        SERVICE
                                    </span>

                                    <strong>
                                        {{ $repair->service?->name ?? 'General Repair' }}
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        PREFERRED DATE
                                    </span>

                                    <strong>

                                        @if ($repair->preferred_date)

                                            {{ $repair->preferred_date->format('d M Y') }}

                                        @else

                                            —

                                        @endif

                                    </strong>

                                </div>

                                @if ($repair->service)

                                    <div>

                                        <span>
                                            STARTING PRICE
                                        </span>

                                        <strong>
                                            Rp {{ number_format($repair->service->starting_price, 0, ',', '.') }}
                                        </strong>

                                    </div>

                                @endif

                            </div>

                            @if ($repair->preferred_date)

                                <p class="admin-booking-note">
                                    Preferred date submitted by the customer.
                                    Final scheduling is handled by the service team.
                                </p>

                            @endif

                        </article>


                        {{-- Device --}}
                        <article class="admin-repair-card">

                            <div class="section-tag">
                                DEVICE
                            </div>

                            <h2>
                                {{ $repair->device->name }}
                            </h2>

                            <div class="admin-info-grid">

                                <div>

                                    <span>
                                        DEVICE CODE
                                    </span>

                                    <strong>
                                        {{ $repair->device->device_code }}
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        CATEGORY
                                    </span>

                                    <strong>
                                        {{ $repair->device->category }}
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        BRAND
                                    </span>

                                    <strong>
                                        {{ $repair->device->brand }}
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        MODEL
                                    </span>

                                    <strong>
                                        {{ $repair->device->model ?? '—' }}
                                    </strong>

                                </div>

                            </div>

                        </article>


                        {{-- Reported Problem --}}
                        <article class="admin-repair-card">

                            <div class="section-tag">
                                REPORTED PROBLEM
                            </div>

                            <h2>
                                Issue Description
                            </h2>

                            <p class="admin-repair-issue">
                                {{ $repair->issue }}
                            </p>

                        </article>


                        {{-- Repair History --}}
                        <article class="admin-repair-card">

                            <div class="section-tag">
                                SERVICE PROGRESS
                            </div>

                            <div class="admin-repair-history-head">

                                <h2>
                                    Repair History
                                </h2>

                                <span>
                                    {{ $repair->repairHistories->count() }}
                                    {{ $repair->repairHistories->count() === 1 ? 'UPDATE' : 'UPDATES' }}
                                </span>

                            </div>

                            <div class="admin-repair-history">

                                @forelse ($repair->repairHistories as $history)

                                    <div class="admin-history-item">

                                        <div>

                                            <strong>
                                                {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                                            </strong>

                                            @if ($history->note)

                                                <p>
                                                    {{ $history->note }}
                                                </p>

                                            @endif

                                            @if ($history->createdBy)

                                                <small>
                                                    Updated by
                                                    {{ $history->createdBy->name }}
                                                </small>

                                            @endif

                                        </div>

                                        <time>
                                            {{ $history->created_at->format('d M Y H:i') }}
                                        </time>

                                    </div>

                                @empty

                                    <p class="admin-repair-empty">
                                        No repair history found.
                                    </p>

                                @endforelse

                            </div>

                        </article>


                    </main>


                    {{-- =================================================
                         SIDEBAR
                         ================================================= --}}

                    <aside class="admin-repair-sidebar">


                        {{-- Manage Repair --}}
                        <article class="admin-repair-card admin-repair-manage-card">

                            <div class="section-tag">
                                MANAGE REPAIR
                            </div>

                            <h2>
                                Update Status
                            </h2>

                            <form
                                action="{{ route('admin.repairs.update-status', $repair) }}"
                                method="POST"
                                class="admin-repair-form"
                            >

                                @csrf
                                @method('PUT')


                                @php

                                    $allowedTransitions = [
                                        'pending' => [
                                            'confirmed',
                                            'rejected',
                                            'cancelled'
                                        ],

                                        'confirmed' => [
                                            'diagnosing',
                                            'rejected',
                                            'cancelled'
                                        ],

                                        'diagnosing' => [
                                            'repairing',
                                            'rejected',
                                            'cancelled'
                                        ],

                                        'repairing' => [
                                            'waiting_payment',
                                            'rejected',
                                            'cancelled'
                                        ],

                                        'waiting_payment' => [
                                            'paid',
                                            'rejected',
                                            'cancelled'
                                        ],

                                        'paid' => [
                                            'completed'
                                        ],

                                        'completed' => [],

                                        'rejected' => [],

                                        'cancelled' => [],
                                    ];

                                    $nextStatuses =
                                        $allowedTransitions[$repair->status] ?? [];

                                @endphp


                                {{-- Status --}}
                                <div class="field">

                                    <label for="status">
                                        STATUS
                                    </label>

                                    <select
                                        id="status"
                                        name="status"
                                        required
                                    >

                                        <option
                                            value="{{ $repair->status }}"
                                            selected
                                        >
                                            {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                        </option>

                                        @foreach ($nextStatuses as $status)

                                            <option value="{{ $status }}">
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- Estimated Cost --}}
                                <div class="field">

                                    <label for="estimated_cost">
                                        ESTIMATED COST
                                    </label>

                                    <input
                                        type="number"
                                        id="estimated_cost"
                                        name="estimated_cost"
                                        min="0"
                                        step="0.01"
                                        value="{{ old('estimated_cost', $repair->estimated_cost) }}"
                                    >

                                </div>


                                {{-- Final Cost --}}
                                <div class="field">

                                    <label for="final_cost">
                                        FINAL COST
                                    </label>

                                    <input
                                        type="number"
                                        id="final_cost"
                                        name="final_cost"
                                        min="0"
                                        step="0.01"
                                        value="{{ old('final_cost', $repair->final_cost) }}"
                                    >

                                </div>


                                {{-- Note --}}
                                <div class="field">

                                    <label for="note">
                                        NOTE
                                    </label>

                                    <textarea
                                        id="note"
                                        name="note"
                                        rows="5"
                                        placeholder="Add a note about this update..."
                                    >{{ old('note') }}</textarea>

                                </div>


                                <button
                                    type="submit"
                                    class="btn -primary admin-repair-submit"
                                >
                                    Update Repair
                                </button>

                            </form>

                        </article>


                        {{-- Invoice --}}
                        <article class="admin-repair-card">

                            <div class="section-tag">
                                INVOICE
                            </div>

                            @if ($repair->final_cost !== null && ! $repair->invoice)

                                <p class="admin-invoice-help">
                                    Final cost has been set. You can generate
                                    the customer's invoice.
                                </p>

                                <form
                                    action="{{ route('admin.repairs.create-invoice', $repair) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn -secondary admin-repair-submit"
                                    >
                                        Generate Invoice
                                    </button>

                                </form>

                            @elseif ($repair->invoice)

                                <div class="admin-invoice-status">

                                    <span>
                                        INVOICE NUMBER
                                    </span>

                                    <strong>
                                        {{ $repair->invoice->invoice_number }}
                                    </strong>

                                    <small>
                                        STATUS:
                                        {{ ucfirst($repair->invoice->status) }}
                                    </small>

                                </div>

                            @else

                                <p class="admin-invoice-help">
                                    Set the final cost before generating an invoice.
                                </p>

                            @endif

                        </article>


                    </aside>


                </div>


            </div>

        </section>

    </main>

</body>

</html>