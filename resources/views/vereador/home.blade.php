@component('vereador.components.layouts.app')

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

            <div class="text-center">
                <a href="javascript:void(0);" class="btn btn-success btn-block mb-4 mr-2">Tribuna</a>
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
                </div>
            </div>
            <hr>
            <button class="btn btn-outline-primary mb-2">PAUTA</button>
        </div>
        <hr>

        <div class="widget-content widget-content-area">
            {{-- <div>
                <a href="" class="btn btn-outline-info mb-2">Votação em bloco</a>
            </div> --}}
            <div>
                <a href="" class="btn btn-outline-info mb-2 btn-votacao-bloco" id="btnVotacaoBloco"
                    style="display: none;">Votação em bloco</a>

            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="checkbox-column">
                                <label class="new-control new-checkbox checkbox-primary"
                                    style="height: 18px; margin: 0 auto;">
                                    <input type="checkbox" class="new-control-input todochkbox" id="todoAll">
                                    <span class="new-control-indicator"></span>
                                </label>
                            </th>
                            <th class="">Nome</th>
                            <th class="">Autor</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentos as $documento)
                            <tr>
                                <td class="checkbox-column">
                                    <label class="new-control new-checkbox checkbox-primary"
                                        style="height: 18px; margin: 0 auto;">
                                        <input type="checkbox" class="new-control-input todochkbox"
                                            id="todo-{{ $documento['nrSequence'] }}">
                                        <span class="new-control-indicator"></span>
                                    </label>
                                </td>
                                <td>
                                    <p class="mb-0">{{ $documento['titulo'] }}</p>
                                </td>
                                <td>{{ $documento['autor'] }}</td>

                                <td class="text-center">
                                    <button class="btn btn-outline-secondary">Discussão</button>
                                    <button class="btn btn-outline-success ml-2">Votação</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Adicionar um ouvinte de eventos para o botão "check all"
        let checkAllButton = document.querySelector('#todoAll');
        checkAllButton.addEventListener('change', function() {
            // Definir o valor "checked" de todas as caixas de seleção para o valor do botão "check all"
            let checkboxes = document.querySelectorAll('.todochkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checkAllButton.checked;
            });

            // Verificar quantas caixas de seleção estão selecionadas
            let checkboxesSelecionados = document.querySelectorAll('.todochkbox:checked');
            if (checkboxesSelecionados.length > 1) {
                // Mostrar o botão de votação em bloco se mais de uma caixa de seleção estiver selecionada
                document.querySelector('.btn-votacao-bloco').style.display = 'block';
            } else {
                // Ocultar o botão de votação em bloco se apenas uma caixa de seleção estiver selecionada
                document.querySelector('.btn-votacao-bloco').style.display = 'none';
            }
        });
    </script>

    <script>
        // Adicionar um ouvinte de eventos para todas as caixas de seleção
        let checkboxes = document.querySelectorAll('.todochkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Verificar quantas caixas de seleção estão selecionadas
                let checkboxesSelecionados = document.querySelectorAll('.todochkbox:checked');
                if (checkboxesSelecionados.length > 1) {
                    // Mostrar o botão de votação em bloco se mais de uma caixa de seleção estiver selecionada
                    document.querySelector('.btn-votacao-bloco').style.display = 'block';
                } else {
                    // Ocultar o botão de votação em bloco se apenas uma caixa de seleção estiver selecionada
                    document.querySelector('.btn-votacao-bloco').style.display = 'none';
                }

                // Verificar se todas as caixas de seleção estão selecionadas e atualizar o botão "check all" de acordo
                let checkAllButton = document.querySelector('#todoAll');
                if (checkboxesSelecionados.length === checkboxes.length) {
                    checkAllButton.checked = true;
                } else {
                    checkAllButton.checked = false;
                }
            });
        });

        // Adicionar um ouvinte de eventos para o botão "check all"
        let checkAllButton = document.querySelector('#todoAll');
        checkAllButton.addEventListener('change', function() {
            // Definir o valor "checked" de todas as caixas de seleção para o valor do botão "check all"
            let checkboxes = document.querySelectorAll('.todochkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checkAllButton.checked;
            });

            // Verificar quantas caixas de seleção estão selecionadas
            let checkboxesSelecionados = document.querySelectorAll('.todochkbox:checked');
            if (checkboxesSelecionados.length > 1) {
                // Mostrar o botão de votação em bloco se mais de uma caixa de seleção estiver selecionada
                document.querySelector('.btn-votacao-bloco').style.display = 'block';
            } else {
                // Ocultar o botão de votação em bloco se apenas uma caixa de seleção estiver selecionada
                document.querySelector('.btn-votacao-bloco').style.display = 'none';
            }
        });
    </script>
@endcomponent
