@component('vereador.components.layouts.app')
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
<link href="{{ url('assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css">
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
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevron-down">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg></button>
                <div class="dropdown-menu" aria-labelledby="btnOutline">
                    <a href="{{ route('logout') }}" class="dropdown-item"><i
                            class="flaticon-home-fill-1 mr-1"></i>FINALIZAR</a>

                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="javascript:void(0);" class="btn btn-success btn-block mb-4 mr-2" data-toggle="modal"
                data-target="#fadeinModal">TRIBUNA</a>
        </div>
        <div class="text-center">
            <a href="javascript:void(0);" class="btn btn-success btn-block mb-4 mr-2">Ordem do dia</a>
        </div>

        <div class="footer float-end" style="float:inline-end">
            <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <script>
                document.write(new Date().getFullYear());
                </script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i>
                by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
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
            </div>
        </div>
    </div>
    <hr>

    <div class="widget-content widget-content-area">

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Titulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-text">
                            <button class="btn btn-success mb-4 mr-3 btn-lg">SIM</button>
                            <button class="btn btn-danger mb-4 btn-lg">NÃO</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                <thead>
                    <tr>
                        <th class="">Nome</th>
                        <th class="">Autor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos as $documento)
                    <tr>
                        <td>
                            <p class="mb-0">{{ $documento['titulo'] }}</p>
                        </td>
                        <td>{{ $documento['autor'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Start SCRIPT VOTAÇÃO here -->
<!-- ============================================================== -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('875de73cad282b0e7de3', {
    cluster: 'sa1'
});

var channel = pusher.subscribe('modal-channel');
channel.bind('ModalVota', function(data) {

    // Preencha os dados no modal
    $('#myLargeModalLabel').text(data.data.titulo);
    // Coloque o título aqui

    // Agora você pode mostrar o modal
    $('.bd-example-modal-lg').modal('show');
});
</script>


<!-- ============================================================== -->
<!-- Start MODAL TRIBUNA here -->
<!-- ============================================================== -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Titulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text">
                    <button class="btn btn-success mb-4 mr-3 btn-lg vote-button" data-vote="SIM">SIM</button>
                    <button class="btn btn-danger mb-4 btn-lg vote-button" data-vote="NAO">NÃO</button>
                </p>
                <div id="vote-message" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#fadeinModal .btn-primary').on('click', function() {
        $.ajax({
            url: '{{ route('
            inscrever - tribuna ') }}',
            type: 'POST',
            data: {
                nrSeqSessao: {
                    {
                        $nrSeqSessao
                    }
                },
                nrSeqUsuarioTribuna: {
                    {
                        $nrSeqUsuario
                    }
                }
            },
            success: function(data) {
                console.log(data);
                alert(data.message);
                $('#fadeinModal').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Houve um erro ao inscrever para a tribuna: ' + textStatus);
            }
        });
    });
});
</script>



@endcomponent