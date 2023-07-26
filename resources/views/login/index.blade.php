<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sistema - Login</title>
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
                        <div class="row d-flex justify-content-center">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="coming_soon">
                        </div>
                        <br><br>

                        {{-- <ul>
                            <li>ADMINISTRADOR</li>
                            <li>Usuário: 85453443766</li>
                            <li>senha: 1234</li>
                        </ul>
                        <ul>
                            <li>PRESIDENTE</li>
                            <li>Usuário: 23081571006</li>
                            <li>senha: 1234</li>
                        </ul>
                        <ul>
                            <li>VEREADR</li>
                            <li>Usuário: 38967002009</li>
                            <li>senha: 1234</li>
                        </ul> --}}

                        <!-- ============================================================== -->
                        <!-- Start MENSAGEM here -->
                        <!-- ============================================================== -->
                        @include('login.includes.msg')
                        <form class="text-left" method="POST" action="{{ route('autenticar') }}" autocomplete="off">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="">CPF</label>
                                <input id="cpf" name="cpf" type="text" class="form-control"
                                    placeholder="xxx.xxx.xxx-xx" autocomplete="off" required>

                            </div>
                            <div class="form-group ">
                                <label for="">SENHA</label>
                                <input id="password" name="senha" type="password" class="form-control"
                                    placeholder="Senha" autocomplete="off" value="1234" required>
                            </div>

                            <button type="submit" class="btn btn-outline-primary mt-3">ENTRAR</button>
                        </form>

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
    <script src="{{ url('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/pages/coming-soon/coming-soon.js') }}"></script>

</body>

</html>
