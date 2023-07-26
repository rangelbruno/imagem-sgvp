@component('presidente.components.layouts.app')
<meta name="nr-sequence" content="{{ session('nrSequence') }}">
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
<link href="{{ url('assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/clock.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/components/custom-list-group.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />


<script src="plugins/sweetalerts/promise-polyfill.js"></script>

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
            <img alt="avatar" src="" class="rounded-circle" width="90" height="90" />
            <p class="text-white"></p>
            <div class="btn-group mb-4 mr-2" role="group">
                <button id="btnOutline" type="button" class="btn btn-outline-white dropdown-toggle text-center"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $nome }}
                    - (pp) <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
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
                    <h3 class="text-uppercase">{{ $sessao['nomeSessao'] }}</h3>
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
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-success">PRESENTES:<b> <span></span> </b></h6>
                        <h6><b class="text-danger">AUSENTES:</b></h6>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="widget-content widget-content-area">
        <!-- ============================================================== -->
        <!-- Start BOTÃO VOTAÇÃO E VOTAÇÃO EM BLOCO here -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-6 text-center">
                <div class="font-family-info">
                    {{-- <h4 class="text-uppercase"> {{ $statusVoto['estatistica']['documentoName'] }} </h4> --}}
                    <h4 class="text-uppercase"> </h4>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <a href="{{ url()->current() }}" class="btn btn-outline-primary mr-5 text-right">ATUALIZAR VOTAÇÃO</a>
                <a class="btn btn-outline-danger text-right warning confirm">FINALIZAR VOTAÇÃO</a>
            </div>
        </div>
        <hr>
        <!-- ============================================================== -->
        <!-- Start RESULTADO VOTAÇÃO here -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-3 text-center">
                <div class="widget-content widget-content-area" style="background-color: #e42a2a34">
                    <div class="font-family-text">
                        <span>RESULTADO</span>
                        <h5 class="text-danger text-center">
                            <b class="text-uppercase">
                                Resultado aqui!
                            </b>
                        </h5>
                    </div>


                </div>
            </div>
            <div class="col-lg-3 text-center">
                <div class="widget-content widget-content-area">
                    <div class="font-family-text">
                        <span>TOTAL DE VOTOS</span>
                        <h5 class="text-center">
                            <b>

                            </b>
                        </h5>
                    </div>

                </div>
            </div>
            <div class="col-lg-2 text-center">
                <div class="widget-content widget-content-area" style="background-color: #2ae42a34">
                    <div class="font-family-text text-success">
                        <span>A FAVOR</span>
                        <h5 class="text-success">
                            <b>

                            </b>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 text-center">
                <div class="widget-content widget-content-area" style="background-color: #e42a2a34">
                    <div class="font-family-text text-danger">
                        <span>CONTRARIO</span>
                        <h5 class="text-danger">
                            <b>
                                {{-- {{ $statusVoto['estatistica']['nao'] }} --}}
                            </b>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 text-center">
                <div class="widget-content widget-content-area" style="background-color: #0e270e34">
                    <div class="font-family-text">
                        <span>ABSTEVE</span>
                        <h5 class="text-dark">
                            <b>
                                {{-- {{ $statusVoto['estatistica']['absteve'] }} --}}
                            </b>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- ============================================================== -->
        <!-- Start MODAL FINALIZAR VOTAÇÃO here -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Start TABELA DOS VEREADORES here -->
        <!-- ============================================================== -->
        <div class="row">
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="widget-content widget-content-area">
                    <ul class="list-group list-group-media">
                        <li class="list-group-item list-group-item-action mb-3" style="background-color: #2ae42a34">
                            <div class="media">
                                <div class="mr-3">
                                    {{-- <img alt="avatar"
                                            src="{{ asset('uploads/' . $voto['usuarioVoto']['fotoPerfil']) }}"
                                    class="img-fluid rounded-circle"> --}}
                                </div>
                                <div class="media-body">
                                    {{-- <h6 class="tx-inverse">{{ $voto['usuarioVoto']['nomeCompleto'] }}</h6> --}}
                                    {{-- <p class="mg-b-0">{{ $voto['usuarioVoto']['partido'] }}</p> --}}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
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
<!-- Start MODAL DO ROTEIRO here -->
<!-- ============================================================== -->
<div class="modal fade bd-example-modal-roteiro" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">ROTEIRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                @if (!empty($roteiros[0]['docRoteiro']))
                <embed id="pdf-embed" src="{{ asset('uploads/' . $roteiros[0]['docRoteiro']) }}" type="application/pdf"
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

<script>
$('.widget-content .warning.confirm').on('click', function() {
    swal({
        title: 'Finalizar votação?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Finalizar',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            swal(
                'Votação finalizada com sucesso!',
                '',
                'success'
            ).then(function() {
                // Redireciona para a rota 'presidente.home'
                window.location.href = "{{ route('presidente.home') }}";
            });
        }
    })
});
</script>

@endcomponent