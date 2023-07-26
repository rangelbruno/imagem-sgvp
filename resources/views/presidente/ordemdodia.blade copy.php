@component('presidente.components.layouts.app')
    <meta name="nr-sequence" content="{{ session('nrSequence') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ url('assets/css/home.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/animate/animate.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('assets/css/components/custom-modal.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('assets/css/clock.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/table/datatable/datatables.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('assets/plugins/table/datatable/dt-global_style.css') }}"
        rel="stylesheet" type="text/css" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .embed-pdf {
            width: 100%;
            height: calc(100vh - 200px);
            /* Substitua '200px' pela altura do cabeçalho e rodapé do modal */
        }

    </style>


    <!-- ============================================================== -->
    <!-- Start ESQUERDA here -->
    <!-- ============================================================== -->
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>

        <div class="p-4">
            <!-- ============================================================== -->
            <!-- Start AVATAR here -->
            <!-- ============================================================== -->
            <div class="text-center avatar avatar-xl">
                <img alt="avatar" src="{{ asset('uploads/' . $fotoPerfil) }}"
                    class="rounded-circle" width="90" height="90" />
                <p class="text-white"></p>
                <div class="btn-group mb-4 mr-2" role="group">
                    <button id="btnOutline" type="button" class="btn btn-outline-white dropdown-toggle text-center"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $nome }}
                        - ({{ $partido }}) <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></button>
                    <div class="dropdown-menu" aria-labelledby="btnOutline">
                        <a href="{{ route('logout') }}" class="dropdown-item"><i
                                class="flaticon-home-fill-1 mr-1"></i>FINALIZAR</a>

                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Start EXPEDIENTE & ORDEM DO DIA & SUSPENDER here -->
            <!-- ============================================================== -->
            <div class="text-center">
                <a class="btn btn-success btn-block mb-4 mr-2">ORDEM DO DIA</a>
            </div>

            <!-- ============================================================== -->
            <!-- Start RELÓGIO here -->
            <!-- ============================================================== -->
            <div id="clock-container">
                <h5 id="title">Horário</h5>
                <div id="clock"></div>
                <h5 id="countdown-title">Tempo da sessão</h5>
                <div id="countdown"></div>
            </div>
            <!-- ============================================================== -->
            <!-- Start SUSPENDER here -->
            <!-- ============================================================== -->
            <div class="text-center mt-5">
                {{-- <button type="button" class="btn btn-warning btn-block warning finalizarSessao mb-4 mr-2">
                    ENCERRAR SESSÃO
                </button> --}}
                <button type="button" class="btn btn-warning btn-block warning finalizarSessao mb-4 mr-2"
                    data-nr-sequence="{{ $nrSequence }}">
                    ENCERRAR SESSÃO
                </button>

            </div>
            <div class="text-center mt-5">
                <button type="button" class="btn btn-dark btn-block warning suspender mb-4 mr-2">
                    SUSPENDER
                </button>
            </div>
            <!-- ============================================================== -->
            <!-- Start FOOTER here -->
            <!-- ============================================================== -->
            <div class="footer sticky-footer">
                <p>
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());

                    </script> Todos os direitos reservados.
                </p>
            </div>

        </div>
    </nav>
    <!-- ============================================================== -->
    <!-- Start DIREITA here -->
    <!-- ============================================================== -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <div class="widget-content widget-content-area">
            <!-- ============================================================== -->
            <!-- Start NOME DA SESSÃO here -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-lg-12 text-center">
                    @if(empty($sessoes))
                        <div class="font-family-text">
                            <h3>Nenhuma sessão encontrada.</h3>
                        </div>
                    @else
                        @foreach($sessoes as $sessao)
                            <div class="font-family-text">
                                <u>
                                    <h3 class="text-uppercase mt-3">{{ $sessao['nomeSessao'] }}
                                    </h3>
                                </u>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <hr>
            <!-- ============================================================== -->
            <!-- Start ROTEIRO & TRIBUNA & VOTAÇÃO & PRESENTES E AUSENTES -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-6 text-center mb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                data-target=".bd-example-modal-roteiro" data-title="roteiro">
                                ROTEIRO
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>
                                <a class="btn btn-outline-success" data-title="{{ $totalVereadoresOnline }}">
                                    PRESENTES: <b>{{ $totalVereadoresOnline }}</b>
                                </a>
                            </h6>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>
                                <a class="btn btn-outline-danger">
                                    PRESENTES: <b>{{ $totalVereadores - $totalVereadoresOnline }}</b>
                                </a>
                            </h6>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="widget-content widget-content-area">
            <!-- ============================================================== -->
            <!-- Start ALERTA PREPARAR VOTAÇÃO here -->
            <!-- ============================================================== -->
            @include('presidente.includes.alertas.preparar_votacao')
            <!-- ============================================================== -->
            <!-- Start BOTÃO VOTAÇÃO E VOTAÇÃO EM BLOCO here -->
            <!-- ============================================================== -->

            {{-- <div class="text-right mt-3 mr-3">
                <a href="#" class="btn btn-outline-primary ml-2" id="prepare-voting-button"
                    style="display: none;">Prepara Votação</a>
                <a href="#" class="btn btn-outline-success ml-2" id="voting-button" style="display: none;"
                    data-toggle="modal" data-target=".bd-example-modal-lg">VOTAÇÃO</a>
                <a href="#" class="btn btn-outline-success ml-2" id="bulk-voting-button" style="display: none;"
                    data-toggle="modal" data-target=".bd-example-modal-bloco">VOTAÇÃO EM BLOCO</a>
                <a href="#" class="btn btn-outline-primary ml-2" id="prepare-bulk-voting-button"
                    style="display: none;">Prepara Votação em Bloco</a>
            </div> --}}
            <div class="text-right mt-3 mr-3">
                <a href="#" class="btn btn-outline-primary ml-2" id="prepare-voting-button"
                    style="display: none;">Prepara
                    Votação</a>
                <a href="#" class="btn btn-outline-success ml-2" id="voting-button" style="display: none;"
                    data-toggle="modal" data-target=".bd-example-modal-lg">VOTAÇÃO</a>
            </div>

            <hr>
            <!-- ============================================================== -->
            <!-- Start TABELA DOS DOCUMENTOS DA SESSÃO here -->
            <!-- ============================================================== -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="checkbox-column">
                                <label class="new-control new-checkbox checkbox-primary"
                                    style="height: 18px; margin: 0 auto;">
                                    <input type="checkbox" class="new-control-input todochkbox" id="todoAll">
                                    <span class="new-control-indicator"></span>
                                </label>
                            </th>
                            <th>NOME</th>
                            <th>AUTOR</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Os dados serão renderizados aqui pelo JavaScript -->
                    </tbody>
                </table>
            </div>
            <!-- ============================================================== -->
            <!-- Start JS DA TABELA here -->
            <!-- ============================================================== -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const tableBody = document.getElementById('tableBody');
                    const todoAllCheckbox = document.getElementById('todoAll');

                    const checkboxes = tableBody.querySelectorAll('.new-control-input');

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('click', function () {
                            checkboxes.forEach(cb => {
                                cb.checked = cb === checkbox;
                            });
                            updateButtons();
                        });
                    });

                    const updateButtons = () => {
                        const checkedCheckbox = tableBody.querySelector('.new-control-input:checked');
                        const prepareVotingButton = document.getElementById('prepare-voting-button');
                        const votingButton = document.getElementById('voting-button');

                        if (checkedCheckbox) {
                            const status = checkedCheckbox.getAttribute('data-status');
                            prepareVotingButton.style.display = status === 'CADASTRADO' ? 'inline-block' :
                                'none';
                            votingButton.style.display = status === 'VOTACAO' ? 'inline-block' : 'none';
                        } else {
                            prepareVotingButton.style.display = 'none';
                            votingButton.style.display = 'none';
                        }
                    };

                    const documentos = @json($documentos);

                    let html = '';

                    documentos.forEach(documento => {
                        const pdfPath = '{{ asset('
                        uploads / ') }}' + '/' + documento.pdf;

                        html += `
                            <tr>
                                <td class="checkbox-column">
                                    <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                                        <input type="checkbox" class="new-control-input todochkbox" data-status="${documento.status}" data-nrsequence="${documento.nrSequence}">
                                        <span class="new-control-indicator"></span>
                                    </label>
                                </td>
                                <td class="text-uppercase documento-titulo" data-pdf-path="${pdfPath}">${documento.titulo}</td>
                                <td class="text-uppercase">${documento.autor}</td>
                            </tr>
                        `;
                    });

                    tableBody.innerHTML = html;

                    const todoAllCheckboxListener = function () {
                        setTimeout(() => {
                            const checkboxes = tableBody.querySelectorAll('.new-control-input');
                            checkboxes.forEach(checkbox => {
                                if (checkbox.getAttribute('data-status') === 'CADASTRADO') {
                                    checkbox.checked = true;
                                }
                            });
                            todoAllCheckbox.checked =
                            false; // desmarca o checkbox todoAll após a seleção
                            updateButtons(); // Atualiza os botões de acordo com a seleção
                        }, 0);
                    };

                    todoAllCheckbox.addEventListener('click', todoAllCheckboxListener);

                    tableBody.addEventListener('click', function (event) {
                        if (event.target.classList.contains('documento-titulo')) {
                            const titulo = event.target.textContent;
                            const pdfPath = event.target.getAttribute('data-pdf-path');
                            openModalWithPDF(titulo, pdfPath);
                        }
                    });

                    function openModalWithPDF(titulo, pdfPath) {
                        const modalTitleElement = document.getElementById('myExtraLargeModalLabel');
                        const modalPdfElement = document.getElementById('modalPdf');
                        const documentPathElement = document.getElementById('documentPath');
                        const noPdfMessageElement = document.getElementById('noPdfMessage');

                        modalTitleElement.textContent = titulo;
                        modalPdfElement.innerHTML = '';

                        if (pdfPath) {
                            const embedElement = document.createElement('embed');
                            embedElement.src = pdfPath;
                            embedElement.type = 'application/pdf';
                            embedElement.classList.add('embed-pdf');
                            modalPdfElement.appendChild(embedElement);
                            noPdfMessageElement.style.display = 'none';
                        } else {
                            modalPdfElement.innerHTML = '';
                            documentPathElement.textContent = '';
                            noPdfMessageElement.style.display = 'block';
                        }

                        $('#myModal').modal('show');
                    }

                    updateButtons();
                });

            </script>
            <!-- ============================================================== -->
            <!-- Start MODAL DOCUMENTO here -->
            <!-- ============================================================== -->
            <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase" id="myExtraLargeModalLabel">Extra Large</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div id="modalPdf"></div>
                        <div class="modal-body">

                            <p id="noPdfMessage" style="display: none;">Não existe documento cadastrado.</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                                Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPT PREPARAR VOTAÇÃO here -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function () {
            // Esconde o botão de votação quando a página é carregada
            $('#voting-button').hide();
            $('#prepare-voting-button').hide(); // Esconde o botão de preparar votação
            $('.alert').hide(); // Esconde o alerta

            // Variável para armazenar o nrSequenceDocumento
            var nrSequenceDocumento;

            // Quando um checkbox é clicado
            $(".new-control-input").change(function () {
                // Verifica se algum checkbox está selecionado
                var checkboxSelected = $(".new-control-input:checked").length > 0;

                if (checkboxSelected) {
                    // Pega o nrSequence do documento a partir do atributo data-nrsequence
                    nrSequenceDocumento = $(this).data('nrsequence');
                    // Armazena o nrSequence no modal
                    $('.bd-example-modal-lg').data('nrsequence', nrSequenceDocumento);
                    // Armazena o nrSequence no botão de acompanhamento de votação
                    $('#acompanhar-votacao').data('nrsequence', nrSequenceDocumento);
                    // Mostra o botão de votação
                    $('#voting-button').show();

                    // Verifica o status do documento
                    var statusDocumento = $(this).data('status');
                    if (statusDocumento !== 'VOTACAO') {
                        // Mostra o botão de preparar votação
                        $('#prepare-voting-button').show().data('nrsequence', nrSequenceDocumento);
                    } else {
                        // Esconde o botão de preparar votação
                        $('#prepare-voting-button').hide();
                    }

                    // Destaca a linha do documento selecionado
                    $('.document-row-' + nrSequenceDocumento).addClass('highlight-row');
                } else {
                    // Nenhum checkbox está selecionado, esconde o botão de votação e preparar votação
                    $('#voting-button').hide();
                    $('#prepare-voting-button').hide();
                    // Remove o destaque de todas as linhas de documentos
                    $('.highlight-row').removeClass('highlight-row');
                }
            });

            // Quando o botão "Preparar Votação" é clicado
            $('#prepare-voting-button').click(function () {
                // Recupera o nrSequenceDocumento a partir do botão
                var nrSequenceDocumento = $(this).data('nrsequence');

                // Verifica se nrSequenceDocumento é válido
                if (!nrSequenceDocumento) {
                    $('.alert strong').text('Error! Número de sequência do documento não encontrado!');
                    $('.alert').show();
                    return;
                }

                // Envia a requisição para alterar o status do documento
                $.ajax({
                    url: "/votacao/preparar/" + nrSequenceDocumento,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    contentType: "application/json",
                    data: JSON.stringify({
                        statusDocumento: "VOTACAO"
                    }),
                    success: function (response) {
                        // Esconde o botão de preparar votação
                        $('#prepare-voting-button').hide();
                        // Destaca a linha do documento selecionado
                        $('.document-row-' + nrSequenceDocumento).addClass('highlight-row');
                        // Altera a classe do alerta para sucesso
                        $('.alert').removeClass('alert-light-danger').addClass(
                            'alert-light-success');
                        // Atualiza o texto do alerta com a mensagem de sucesso
                        $('.alert strong').text(response.message);
                        // Mostra o alerta
                        $('.alert').show();
                    },
                    error: function (error) {
                        // Mostra a mensagem de erro da API, se disponível
                        var errorMsg = error.responseJSON && error.responseJSON.message ?
                            error
                            .responseJSON.message :
                            "Erro ao preparar a votação, por favor tente novamente.";
                        // Altera a classe do alerta para erro
                        $('.alert').removeClass('alert-light-success').addClass(
                            'alert-light-danger');
                        // Atualiza o texto do alerta com a mensagem de erro
                        $('.alert strong').text('Error! ' + errorMsg);
                        // Mostra o alerta
                        $('.alert').show();
                    }
                });
            });
        });

    </script>
    <!-- ============================================================== -->
    <!-- Start SCRIPT PREPARAR VOTAÇÃO EM BLOCO here -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function () {
            // Esconde o botão de votação em bloco quando a página é carregada
            $('#bulk-voting-button').hide();
            $('#prepare-bulk-voting-button').hide(); // Esconde o botão de preparar votação em bloco
            $('.alert').hide(); // Esconde o alerta

            // Quando um checkbox é clicado
            $(".new-control-input").change(function () {
                // Verifica se algum checkbox está selecionado
                var checkboxSelected = $(".new-control-input:checked").length > 0;

                if (checkboxSelected) {
                    // Mostra o botão de votação em bloco
                    $('#bulk-voting-button').show();

                    // Verifica o status dos documentos selecionados
                    var documentosSelecionados = [];
                    $(".new-control-input:checked").each(function () {
                        var statusDocumento = $(this).data('status');
                        if (statusDocumento !== 'VOTACAO') {
                            // Adiciona o número de sequência do documento aos documentos selecionados
                            documentosSelecionados.push($(this).data('nrsequence'));
                        }
                    });

                    if (documentosSelecionados.length > 0) {
                        // Mostra o botão de preparar votação em bloco
                        $('#prepare-bulk-voting-button').show().data('documentos',
                            documentosSelecionados);
                    } else {
                        // Esconde o botão de preparar votação em bloco
                        $('#prepare-bulk-voting-button').hide();
                    }
                } else {
                    // Nenhum checkbox está selecionado, esconde o botão de votação em bloco e preparar votação em bloco
                    $('#bulk-voting-button').hide();
                    $('#prepare-bulk-voting-button').hide();
                }
            });

            // Quando o botão "Preparar Votação em Bloco" é clicado
            $('#prepare-bulk-voting-button').click(function () {
                // Recupera os documentos selecionados
                var documentosSelecionados = $(this).data('documentos');

                // Verifica se existem documentos selecionados
                if (!documentosSelecionados || documentosSelecionados.length === 0) {
                    $('.alert strong').text(
                        'Error! Nenhum documento selecionado para preparar votação em bloco!');
                    $('.alert').show();
                    return;
                }

                // Monta o objeto de dados para a requisição
                var requestData = {
                    statusDocumento: 'VOTACAO',
                    documentos: documentosSelecionados
                };

                // Envia a requisição para preparar a votação em bloco
                $.ajax({
                    url: "/documento/preparar-votacao-bloco",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    contentType: "application/json",
                    data: JSON.stringify(requestData),
                    success: function (response) {
                        // Esconde o botão de preparar votação em bloco
                        $('#prepare-bulk-voting-button').hide();
                        // Mostra o alerta de sucesso
                        showSuccessAlert(response.message);
                    },
                    error: function (error) {
                        // Mostra a mensagem de erro da API, se disponível
                        var errorMsg = error.responseJSON && error.responseJSON.message ?
                            error
                            .responseJSON.message :
                            "Erro ao preparar a votação em bloco, por favor tente novamente.";
                        // Mostra o alerta de erro
                        showErrorAlert(errorMsg);
                    }
                });
            });

            // Função para mostrar o alerta de sucesso
            function showSuccessAlert(message) {
                $('.alert').removeClass('alert-light-danger').addClass('alert-light-success');
                $('.alert strong').text(message);
                $('.alert').show();
            }

            // Função para mostrar o alerta de erro
            function showErrorAlert(message) {
                $('.alert').removeClass('alert-light-success').addClass('alert-light-danger');
                $('.alert strong').text('Error! ' + message);
                $('.alert').show();
            }
        });

    </script>






    <!-- ============================================================== -->
    <!-- Start SCRIPT RELÓGIO here -->
    <!-- ============================================================== -->
    <script src="{{ url('assets/js/presidentehome/timer.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Start CRONÔMETRO here -->
    <!-- ============================================================== -->
    <script src="{{ url('assets/js/presidentehome/cronometro.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Start MODAL VOTAÇÃO here -->
    <!-- ============================================================== -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="document-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">
                        <button class="btn btn-success mb-4 mr-3 btn-lg vote-button" data-vote="SIM">SIM</button>
                        <button class="btn btn-danger mb-4 mr-3 btn-lg vote-button" data-vote="NAO">NÃO</button>
                        <button class="btn btn-dark mb-4 btn-lg vote-button" data-vote="abster">ABSTER</button>
                    </p>
                    <div id="vote-message" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="acompanhar-votacao">Acompanhar votação</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPT MODAL VOTAÇÃO here -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function () {
            // Esconde o botão de votação quando a página é carregada
            $('#voting-button').hide();
            $('#vote-message').hide();

            // Variável para armazenar o nrSequenceDocumento
            var nrSequenceDocumento;

            // Quando um checkbox é clicado
            $(".new-control-input").click(function () {
                var documentoTitle = $(this).closest("tr").find("td:nth-child(2)").text();
                $("#document-title").text(documentoTitle);
                // Pega o nrSequence do documento a partir do atributo data-nrsequence
                nrSequenceDocumento = $(this).data('nrsequence');
                // Armazena o nrSequence no modal
                $('.bd-example-modal-lg').data('nrsequence', nrSequenceDocumento);
                // Armazena o nrSequence no botão de acompanhamento de votação
                $('#acompanhar-votacao').data('nrsequence', nrSequenceDocumento);
                // Mostra o botão de votação
                $('#voting-button').show();
            });

            // Quando o modal é aberto
            $(".bd-example-modal-lg").on("shown.bs.modal", function () {
                var titulo = $('#voting-button').data('titulo');
                $("#myLargeModalLabel").text(titulo);
                // Emitir o evento do Pusher para o canal 'modal-channel'
                var pusher = new Pusher('875de7708', {
                    cluster: 'sa1',
                    encrypted: true
                });

                var channel = pusher.subscribe('modal-channel');
                channel.bind('server-modal-open', function (data) {
                    console.log(data.message);
                });

                // Obtenha o título do documento a partir do atributo data-titulo do botão de votação
                var titulo = $('#voting-button').data('titulo');
                // Enviar o título como parte do POST Ajax para o Laravel
                $.post("/modal-open", {
                    _token: "{{ csrf_token() }}",
                    titulo: titulo,
                    nrSequenceDocumento: nrSequenceDocumento
                });
            });

            // Quando o botão de votação é clicado
            $(".vote-button").click(function () {
                // Recupera o voto a partir do atributo data-vote do botão clicado
                var vote = $(this).data('vote');
                // Recupera o nrSequenceUsuario a partir da metatag
                var nrSequenceUsuario = $('meta[name="nr-sequence"]').attr('content');
                // Recupera o nrSequenceDocumento a partir do modal
                var nrSequenceDocumento = $('.bd-example-modal-lg').data('nrsequence');
                // Esconde os botões de votação
                $(this).parent().hide();

                // Cria o objeto de dados para enviar para a API
                var dadosVoto = {
                    usuarioVoto: {
                        nrSequence: nrSequenceUsuario
                    },
                    documento: {
                        nrSequence: nrSequenceDocumento
                    },
                    voto: vote
                };

                // Envia a votação para o endpoint da API
                $.ajax({
                    url: "/votacao",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    contentType: "application/json",
                    data: JSON.stringify(dadosVoto),
                    success: function (response) {
                        // Mostra a mensagem de sucesso e esconde os botões
                        $('#vote-message').text(response.message).show();
                    },
                    error: function (error) {
                        // Mostra a mensagem de erro da API, se disponível
                        var errorMsg = error.responseJSON && error.responseJSON.message ?
                            error.responseJSON.message :
                            "Erro ao enviar a votação, por favor tente novamente.";
                        $('#vote-message').text(errorMsg).show();
                    }
                });
            });

            // Quando o botão "Acompanhar votação" é clicado
            $("#acompanhar-votacao").click(function () {
                // Recupera o nrSequence a partir do atributo data-nrsequence do botão
                var nrSequence = $(this).data('nrsequence');
                // Redireciona para a rota de votação
                window.location.href = "/votacao/" + nrSequence;
            });

        });

    </script>
    <!-- ============================================================== -->
    <!-- Start MODAL VOTAÇÃO EM BLOCO here -->
    <!-- ============================================================== -->
    <div class="modal fade bd-example-modal-bloco" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="myLargeModalLabel">VOTAÇÃO EM BLOCO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">
                        <span id="selected-documents-list" class="text-uppercase text-left"></span>
                    </p>
                    <div id="vote-message"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success mb-4 mr-3 btn-lg vote-button-bloco" data-vote="SIM">SIM</button>
                    <button class="btn btn-danger mb-4 btn-lg vote-button-bloco" data-vote="NAO">NÃO</button>
                    <button class="btn btn-dark mb-4 btn-lg vote-button-bloco" data-vote="ABSTER">ABSTER</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Start SCRIPT DO MODAL VOTAÇÃO EM BLOCO here -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function () {
            var socket = new WebSocket("ws://sgvp-backend-api.herokuapp.com/ws/votacao");

            socket.onopen = function () {
                console.log("Conectado ao WebSocket (Presidente)");
            };

            socket.onerror = function (event) {
                console.error("Erro no WebSocket (Presidente):", event);
            };

            $('#bulk-voting-button').on('click', function () {
                var message = JSON.stringify({
                    type: 'openModal'
                });
                socket.send(message);
            });
        });

    </script>

    <!-- ============================================================== -->
    <!-- Start MODAL DO ROTEIRO here -->
    <!-- ============================================================== -->
    @include('presidente.includes.modal.roteiro')
    <!-- ============================================================== -->
    <!-- Start MODAL DO DOCUMENTO here -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start SCRIPT HIBILITAR BOTÃO DE VOTAÇÃO here -->
    <!-- ============================================================== -->
    <script>
        var documentos = @json($documentos);

    </script>
    <script src="{{ url('assets/js/presidentehome/botao_votacao.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Start SCRIPT MODAL DO DOCUMENTO here -->
    <!-- ============================================================== -->
    <script src="{{ url('assets/js/presidentehome/documento.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Start OUTROS SCRIPTS here -->
    <!-- ============================================================== -->
    <script src="{{ url('assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ url('assets/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ url('assets/plugins/sweetalerts/custom-sweetalert.js') }}"></script>
    {{-- <script>
        $('.warning.finalizarSessao').on('click', function() {
            var nrSequence = $(this).data('nr-sequence');

            swal({
                title: 'Deseja finalizar a sessão?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'CANCELAR',
                confirmButtonText: 'SIM',
                padding: '2em',
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/encerrar-sessao',
                        data: {
                            nrSequence: nrSequence,
                            _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    alert('Sessão encerrada com sucesso!');
    },
    error: function() {
    alert('Erro ao encerrar a sessão.');
    }
    });

    }
    });
    });
    </script> --}}

    <script>
        $('.warning.finalizarSessao').on('click', function () {
            swal({
                title: 'Deseja finalizar a sessão?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'CANCELAR',
                confirmButtonText: 'SIM',
                padding: '2em',
                allowOutsideClick: false
            }).then(function (result) {
                if (result.value) {
                    window.location.href = '/';
                }
            });
        });

    </script>

@endcomponent
