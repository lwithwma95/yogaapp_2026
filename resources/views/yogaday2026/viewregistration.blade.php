@include('yogaday2026.layouts.header')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card details-card">
                <!-- HEADER -->
                <div class="details-header">
                    <h2>
                        🧘 Yoga Registration Details
                    </h2>

                </div>

                <!-- BODY -->

                <div class="details-body">

                    @if(session('success'))

                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '{{ session('success') }}',
                                confirmButtonColor: '#198754',
                                confirmButtonText: 'OK'
                            });

                        </script>

                    @endif

                    <!-- PHOTO -->

                    <div class="text-center mb-5">

                        @if($member->yoga_selfie)
                            <img src="{{ Storage::disk('s3')->temporaryUrl($member->yoga_selfie, now()->addMinutes(30)) }}"
                                alt="Member Photo" class="profile-photo">
                        @else
                            <img src="{{ asset('assets/no-image.png') }}" alt="No Photo" class="profile-photo">
                        @endif

                    </div>

                    <!-- DETAILS -->

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="info-card">

                                <span class="info-label">
                                    Member Name
                                </span>

                                <p class="info-value">
                                    {{ $member->mem_name }}
                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="info-card">

                                <span class="info-label">
                                    Member Code
                                </span>

                                <p class="info-value">
                                    {{ $member->mem_code }}
                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="info-card">

                                <span class="info-label">
                                    Mobile Number
                                </span>

                                <p class="info-value">
                                    {{ $member->mem_mobile }}
                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="info-card">

                                <span class="info-label">
                                    SHG Code
                                </span>

                                <p class="info-value">
                                    {{ $member->shg_code }}
                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="info-card">

                                <span class="info-label">
                                    Registration Status
                                </span>

                                <p class="mt-2">

                                    @if($member->yoga2026_registration == '1')

                                        <span class="badge bg-success status-badge">

                                            Registered

                                        </span>

                                    @elseif($member->yoga2026_registration == '0')

                                        <span class="badge bg-danger status-badge">

                                            Not Registered

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark status-badge">

                                            Pending

                                        </span>

                                    @endif

                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="info-card">

                                <span class="info-label">
                                    Registration Date
                                </span>

                                <p class="info-value">
                                    {{ $member->yoga_reg_date }}
                                </p>

                            </div>

                        </div>

                    </div>

                    <!-- BUTTON -->

                    <div class="text-center mt-5">

                        <a href="{{ route('welcome') }}" class="btn btn-primary back-btn">

                            ← Back to Home

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@include('yogaday2026.layouts.footer')