<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sistema - Recuperar senha</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- ============================================================== -->
    <!-- Start global STYLES here -->
    <!-- ============================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/forms/switches.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="form no-image-content">


    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Alterar Senha</h1>

                        <p class="signup-link recovery">Coloque uma nova senha!</p>
                        <form class="text-left">
                            <div class="form">

                                <div id="senha-field" class="field-wrapper input">
                                    <div class="d-flex justify-content-between">
                                        <label for="senha">Senha</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2"
                                            ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="senha" name="senha" type="password" class="form-control"
                                        value="" placeholder="Senha">
                                </div>
                                <div id="senha-field" class="field-wrapper input">
                                    <div class="d-flex justify-content-between">
                                        <label for="senha">Repita a Senha</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2"
                                            ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="senha" name="senha" type="password" class="form-control"
                                        value="" placeholder="Nova Senha">
                                </div>

                                <div class="d-sm-flex justify-content-between">

                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">ALTERAR</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- Start global SCRIPTS here -->
    <!-- ============================================================== -->
    <script src="{{ url('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/authentication/form-2.js') }}"></script>

</body>

</html>
