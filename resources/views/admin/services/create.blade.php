
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Service — Admin — FixIT</title>

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


    {{-- ========================================
         Create Service
         ======================================== --}}

    <main class="admin-service-create-page">

        <div class="container">

            {{-- Back Navigation --}}
            <a
                href="{{ route('admin.services.index') }}"
                class="admin-service-create-back"
            >
                <span aria-hidden="true">←</span>
                Back to Services
            </a>


            {{-- Page Heading --}}
            <div class="admin-service-create-heading">

                <div>

                    <span class="section-tag">
                        SERVICE MANAGEMENT / NEW ENTRY
                    </span>

                    <h1>
                        Add New Service
                    </h1>

                    <p>
                        Configure a repair or maintenance service
                        for the FixIT service catalog.
                    </p>

                </div>

                <span class="admin-service-create-code">
                    SERVICE / CREATE
                </span>

            </div>


            {{-- Validation Errors --}}
            @if ($errors->any())

                <div
                    class="admin-service-create-errors"
                    role="alert"
                >

                    <div class="admin-service-create-errors-title">
                        <span aria-hidden="true">!</span>

                        <strong>
                            Please review the following fields.
                        </strong>
                    </div>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif


            {{-- Form Layout --}}
            <div class="admin-service-create-layout">


                {{-- Main Form --}}
                <form
                    action="{{ route('admin.services.store') }}"
                    method="POST"
                    class="admin-service-create-form"
                >

                    @csrf


                    {{-- Service Information --}}
                    <section class="admin-service-create-panel">

                        <div class="admin-service-create-panel-heading">

                            <div class="admin-service-create-step">
                                01
                            </div>

                            <div>

                                <span class="section-tag">
                                    SERVICE DETAILS
                                </span>

                                <h2>
                                    General Information
                                </h2>

                                <p>
                                    Define the identity and description
                                    of this service.
                                </p>

                            </div>

                        </div>


                        <div class="admin-service-create-fields">

                            {{-- Service Name --}}
                            <div class="admin-service-create-field">

                                <label for="name">
                                    Service Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    maxlength="100"
                                    placeholder="e.g. Laptop Repair"
                                    autocomplete="off"
                                    required
                                >

                                <small>
                                    Use a clear name that customers can recognize.
                                </small>

                                @error('name')
                                    <span class="admin-service-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Slug --}}
                            <div class="admin-service-create-field">

                                <label for="slug">
                                    Service Slug
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="slug"
                                    name="slug"
                                    value="{{ old('slug') }}"
                                    maxlength="120"
                                    placeholder="e.g. laptop-repair"
                                    autocomplete="off"
                                    spellcheck="false"
                                    required
                                >

                                <small>
                                    Unique identifier used in the system.
                                </small>

                                @error('slug')
                                    <span class="admin-service-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Category --}}
                            <div class="admin-service-create-field">

                                <label for="category">
                                    Category
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="category"
                                    name="category"
                                    value="{{ old('category') }}"
                                    maxlength="50"
                                    placeholder="e.g. Laptop"
                                    required
                                >

                                <small>
                                    Group the service by device or repair type.
                                </small>

                                @error('category')
                                    <span class="admin-service-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Starting Price --}}
                            <div class="admin-service-create-field">

                                <label for="starting_price">
                                    Starting Price
                                    <span>*</span>
                                </label>

                                <div class="admin-service-create-price-input">

                                    <span>Rp</span>

                                    <input
                                        type="number"
                                        id="starting_price"
                                        name="starting_price"
                                        value="{{ old('starting_price') }}"
                                        min="0"
                                        step="1000"
                                        placeholder="100000"
                                        required
                                    >

                                </div>

                                <small>
                                    Final repair costs may vary after diagnosis.
                                </small>

                                @error('starting_price')
                                    <span class="admin-service-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Description --}}
                            <div class="admin-service-create-field is-full-width">

                                <label for="description">
                                    Service Description
                                    <span>*</span>
                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="6"
                                    placeholder="Describe the service, what it covers, and what customers can expect..."
                                    required
                                >{{ old('description') }}</textarea>

                                <small>
                                    Keep the description informative and easy to understand.
                                </small>

                                @error('description')
                                    <span class="admin-service-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- Publication Settings --}}
                    <section class="admin-service-create-panel">

                        <div class="admin-service-create-panel-heading">

                            <div class="admin-service-create-step">
                                02
                            </div>

                            <div>

                                <span class="section-tag">
                                    VISIBILITY
                                </span>

                                <h2>
                                    Publication Settings
                                </h2>

                                <p>
                                    Decide whether this service is visible
                                    in the customer catalog.
                                </p>

                            </div>

                        </div>


                        <label
                            for="is_active"
                            class="admin-service-create-visibility"
                        >

                            <input
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                            >

                            <span class="admin-service-create-checkbox-ui">
                                <span></span>
                            </span>

                            <span class="admin-service-create-visibility-copy">

                                <strong>
                                    Publish service
                                </strong>

                                <small>
                                    Active services can appear in the
                                    public service catalog. You can
                                    change this setting later.
                                </small>

                            </span>

                            <span class="admin-service-create-visibility-state">
                                {{ old('is_active', true) ? 'ACTIVE BY DEFAULT' : 'INACTIVE' }}
                            </span>

                        </label>

                    </section>


                    {{-- Form Actions --}}
                    <div class="admin-service-create-actions">

                        <a
                            href="{{ route('admin.services.index') }}"
                            class="btn -secondary"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn -primary"
                        >
                            Create Service
                            <span aria-hidden="true">→</span>
                        </button>

                    </div>

                </form>


                {{-- Side Information --}}
                <aside class="admin-service-create-aside">

                    <section class="admin-service-create-aside-panel">

                        <span class="section-tag">
                            BEFORE PUBLISHING
                        </span>

                        <h2>
                            Service Checklist
                        </h2>

                        <p class="admin-service-create-aside-intro">
                            Review these details before making
                            the service available to customers.
                        </p>


                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                01
                            </span>

                            <div>

                                <strong>
                                    Clear Service Name
                                </strong>

                                <p>
                                    Choose a name that clearly
                                    describes the repair service.
                                </p>

                            </div>

                        </div>


                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                02
                            </span>

                            <div>

                                <strong>
                                    Unique Slug
                                </strong>

                                <p>
                                    Each service requires a unique
                                    identifier in the catalog.
                                </p>

                            </div>

                        </div>


                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                03
                            </span>

                            <div>

                                <strong>
                                    Accurate Starting Price
                                </strong>

                                <p>
                                    Set a reasonable starting price
                                    for customers to review.
                                </p>

                            </div>

                        </div>


                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                04
                            </span>

                            <div>

                                <strong>
                                    Publication Status
                                </strong>

                                <p>
                                    Only enable active status when
                                    the service is ready to be offered.
                                </p>

                            </div>

                        </div>

                    </section>


                    <section class="admin-service-create-note">

                        <span>
                            ADMIN NOTE
                        </span>

                        <p>
                            The starting price is an initial reference.
                            The final repair cost should be confirmed
                            during the repair workflow.
                        </p>

                    </section>

                </aside>

            </div>

        </div>

    </main>

</body>
</html>