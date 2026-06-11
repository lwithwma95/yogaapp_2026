<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Venue Mapping
    </title>

    @include('block.includes.header')

    <style>
        /* ── Modal/edit helpers (unchanged) ── */
        .assign-badge {
            font-size: 12px;
            line-height: 1.4;
        }

        .edit-venue-row.editing-active {
            background-color: #fff3cd !important;
        }

        .member-item.selected-member {
            background-color: #d4edda !important;
        }

        .modal-header.bg-warning .close {
            color: #212529;
            opacity: 1;
        }

        #editAssignSection {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            border: 1px dashed #ced4da;
        }

        #editModal .modal-body {
            max-height: 65vh;
            overflow-y: auto;
        }

        #editCadreModal .modal-body {
            max-height: 65vh;
            overflow-y: auto;
        }

        #editMemberSection .table-responsive {
            max-height: 200px;
            overflow-y: auto;
        }

        #editMemberSection .table-responsive thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .section-divider {
            border-top: 1px dashed #ccc;
            margin: 12px 0;
        }

        /* ── Stat cards ── */
        .vm-stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
            transition: transform .15s, box-shadow .15s;
        }

        .vm-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .11);
        }

        .vm-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .vm-stat-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
        }

        .vm-stat-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            margin-top: 3px;
        }

        /* ── Main table card ── */
        .vm-main-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .vm-main-card>.card-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #1565a0 60%, #1e88c8 100%);
            color: #fff;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            border-bottom: none;
        }

        .vm-main-card>.card-header h5 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
        }

        .vm-main-card>.card-body {
            padding: 0;
        }

        /* ── Table ── */
        .vm-table thead th {
            background: #f0f4f8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 10px 12px;
        }

        .vm-table tbody td {
            vertical-align: middle;
            padding: 10px 12px;
            font-size: 13px;
        }

        .vm-table tbody tr:hover {
            background-color: #f5f8ff !important;
        }

        .vm-venue-name {
            font-weight: 700;
            font-size: 14px;
            color: #212529;
        }

        .vm-venue-gp {
            font-size: 11px;
            color: #868e96;
            margin-top: 2px;
        }

        .vm-action-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }
        .edit-venue-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    background: #fff8e1;
    border: 1px solid #ffc107;
    border-radius: 5px;
    color: #e6a800;
    font-size: 0.68rem;
    text-decoration: none;
    vertical-align: middle;
    transition: all 0.2s ease;
}

