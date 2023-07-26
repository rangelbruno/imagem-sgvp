<x-layouts.app title="Gerenciar Sessão" namepage="Gerenciar Sessão">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    @push('styles')
    <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/forms/theme-checkbox-radio.css') }}">
    <link href="{{ url('assets/plugins/tagInput/tags-input.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/forms/switches.css') }}">
    @endpush
    <!-- ============================================================== -->
    <!-- Start CONTENT here -->
    <!-- ============================================================== -->
    <div class="row layout-top-spacing" id="cancel-row">

        <div id="custom_styles" class="col-lg-12 layout-spacing col-md-12">
            <!-- ============================================================== -->
            <!-- Start MENSAGEM here -->
            <!-- ============================================================== -->
            @include('sessao.includes.mensagem')
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
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-cast">
                                                <path
                                                    d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6">
                                                </path>
                                                <line x1="2" y1="20" x2="2.01" y2="20">
                                                </line>
                                            </svg> SESSÃO</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span>EDITAR ROTEIRO</span>
                                    </li>
                                </ol>
                            </nav>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <form action="{{ route('roteiro.atualizar', $roteiro[0]['nrSequence']) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        <!-- ============================================================== -->
                        <!-- Start FORMULÁRIO here -->
                        <!-- ============================================================== -->
                        @include('sessao.gerenciar.roteiro._partials.form')
                        <button class="btn btn-primary  mt-3" type="submit">SALVAR</button>
                    </form>

                    <div class="text-center">
                        <form action="{{ route('roteiro.excluir', ['nrSequence' => $roteiro[0]['nrSequence']]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <button id="delete-btn" class="btn btn-outline-danger warning confirm mt-3" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg> EXCLUIR</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPTS here -->
    <!-- ============================================================== -->
    @push('scripts')
    <script src="{{ url('assets/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ url('assets/plugins/input-mask/input-mask.js') }}"></script>
    <script src="{{ url('assets/plugins/sweetalerts/sweetalert2.min.js') }}"></script>


    <script>
    $('.widget-content .warning.confirm').on('click', function(event) {
        event.preventDefault(); // impede o envio do formulário padrão
        swal({
            title: 'Você tem certeza?',
            text: "Você não poderá reverter isso!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Excluir',
            cancelButtonText: "Cancelar",
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $('form').submit(); // envia o formulário para excluir o documento
                swal(
                    'Deletado!',
                    'Documento deletado com sucesso.',
                    'success'
                )
            }
        })
    })
    </script>
    @endpush
</x-layouts.app>