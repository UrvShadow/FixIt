<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard — FixIT</title>

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

            <button
                class="nav-toggle"
                id="navOpen"
                type="button"
                aria-label="Open navigation"
            >
                ☰
            </button>

            <nav class="nav-links">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('devices.index') }}">Devices</a>
                <a href="{{ route('repairs.index') }}">Repairs</a>
            </nav>

            <div class="nav-actions">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn -secondary -sm">
                        Log out
                    </button>
                </form>
            </div>

        </div>
    </header>


    {{-- Mobile Navigation --}}
    <div class="nav-mobile" id="mobileNav">

        <button
            class="nav-toggle"
            id="navClose"
            type="button"
            aria-label="Close navigation"
        >
            ✕
        </button>

        <a href="{{ route('dashboard') }}">
            Dashboard
        </a>

        <a href="{{ route('devices.index') }}">
            Devices
        </a>

        <a href="{{ route('repairs.index') }}">
            Repairs
        </a>

        <div class="nav-mobile-actions">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn -secondary -sm">
                    Log out
                </button>
            </form>
        </div>

    </div>


    {{-- Dashboard --}}
    <section>
        <div class="container">

            {{-- Welcome --}}
            <div class="section-head">
                <div class="section-tag">
                    User dashboard
                </div>

                <h2>
                    Welcome back, {{ auth()->user()->name }}
                </h2>
            </div>


            {{-- Statistics --}}
            <div class="grid-3">

                <div class="svc-card">
                    <div class="section-tag">
                        Devices
                    </div>

                    <h3>
                        My Devices
                    </h3>

                    <p class="dashboard-stat">
                        {{ $totalDevices }}
                    </p>

                    <a
                        href="{{ route('devices.index') }}"
                        class="btn -ghost -sm"
                    >
                        View Devices
                    </a>
                </div>


                <div class="svc-card">
                    <div class="section-tag">
                        Repairs
                    </div>

                    <h3>
                        Active Repairs
                    </h3>

                    <p class="dashboard-stat">
                        {{ $activeRepairs }}
                    </p>

                    <a
                        href="{{ route('repairs.index') }}"
                        class="btn -ghost -sm"
                    >
                        Track Repairs
                    </a>
                </div>


                <div class="svc-card">
                    <div class="section-tag">
                        Completed
                    </div>

                    <h3>
                        Completed Repairs
                    </h3>

                    <p class="dashboard-stat">
                        {{ $completedRepairs }}
                    </p>

                    <a
                        href="{{ route('repairs.index') }}"
                        class="btn -ghost -sm"
                    >
                        View History
                    </a>
                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="dashboard-actions">

                <a
                    href="{{ route('repairs.create') }}"
                    class="btn -primary"
                >
                    Submit a Repair
                </a>

                <a
                    href="{{ route('repairs.index') }}"
                    class="btn -secondary"
                >
                    View Repair History
                </a>

            </div>


            {{-- Recent Repairs --}}
            <div class="dashboard-recent">

                <div class="section-head">
                    <div class="section-tag">
                        Activity
                    </div>

                    <h2>
                        Recent Repairs
                    </h2>
                </div>


                @forelse ($recentRepairs as $repair)

                    <div class="repair-row">

                        <div>
                            <span class="ticket-code">
                                #{{ $repair->id }}
                            </span>

                            <h3>
                                {{ $repair->device->name }}
                            </h3>

                            <p>
                                {{ $repair->issue }}
                            </p>
                        </div>


                        <div>

                            <span class="status-badge status-{{ $repair->status }}">
                                {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                            </span>

                            <a
                                href="{{ route('repairs.show', $repair) }}"
                                class="btn -ghost -sm"
                            >
                                View
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <h3>
                            No repair requests yet.
                        </h3>

                        <p>
                            When you submit a repair request,
                            your latest activity will appear here.
                        </p>

                        <a
                            href="{{ route('repairs.create') }}"
                            class="btn -primary"
                        >
                            Submit Your First Repair
                        </a>

                    </div>

                @endforelse

            </div>

        </div>
    </section>

    <script>
        const navOpen = document.getElementById('navOpen');
        const navClose = document.getElementById('navClose');
        const mobileNav = document.getElementById('mobileNav');

        navOpen.addEventListener('click', () => {
            mobileNav.classList.add('-open');
        });

        navClose.addEventListener('click', () => {
            mobileNav.classList.remove('-open');
        });
    </script>
</body>
</html>