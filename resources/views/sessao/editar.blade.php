<x-layouts.app title="Sessão" namepage="Sessão">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    @push('styles')
        <link href="{{ url('assets/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"
            type="text/css" />
    @endpush
    <!-- ============================================================== -->
    <!-- Start CONTENT here -->
    <!-- ============================================================== -->
    <div class="row layout-top-spacing" id="cancel-row">

        <div id="custom_styles" class="col-lg-12 layout-spacing col-md-12">
            <!-- ============================================================== -->
            <!-- Start MENSAGEM here -->
            <!-- ============================================================== -->
            @include('usuarios.includes.mensagem')
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <!-- ============================================================== -->
                            <!-- Start NAV here -->
                            <!-- ============================================================== -->
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
                                        <a href="{{ route('sessao.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-cast">
                                                <path
                                                    d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6">
                                                </path>
                                                <line x1="2" y1="20" x2="2.01" y2="20">
                                                </line>
                                            </svg> SESSÃO</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span>EDITAR SESSÃO</span>
                                    </li>
                                </ol>
                            </nav>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <form action="{{ route('sessao.update', $sessao[0]['nrSequence']) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        <!-- ============================================================== -->
                        <!-- Start FORMULÁRIO here -->
                        <!-- ============================================================== -->

                        @include('sessao._partials.form')


                        <div class="form-row mb-4">

                        </div>

                        <button class="btn btn-primary  mt-3" type="submit">SALVAR</button>
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
            $(document).ready(function() {
                // função para exibir ou ocultar os campos de nomePolitico e partido
                function showHideFields() {
                    var perfil = $('#perfil').val();
                    if (perfil === 'VEREADOR' || perfil === 'PRESIDENTE') {
                        $('.contact-nomePolitico').show();
                        $('.contact-partido').show();
                    } else {
                        $('.contact-nomePolitico').hide();
                        $('.contact-partido').hide();
                    }
                }

                // chama a função quando a página é carregada
                showHideFields();

                // chama a função quando o valor do campo perfil é alterado
                $('#perfil').on('change', function() {
                    showHideFields();
                });
            });
        </script>


        <script src="{{ url('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ url('assets/js/forms/bootstrap_validation/bs_validation_script.js') }}"></script>
        <script src="{{ url('assets/js/apps/contact.js') }}"></script>
        <script src="{{ url('assets/js/scrollspyNav.js') }}"></script>
        <script src="{{ url('assets/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
        <script src="{{ url('assets/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
        <script src="{{ url('assets/plugins/input-mask/input-mask.js') }}"></script>
        <script src="{{ url('assets/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
        <script>
            //First upload
            var firstUpload = new FileUploadWithPreview('myFirstImage')
            //Second upload
            var secondUpload = new FileUploadWithPreview('mySecondImage')
        </script>
    @endpush
</x-layouts.app>
