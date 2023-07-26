<div class="sidebar-wrapper sidebar-theme">

    <nav id="compactSidebar">

        <div class="theme-logo">
            <a href="{{ route('admin.home') }}">
                <img src="{{ asset('assets/img/logo.svg') }}" class="navbar-logo" alt="logo">

            </a>
        </div>
        <ul class="menu-categories">
            <!-- ============================================================== -->
            <!-- Start HOME here -->
            <!-- ============================================================== -->
            <li class="menu menu-single">
                <a href="{{ route('admin.home') }}" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                </a>
                <div class="tooltip"><span>Home</span></div>
            </li>
            <!-- ============================================================== -->
            <!-- Start USUÁRIOS here -->
            <!-- ============================================================== -->
            <li class="menu menu-single">
                <a href="{{ route('usuarios.index') }}" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                <div class="tooltip"><span>Usuários</span></div>
            </li>
            <!-- ============================================================== -->
            <!-- Start SESSÃO here -->
            <!-- ============================================================== -->
            <li class="menu menu-single">
                <a href="{{ route('sessao.index') }}" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-cast">
                                <path
                                    d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6">
                                </path>
                                <line x1="2" y1="20" x2="2.01" y2="20"></line>
                            </svg>
                        </div>
                    </div>
                </a>
                <div class="tooltip"><span>Sessão</span></div>
            </li>
            <!-- ============================================================== -->
            <!-- Start SESSÃO here -->
            <!-- ============================================================== -->
            <li class="menu menu-single">
                <a href="{{ route('painel.index') }}" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-cast">
                                <path
                                    d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6">
                                </path>
                                <line x1="2" y1="20" x2="2.01" y2="20"></line>
                            </svg>
                        </div>
                    </div>
                </a>
                <div class="tooltip"><span>Painel</span></div>
            </li>
            <!-- ============================================================== -->
            <!-- Start DOCUMENTAÇÃO here -->
            <!-- ============================================================== -->
            <li class="menu menu-single">
                <a href="{{ route('documentacao') }}" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                    </div>
                </a>
                <div class="tooltip"><span>Documentação</span></div>
            </li>
        </ul>

        <div class="sidebar-bottom-actions">
            <!-- ============================================================== -->
            <!-- Start AVATAR here -->
            <!-- ============================================================== -->
            <div class="dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('assets/img/profile-7.jpg') }}" class="img-fluid" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="dropdown-inner">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <img src="{{ asset('assets/img/profile-7.jpg') }}" class="img-fluid mr-2"
                                    alt="avatar">
                                {{-- <img src="{{ asset('uploads/' . $fotoPerfil) }}" class="img-fluid mr-2"
                                    alt="avatar"> --}}

                                <div class="media-body">
                                    <h5>{{ $nome }}</h5>
                                    <p>{{ $perfil }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span> PERFIL</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <span>
                                <a href="{{ route('logout') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12">
                                        </line>
                                    </svg>
                                    SAIR
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </nav>

    <div id="compact_submenuSidebar" class="submenu-sidebar">

        <div class="submenu" id="dashboard">
            <ul class="submenu-list" data-parent-element="#dashboard">
                <li class="active">
                    <a href="index-2.html"> Analytics </a>
                </li>
                <li>
                    <a href="index2.html"> Sales </a>
                </li>
            </ul>
        </div>

        <div class="submenu" id="app">
            <div class="menu-title">
                <h3>Menu 2</h3>
            </div>
            <ul class="submenu-list" data-parent-element="#app">
                <li>
                    <a href="javascript:void(0)"> Submenu 1 </a>
                </li>
                <li>
                    <a href="javascript:void(0)"> Submenu 2 </a>
                </li>
            </ul>
        </div>

        <div class="submenu" id="tables">
            <div class="menu-title">
                <h3>Tables</h3>
            </div>
            <ul class="submenu-list" data-parent-element="#tables">
                <li>
                    <a href="javascript:void(0);">Submenu 1 </a>
                </li>
                <li>
                    <a href="javascript:void(0);">Submenu 2 </a>
                </li>
                <li class="sub-submenu">
                    <a role="menu" class="collapsed" data-toggle="collapse" data-target="#datatables"
                        aria-expanded="true">
                        <div>Submenu 3</div> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul id="datatables" class="collapse show" data-parent="#compact_submenuSidebar">
                        <li>
                            <a href="javascript:void(0);"> Sub Submenu 1 </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"> Sub Submenu 2 </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"> Sub Submenu 2 </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="submenu" id="more">
            <div class="menu-title">
                <h3>Starter Kit</h3>
            </div>
            <ul class="submenu-list" data-parent-element="#more">
                <li class="active">
                    <a href="starter_kit_blank_page.html">Blank Page</a>
                </li>
                <li>
                    <a href="starter_kit_breadcrumb.html">Breadcrumb</a>
                </li>
                <li>
                    <a href="starter_kit_boxed.html">Boxed</a>
                </li>
                <li>
                    <a href="starter_kit_single_click_menu.html">Single Click Menu</a>
                </li>
            </ul>
        </div>

    </div>

</div>
