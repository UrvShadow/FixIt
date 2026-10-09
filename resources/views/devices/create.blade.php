<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Device — FixIT</title>

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
            <a href="{{ route('home') }}#services">Services</a>
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

    {{-- Add Device --}}
    <section>
        <div class="container">

            <div class="device-form-layout">

                {{-- Device Form --}}
                <div class="auth-box device-form-box">

                    <div class="section-head">
                        <div class="section-tag">
                            Device Management
                        </div>

                        <h1>Add Device</h1>

                        <p>
                            Register a device to start managing its
                            identification and repair history.
                        </p>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="form-errors">
                            <strong>Please fix the following errors:</strong>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('devices.store') }}"
                        method="POST"
                    >
                        @csrf

                        <div class="field-2col">

                            <div class="field">
                                <label for="name">
                                    Device Name
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. ASUS ROG Laptop"
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
                                    value="{{ old('category') }}"
                                    placeholder="e.g. Laptop"
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
                                    value="{{ old('brand') }}"
                                    placeholder="e.g. ASUS"
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
                                    value="{{ old('model') }}"
                                    placeholder="e.g. ROG Strix G15"
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
                                value="{{ old('serial_number') }}"
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
                            >{{ old('description') }}</textarea>
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
                                Save Device
                            </button>

                        </div>

                    </form>

                </div>

                {{-- Registration Information --}}
                <aside class="device-registration-panel">

                    <div class="section-tag">
                        How it works
                    </div>

                    <h2>
                        Device Registration
                    </h2>

                    <p>
                        Registering a device creates a unique identity
                        that can be used throughout the FixIT repair
                        system.
                    </p>

                    <div class="registration-list">

                        <div class="registration-item">
                            <span class="registration-number">01</span>

                            <div>
                                <h3>Unique Device ID</h3>

                                <p>
                                    FixIT automatically assigns a unique
                                    device code after registration.
                                </p>
                            </div>
                        </div>

                        <div class="registration-item">
                            <span class="registration-number">02</span>

                            <div>
                                <h3>QR Identification</h3>

                                <p>
                                    A QR code can be used to quickly
                                    access the device information.
                                </p>
                            </div>
                        </div>

                        <div class="registration-item">
                            <span class="registration-number">03</span>

                            <div>
                                <h3>Repair Tracking</h3>

                                <p>
                                    Repair requests and history can be
                                    associated with the registered device.
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="registration-note">
                        <span>TIP</span>

                        <p>
                            Use the actual device name, brand, model,
                            and serial number whenever available.
                        </p>
                    </div>

                </aside>

            </div>

        </div>
    </section>

</body>
</html>