<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <!--end::Theme Init-->
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Primary Meta Tags-->
    <title>@yield('title', 'SIRAE')</title>    <meta name="author" content="ColorlibHQ" />
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="stylesheet" href="{{ asset('adminlte4/css/adminlte.css') }}">
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha384-oXLoUoB5XFLG2VXaPgirj0OzzF7JWUf+9DRdQ4TnfpOxIdWCy0EbfR8h9WeYPvK9"
      crossorigin="anonymous"
      media="print"
      onload="this.media = 'all'"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      integrity="sha384-8sLCQOHuTW2bb7a9SVEmWb05/IaKIMn9My+f1IWbPWNmgTe4oHCcs0xKyl9xeGuH"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      integrity="sha384-CK2SzKma4jA5H/MXDUU7i1TqZlCFaD4T01vtyDFvPlD97JQyS+IsSh1nI2EFbpyk"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte4/css/adminlte.css') }}">
    <!--end::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha384-nRgPTkuX86pH8yjPJUAFuASXQSSl2/bBUiNV47vSYpKFxHJhbcrGnmlYpYJMeD7a" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@3.1.3/css/dataTables.bootstrap5.min.css" rel="stylesheet" integrity="sha384-OZKa6QSlaaq/LGR1sBFkYhC0c/nacIFh1chsblhDUxggC9Zb0XLEEMs95i1Kydnt" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs5@4.1.1/css/responsive.bootstrap5.min.css" rel="stylesheet" integrity="sha384-IccFVZxMebKzou2YAT+5kHCpRTtvbJKtU1WS6PmGGeO3LvfGhMNgmeDE5k59j9Qk" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" integrity="sha384-OXVF05DQEe311p6ohU11NwlnX08FzMCsyoXzGOaL+83dKAb3qS17yZJxESl8YrJQ" crossorigin="anonymous">