.edit-venue-btn:hover {
    background: #ffc107;
    color: #ffffff;
    text-decoration: none;
    transform: scale(1.1);
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

                    <div class="row mb-2">

                        <div class="col-sm-6">
                            <h1 class="m-0">Venue Mapping</h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('block.dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Venue Mapping
                                </li>
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $totalVenues = $venues->count();
                        $assignedCadre = $venues->filter(fn($v) => $v->cadre !== null)->count();
                        $unassignedCadre = $totalVenues - $assignedCadre;
                    @endphp

                    {{-- Summary Stats --}}
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                            <div class="card vm-stat-card">
                                <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                    <div class="vm-stat-icon" style="background:rgba(30,136,200,.12)">
                                        <i class="fas fa-map-marker-alt" style="color:#1e88c8"></i>
                                    </div>
                                    <div>
                                        <div class="vm-stat-value" style="color:#1e88c8">{{ $totalVenues }}</div>
                                        <div class="vm-stat-label">Total Venues</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                            <div class="card vm-stat-card">
                                <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                    <div class="vm-stat-icon" style="background:rgba(40,167,69,.12)">
                                        <i class="fas fa-user-check text-success"></i>
                                    </div>
                                    <div>
                                        <div class="vm-stat-value text-success">{{ $assignedCadre }}</div>
                                        <div class="vm-stat-label">Cadre Assigned</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                            <div class="card vm-stat-card">
                                <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                    <div class="vm-stat-icon" style="background:rgba(220,53,69,.12)">
                                        <i class="fas fa-user-times text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="vm-stat-value text-danger">{{ $unassignedCadre }}</div>
                                        <div class="vm-stat-label">Cadre Not Assigned</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Main Venue Table --}}
                    <div class="card vm-main-card">

                        <div class="card-header">
                            <h5><i class="fas fa-map-marker-alt mr-2"></i>Venue List</h5>
                            <span class="badge badge-light text-dark px-2 py-1" style="font-size:12px">
                                {{ $totalVenues }} Venue{{ $totalVenues !== 1 ? 's' : '' }}
                            </span>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="cadreTable" class="table table-bordered table-hover vm-table mb-0">

                                    <thead>
                                        <tr>
                                            <th  class="text-center">#</th>
                                            <th>GP/VCDC</th>
                                            <th >Village</th>
                                            <th>Venue Name</th>
                                            <th  class="text-center">Capacity</th>
                                            <th  class="text-center">Reg. Members</th>
                                            <th class="text-center">Cadre</th>
                                            <th class="text-center">Venue Photo</th>
                                            <th class="text-center">User Id</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($venues as $venue)

                                            <tr class="{{ !$venue->cadre ? 'table-warning' : '' }}">
                                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                                <td>{{ $venue->gp_name ?? 'N/A' }}</td>
                                                <td>{{ optional($venue->village)->vill_name ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="vm-venue-name">
                                                        {{ $venue->venue_name }}
                                                        <a href="{{ route('edit.venue', $venue->id) }}"
                                                        class="edit-venue-btn ml-1"
                                                        title="Edit Venue">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                    <div class="vm-venue-gp">
                                                        {{ optional(optional($venue->village)->gp)->gp_name ?? '' }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-secondary px-2 py-1">{{ $venue->capacity }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-secondary px-2 py-1">{{ $venue->registered_member_count }}</span>
                                                </td>
                                                <td>
                                                    @if($venue->cadre)
                                                        <div class="font-weight-bold" style="font-size:13px">
                                                            {{ $venue->cadre->mem_name }}</div>
                                                    @else
                                                        <span class="text-muted" style="font-size:13px">—</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($venue->photo)
                                                        @php /** @var \Illuminate\Filesystem\FilesystemAdapter $s3disk */ $s3disk = Storage::disk('s3');
                                                        $photoUrl = $s3disk->temporaryUrl($venue->photo, now()->addMinutes(30)); @endphp
                                                        <span class="badge badge-success px-2 py-1" style="font-size:11px">
                                                            <i class="fas fa-check-circle mr-1"></i>Uploaded
                                                        </span>
                                                        <br>
                                                        <a href="{{ $photoUrl }}" target="_blank"
                                                            class="btn btn-outline-info btn-sm mt-1" style="font-size:11px">
                                                            <i class="fas fa-eye mr-1"></i>View Photo
                                                        </a>
                                                    @else
                                                        <span class="badge badge-danger px-2 py-1" style="font-size:11px">
                                                            <i class="fas fa-times-circle mr-1"></i>Not Uploaded
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $cadreNameMap->get($venue->monitored_by) ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="vm-action-wrap justify-content-center">
                                                        <a href="{{ route('block.shgmapping.venue', $venue->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fas fa-link mr-1"></i> Map SHG
                                                        </a>
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal" data-target="#editCadreModal"
                                                            data-venue-id="{{ $venue->id }}"
                                                            data-venue-name="{{ $venue->venue_name }}"
                                                            data-capacity="{{ $venue->capacity }}"
                                                            data-gp-id="{{ optional(optional($venue->village)->gp)->gp_id ?? '' }}"
                                                            data-vill-id="{{ $venue->village_id }}"
                                                            data-cadre-code="{{ $venue->cadre->mem_code ?? '' }}"
                                                            data-cadre-name="{{ $venue->cadre->mem_name ?? 'None' }}">
                                                            <i class="fas fa-user-edit mr-1"></i> Cadre
                                                        </button>
                                                        <a href="{{ route('mapped.reg.member', [
                                                                $venue->gp_name,
                                                                $venue->village->vill_name,
                                                                $venue->venue_name,
                                                                $venue->id
                                                            ]) }}" class="btn btn-info btn-sm"
                                                        onclick="window.open(this.href,'MemberWindow','width=1000,height=700,scrollbars=yes,resizable=yes'); return false;">
                                                            
                                                                <i class="fas fa-eye mr-1"></i> View List
                                                           
                                                        </a>
                                                        <form action="{{ route('block.venue.delete') }}" method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Delete this venue and remove cadre credentials for {{ addslashes($venue->cadre->mem_name ?? $venue->venue_name) }}?')">
                                                            @csrf
                                                            <input type="hidden" name="venue_id" value="{{ $venue->id }}">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

        @include('block.includes.footer')

    </div>

    {{-- EDIT CADRE MODAL --}}
    <div class="modal fade" id="editCadreModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark">
                        <i class="fas fa-edit mr-2"></i>Change Cadre &mdash;
                        <span id="editCadreModalTitle" class="font-weight-bold"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('block.venue.update-cadre') }}" method="POST">
                    @csrf
                    <input type="hidden" name="venue_id" id="editCadreVenueId">
                    <input type="hidden" name="mem_code" id="editCadreMemCode">
                    <div class="modal-body">

                        {{-- VENUE INFO ROW --}}
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="small font-weight-bold text-muted text-uppercase">Venue</label>
                                <p id="editCadreVenueName" class="mb-0 font-weight-bold"></p>
                            </div>
                            <div class="col-md-3">
                                <label class="small font-weight-bold text-muted text-uppercase">Capacity</label>
                                <p id="editCadreCapacity" class="mb-0"></p>
                            </div>
                            <div class="col-md-4">
                                <label class="small font-weight-bold text-muted text-uppercase">Current Cadre</label>
                                <p id="editCadreCurrent" class="mb-0 text-primary font-weight-bold"></p>
                            </div>
                        </div>

                        <hr class="mt-0">

                        {{-- VILLAGE SELECT --}}
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-map-marker-alt mr-1 text-danger"></i> Select Village
                            </label>
                            <select id="editModalVillageSelect" class="form-control">
                                <option value="">Loading...</option>
                            </select>
                        </div>

                        {{-- SHG SELECT --}}
                        <div id="editModalShgSection" style="display:none;">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-sitemap mr-1 text-primary"></i> Select SHG
                                </label>
                                <select id="editModalShgSelect" class="form-control">
                                    <option value="">-- Select SHG --</option>
                                </select>
                            </div>
                        </div>

                        {{-- MEMBER LIST --}}
                        <div id="editModalMemberSection" style="display:none;">
                            <label class="font-weight-bold">
                                <i class="fas fa-users mr-1 text-success"></i> Select Member
                            </label>
                            <div class="table-responsive" style="max-height:220px;overflow-y:auto;">
                                <table class="table table-bordered table-sm table-hover">
                                    <thead class="bg-secondary text-white" style="position:sticky;top:0;z-index:1;">
                                        <tr>
                                            <th width="8%" class="text-center">Sl No</th>
                                            <th>Member Name</th>
                                            <th width="22%">Code</th>
                                            <th width="18%" class="text-center">Select</th>
                                        </tr>
                                    </thead>
                                    <tbody id="editModalMemberBody"></tbody>
                                </table>
                            </div>
                            <p id="editModalSelectedLabel" class="mt-2 mb-0 text-success font-weight-bold"
                                style="display:none;">
                                <i class="fas fa-check-circle mr-1"></i> Selected: <span
                                    id="editModalSelectedName"></span>
                            </p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="editCadreSubmitBtn" class="btn btn-warning" disabled>
                            <i class="fas fa-save mr-1"></i> Update Cadre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT VENUE MODAL --}}

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark">
                        <i class="fas fa-edit mr-2"></i>Edit Venue Assignment &mdash;
                        <span id="editModalMemberName" class="font-weight-bold"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="editVenueForm" action="{{ route('block.venue.update') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        {{-- LOADING --}}
                        <div id="editLoadingMsg" class="text-center text-muted py-3">
                            <i class="fas fa-spinner fa-spin mr-1"></i> Loading venues...
                        </div>

                        {{-- VENUES TABLE --}}
                        <div id="editVenueTableWrapper" style="display:none;">

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-hover align-middle">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="5%" class="text-center">Sl No</th>
                                            <th width="18%">Village</th>
                                            <th width="27%">Venue Name</th>
                                            <th width="10%">Capacity</th>
                                            <th>Assigned SHG &amp; Member</th>
                                        </tr>
                                    </thead>
                                    <tbody id="editVenueBody">
                                    </tbody>
                                </table>
                            </div>

                            {{-- INLINE ASSIGN SECTION (shown when Change is clicked) --}}
                            <div id="editAssignSection" style="display:none;">

                                <div class="section-divider"></div>

                                <h6 class="font-weight-bold mb-3">
                                    <i class="fas fa-sitemap mr-1 text-primary"></i>
                                    Change SHG &amp; Member for:
                                    <span id="editSectionRowLabel" class="text-primary"></span>
                                </h6>

                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-map-marker-alt mr-1 text-danger"></i> Select Village
                                    </label>
                                    <select id="editVillageSelect" class="form-control">
                                        <option value="">-- Select Village --</option>
                                    </select>
                                </div>

                                <div id="editShgSection" style="display:none;">
                                    <div class="section-divider"></div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            <i class="fas fa-sitemap mr-1 text-primary"></i> Select SHG
                                        </label>
                                        <select id="editShgSelect" class="form-control">
                                            <option value="">-- Select SHG --</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="editMemberSection" style="display:none;">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-users mr-1 text-success"></i> Members List
                                    </label>
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
                                            <tbody id="editMemberListBody"></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="text-right mt-2">
                                    <button type="button" id="editCancelAssignBtn"
                                        class="btn btn-outline-secondary btn-sm mr-2">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </button>
                                    <button type="button" id="editAssignConfirmBtn" class="btn btn-success btn-sm"
                                        disabled>
                                        <i class="fas fa-check mr-1"></i> Assign to Row
                                    </button>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" id="saveVenueChangesBtn" class="btn btn-primary" style="display:none;">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>

        $(document).ready(function () {

            // ========================
            // EDIT CADRE MODAL
            // ========================

            let editCadreSelectedMem = { code: '', name: '' };

            $('#editCadreModal').on('show.bs.modal', function (e) {
                let btn = $(e.relatedTarget);

                // Reset state
                editCadreSelectedMem = { code: '', name: '' };
                $('#editCadreVenueId').val(btn.data('venue-id'));
                $('#editCadreMemCode').val('');
                $('#editCadreModalTitle').text(btn.data('venue-name'));
                $('#editCadreVenueName').text(btn.data('venue-name'));
                $('#editCadreCapacity').text(btn.data('capacity'));
                $('#editCadreCurrent').text(btn.data('cadre-name'));
                $('#editModalShgSection').hide();
                $('#editModalMemberSection').hide();
                $('#editModalMemberBody').empty();
                $('#editModalSelectedLabel').hide();
                $('#editCadreSubmitBtn').prop('disabled', true);

                // Load villages for this GP
                try { $('#editModalVillageSelect').select2('destroy'); } catch (ex) { }
                $('#editModalVillageSelect').html('<option value="">Loading villages...</option>');

                let gpId = btn.data('gp-id');
                let villId = btn.data('vill-id');

                $.get('/get-villages/' + gpId, function (data) {
                    let opts = '<option value="">-- Select Village --</option>';
                    data.forEach(function (item) {
                        let sel = (item.vill_id == villId) ? 'selected' : '';
                        opts += `<option value="${item.vill_id}" ${sel}>${item.vill_name}</option>`;
                    });
                    $('#editModalVillageSelect').html(opts).select2({
                        width: '100%',
                        dropdownParent: $('#editCadreModal')
                    });
                    // Auto-trigger SHG load for pre-selected village
                    if (villId) {
                        $('#editModalVillageSelect').trigger('change');
                    }
                });
            });

            $(document).on('change', '#editModalVillageSelect', function () {
                let villId = $(this).val();
                $('#editModalShgSection').hide();
                $('#editModalMemberSection').hide();
                $('#editModalMemberBody').empty();
                $('#editModalSelectedLabel').hide();
                editCadreSelectedMem = { code: '', name: '' };
                $('#editCadreMemCode').val('');
                $('#editCadreSubmitBtn').prop('disabled', true);

                try { $('#editModalShgSelect').select2('destroy'); } catch (ex) { }
                $('#editModalShgSelect').html('<option value="">-- Select SHG --</option>');

                if (!villId) return;

                $.get('/get-shgs/' + villId, function (data) {
                    let opts = '<option value="">-- Select SHG --</option>';
                    data.forEach(function (item) {
                        opts += `<option value="${item.shg_code}">${item.shg_name} (${item.shg_code})</option>`;
                    });
                    $('#editModalShgSelect').html(opts).select2({
                        width: '100%',
                        dropdownParent: $('#editCadreModal')
                    });
                    $('#editModalShgSection').show();
                });
            });

            $(document).on('change', '#editModalShgSelect', function () {
                let shgCode = $(this).val();
                $('#editModalMemberSection').hide();
                $('#editModalMemberBody').empty();
                $('#editModalSelectedLabel').hide();
                editCadreSelectedMem = { code: '', name: '' };
                $('#editCadreMemCode').val('');
                $('#editCadreSubmitBtn').prop('disabled', true);

                if (!shgCode) return;

                $.get('/get-members/' + shgCode, function (data) {
                    if (!data || data.length === 0) {
                        $('#editModalMemberBody').html(
                            '<tr><td colspan="4" class="text-center text-muted">No members found.</td></tr>'
                        );
                        $('#editModalMemberSection').show();
                        return;
                    }
                    let rows = '';
                    data.forEach(function (m, i) {
                        rows += `
                            <tr class="editModalMemberRow"
                                data-code="${m.mem_code}" data-name="${escapeHtml(m.mem_name)}">
                                <td class="text-center">${i + 1}</td>
                                <td>${escapeHtml(m.mem_name)}</td>
                                <td>${m.mem_code}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary editModalSelectMemberBtn">
                                        <i class="fas fa-check mr-1"></i> Select
                                    </button>
                                </td>
                            </tr>`;
                    });
                    $('#editModalMemberBody').html(rows);
                    $('#editModalMemberSection').show();
                });
            });

            $(document).on('click', '.editModalSelectMemberBtn', function () {
                let row = $(this).closest('.editModalMemberRow');
                editCadreSelectedMem.code = row.data('code');
                editCadreSelectedMem.name = row.data('name');

                $('.editModalMemberRow').removeClass('table-success')
                    .find('.editModalSelectMemberBtn')
                    .removeClass('btn-success').addClass('btn-outline-primary')
                    .html('<i class="fas fa-check mr-1"></i> Select');

                row.addClass('table-success');
                $(this).removeClass('btn-outline-primary').addClass('btn-success')
                    .html('<i class="fas fa-check-circle mr-1"></i> Selected');

                $('#editCadreMemCode').val(editCadreSelectedMem.code);
                $('#editModalSelectedName').text(editCadreSelectedMem.name);
                $('#editModalSelectedLabel').show();
                $('#editCadreSubmitBtn').prop('disabled', false);
            });

            $('#editCadreModal').on('hidden.bs.modal', function () {
                editCadreSelectedMem = { code: '', name: '' };
                try { $('#editModalVillageSelect').select2('destroy'); } catch (ex) { }
                try { $('#editModalShgSelect').select2('destroy'); } catch (ex) { }
            });

            // ========================
            // DATATABLE
            // ========================

            $('#cadreTable').DataTable({
                responsive: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Cadre_Mapping_Report',
                        text: '<i class="fas fa-file-excel"></i> Export Excel',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm'
                    }
                ]
            });

            // ========================
            // EDIT STATE
            // ========================

            let editCurrentRow = null;
            let editSelectedShg = { code: '', name: '' };
            let editSelectedMember = { code: '', name: '' };

            // ========================
            // OPEN EDIT MODAL
            // ========================

            $(document).on('click', '.editCadreBtn', function () {

                let memCode = $(this).data('mem-code');
                let memName = $(this).data('mem-name');

                // Reset
                editCurrentRow = null;
                editSelectedShg = { code: '', name: '' };
                editSelectedMember = { code: '', name: '' };
                $('#editVenueBody').empty();
                $('#editAssignSection').hide();
                $('#editMemberSection').hide();
                $('#editMemberListBody').empty();
                $('#editAssignConfirmBtn').prop('disabled', true);
                $('#editVenueTableWrapper').hide();
                $('#saveVenueChangesBtn').hide();
                $('#editLoadingMsg').show();
                $('#editModalMemberName').text(memName + ' (' + memCode + ')');

                $('#editModal').modal('show');

                // Load venues for this member
                $.ajax({
                    url: '{{ route("block.venue.by-member", ":mem") }}'.replace(':mem', memCode),
                    type: 'GET',
                    success: function (venues) {
                        $('#editLoadingMsg').hide();

                        if (!venues || venues.length === 0) {
                            $('#editVenueBody').html(
                                '<tr><td colspan="5" class="text-center text-muted">No venues found.</td></tr>'
                            );
                            $('#editVenueTableWrapper').show();
                            return;
                        }

                        let rows = '';
                        venues.forEach(function (v, i) {
                            rows += `
                                <tr class="edit-venue-row" data-venue-id="${v.id}"
                                    data-gp-id="${v.gp_id}"
                                    data-vill-id="${v.village_id}"
                                    data-venue-name="${escapeHtml(v.venue_name)}">
                                    <td class="text-center font-weight-bold">${i + 1}</td>
                                    <td><small class="text-muted">${escapeHtml(v.village_name)}</small></td>
                                    <td>
                                        <input type="hidden" name="venue_ids[]" value="${v.id}">
                                        <input type="text" name="venue_name[]"
                                            class="form-control form-control-sm"
                                            value="${escapeHtml(v.venue_name)}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="capacity[]"
                                            class="form-control form-control-sm"
                                            value="${v.capacity}" min="1" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="shg[]" class="editRowShg" value="${v.shg_code}">
                                        <input type="hidden" name="memberid[]" class="editRowMember" value="${v.monitored_by}">
                                        <div class="assign-badge mb-1">
                                            <span class="badge badge-info py-1 px-2 editBadgeShg">
                                                <i class="fas fa-sitemap mr-1"></i>${escapeHtml(v.shg_name)}
                                            </span><br>
                                            <small class="text-muted editBadgeMember">
                                                Member: ${escapeHtml(v.monitored_by)}
                                            </small>
                                        </div>
                                        <button type="button"
                                            class="btn btn-sm btn-warning editChangeBtn mt-1">
                                            <i class="fas fa-exchange-alt mr-1"></i> Change
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });

                        $('#editVenueBody').html(rows);
                        $('#editVenueTableWrapper').show();
                        $('#saveVenueChangesBtn').show();
                    },
                    error: function () {
                        $('#editLoadingMsg').hide().text('');
                        $('#editVenueBody').html(
                            '<tr><td colspan="5" class="text-center text-danger">Failed to load venue data.</td></tr>'
                        );
                        $('#editVenueTableWrapper').show();
                    }
                });

            });

            // ========================
            // CHANGE SHG/MEMBER BUTTON
            // ========================

            $(document).on('click', '.editChangeBtn', function () {

                // Highlight this row, de-highlight others
                $('.edit-venue-row').removeClass('editing-active');
                editCurrentRow = $(this).closest('.edit-venue-row');
                editCurrentRow.addClass('editing-active');

                let gpId = editCurrentRow.data('gp-id');
                let villId = editCurrentRow.data('vill-id');
                let venueName = editCurrentRow.data('venue-name');

                // Reset assign section
                editSelectedShg = { code: '', name: '' };
                editSelectedMember = { code: '', name: '' };
                $('#editAssignConfirmBtn').prop('disabled', true);
                $('#editMemberSection').hide();
                $('#editMemberListBody').empty();
                $('#editShgSection').hide();
                $('#editShgSelect').html('<option value="">-- Select SHG --</option>');
                $('#editSectionRowLabel').text(venueName);

                // Destroy existing select2 instances
                try { $('#editVillageSelect').select2('destroy'); } catch (e) { }
                try { $('#editShgSelect').select2('destroy'); } catch (e) { }

                // Load villages for this venue's GP
                $.ajax({
                    url: '/get-villages/' + gpId,
                    type: 'GET',
                    success: function (data) {
                        let opts = '<option value="">-- Select Village --</option>';
                        data.forEach(function (item) {
                            let sel = item.vill_id == villId ? 'selected' : '';
                            opts += `<option value="${item.vill_id}" ${sel}>${item.vill_name}</option>`;
                        });
                        $('#editVillageSelect').html(opts);
                        $('#editVillageSelect').select2({
                            width: '100%',
                            dropdownParent: $('#editModal')
                        });

                        $('#editAssignSection').show();

                        // Auto-trigger SHG load with pre-selected village
                        if (villId) {
                            $('#editVillageSelect').trigger('change');
                        }

                        $('#editAssignSection')[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    },
                    error: function () {
                        alert('Failed to load village list. Please try again.');
                    }
                });

            });

            // ========================
            // EDIT VILLAGE → LOAD SHGs
            // ========================

            $(document).on('change', '#editVillageSelect', function () {

                let vill_id = $(this).val();

                editSelectedShg = { code: '', name: '' };
                editSelectedMember = { code: '', name: '' };
                $('#editAssignConfirmBtn').prop('disabled', true);
                $('#editMemberSection').hide();
                $('#editMemberListBody').empty();
                $('#editShgSection').hide();

                try { $('#editShgSelect').select2('destroy'); } catch (e) { }
                $('#editShgSelect').html('<option value="">-- Select SHG --</option>');

                if (!vill_id) return;

                let currentShg = editCurrentRow ? editCurrentRow.find('.editRowShg').val() : '';

                $.ajax({
                    url: '/get-shgs/' + vill_id,
                    type: 'GET',
                    success: function (data) {
                        let opts = '<option value="">-- Select SHG --</option>';
                        data.forEach(function (item) {
                            let sel = item.shg_code == currentShg ? 'selected' : '';
                            opts += `<option value="${item.shg_code}" ${sel}>${item.shg_name} (${item.shg_code})</option>`;
                        });
                        $('#editShgSelect').html(opts);
                        $('#editShgSelect').select2({
                            width: '100%',
                            dropdownParent: $('#editModal')
                        });
                        $('#editShgSection').show();

                        // Auto-trigger member load if SHG was pre-selected
                        if (currentShg) {
                            $('#editShgSelect').trigger('change');
                        }
                    },
                    error: function () {
                        alert('Failed to load SHG list. Please try again.');
                    }
                });

            });

            // ========================
            // EDIT SHG → MEMBERS
            // ========================

            $(document).on('change', '#editShgSelect', function () {

                editSelectedShg.code = $(this).val();
                editSelectedShg.name = $(this).find('option:selected').text();
                editSelectedMember = { code: '', name: '' };
                $('#editAssignConfirmBtn').prop('disabled', true);
                $('#editMemberListBody').empty();
                $('#editMemberSection').hide();

                if (!editSelectedShg.code) return;

                let currentMember = editCurrentRow ? editCurrentRow.find('.editRowMember').val() : '';

                $.ajax({
                    url: '/get-members/' + editSelectedShg.code,
                    type: 'GET',
                    success: function (data) {
                        if (!data || data.length === 0) {
                            $('#editMemberListBody').html(
                                '<tr><td colspan="4" class="text-center text-muted">No members found.</td></tr>'
                            );
                            $('#editMemberSection').show();
                            return;
                        }

                        let rows = '';
                        data.forEach(function (m, i) {
                            let isSelected = (m.mem_code == currentMember);
                            if (isSelected) {
                                editSelectedMember = { code: m.mem_code, name: m.mem_name };
                            }
                            rows += `
                                <tr class="member-item ${isSelected ? 'selected-member' : ''}"
                                    data-code="${m.mem_code}" data-name="${escapeHtml(m.mem_name)}">
                                    <td class="text-center">${i + 1}</td>
                                    <td>${escapeHtml(m.mem_name)}</td>
                                    <td>${m.mem_code}</td>
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-sm editSelectMemberBtn ${isSelected ? 'btn-success' : 'btn-outline-primary'}">
                                            <i class="fas ${isSelected ? 'fa-check-circle' : 'fa-check'} mr-1"></i>
                                            ${isSelected ? 'Selected' : 'Select'}
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });

                        $('#editMemberListBody').html(rows);
                        $('#editMemberSection').show();

                        if (editSelectedMember.code) {
                            $('#editAssignConfirmBtn').prop('disabled', false);
                        }
                    }
                });

            });

            // ========================
            // SELECT MEMBER (EDIT)
            // ========================

            $(document).on('click', '.editSelectMemberBtn', function () {

                let row = $(this).closest('.member-item');
                editSelectedMember.code = row.data('code');
                editSelectedMember.name = row.data('name');

                // Clear all
                $('#editMemberListBody .member-item')
                    .removeClass('selected-member')
                    .find('.editSelectMemberBtn')
                    .removeClass('btn-success').addClass('btn-outline-primary')
                    .html('<i class="fas fa-check mr-1"></i> Select');

                // Highlight selected
                row.addClass('selected-member');
                $(this).removeClass('btn-outline-primary').addClass('btn-success')
                    .html('<i class="fas fa-check-circle mr-1"></i> Selected');

                $('#editAssignConfirmBtn').prop('disabled', false);

            });

            // ========================
            // ASSIGN TO ROW
            // ========================

            $('#editAssignConfirmBtn').on('click', function () {

                if (!editCurrentRow || !editSelectedShg.code || !editSelectedMember.code) return;

                // Store in hidden fields
                editCurrentRow.find('.editRowShg').val(editSelectedShg.code);
                editCurrentRow.find('.editRowMember').val(editSelectedMember.code);

                // Update badges
                editCurrentRow.find('.editBadgeShg')
                    .html('<i class="fas fa-sitemap mr-1"></i>' + editSelectedShg.name);
                editCurrentRow.find('.editBadgeMember')
                    .text('Member: ' + editSelectedMember.name + ' (' + editSelectedMember.code + ')');

                // Update change button
                editCurrentRow.find('.editChangeBtn')
                    .removeClass('btn-warning').addClass('btn-success')
                    .html('<i class="fas fa-check-circle mr-1"></i> Changed');

                editCurrentRow.removeClass('editing-active');
                editCurrentRow = null;

                // Hide assign section
                $('#editAssignSection').hide();
                $('#editShgSection').hide();
                try { $('#editVillageSelect').select2('destroy'); } catch (e) { }
                try { $('#editShgSelect').select2('destroy'); } catch (e) { }

            });

            // ========================
            // CANCEL ASSIGN
            // ========================

            $('#editCancelAssignBtn').on('click', function () {
                if (editCurrentRow) {
                    editCurrentRow.removeClass('editing-active');
                    editCurrentRow = null;
                }
                editSelectedShg = { code: '', name: '' };
                editSelectedMember = { code: '', name: '' };
                $('#editAssignSection').hide();
                $('#editShgSection').hide();
                try { $('#editVillageSelect').select2('destroy'); } catch (e) { }
                try { $('#editShgSelect').select2('destroy'); } catch (e) { }
            });

            // ========================
            // RESET ON MODAL CLOSE
            // ========================

            $('#editModal').on('hidden.bs.modal', function () {
                editCurrentRow = null;
                editSelectedShg = { code: '', name: '' };
                editSelectedMember = { code: '', name: '' };
                try { $('#editVillageSelect').select2('destroy'); } catch (e) { }
                try { $('#editShgSelect').select2('destroy'); } catch (e) { }
            });

            // ========================
            // FORM VALIDATION
            // ========================

            $('#editVenueForm').on('submit', function (e) {
                let errors = [];

                $('#editVenueBody .edit-venue-row').each(function (i) {
                    let name = $(this).find('input[name="venue_name[]"]').val().trim();
                    let capacity = $(this).find('input[name="capacity[]"]').val();
                    let shg = $(this).find('.editRowShg').val();
                    let member = $(this).find('.editRowMember').val();

                    if (!name) errors.push('Row ' + (i + 1) + ': Venue Name is required.');
                    if (!capacity || parseInt(capacity) < 1) errors.push('Row ' + (i + 1) + ': Capacity must be at least 1.');
                    if (!shg || !member) errors.push('Row ' + (i + 1) + ': SHG & Member must be assigned.');
                });

                if (errors.length > 0) {
                    e.preventDefault();
                    alert(errors.join('\n'));
                }
            });

            // ========================
            // HELPER: HTML ESCAPE
            // ========================

            function escapeHtml(str) {
                if (!str) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

        });
        // ==========================================
