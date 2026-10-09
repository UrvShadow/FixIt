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
                <span class="mark">FX</span>
                FixIT
            </a>

            <nav class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('services.index') }}">Services</a>
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

            <button
                type="button"
                class="nav-toggle"
                aria-label="Open menu"
                aria-expanded="false"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>

        {{-- Mobile Navigation --}}
        <nav class="nav-mobile">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('services.index') }}">Services</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('devices.index') }}">Devices</a>
            <a href="{{ route('repairs.index') }}">Repairs</a>

            <div class="nav-mobile-actions">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn -secondary -sm -block">
                        Log out
                    </button>
                </form>
            </div>
        </nav>
    </header>

    {{-- Repair Management --}}
    <section class="repairs-page">
        <div class="container">

            {{-- Page Header --}}
            <div class="repairs-page-head">
                <div class="repairs-page-copy">
                    <div class="section-tag">
                        Service Management
                    </div>

                    <h1>My Repairs</h1>

                    <p>
                        Track your device repair requests and service progress.
                    </p>
                </div>

                <a href="{{ route('repairs.create') }}" class="btn -primary">
                    + Request Repair
                </a>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="success-message" role="status">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <form
                action="{{ route('repairs.index') }}"
                method="GET"
                class="repair-filters"
            >
                <div class="field">
                    <label for="device">Filter by Device</label>

                    <select id="device" name="device">
                        <option value="">All Devices</option>

                        @foreach ($devices as $device)
                            <option
                                value="{{ $device->id }}"
                                @selected((string) $deviceId === (string) $device->id)
                            >
                                {{ $device->name }} ({{ $device->device_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="status">Filter by Status</label>

                    <select id="status" name="status">
                        <option value="">All Statuses</option>

                        @foreach ([
                            'pending',
                            'confirmed',
                            'diagnosing',
                            'repairing',
                            'waiting_payment',
                            'paid',
                            'completed',
                            'rejected',
                            'cancelled',
                        ] as $option)
                            <option
                                value="{{ $option }}"
                                @selected($status === $option)
                            >
                                {{ ucfirst(str_replace('_', ' ', $option)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="sort">Sort by</label>

                    <select id="sort" name="sort">
                        <option value="newest" @selected($sort === 'newest')>
                            Newest First
                        </option>

                        <option value="oldest" @selected($sort === 'oldest')>
                            Oldest First
                        </option>
                    </select>
                </div>

                <div class="repair-filter-actions">
                    <button type="submit" class="btn -primary">
                        Apply Filters
                    </button>

                    <a href="{{ route('repairs.index') }}" class="btn -ghost">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Results Summary --}}
            <div class="repair-results-summary">
                <span>
                    {{ $repairRequests->count() }}
                    {{ $repairRequests->count() === 1 ? 'repair request' : 'repair requests' }}
                    found
                </span>
            </div>

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

                                <h2>{{ $repair->device->name }}</h2>

                                <span class="repair-device-code">
                                    {{ $repair->device->device_code }}
                                </span>
                            </div>

                            <span class="status-badge status-{{ $repair->status }}">
                                {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                            </span>
                        </div>

                        {{-- Issue --}}
                        <div class="repair-issue">
                            <span>Reported Issue</span>
                            <p>{{ $repair->issue }}</p>
                        </div>

                        {{-- Metadata --}}
                        <div class="repair-meta">
                            <div>
                                <span>Submitted</span>

                                <strong>
                                    {{ $repair->created_at->format('d M Y H:i') }}
                                </strong>
                            </div>

                            @if ($repair->estimated_cost !== null)
                                <div>
                                    <span>Estimated Cost</span>

                                    <strong>
                                        Rp {{ number_format($repair->estimated_cost, 0, ',', '.') }}
                                    </strong>
                                </div>
                            @endif

                            @if ($repair->final_cost !== null)
                                <div>
                                    <span>Final Cost</span>

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

                    {{-- Empty State --}}
                    <div class="empty-state">
                        <div class="section-tag">
                            Service Management
                        </div>

                        @if ($deviceId !== '' || $status !== '')
                            <h2>No matching repair requests.</h2>

                            <p>
                                Try changing your filters or reset them
                                to view all your repair requests.
                            </p>

                            <a
                                href="{{ route('repairs.index') }}"
                                class="btn -secondary"
                            >
                                Clear Filters
                            </a>
                        @else
                            <h2>No repair requests yet.</h2>

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
                        @endif
                    </div>

                @endforelse

            </div>

        </div>
    </section>

    {{-- Mobile Navbar Toggle --}}
    <script>
        const navToggle = document.querySelector('.nav-toggle');
        const navMobile = document.querySelector('.nav-mobile');

        navToggle?.addEventListener('click', () => {
            const isOpen = navMobile.classList.toggle('-open');

            navToggle.setAttribute('aria-expanded', String(isOpen));
            navToggle.setAttribute(
                'aria-label',
                isOpen ? 'Close menu' : 'Open menu'
            );
        });

        navMobile?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                navMobile.classList.remove('-open');
                navToggle?.setAttribute('aria-expanded', 'false');
                navToggle?.setAttribute('aria-label', 'Open menu');
            });
        });
    </script>

</body>
</html>