<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" integrity="sha384-IrMr0LFnIMa9H6HhC5VVqVuWNEIwspnRLKQc0SUyPj4Cy4s02DiWDZEoJOo5WNK6" crossorigin="anonymous">

    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha384-IMZTIIMtTbMegVcBxOJnwW7aKGqh3tChpUO6T8PXUNQaGZCSlgerMvM4ifNew7uX"
      crossorigin="anonymous"
    />

    @livewireStyles
    @stack('styles')

    <style>
       /* ANCHO COMPLETO */
        .select2-container {
            width:100% !important;
        }
        /* SELECT NORMAL */
        .select2-container--default 
        .select2-selection--single {
            height:38px !important;
            border:1px solid #dee2e6 !important;
            border-radius:.375rem !important;
            background-color:#fff !important;
            transition:
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }
        /* TEXTO */
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__rendered {
            line-height:38px !important;
            padding-left:.75rem !important;
            padding-right:65px !important;
            font-size:1rem !important;
            color:#212529 !important;
        }
        /* FLECHA */
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__arrow {
            height:38px !important;
            right:8px !important;
        }
        /* FOCUS / ABIERTO ROSA */
        .select2-container--default.select2-container--focus 
        .select2-selection--single,
        .select2-container--default.select2-container--open 
        .select2-selection--single {
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25) !important;
        }
        /* ERROR */
        .select2-container.select2-error 
        .select2-selection--single {
            border-color:#dc3545 !important;
            box-shadow:
            0 0 0 .25rem rgba(220,53,69,.25) !important;
        }
        /* X LIMPIAR */
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__clear {
            position:absolute !important;
            right:35px !important;
            top:50% !important;
            transform:translateY(-50%) !important;
            font-size:22px !important;
            color:#dc3545 !important;
            font-weight:bold !important;
            margin:0 !important;
            line-height:1 !important;
            cursor:pointer !important;
            z-index:20 !important;
        }
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__clear:hover {
            color:#b02a37 !important;
        }
        /* OPCION SELECCIONADA */
        .select2-container--default 
        .select2-results__option[aria-selected="true"] {
            background-color:#E22275 !important;
            color:white !important;
        }
        /* HOVER OPCIONES */
        .select2-container--default 
        .select2-results__option--highlighted {
            background-color:#E22275 !important;
            color:white !important;
        }
        /* HOVER SOBRE SELECCIONADA */
        .select2-container--default 
        .select2-results__option[aria-selected="true"]:hover {
            background-color:#E22275 !important;
            color:white !important;
        }
        /* BUSCADOR */
        .select2-container--default 
        .select2-search--dropdown 
        .select2-search__field {
            border:1px solid #dee2e6 !important;
            border-radius:.375rem !important;
        }
        /* DESHABILITADO */
        .select2-container--default.select2-container--disabled 
        .select2-selection--single {
            background-color:#e9ecef !important;
            cursor:not-allowed !important;
        }
        /* OCULTAR X */
        .select2-selection__clear {
            display:none !important;
        }
    </style>

  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
           <!--begin::Color Mode Toggle (#6010)-->
            <li class="nav-item dropdown">
              <a
                class="nav-link"
                href="#"
                id="bd-theme"
                aria-label="Toggle color scheme"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
                <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
                <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="bd-theme"
                style="--bs-dropdown-min-width: 8rem"
              >
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="light"
                    aria-pressed="false"
                  >
                    <i class="bi bi-sun-fill me-2"></i>
                    Light
                    <i class="bi bi-check-lg ms-auto d-none"></i>
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="dark"
                    aria-pressed="false"
                  >
                    <i class="bi bi-moon-fill me-2"></i>
                    Dark
                    <i class="bi bi-check-lg ms-auto d-none"></i>
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center active"
                    data-bs-theme-value="auto"
                    aria-pressed="true"
                  >
                    <i class="bi bi-circle-half me-2"></i>
                    Auto
                    <i class="bi bi-check-lg ms-auto d-none"></i>
                  </button>
                </li>
              </ul>
            </li>
            <!--end::Color Mode Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a class="nav-link d-flex align-items-center gap-2"
                   href="#"
                   data-bs-toggle="dropdown">
                    <img
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre." ". auth()->user()->apaterno." ". auth()->user()->amaterno) }}&background=E22275&color=fff&size=128"
                        alt="Usuario"
                        class="rounded-circle"
                        width="35"
                        height="35">
                    <span>
                        {{ auth()->user()->nombre." ". auth()->user()->apaterno." ". auth()->user()->amaterno }}
                    </span>
                </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary" style="background-color: #E22275 !important; color:#ffffff !important;">
                  <img src="{{ asset('adminlte4/assets/img/user2-160x160.jpg') }}" width="15%" class="rounded-circle shadow">
                  <p>
                    {{ auth()->user()->nombre." ". auth()->user()->apaterno." ". auth()->user()->amaterno }}
                    <small></small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Footer-->
                <li class="user-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.users.perfiles') }}"
                    class="btn btn-outline-secondary">
                        <i class="fas fa-user me-2"></i>
                        Mi Perfil
                    </a>
                    <form method="POST"
                        action="{{ route('logout') }}"
                        class="m-0 ms-auto">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Salir
                        </button>
                    </form>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark" style="background-color: #E22275 !important; color:#ffffff !important;">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand d-flex align-items-center"
            style="border-bottom:1px solid #e5e7eb; padding: 16px 12px;">

        <a href="{{ route('dashboard') }}"
          class="text-decoration-none w-100 ps-2"
          style="line-height: 1.1;">
            <span class="fw-bolder d-block"
                  style="font-size: 22px; letter-spacing: 1px; color:#ffffff; margin-bottom: -2px;">
                Sistema <strong>SIRAE</strong>
            </span>
        </a>
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2" aria-label="Main navigation">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation" style="color: white !important;">
                <li class="nav-item fw-light">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"  style="color: white !important;"></i>
                        <p  style="color: white !important;">
                            Panel principal
                        </p>
                    </a>
                </li>
                @hasanyrole('SuperAdmin|Admin')
                <li class="nav-header">
                    ADMINISTRACIÓN
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.aspirantes.listar') }}"
                       class="nav-link">
                        <i class="nav-icon fas fa-users" style="color: white !important;"></i>
                        <p style="color: white !important;">
                            Aspirantes con registro
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.aspirantes.requeridos.listar') }}"
                       class="nav-link">
                        <i class="nav-icon fas fa-user-clock" style="color: white !important;"></i>
                        <p style="color: white !important; white-space: normal; line-height: 1.4;">
                            Aspirantes con requerimiento y que subsanaron
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.aspirantes.validados.listar') }}"
                       class="nav-link">
                        <i class="nav-icon fas fa-user-check" style="color: white !important;"></i>
                        <p style="color: white !important;">
                            Aspirantes con validación
                        </p>
                    </a>
                </li>
                @role('SuperAdmin')
                @endrole
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cog" style="color: white !important;"></i>
                    <p style="color: white !important;">
                        Configuraciones
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('admin.users') }}"
                            class="nav-link ms-1">
                              <i class="bi-arrow-right-circle" style="color: #f8f8f8 !important;"></i>
                              <p style="color: #f8f8f8 !important;">
                                  Usuarios
                              </p>
                          </a>
                      </li>
                      {{--  
                      <li class="nav-item">
                          <a href="{{ route('admin.roles') }}"
                            class="nav-link">
                              <i class="bi-arrow-right-circle" style="color: #f8f8f8 !important;"></i>
                              <p style="color: #f8f8f8 !important;">
                                  Roles
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('admin.organizaciones') }}"
                            class="nav-link">
                              <i class="bi-arrow-right-circle" style="color: #f8f8f8 !important;"></i>
                              <p style="color: #f8f8f8 !important;">
                                  Organizaciones
                              </p>
                          </a>
                      </li>
                      --}}
                    </ul>
                </li>
               

                {{--  
                <li class="nav-item">
                    <a href="{{ route('admin.aspirantes.listar') }}"
                       class="nav-link">
                        <i class="nav-icon fas fa-chart-column" style="color:white !important;"></i>
                        <p style="color: white !important;">
                            Reportes
                        </p>
                    </a>
                </li>
                --}}
                @endrole

            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
                <div class="row align-items-center mb-3">
                    {{--  
                    <div class="col-sm-6">
                        <h5 class="page-title">
                            @yield('title', 'Dashboard')
                        </h5>
                    </div>
                    --}}
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-star">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Inicio
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                @yield('title', 'Dashboard')
                            </li>
                        </ol>
                    </div>
                </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <div class="app-content">
          <!--begin::Container-->
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
               @if (isset($slot))
                  {{ $slot }}
              @else
                  @yield('content')
              @endif
            </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer text-center">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline"></div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy;
          <a href="https://www.iepc-chiapas.org.mx" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              IEPC
          </a>
        </strong>
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <!-- jQuery PRIMERO -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs" crossorigin="anonymous"></script>
<!-- OverlayScrollbars -->
<script
src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
 integrity="sha384-OpOb07UyDi3sxCwFB2HK/Co1PBt6UL2ycxHHwjXwJuRSSjOZAWZSrCY0xd41RLSG"
