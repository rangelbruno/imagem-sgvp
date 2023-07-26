<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="application/pdf">

    <title>Sistema - {{ $title ?? '' }}</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- ============================================================== -->
    <!-- Chamada para o STYLES da página -->
    <!-- ============================================================== -->
    @stack('styles')

</head>

<body class="sidebar-noneoverflow starterkit">
    <!-- ============================================================== -->
    <!-- Start Page NAVBAR here -->
    <!-- ============================================================== -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                            <h3>{{ $namepage ?? 'Nome da pagina' }}</h3>
                        </div>
                    </div>
                </li>
            </ul>
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>


        </header>
    </div>
    <!-- ============================================================== -->
    <!-- Start Page CONTAINER here -->
    <!-- ============================================================== -->
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <!-- ============================================================== -->
        <!-- Start Page SIDEBAR here -->
        <!-- ============================================================== -->
        <x-layouts.sidebar />
        <!-- ============================================================== -->
        <!-- Start Page CONTENT here -->
        <!-- ============================================================== -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <!-- ============================================================== -->
                <!-- Start Page SLOT here -->
                <!-- ============================================================== -->
                {{ $slot }}
            </div>
            <!-- ============================================================== -->
            <!-- Start Page FOOTER here -->
            <!-- ============================================================== -->
            <x-layouts.footer />
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start Page SCRIPTS here -->
    <!-- ============================================================== -->
    <script src="{{ url('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Chamada para o SCRIPTS da página -->
    <!-- ============================================================== -->
    @stack('scripts')
</body>

</html>
