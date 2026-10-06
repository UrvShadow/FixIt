<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Repairs — FixIT</title>

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


    {{-- Repair Management --}}
    <section>

        <div class="container">

            <div class="section-head">

                <div>

                    <div class="section-tag">
                        Service Management
                    </div>

                    <h1>
                        My Repairs
                    </h1>

                    <p>
                        Track your device repair requests and service progress.
                    </p>

                </div>

                <a
                    href="{{ route('repairs.create') }}"
                    class="btn -primary"
                >
                    + Request Repair
                </a>

            </div>


            {{-- Success Message --}}
            @if (session('success'))

                <div class="success-message">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Repair List --}}
            <div class="repair-list">

                @forelse ($repairRequests as $repair)

                    <article class="repair-card">

                        {{-- Header --}}
                        <div class="repair-card-header">

                            <div>

                                <span class="ticket-code">
                                    REPAIR #{{ $repair->id }}
                                </span>

                                <h2>
                                    {{ $repair->device->name }}
                                </h2>

                                <span class="repair-device-code">
                                    {{ $repair->device->device_code }}
                                </span>

                            </div>

                            <span
                                class="status-badge status-{{ $repair->status }}"
                            >
                                {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                            </span>

                        </div>


                        {{-- Issue --}}
                        <div class="repair-issue">

                            <span>
                                Reported Issue
                            </span>

                            <p>
                                {{ $repair->issue }}
                            </p>

                        </div>


                        {{-- Metadata --}}
                        <div class="repair-meta">

                            <div>

                                <span>
                                    Submitted
                                </span>

                                <strong>
                                    {{ $repair->created_at->format('d M Y H:i') }}
                                </strong>

                            </div>

                            @if ($repair->estimated_cost)

                                <div>

                                    <span>
                                        Estimated Cost
                                    </span>

                                    <strong>
                                        Rp {{ number_format($repair->estimated_cost, 0, ',', '.') }}
                                    </strong>

                                </div>

                            @endif

                            @if ($repair->final_cost)

                                <div>

                                    <span>
                                        Final Cost
                                    </span>

                                    <strong>
                                        Rp {{ number_format($repair->final_cost, 0, ',', '.') }}
                                    </strong>

                                </div>

                            @endif

                        </div>


                        {{-- Actions --}}
                        <div class="repair-card-actions">

                            <a
                                href="{{ route('repairs.show', $repair) }}"
                                class="btn -secondary -sm"
                            >
                                View Details →
                            </a>

                        </div>

                    </article>

                @empty

                    <div class="empty-state">

                        <div class="section-tag">
                            Service Management
                        </div>

                        <h2>
                            No repair requests yet.
                        </h2>

                        <p>
                            Submit your first repair request to start
                            tracking your device service.
                        </p>

                        <a
                            href="{{ route('repairs.create') }}"
                            class="btn -primary"
                        >
                            Request Your First Repair
                        </a>

                    </div>

                @endforelse

            </div>

        </div>

    </section>

</body>
</html>