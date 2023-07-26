<table id="zero-config" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Status</th>
            <th class="no-content">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sessoes as $sessao)
            <tr>
                <td>{{ $sessao['nrSequence'] }}</td>
                <td class="text-uppercase">{{ $sessao['nomeSessao'] }}</td>
                <td class="text-uppercase">{{ $sessao['tipoSessao'] }}</td>
                <td>
                    <!-- Formulário de alteração de status -->
                    <form method="POST" action="{{ route('sessao.updateStatus', $sessao['nrSequence']) }}"
                        id="updateStatusForm_{{ $sessao['nrSequence'] }}">
                        @csrf
                        <input type="hidden" class="text-uppercase" name="status"
                            id="statusInput_{{ $sessao['nrSequence'] }}">
                        <div class="btn-group">
                            <button
                                class="btn btn-sm dropdown-toggle @switch($sessao['status'])
                                    @case('AUTORIZADA')
                                        btn-outline-success
                                        @break
                                    @case('CRIADA')
                                        btn-outline-info
                                        @break
                                    @case('SUPENSA')
                                        btn-outline-warning
                                        @break
                                    @case('CANCELADA')
                                        btn-outline-danger
                                        @break
                                    @case('FINALIZADA')
                                        btn-outline-danger
                                        @break
                                    @default
                                        btn-outline-dark
                                @endswitch"
                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $sessao['status'] }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>

                            <div class="dropdown-menu">
                                <a href="javascript:void(0);" class="dropdown-item text-success"
                                    onclick="submitUpdateStatusForm('AUTORIZADA', {{ $sessao['nrSequence'] }})">AUTORIZADA</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item text-info"
                                    onclick="submitUpdateStatusForm('CRIADA', {{ $sessao['nrSequence'] }})">CRIADA</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item text-warning"
                                    onclick="submitUpdateStatusForm('SUPENSA', {{ $sessao['nrSequence'] }})">SUPENSA</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item text-danger"
                                    onclick="submitUpdateStatusForm('CANCELADA', {{ $sessao['nrSequence'] }})">CANCELADA</a>
                                <a href="javascript:void(0);" class="dropdown-item text-danger"
                                    onclick="submitUpdateStatusForm('FINALIZADA', {{ $sessao['nrSequence'] }})">FINALIZADA</a>
                            </div>
                        </div>
                    </form>
                </td>
                <td>
                    @if ($sessao['status'] == 'CRIADA' || $sessao['status'] == 'AUTORIZADA')
                        <a href="{{ route('sessao.gerenciar', $sessao['nrSequence']) }}"
                            class="btn btn-outline-primary mr-2 rounded-circle" title="Gerenciar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                        </a>
                    @else
                        <a class="btn btn-outline-default mr-2 rounded-circle" title="Gerenciar" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                        </a>
                    @endif
                    &nbsp;
                    <a href="{{ route('sessao.editar', $sessao['nrSequence']) }}"
                        class="btn btn-outline-warning mr-2 rounded-circle" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-edit">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </a>
                </td>

            </tr>
        @endforeach
    </tbody>


    <script>
        function submitUpdateStatusForm(status, nrSequence) {
            document.getElementById('statusInput_' + nrSequence).value = status;
            document.getElementById('updateStatusForm_' + nrSequence).submit();
        }
    </script>
</table>
