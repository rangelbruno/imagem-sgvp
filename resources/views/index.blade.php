<x-layouts.app title="Bem-vindo" namepage="Bem-vindo(a) {{ $nome }}">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    @push('styles')
        <link href="{{ url('assets/css/elements/infobox.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget widget-content-area br-4">
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- Start Page USUÁRIOS here -->
                    <!-- ============================================================== -->
                    <div class="col-12 col-xl-6 col-lg-12 mb-xl-5 mb-5 ">
                        <!-- ============================================================== -->
                        <!-- Start MENSAGEM here -->
                        <!-- ============================================================== -->
                        @include('login.includes.msg')
                        <div class="infobox-3">
                            <div class="info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h5 class="info-heading mb-3">USUÁRIOS</h5>
                            <p class="info-text"> </p>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary mb-2"
                                data-active="false" class="menu-toggle">Entrar</a>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Start Page SESSÃO here -->
                    <!-- ============================================================== -->
                    <div class="col-12 col-xl-6 col-lg-12 mb-xl-5 mb-5 ">
                        <div class="infobox-3">
                            <div class="info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-cast">
                                    <path
                                        d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6">
                                    </path>
                                    <line x1="2" y1="20" x2="2.01" y2="20"></line>
                                </svg>
                            </div>
                            <h5 class="info-heading mb-3">SESSÃO</h5>
                            <p class="info-text"> </p>
                            <a href="{{ route('sessao.index') }}" class="btn btn-outline-primary mb-2"
                                data-active="false" class="menu-toggle">Entrar</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
