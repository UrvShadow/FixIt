
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Repair Requests — Admin — FixIT</title>

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

    {{-- ========================================
         Admin Navigation
         ======================================== --}}

    <header class="nav">

        <div class="container">

            <a
                href="{{ route('admin.dashboard') }}"
                class="brand"
            >
                <span class="mark">FX</span>
                FixIT Admin
            </a>

            <nav class="nav-links" aria-label="Admin navigation">

                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.services.index') }}">
                    Services
                </a>

                <a
                    href="{{ route('admin.repairs.index') }}"
                    class="active"
                    aria-current="page"
                >
                    Repairs
                </a>

                <a href="{{ route('admin.promos.index') }}">
                    Promos
                </a>

                <a href="{{ route('admin.financial-reports') }}">
                    Financial Reports
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


    {{-- ========================================
         Repair Management
         ======================================== --}}

    <main>

        <section class="admin-repair-list">

            <div class="container">


                {{-- Page Header --}}
                <div class="admin-repair-list-head">

                    <div>

                        <span class="section-tag">
                            ADMINISTRATION
                        </span>

                        <h1>
                            Repair Requests
                        </h1>

                        <p>
                            Search customer requests, prioritize repair work,
                            and manage service progress.
                        </p>

                    </div>

                    <div class="admin-repair-count">

                        <span>
                            TOTAL MATCHING REQUESTS
                        </span>

                        <strong>
                            {{ number_format($repairRequests->total()) }}
                        </strong>

                    </div>

                </div>


                {{-- Success Message --}}
                @if (session('success'))

                    <div
                        class="admin-repair-filter-success"
                        role="status"
                    >
                        {{ session('success') }}
                    </div>

                @endif


                {{-- Validation Errors --}}
                @if ($errors->has('search') || $errors->has('status') || $errors->has('sort'))

                    <div
                        class="admin-repair-filter-errors"
                        role="alert"
                    >
                        @foreach (['search', 'status', 'sort'] as $field)
                            @foreach ($errors->get($field) as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @endforeach
                    </div>

                @endif


                {{-- ========================================
                     Search, Filter & Sort
                     ======================================== --}}

                <section
                    class="admin-repair-filter-panel"
                    aria-label="Search, filter, and sort repair requests"
                >

                    <div class="admin-repair-filter-heading">

                        <div>

                            <span class="section-tag">
                                REQUEST MANAGEMENT
                            </span>

                            <h2>
                                Find a Repair
                            </h2>

                            <p>
                                Search by repair ID, customer, device,
                                service, or reported issue.
                            </p>

                        </div>

                        <span class="admin-repair-filter-count">
                            {{ number_format($repairRequests->total()) }}
                            {{ $repairRequests->total() === 1 ? 'RESULT' : 'RESULTS' }}
                        </span>

                    </div>


                    <form
                        action="{{ route('admin.repairs.index') }}"
                        method="GET"
                        class="admin-repair-filter-form"
                    >

                        {{-- Search --}}
                        <div class="admin-repair-filter-field admin-repair-search-field">

                            <label for="repair-search">
                                Search Requests
                            </label>

                            <input
                                type="search"
                                id="repair-search"
                                name="search"
                                value="{{ $search }}"
                                maxlength="100"
                                placeholder="Repair ID, customer, device..."
                                autocomplete="off"
                            >

                        </div>


                        {{-- Status --}}
                        <div class="admin-repair-filter-field">

                            <label for="repair-status">
                                Repair Status
                            </label>

                            <select
                                id="repair-status"
                                name="status"
                            >

                                <option
                                    value=""
                                    {{ $status === '' ? 'selected' : '' }}
                                >
                                    All statuses
                                </option>

                                <option
                                    value="pending"
                                    {{ $status === 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="confirmed"
                                    {{ $status === 'confirmed' ? 'selected' : '' }}
                                >
                                    Confirmed
                                </option>

                                <option
                                    value="diagnosing"
                                    {{ $status === 'diagnosing' ? 'selected' : '' }}
                                >
                                    Diagnosing
                                </option>

                                <option
                                    value="repairing"
                                    {{ $status === 'repairing' ? 'selected' : '' }}
                                >
                                    Repairing
                                </option>

                                <option
                                    value="waiting_payment"
                                    {{ $status === 'waiting_payment' ? 'selected' : '' }}
                                >
                                    Waiting Payment
                                </option>

                                <option
                                    value="paid"
                                    {{ $status === 'paid' ? 'selected' : '' }}
                                >
                                    Paid
                                </option>

                                <option
                                    value="completed"
                                    {{ $status === 'completed' ? 'selected' : '' }}
                                >
                                    Completed
                                </option>

                                <option
                                    value="rejected"
                                    {{ $status === 'rejected' ? 'selected' : '' }}
                                >
                                    Rejected
                                </option>

                                <option
                                    value="cancelled"
                                    {{ $status === 'cancelled' ? 'selected' : '' }}
                                >
                                    Cancelled
                                </option>

                            </select>

                        </div>


                        {{-- Sort --}}
                        <div class="admin-repair-filter-field">

                            <label for="repair-sort">
                                Sort By
                            </label>

                            <select
                                id="repair-sort"
                                name="sort"
                            >

                                <option
                                    value="newest"
                                    {{ $sort === 'newest' ? 'selected' : '' }}
                                >
                                    Newest First
                                </option>

                                <option
                                    value="oldest"
                                    {{ $sort === 'oldest' ? 'selected' : '' }}
                                >
                                    Oldest First
                                </option>

                                <option
                                    value="preferred_soon"
                                    {{ $sort === 'preferred_soon' ? 'selected' : '' }}
                                >
                                    Preferred Date — Soonest
                                </option>

                                <option
                                    value="preferred_late"
                                    {{ $sort === 'preferred_late' ? 'selected' : '' }}
                                >
                                    Preferred Date — Latest
                                </option>

                                <option
                                    value="status"
                                    {{ $sort === 'status' ? 'selected' : '' }}
                                >
                                    Repair Status
                                </option>

                                <option
                                    value="cost_high"
                                    {{ $sort === 'cost_high' ? 'selected' : '' }}
                                >
                                    Highest Final Cost
                                </option>

                                <option
                                    value="cost_low"
                                    {{ $sort === 'cost_low' ? 'selected' : '' }}
                                >
                                    Lowest Final Cost
                                </option>

                            </select>

                        </div>


                        {{-- Actions --}}
                        <div class="admin-repair-filter-actions">

                            <button
                                type="submit"
                                class="btn -primary"
                            >
                                Apply
                            </button>

                            @if ($search !== '' || $status !== '' || $sort !== 'newest')

                                <a
                                    href="{{ route('admin.repairs.index') }}"
                                    class="btn -ghost"
                                >
                                    Reset
                                </a>

                            @endif

                        </div>

                    </form>


                    @if ($search !== '' || $status !== '' || $sort !== 'newest')

                        <div class="admin-repair-filter-summary">

                            <span>
                                Active filters:
                            </span>

                            @if ($search !== '')
                                <span class="admin-repair-filter-chip">
                                    Search: {{ $search }}
                                </span>
                            @endif

                            @if ($status !== '')
                                <span class="admin-repair-filter-chip">
                                    Status: {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            @endif

                            @if ($sort !== 'newest')
                                <span class="admin-repair-filter-chip">
                                    Sort: {{ ucfirst(str_replace('_', ' ', $sort)) }}
                                </span>
                            @endif

                        </div>

                    @endif

                </section>


                {{-- ========================================
                     Repair List
                     ======================================== --}}

                @if ($repairRequests->isNotEmpty())

                    <div class="admin-repair-list-grid">

                        @foreach ($repairRequests as $repair)

                            <article class="admin-repair-list-card">


                                {{-- Card Header --}}
                                <div class="admin-repair-list-card-head">

                                    <div>

                                        <div class="admin-repair-card-meta">

                                            <span class="ticket-code">
                                                REPAIR #{{ $repair->id }}
                                            </span>

                                            @if ($repair->device)
                                                <span class="admin-repair-card-device-code">
                                                    {{ $repair->device->device_code }}
                                                </span>
                                            @endif

                                        </div>

                                        <h2>
                                            {{ $repair->device?->name ?? 'Device unavailable' }}
                                        </h2>

                                    </div>

                                    <span
                                        class="status-badge status-{{ $repair->status }}"
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                    </span>

                                </div>


                                {{-- Customer + Service --}}
                                <div class="admin-repair-list-info">

                                    <div>

                                        <span>
                                            CUSTOMER
                                        </span>

                                        <strong>
                                            {{ $repair->user?->name ?? 'Customer unavailable' }}
                                        </strong>

                                    </div>

                                    <div>

                                        <span>
                                            SERVICE
                                        </span>

                                        <strong>
                                            {{ $repair->service?->name ?? 'General Repair' }}
                                        </strong>

                                    </div>

                                </div>


                                {{-- Preferred Date --}}
                                <div class="admin-repair-list-date">

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


                                {{-- Issue --}}
                                <div class="admin-repair-list-issue">

                                    <span>
                                        REPORTED ISSUE
                                    </span>

                                    <p>
                                        {{ \Illuminate\Support\Str::limit($repair->issue, 120) }}
                                    </p>

                                </div>


                                {{-- Footer --}}
                                <div class="admin-repair-list-footer">

                                    <div>

                                        <span>
                                            SUBMITTED
                                        </span>

                                        <strong>
                                            {{ $repair->created_at->format('d M Y, H:i') }}
                                        </strong>

                                    </div>

                                    <a
                                        href="{{ route('admin.repairs.show', $repair) }}"
                                        class="admin-repair-view"
                                    >
                                        Manage
                                        <span>→</span>
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>


                    {{-- Pagination --}}
                    @if ($repairRequests->hasPages())

                        <nav
                            class="admin-repair-pagination"
                            aria-label="Repair request pagination"
                        >
                            {{ $repairRequests->links() }}
                        </nav>

                    @endif

                @else

                    {{-- Empty State --}}
                    <div class="admin-repair-list-empty">

                        <span class="section-tag">
                            REPAIR REQUESTS
                        </span>

                        @if ($search !== '' || $status !== '')

                            <h2>
                                No matching repair requests
                            </h2>

                            <p>
                                Try another search term, change the status,
                                or reset your filters.
                            </p>

                            <a
                                href="{{ route('admin.repairs.index') }}"
                                class="btn -secondary"
                            >
                                Reset Filters
                            </a>

                        @else

                            <h2>
                                No repair requests yet
                            </h2>

                            <p>
                                Customer repair requests will appear here
                                once they submit a service request.
                            </p>

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="btn -secondary"
                            >
                                ← Admin Dashboard
                            </a>

                        @endif

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>
</html>