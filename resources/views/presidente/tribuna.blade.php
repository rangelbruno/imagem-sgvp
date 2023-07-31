<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta name="csrf-token" content="{{ $token }}">

    <title>Sistema - PRESIDENTE</title>
    <link rel="icon" type="image/x-icon" href="{{ url('assets/img/favicon.ico') }}" />
    <!-- GOOGLE FONTES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ url('assets/css/presidente.css') }}" rel="stylesheet" type="text/css">
    <!-- ============================================================== -->
    <!-- Start OTHER STYLES here -->
    <!-- ============================================================== -->
    <link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/users/user-profile.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/tables/table-basic.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/plugins/drag-and-drop/dragula/dragula.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/plugins/drag-and-drop/dragula/example.css') }}" rel="stylesheet" type="text/css">

    <style>
    .iniciado {
        background-color: rgba(0, 128, 0, 0.1);
    }

    .aparte {
        background-color: rgba(255, 255, 0, 0.1);
    }

    .cronometro-label {
        color: #4a4a4a;
        font-weight: bold;
    }

    .cronometro-tempo {
        color: #2c3e50;
        font-weight: bold;
    }
    </style>

</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
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

                <div class="text-center avatar avatar-xl">
                    <img alt="avatar" src="{{ asset('assets/img/profile-7.jpg') }}" class="rounded-circle" />
                    <p class="text-white"></p>
                    <div class="btn-group mb-4 mr-2" role="group">
                        <button id="btnOutline" type="button" class="btn btn-outline-white dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $nome }} <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg></button>
                        <div class="dropdown-menu" aria-labelledby="btnOutline">
                            <a href="{{ route('logout') }}" class="dropdown-item"><i
                                    class="flaticon-home-fill-1 mr-1"></i>FINALIZAR</a>

                        </div>
                    </div>
                </div>


                <div class="footer">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script>
                        document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i class="icon-heart"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>

            </div>
        </nav>
        <!-- ============================================================== -->
        <!-- Start DIREITA here -->
        <!-- ============================================================== -->
        <div id="content" class="p-4 p-md-5 pt-5">

            <div class="widget-content widget-content-area">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        @if (empty($sessoes))
                        <div class="font-family-text">
                            <h3>Nenhuma sessão encontrada.</h3>
                        </div>
                        @else
                        @foreach ($sessoes as $sessao)
                        <div class="font-family-text">
                            <h3>{{ $sessao['nomeSessao'] }}</h3>
                        </div>
                        @endforeach
                        @endif

                        <hr>
                        <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                            data-target=".bd-example-modal-roteiro" data-title="roteiro">
                            ROTEIRO
                        </a>

                    </div>
                </div>
            </div>
            <hr>
            <!-- <div id="cronometro" class="d-flex justify-content-center mb-3">
                <h4 class="cronometro-label mr-3">Cronômetro:</h4>
                <h4 id="tempo" class="cronometro-tempo">00:00</h4>
            </div> -->
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center mb-3">
                        <div class="col-xl-10 mx-auto">
                            <blockquote class="blockquote">
                                <p>Momento de fala:</p>
                                <h6 class="d-inline" id="nomeVereador"></h6>
                            </blockquote>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex justify-content-center mb-3">
                        <div class="col-xl-10 mx-auto">
                            <blockquote class="blockquote">
                                <p>A parte:</p>
                                <h6 class="d-inline" id="nomeVereadorAParte"></h6>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input id="tempoAdicional" type="number" class="form-control"
                                        placeholder="Adicionar tempo em minutos">
                                    <div class="input-group-append">
                                        <button id="adicionarTempo"  class="btn btn-success" onclick="adicionarTempo()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-circle">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="16">
                                                </line>
                                                <line x1="8" y1="12" x2="16" y2="12">
                                                </line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mb-3">
                            <button id="adicionarUmMinuto" class="btn btn-primary mr-3">
                                +1
                            </button>
                            <button id="adicionarCincoMinutos" class="btn btn-secondary mr-3">
                                +5
                            </button>
                            <button id="resetarTempo" class="btn btn-danger">
                                RESETAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class='parent ex-1'>
                <div class="row">
                    @foreach ($usuarios as $usuario)
                    <div class="col-md-3 col-sm-6 mb-5 ">
                        <div id="card-{{ $usuario['nrSequence'] }}" class='dragula card-fixed mb-3'>
                            <div
                                class="media d-md-flex d-block text-center d-flex flex-column align-items-center justify-content-center h-100">
                                <img alt="avatar" src="{{ asset('uploads/' . $usuario['fotoPerfil']) }}"
                                    class="img-fluid mb-3">

                                <div class="media-body text-center mb-3">
                                    <h6 class="">{{ $usuario['nomeCompleto'] }}</h6>
                                    <p class="">{{ $usuario['partido'] }}</p>
                                </div>
                                @foreach($sessoes as $sessao)
                                <div class="text-center">
                                    <!-- {{-- <button id="iniciar-{{ $usuario['nrSequence'] }}"
                                    onclick="iniciarVereador({{ $usuario['nrSequence'] }}, '{{ $usuario['token'] }}',
                                    '{{ $sessao['nrSequence']}}', '{{ $usuario['nomeCompleto'] }}',)"
                                    data-nrSequence="{{ $usuario['nrSequence'] }}"
                                    data-nome="{{ $usuario['nomeCompleto'] }}"
                                    class="btn btn-outline-success mb-2 iniciar">Início</button> --}} -->
                                    <button id="iniciar-{{ $usuario['nrSequence'] }}"
                                        onclick="iniciarVereador({{ $usuario['nrSequence'] }}, '{{ $usuario['token'] }}', '{{ $sessao['nrSequence']}}', '{{ $usuario['nomeCompleto'] }}',)"
                                        data-nrSequence="{{ $usuario['nrSequence'] }}"
                                        data-nome="{{ $usuario['nomeCompleto'] }}"
                                        class="btn btn-outline-success mb-2 iniciar">Início</button>

                                    <button id="parar-{{ $usuario['nrSequence'] }}"
                                        onclick="pararVereadorIniciar({{ $usuario['nrSequence'] }})"
                                        data-nrSequence="{{ $usuario['nrSequence'] }}"
                                        class="btn btn-outline-danger mb-2 parar d-none">Parar</button>
                                    <button id="parar-a-parte-{{ $usuario['nrSequence'] }}"
                                        onclick="pararVereadorAParte({{ $usuario['nrSequence'] }})"
                                        data-nrSequence="{{ $usuario['nrSequence'] }}"
                                        class="btn btn-outline-danger mb-2 parar-a-parte d-none">Parar</button>
                                    <button id="a-parte-{{ $usuario['nrSequence'] }}"
                                        onclick="aparteVereador({{ $usuario['nrSequence'] }}, '{{ $usuario['nomeCompleto'] }}', '{{ $usuario['token'] }}', '{{ $sessao['nrSequence']}}', )"
                                        data-nrSequence="{{ $usuario['nrSequence'] }}"
                                        data-nome="{{ $usuario['nomeCompleto'] }}"
                                        class="btn btn-outline-warning mb-2 a-parte d-none">A
                                        parte</button>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

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
                    {{-- <embed id="pdf-embed" src="{{ asset('uploads/' . $roteiros[0]['docRoteiro']) }}"
                    type="application/pdf" style="width:100%; height:80vh;" /> --}}
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/main.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Start TRIBUNA here -->
    <!-- ============================================================== -->
    <script src="{{ url('assets/js/tribuna.js') }}"></script>
</body>

</html>