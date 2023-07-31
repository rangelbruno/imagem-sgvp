<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ============================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/components/custom-counter.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/painel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/clock.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/presidente.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Sistem - Discussão</title>
</head>

<body style="background-color: #060818;">




    <div>
        <div class="row d-flex flex-column ">
            <div class="col-xl-12 col-lg-1 col-md-12 col-12 layout-spacing">

                <div class="col d-flex justify-content-between  mt-3">

                    @foreach ($sessaoAutorizada as $sessao)
                    <div class=" px-5">
                        <h1 class="text-uppercase" style="color: white;">{{ $sessao['nomeSessao'] }}</h1>
                    </div>
                    @endforeach


                    <div class="d-flex px-3">
                        <h1 id="dataAtual" style="color: white;"></h1>
                    </div>

                </div>

            </div>

        </div>

        <div class="row px-1">
            <div class="col">
                <div class="d-flex justify-content-center text-uppercase">
                    <div class="">
                        <h1 class="text-uppercase" style="color: white;">DISCUSSÃO NOME PROJETO </h1>
                    </div>

                </div>
                <div class="d-flex justify-content-center text-uppercase mt-3 mb-4">
                   

                    <div class="px-3">
                        <div id="timer" style="color:#28a745; font-size: 109px; ">
                        </div>
                        <h1 class="text-uppercase" style="color: white;" id="NameVereador"></h1>
                        <h1 class="text-uppercase" style="color: white;" id="partidoVereadorMomento"></h1>



                    </div>


                </div>

                <div class="d-flex justify-content-center text-uppercase mt-3 mb-4">

                    <div class="">
                    </div>
                    <div class="px-3">
                        <div id="timer" style="color:#28a745; font-size: 109px; ">
                        </div>
                        <h1 class="text-uppercase" style="color: white;" id="NomeVereadorAparte"></h1>
                        <h1 class="text-uppercase" style="color: white;" id="PartidoVereadorAparte"></h1>
                    </div>

                </div>
            </div>
            <div class=" col-lg-2 mt-5 mr-3">
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
                    </div>
                </div>
            </div>
        </div>


        <div class="row px-1">
            <div class="col px-3 mt-3 m-3">

            </div>

            <div class="col px-3 mt-3 m-3">

            </div>
        </div>


    </div>



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
    <!--WS-->
    <script>

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
    <script>

    </script>
    <script src=" {{ url('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/js/relogio.js') }}"></script>
    <script src="{{ url('assets/js/dateFormates.js') }}"></script>
    <script src="{{ url('assets/js/calendario.js') }}"></script>
    <script src="{{ url('assets/js/tribuna.js') }}"></script>
    <script src="{{ url('assets/js/webSocket.js') }}"></script>
    <script src="{{ url('assets/js/wsTempoTribuna.js') }}"></script>


</body>


</html>