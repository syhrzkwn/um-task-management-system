<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom CSS -->
    <style>
        .table-custom th {
            background-color: #ffffff; /* Replace with your desired background color */
        }
        .table-custom tbody tr td {
            background-color: #ffffff; /* Replace with your desired background color */
        }
        .icon {
            font-size: 25px;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="offcanvas offcanvas-start p-3 bg-white rounded-end-4" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" style="width: 300px;">
                    <div class="offcanvas-header">
                        <img src="{{ asset('img/um-logo.png') }}" class="logo me-1" alt="VetEase Logo" />
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="mt-3">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                                <div data-bs-dismiss="offcanvas" aria-label="Close">
                                    <i class="bi bi-columns-gap icon align-middle ms-2"></i>
                                    <span class="ms-3 text-dark">Dashboard</span>
                                </div>
                            </a>
                        </div>
                        @can('read.tasks')
                        <div class="mt-3">
                            <a href="#" class="text-decoration-none">
                                <div data-bs-dismiss="offcanvas" aria-label="Close">
                                    <i class="bi bi-clipboard-data icon align-middle ms-2"></i>
                                    @if (Auth::user()->user_type == 'Admin')
                                        <span class="ms-3 text-dark">Tasks</span>
                                    @else
                                        <span class="ms-3 text-dark">My Tasks</span>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endcan
                        @can('read.staffs')
                        <div class="mt-3">
                            <a href="{{ route('staff.index') }}" class="text-decoration-none">
                                <div data-bs-dismiss="offcanvas" aria-label="Close">
                                    <i class="bi bi-people icon align-middle ms-2"></i>
                                    <span class="ms-3 text-dark">Staffs</span>
                                </div>
                            </a>
                        </div>
                        @endcan
                        <hr />
                        <div class="mt-3">
                            <a href="{{ route('profile.show') }}" class="text-decoration-none">
                                <div data-bs-dismiss="offcanvas" aria-label="Close">
                                    <i class="bi bi-person-circle icon align-middle ms-2"></i>
                                    <span class="ms-3 text-dark">{{ Auth::user()->name }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div>
                        <a class="btn btn-danger w-100" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="col px-0">
                    <!-- Navbar -->
                    <nav class="navbar navbar-border bg-white border-bottom">
                        <div class="container">
                            <button class="btn btn-primary rounded-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fs-4 bi bi-list"></i></button>
                            <span class="badge rounded-pill text-bg-primary">{{ Auth::user()->user_type }}</span>
                        </div>
                    </nav>

                    <main class="py-4">
                        <div class="container">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible rounded-4 fade show" role="alert">
                                    <i class="fs-5 bi bi-check-circle-fill align-middle me-2"></i>
                                    <span> {{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger alert-dismissible rounded-4 fade show" role="alert">
                                    <i class="fs-5 bi bi-exclamation-circle-fill align-middle me-2"></i>
                                    <span> {{ session('error') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>

                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
