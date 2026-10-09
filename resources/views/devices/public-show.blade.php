<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $device->name }} — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- Public Navbar --}}
    <header class="nav">
        <div class="container">
            <a href="{{ route('home') }}" class="brand">
                <span class="mark">FX</span>
                FixIT
            </a>

            <div class="public-label">
                Public Device Record
            </div>
        </div>
    </header>

    {{-- Device Record --}}
    <section class="public-device-page">
        <div class="container">

            {{-- Device Header --}}
            <div class="public-device-header">
                <div>
                    <div class="section-tag">
                        Device Record
                    </div>

                    <h1>{{ $device->name }}</h1>

                    <p>
                        {{ $device->category }}
                        ·
                        {{ $device->brand }}

                        @if ($device->model)
                            · {{ $device->model }}
                        @endif
                    </p>
                </div>

                <div class="public-device-code">
                    <span>Device ID</span>

                    <strong class="ticket-code">
                        {{ $device->device_code }}
                    </strong>
                </div>
            </div>

            {{-- Device Information --}}
            <div class="public-device-info">
                <div class="section-tag">
                    Device Information
                </div>

                <div class="public-info-grid">
                    <div>
                        <span>Category</span>
                        <strong>{{ $device->category }}</strong>
                    </div>

                    <div>
                        <span>Brand</span>
                        <strong>{{ $device->brand }}</strong>
                    </div>

                    <div>
                        <span>Model</span>
                        <strong>{{ $device->model ?: '-' }}</strong>
                    </div>

                    <div>
                        <span>Serial Number</span>
                        <strong>{{ $device->serial_number ?: '-' }}</strong>
                    </div>
                </div>

                @if ($device->description)
                    <div class="public-description">
                        <span>Description</span>

                        <p>{{ $device->description }}</p>
                    </div>
                @endif
            </div>

            {{-- Repair History --}}
            <div class="public-repair-history">
                <div class="section-head">
                    <div class="section-tag">
                        Service Record
                    </div>

                    <h2>Repair History</h2>

                    <p>
                        Recorded repair activity associated with this device.
                    </p>
                </div>

                @forelse ($device->repairRequests as $repair)
                    <article class="public-repair-card">

                        {{-- Repair Header --}}
                        <div class="public-repair-header">
                            <div>
                                <span class="ticket-code">
                                    REPAIR #{{ $repair->id }}
                                </span>

                                <h3>{{ $repair->issue }}</h3>
                            </div>

                            <span class="status-badge status-{{ $repair->status }}">
                                {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                            </span>
                        </div>

                        {{-- Repair Timeline --}}
                        @if ($repair->repairHistories->isNotEmpty())
                            <div class="repair-timeline">
                                @php
                                    $lastHistory = $repair->repairHistories->last();
                                @endphp

                                @foreach ($repair->repairHistories as $history)
                                    @php
                                        $isLast = $lastHistory
                                            && $history->id === $lastHistory->id;

                                        $isFailed = in_array($history->status, [
                                            'rejected',
                                            'cancelled',
                                        ]);

                                        $isCompleted = !$isLast
                                            || $history->status === 'completed';

                                        $timelineClass = $isFailed
                                            ? '-failed'
                                            : ($isCompleted ? '-completed' : '-active');
                                    @endphp

                                    <div class="timeline-item {{ $timelineClass }}">
                                        <div class="timeline-marker">
                                            @if ($isFailed)
                                                ×
                                            @elseif ($isCompleted)
                                                ✓
                                            @else
                                                ●
                                            @endif
                                        </div>

                                        <div class="timeline-content">
                                            <strong>
                                                {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                                            </strong>

                                            <span>
                                                {{ $history->created_at->format('d M Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </article>
                @empty
                    {{-- Empty State --}}
                    <div class="empty-state">
                        <h3>No repair history</h3>

                        <p>
                            This device has no recorded repair activity yet.
                        </p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

</body>
</html>