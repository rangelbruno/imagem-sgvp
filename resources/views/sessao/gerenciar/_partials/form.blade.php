@csrf

<input type="hidden" class="form-control" id="inputEmail4" name="nrSeqSessao[nrSequence]"
    value="{{ $sessao[0]['nrSequence'] ?? old('nrSeqSessao.nrSequence') }}">

<div class="form-row mb-4">
    <div class="form-group col-md-3">
        <label for="inputEmail4">Ordem do Documento</label>
        <div class="input-group mb-6">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-shuffle">
                        <polyline points="16 3 21 3 21 8"></polyline>
                        <line x1="4" y1="20" x2="21" y2="3"></line>
                        <polyline points="21 16 21 21 16 21"></polyline>
                        <line x1="15" y1="15" x2="21" y2="21"></line>
                        <line x1="4" y1="4" x2="9" y2="9"></line>
                    </svg>
                </span>
            </div>
            <input type="number" name="dto[nrOrdemDoc]" class="form-control" aria-label="notification"
                aria-describedby="basic-addon1" value="{{ $documentos[0]['nrOrdemDoc'] ?? old('dto.nrOrdemDoc') }}"
                required>
        </div>
    </div>
</div>

<div class="form-row mb-4">
    <div class="form-group col-md-6">
        <label for="inputEmail4">Documento</label>
        <input type="text" class="form-control text-uppercase" id="inputEmail4" name="dto[titulo]"
            value="{{ $documentos[0]['titulo'] ?? old('dto.titulo') }}">
    </div>

    <div class="form-group col-md-6">
        <label for="inputPassword4">Autor</label>
        <select id="inputState" class="form-control text-uppercase" name="dto[autor]">
            <option value="" {{ empty(old('dto.autor', $documentos[0]['autor'] ?? '')) ? 'selected' : '' }}>
                Escolha...</option>
            @foreach ($nomesUsuarios as $nome)
                <option value="{{ $nome }}"
                    {{ old('dto.autor', $documentos[0]['autor'] ?? '') == $nome ? 'selected' : '' }}>{{ $nome }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-row mb-4">
    <div class="form-group col-md-6">
        <label for="inputPassword4">Tipo de documento</label>
        <select id="inputState" class="form-control text-uppercase" name="dto[tipoDoc]">
            <option selected>Escolha...</option>
            <option value="Projeto de lei"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Projeto de lei' ? 'selected' : '' }}>
                Projeto de lei</option>
            <option value="Indicação"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Indicação' ? 'selected' : '' }}>
                Indicação</option>
            <option value="Moção"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Moção' ? 'selected' : '' }}>
                Moção</option>
            <option value="Projeto de resolução"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Projeto de resolução' ? 'selected' : '' }}>
                Projeto de resolução</option>
            <option value="Veto"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Veto' ? 'selected' : '' }}>
                Veto</option>
            <option value="Requerimento"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Requerimento' ? 'selected' : '' }}>
                Requerimento</option>
            <option value="Projeto de lei executivo"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Projeto de lei executivo' ? 'selected' : '' }}>
                Projeto de lei executivo</option>
            <option value="Ato de mesa"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Ato de mesa' ? 'selected' : '' }}>
                Ato de mesa</option>
            <option value="Emenda"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Emenda' ? 'selected' : '' }}>
                Emenda</option>
            <option value="Subemenda"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Subemenda' ? 'selected' : '' }}>
                Subemenda</option>
            <option value="Projeto de decreto legislativo"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Projeto de decreto legislativo' ? 'selected' : '' }}>
                Projeto de decreto legislativo</option>
            <option value="Projeto de lei complementar"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Projeto de lei complementar' ? 'selected' : '' }}>
                Projeto de lei complementar</option>
            <option value="Projeto de emenda LOM - (Lei Orgânica Municipal)"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Projeto de emenda LOM - (Lei Orgânica Municipal)' ? 'selected' : '' }}>
                Projeto de emenda LOM - (Lei Orgânica Municipal)</option>
            <option value="Substitutivo"
                {{ isset($documentos[0]['tipoDoc']) && $documentos[0]['tipoDoc'] == 'Substitutivo' ? 'selected' : '' }}>
                Substitutivo</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="inputmomento">Momento</label>
        <select id="inputmomento" class="form-control text-uppercase" name="dto[momento]">
            <option selected>Escolha...</option>
            <option value="Expediente"
                {{ isset($documentos[0]['momento']) && $documentos[0]['momento'] == 'Expediente' ? 'selected' : '' }}>
                Expediente</option>
            <option value="Ordem do dia"
                {{ isset($documentos[0]['momento']) && $documentos[0]['momento'] == 'Ordem do dia' ? 'selected' : '' }}>
                Ordem do dia</option>
        </select>
    </div>
</div>

<div class="form-row mb-4">
    <div class="form-group col-md-6">

        @if (isset($documentos[0]['pdf']))
            <label for="exampleFormControlFile1">PDF Cadastrado</label>
            <div>
                <a href="{{ $documentos[0]['pdf'] }}" target="_blank">{{ $documentos[0]['pdf'] }}</a>
            </div>
            <br>
        @endif
        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="dto[pdf]">
    </div>


    <div class="form-group col-md-6">
        <label for="inputPassword4">Ementa</label>
        <textarea class="form-control text-uppercase" id="exampleFormControlTextarea1" rows="3" name="dto[ementa]">{{ $documentos[0]['ementa'] ?? old('dto.ementa') }}</textarea>
    </div>
</div>

<div class="form-row mb-4">
    <div class="form-group col-md-2">
        <label for="docLeitura" class="ml-3">SOMENTE LEITURA</label>
        <br>
        <label class="switch s-icons s-outline s-outline-secondary mt-2 ml-3">
            <input type="checkbox" name="dto[docLeitura]" value="true" id="docLeitura"
                {{ isset($documentos[0]['docLeitura']) && $documentos[0]['docLeitura'] ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
    <div class="form-group col-md-2 text-center">
        <label for="docVota" class="ml-3">VOTAÇÃO</label>
        <br>
        <label class="switch s-icons s-outline s-outline-secondary mt-2 ml-3">
            <input type="checkbox" name="dto[docVota]" value="true" id="docVota"
                {{ isset($documentos[0]['docVota']) && $documentos[0]['docVota'] ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
    <div class="form-group col-md-2 text-center">
        <label for="presidenteVota" class="ml-3">PRESIDENTE VOTA?</label>
        <br>
        <label class="switch s-icons s-outline s-outline-secondary mt-2 ml-3">
            <input type="checkbox" name="dto[presidenteVota]" value="true" id="presidenteVota"
                {{ isset($documentos[0]['presidenteVota']) && $documentos[0]['presidenteVota'] ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>

    {{-- <div class="form-group col-md-6" id="votacaoContainer">
        <label for="inputvotacao" id="votacaoLabel">Tipo de votação</label>
        <select id="inputvotacao" class="form-control text-uppercase" name="dto[votacao]" required>
            <option selected>Escolha...</option>
            <option value="Maioria Absoluta"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'Maioria Absoluta' ? 'selected' : '' }}>
                Maioria Absoluta</option>

            <option value="Maioria Qualificada (2/3)"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'Maioria Qualificada (2/3)' ? 'selected' : '' }}>
                Maioria Qualificada (2/3)</option>

            <option value="Maioria Qualificada (3/5)"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'Maioria Qualificada (3/5)' ? 'selected' : '' }}>
                Maioria Qualificada (3/5)</option>

            <option value="Maioria Simples"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'MAIORIA_SIMPLES' ? 'selected' : '' }}>
                Maioria Simples</option>
        </select>
    </div> --}}

    <div class="form-group col-md-6" id="votacaoContainer">
        <label for="inputvotacao" id="votacaoLabel">Tipo de votação</label>
        <select id="inputvotacao" class="form-control text-uppercase" name="dto[votacao]" required>
            <option selected>Escolha...</option>
            <option value="Maioria Absoluta"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'MAIORIA_ABSOLUTA' ? 'selected' : '' }}>
                Maioria Absoluta</option>

            <option value="Maioria Qualificada (2/3)"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'MAIORIA_QUALIFICADA_2_3' ? 'selected' : '' }}>
                Maioria Qualificada (2/3)</option>

            <option value="Maioria Qualificada (3/5)"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'MAIORIA_QUALIFICADA_3_5' ? 'selected' : '' }}>
                Maioria Qualificada (3/5)</option>

            <option value="Maioria Simples"
                {{ isset($documentos[0]['votacao']) && $documentos[0]['votacao'] == 'MAIORIA_SIMPLES' ? 'selected' : '' }}>
                Maioria Simples</option>
        </select>
    </div>


