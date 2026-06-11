<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>ASRLM | Secure Yoga Portal Login</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <script id="tailwind-config">
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#2E7D32",
            "on-primary": "#ffffff",
            "primary-container": "#c8e6c9",
            "on-primary-container": "#1b5e20",
            secondary: "#388e3c",
            "secondary-container": "#d4edcc",
            "on-secondary-container": "#1b5e20",
            background: "#f2faf3",
            "on-background": "#1a2e1c",
            surface: "#ffffff",
            "on-surface": "#1a2e1c",
            "on-surface-variant": "#4f6b52",
            outline: "#6b8f6e",
            "outline-variant": "#b8d4bb",
            "surface-container": "#e4f3e6",
            "surface-container-low": "#eef7ef",
            "surface-container-high": "#d8eeda",
            "surface-container-lowest": "#ffffff",
            error: "#b3261e",
            "on-error": "#ffffff",
            "error-container": "#fde8e8",
            "on-error-container": "#7c1d1d",
          },
          borderRadius: {
            DEFAULT: "0.25rem",
            lg: "0.5rem",
            xl: "0.75rem",
            full: "9999px",
          },
          fontFamily: {
            "body-md": ["Plus Jakarta Sans"],
          },
          fontSize: {
            "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
          },
        },
      },
    };
  </script>
  <style>
    /* Card */
    .glass-card {
      background: rgba(210, 235, 212, 0.55);
      backdrop-filter: blur(32px);
      -webkit-backdrop-filter: blur(32px);
      border: 1px solid rgba(46, 125, 50, 0.22);
      box-shadow: 0 8px 40px 0 rgba(46, 125, 50, 0.14), 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    /* Button glow */
    .glow-primary {
      box-shadow: 0 0 18px rgba(46, 125, 50, 0.35);
    }

    /* Input field background */
    .input-field {
      background: rgba(232, 245, 233, 0.7);
      border-bottom: 2px solid #b8d4bb;
      color: #1a2e1c;
      transition: border-color 0.25s ease, background 0.25s ease;
    }

    .input-field::placeholder {
      color: #7a9e7d;
    }

    .input-field:focus {
      outline: none;
      border-color: #2E7D32;
      background: rgba(200, 230, 201, 0.35);
    }

    /* Page background */
    body {
      background: linear-gradient(135deg, #e8f5e9 0%, #f9fef9 50%, #e0f2f1 100%);
      min-height: 100vh;
    }

    /* Glow blobs */
    .blob-tl {
      background: radial-gradient(circle, rgba(46, 125, 50, 0.18) 0%, transparent 70%);
    }

    .blob-br {
      background: radial-gradient(circle, rgba(56, 142, 60, 0.14) 0%, transparent 70%);
    }

    /* Material Symbols */
    .material-symbols-outlined {
      font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
    }

    /* Checkbox */
    input[type="checkbox"] {
      accent-color: #2E7D32;
    }

    /* ── Icon animations ── */
    @keyframes icon-pop {
      0% {
        transform: scale(1) rotate(0deg);
      }

      35% {
        transform: scale(1.4) rotate(-12deg);
      }

      65% {
        transform: scale(1.1) rotate(6deg);
      }

      100% {
        transform: scale(1.18) rotate(0deg);
      }
    }

    @keyframes icon-rest {
      from {
        transform: scale(1.18);
      }

      to {
        transform: scale(1);
      }
    }

    .input-icon {
      transition: color 0.35s ease, font-variation-settings 0.4s ease;
      font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
      color: #6b8f6e;
    }

    .input-icon.icon-focused {
      color: #2E7D32;
      font-variation-settings: "FILL" 1, "wght" 600, "GRAD" 0, "opsz" 24;
      animation: icon-pop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    .input-icon.icon-blur {
      animation: icon-rest 0.25s ease forwards;
    }

    .input-icon.icon-clickable {
      cursor: pointer;
      pointer-events: auto;
    }
  </style>
</head>

<body class="font-body-md text-on-background flex flex-col">

  <!-- TopAppBar -->
  <header class="bg-white/80 backdrop-blur-xl border-b border-outline-variant/60 shadow-sm sticky top-0 z-50">
    <div class="flex justify-between items-center w-full px-5 md:px-20 py-4 max-w-[1280px] mx-auto">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 flex items-center justify-center">
          <img src="{{ asset('assets/images/asrlm_logo.png') }}" alt="ASRLM Logo" class="w-full h-full object-contain">
        </div>
        <h1 class="text-[17px] font-bold tracking-tighter text-on-background uppercase">ASRLM</h1>
      </div>
      <a class="text-[12px] font-semibold border border-outline/50 text-primary px-5 py-2 rounded-full hover:bg-primary-container transition-colors uppercase tracking-widest"
        href="{{ route('welcome') }}">HOME</a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center relative overflow-hidden py-10 px-5">

    <!-- Atmospheric blobs -->
    <div class="blob-tl absolute top-[-10%] left-[-10%] w-[55%] h-[55%] blur-[120px] rounded-full pointer-events-none">
    </div>
    <div
      class="blob-br absolute bottom-[-10%] right-[-10%] w-[55%] h-[55%] blur-[120px] rounded-full pointer-events-none">
    </div>

    <div class="w-full max-w-[480px] z-10">

      <!-- Login Card -->
      <div class="glass-card rounded-2xl p-6 sm:p-8 md:p-10 flex flex-col gap-6">

        <!-- Title -->
        <div class="flex flex-col gap-1 text-center">
          <h2 class="text-[28px] sm:text-[32px] font-bold text-on-background leading-tight">Secure Login</h2>
          <p class="text-[13px] text-on-surface-variant">Empowering rural transformation through digital governance.</p>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
          <div class="bg-error-container border border-error/30 rounded-lg px-4 py-3 flex items-start gap-2">
            <span class="material-symbols-outlined text-error text-[18px] mt-px flex-shrink-0">error</span>
            <p class="text-error text-[12px] leading-5">{{ $errors->first() }}</p>
          </div>
        @endif
        @if (session('error'))
          <div class="bg-error-container border border-error/30 rounded-lg px-4 py-3 flex items-start gap-2">
            <span class="material-symbols-outlined text-error text-[18px] mt-px flex-shrink-0">error</span>
            <p class="text-error text-[12px] leading-5">{{ session('error') }}</p>
          </div>
        @endif

        <!-- Tab Toggle -->
        <div class="flex bg-surface-container rounded-xl p-1">
          <button type="button"
            class="flex-1 py-2.5 text-[12px] font-semibold rounded-lg transition-all duration-300 bg-primary text-on-primary shadow-md uppercase tracking-widest"
            id="tab-cadre" onclick="switchLogin('cadre')">
            Cadre
          </button>
          <button type="button"
            class="flex-1 py-2.5 text-[12px] font-semibold rounded-lg transition-all duration-300 text-on-surface-variant hover:bg-black/5 uppercase tracking-widest"
            id="tab-block" onclick="switchLogin('block')">
            Block/District/State
          </button>
        </div>

        <!-- ======================== -->
        <!-- CADRE LOGIN FORM        -->
        <!-- ======================== -->
        <form id="cadre-login-form" action="{{ route('login.submit') }}" method="post" class="flex flex-col gap-5">
          @csrf

          <div class="flex flex-col gap-2">
            <label class="text-[12px] font-semibold text-on-surface-variant px-1 uppercase tracking-wider">
              Cadre User ID
            </label>
            <div class="relative flex items-center">
                <input
                  id="cadre-member-input"
                  type="number"
                  name="member_code"
                  placeholder="Enter Member Code"
                  value="{{ old('member_code') }}"
                  class="input-field w-full pl-4 pr-11 py-4 border-0 rounded-t-lg text-[15px]"
                  autocomplete="username"
                />
                <span id="icon-badge" class="material-symbols-outlined input-icon absolute right-3 text-[20px] pointer-events-none">badge</span>
              </div>
            <div class="relative flex items-center">
              <div class="w-full p-4 rounded-t-lg bg-yellow-50 border border-yellow-200 text-center">
                <span class="material-symbols-outlined text-yellow-600 text-2xl align-middle">
                  schedule
                </span>
                <p class="mt-2 text-sm font-semibold text-yellow-800">
                  Cadre Login will be live from 16th June 2026.
                </p>
              </div>
            </div>
          </div>

          <!-- <button type="submit"
            class="w-full py-3.5 bg-primary text-on-primary font-bold rounded-xl active:scale-95 duration-150 glow-primary hover:brightness-110 transition-all uppercase tracking-widest text-[12px]">
            Secure Login
          </button> -->

        </form>

        <!-- ======================== -->
        <!-- BLOCK LOGIN FORM        -->
        <!-- ======================== -->
        <form id="block-login-form" action="{{ route('login.submit') }}" method="post" class="hidden flex-col gap-5">
          @csrf

          {{-- EMAIL --}}
          <div class="flex flex-col gap-2">
            <label class="text-[12px] font-semibold text-on-surface-variant px-1 uppercase tracking-wider">
              Email Address
            </label>
            <div class="relative flex items-center">
              <input id="block-email-input" type="email" name="email" placeholder="Enter Email Address"
                value="{{ old('email') }}" class="input-field w-full pl-4 pr-11 py-4 border-0 rounded-t-lg text-[15px]"
                autocomplete="email" required />
              <span id="icon-mail"
                class="material-symbols-outlined input-icon absolute right-3 text-[20px] pointer-events-none">mail</span>
            </div>
          </div>

          {{-- PASSWORD --}}
          <div class="flex flex-col gap-2">
            <label class="text-[12px] font-semibold text-on-surface-variant px-1 uppercase tracking-wider">
              Password
            </label>
            <div class="relative flex items-center">
              <input id="block-password-input" type="password" name="password" placeholder="Enter Password"
                class="input-field w-full pl-4 pr-11 py-4 border-0 rounded-t-lg text-[15px]"
                autocomplete="current-password" required />
              <span id="icon-lock"
                class="material-symbols-outlined input-icon icon-clickable absolute right-3 text-[20px]"
                onclick="togglePassword()">lock</span>
            </div>
          </div>

          <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"></div>

          {{-- REMEMBER ME + SIGN IN --}}
          <div class="flex items-center justify-between gap-3 flex-wrap">
            <label class="flex items-center gap-2 cursor-pointer select-none min-w-0">
              <input type="checkbox" name="remember" id="remember-block"
                class="w-4 h-4 rounded border-outline-variant bg-surface cursor-pointer flex-shrink-0" />
              <span class="text-[12px] font-semibold text-on-surface-variant whitespace-nowrap">Remember Me</span>
            </label>

            <button type="submit"
              class="px-7 py-3 bg-primary text-on-primary font-bold rounded-xl active:scale-95 duration-150 glow-primary hover:brightness-110 transition-all uppercase tracking-widest text-[12px] whitespace-nowrap">
              Sign In
            </button>
          </div>

        </form>

        <!-- Footer tag line -->
        <div class="flex items-center justify-center gap-2 pt-1">
          <span class="w-2 h-2 rounded-full bg-primary/30"></span>
          <p class="text-[12px] font-semibold text-on-surface-variant">World Yoga Day | ASRLM</p>
          <span class="w-2 h-2 rounded-full bg-primary/30"></span>
        </div>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white/70 border-t border-outline-variant/50 w-full">
    <div
      class="flex flex-col sm:flex-row justify-between items-center w-full px-5 md:px-20 py-3 gap-3 max-w-[1280px] mx-auto">
      <span class="text-[12px] font-semibold text-on-surface-variant text-center sm:text-left">
        &copy; @php
          echo date('Y');
        @endphp Assam State Rural Livelihoods Mission. All Rights Reserved.
      </span>
      <div class="flex items-center gap-2 text-primary/70">
        <span class="material-symbols-outlined text-[16px]">verified_user</span>
        <span class="text-[12px] font-semibold">Government of Assam</span>
      </div>
    </div>
  </footer>

  <script>
    function switchLogin(type) {
      const cadreTab = document.getElementById('tab-cadre');
      const blockTab = document.getElementById('tab-block');
      const cadreForm = document.getElementById('cadre-login-form');
      const blockForm = document.getElementById('block-login-form');

      if (type === 'cadre') {
        cadreTab.classList.add('bg-primary', 'text-on-primary', 'shadow-md');
        cadreTab.classList.remove('text-on-surface-variant', 'hover:bg-black/5');
        blockTab.classList.remove('bg-primary', 'text-on-primary', 'shadow-md');
        blockTab.classList.add('text-on-surface-variant', 'hover:bg-black/5');
        cadreForm.classList.remove('hidden'); cadreForm.classList.add('flex');
        blockForm.classList.add('hidden'); blockForm.classList.remove('flex');
      } else {
        blockTab.classList.add('bg-primary', 'text-on-primary', 'shadow-md');
        blockTab.classList.remove('text-on-surface-variant', 'hover:bg-black/5');
        cadreTab.classList.remove('bg-primary', 'text-on-primary', 'shadow-md');
        cadreTab.classList.add('text-on-surface-variant', 'hover:bg-black/5');
        blockForm.classList.remove('hidden'); blockForm.classList.add('flex');
        cadreForm.classList.add('hidden'); cadreForm.classList.remove('flex');
      }
    }

    @if ($errors->has('email') || $errors->has('password'))
      switchLogin('block');
    @endif

    // Icon animation
    function bindIconAnimation(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (!input || !icon) return;
      input.addEventListener('focus', () => {
        icon.classList.remove('icon-blur');
        void icon.offsetWidth;
        icon.classList.add('icon-focused');
      });
      input.addEventListener('blur', () => {
        icon.classList.remove('icon-focused');
        icon.classList.add('icon-blur');
      });
    }

    bindIconAnimation('cadre-member-input', 'icon-badge');
    bindIconAnimation('block-email-input', 'icon-mail');
    bindIconAnimation('block-password-input', 'icon-lock');

    // Password toggle
    function togglePassword() {
      const input = document.getElementById('block-password-input');
      const icon = document.getElementById('icon-lock');
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.textContent = isHidden ? 'lock_open' : 'lock';
      icon.classList.remove('icon-focused');
      void icon.offsetWidth;
      icon.classList.add('icon-focused');
    }
  </script>

</body>

</html>