<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Repair #{{ $repair->id }} — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- Navbar --}}
    <header class="nav">

        <div class="container">

            <a href="{{ route('home') }}" class="brand">
                <span class="mark">FX</span>FixIT
            </a>

            <nav class="nav-links">

                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('devices.index') }}">
                    Devices
                </a>

                <a href="{{ route('repairs.index') }}">
                    Repairs
                </a>

            </nav>

            <div class="nav-actions">

                <form action="{{ route('logout') }}" method="POST">
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


    {{-- Repair Detail --}}
    <section>

        <div class="container">

            {{-- Back --}}
            <div class="repair-detail-back">

                <a
                    href="{{ route('repairs.index') }}"
                    class="btn -ghost -sm"
                >
                    ← My Repairs
                </a>

            </div>


            {{-- Header --}}
            <div class="repair-detail-head">

                <div>

                    <span class="ticket-code">
                        REPAIR #{{ $repair->id }}
                    </span>

                    <h1>
                        {{ $repair->device->name }}
                    </h1>

                    <span class="repair-device-code">
                        {{ $repair->device->device_code }}
                    </span>

                </div>

                <span class="status-badge status-{{ $repair->status }}">
                    {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                </span>

            </div>


            {{-- Main Layout --}}
            <div class="repair-detail-layout">


                {{-- Main Content --}}
                <main class="repair-detail-main">


                    {{-- Reported Problem --}}
                    <article class="repair-detail-card">

                        <div class="section-tag">
                            Reported Problem
                        </div>

                        <h2>
                            Issue Description
                        </h2>

                        <p class="repair-detail-issue">
                            {{ $repair->issue }}
                        </p>

                    </article>


                    {{-- Timeline --}}
                    <article class="repair-detail-card">

                        <div class="section-tag">
                            Service Progress
                        </div>

                        <h2>
                            Repair Timeline
                        </h2>


                        <div class="repair-detail-timeline">

                            @forelse ($repair->repairHistories as $history)

                                @php
                                    $isLatest = $loop->first;
                                    $isFailed = in_array($history->status, [
                                        'rejected',
                                        'cancelled',
                                    ]);

                                    $timelineClass = $isFailed
                                        ? '-failed'
                                        : ($isLatest ? '-active' : '-completed');
                                @endphp

                                <div class="timeline-item {{ $timelineClass }}">

                                    <div class="timeline-marker">

                                        @if ($isFailed)
                                            ×
                                        @elseif ($isLatest)
                                            ●
                                        @else
                                            ✓
                                        @endif

                                    </div>


                                    <div class="timeline-content">

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
                                                    Updated by {{ $history->createdBy->name }}
                                                </small>

                                            @endif

                                        </div>

                                        <span>
                                            {{ $history->created_at->format('d M Y H:i') }}
                                        </span>

                                    </div>

                                </div>

                            @empty

                                <div class="repair-detail-empty">
                                    No repair history available yet.
                                </div>

                            @endforelse

                        </div>

                    </article>

                </main>


                {{-- Sidebar --}}
                <aside class="repair-detail-sidebar">


                    {{-- Cost Summary --}}
                    <article class="repair-detail-card repair-cost-card">

                        <div class="section-tag">
                            Cost Summary
                        </div>

                        <div class="repair-cost-list">

                            <div class="repair-cost-row">

                                <span>
                                    Estimated Cost
                                </span>

                                <strong>
                                    @if ($repair->estimated_cost)
                                        Rp {{ number_format($repair->estimated_cost, 0, ',', '.') }}
                                    @else
                                        —
                                    @endif
                                </strong>

                            </div>


                            <div class="repair-cost-row">

                                <span>
                                    Final Cost
                                </span>

                                <strong class="repair-final-cost">

                                    @if ($repair->final_cost)
                                        Rp {{ number_format($repair->final_cost, 0, ',', '.') }}
                                    @else
                                        —
                                    @endif

                                </strong>

                            </div>

                        </div>


                        {{-- Payment State --}}

                        @if ($repair->invoice && $repair->invoice->status === 'paid')

                            <a
                                href="{{ route('invoices.download', $repair->invoice) }}"
                                class="btn -secondary invoice-download-button"
                                target="_blank"
                            >
                                Download Invoice PDF
                            </a>
                        @endif

                        @if ($repair->invoice)

                            <div class="repair-payment-state">

                                <span>
                                    Invoice
                                </span>

                                <strong>
                                    {{ $repair->invoice->invoice_number }}
                                </strong>

                                @if ($repair->invoice->status === 'paid')

                                    <div class="payment-complete">
                                        ✓ Payment Completed
                                    </div>

                                @elseif (
                                    $repair->status === 'waiting_payment' &&
                                    $repair->final_cost !== null
                                )

                                    <a
                                        href="{{ route('payments.create', $repair) }}"
                                        class="btn -primary repair-pay-button"
                                    >
                                        Pay Invoice
                                    </a>

                                    <p class="payment-help">
                                        Choose QRIS or bank transfer to complete your payment.
                                    </p>

                                @else

                                    <div class="payment-pending">
                                        Payment is not available yet.
                                    </div>

                                @endif

                            </div>

                        @endif

                    </article>


                    {{-- Device Information --}}
                    <article class="repair-detail-card">

                        <div class="section-tag">
                            Device Information
                        </div>

                        <h2>
                            {{ $repair->device->name }}
                        </h2>

                        <div class="repair-device-info">

                            <div>
                                <span>
                                    Device Code
                                </span>

                                <strong>
                                    {{ $repair->device->device_code }}
                                </strong>
                            </div>


                            <div>
                                <span>
                                    Category
                                </span>

                                <strong>
                                    {{ $repair->device->category }}
                                </strong>
                            </div>


                            <div>
                                <span>
                                    Brand
                                </span>

                                <strong>
                                    {{ $repair->device->brand }}
                                </strong>
                            </div>


                            @if ($repair->device->model)

                                <div>
                                    <span>
                                        Model
                                    </span>

                                    <strong>
                                        {{ $repair->device->model }}
                                    </strong>
                                </div>

                            @endif


                            @if ($repair->device->serial_number)

                                <div>
                                    <span>
                                        Serial Number
                                    </span>

                                    <strong>
                                        {{ $repair->device->serial_number }}
                                    </strong>
                                </div>

                            @endif

                        </div>

                    </article>


                </aside>

            </div>

        </div>

    </section>

</body>

</html>
