<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Device — FixIT</title>

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
        <a href="{{ route('home') }}#services">Services</a>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('devices.index') }}">Devices</a>
        <a href="{{ route('repairs.index') }}">Repairs</a>

        <div class="nav-mobile-actions">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="btn -secondary -sm -block"
                >
                    Log out
                </button>
            </form>
        </div>
    </nav>
</header>


    {{-- Edit Device --}}
    <section>
        <div class="container">

            <div class="device-form-layout">

                {{-- Device Form --}}
                <div class="auth-box device-form-box">

                    <div class="section-head">

                        <div class="section-tag">
                            Device Management
                        </div>

                        <h1>Edit Device</h1>

                        <p>
                            Update the information of your registered
                            device.
                        </p>

                    </div>

                    {{-- Device Code --}}
                    <div class="device-code-display">

                        <span>Device ID</span>

                        <strong class="ticket-code">
                            {{ $device->device_code }}
                        </strong>

                        <p>
                            This device code is automatically generated
                            and cannot be changed.
                        </p>

                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="form-errors">

                            <strong>
                                Please fix the following errors:
                            </strong>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif

                    <form
                        action="{{ route('devices.update', $device) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <div class="field-2col">

                            <div class="field">

                                <label for="name">
                                    Device Name
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $device->name) }}"
                                    required
                                >

                            </div>

                            <div class="field">

                                <label for="category">
                                    Category
                                </label>

                                <input
                                    type="text"
                                    id="category"
                                    name="category"
                                    value="{{ old('category', $device->category) }}"
                                    required
                                >

                            </div>

                        </div>

                        <div class="field-2col">

                            <div class="field">

                                <label for="brand">
                                    Brand
                                </label>

                                <input
                                    type="text"
                                    id="brand"
                                    name="brand"
                                    value="{{ old('brand', $device->brand) }}"
                                    required
                                >

                            </div>

                            <div class="field">

                                <label for="model">
                                    Model
                                </label>

                                <input
                                    type="text"
                                    id="model"
                                    name="model"
                                    value="{{ old('model', $device->model) }}"
                                >

                            </div>

                        </div>

                        <div class="field">

                            <label for="serial_number">
                                Serial Number
                            </label>

                            <input
                                type="text"
                                id="serial_number"
                                name="serial_number"
                                value="{{ old('serial_number', $device->serial_number) }}"
                                placeholder="Optional"
                            >

                        </div>

                        <div class="field">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Additional information about the device..."
                            >{{ old('description', $device->description) }}</textarea>

                        </div>

                        <div class="form-actions">

                            <a
                                href="{{ route('devices.index') }}"
                                class="btn -ghost"
                            >
                                ← Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn -primary"
                            >
                                Update Device
                            </button>

                        </div>

                    </form>

                </div>

                {{-- Device Information --}}
                <aside class="device-registration-panel">

                    <div class="section-tag">
                        Device Identity
                    </div>

                    <h2>
                        Keep It Accurate
                    </h2>

                    <p>
                        Keep your device information up to date so
                        identification and repair tracking remain accurate.
                    </p>

                    <div class="registration-list">

                        <div class="registration-item">

                            <span class="registration-number">
                                01
                            </span>

                            <div>

                                <h3>Device Code</h3>

                                <p>
                                    Your unique device code remains
                                    unchanged after editing.
                                </p>

                            </div>

                        </div>

                        <div class="registration-item">

                            <span class="registration-number">
                                02
                            </span>

                            <div>

                                <h3>Device Information</h3>

                                <p>
                                    Update the brand, model, serial number,
                                    or other details when necessary.
                                </p>

                            </div>

                        </div>

                        <div class="registration-item">

                            <span class="registration-number">
                                03
                            </span>

                            <div>

                                <h3>Repair History</h3>

                                <p>
                                    Existing repair requests and history
                                    remain connected to this device.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="registration-note">

                        <span>TIP</span>

                        <p>
                            Make sure the device information matches the
                            physical device before saving your changes.
                        </p>

                    </div>

                </aside>

            </div>

        </div>
    </section>

</body>
</html>