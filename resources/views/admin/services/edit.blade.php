<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Service — Admin — FixIT</title>

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
         Edit Service
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
                        SERVICE MANAGEMENT / EDIT ENTRY
                    </span>

                    <h1>
                        Edit Service
                    </h1>

                    <p>
                        Update the information, pricing, and availability
                        of this FixIT service.
                    </p>

                </div>

                <span class="admin-service-create-code">
                    SERVICE / {{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
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
                    action="{{ route('admin.services.update', $service) }}"
                    method="POST"
                    class="admin-service-create-form"
                >

                    @csrf
                    @method('PUT')


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
                                    Update the identity and description
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
                                    value="{{ old('name', $service->name) }}"
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
                                    value="{{ old('slug', $service->slug) }}"
                                    maxlength="120"
                                    placeholder="e.g. laptop-repair"
                                    autocomplete="off"
                                    spellcheck="false"
                                    required
                                >

                                <small>
                                    Must remain unique across all services.
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
                                    value="{{ old('category', $service->category) }}"
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
                                        value="{{ old('starting_price', $service->starting_price) }}"
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
                                >{{ old('description', $service->description) }}</textarea>

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
                                    Manage whether customers can find
                                    this service in the public catalog.
                                </p>

                            </div>

                        </div>


                        @php
                            $isActive = old(
                                '_token',
                                null
                            ) !== null
                                ? (bool) old('is_active', false)
                                : (bool) $service->is_active;
                        @endphp

                        <label
                            for="is_active"
                            class="admin-service-create-visibility"
                        >

                            {{-- Ensures unchecked status is submitted as false --}}
                            <input
                                type="hidden"
                                name="is_active"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ $isActive ? 'checked' : '' }}
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
                                    public service catalog. Deactivated
                                    services remain saved in the database.
                                </small>

                            </span>

                            <span class="admin-service-create-visibility-state">
                                {{ $isActive ? 'ACTIVE' : 'INACTIVE' }}
                            </span>

                        </label>

                        @error('is_active')
                            <span class="admin-service-create-field-error">
                                {{ $message }}
                            </span>
                        @enderror

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
                            Save Changes
                            <span aria-hidden="true">→</span>
                        </button>

                    </div>

                </form>


                {{-- Sidebar --}}
                <aside class="admin-service-create-aside">


                    {{-- Current Service Summary --}}
                    <section class="admin-service-create-aside-panel">

                        <span class="section-tag">
                            CURRENT RECORD
                        </span>

                        <h2>
                            Service Overview
                        </h2>

                        <p class="admin-service-create-aside-intro">
                            Review the existing service before
                            applying your changes.
                        </p>


                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                01
                            </span>

                            <div>

                                <strong>
                                    Service ID
                                </strong>

                                <p>
                                    #{{ $service->id }}
                                </p>

                            </div>

                        </div>


                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                02
                            </span>

                            <div>

                                <strong>
                                    Current Category
                                </strong>

                                <p>
                                    {{ $service->category }}
                                </p>

                            </div>

                        </div>


                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                03
                            </span>

                            <div>

                                <strong>
                                    Current Price
                                </strong>

                                <p>
                                    Rp {{ number_format($service->starting_price, 0, ',', '.') }}
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
                                    {{ $service->is_active ? 'Currently active in the catalog' : 'Currently inactive in the catalog' }}
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- Editing Tips --}}
                    <section class="admin-service-create-aside-panel">

                        <span class="section-tag">
                            EDITING GUIDELINES
                        </span>

                        <h2>
                            Before Saving
                        </h2>

                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                01
                            </span>

                            <div>

                                <strong>
                                    Check the Slug
                                </strong>

                                <p>
                                    Existing public links may depend
                                    on this identifier.
                                </p>

                            </div>

                        </div>

                        <div class="admin-service-create-checklist-item">

                            <span class="admin-service-create-check-number">
                                02
                            </span>

                            <div>

                                <strong>
                                    Review the Price
                                </strong>

                                <p>
                                    Make sure the updated starting
                                    price reflects the service offered.
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- Admin Note --}}
                    <section class="admin-service-create-note">

                        <span>
                            ADMIN NOTE
                        </span>

                        <p>
                            Changing a service's starting price does not
                            automatically change existing repair invoices.
                            Review repair costs through the repair workflow.
                        </p>

                    </section>

                </aside>

            </div>

        </div>

    </main>

</body>
</html>