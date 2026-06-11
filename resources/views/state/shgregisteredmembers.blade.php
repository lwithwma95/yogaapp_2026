<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registered Members — {{ $shg->shg_name }}</title>
    @include('state.includes.header')
    <style>
        .member-photo {
            width: 90px; height: 90px;
            object-fit: cover; border-radius: 50%;
            border: 3px solid #28a745;
            box-shadow: 0 4px 12px rgba(0,0,0,.12);
        }
        .member-card {
            border: none; border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: transform .15s, box-shadow .15s;
        }
        .member-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.12); }
        .shg-banner {
            background: linear-gradient(135deg, #155724, #1a6b2e, #28a745);
            border-radius: 12px; color: #fff; padding: 16px 20px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    @include('state.includes.navbar')
    @include('state.includes.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Registered Members</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('state.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('state.district.details', $shg->village->gp->block->district->district_id) }}">{{ $shg->village->gp->block->district->district_name }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('state.block.details', $shg->village->gp->block->block_id) }}">{{ $shg->village->gp->block->block_name }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('state.gp.details', $shg->village->gp->gp_id) }}">{{ $shg->village->gp->gp_name }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('state.village.details', $shg->village->vill_id) }}">{{ $shg->village->vill_name }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $shg->shg_name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                {{-- SHG Banner --}}
                <div class="shg-banner mb-4 d-flex flex-wrap align-items-center" style="gap:24px;">
                    <div>
                        <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;">SHG</div>
                        <div style="font-size:1.1rem;font-weight:700;">{{ $shg->shg_name }}</div>
                    </div>
                    <div>
                        <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;">SHG Code</div>
                        <div style="font-size:1rem;font-weight:700;">{{ $shg->shg_code }}</div>
                    </div>
                    <div>
                        <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;">Village · Block · District</div>
                        <div style="font-size:1rem;font-weight:700;">
                            {{ $shg->village->vill_name }} · {{ $shg->village->gp->block->block_name }} · {{ $shg->village->gp->block->district->district_name }}
                        </div>
                    </div>
                    <div class="ml-auto">
                        <span class="badge badge-light px-3 py-2" style="font-size:14px;border-radius:50px;">
                            <i class="fas fa-check-circle text-success mr-1"></i>
                            {{ $members->count() }} Registered
                        </span>
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Member Cards --}}
                @if($members->isEmpty())
                    <div class="alert alert-warning text-center py-5">
                        <i class="fas fa-info-circle fa-2x mb-3 d-block text-warning"></i>
                        No registered members found for this SHG.
                    </div>
                @else
                    <div class="row">
                        @foreach($members as $member)
                            @php $photoUrl = $photoUrls[$member->mem_no] ?? null; @endphp
                            <div class="col-6 col-md-4 col-lg-3 mb-4">
                                <div class="card member-card h-100">
                                    <div class="card-body text-center pt-4 pb-3 px-3">
                                        <img src="{{ $photoUrl ?? asset('assets/images/no-image.png') }}"
                                             alt="{{ $member->mem_name }}"
                                             class="member-photo mb-3"
                                             onerror="this.src='{{ asset('assets/images/no-image.png') }}'">
                                        <div style="font-weight:700;font-size:14px;color:#1a2e1c;margin-bottom:2px;line-height:1.3;">
                                            {{ $member->mem_name }}
                                        </div>
                                        <div class="text-muted mb-2" style="font-size:11px;">{{ $member->mem_code }}</div>
                                        <div class="mb-1" style="font-size:12px;">
                                            <i class="fas fa-phone-alt text-success mr-1"></i>
                                            {{ $member->mem_mobile ?? 'N/A' }}
                                        </div>
                                        <div class="text-muted" style="font-size:11px;">
                                            <i class="fas fa-calendar-check mr-1"></i>
                                            {{ $member->yoga_reg_date ? \Carbon\Carbon::parse($member->yoga_reg_date)->format('d M Y') : 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="card-footer text-center py-2 px-3" style="background:#f0faf2;border-top:1px solid #d4edda;border-radius:0 0 14px 14px;">
                                        <span class="badge badge-success px-2 py-1" style="font-size:11px;border-radius:50px;">
                                            <i class="fas fa-check mr-1"></i>Registered
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    </div>

    @include('state.includes.footer')
</div>
</body>
</html>
