@component('presidente.components.layouts.app')
    <meta name="nr-sequence" content="{{ session('nrSequence') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .sticky-footer {
            position: -webkit-sticky;
            position: sticky;
            bottom: 0;
            width: 100%;
            text-align: center;
            margin-top: 100%;
        }

        .modal-content {
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            text-align: center;
        }

        .modal-body {
            display: flex;
            justify-content: center;
        }

        #pdf-embed {
            width: 100%;
            height: 80vh;
            /* Ajuste este valor conforme necessário */
        }

        .presidente-nao-vota .vote-button {
            display: none;
        }

        /* Estilo para telas com largura máxima de 768px (como tablets em modo retrato) */
        @media (max-width: 768px) {
            .embed-pdf {
                width: 100%;
                height: 400px;
            }
        }

        /* Estilo para telas com largura máxima de 480px (como telefones celulares em modo retrato) */
        @media (max-width: 480px) {
            .embed-pdf {
                width: 100%;
                height: 300px;
            }
        }
    </style>
    <link href="{{ url('assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/clock.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                <div class="col-md-6 text-center">
                    <div>
                        <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                            data-target=".bd-example-modal-roteiro" data-title="roteiro">
                            ROTEIRO
                        </a>
                        {{-- <button type="button" class="btn btn-outline-success ml-5" id="reabrir-modal">VOTAÇÃO</button> --}}

                    </div>
                </div>

            </div>
        </div>
        <hr>
        <div class="widget-content widget-content-area">
            <!-- ============================================================== -->
            <!-- Start BOTÃO VOTAÇÃO E VOTAÇÃO EM BLOCO here -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- Start TABELA DOS DOCUMENTOS DA SESSÃO here -->
            <!-- ============================================================== -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="">Nome</th>
                            <th class="">Autor</th>
                            <th class="">Momento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentos as $documento)
                            <tr>

                                <td>
                                    <p class="mb-0">
                                        <a href="#" class="open-pdf text-uppercase" data-toggle="modal"
                                            data-target=".bd-example-modal-xl" data-title="{{ $documento['titulo'] }}"
                                            data-pdf="{{ asset('uploads/' . $documento['pdf']) }}">
                                            {{ $documento['titulo'] }}
                                        </a>
                                    </p>
                                </td>
                                <td class="text-uppercase">{{ $documento['autor'] }}</td>
                                <td class="text-uppercase">{{ $documento['momento'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPT RELÓGIO here -->
    <!-- ============================================================== -->
    <script>
        function updateTime() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            document.getElementById('clock').textContent =
                `${padNumber(hours)}:${padNumber(minutes)}:${padNumber(seconds)}`;
        }

        function padNumber(number) {
            return number.toString().padStart(2, '0');
        }

        setInterval(updateTime, 1000);
    </script>
    <!-- ============================================================== -->
    <!-- Start CRONÔMETRO here -->
    <!-- ============================================================== -->
    <script>
        // Get the end time
        const endTime = new Date();
        endTime.setHours(endTime.getHours() + 4);

        function updateCountdown() {
            const now = new Date();
            let diff = endTime - now;

            // Calculate hours, minutes, and seconds
            let hours = Math.floor(diff / 1000 / 60 / 60);
            diff -= hours * 1000 * 60 * 60;
            let minutes = Math.floor(diff / 1000 / 60);
            diff -= minutes * 1000 * 60;
            let seconds = Math.floor(diff / 1000);

            // Update the countdown
            document.getElementById('countdown').textContent =
                `${padNumber(hours)}:${padNumber(minutes)}:${padNumber(seconds)}`;
        }

        // Call updateCountdown() once at first to avoid delay
        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
    <!-- ============================================================== -->
    <!-- Start MODAL VOTAÇÃO here -->
    <!-- ============================================================== -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="myLargeModalLabel">Titulo</h5>
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

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPT MODAL VOTAÇÃO here -->
    <!-- ============================================================== -->
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('875de73cad282b0e7de3', {
            cluster: 'sa1'
        });

        var channel = pusher.subscribe('modal-channel');
        channel.bind('ModalVota', function(data) {
            // Preencha os dados no modal
            $('#myLargeModalLabel').text(data.data.titulo);
            $('.bd-example-modal-lg').attr('data-nrsequence', data.data.nrSequenceDocumento);
            $('#acompanhar-votacao').attr('data-nrsequence', data.data.nrSequenceDocumento);

            // Agora você pode mostrar o modal
            $('.bd-example-modal-lg').modal('show');
        });

        // Quando o botão de votação é clicado
        $(".vote-button").click(function() {
            var vote = $(this).data('vote');
            var nrSequenceUsuario = $('meta[name="nr-sequence"]').attr('content');
            var nrSequenceDocumento = $('.bd-example-modal-lg').attr('data-nrsequence');

            $(this).parent().hide();

            var dadosVoto = {
                usuarioVoto: {
                    nrSequence: nrSequenceUsuario
                },
                documento: {
                    nrSequence: nrSequenceDocumento
                },
                voto: vote
            };

            console.log("Dados sendo enviados para a API:", dadosVoto); // Log dos dados enviados

            $.ajax({
                url: "/vereador/votacao",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify(dadosVoto),
                success: function(response) {
                    console.log("Resposta recebida da API:", response); // Log da resposta recebida
                    $('#vote-message').text(response.message).show();
                },
                error: function(error) {
                    console.log("Erro recebido da API:", error); // Log do erro recebido
                    var errorMsg = error.responseJSON && error.responseJSON.message ?
                        error.responseJSON.message :
                        "Erro ao enviar a votação, por favor tente novamente.";
                    $('#vote-message').text(errorMsg).show();
                }
            });
        });

        // Quando o botão para reabrir o modal é clicado
        $("#reabrir-modal").click(function() {
            // Mostra o modal
            $('.bd-example-modal-lg').modal('show');
        });
    </script> --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('875de73cad282b0e7de3', {
            cluster: 'sa1'
        });

        var channel = pusher.subscribe('modal-channel');
        channel.bind('ModalVota', function(data) {
            // Preencha os dados no modal
            $('#myLargeModalLabel').text(data.data.titulo);
            $('#document-title').text(data.data.titulo);
            $('.bd-example-modal-lg').data('nrsequence', data.data.nrSequenceDocumento);
            $('#acompanhar-votacao').data('nrsequence', data.data.nrSequenceDocumento);

            // Agora você pode mostrar o modal
            $('.bd-example-modal-lg').modal('show');
        });

        // Quando o botão de votação é clicado
        $(document).on("click", ".vote-button", function() {
            var vote = $(this).data('vote');
            var nrSequenceUsuario = $('meta[name="nr-sequence"]').attr('content');
            var nrSequenceDocumento = $('.bd-example-modal-lg').data('nrsequence');

            $(this).parent().hide();

            var dadosVoto = {
                usuarioVoto: {
                    nrSequence: nrSequenceUsuario
                },
                documento: {
                    nrSequence: nrSequenceDocumento
                },
                voto: vote
            };

            console.log("Dados sendo enviados para a API:", dadosVoto); // Log dos dados enviados

            // $.ajax({
            //     url: "/vereador/votacao",
            //     type: "POST",
            //     headers: {
            //         "X-CSRF-TOKEN": "{{ csrf_token() }}"
            //     },
            //     contentType: "application/json",
            //     data: JSON.stringify(dadosVoto),
            //     success: function(response) {
            //         console.log("Resposta recebida da API:", response); // Log da resposta recebida
            //         $('#vote-message').text(response.message).show();
            //     },
            //     error: function(error) {
            //         console.log("Erro recebido da API:", error); // Log do erro recebido
            //         var errorMsg = error.responseJSON && error.responseJSON.message ?
            //             error.responseJSON.message :
            //             "Erro ao enviar a votação, por favor tente novamente.";
            //         $('#vote-message').text(errorMsg).show();
            //     }
            // });
            $.ajax({
                url: "/vereador/votacao",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify(dadosVoto),
                success: function(response) {
                    console.log("Resposta recebida da API:", response); // Log da resposta recebida
                    $('#vote-message').text(response.message).show();

                    // Recarregar a página após o envio do voto
                    location.reload();
                },
                error: function(error) {
                    console.log("Erro recebido da API:", error); // Log do erro recebido
                    var errorMsg = error.responseJSON && error.responseJSON.message ?
                        error.responseJSON.message :
                        "Erro ao enviar a votação, por favor tente novamente.";
                    $('#vote-message').text(errorMsg).show();
                }
            });

        });

        // Quando o botão para reabrir o modal é clicado
        $("#reabrir-modal").click(function() {
            // Mostra o modal
            $('.bd-example-modal-lg').modal('show');
        });

        // Ouvinte de eventos para quando o modal é fechado
        $('.bd-example-modal-lg').on('hidden.bs.modal', function() {
            location.reload();
        });
    </script>




    <!-- ============================================================== -->
    <!-- Start MODAL VOTAÇÃO EM BLOCO here -->
    <!-- ============================================================== -->
    <!-- Modal para o outro usuário -->
    {{-- <div class="modal fade bd-example-modal-lg" id="modal-votacao-unica-outro-usuario" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="myLargeModalLabel">Titulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">
                        <button class="btn btn-success mb-4 mr-3 btn-lg vote-button" data-vote="SIM">SIM</button>
                        <button class="btn btn-danger mb-4 mr-3 btn-lg vote-button" data-vote="NAO">NÃO</button>
                        <button class="btn btn-dark mb-4 btn-lg vote-button" data-vote="ABSTEVE">ABSTER</button>
                    </p>
                    <div id="vote-message" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div> --}}




    <!-- ============================================================== -->
    <!-- Start SCRIPT VOTAÇÃO EM BLOCO here -->
    <!-- ============================================================== -->
    {{-- <script>
        // Função para abrir o modal de votação única para o segundo usuário
        function openModalForOtherUser() {
            $("#modal-votacao-unica-outro-usuario").modal("show");
        }

        $(document).ready(function() {
            // Verifica se o usuário atual é o principal
            function isUserPrincipal() {
                // Implemente a lógica para determinar se o usuário atual é o principal
                // Retorne true se for o principal, false caso contrário
                return false; // Exemplo: sempre retorna false para fins de demonstração
            }

            // Função para atualizar os botões com base na seleção de documentos
            function updateButtons() {
                var checkedCheckboxes = $(".new-control-input:checked");
                var prepareVotingButton = $("#prepare-voting-button");
                var votingButton = $("#voting-button");
                var bulkVotingButton = $("#bulk-voting-button");
                var prepareBulkVotingButton = $("#prepare-bulk-voting-button");

                // Oculta todos os botões por padrão
                prepareVotingButton.hide();
                votingButton.hide();
                bulkVotingButton.hide();
                prepareBulkVotingButton.hide();

                var selectedStatuses = Array.from(checkedCheckboxes).map(checkbox => checkbox.getAttribute(
                    "data-status"));
                var uniqueStatuses = [...new Set(selectedStatuses)];

                if (checkedCheckboxes.length > 0) {
                    if (uniqueStatuses.length === 1) {
                        var status = uniqueStatuses[0];
                        if (status === "CADASTRADO") {
                            if (checkedCheckboxes.length === 1) {
                                prepareVotingButton.show();
                            } else {
                                prepareBulkVotingButton.show();
                            }
                        } else if (status === "VOTACAO") {
                            if (checkedCheckboxes.length === 1) {
                                votingButton.show();
                            } else {
                                bulkVotingButton.show();
                            }
                        }
                    }
                }
            }

            // Quando um checkbox é clicado
            $(".new-control-input").change(function() {
                updateButtons();
            });

            // Quando o botão de votação em bloco é clicado
            $("#bulk-voting-button").click(function() {
                // Verifica se o usuário atual é o principal
                if (!isUserPrincipal()) {
                    alert("Apenas o usuário principal pode iniciar uma votação em bloco.");
                    return;
                }

                // Pode pegar os elementos selecionados da forma que desejar
                var selectedDocuments = $(".new-control-input:checked");

                // Cria um array para armazenar os nrSequence dos documentos selecionados
                var nrSequences = [];
                selectedDocuments.each(function() {
                    var nrSequence = $(this).data("nrsequence");
                    nrSequences.push(nrSequence);
                });

                // Emitir o evento do Pusher para o canal 'bulk-modal-channel'
                var pusher = new Pusher("875de7708", {
                    cluster: "sa1",
                    encrypted: true
                });

                var channel = pusher.subscribe("bulk-modal-channel");
                channel.bind("server-bulk-modal-open", function(data) {
                    console.log(data.message);
                    console.log("Documentos selecionados:", data.documentos);

                    // Verifica se o usuário atual é o usuário principal
                    if (isUserPrincipal() && data.modalType === "votacao-em-bloco") {
                        // Abrir o modal de votação em bloco para o usuário principal
                        $("#modal-votacao-em-bloco").modal("show");
                    } else if (!isUserPrincipal() && data.modalType === "votacao-unica") {
                        // Abrir o modal de votação única para o segundo usuário
                        openModalForOtherUser();
                    }
                });

                // Enviar os documentos selecionados como parte do POST Ajax para o Laravel
                $.post("/bulk-modal-open", {
                    _token: "{{ csrf_token() }}",
                    documentos: nrSequences
                });
            });

            // Chamar a função updateButtons para mostrar os botões corretos com base na seleção inicial
            updateButtons();
        });
    </script> --}}
    <!-- ============================================================== -->
    <!-- Start MODAL DO ROTEIRO here -->
    <!-- ============================================================== -->
    <div class="modal fade bd-example-modal-roteiro" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">ROTEIRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    @if (!empty($roteiros[0]['docRoteiro']))
                        <embed id="pdf-embed" src="{{ asset('uploads/' . $roteiros[0]['docRoteiro']) }}"
                            type="application/pdf" style="width:100%; height:80vh;" />
                    @else
                        <p>Não existe um roteiro cadastrado.</p>
                    @endif
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start MODAL DO DOCUMENTO here -->
    <!-- ============================================================== -->
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="myExtraLargeModalLabel">DOCUMENTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    @if (!empty($documento['pdf']))
                        <embed id="pdf-embed" src="{{ asset('uploads/' . $documento['pdf']) }}" type="application/pdf"
                            style="width:100%; height:80vh;" />
                    @else
                        <p>Não existe um roteiro cadastrado.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>




    <script src="{{ url('assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ url('assets/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ url('assets/plugins/sweetalerts/custom-sweetalert.js') }}"></script>
@endcomponent
