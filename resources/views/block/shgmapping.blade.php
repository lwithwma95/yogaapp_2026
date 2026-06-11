<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHG – Venue Mapping</title>
    @include('block.includes.header')
    <style>
        /* ── Venue info card ── */
        .venue-info-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .venue-info-card .card-header {
            background: linear-gradient(135deg, #155724, #1a6b2e, #28a745);
            color: #fff;
            padding: 16px 20px;
        }

        .venue-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            padding: 16px 20px;
        }

        .venue-meta-item .lbl {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            margin-bottom: 3px;
        }

        .venue-meta-item .val {
            font-size: 14px;
            font-weight: 600;
            color: #212529;
        }

        /* ── Mapping card ── */
        .mapping-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
        }

        .mapping-card .card-header {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            border-radius: 12px 12px 0 0;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .mapping-card .card-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 14px;
        }

        /* ── Table ── */
        .mapping-table thead th {
            background: #e9ecef;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #495057;
            white-space: nowrap;
            border-bottom: 2px solid #dee2e6;
        }

        .mapping-table td {
            vertical-align: middle;
            font-size: 13px;
        }

        .shg-name {
            font-weight: 600;
            color: #212529;
            font-size: 14px;
        }

        .shg-code {
            font-size: 11px;
            color: #6c757d;
        }

        /* ── Toggle switch ── */
        .custom-switch .custom-control-label {
            cursor: pointer;
            padding-left: .5rem;
        }

        .custom-switch .custom-control-label::before {
            width: 2.75rem;
            border-radius: 1rem;
            height: 1.25rem;
            top: .1rem;
        }

        .custom-switch .custom-control-label::after {
            width: calc(1.25rem - 4px);
            height: calc(1.25rem - 4px);
            border-radius: 50%;
            top: calc(.1rem + 2px);
            left: calc(-2.75rem + 2px);
        }

        .custom-switch .custom-control-input:checked~.custom-control-label::before {
            background-color: #28a745;
            border-color: #28a745;
        }

        .custom-switch .custom-control-input:checked~.custom-control-label::after {
            transform: translateX(1.5rem);
        }

        .custom-control-input:disabled~.custom-control-label {
            opacity: .5;
            cursor: not-allowed;
        }

        /* ── Submit bar ── */
        .submit-bar {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 2px solid #28a745;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.08);
            z-index: 100;
            margin-top: 0;
        }

        @media (max-width: 576px) {
            .mapping-table {
                min-width: 420px;
            }

            .venue-meta-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('block.includes.navbar')
        @include('block.includes.sidebar')

        @php
            /** @var \App\Models\Venue $venue */
        @endphp

        <div class="content-wrapper">

            {{-- PAGE HEADER --}}
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">SHG – Venue Mapping</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('block.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('cadre.mapping') }}">Venues</a></li>
                                <li class="breadcrumb-item active">SHG Mapping</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif



                    {{-- VENUE INFO CARD --}}
                    <div class="venue-info-card">
                        <div class="card-header" style="position:relative; padding:20px; text-align:center;">
                            <div>
                                <div
                                    style="font-size:11px;opacity:.8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px">
                                    Selected Venue</div>
                                <h2 class="mb-0" style="font-weight:800; font-size:1.8rem;">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $venue->venue_name }}
                                </h2>


                            </div>
                            <a href="{{ route('cadre.mapping') }}" class="btn btn-sm btn-light"
                                style="border-radius:50px; position:absolute; right:20px; top:50%; transform:translateY(-50%); white-space:nowrap;">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Venues
                            </a>
                        </div>
                        <div class="venue-meta-grid">
                            <div class="venue-meta-item">
                                <div class="lbl">Village</div>
                                <div class="val">{{ optional($venue->village)->vill_name ?? 'N/A' }}</div>
                            </div>
                            <div class="venue-meta-item">
                                <div class="lbl">GP / VCDC</div>
                                <div class="val">{{ optional(optional($venue->village)->gp)->gp_name ?? 'N/A' }}</div>
                            </div>
                            <div class="venue-meta-item">
                                <div class="lbl">Capacity</div>
                                <div class="val">
                                    <span class="badge badge-warning p-2">{{ $venue->capacity }}</span>
                                </div>
                            </div>
                            <div class="venue-meta-item">
                                <div class="lbl">Mapped SHGs</div>
                                <div class="val">

                                    <a href="{{ route('mapped.shgs', $venue->id) }}" class="btn btn-info btn-sm"
                                        onclick="window.open(this.href,'ShgWindow','width=1000,height=700,scrollbars=yes,resizable=yes'); return false;">
                                        
                                            <i class="fas fa-users mr-1"></i>
                                            View {{ $mappedShgCount }} Mapped SHG
                                        
                                    </a>
                                </div>
                            </div>
                            <div class="venue-meta-item">
                                <div class="lbl">Assigned Cadre</div>
                                <div class="val">
                                    @if($venue->cadre)
                                        <span class="badge badge-success p-2">
                                            <i class="fas fa-user-check mr-1"></i>{{ $venue->cadre->mem_name }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary p-2">Unassigned</span>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>
                    <form action="{{ route('block.shgmapping.venue.save') }}" method="POST" id="mappingForm">
                        @csrf

                        <input type="hidden" id="currentVenueId" value="{{ $venue->id }}">

                        <input type="hidden" name="venue_id" value="{{ $venue->id }}">

                        <div class="card mapping-card">

                            <div class="card-header">
                                <h5>
                                    <i class="fas fa-link mr-2 text-success"></i>
                                    SHG Venue Mapping
                                </h5>

                                <div class="d-flex align-items-center" style="gap:8px">
                                    <span class="badge badge-success px-3 py-2" id="selectedCountBadge">
                                        0 SHGs Selected
                                    </span>

                                    <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-check-double mr-1"></i>
                                        Select All
                                    </button>

                                    <button type="button" id="clearAllBtn" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-times mr-1"></i>
                                        Clear
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                {{-- FILTER SECTION --}}
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            <i class="fas fa-map-marker-alt text-success mr-1"></i>
                                            GP / VCDC
                                        </label>

                                        <select id="gpSelect" class="form-control">
                                            <option value="">
                                                Select GP
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            <i class="fas fa-home text-success mr-1"></i>
                                            Village
                                        </label>

                                        <select id="villageSelect" class="form-control">
                                            <option value="">
                                                Select Village
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <hr>
                                <div id="locationInfoCard" class="alert alert-success mb-3"
                                    style="display:none;border-radius:12px;">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="font-weight-bold mb-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                GP / VCDC
                                            </div>

                                            <div id="selectedGpName" class="h6 mb-0">
                                                -
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="font-weight-bold mb-1">
                                                <i class="fas fa-home mr-1"></i>
                                                Village
                                            </div>

                                            <div id="selectedVillageName" class="h6 mb-0">
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                {{-- SHG LIST --}}
                                <div id="shgContainer">

                                    <div class="text-center text-muted py-5">

                                        <div style="font-size:52px;margin-bottom:12px">
                                            🔍
                                        </div>

                                        <h5 class="font-weight-bold">
                                            Select GP and Village
                                        </h5>

                                        <p class="mb-0">
                                            SHGs will appear here for mapping.
                                        </p>

                                    </div>

                                </div>

                            </div>

                            {{-- STICKY SAVE BAR --}}
                            <div class="submit-bar">

                                <div>
                                    <i class="fas fa-info-circle text-success mr-1"></i>
                                    <span id="pendingCount" class="font-weight-bold">
                                        0
                                    </span>
                                    SHG(s) selected
                                </div>

                                <button type="submit" class="btn btn-success px-4" style="border-radius:50px">

                                    <i class="fas fa-save mr-1"></i>
                                    Save Mapping

                                </button>

                            </div>

                        </div>
                    </form>



                </div>
            </section>

        </div>

        @include('block.includes.footer')
    </div>
    <script>
        $(document).ready(function () {

            loadGps();

            // ==========================================
            // LOAD GPS
            // ==========================================
            function loadGps() {

                $('#gpSelect').html(
                    '<option value="">Loading GP...</option>'
                );

                $.ajax({
                    url: '/get-gps/{{ auth()->user()->block }}',
                    type: 'GET',

                    success: function (data) {

                        let options =
                            '<option value="">Select GP / VCDC</option>';

                        $.each(data, function (i, gp) {

                            options += `
                        <option value="${gp.gp_id}">
                            ${gp.gp_name}
                        </option>
                    `;
                        });

                        $('#gpSelect').html(options);
                    },

                    error: function () {

                        $('#gpSelect').html(
                            '<option value="">Unable to load GP</option>'
                        );

                    }
                });
            }

            // ==========================================
            // GP -> VILLAGES
            // ==========================================
            $('#gpSelect').on('change', function () {

                let gp_id = $(this).val();
                let gp_name = $('#gpSelect option:selected').text();

                $('#villageSelect').html(
                    '<option value="">Select Village</option>'
                );

                $('#selectedVillageName').text('-');

                $('#shgContainer').html(`
            <div class="text-center text-muted py-5">
                <i class="fas fa-hand-point-up fa-2x mb-2"></i>
                <p>Select a village to load SHGs.</p>
            </div>
        `);

                updateCount();

                if (!gp_id) {

                    $('#selectedGpName').text('-');
                    $('#selectedVillageName').text('-');
                    $('#locationInfoCard').hide();

                    return;
                }

                $('#selectedGpName').text(gp_name);
                $('#locationInfoCard').show();

                $('#villageSelect').html(
                    '<option value="">Loading Villages...</option>'
                );

                $.ajax({
                    url: '/get-villages/' + gp_id,
                    type: 'GET',

                    success: function (data) {

                        let options =
                            '<option value="">Select Village</option>';

                        $.each(data, function (i, village) {

                            options += `
                        <option value="${village.vill_id}">
                            ${village.vill_name}
                        </option>
                    `;
                        });

                        $('#villageSelect').html(options);
                    },

                    error: function () {

                        $('#villageSelect').html(
                            '<option value="">Unable to load villages</option>'
                        );

                    }
                });

            });

            // ==========================================
            // VILLAGE -> SHGs
            // ==========================================
            $('#villageSelect').on('change', function () {

                let vill_id = $(this).val();

                let village_name =
                    $('#villageSelect option:selected').text();

                $('#selectedVillageName').text(
                    vill_id ? village_name : '-'
                );

                updateCount();

                if (!vill_id) {

                    $('#shgContainer').html(`
                <div class="text-center text-muted py-5">
                    <i class="fas fa-hand-point-up fa-2x mb-2"></i>
                    <p>Select a village to load SHGs.</p>
                </div>
            `);

                    return;
                }

                $('#shgContainer').html(`
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-success"></i>
                <div class="mt-2">
                    Loading SHGs...
                </div>
            </div>
        `);

                $.ajax({
                    url: '/get-shg-mapped/' + vill_id,
                    type: 'GET',

                    success: function (data) {

                        if (!data.length) {

                            $('#shgContainer').html(`
                        <div class="alert alert-warning mb-0">
                            No SHGs found for selected village.
                        </div>
                    `);

                            updateCount();

                            return;
                        }

                        let html = `
                    <div class="table-responsive">
                        <table class="table mapping-table mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>SHG Name</th>
                                    <th>SHG Code</th>
                                    <th>Status</th>
                                    <th width="120">Assign</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                        $.each(data, function (i, shg) {

                            const currentVenueId =
                                parseInt($('#currentVenueId').val());

                            let statusHtml = '';
                            let toggleHtml = '';
                            let rowClass = '';

                            // ======================================
                            // ASSIGNED TO SOME VENUE
                            // ======================================
                            if (shg.venue_id) {

                                // --------------------------
                                // ASSIGNED TO CURRENT VENUE
                                // --------------------------
                                if (parseInt(shg.venue_id) === currentVenueId) {

                                    rowClass = 'table-success';

                                    statusHtml = `
                                <span class="badge badge-success p-2">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Assigned To This Venue
                                </span>
                            `;

                                    toggleHtml = `
                                <input
                                    type="hidden"
                                    name="selected_shgs[${shg.shg_code}]"
                                    value="0"
                                >
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input shg-toggle"
                                        id="shg_${shg.shg_code}"
                                        name="selected_shgs[${shg.shg_code}]"
                                        value="1"
                                        checked
                                    >
                                    <label
                                        class="custom-control-label"
                                        for="shg_${shg.shg_code}">
                                    </label>
                                </div>
                                <small class="text-success">
                                    Untoggle to remove
                                </small>
                            `;

                                } else {

                                    // --------------------------
                                    // ASSIGNED TO OTHER VENUE
                                    // --------------------------

                                    rowClass = 'table-danger';

                                    statusHtml = `
                                <span class="badge badge-danger p-2">
                                    <i class="fas fa-lock mr-1"></i>
                                    Assigned to ${shg.venue_name}
                                </span>
                            `;

                                    toggleHtml = `
                                <button
                                    type="button"
                                    class="btn btn-sm btn-secondary"
                                    disabled
                                >
                                    <i class="fas fa-lock mr-1"></i>
                                    Locked
                                </button>
                            `;
                                }

                            } else {

                                // ======================================
                                // AVAILABLE SHG
                                // ======================================

                                rowClass = '';

                                statusHtml = `
                            <span class="badge badge-info p-2">
                                <i class="fas fa-circle mr-1"></i>
                                Available
                            </span>
                        `;

                                toggleHtml = `
                            <input
                                type="hidden"
                                name="selected_shgs[${shg.shg_code}]"
                                value="0"
                            >
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    class="custom-control-input shg-toggle"
                                    id="shg_${shg.shg_code}"
                                    name="selected_shgs[${shg.shg_code}]"
                                    value="1"
                                >
                                <label
                                    class="custom-control-label"
                                    for="shg_${shg.shg_code}">
                                </label>
                            </div>
                        `;
                            }

                            html += `
                        <tr class="${rowClass}">
                            <td class="text-center">
                                ${i + 1}
                            </td>
                            <td>
                                <div class="shg-name">
                                    ${shg.shg_name}
                                </div>
                            </td>
                            <td>
                                <div class="shg-code">
                                    ${shg.shg_code}
                                </div>
                            </td>
                            <td>
                                ${statusHtml}
                            </td>
                            <td>
                                ${toggleHtml}
                            </td>
                        </tr>
                    `;
                        });

                        html += `
                            </tbody>
                        </table>
                    </div>
                `;

                        $('#shgContainer').html(html);

                        updateCount();
                    },

                    error: function () {

                        $('#shgContainer').html(`
                    <div class="alert alert-danger mb-0">
                        Unable to load SHGs.
                    </div>
                `);

                    }
                });

            });

            // ==========================================
            // COUNT SELECTED SHGs
            // ==========================================
            function updateCount() {

                let total =
                    $('.shg-toggle:checked').length;

                $('#selectedCountBadge').text(
                    total + ' SHGs Selected'
                );

                $('#pendingCount').text(total);
            }

            // ==========================================
            // TOGGLE CHANGE
            // ==========================================
            $(document).on(
                'change',
                '.shg-toggle',
                function () {

                    updateCount();

                }
            );

            // ==========================================
            // SELECT ALL AVAILABLE SHGs
            // ==========================================
            $('#selectAllBtn').on('click', function () {

                $('.shg-toggle:not(:disabled)')
                    .prop('checked', true);

                updateCount();

            });

            // ==========================================
            // CLEAR ALL
            // ==========================================
            $('#clearAllBtn').on('click', function () {

                $('.shg-toggle:not(:disabled)')
                    .prop('checked', false);

                updateCount();

            });

        });
    </script>

</body>

</html>