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
        {{ $slot }}
    </div>


    {{-- <script src="{{ url('assets/js/jquery.min.js') }}"></script> --}}
    <script src="{{ url('assets/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/main.js') }}"></script>
</body>

</html>