crossorigin="anonymous"></script>
<!-- Bootstrap 5 + Popper incluido -->
<script
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
crossorigin="anonymous"></script>
<!-- AdminLTE -->
<script src="{{ asset('adminlte4/js/adminlte.min.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" integrity="sha384-d3UHjPdzJkZuk5H3qKYMLRyWLAQBJbby2yr2Q58hXXtAGF8RSNO9jpLDlKKPv5v3" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js" integrity="sha384-nLoOnA/BDh8A/jxqtckg4DumuCGOBYUnNJLZdQz/zfYNp3wcjGSoWTAzgko06G/2" crossorigin="anonymous"></script>
<!-- DataTables -->
 <script src="https://cdn.jsdelivr.net/npm/datatables.net@3.1.3/js/dataTables.min.js" integrity="sha384-2VkhZZqhleNsGIa6GcWWRJn09k3lpejTs0B2LzDbeU/YSNfr6nKAnRTgasXvxWc3" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@3.1.3/js/dataTables.bootstrap5.min.js" integrity="sha384-4d8X9sr6Gnv9AgIQn6bv3lmQxj5fD+9bVAun0/XMmdy7oPRvT0adfiUUiiYpi4Ck" crossorigin="anonymous"></script>
<!-- Responsive -->
 <script src="https://cdn.jsdelivr.net/npm/datatables.net-responsive@4.1.1/js/dataTables.responsive.min.js" integrity="sha384-PQkuArYpt1S0q5TqF/LnSkmadKwFyLBnPgdKgxfzpZy+h8UOk/jF3895MC6ZbHof" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs5@4.1.1/js/responsive.bootstrap5.min.js" integrity="sha384-knw38sH7qpV3KrjATT6pxZQbU/X2YxbvSTFx8RSBVmc5KndzK7iStdfQiNUs0nnd" crossorigin="anonymous"></script>
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        // Disable OverlayScrollbars on mobile devices to prevent touch interference
        const isMobile = window.innerWidth <= 992;
        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure--><!--begin::Color Mode Toggle (#6010)-->
    <script>
      (() => {
        'use strict';
        const STORAGE_KEY = 'lte-theme';
        const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
        const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);
        const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
        const getPreferredTheme = () => {
          const stored = getStoredTheme();
          if (stored) return stored;
          return prefersDark() ? 'dark' : 'light';
        };
        const setTheme = (theme) => {
          const resolved = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme;
          document.documentElement.setAttribute('data-bs-theme', resolved);
        };
        setTheme(getPreferredTheme());
        const showActiveTheme = (theme) => {
          // Highlight the active dropdown option
          document.querySelectorAll('[data-bs-theme-value]').forEach((el) => {
            el.classList.remove('active');
            el.setAttribute('aria-pressed', 'false');
            const check = el.querySelector('.bi-check-lg');
            if (check) check.classList.add('d-none');
          });
          const active = document.querySelector(`[data-bs-theme-value="${theme}"]`);
          if (active) {
            active.classList.add('active');
            active.setAttribute('aria-pressed', 'true');
            const check = active.querySelector('.bi-check-lg');
            if (check) check.classList.remove('d-none');
          }
          // Sync the topbar trigger icon
          document.querySelectorAll('[data-lte-theme-icon]').forEach((icon) => {
            icon.classList.toggle('d-none', icon.dataset.lteThemeIcon !== theme);
          });
        };
        globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
          const stored = getStoredTheme();
          if (!stored || stored === 'auto') setTheme(getPreferredTheme());
        });
        document.addEventListener('DOMContentLoaded', () => {
          showActiveTheme(getPreferredTheme());
          document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
            toggle.addEventListener('click', () => {
              const theme = toggle.getAttribute('data-bs-theme-value');
              setStoredTheme(theme);
              setTheme(theme);
              showActiveTheme(theme);
            });
          });
        });
      })();
    </script>
    <!--end::Color Mode Toggle-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha384-PVKTeDrjIq4WEIqFRZdXDZUhM0A2eiRYpEfyxva/f/2THbmQ3rI3WMoURAsqcOan"
      crossorigin="anonymous"
    ></script>
    <!--end::Script-->
    @livewireScripts
    @stack('scripts')
</body>
  <!--end::Body-->
</html>
