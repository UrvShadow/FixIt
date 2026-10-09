<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard — FixIT</title>

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

    {{-- =========================================================
         NAVBAR
    ========================================================== --}}

    <header class="nav">
        <div class="container">

            <a
                href="{{ route('home') }}"
                class="brand"
            >
                <span class="mark">FX</span>FixIT
            </a>

            <button
                class="nav-toggle"
                id="navOpen"
                type="button"
                aria-label="Open navigation"
                aria-expanded="false"
                aria-controls="mobileNav"
            >
                ☰
            </button>

            <nav class="nav-links">

                <a
                    href="{{ route('home') }}"
                    class="active"
                >
                    Home
                </a>

                <a
                    href="{{ route('services.index') }}"
                    class="active"
                >
                    Services
                </a>

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


    {{-- =========================================================
         MOBILE NAVIGATION
    ========================================================== --}}

    <div
        class="nav-mobile"
        id="mobileNav"
    >

        <button
            class="nav-toggle"
            id="navClose"
            type="button"
            aria-label="Close navigation"
        >
            ✕
        </button>

        <a
            href="{{ route('dashboard') }}"
            class="active"
        >
            Dashboard
        </a>

        <a href="{{ route('services.index') }}">
            Services
        </a>

        <a href="{{ route('devices.index') }}">
            Devices
        </a>

        <a href="{{ route('repairs.index') }}">
            Repairs
        </a>

        <div class="nav-mobile-actions">

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


    {{-- =========================================================
         DASHBOARD
    ========================================================== --}}

    <main>

        {{-- Welcome --}}

        <section class="dashboard-hero">

            <div class="container">

                <div class="section-head">

                    <div class="section-tag">
                        User dashboard
                    </div>

                    <h1>
                        Welcome back,
                        {{ auth()->user()->name }}.
                    </h1>

                    <p>
                        Manage your devices, track repairs,
                        and keep everything in one place.
                    </p>

                </div>

            </div>

        </section>


        {{-- Statistics --}}

        <section class="dashboard-stats">

            <div class="container">

                <div class="grid-3">

                    <div class="dashboard-stat-card">

                        <div class="section-tag">
                            Devices
                        </div>

                        <h2 class="dashboard-stat">
                            {{ $totalDevices }}
                        </h2>

                        <p>
                            Registered devices
                        </p>

                        <a
                            href="{{ route('devices.index') }}"
                            class="btn -ghost -sm"
                        >
                            View Devices
                        </a>

                    </div>


                    <div class="dashboard-stat-card">

                        <div class="section-tag">
                            Active repairs
                        </div>

                        <h2 class="dashboard-stat">
                            {{ $activeRepairs }}
                        </h2>

                        <p>
                            Repairs currently in progress
                        </p>

                        <a
                            href="{{ route('repairs.index') }}"
                            class="btn -ghost -sm"
                        >
                            Track Repairs
                        </a>

                    </div>


                    <div class="dashboard-stat-card">

                        <div class="section-tag">
                            Completed
                        </div>

                        <h2 class="dashboard-stat">
                            {{ $completedRepairs }}
                        </h2>

                        <p>
                            Completed repair requests
                        </p>

                        <a
                            href="{{ route('repairs.index') }}"
                            class="btn -ghost -sm"
                        >
                            View History
                        </a>

                    </div>

                </div>

            </div>

        </section>


        {{-- Quick Actions --}}

        <section class="dashboard-quick-actions">

            <div class="section-head">

                <div class="section-tag">
                    Quick actions
                </div>

                <h2>
                    What would you like to do?
                </h2>

            </div>

            <div class="dashboard-actions">

                <a
                    href="{{ route('repairs.create') }}"
                    class="btn -primary"
                >
                    Submit a Repair
                </a>

                <a
                    href="{{ route('services.index') }}"
                    class="btn -secondary"
                >
                    Browse Services
                </a>

            </div>

        </section>


        {{-- Recent Repairs --}}

        <section class="dashboard-recent">

            <div class="section-head">

                <div class="section-tag">
                    Activity
                </div>

                <h2>
                    Recent Repairs
                </h2>

                <p>
                    Keep track of your latest repair requests
                    and their current status.
                </p>

            </div>


            @forelse ($recentRepairs as $repair)

                <div class="repair-row">

                    <div class="repair-row-info">

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


                    <div class="repair-row-actions">

                        <span
                            class="status-badge status-{{ $repair->status }}"
                        >
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

                    <div class="section-tag">
                        No activity yet
                    </div>

                    <h3>
                        No repair requests yet.
                    </h3>

                    <p>
                        When you submit a repair request,
                        your latest activity will appear here.
                    </p>

                    <div class="empty-state-actions">

                        <a
                            href="{{ route('repairs.create') }}"
                            class="btn -primary"
                        >
                            Submit Your First Repair
                        </a>

                        <a
                            href="{{ route('services.index') }}"
                            class="btn -secondary"
                        >
                            Browse Services
                        </a>

                    </div>

                </div>

            @endforelse

        </section>

    </main>


    {{-- =========================================================
         NAVIGATION SCRIPT
    ========================================================== --}}

    <script>
        const navOpen = document.getElementById('navOpen');
        const navClose = document.getElementById('navClose');
        const mobileNav = document.getElementById('mobileNav');

        if (navOpen && navClose && mobileNav) {

            navOpen.addEventListener('click', () => {
                mobileNav.classList.add('-open');
                navOpen.setAttribute('aria-expanded', 'true');
            });

            navClose.addEventListener('click', () => {
                mobileNav.classList.remove('-open');
                navOpen.setAttribute('aria-expanded', 'false');
            });

        }
    </script>

</body>

</html>