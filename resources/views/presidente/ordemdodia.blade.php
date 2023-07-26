@component('presidente.components.layouts.app')
    <meta name="nr-sequence" content="{{ session('nrSequence') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ url('assets/css/home.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/clock.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/table/datatable/dt-global_style.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        .embed-pdf {
            width: 100%;
            height: calc(100vh - 200px);
            /* Substitua '200px' pela altura do cabeçalho e rodapé do modal */
        }

        .loading {
            background-color: #4CAF50;
            /* Cor de fundo do botão */
            border: none;
            color: white;
            /* Cor do texto do botão */
            padding: 12px 24px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            /* Duração da transição */
            cursor: pointer;
            position: relative;
        }

        .loading:after {
            content: '...';
            position: absolute;
            white-space: pre;
            animation: dots 1s steps(3, end) infinite;
        }

        @keyframes dots {

            from,
            20% {
                text-indent: 0;
            }

            40% {
                text-indent: -0.5em;
            }

            60% {
                text-indent: -1em;
            }
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
                <img alt="avatar" src="{{ asset('uploads/' . $fotoPerfil) }}" class="rounded-circle" width="90"
                    height="90" />
                <p class="text-white"></p>
                <div class="btn-group mb-4 mr-2" role="group">
                    <button id="btnOutline" type="button" class="btn btn-outline-white dropdown-toggle text-center"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $nome }}
                        - ({{ $partido }}) <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-down">
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

                {{-- <button type="button" class="btn btn-warning btn-block warning finalizarSessao mb-4 mr-2"
                    data-nr-sequence="{{ $nrSequence }}">
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
                    @if (empty($sessoes))
                        <div class="font-family-text">
                            <h3>Nenhuma sessão encontrada.</h3>
                        </div>
                    @else
                        @foreach ($sessoes as $sessao)
                            <div class="font-family-text">
                                <u>
                                    <h3 class="text-uppercase mt-3">{{ $sessao['nomeSessao'] }}</h3>
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
                {{-- <div class="col-md-3">
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
                </div> --}}
            </div>
        </div>
        <hr>
        <div class="widget-content widget-content-area">
            <!-- ============================================================== -->
            <!-- Start ALERTA PREPARAR VOTAÇÃO here -->
            <!-- ============================================================== -->
            {{-- @include('presidente.includes.alertas.preparar_votacao') --}}
            <!-- ============================================================== -->
            <!-- Start BOTÃO VOTAÇÃO E VOTAÇÃO EM BLOCO here -->
            <!-- ============================================================== -->
            <div class="text-right mt-3 mr-3">
                <a href="#" class="btn btn-outline-primary ml-2" id="prepare-voting-button"
                    style="display: none;">Prepara Votação</a>
                <a href="#" class="btn btn-outline-success ml-2" id="voting-button" style="display: none;"
                    data-toggle="modal" data-target=".bd-example-modal-lg">VOTAÇÃO</a>
                {{-- <a href="#" class="btn btn-outline-success ml-2" id="bulk-voting-button" style="display: none;"
                    data-toggle="modal" data-target="#modal-votacao-em-bloco">VOTAÇÃO EM BLOCO</a>


                <a href="#" class="btn btn-outline-primary ml-2" id="prepare-bulk-voting-button"
                    style="display: none;">Prepara Votação em Bloco</a> --}}
            </div>
            <hr>
            <!-- ============================================================== -->
            <!-- Start TABELA DOS DOCUMENTOS DA SESSÃO here -->
            <!-- ============================================================== -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="checkbox-column"></th>
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
            {{-- <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tableBody = document.getElementById('tableBody');
                    const todoAllCheckbox = document.getElementById('todoAll');

                    const checkboxes = tableBody.querySelectorAll('.new-control-input');

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('click', function() {
                            checkboxes.forEach(cb => {
                                cb.checked = cb === checkbox;
                            });
                            updateButtons();
                        });
                    });

                    const documentos = @json($documentos);

                    let html = '';

                    documentos.forEach(documento => {
                        const pdfPath = '{{ asset('uploads/') }}' + '/' + documento.pdf;

                        html += '<tr>';

                        // Verifica se o status do documento é diferente de ENCERRADO e docLeitura é diferente de true
                        if (documento.status !== 'ENCERRADO' && documento.docLeitura !== true) {
                            html += `
                                        <td class="checkbox-column">
                                            <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                                                <input type="checkbox" class="new-control-input todochkbox" data-status="${documento.status}" data-nrsequence="${documento.nrSequence}">
                                                <span class="new-control-indicator"></span>
                                            </label>
                                        </td>
                                    `;
                        } else {
                            html +=
                                '<td></td>'; // Coluna vazia para documentos com status ENCERRADO ou docLeitura igual a true
                        }

                        html += `
                                    <td class="text-uppercase documento-titulo" data-pdf-path="${pdfPath}" style="cursor: pointer;">${documento.titulo}</td>
                                    <td class="text-uppercase">${documento.autor}</td>
                                </tr>
                                `;
                    });

                    tableBody.innerHTML = html;

                    const todoAllCheckboxListener = function() {
                        setTimeout(() => {
                            const checkboxes = tableBody.querySelectorAll('.new-control-input');
                            checkboxes.forEach(checkbox => {
                                if (checkbox.getAttribute('data-status') === 'CADASTRADO') {
                                    checkbox.checked = true;
                                }
                            });
                            todoAllCheckbox.checked = false; // desmarca o checkbox todoAll após a seleção
                            updateButtons(); // Atualiza os botões de acordo com a seleção
                        }, 0);
                    };

                    todoAllCheckbox.addEventListener('click', todoAllCheckboxListener);

                    tableBody.addEventListener('click', function(event) {
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
            </script> --}}

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tableBody = document.getElementById('tableBody');

                    const documentos = @json($documentos);

                    let html = '';

                    documentos.forEach(documento => {
                        const pdfPath = '{{ asset('uploads/') }}' + '/' + documento.pdf;

                        html += '<tr>';

                        if (documento.status !== 'ENCERRADO' && documento.docLeitura !== true) {
                            html += `
                <td class="checkbox-column">
                    <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                        <input type="checkbox" class="new-control-input todochkbox" data-status="${documento.status}" data-nrsequence="${documento.nrSequence}">
                        <span class="new-control-indicator"></span>
                    </label>
                </td>
            `;
                        } else {
                            html += '<td></td>';
                        }

                        html += `
            <td class="text-uppercase documento-titulo" data-pdf-path="${pdfPath}" style="cursor: pointer;">${documento.titulo}</td>
            <td class="text-uppercase">${documento.autor}</td>
        </tr>
        `;
                    });

                    tableBody.innerHTML = html;

                    const checkboxes = tableBody.querySelectorAll('.new-control-input');

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            if (this.checked) {
                                checkboxes.forEach(cb => {
                                    if (cb !== this) {
                                        cb.checked = false;
                                    }
                                });
                                updateButtons();
                            }
                        });
                    });

                    tableBody.addEventListener('click', function(event) {
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

                    function updateButtons() {
                        // Adicione o código para atualizar os botões aqui
                    }

                });
            </script>

            <!-- ============================================================== -->
            <!-- Start JS DOS BOTÕES -->
            <!-- ============================================================== -->
            {{-- <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tableBody = document.getElementById('tableBody');
                    const todoAllCheckbox = document.getElementById('todoAll');

                    const checkboxes = tableBody.querySelectorAll('.new-control-input');

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            updateButtons();
                        });
                    });

                    const updateButtons = () => {
                        const checkedCheckboxes = tableBody.querySelectorAll('.new-control-input:checked');
                        const prepareVotingButton = document.getElementById('prepare-voting-button');
                        const votingButton = document.getElementById('voting-button');
                        const bulkVotingButton = document.getElementById('bulk-voting-button');
                        const prepareBulkVotingButton = document.getElementById('prepare-bulk-voting-button');

                        // Oculta todos os botões por padrão
                        prepareVotingButton.style.display = 'none';
                        votingButton.style.display = 'none';
                        bulkVotingButton.style.display = 'none';
                        prepareBulkVotingButton.style.display = 'none';

                        const selectedStatuses = Array.from(checkedCheckboxes).map(checkbox => checkbox.getAttribute(
                            'data-status'));
                        const uniqueStatuses = [...new Set(selectedStatuses)];

                        if (checkedCheckboxes.length > 0) {
                            if (uniqueStatuses.length === 1) {
                                const status = uniqueStatuses[0];
                                if (status === 'CADASTRADO') {
                                    if (checkedCheckboxes.length === 1) {
                                        prepareVotingButton.style.display = 'inline-block';
                                    } else {
                                        prepareBulkVotingButton.style.display = 'inline-block';
                                    }
                                } else if (status === 'VOTACAO') {
                                    if (checkedCheckboxes.length === 1) {
                                        votingButton.style.display = 'inline-block';
                                    } else {
                                        bulkVotingButton.style.display = 'inline-block';
                                    }
                                }
                            }
                        }
                    };

                    const todoAllCheckboxListener = function() {
                        setTimeout(() => {
                            const checkboxes = tableBody.querySelectorAll('.new-control-input');
                            checkboxes.forEach(checkbox => {
                                if (checkbox.getAttribute('data-status') === 'CADASTRADO') {
                                    checkbox.checked = true;
                                }
                            });
                            todoAllCheckbox.checked = false; // desmarca o checkbox todoAll após a seleção
                            updateButtons(); // Atualiza os botões de acordo com a seleção
                        }, 0);
                    };

                    todoAllCheckbox.addEventListener('click', todoAllCheckboxListener);

                    updateButtons();
                });

                $(document).ready(function() {
                    // Esconde os botões de votação e preparar votação quando a página é carregada
                    $('#voting-button').hide();
                    $('#prepare-voting-button').hide();
                    $('#bulk-voting-button').hide();
                    $('#prepare-bulk-voting-button').hide();

                    // Variável para armazenar o nrSequenceDocumento
                    var nrSequenceDocumento;

                    // Quando um checkbox é clicado
                    $(".new-control-input").change(function() {
                        // Verifica se algum checkbox está selecionado
                        var checkboxSelected = $(".new-control-input:checked").length > 0;

                        if (checkboxSelected) {
                            // Verifica o status do documento
                            var selectedCheckboxes = $(".new-control-input:checked");
                            var allStatuses = Array.from(selectedCheckboxes).map(checkbox => checkbox.getAttribute(
                                'data-status'));
                            var uniqueStatuses = [...new Set(allStatuses)];

                            if (uniqueStatuses.length === 1) {
                                var statusDocumento = uniqueStatuses[0];

                                if (statusDocumento === 'CADASTRADO') {
                                    var prepareVotingButton = $('#prepare-voting-button');
                                    var prepareBulkVotingButton = $('#prepare-bulk-voting-button');

                                    // Verifica se apenas um documento está selecionado
                                    if (selectedCheckboxes.length === 1) {
                                        // Mostra o botão de preparar votação
                                        prepareVotingButton.show();
                                        prepareBulkVotingButton.hide();
                                    } else {
                                        // Mostra o botão de preparar votação em bloco
                                        prepareVotingButton.hide();
                                        prepareBulkVotingButton.show();
                                    }
                                } else if (statusDocumento === 'VOTACAO') {
                                    var votingButton = $('#voting-button');
                                    var bulkVotingButton = $('#bulk-voting-button');

                                    // Verifica se apenas um documento está selecionado
                                    if (selectedCheckboxes.length === 1) {
                                        // Mostra o botão de votação
                                        votingButton.show();
                                        bulkVotingButton.hide();
                                    } else {
                                        // Mostra o botão de votação em bloco
                                        votingButton.hide();
                                        bulkVotingButton.show();
                                    }
                                }
                            }

                            // Destaca as linhas dos documentos selecionados
                            selectedCheckboxes.each(function() {
                                var nrSequenceDocumento = $(this).data('nrsequence');
                                $('.document-row-' + nrSequenceDocumento).addClass('highlight-row');
                            });
                        } else {
                            // Nenhum checkbox está selecionado, esconde os botões de votação e preparar votação
                            $('#voting-button').hide();
                            $('#prepare-voting-button').hide();
                            $('#bulk-voting-button').hide();
                            $('#prepare-bulk-voting-button').hide();

                            // Remove o destaque de todas as linhas de documentos
                            $('.highlight-row').removeClass('highlight-row');
                        }
                    });
                });

                // Evento de clique no botão "Prepara Votação"
                $(document).ready(function() {

                    // Verifica se há uma seleção armazenada no localStorage
                    const storedSelection = localStorage.getItem('selectedNrSequence');

                    if (storedSelection) {
                        // Aplica a seleção ao documento correspondente
                        $(`.new-control-input[data-nrsequence="${storedSelection}"]`).prop('checked', true);

                        // Limpa a seleção do localStorage para evitar seleções indesejadas em recarregamentos futuros
                        localStorage.removeItem('selectedNrSequence');

                        // Chama updateButtons para mostrar botões apropriados baseado no status
                        updateButtons();
                    }

                    $('#prepare-voting-button').click(function(event) {
                        event.preventDefault();

                        // Altera o texto do botão para "Preparando" e adiciona a classe "loading"
                        $(this).text('Preparando').addClass('loading');

                        // Obtém o nrSequence do documento selecionado
                        const selectedCheckbox = $('.new-control-input:checked');
                        const nrSequenceDocumento = selectedCheckbox.data('nrsequence');

                        // Define os dados para a requisição
                        const requestData = {
                            statusDocumento: 'VOTACAO'
                        };

                        // Obtém o token Bearer do Laravel
                        const bearerToken = '{{ $token }}';

                        // Exibe o token no console do navegador
                        console.log('Bearer Token:', bearerToken);

                        // Faz a requisição AJAX para atualizar o status do documento
                        $.ajax({
                            url: 'https://sgvp-backend-api.herokuapp.com/api/documento/' +
                                nrSequenceDocumento + '/atualiza-status',
                            type: 'PUT',
                            headers: {
                                'Authorization': 'Bearer ' + bearerToken,
                                'Content-Type': 'application/json'
                            },
                            data: JSON.stringify(requestData),
                            success: function(response) {
                                // Log de sucesso
                                console.log('Requisição concluída com sucesso.', response);

                                // Atualiza o status do documento na tabela
                                selectedCheckbox.attr('data-status', 'VOTACAO');
                                console.log('Status do documento atualizado.'); // Log adicional

                                try {
                                    // Tenta atualizar os botões
                                    updateButtons();
                                    console.log('Botões atualizados.'); // Log adicional
                                } catch (error) {
                                    console.error('Erro ao atualizar os botões:', error);
                                }

                                // Tentativa de recarregar a página
                                console.log(
                                    'Tentando recarregar a página.'); // Log antes de tentar recarregar
                                window.location.href = window.location.href;
                            },
                            error: function(xhr, status, error) {
                                // Log de erro
                                console.log('Erro na requisição.', xhr, status, error);

                                // Exibe a mensagem de erro
                                $('#error-message').text(
                                    'Erro ao preparar a votação. Por favor, tente novamente.');
                                $('#vote-message').show();
                            }
                        });
                    });




                });


                //Evento de clique no botão "Prepara Votação em Bloco"
                // $(document).ready(function() {
                //     // Click event for the "Prepare Bulk Voting" button
                //     $('#prepare-bulk-voting-button').click(function(event) {
                //         event.preventDefault();

                //         // Change the button text to "Preparing" and add the "loading" class
                //         $(this).text('Preparing').addClass('loading');

                //         // Get the nrSequence of the selected documents
                //         const selectedCheckboxes = $('.new-control-input:checked');
                //         const nrSequenceDocumentos = Array.from(selectedCheckboxes).map(checkbox => $(checkbox)
                //             .data('nrsequence'));

                //         // Define the data for the request
                //         const requestData = {
                //             statusDocumento: 'VOTACAO',
                //             documentos: nrSequenceDocumentos
                //         };

                //         // Get the Bearer token from Laravel
                //         const bearerToken = '{{ $token }}';

                //         // Make the AJAX request to update the status of the documents
                //         $.ajax({
                //             url: 'https://sgvp-backend-api.herokuapp.com/api/documento/atualiza-status-documentos',
                //             type: 'PUT',
                //             headers: {
                //                 'Authorization': 'Bearer ' + bearerToken,
                //                 'Content-Type': 'application/json'
                //             },
                //             data: JSON.stringify(requestData),
                //             success: function(response) {
                //                 // Log success
                //                 console.log('Bulk update request completed successfully.', response);

                //                 // Update the status of the documents in the table
                //                 selectedCheckboxes.attr('data-status', 'VOTACAO');

                //                 // Attempt to reload the page
                //                 window.location.href = window.location.href;
                //             },
                //             error: function(xhr, status, error) {
                //                 // Log error
                //                 console.log('Error in the bulk update request.', xhr, status, error);

                //                 // Display error message
                //                 $('#error-message').text(
                //                     'Error while preparing bulk voting. Please try again.');
                //                 $('#vote-message').show();
                //             }
                //         });
                //     });
                // });
                $(document).ready(function() {
                    // Click event for the "Prepare Bulk Voting" button
                    $('#prepare-bulk-voting-button').click(function(event) {
                        event.preventDefault();

                        // Change the button text to "Preparing" and add the "loading" class
                        $(this).text('Preparing').addClass('loading');

                        // Get the nrSequence of the selected documents
                        const selectedCheckboxes = $('.new-control-input:checked');
                        const nrSequenceDocumentos = Array.from(selectedCheckboxes).map(checkbox => $(checkbox)
                            .data('nrsequence'));

                        // Define the data for the request
                        const requestData = {
                            statusDocumento: 'VOTACAO',
                            documentos: nrSequenceDocumentos
                        };

                        // Get the Bearer token from Laravel
                        const bearerToken = '{{ $token }}';

                        // Make the AJAX request to update the status of the documents
                        $.ajax({
                            url: 'https://sgvp-backend-api.herokuapp.com/api/documento/atualiza-status-documentos',
                            type: 'PUT',
                            headers: {
                                'Authorization': 'Bearer ' + bearerToken,
                                'Content-Type': 'application/json'
                            },
                            data: JSON.stringify(requestData),
                            success: function(response) {
                                // Log success
                                console.log('Bulk update request completed successfully.', response);

                                // Update the status of the documents in the table
                                selectedCheckboxes.attr('data-status', 'VOTACAO');

                                // Attempt to reload the page
                                window.location.href = window.location.href;
                            },
                            error: function(xhr, status, error) {
                                // Log error
                                console.log('Error in the bulk update request.', xhr, status, error);

                                // Display error message
                                $('#error-message').text(
                                    'Error while preparing bulk voting. Please try again.');
                                $('#vote-message').show();
                            }
                        });
                    });
                });
            </script> --}}

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tableBody = document.getElementById('tableBody');
                    const todoAllCheckbox = document.getElementById('todoAll');

                    const checkboxes = tableBody.querySelectorAll('.new-control-input');

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            updateButtons();
                        });
                    });

                    const updateButtons = () => {
                        const checkedCheckboxes = tableBody.querySelectorAll('.new-control-input:checked');
                        const prepareVotingButton = document.getElementById('prepare-voting-button');
                        const votingButton = document.getElementById('voting-button');

                        // Oculta todos os botões por padrão
                        prepareVotingButton.style.display = 'none';
                        votingButton.style.display = 'none';

                        const selectedStatuses = Array.from(checkedCheckboxes).map(checkbox => checkbox.getAttribute(
                            'data-status'));
                        const uniqueStatuses = [...new Set(selectedStatuses)];

                        if (checkedCheckboxes.length > 0) {
                            if (uniqueStatuses.length === 1) {
                                const status = uniqueStatuses[0];
                                if (status === 'CADASTRADO') {
                                    if (checkedCheckboxes.length === 1) {
                                        prepareVotingButton.style.display = 'inline-block';
                                    } else {
                                        prepareBulkVotingButton.style.display = 'inline-block';
                                    }
                                } else if (status === 'VOTACAO') {
                                    if (checkedCheckboxes.length === 1) {
                                        votingButton.style.display = 'inline-block';
                                    } else {
                                        bulkVotingButton.style.display = 'inline-block';
                                    }
                                }
                            }
                        }
                    };

                    const todoAllCheckboxListener = function() {
                        setTimeout(() => {
                            const checkboxes = tableBody.querySelectorAll('.new-control-input');
                            checkboxes.forEach(checkbox => {
                                if (checkbox.getAttribute('data-status') === 'CADASTRADO') {
                                    checkbox.checked = true;
                                }
                            });
                            todoAllCheckbox.checked = false; // desmarca o checkbox todoAll após a seleção
                            updateButtons(); // Atualiza os botões de acordo com a seleção
                        }, 0);
                    };

                    todoAllCheckbox.addEventListener('click', todoAllCheckboxListener);

                    updateButtons();
                });

                $(document).ready(function() {
                    // Esconde os botões de votação e preparar votação quando a página é carregada
                    $('#voting-button').hide();
                    $('#prepare-voting-button').hide();

                    // Variável para armazenar o nrSequenceDocumento
                    var nrSequenceDocumento;

                    // Quando um checkbox é clicado
                    $(".new-control-input").change(function() {
                        // Verifica se algum checkbox está selecionado
                        var checkboxSelected = $(".new-control-input:checked").length > 0;

                        if (checkboxSelected) {
                            // Verifica o status do documento
                            var selectedCheckboxes = $(".new-control-input:checked");
                            var allStatuses = Array.from(selectedCheckboxes).map(checkbox => checkbox.getAttribute(
                                'data-status'));
                            var uniqueStatuses = [...new Set(allStatuses)];

                            if (uniqueStatuses.length === 1) {
                                var statusDocumento = uniqueStatuses[0];

                                if (statusDocumento === 'CADASTRADO') {
                                    var prepareVotingButton = $('#prepare-voting-button');

                                    // Verifica se apenas um documento está selecionado
                                    if (selectedCheckboxes.length === 1) {
                                        // Mostra o botão de preparar votação
                                        prepareVotingButton.show();
                                    } else {
                                        // Mostra o botão de preparar votação em bloco
                                        prepareVotingButton.hide();
                                    }
                                } else if (statusDocumento === 'VOTACAO') {
                                    var votingButton = $('#voting-button');

                                    // Verifica se apenas um documento está selecionado
                                    if (selectedCheckboxes.length === 1) {
                                        // Mostra o botão de votação
                                        votingButton.show();
                                    } else {
                                        // Mostra o botão de votação em bloco
                                        votingButton.hide();
                                    }
                                }
                            }

                            // Destaca as linhas dos documentos selecionados
                            selectedCheckboxes.each(function() {
                                var nrSequenceDocumento = $(this).data('nrsequence');
                                $('.document-row-' + nrSequenceDocumento).addClass('highlight-row');
                            });
                        } else {
                            // Nenhum checkbox está selecionado, esconde os botões de votação e preparar votação
                            $('#voting-button').hide();
                            $('#prepare-voting-button').hide();

                            // Remove o destaque de todas as linhas de documentos
                            $('.highlight-row').removeClass('highlight-row');
                        }
                    });
                });

                // Evento de clique no botão "Prepara Votação"
                $(document).ready(function() {

                    // Verifica se há uma seleção armazenada no localStorage
                    const storedSelection = localStorage.getItem('selectedNrSequence');

                    if (storedSelection) {
                        // Aplica a seleção ao documento correspondente
                        $(`.new-control-input[data-nrsequence="${storedSelection}"]`).prop('checked', true);

                        // Limpa a seleção do localStorage para evitar seleções indesejadas em recarregamentos futuros
                        localStorage.removeItem('selectedNrSequence');

                        // Chama updateButtons para mostrar botões apropriados baseado no status
                        updateButtons();
                    }

                    $('#prepare-voting-button').click(function(event) {
                        event.preventDefault();

                        // Altera o texto do botão para "Preparando" e adiciona a classe "loading"
                        $(this).text('Preparando').addClass('loading');

                        // Obtém o nrSequence do documento selecionado
                        const selectedCheckbox = $('.new-control-input:checked');
                        const nrSequenceDocumento = selectedCheckbox.data('nrsequence');

                        // Define os dados para a requisição
                        const requestData = {
                            statusDocumento: 'VOTACAO'
                        };

                        // Obtém o token Bearer do Laravel
                        const bearerToken = '{{ $token }}';

                        // Exibe o token no console do navegador
                        console.log('Bearer Token:', bearerToken);

                        // Faz a requisição AJAX para atualizar o status do documento
                        $.ajax({
                            url: 'https://sgvp-backend-api.herokuapp.com/api/documento/' +
                                nrSequenceDocumento + '/atualiza-status',
                            type: 'PUT',
                            headers: {
                                'Authorization': 'Bearer ' + bearerToken,
                                'Content-Type': 'application/json'
                            },
                            data: JSON.stringify(requestData),
                            success: function(response) {
                                // Log de sucesso
                                console.log('Requisição concluída com sucesso.', response);

                                // Atualiza o status do documento na tabela
                                selectedCheckbox.attr('data-status', 'VOTACAO');
                                console.log('Status do documento atualizado.'); // Log adicional

                                try {
                                    // Tenta atualizar os botões
                                    updateButtons();
                                    console.log('Botões atualizados.'); // Log adicional
                                } catch (error) {
                                    console.error('Erro ao atualizar os botões:', error);
                                }

                                // Tentativa de recarregar a página
                                console.log(
                                    'Tentando recarregar a página.'); // Log antes de tentar recarregar
                                window.location.href = window.location.href;
                            },
                            error: function(xhr, status, error) {
                                // Log de erro
                                console.log('Erro na requisição.', xhr, status, error);

                                // Exibe a mensagem de erro
                                $('#error-message').text(
                                    'Erro ao preparar a votação. Por favor, tente novamente.');
                                $('#vote-message').show();
                            }
                        });
                    });




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
        aria-hidden="true" data-backdrop="static">
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
                        <button class="btn btn-dark mb-4 btn-lg vote-button" data-vote="ABSTER">ABSTER</button>
                    </p>
                    <div id="vote-message" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('presidente.votacao') }}">Acompanhar Votação</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPT MODAL VOTAÇÃO here -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function() {
            // Esconde o botão de votação quando a página é carregada
            $('#voting-button').hide();
            $('#vote-message').hide();

            // Variável para armazenar o nrSequenceDocumento
            var nrSequenceDocumento;

            // Quando um checkbox é clicado
            $(".new-control-input").click(function() {
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
            $(".bd-example-modal-lg").on("shown.bs.modal", function() {
                var titulo = $("#document-title")
                    .text(); // Obtém o título do documento do elemento de título
                $("#document-title-modal").text(
                    titulo); // Atualiza o título do modal com o título do documento

                // Emitir o evento do Pusher para o canal 'modal-channel'
                var pusher = new Pusher('875de7708', {
                    cluster: 'sa1',
                    encrypted: true
                });

                var channel = pusher.subscribe('modal-channel');
                channel.bind('server-modal-open', function(data) {
                    console.log(data.message);
                });

                // Enviar o título como parte do POST Ajax para o Laravel
                $.post("/modal-open", {
                    _token: "{{ csrf_token() }}",
                    titulo: titulo,
                    nrSequenceDocumento: nrSequenceDocumento
                });
            });

            // Quando o botão de votação é clicado
            $(".vote-button").click(function() {
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
                    success: function(response) {
                        // Mostra a mensagem de sucesso e esconde os botões
                        $('#vote-message').text(response.message).removeClass('text-danger')
                            .addClass('text-success').show();
                    },
                    error: function(error) {
                        // Mostra a mensagem de erro da API, se disponível
                        var errorMsg = error.responseJSON && error.responseJSON.message ?
                            error.responseJSON.message :
                            "Erro ao enviar a votação, por favor tente novamente.";
                        $('#vote-message').text(errorMsg).removeClass('text-success').addClass(
                            'text-danger').show();
                    }
                });
            });

            // Quando o botão "Acompanhar votação" é clicado
            $("#acompanhar-votacao").click(function() {
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
    <div class="modal fade" id="modal-votacao-em-bloco" tabindex="-1" role="dialog"
        aria-labelledby="modal-votacao-em-bloco-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-votacao-em-bloco-label">Votação em Bloco</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">
                        <strong>Documentos selecionados:</strong>
                    <ul id="document-list"></ul>
                    </p>
                    <p class="modal-text">
                        <button class="btn btn-primary mb-4 mr-3 btn-lg vote-bulk-button" data-vote="BLOCO">Votar em
                            Bloco</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPT DO MODAL VOTAÇÃO EM BLOCO here -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function() {
            // Cria uma lista vazia para armazenar os títulos dos documentos selecionados
            var documentosSelecionados = [];

            // Detecta quando um checkbox é alterado
            $(".todochkbox").change(function() {
                var documentoTitle = $(this).closest("tr").find("td:nth-child(2)").text();

                // Se o checkbox foi selecionado, adiciona o título do documento na lista, senão remove
                if ($(this).is(":checked")) {
                    documentosSelecionados.push(documentoTitle);
                } else {
                    var index = documentosSelecionados.indexOf(documentoTitle);
                    if (index > -1) {
                        documentosSelecionados.splice(index, 1);
                    }
                }
            });

            // Quando o modal estiver prestes a ser aberto
            $("#modal-votacao-em-bloco").on('show.bs.modal', function() {
                // Limpa a lista de documentos no modal
                $("#document-list").empty();

                // Adiciona cada documento selecionado na lista do modal
                documentosSelecionados.forEach(function(documento) {
                    $("#document-list").append('<li>' + documento + '</li>');
                });
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
    @include('presidente.includes.modal.documento')
    <!-- ============================================================== -->
    <!-- Start SCRIPT HIBILITAR BOTÃO DE VOTAÇÃO here -->
    <!-- ============================================================== -->
    <script>
        var documentos = @json($documentos);
    </script>
    {{-- <script src="{{ url('assets/js/presidentehome/botao_votacao.js') }}"></script> --}}
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
                    window.location.href = '/';
                }
            });
        });
    </script> --}}

    <script>
        $('.warning.finalizarSessao').on('click', function() {
            var nrSequence = $(this).data('nr-sequence');
            swal({
                title: 'ENCERRAR A SESSÃO?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'CANCELAR',
                confirmButtonText: 'SIM',
                padding: '2em',
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    finalizeSession(nrSequence);
                }
            });
        });

        function finalizeSession(nrSequence) {
            var url = "{{ route('sessao.updateStatus', 'PLACEHOLDER') }}".replace('PLACEHOLDER', nrSequence);
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    status: 'FINALIZADA',
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Ação para quando a requisição for bem sucedida
                    // Por exemplo, redirecionar para outra página
                    window.location.href = '/';
                },
                error: function(error) {
                    // Ação para quando ocorrer algum erro
                    alert("Ocorreu um erro ao finalizar a sessão.");
                }
            });
        }
    </script>

@endcomponent
