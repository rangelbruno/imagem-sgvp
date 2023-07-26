<x-layouts.app title="Documentos" namepage="Gereciar documentos">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    @push('styles')
    <link href="{{ url('assets/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/plugins/table/datatable/dt-global_style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/forms/theme-checkbox-radio.css') }}">
    <link href="{{ url('assets/plugins/tagInput/tags-input.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/forms/switches.css') }}">
    <link href="{{ url('assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('assets/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <!-- ============================================================== -->
    <!-- Start CONTENT here -->
    <!-- ============================================================== -->

    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <!-- ============================================================== -->
            <!-- Start MENSAGEM here -->
            <!-- ============================================================== -->
            @include('sessao.includes.mensagem')
            <div class="widget-content widget-content-area br-6">
                <!-- ============================================================== -->
                <!-- Start NAV here -->
                <!-- ============================================================== -->
                <nav class="breadcrumb-one mt-3 ml-2" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('sessao.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-cast">
                                    <path
                                        d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6">
                                    </path>
                                    <line x1="2" y1="20" x2="2.01" y2="20">
                                    </line>
                                </svg> SESSÃO</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>GERENCIAR DOCUMENTOS</span>
                        </li>
                    </ol>
                </nav>
                <hr>
                <!-- ============================================================== -->
                <!-- Start Botão nova sessão here -->
                <!-- ============================================================== -->
                <h5 class="ml-3 mt-3 mb-3">
                    <a href="{{ route('documento.cadastrar', $sessao[0]['nrSequence']) }}"
                        class="btn btn-success mb-2 mr-2">CADASTRAR DOCUMENTO</a>


                    @if (count($roteiro) > 0)
                    @foreach ($roteiro as $roteiro)
                    @if (!empty($roteiro['docRoteiro']))
                    <a href="{{ route('roteiro.editar', ['nrSequence' => $roteiro['nrSequence']]) }}"
                        class="btn btn-outline-secondary mb-2 mr-2 " title="Editar"
                        data-id="{{ $roteiro['nrSequence'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        EDITAR ROTEIRO
                    </a>
                    @else
                    <!-- Caso queira exibir uma mensagem -->
                    @endif
                    @endforeach
                    @else
                    <!-- Botão para incluir um novo roteiro -->
                    <a href="{{ route('roteiro.cadastrar', $sessao[0]['nrSequence']) }}"
                        class="btn btn-outline-dark mb-2 ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg> INCLUIR ROTEIRO</a>
                    @endif


                </h5>

                <hr>
                <!-- ============================================================== -->
                <!-- Start chamada da tabela sessão here -->
                <!-- ============================================================== -->
                @include('sessao.gerenciar.includes.tabela')

                <br>

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPTS here -->
    <!-- ============================================================== -->
    @push('scripts')
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

    <script src="{{ url('assets/plugins/table/datatable/datatables.js') }}"></script>

    <script>
    $('#zero-config').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando de _PAGE_ até _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Registro :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });
    </script>
    @endpush
</x-layouts.app>