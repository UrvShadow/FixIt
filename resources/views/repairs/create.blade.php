<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Request Repair — FixIT</title>

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

            <nav class="nav-links">

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


    {{-- Repair Request --}}
    <section>

        <div class="container">

            <div class="repair-form-layout">

                {{-- Form --}}
                <div class="auth-box repair-form-box">

                    <div class="section-head">

                        <div class="section-tag">
                            Service Request
                        </div>

                        <h1>
                            Request Repair
                        </h1>

                        <p>
                            Submit a repair request for one of your
                            registered devices.
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

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    @if ($devices->isEmpty())

                        {{-- No Devices --}}
                        <div class="empty-state repair-no-device">

                            <div class="section-tag">
                                Device Required
                            </div>

                            <h2>
                                No devices registered yet.
                            </h2>

                            <p>
                                You need to register at least one device
                                before submitting a repair request.
                            </p>

                            <a
                                href="{{ route('devices.create') }}"
                                class="btn -primary"
                            >
                                + Add Device First
                            </a>

                        </div>

                    @else

                        <form
                            action="{{ route('repairs.store') }}"
                            method="POST"
                        >

                            @csrf


                            {{-- Device --}}
                            <div class="field">

                                <label for="device_id">
                                    Select Device
                                </label>

                                <select
                                    id="device_id"
                                    name="device_id"
                                    required
                                >

                                    <option value="">
                                        -- Select Device --
                                    </option>

                                    @foreach ($devices as $device)

                                        <option
                                            value="{{ $device->id }}"
                                            {{ old('device_id') == $device->id ? 'selected' : '' }}
                                        >
                                            {{ $device->name }}
                                            — {{ $device->brand }}
                                            @if ($device->model)
                                                {{ $device->model }}
                                            @endif
                                        </option>

                                    @endforeach

                                </select>

                                <small class="field-help">
                                    Select the device that requires service.
                                </small>

                            </div>


                            {{-- Issue --}}
                            <div class="field">

                                <label for="issue">
                                    Describe the Problem
                                </label>

                                <textarea
                                    id="issue"
                                    name="issue"
                                    rows="7"
                                    placeholder="Explain the problem with your device..."
                                    required
                                >{{ old('issue') }}</textarea>

                                <small class="field-help">
                                    Include symptoms, errors, or anything
                                    unusual you noticed.
                                </small>

                            </div>


                            {{-- Actions --}}
                            <div class="form-actions">

                                <a
                                    href="{{ route('repairs.index') }}"
                                    class="btn -ghost"
                                >
                                    ← Cancel
                                </a>

                                <button
                                    type="submit"
                                    class="btn -primary"
                                >
                                    Submit Repair Request
                                </button>

                            </div>

                        </form>

                    @endif

                </div>

                <div class="repair-flow">

    <div class="repair-flow-line"></div>

    <div class="repair-flow-step">
        <span class="repair-flow-dot"></span>
        <span class="repair-flow-label">REQUEST</span>
    </div>

    <div class="repair-flow-arrow">
        →
    </div>

    <div class="repair-flow-step">
        <span class="repair-flow-dot"></span>
        <span class="repair-flow-label">SERVICE</span>
    </div>

    <div class="repair-flow-line"></div>

</div>


                {{-- Side Panel --}}
                <aside class="repair-request-panel">

                    <div class="section-tag">
                        How It Works
                    </div>

                    <h2>
                        Repair Process
                    </h2>

                    <p>
                        Your repair request will go through several
                        stages before the service is completed.
                    </p>


                    <div class="repair-process-list">

                        <div class="repair-process-item">

                            <span class="repair-process-number">
                                01
                            </span>

                            <div>

                                <h3>
                                    Submit Request
                                </h3>

                                <p>
                                    Tell us which device needs service
                                    and describe the problem.
                                </p>

                            </div>

                        </div>


                        <div class="repair-process-item">

                            <span class="repair-process-number">
                                02
                            </span>

                            <div>

                                <h3>
                                    Device Diagnosis
                                </h3>

                                <p>
                                    The device is reviewed to identify
                                    the cause of the problem.
                                </p>

                            </div>

                        </div>


                        <div class="repair-process-item">

                            <span class="repair-process-number">
                                03
                            </span>

                            <div>

                                <h3>
                                    Repair & Service
                                </h3>

                                <p>
                                    Approved repairs are performed and
                                    tracked through the system.
                                </p>

                            </div>

                        </div>


                        <div class="repair-process-item">

                            <span class="repair-process-number">
                                04
                            </span>

                            <div>

                                <h3>
                                    Completion
                                </h3>

                                <p>
                                    Once the repair is finished, the
                                    service record is updated.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="repair-request-note">

                        <span>TIP</span>

                        <p>
                            The more specific your problem description
                            is, the easier it will be to diagnose the
                            device.
                        </p>

                    </div>

                </aside>

            </div>

        </div>

    </section>

</body>
</html>