<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Request Repair - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="container">

        <h1>Request Repair</h1>

        <p>
            Submit a repair request for your device.
        </p>

        @if ($errors->any())
            <div>
                <strong>Please fix the following errors:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($devices->isEmpty())

            <p>
                You don't have any registered devices yet.
            </p>

            <a href="{{ route('devices.create') }}">
                + Add Device First
            </a>

        @else

            <form action="{{ route('repairs.store') }}" method="POST">

                @csrf

                <div>
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
                                - {{ $device->brand }}
                                {{ $device->model }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <br>

                <div>
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
                </div>

                <br>

                <button type="submit">
                    Submit Repair Request
                </button>

            </form>

        @endif

        <br>

        <a href="{{ route('repairs.index') }}">
            ← My Repair Requests
        </a>

        <br>

        <a href="{{ route('dashboard') }}">
            ← Dashboard
        </a>

    </div>

</body>
</html>