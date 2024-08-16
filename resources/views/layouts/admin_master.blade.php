<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('backend') }}/js/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js" />
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.jqueryui.js" />
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap4.min.js" />
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.11/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.11/vfs_fonts.js"></script>
    <script src="{{ asset('backend') }}/js/sidenav-scripts.js"></script>


    <!-- Styles -->
    <link href="{{ asset('backend') }}/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />


</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <!-- <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a> -->
                        <a class="dropdown-item"><button class="btn btn-danger text-white" onclick="event.preventDefault(); this.closest('form').submit();">Logout</button></a>
                    </form>

                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- <div class="sb-sidenav-menu-heading">Core</div> -->
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Devices
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('all.devices') }}">All Devices</a>
                                <a class="nav-link" href="{{ route('add.device') }}">Add New Device</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAuthentication" aria-expanded="false" aria-controls="collapseAuthentication">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Agents
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseAuthentication" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('all.agents') }}">All Agents</a>
                            </nav>
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('add.agent') }}">Add New Agent</a>
                            </nav>
                        </div>

                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            @yield('content')

            <!-- Footer / Notes -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Killa Bee/John Smith Industries</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    @yield('script')
</body>

</html>