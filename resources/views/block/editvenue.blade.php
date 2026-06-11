<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Edit Venue
    </title>
    @include('block.includes.header')
    <style>

        /* ========================
           PAGE TITLE
        ======================== */
        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3748;
        }

        /* ========================
           EDIT CARD
        ======================== */
        .edit-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        /* ========================
           CARD HEADER
        ======================== */
        .edit-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 28px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            color: #ffffff;
        }

        .venue-icon-wrap {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .text-muted-light {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
        }

        .venue-id-badge {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* ========================
           CARD BODY
        ======================== */
        .edit-card-body {
            padding: 32px 28px 28px;
        }

        /* ========================
           FORM FIELDS
        ======================== */
        .form-field-wrap {
            margin-bottom: 24px;
        }

        .field-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .field-icon {
            width: 24px;
            height: 24px;
            background: #eef2ff;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            font-size: 0.7rem;
        }

        .field-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #2d3748;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.2s ease;
            outline: none;
        }

        .field-input:focus {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
        }

        .field-input.is-invalid {
            border-color: #e53e3e;
            background: #fff5f5;
        }

        .field-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(229, 62, 62, 0.08);
        }

        .field-error {
            margin-top: 6px;
            font-size: 0.8rem;
            color: #e53e3e;
            font-weight: 500;
        }

        .field-hint {
            display: block;
            margin-top: 6px;
            font-size: 0.78rem;
            color: #a0aec0;
        }

        /* ========================
           DIVIDER
        ======================== */
        .field-divider {
            height: 1px;
            background: #f0f4f8;
            margin: 8px 0 24px;
        }

        /* ========================
           ACTION BUTTONS
        ======================== */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #718096;
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background: #edf2f7;
            color: #4a5568;
            border-color: #cbd5e0;
            text-decoration: none;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            padding: 10px 24px;
            font-size: 0.875rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
            transform: translateY(-1px);
        }

        .btn-save:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }

        .btn-save:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

    </style>
</head>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- ======================== --}}
    {{-- NAVBAR --}}
    {{-- ======================== --}}
    @include('block.includes.navbar')

    {{-- ======================== --}}
    {{-- SIDEBAR --}}
    {{-- ======================== --}}
    @include('block.includes.sidebar')

    {{-- ======================== --}}
    {{-- CONTENT WRAPPER --}}
    {{-- ======================== --}}
    <div class="content-wrapper">

        {{-- PAGE HEADER --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 page-title">
                            <i class="fas fa-map-marker-alt mr-2 text-warning"></i>
                            Edit Venue
                        </h1>
                        
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('cadre.mapping') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Venues
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-6">

                        {{-- SUCCESS ALERT --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        {{-- ERROR ALERT --}}
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        {{-- EDIT CARD --}}
                        <div class="edit-card">

                            {{-- CARD HEADER --}}
                            <div class="edit-card-header">
                                <div class="venue-icon-wrap">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 font-weight-bold">{{ $venue->venue_name }}</h5>
                                    <small class="text-muted-light">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $venue->village->vill_name ?? 'N/A' }}
                                    </small>
                                </div>
                                <div class="ml-auto">
                                    <span class="venue-id-badge">#{{ $venue->id }}</span>
                                </div>
                            </div>

                            {{-- CARD BODY --}}
                            <div class="edit-card-body">

                                <form
                                    action="{{ route('edit.venue.update', $venue->id) }}"
                                    method="POST"
                                    id="editVenueForm"
                                >
                                    @csrf
                                    @method('POST')

                                    {{-- VENUE NAME --}}
                                    <div class="form-field-wrap">
                                        <label class="field-label" for="venue_name">
                                            <span class="field-icon">
                                                <i class="fas fa-building"></i>
                                            </span>
                                            Venue Name
                                        </label>
                                        <input
                                            type="text"
                                            id="venue_name"
                                            name="venue_name"
                                            class="field-input @error('venue_name') is-invalid @enderror"
                                            value="{{ old('venue_name', $venue->venue_name) }}"
                                            placeholder="Enter venue name"
                                            required
                                            autocomplete="off"
                                        >
                                        @error('venue_name')
                                            <div class="field-error">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- CAPACITY --}}
                                    <div class="form-field-wrap">
                                        <label class="field-label" for="capacity">
                                            <span class="field-icon">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            Capacity
                                        </label>
                                        <input
                                            type="number"
                                            id="capacity"
                                            name="capacity"
                                            class="field-input @error('capacity') is-invalid @enderror"
                                            value="{{ old('capacity', $venue->capacity) }}"
                                            placeholder="Enter capacity"
                                            min="1"
                                            required
                                        >
                                        @error('capacity')
                                            <div class="field-error">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <small class="field-hint">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Minimum capacity is 1
                                        </small>
                                    </div>

                                    {{-- DIVIDER --}}
                                    <div class="field-divider"></div>

                                    {{-- ACTION BUTTONS --}}
                                    <div class="form-actions">
                                        <a href="{{ route('cadre.mapping') }}" class="btn-cancel">
                                            <i class="fas fa-times mr-1"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn-save" id="saveVenueBtn">
                                            <i class="fas fa-save mr-1"></i> Save Changes
                                        </button>
                                    </div>

                                </form>

                            </div>
                            {{-- END CARD BODY --}}

                        </div>
                        {{-- END EDIT CARD --}}

                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- END CONTENT WRAPPER --}}

    {{-- ======================== --}}
    {{-- FOOTER --}}
    {{-- ======================== --}}
    @include('block.includes.footer')

</div>
{{-- END WRAPPER --}}

<script>
    $(document).ready(function () {

        // ========================
        // FORM SUBMIT WITH SWAL
        // ========================
        $('#editVenueForm').on('submit', function (e) {
            e.preventDefault();

            const venueName = $('#venue_name').val().trim();
            const capacity  = $('#capacity').val();
            const $btn      = $('#saveVenueBtn');

            // Guard: venue name required
            if (!venueName) {
                Swal.fire({
                    icon              : 'warning',
                    title             : 'Venue Name Required',
                    text              : 'Please enter the venue name.',
                    confirmButtonColor: '#4f46e5',
                });
                return;
            }

            // Guard: capacity required and min 1
            if (!capacity || parseInt(capacity) < 1) {
                Swal.fire({
                    icon              : 'warning',
                    title             : 'Invalid Capacity',
                    text              : 'Capacity must be at least 1.',
                    confirmButtonColor: '#4f46e5',
                });
                return;
            }

            // Disable button
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

            // Native submit to avoid loop
            this.submit();
        });

    });
</script>

</body>
</html>
