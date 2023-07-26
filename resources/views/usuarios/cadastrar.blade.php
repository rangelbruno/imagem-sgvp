<x-layouts.app title="Usuários" namepage="Usuários">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    @push('styles')
        <link href="{{ url('assets/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <!-- ============================================================== -->
    <!-- Start CONTENT here -->
    <!-- ============================================================== -->
    <div class="row layout-top-spacing" id="cancel-row">
        <!-- ============================================================== -->
        <!-- Start MENSAGEM here -->
        <!-- ============================================================== -->
        @include('usuarios.includes.mensagem')
        <div id="custom_styles" class="col-lg-12 layout-spacing col-md-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <nav class="breadcrumb-one mt-3 ml-2" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.home') }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-home">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('usuarios.index') }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-users">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg> USUÁRIOS</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span>CADASTAR USUÁRIO</span>
                                    </li>
                                </ol>
                            </nav>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form class="needs-validation" novalidate action="{{ route('usuarios') }}" method="POST"
                        enctype="multipart/form-data">
                        <!-- ============================================================== -->
                        <!-- Start FORMULÁRIO here -->
                        <!-- ============================================================== -->
                        @include('usuarios._partials.form')
                        <button class="btn btn-primary  mt-3" type="submit">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPTS here -->
    <!-- ============================================================== -->
    @push('scripts')
        <script>
            const perfilSelect = document.getElementById('perfil');
            const nomePolitico = document.querySelector('.contact-nomePolitico');
            const partido = document.querySelector('.contact-partido');

            function handlePerfilSelect() {
                if (perfilSelect.value === 'PRESIDENTE' || perfilSelect.value === 'VEREADOR') {
                    nomePolitico.style.display = 'block';
                    partido.style.display = 'block';
                } else {
                    nomePolitico.style.display = 'none';
                    partido.style.display = 'none';
                }
            }

            perfilSelect.addEventListener('change', handlePerfilSelect);
        </script>
        <script src="{{ url('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ url('assets/js/forms/bootstrap_validation/bs_validation_script.js') }}"></script>
        <script src="{{ url('assets/js/apps/contact.js') }}"></script>
        <script src="{{ url('assets/js/scrollspyNav.js') }}"></script>
        <script src="{{ url('assets/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
        <script src="{{ url('assets/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
        <script src="{{ url('assets/plugins/input-mask/input-mask.js') }}"></script>
        <script>
            //First upload
            var firstUpload = new FileUploadWithPreview('myFirstImage')
            //Second upload
            var secondUpload = new FileUploadWithPreview('mySecondImage')
        </script>
    @endpush
</x-layouts.app>
