<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Venue Registrations
    </title>

    @include('block.includes.header')

    <style>
        .content-header h1 {
            font-weight: 600;
        }

        .custom-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .custom-card .card-header {
            padding: 14px 20px;
        }

        .custom-card .card-title {
            font-size: 17px;
            font-weight: 600;
            margin: 0;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border-radius: 8px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .save-btn {
            border-radius: 10px;
            padding: 12px 35px;
            font-size: 16px;
            font-weight: 600;
        }

        .section-divider {
            margin-top: 10px;
            margin-bottom: 10px;
            border-top: 1px dashed #ccc;
        }

        .member-assigned-badge {
            font-size: 12px;
            line-height: 1.3;
            margin-bottom: 6px;
        }

        .member-item.selected-member {
            background-color: #d4edda !important;
        }

        .modal-header.bg-primary .close {
            color: #fff;
            opacity: 1;
        }

        #memberSection table thead {
            font-size: 13px;
        }

        #memberSection table tbody tr td {
            font-size: 13px;
            vertical-align: middle;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">

        @include('block.includes.navbar')

        @include('block.includes.sidebar')

        <div class="content-wrapper">

            <div class="content-header">

                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-times-circle"></i> {{ session('error') }}
                        </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Venue Registrations</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('block.dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Venue Registrations</li>
                            </ol>
                        </div>

                    </div>

                </div>

            </div>

            <section class="content">

                <div class="container-fluid">

                    <form action="{{ route('block.venue.store') }}" method="POST" id="venueForm">

                        @csrf

                        <div class="card card-primary card-outline custom-card">

                            <div class="card-header d-flex align-items-center justify-content-between">

                                <h3 class="card-title mb-0">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Venue Details
                                </h3>

                            </div>

                            <div class="card-body">

                                {{-- GP / VILLAGE --}}

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>GP / VCDC</label>
                                            <select name="gp_id" id="gp" class="form-control select2ajax" required>
                                                <option value="">-- Select GP --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Village</label>
                                            <select name="vill_id" id="village" class="form-control select2ajax"
                                                required>
                                                <option value="">-- Select Village --</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="section-divider"></div>

                                {{-- VENUE TABLE --}}

                                <div class="table-responsive">

                                    <table class="table table-bordered table-sm table-hover align-middle"
                                        id="venueTable">

                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th width="6%" class="text-center">Sl No</th>
                                                <th width="35%">Venue Name</th>
                                                <th width="14%">Capacity</th>
                                                <th width="45%" class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="venueWrapper">

                                            <tr class="venue-row">
                                                <td class="serialNo text-center font-weight-bold">1</td>

                                                <td>
                                                    <input type="text" name="venue_name[]" class="form-control"
                                                        placeholder="Venue Name" required>
                                                </td>

                                                <td>
                                                    <input type="number" name="capacity[]" class="form-control"
                                                        placeholder="0" min="1" required>
                                                </td>

                                                <td class="text-center">
                                                    <input type="hidden" name="shg[]" class="rowShg" value="">
                                                    <input type="hidden" name="memberid[]" class="rowMember" value="">

                                                    <div class="member-assigned-badge d-none">
                                                        <span class="badge badge-success py-1 px-2">
                                                            <i class="fas fa-user-check mr-1"></i>
                                                            <span class="badge-member-text"></span>
                                                        </span>
                                                    </div>

                                                    <button type="button"
                                                        class="btn btn-sm btn-primary openModalBtn mt-1">
                                                        <i class="fas fa-user-plus mr-1"></i> Assign
                                                    </button>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                                {{-- ADD ROW BUTTON --}}

                                <div class="mt-2">
                                    <button type="button" id="addRowBtn" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-plus mr-1"></i> Add More Venue
                                    </button>
                                </div>

                            </div>

                        </div>

                        {{-- SUBMIT --}}

                        <div class="text-center mt-4 mb-5">
                            <button type="submit" class="btn btn-success save-btn btn-sm">
                                <i class="fas fa-save mr-2"></i> Save Venue Registration & Assign
                            </button>
                        </div>

                    </form>

                </div>

            </section>

        </div>

        @include('block.includes.footer')

    </div>

    {{-- ASSIGN SHG & MEMBER MODAL --}}

    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="assignModalLabel">
                        <i class="fas fa-users mr-2"></i>Assign SHG &amp; Member
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{-- VILLAGE GP --}}

                    <div class="form-group">
                        <label>GP / VCDC</label>
                        <select id="modalGpSelect" class="form-control">
                            <option value="">-- Select GP --</option>
                        </select>
                    </div>
                    {{-- VILLAGE SELECT --}}
                    <div class="form-group">
                        <label>Village</label>
                        <select id="modalVillageSelect" class="form-control">
                            <option value="">-- Select Village --</option>
                        </select>
                    </div>

                    {{-- SHG SELECT (shown after village selected) --}}

                    <div id="modalShgSection" style="display:none;">
                        <div class="section-divider"></div>
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-sitemap mr-1 text-primary"></i> Select SHG
                            </label>
                            <select id="modalShgSelect" class="form-control">
                                <option value="">-- Select SHG --</option>
                            </select>
                        </div>
                    </div>

                    {{-- MEMBER LIST --}}

                    <div id="memberSection" style="display: none;">

                        <div class="section-divider"></div>

                        <h6 class="font-weight-bold mb-2">
                            <i class="fas fa-users mr-1 text-success"></i> Members List
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th width="8%" class="text-center">Sl No</th>
                                        <th>Member Name</th>
                                        <th width="20%">Member Code</th>
                                        <th width="15%" class="text-center">Select</th>
                                    </tr>
                                </thead>
                                <tbody id="memberListBody">
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div id="modalLoadingMsg" class="text-center text-muted py-2" style="display:none;">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Loading...
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Close
                    </button>

                    <button type="button" id="assignConfirmBtn" class="btn btn-success" disabled>
                        <i class="fas fa-check mr-1"></i> Assign
                    </button>

                </div>

            </div>

        </div>

    </div>

    <script>

        $(document).ready(function () {

            let currentRow = null;
            let selectedShgCode = '';
            let selectedShgName = '';
            let selectedMemberCode = '';
            let selectedMemberName = '';

            // ========================
            // INIT SELECT2
            // ========================

            $('.select2ajax').select2({ width: '100%' });

            // ========================
            // LOAD GPs
            // ========================

            $.ajax({
                url: '/get-gps/{{ auth()->user()->block }}',
                type: 'GET',
                success: function (data) {
                    let opts = '<option value="">-- Select GP --</option>';
                    $.each(data, function (k, item) {
                        opts += `<option value="${item.gp_id}">${item.gp_name}</option>`;
                    });
                    $('#gp').html(opts).trigger('change.select2');
                }
            });

            // ========================
            // GP → VILLAGE
            // ========================

            $('#gp').on('change', function () {
                let gp_id = $(this).val();
                if (!gp_id) {
                    $('#village').html('<option value="">-- Select Village --</option>').trigger('change.select2');
                    return;
                }
                $.ajax({
                    url: '/get-villages/' + gp_id,
                    type: 'GET',
                    success: function (data) {
                        let opts = '<option value="">-- Select Village --</option>';
                        $.each(data, function (k, item) {
                            opts += `<option value="${item.vill_id}">${item.vill_name}</option>`;
                        });
                        $('#village').html(opts).trigger('change.select2');
                    }
                });
            });

            // ========================
            // OPEN MODAL
            // ========================

            $(document).on('click', '.openModalBtn', function () {

                currentRow = $(this).closest('.venue-row');

                selectedShgCode = '';
                selectedShgName = '';
                selectedMemberCode = '';
                selectedMemberName = '';

                $('#memberSection').hide();
                $('#memberListBody').empty();
                $('#modalShgSection').hide();

                $('#modalVillageSelect').html('<option value="">-- Select Village --</option>');
                $('#modalShgSelect').html('<option value="">-- Select SHG --</option>');

                $('#assignConfirmBtn').prop('disabled', true);

                try { $('#modalGpSelect').select2('destroy'); } catch (e) { }
                try { $('#modalVillageSelect').select2('destroy'); } catch (e) { }
                try { $('#modalShgSelect').select2('destroy'); } catch (e) { }

                $('#modalLoadingMsg').show();

                $.ajax({
                    url: '/get-gps/{{ auth()->user()->block }}',
                    type: 'GET',
                    success: function (data) {

                        $('#modalLoadingMsg').hide();

                        let opts = '<option value="">-- Select GP --</option>';

                        $.each(data, function (i, item) {
                            opts += `<option value="${item.gp_id}">${item.gp_name}</option>`;
                        });

                        $('#modalGpSelect').html(opts);

                        $('#modalGpSelect').select2({
                            width: '100%',
                            dropdownParent: $('#assignModal')
                        });

                        $('#modalVillageSelect').select2({
                            width: '100%',
                            dropdownParent: $('#assignModal')
                        });

                        $('#modalShgSelect').select2({
                            width: '100%',
                            dropdownParent: $('#assignModal')
                        });

                        $('#assignModal').modal('show');
                    }
                });

            });

            // ========================
            // MODAL GP → VILLAGE
            // ========================

            $(document).on('change', '#modalGpSelect', function () {

                let gp_id = $(this).val();

                $('#modalVillageSelect').html('<option value="">-- Select Village --</option>');
                $('#modalShgSelect').html('<option value="">-- Select SHG --</option>');

                $('#modalShgSection').hide();
                $('#memberSection').hide();
                $('#memberListBody').empty();

                if (!gp_id) return;

                $('#modalLoadingMsg').show();

                $.ajax({
                    url: '/get-villages/' + gp_id,
                    type: 'GET',
                    success: function (data) {
                        $('#modalLoadingMsg').hide();
                        let opts = '<option value="">-- Select Village --</option>';
                        $.each(data, function (i, item) {
                            opts += `<option value="${item.vill_id}">${item.vill_name}</option>`;
                        });
                        $('#modalVillageSelect').html(opts);
                    },
                    error: function () {
                        $('#modalLoadingMsg').hide();
                        alert('Unable to load villages.');
                    }
                });

            });

            // ========================
            // MODAL VILLAGE → LOAD SHGs
            // ========================

            $(document).on('change', '#modalVillageSelect', function () {

                let vill_id = $(this).val();

                selectedShgCode = '';
                selectedShgName = '';
                selectedMemberCode = '';
                selectedMemberName = '';
                $('#memberSection').hide();
                $('#memberListBody').empty();
                $('#assignConfirmBtn').prop('disabled', true);
                $('#modalShgSection').hide();

                try { $('#modalShgSelect').select2('destroy'); } catch (e) { }
                $('#modalShgSelect').html('<option value="">-- Select SHG --</option>');

                if (!vill_id) return;

                $('#modalLoadingMsg').show();

                $.ajax({
                    url: '/get-shgs/' + vill_id,
                    type: 'GET',
                    success: function (data) {
                        $('#modalLoadingMsg').hide();
                        let opts = '<option value="">-- Select SHG --</option>';
                        $.each(data, function (k, item) {
                            opts += `<option value="${item.shg_code}">${item.shg_name} (${item.shg_code})</option>`;
                        });
                        $('#modalShgSelect').html(opts);
                        $('#modalShgSelect').select2({
                            width: '100%',
                            dropdownParent: $('#assignModal')
                        });

                        let prevShg = currentRow ? currentRow.find('.rowShg').val() : '';
                        if (prevShg) {
                            $('#modalShgSelect').val(prevShg).trigger('change');
                        }

                        $('#modalShgSection').show();
                    },
                    error: function () {
                        $('#modalLoadingMsg').hide();
                        alert('Failed to load SHG list. Please try again.');
                    }
                });

            });

            // ========================
            // SHG → MEMBER LIST
            // ========================

            $(document).on('change', '#modalShgSelect', function () {

                selectedShgCode = $(this).val();
                selectedShgName = $(this).find('option:selected').text();
                selectedMemberCode = '';
                selectedMemberName = '';
                $('#assignConfirmBtn').prop('disabled', true);
                $('#memberSection').hide();
                $('#memberListBody').empty();

                if (!selectedShgCode) return;

                $('#modalLoadingMsg').show();

                $.ajax({
                    url: '/get-members/' + selectedShgCode,
                    type: 'GET',
                    success: function (data) {
                        $('#modalLoadingMsg').hide();

                        if (!data || data.length === 0) {
                            $('#memberListBody').html(
                                '<tr><td colspan="4" class="text-center text-muted">No members found for this SHG.</td></tr>'
                            );
                            $('#memberSection').show();
                            return;
                        }

                        let prevMember = currentRow ? currentRow.find('.rowMember').val() : '';
                        let rows = '';

                        $.each(data, function (i, member) {
                            let isSelected = (member.mem_code == prevMember);
                            rows += `
                            <tr class="member-item ${isSelected ? 'selected-member' : ''}"
                                data-code="${member.mem_code}"
                                data-name="${member.mem_name}">
                                <td class="text-center">${i + 1}</td>
                                <td>${member.mem_name}</td>
                                <td>${member.mem_code}</td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-sm selectMemberBtn ${isSelected ? 'btn-success' : 'btn-outline-primary'}">
                                        <i class="fas ${isSelected ? 'fa-check-circle' : 'fa-check'} mr-1"></i>
                                        ${isSelected ? 'Selected' : 'Select'}
                                    </button>
                                </td>
                            </tr>
                        `;
                            if (isSelected) {
                                selectedMemberCode = member.mem_code;
                                selectedMemberName = member.mem_name;
                            }
                        });

                        $('#memberListBody').html(rows);
                        $('#memberSection').show();

                        if (selectedMemberCode) {
                            $('#assignConfirmBtn').prop('disabled', false);
                        }
                    },
                    error: function () {
                        $('#modalLoadingMsg').hide();
                        alert('Failed to load member list. Please try again.');
                    }
                });

            });

            // ========================
            // SELECT MEMBER
            // ========================

            $(document).on('click', '.selectMemberBtn', function () {

                let row = $(this).closest('.member-item');
                selectedMemberCode = row.data('code');
                selectedMemberName = row.data('name');

                $('#memberListBody .member-item')
                    .removeClass('selected-member')
                    .find('.selectMemberBtn')
                    .removeClass('btn-success')
                    .addClass('btn-outline-primary')
                    .html('<i class="fas fa-check mr-1"></i> Select');

                row.addClass('selected-member');
                $(this)
                    .removeClass('btn-outline-primary')
                    .addClass('btn-success')
                    .html('<i class="fas fa-check-circle mr-1"></i> Selected');

                $('#assignConfirmBtn').prop('disabled', false);

            });

            // ========================
            // ASSIGN CONFIRM
            // ========================

            $('#assignConfirmBtn').on('click', function () {

                if (!currentRow || !selectedShgCode || !selectedMemberCode) return;

                currentRow.find('.rowShg').val(selectedShgCode);
                currentRow.find('.rowMember').val(selectedMemberCode);

                currentRow.find('.badge-member-text').text(selectedMemberName);
                currentRow.find('.member-assigned-badge').removeClass('d-none');

                currentRow.find('.openModalBtn')
                    .removeClass('btn-primary')
                    .addClass('btn-success');

                $('#assignModal').modal('hide');

            });

            // ========================
            // ADD MORE VENUE ROW
            // ========================

            $('#addRowBtn').on('click', function () {

                let rowCount = $('#venueWrapper .venue-row').length + 1;

                let newRow = `
                <tr class="venue-row">
                    <td class="serialNo text-center font-weight-bold">${rowCount}</td>
                    <td>
                        <input type="text" name="venue_name[]" class="form-control"
                            placeholder="Venue Name" required>
                    </td>
                    <td>
                        <input type="number" name="capacity[]" class="form-control"
                            placeholder="0" min="1" required>
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="shg[]" class="rowShg" value="">
                        <input type="hidden" name="memberid[]" class="rowMember" value="">
                        <div class="member-assigned-badge d-none mb-1">
                            <span class="badge badge-success py-1 px-2">
                                <i class="fas fa-user-check mr-1"></i>
                                <span class="badge-member-text"></span>
                            </span>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary openModalBtn mt-1">
                            <i class="fas fa-user-plus mr-1"></i> Assign
                        </button>
                        <button type="button" class="btn btn-sm btn-danger removeRowBtn mt-1 ml-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;

                $('#venueWrapper').append(newRow);
                updateSerials();

            });

            // ========================
            // REMOVE ROW
            // ========================

            $(document).on('click', '.removeRowBtn', function () {
                $(this).closest('.venue-row').remove();
                updateSerials();
            });

            // ========================
            // UPDATE SERIAL NUMBERS
            // ========================

            function updateSerials() {
                $('#venueWrapper .venue-row').each(function (i) {
                    $(this).find('.serialNo').text(i + 1);
                });
            }

            // ==========================================
            // SAVE BUTTON - AJAX VALIDATION
            // ==========================================
            $(document).on('click', '.save-btn', function (e) {
                e.preventDefault();

                const villageId = $('#village').val();
                const $btn = $(this);

                // Guard: GP must be selected
                if (!$('#gp').val()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select GP',
                        text: 'Please select a GP / VCDC before saving.',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                // Guard: village must be selected
                if (!villageId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Village',
                        text: 'Please select a village before saving.',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                // Guard: validate all venue rows
                let rowErrors = [];
                $('#venueWrapper .venue-row').each(function (i) {
                    let venueName = $(this).find('input[name="venue_name[]"]').val().trim();
                    let capacity = $(this).find('input[name="capacity[]"]').val();
                    let shg = $(this).find('.rowShg').val();
                    let member = $(this).find('.rowMember').val();

                    if (!venueName) {
                        rowErrors.push('Row ' + (i + 1) + ': Venue Name is required.');
                    }
                    if (!capacity || parseInt(capacity) < 1) {
                        rowErrors.push('Row ' + (i + 1) + ': Capacity must be at least 1.');
                    }
                    if (!shg || !member) {
                        rowErrors.push('Row ' + (i + 1) + ': Please assign an SHG & Member.');
                    }
                });

                if (rowErrors.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Details',
                        html: rowErrors.join('<br>'),
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                // Collect member codes from all rows
                let memberCodes = [];
                $('#venueWrapper .venue-row').each(function () {
                    let member = $(this).find('.rowMember').val();
                    if (member) {
                        memberCodes.push(member);
                    }
                });

                // Disable button to prevent double submit
                $btn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin mr-2"></i> Checking...');

                // ==========================================
                // STEP 1 — CHECK IF VILLAGE ALREADY HAS VENUE
                // ==========================================
                $.ajax({
                    url: '/check-village-venue',
                    type: 'POST',
                    data: {
                        village_id: villageId,
                        member_codes: memberCodes,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },

                    success: function (response) {

                        if (response.exists) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Already Registered!',
                                text: response.message,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK',
                            });

                            $btn.prop('disabled', false)
                                .html('<i class="fas fa-save mr-2"></i> Save Venue Registration & Assign');

                        } else {

                            // ==========================================
                            // STEP 2 — CHECK IF MEMBER ALREADY MONITORS
                            // ==========================================
                            $.ajax({
                                url: '/check-venue-monitor',
                                type: 'POST',
                                data: {
                                    village_id: villageId,
                                    member_codes: memberCodes,
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                },

                                success: function (response) {

                                    if (response.already_mapped) {

                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Member Already Mapped!',
                                            text: response.message,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                        });

                                        $btn.prop('disabled', false)
                                            .html('<i class="fas fa-save mr-2"></i> Save Venue Registration & Assign');

                                    } else {

                                        // ==========================================
                                        // STEP 3 — ALL CLEAR, SUBMIT FORM
                                        // ==========================================
                                        $btn.closest('form').submit();

                                    }
                                },

                                error: function (xhr) {

                                    let errorMsg = 'Unable to verify venue monitor.';
                                    try {
                                        let res = JSON.parse(xhr.responseText);
                                        errorMsg = res.message + (res.line ? ' (Line: ' + res.line + ')' : '');
                                    } catch (e) {
                                        errorMsg = xhr.responseText;
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error ' + xhr.status,
                                        text: errorMsg,
                                        confirmButtonColor: '#d33',
                                    });

                                    $btn.prop('disabled', false)
                                        .html('<i class="fas fa-save mr-2"></i> Save Venue Registration & Assign');
                                }
                            });
                        }
                    },

                    error: function (xhr) {

                        let errorMsg = 'Unable to verify village venue.';
                        try {
                            let res = JSON.parse(xhr.responseText);
                            errorMsg = res.message + (res.line ? ' (Line: ' + res.line + ')' : '');
                        } catch (e) {
                            errorMsg = xhr.responseText;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error ' + xhr.status,
                            text: errorMsg,
                            confirmButtonColor: '#d33',
                        });

                        $btn.prop('disabled', false)
                            .html('<i class="fas fa-save mr-2"></i> Save Venue Registration & Assign');
                    }
                });

            }); // END SAVE BUTTON

        }); // END document.ready  ← THIS WAS MISSING

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>