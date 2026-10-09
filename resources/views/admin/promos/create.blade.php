<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Promo — Admin — FixIT</title>

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

                <a href="{{ route('admin.repairs.index') }}">
                    Repairs
                </a>

                <a
                    href="{{ route('admin.promos.index') }}"
                    class="active"
                    aria-current="page"
                >
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
         Create Promo
         ======================================== --}}

    <main class="admin-promo-create-page">

        <div class="container">

            {{-- Back Navigation --}}
            <a
                href="{{ route('admin.promos.index') }}"
                class="admin-promo-create-back"
            >
                <span aria-hidden="true">←</span>
                Back to Promo Management
            </a>


            {{-- Page Heading --}}
            <div class="admin-promo-create-heading">

                <div>

                    <span class="section-tag">
                        PROMO MANAGEMENT / NEW ENTRY
                    </span>

                    <h1>
                        Create Promo
                    </h1>

                    <p>
                        Configure a discount code for customers
                        to use during the FixIT checkout process.
                    </p>

                </div>

                <span class="admin-promo-create-code">
                    PROMO / CREATE
                </span>

            </div>


            {{-- Validation Errors --}}
            @if ($errors->any())

                <div
                    class="admin-promo-create-errors"
                    role="alert"
                >

                    <div class="admin-promo-create-errors-title">

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
            <div class="admin-promo-create-layout">


                {{-- Main Form --}}
                <form
                    action="{{ route('admin.promos.store') }}"
                    method="POST"
                    class="admin-promo-create-form"
                >

                    @csrf


                    {{-- Discount Configuration --}}
                    <section class="admin-promo-create-panel">

                        <div class="admin-promo-create-panel-heading">

                            <div class="admin-promo-create-step">
                                01
                            </div>

                            <div>

                                <span class="section-tag">
                                    PROMO DETAILS
                                </span>

                                <h2>
                                    Discount Configuration
                                </h2>

                                <p>
                                    Define the code and discount
                                    customers can receive.
                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-fields">


                            {{-- Promo Code --}}
                            <div class="admin-promo-create-field is-full-width">

                                <label for="code">
                                    Promo Code
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="code"
                                    name="code"
                                    value="{{ old('code') }}"
                                    maxlength="50"
                                    placeholder="e.g. WELCOME10"
                                    autocomplete="off"
                                    spellcheck="false"
                                    required
                                >

                                <small>
                                    Customers enter this code during checkout.
                                    Use a code that is easy to recognize.
                                </small>

                                @error('code')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Discount Type --}}
                            <div class="admin-promo-create-field">

                                <label for="discount_type">
                                    Discount Type
                                    <span>*</span>
                                </label>

                                <select
                                    id="discount_type"
                                    name="discount_type"
                                    required
                                >

                                    <option
                                        value="percentage"
                                        {{ old('discount_type', 'percentage') === 'percentage' ? 'selected' : '' }}
                                    >
                                        Percentage (%)
                                    </option>

                                    <option
                                        value="fixed"
                                        {{ old('discount_type') === 'fixed' ? 'selected' : '' }}
                                    >
                                        Fixed Amount (Rp)
                                    </option>

                                </select>

                                <small>
                                    Choose a percentage or fixed discount.
                                </small>

                                @error('discount_type')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Discount Value --}}
                            <div class="admin-promo-create-field">

                                <label for="discount_value">
                                    Discount Value
                                    <span>*</span>
                                </label>

                                <input
                                    type="number"
                                    id="discount_value"
                                    name="discount_value"
                                    value="{{ old('discount_value') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="e.g. 10"
                                    required
                                >

                                <small id="promo-discount-help">
                                    Enter the percentage discount.
                                </small>

                                @error('discount_value')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Minimum Transaction --}}
                            <div class="admin-promo-create-field">

                                <label for="minimum_transaction">
                                    Minimum Transaction
                                    <span>*</span>
                                </label>

                                <div class="admin-promo-create-money-input">

                                    <span>Rp</span>

                                    <input
                                        type="number"
                                        id="minimum_transaction"
                                        name="minimum_transaction"
                                        value="{{ old('minimum_transaction', 0) }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="100000"
                                        required
                                    >

                                </div>

                                <small>
                                    Set to 0 if no minimum is required.
                                </small>

                                @error('minimum_transaction')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Expiration --}}
                            <div class="admin-promo-create-field">

                                <label for="expires_at">
                                    Expiration Date
                                </label>

                                <input
                                    type="datetime-local"
                                    id="expires_at"
                                    name="expires_at"
                                    value="{{ old('expires_at') }}"
                                >

                                <small>
                                    Leave empty for no expiration date.
                                </small>

                                @error('expires_at')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- Publication Settings --}}
                    <section class="admin-promo-create-panel">

                        <div class="admin-promo-create-panel-heading">

                            <div class="admin-promo-create-step">
                                02
                            </div>

                            <div>

                                <span class="section-tag">
                                    AVAILABILITY
                                </span>

                                <h2>
                                    Publication Settings
                                </h2>

                                <p>
                                    Choose whether this promo can be used
                                    when it is created.
                                </p>

                            </div>

                        </div>


                        <label
                            for="is_active"
                            class="admin-promo-create-visibility"
                        >

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
                                {{ old('is_active', true) ? 'checked' : '' }}
                            >

                            <span class="admin-promo-create-visibility-copy">

                                <strong>
                                    Activate this promo
                                </strong>

                                <small>
                                    Allow customers to use this code
                                    when its other requirements are satisfied.
                                </small>

                            </span>

                            <span
                                id="promo-preview-status"
                                class="admin-promo-create-status is-active"
                            >
                                ACTIVE
                            </span>

                        </label>

                        @error('is_active')
                            <span class="admin-promo-create-field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </section>


                    {{-- Form Actions --}}
                    <div class="admin-promo-create-actions">

                        <a
                            href="{{ route('admin.promos.index') }}"
                            class="btn -secondary"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn -primary"
                        >
                            Create Promo
                            <span aria-hidden="true">→</span>
                        </button>

                    </div>

                </form>


                {{-- Sidebar --}}
                <aside class="admin-promo-create-aside">


                    {{-- Live Preview --}}
                    <section class="admin-promo-create-preview-panel">

                        <div class="admin-promo-create-preview-heading">

                            <div>

                                <span class="section-tag">
                                    LIVE PREVIEW
                                </span>

                                <h2>
                                    Promo Preview
                                </h2>

                            </div>

                            <span class="admin-promo-create-preview-indicator">
                                LIVE
                            </span>

                        </div>


                        <div class="admin-promo-create-ticket">

                            <div class="admin-promo-create-ticket-top">

                                <span class="admin-promo-create-ticket-brand">
                                    <span class="mark">FX</span>
                                    FixIT
                                </span>

                                <span class="admin-promo-create-ticket-label">
                                    PROMOTION
                                </span>

                            </div>


                            <div class="admin-promo-create-ticket-discount">

                                <span class="admin-promo-create-ticket-caption">
                                    YOUR DISCOUNT
                                </span>

                                <strong
                                    id="promo-preview-value"
                                    aria-live="polite"
                                >
                                    —
                                </strong>

                            </div>


                            <div class="admin-promo-create-ticket-code">

                                <span>
                                    PROMO CODE
                                </span>

                                <strong id="promo-preview-code">
                                    WELCOME10
                                </strong>

                            </div>


                            <div class="admin-promo-create-ticket-details">

                                <div>

                                    <span>
                                        MIN. SPEND
                                    </span>

                                    <strong id="promo-preview-minimum">
                                        Rp 0
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        EXPIRES
                                    </span>

                                    <strong id="promo-preview-expiry">
                                        No expiration
                                    </strong>

                                </div>

                            </div>


                            <div
                                id="promo-preview-ticket-status"
                                class="admin-promo-create-ticket-status is-active"
                            >
                                ACTIVE PROMO
                            </div>

                        </div>


                        <p class="admin-promo-create-preview-note">
                            This is an administrative preview.
                            Actual eligibility and discount calculations
                            are determined by the payment rules.
                        </p>

                    </section>


                    {{-- Guidelines --}}
                    <section class="admin-promo-create-guide">

                        <span class="section-tag">
                            BEFORE PUBLISHING
                        </span>

                        <h2>
                            Promo Checklist
                        </h2>


                        <div class="admin-promo-create-guide-item">

                            <span>01</span>

                            <div>

                                <strong>
                                    Unique Promo Code
                                </strong>

                                <p>
                                    Make sure the code does not conflict
                                    with an existing promotion.
                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-guide-item">

                            <span>02</span>

                            <div>

                                <strong>
                                    Discount Configuration
                                </strong>

                                <p>
                                    Verify the discount type and value
                                    before publishing.
                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-guide-item">

                            <span>03</span>

                            <div>

                                <strong>
                                    Minimum Spend
                                </strong>

                                <p>
                                    Confirm the minimum transaction
                                    requirement is appropriate.
                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-guide-item">

                            <span>04</span>

                            <div>

                                <strong>
                                    Expiration and Status
                                </strong>

                                <p>
                                    Check the validity period and
                                    whether the promo should be active.
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- Admin Note --}}
                    <section class="admin-promo-create-note">

                        <span>
                            ADMIN NOTE
                        </span>

                        <p>
                            Deactivating a promo should prevent new use
                            without deleting its historical references
                            in invoices.
                        </p>

                    </section>

                </aside>

            </div>

        </div>

    </main>


    {{-- ========================================
         Live Promo Preview
         ======================================== --}}

    <script>
        (() => {
            const codeInput = document.getElementById('code');
            const typeInput = document.getElementById('discount_type');
            const valueInput = document.getElementById('discount_value');
            const minimumInput = document.getElementById('minimum_transaction');
            const expiryInput = document.getElementById('expires_at');
            const activeInput = document.getElementById('is_active');

            const previewCode = document.getElementById('promo-preview-code');
            const previewValue = document.getElementById('promo-preview-value');
            const previewMinimum = document.getElementById('promo-preview-minimum');
            const previewExpiry = document.getElementById('promo-preview-expiry');
            const previewStatus = document.getElementById('promo-preview-status');
            const previewTicketStatus = document.getElementById('promo-preview-ticket-status');
            const discountHelp = document.getElementById('promo-discount-help');

            const formatter = new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 2
            });

            const formatNumber = (value) => formatter.format(value);

            const formatRupiah = (value) => {
                const amount = Number(value);

                if (!Number.isFinite(amount) || value.trim?.() === '') {
                    return 'Rp 0';
                }

                return `Rp ${formatNumber(amount)}`;
            };

            const formatExpiry = (value) => {
                if (!value) {
                    return 'No expiration';
                }

                const date = new Date(value);

                if (Number.isNaN(date.getTime())) {
                    return 'Invalid date';
                }

                return new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }).format(date);
            };

            const updatePreview = () => {
                const code = codeInput.value.trim().toUpperCase();
                const type = typeInput.value;
                const rawValue = valueInput.value.trim();
                const rawMinimum = minimumInput.value.trim();

                const value = Number(rawValue);
                const minimum = Number(rawMinimum);

                previewCode.textContent = code || 'WELCOME10';

                if (rawValue === '') {
                    previewValue.textContent = '—';
                } else if (Number.isFinite(value)) {
                    previewValue.textContent = type === 'percentage'
                        ? `${formatNumber(value)}% OFF`
                        : `${formatRupiah(rawValue)} OFF`;
                } else {
                    previewValue.textContent = '—';
                }

                previewMinimum.textContent = rawMinimum === ''
                    ? 'Rp 0'
                    : formatRupiah(rawMinimum);

                previewExpiry.textContent = formatExpiry(expiryInput.value);

                discountHelp.textContent = type === 'percentage'
                    ? 'Enter the percentage discount.'
                    : 'Enter the fixed discount amount in rupiah.';

                const isActive = activeInput.checked;

                previewStatus.textContent = isActive ? 'ACTIVE' : 'INACTIVE';
                previewTicketStatus.textContent = isActive
                    ? 'ACTIVE PROMO'
                    : 'INACTIVE PROMO';

                previewStatus.classList.toggle('is-active', isActive);
                previewStatus.classList.toggle('is-inactive', !isActive);

                previewTicketStatus.classList.toggle('is-active', isActive);
                previewTicketStatus.classList.toggle('is-inactive', !isActive);
            };

            [
                codeInput,
                typeInput,
                valueInput,
                minimumInput,
                expiryInput
            ].forEach((input) => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            activeInput.addEventListener('change', updatePreview);

            updatePreview();
        })();
    </script>

</body>
</html>