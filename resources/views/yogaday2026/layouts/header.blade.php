<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'International Yoga Day 2026')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/dist/css/guestcss.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/icon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/icon/site.webmanifest') }}">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">

        <div class="container">

            <img src="{{ asset('assets/images/asrlm_logo.png') }}" width="40" class="me-2">

            <a class="navbar-brand fw-bold text-success" href="{{ route('welcome') }}">
                Yoga Day 2026
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">

                        @auth

                            @if(auth()->user()->role == 'admin')

                                <a class="btn btn-success btn-sm" href="{{ route('admin.dashboard') }}">

                                    Dashboard

                                </a>

                            @elseif(auth()->user()->role == 'block')

                                <a class="btn btn-success btn-sm" href="{{ route('block.dashboard') }}">

                                    Dashboard

                                </a>

                            @elseif(auth()->user()->role == 'cadre')

                                <a class="btn btn-success btn-sm" href="{{ route('cadre.dashboard') }}">

                                    Dashboard

                                </a>

                            @else

                                <a class="btn btn-success btn-sm" href="{{ url('/login') }}">

                                    Dashboard

                                </a>

                            @endif

                        @else

                            <a class="btn btn-primary btn-sm" href="{{ route('login') }}">

                                Login

                            </a>

                        @endauth

                    </li>

                </ul>

            </div>

        </div>

    </nav>