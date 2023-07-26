<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sistema - PRESIDENTE</title>
    <link rel="icon" type="image/x-icon" href="{{ url('assets/img/favicon.ico') }}" />
    <!-- GOOGLE FONTES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/pages/coming-soon/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/forms/switches.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="coming-soon">

    <div class="coming-soon-container">
        <div class="coming-soon-cont">
            <div class="coming-soon-wrap">
                <div class="coming-soon-container">
                    <div class="coming-soon-content">
                        <!-- ============================================================== -->
                        <!-- Start Page QUÓRUM here -->
                        <!-- ============================================================== -->
                        <div class="card component-card_8">
                            <div class="card-body">
                                <div class="progress-order">
                                    <div class="progress-order-header">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-12">
                                                @if ($total_usuarios > 9 / 2)
                                                    <h6 class="text-success">Há Quórum</h6>
                                                @else
                                                    <h6 class="text-danger">Não há Quórum</h6>
                                                @endif
                                            </div>

                                            <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                                <span class="badge badge-info">Não há sessão aberta!</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-order-body">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <ul class="list-inline badge-collapsed-img mb-0 mb-3">
                                                    <li class="list-inline-item chat-online-usr ml-3">
                                                        {{-- <img alt="avatar" src="" class="ml-0"> --}}
                                                    </li>
                                                    @foreach ($usuarios as $usuario)
                                                        <li class="list-inline-item chat-online-usr">
                                                            <img alt="avatar"
                                                                src="{{ asset('uploads/' . $usuario['fotoPerfil']) }}"
                                                                title="{{ $usuario['nomeCompleto'] }}">
                                                        </li>
                                                    @endforeach
                                                    @if ($total_usuarios > 4)
                                                        <li class="list-inline-item badge-notify mr-0">
                                                            <div class="notification">
                                                                <span
                                                                    class="badge badge-info badge-pill">+{{ $total_usuarios - 4 }}
                                                                    mais</span>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <span
                                                    class="p-o-percentage mr-4">{{ number_format($percentual_usuarios_logados, 0) }}%</span>
                                                <div class="progress p-o-progress mt-2">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                        style="width: {{ $percentual_usuarios_logados }}%"
                                                        aria-valuenow="{{ $percentual_usuarios_logados }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (empty($sessoes))
                            <h3>Nenhuma sessão encontrada.</h3>
                        @else
                            @foreach ($sessoes as $sessao)
                                @if (is_array($sessao) && isset($sessao['nomeSessao']))
                                    <h3 class="text-uppercase"><u>{{ $sessao['nomeSessao'] }}</u></h3>
                                @endif
                            @endforeach
                        @endif



                        <div class="text-left">
                            <div class="coming-soon">

                                {{-- <div class="text-center">
                                    @if ($total_usuarios > 15 / 2 && !empty($sessoes))
                                        <a href="{{ route('presidente.home') }}"
                                            class="btn btn-outline-primary mb-4 mr-2 btn-lg">INICIAR</a>
                                    @endif
                                </div> --}}

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                {{-- <div class="text-center">
                                    @if ($total_usuarios > 9 / 2 && !empty($sessoes))
                                        <form method="POST" action="{{ route('presidente.iniciar') }}">
                                            @csrf
                                            <input type="hidden" name="nrSequence"
                                                value="{{ $sessoes[0]['nrSequence'] }}">
                                            <input type="hidden" name="nrSeqUsuarioList"
                                                value="{{ json_encode(array_column($usuarios, 'nrSequence')) }}">
                                            <input type="submit" class="btn btn-outline-primary mb-4 mr-2 btn-lg"
                                                value="INICIAR">

                                        </form>
                                    @endif
                                </div> --}}
                                <div class="text-center">
                                    @if ($total_usuarios > 9 / 2 && !empty($sessoes))
                                        <a href="{{ route('presidente.home') }}"
                                            class="btn btn-outline-primary mb-4 mr-2 btn-lg">INICIAR</a>
                                    @endif
                                </div>


                            </div>
                        </div>



                        <p class="terms-conditions">Copyright © {{ date('Y') }} Todos os direitos reservados.
                        </p>


                    </div>
                </div>
            </div>
        </div>
        <div class="coming-soon-image">
            <div class="l-image">
                <div class="img-content">
                    <img src="{{ asset('assets/img/mongagua.png') }}" alt="coming_soon">
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Start SCRIPTS here -->
    <!-- ============================================================== -->
    <script>
        // Cria uma nova instância de WebSocket
        const socket = new WebSocket('ws://sgvp-backend-api.herokuapp.com/ws/usuarioLogou');

        // Manipulador de evento para quando a conexão é estabelecida
        socket.onopen = function() {
            console.log('Conexão estabelecida com sucesso!');
        };

        // Manipulador de evento para receber mensagens do servidor
        socket.onmessage = function(event) {
            console.log('Mensagem recebida:', event.data);

            // Atualizar a página aqui após o usuário logar
            localStorage.clear();
            location.reload();
        };

        // Manipulador de evento para lidar com erros
        socket.onerror = function(error) {
            console.error('Erro WebSocket:', error);
        };

        // Manipulador de evento para lidar com o fechamento da conexão
        socket.onclose = function() {
            console.log('Conexão fechada.');
            localStorage.clear();

        };
    </script>
    <script src="{{ url('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/pages/coming-soon/coming-soon.js') }}"></script> --}}

</body>

</html>
