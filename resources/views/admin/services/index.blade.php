<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Service Management — Admin — FixIT</title>

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

    {{-- Admin Navigation --}}
    <header class="nav">
        <div class="container">

            <a href="{{ route('admin.dashboard') }}" class="brand">
                <span class="mark">FX</span>
                FixIT Admin
            </a>

            <nav class="nav-links">

                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <a
                    href="{{ route('admin.services.index') }}"
                    class="active"
                    aria-current="page"
                >
                    Services
                </a>

                <a href="{{ route('admin.repairs.index') }}">
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


    <main>

        <section class="admin-service-list">

            <div class="container">

                {{-- Page Header --}}
                <div class="admin-service-head">

                    <div>

                        <span class="section-tag">
                            ADMINISTRATION
                        </span>

                        <h1>
                            Service Management
                        </h1>

                        <p>
                            Manage the repair and maintenance services
                            offered through the FixIT platform.
                        </p>

                    </div>

                    <a
                        href="{{ route('admin.services.create') }}"
                        class="btn -primary"
                    >
                        + Add Service
                    </a>

                </div>


                {{-- Success Message --}}
                @if (session('success'))
                    <div class="admin-service-success" role="status">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- Search & Filter --}}
                <section
                    class="admin-service-filter-panel"
                    aria-label="Search and filter services"
                >

                    <div class="admin-service-filter-heading">

                        <div>
                            <span class="section-tag">
                                CATALOG SEARCH
                            </span>

                            <h2>
                                Find a Service
                            </h2>
                        </div>

                        <span class="admin-service-result-count">
                            {{ number_format($services->total()) }}
                            {{ $services->total() === 1 ? 'SERVICE' : 'SERVICES' }}
                        </span>

                    </div>

                    <form
                        action="{{ route('admin.services.index') }}"
                        method="GET"
                        class="admin-service-filter-form"
                    >

                        {{-- Search Input --}}
                        <div class="admin-service-search-field">

                            <label for="service-search">
                                Search
                            </label>

                            <input
                                type="search"
                                id="service-search"
                                name="search"
                                value="{{ $search }}"
                                maxlength="100"
                                placeholder="Name, description, category, or slug..."
                                autocomplete="off"
                            >

                            @error('search')
                                <span class="admin-service-filter-error" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        {{-- Status Filter --}}
                        <div class="admin-service-status-field">

                            <label for="service-status">
                                Availability
                            </label>

                            <select
                                id="service-status"
                                name="status"
                            >
                                <option value="" {{ $status === '' ? 'selected' : '' }}>
                                    All statuses
                                </option>

                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            @error('status')
                                <span class="admin-service-filter-error" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        {{-- Actions --}}
                        <div class="admin-service-filter-actions">

                            <button
                                type="submit"
                                class="btn -primary"
                            >
                                Search
                            </button>

                            @if ($search !== '' || $status !== '')
                                <a
                                    href="{{ route('admin.services.index') }}"
                                    class="btn -ghost"
                                >
                                    Clear
                                </a>
                            @endif

                        </div>

                    </form>

                    @if ($search !== '' || $status !== '')
                        <p class="admin-service-filter-summary">
                            Showing results
                            @if ($search !== '')
                                for <strong>{{ $search }}</strong>
                            @endif

                            @if ($status !== '')
                                with status
                                <strong>{{ strtoupper($status) }}</strong>
                            @endif
                        </p>
                    @endif

                </section>


                {{-- Service Grid --}}
                @if ($services->isNotEmpty())

                    <div class="admin-service-grid">

                        @foreach ($services as $service)

                            <article class="admin-service-card">

                                {{-- Card Header --}}
                                <div class="admin-service-card-head">

                                    <div>

                                        <span class="admin-service-category">
                                            {{ strtoupper($service->category) }}
                                        </span>

                                        <span class="admin-service-number">
                                            {{ str_pad(($services->firstItem() ?? 1) + $loop->index, 2, '0', STR_PAD_LEFT) }}
                                        </span>

                                    </div>

                                    {{-- Status Toggle --}}
                                    <form
                                        action="{{ route('admin.services.toggle', $service) }}"
                                        method="POST"
                                        class="admin-service-status-form"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="hidden"
                                            name="search"
                                            value="{{ $search }}"
                                        >

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="{{ $status }}"
                                        >

                                        @if ($service->is_active)

                                            <button
                                                type="submit"
                                                class="admin-service-status -active"
                                                title="Click to deactivate this service"
                                            >
                                                <i></i>
                                                ACTIVE
                                            </button>

                                        @else

                                            <button
                                                type="submit"
                                                class="admin-service-status -inactive"
                                                title="Click to activate this service"
                                            >
                                                <i></i>
                                                INACTIVE
                                            </button>

                                        @endif

                                    </form>

                                </div>


                                {{-- Card Body --}}
                                <div class="admin-service-card-body">

                                    <h2>
                                        {{ $service->name }}
                                    </h2>

                                    <p>
                                        {{ $service->description }}
                                    </p>

                                </div>


                                {{-- Card Footer --}}
                                <div class="admin-service-card-footer">

                                    <div class="admin-service-price">

                                        <span>
                                            STARTING FROM
                                        </span>

                                        <strong>
                                            Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                        </strong>

                                    </div>

                                    <a
                                        href="{{ route('admin.services.edit', $service) }}"
                                        class="admin-service-edit"
                                    >
                                        Edit
                                        <span>→</span>
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>


                    {{-- Pagination --}}
                    @if ($services->hasPages())

                        <nav
                            class="admin-service-pagination"
                            aria-label="Service pagination"
                        >
                            {{ $services->links() }}
                        </nav>

                    @endif

                @else

                    {{-- Empty State --}}
                    <div class="admin-service-empty">

                        <span class="section-tag">
                            SERVICES
                        </span>

                        @if ($search !== '' || $status !== '')

                            <h2>
                                No matching services found
                            </h2>

                            <p>
                                Try a different search term or change
                                the availability filter.
                            </p>

                            <a
                                href="{{ route('admin.services.index') }}"
                                class="btn -secondary"
                            >
                                Clear Filters
                            </a>

                        @else

                            <h2>
                                No services available
                            </h2>

                            <p>
                                Create your first service to make it
                                available through the FixIT platform.
                            </p>

                            <a
                                href="{{ route('admin.services.create') }}"
                                class="btn -primary"
                            >
                                Add First Service
                            </a>

                        @endif

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>
</html>