// UPDATE CADRE - AJAX VALIDATION
// ==========================================
$(document).on('click', '#editCadreSubmitBtn', function (e) {
    e.preventDefault();

    const venueId   = $('#editCadreVenueId').val();
    const memCode   = $('#editCadreMemCode').val();
    const villageId = $('#editModalVillageSelect').val();
    const $btn      = $(this);
    const $form     = $btn.closest('form');

    // Guard: member must be selected
    if (!memCode) {
        Swal.fire({
            icon              : 'warning',
            title             : 'Select Member',
            text              : 'Please select a member before updating.',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    // Guard: village must be selected
    if (!villageId) {
        Swal.fire({
            icon              : 'warning',
            title             : 'Select Village',
            text              : 'Please select a village before updating.',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    // Disable button to prevent double submit
    $btn.prop('disabled', true)
        .html('<i class="fas fa-spinner fa-spin mr-1"></i> Checking...');

    $.ajax({
        url  : '/check-village-venue',
        type : 'POST',
        data : {
            village_id       : villageId,
            member_codes     : [memCode],
            exclude_venue_id : venueId,
            _token           : $('meta[name="csrf-token"]').attr('content'),
        },

        success: function (response) {

            if (response.exists) {

                Swal.fire({
                    icon              : 'warning',
                    title             : 'Already Mapped!',
                    text              : response.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText : 'OK',
                });

                $btn.prop('disabled', false)
                    .html('<i class="fas fa-save mr-1"></i> Update Cadre');

            } else {

                // ✅ Use native DOM submit to bypass jQuery click event loop
                $form[0].submit();

            }
        },

        error: function (xhr) {

            let errorMsg = 'Unable to verify cadre assignment.';
            try {
                let res = JSON.parse(xhr.responseText);
                errorMsg = res.message + (res.line ? ' (Line: ' + res.line + ')' : '');
            } catch (e) {
                errorMsg = xhr.responseText;
            }

            console.log('Status  :', xhr.status);
            console.log('Response:', xhr.responseText);

            Swal.fire({
                icon              : 'error',
                title             : 'Error ' + xhr.status,
                text              : errorMsg,
                confirmButtonColor: '#d33',
            });

            $btn.prop('disabled', false)
                .html('<i class="fas fa-save mr-1"></i> Update Cadre');
        }
    });

});

    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>