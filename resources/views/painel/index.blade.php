<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sistema - Painel</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/components/custom-counter.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/painel.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('assets/css/components/custom-counter.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('assets/css/clock.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/presidente.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>




</head>

<body style="background-color: #060818;">
    <!-- ============================================================== -->
    <!-- Start CONTENT here -->
    <!-- ============================================================== -->
    <div class="">
        <div class="row d-flex flex-column ">
            <div class="col-xl-12 col-lg-1 col-md-12 col-12 layout-spacing">
                <div class="col d-flex justify-content-between  mt-3">
                    @if (empty($sessoes))
                        <div class=" px-5">
                            <h1 class="text-uppercase" style="color: white;">Nenhuma Sessãos </h1>
                        </div>
                    @else
                        @foreach ($sessoes as $sessao)
                            <div class=" px-5">
                                <h1 class="text-uppercase" style="color: white;">{{ $sessao['nomeSessao'] }}</h1>
                            </div>
                        @endforeach
                    @endif

                    <div class="d-flex px-3">
                        <h1 id="dataAtual" style="color: white;"></h1>
                    </div>

                </div>

            </div>


        </div>

        <div class="row  px-1">
            <div class=" d-flex justify-content-between col-10 row layout-top-spacing ">
                @foreach ($vereadores as $vereador)
                    <div id="card_4" class="col-lg-4 layout-spacing px-3">
                        <div id="" class="px-5">
                            @if ($vereador['online'] == true)
                                <div id="card-vereadores">
                                    <div class="">
                                        <img alt="avatar" src="{{ asset('uploads/' . $vereador['fotoPerfil']) }}"
                                            id="vereador-online" width="130" height="130" />
                                    </div>
                                    <div class="px-3 mt-4">
                                        <h5 class="text-uppercase" style="color: white;">
                                            {{ $vereador['nomeCompleto'] }}</h5>
                                        <p class="text-uppercase" style="color: white;">{{ $vereador['partido'] }}</p>
                                    </div>
                                </div>
                            @else
                                <div id="card-vereadores-offline">
                                    <div class="">
                                        <img alt="avatar" src="{{ asset('uploads/' . $vereador['fotoPerfil']) }}"
                                            id="vereador-offline" width="130" height="130" />
                                    </div>
                                    <div class="px-3 mt-4">
                                        <h5 class="text-uppercase" style="color: white;">
                                            {{ $vereador['nomeCompleto'] }}</h5>
                                        <p class="text-uppercase" style="color: white;">{{ $vereador['partido'] }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-2 mt-4">
                <div class="clock-container-painel">
                    <h5 id="title">Relógio</h5>
                    <div id="clock"></div>
                    <h5 id="countdown-title">Sessão</h5>
                    <div id="countdown"></div>
                </div>
                <div class="row">
                    <div class=" col-10 ">
                    </div>
                    <div class=" col-lg-12 col-sm-12 mr-3 mt-5 ">

                        <div class="text-center">
                            <button class="btn btn-success btn-block mb-4 mr-2  d-flex justify-content-between"
                                style="text-align: center;">
                                <span>PRESENTES</span>
                                <span>{{ $total_vereadoresOnline }}</span></button>
                            <button type="button"
                                class="btn btn-danger btn-block mb-4 mr-2 d-flex justify-content-between"
                                data-toggle="modal" data-target="#fadeleftModalTribuna">
                                <span>AUSENTES</span>
                                {{ $total_vereadores - $total_vereadoresOnline }}
                            </button>
                            <button type="button"
                                class="btn btn-primary btn-block mb-4 mr-2 d-flex justify-content-between"
                                data-toggle="modal"
                                data-target="#fadeleftModal"><span>TOTAL</span><span>{{ $total_vereadores }} </span>
                            </button>
                        </div>


                    </div>
                </div>
            </div>

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
            if (event.data === "VOTACAO") {

                function getUrl() {
                    var url = 'https://sgvp.online/painel/votacao';
                    return url
                }

                const redirection = getUrl();

                window.location.href = redirection;

            }


            // Função para redirecionar após o uso do WS
            // function getUrl() {
            //     var url = 'url de exemplo;
            //     return url
            // }

            // const redirection = getUrl();

            // window.location.href = redirection;
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

        // Get the end time


        // Call updateCountdown() once at first to avoid delay
        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

    <script src="{{ url('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/js/relogio.js') }}"></script>
    <script src="{{ url('assets/js/calendario.js') }}"></script>


</body>

</html>
