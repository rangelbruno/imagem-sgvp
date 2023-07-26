<x-layouts.app title="Usuários" namepage="Usuários">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    @push('styles')
        <link href="{{ url('assets/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/plugins/table/datatable/dt-global_style.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ url('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/apps/contacts.css') }}" rel="stylesheet" type="text/css" />
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
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <!-- ============================================================== -->
            <!-- Start MENSAGEM here -->
            <!-- ============================================================== -->
            @include('usuarios.includes.mensagem')
            <div class="widget-content widget-content-area br-6">
                <nav class="breadcrumb-one mt-3 ml-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg> USUÁRIOS</span>
                        </li>
                    </ol>
                </nav>
                <hr>

                <h5 class="ml-3 mt-3 mb-3">
                    <a href="{{ route('usuarios.cadastrar') }}" class="btn btn-success mb-2 mr-2">Cadastrar</a>
                </h5>
                <hr>
                <table id="usuarios" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th class="no-content">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPTS here -->
    <!-- ============================================================== -->
    @push('scripts')
        <script src="{{ url('assets/plugins/table/datatable/datatables.js') }}"></script>

        <script>
            $('#usuarios').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('getusers') }}',
                "columns": [{
                        data: "nrSequence"
                    },
                    {
                        data: "nomeCompleto"
                    },
                    {
                        data: "cpf"
                    },
                    {
                        data: "perfil"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                oLanguage: {
                    oPaginate: {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    sInfo: "Mostrando de _PAGE_ até _PAGES_",
                    sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    sSearchPlaceholder: "Buscar...",
                    sLengthMenu: "_MENU_ resultados",
                },
                stripeClasses: [],
                lengthMenu: [7, 10, 20, 50],
                pageLength: 7
            });
        </script>

        <script src="{{ url('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ url('assets/js/apps/contact.js') }}"></script>
        <script src="{{ url('assets/js/scrollspyNav.js') }}"></script>
        <script src="{{ url('assets/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
        <script>
            //First upload
            var firstUpload = new FileUploadWithPreview('myFirstImage')
            //Second upload
            var secondUpload = new FileUploadWithPreview('mySecondImage')
        </script>
    @endpush
</x-layouts.app> 
