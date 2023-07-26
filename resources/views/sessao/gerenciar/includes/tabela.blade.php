<table id="zero-config" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Ordem</th>
            <th class="no-content" data-search="true">Título</th>
            <th class="no-content">Momento</th>
            <th class="no-content text-truncate" style="max-width: 50px;">Ementa</th>
            <th class="no-content">Ação</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($sessao['documentos'] as $documento) --}}
        @foreach ($documentos as $documento)
            <tr>
                <td>
                    <h6 class="text-uppercase">{{ $documento['nrOrdemDoc'] }}</h6>
                </td>
                <td>
                    <h6 class="text-uppercase">{{ $documento['titulo'] }}</h6>
                <td>
                    <h6 class="text-uppercase">{{ $documento['momento'] }}</h6>
                </td>
                <td>
                    <h6 class="text-truncate mb-2 rounded bs-tooltip text-uppercase" data-placement="top"
                        style="max-width: 300px;" title="{{ $documento['ementa'] }}">
                        {{ $documento['ementa'] }}</h6>
                </td>

                <td>
                    <a href="{{ route('documento.editar', ['nrSequence' => $documento['nrSequence']]) }}"
                        class="btn btn-outline-warning mb-2 mr-2 " title="Editar"
                        data-id="{{ $documento['nrSequence'] }}">
                        EDITAR
                    </a>

                    {{-- <a href="{{ route('documento.editar', $sessao[0]['nrSequence']) }}"
                        class="btn btn-outline-warning mb-2 mr-2 " title="Editar">
                        EDITAR
                    </a> --}}

                    {{-- <a href="{{ route('documento.cadastrar', $sessao[0]['nrSequence']) }}"
                        class="btn btn-success mb-2 mr-2">Cadastrar
                        Documento</a> --}}

                    {{-- <a href="{{ route('documento.editar', array_merge(['nrSequence' => $documento['nrSequence']], ['nrSequenceSessao' => $sessao[0]['nrSequence']])) }}"
                        class="btn btn-outline-warning mb-2 mr-2 " title="Editar"
                        data-id="{{ $documento['nrSequence'] }}">
                        EDITAR
                    </a> --}}


                </td>
            </tr>
        @endforeach



    </tbody>
</table>