</div>

<script>
    // Obtém referências aos checkboxes
    const checkboxLeitura = document.getElementById('docLeitura');
    const checkboxVotacao = document.getElementById('docVota');
    const checkboxPresidenteVota = document.getElementById('presidenteVota');
    const votacaoContainer = document.getElementById('votacaoContainer');
    const votacaoLabel = document.getElementById('votacaoLabel');

    // Adiciona os ouvintes de evento para os checkboxes
    checkboxLeitura.addEventListener('change', handleLeituraCheckbox);

    function handleLeituraCheckbox() {
        if (checkboxLeitura.checked) {
            // Se o checkbox de Somente Leitura estiver marcado,
            // desabilita os outros checkboxes e oculta o campo de seleção
            checkboxVotacao.disabled = true;
            checkboxPresidenteVota.disabled = true;
            votacaoContainer.style.display = 'none';
            votacaoLabel.style.display = 'none';
        } else {
            // Se o checkbox de Somente Leitura estiver desmarcado,
            // habilita os outros checkboxes e exibe o campo de seleção
            checkboxVotacao.disabled = false;
            checkboxPresidenteVota.disabled = false;
            votacaoContainer.style.display = 'block';
            votacaoLabel.style.display = 'block';
        }
    }

    // Define a função para preencher os campos com os valores do documento existente
    function preencherCampos() {
        handleLeituraCheckbox(); // Executa a função para lidar com o estado inicial do checkbox de Somente Leitura

        // Verifica se o documento existe e se há valores a serem preenchidos
        @if (isset($documentos[0]))
            // Preenche a Ordem do Documento
            document.querySelector('input[name="dto[nrOrdemDoc]"]').value = '{{ $documentos[0]['nrOrdemDoc'] ?? '' }}';

            // Preenche o Autor
            document.querySelector('select[name="dto[autor]"]').value = '{{ $documentos[0]['autor'] ?? '' }}';

            // Preenche outros campos conforme necessário
        @endif
    }

    // Chama a função para preencher os campos assim que a página for carregada
    window.addEventListener('DOMContentLoaded', preencherCampos);
</script>
