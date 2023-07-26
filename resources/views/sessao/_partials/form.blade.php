    @csrf

    <div class="form-row mb-4">
        <div class="form-group col-md-6">
            <label for="nomeSessao">NOME</label>

            <input type="text" id="nomeSessao" name="dto[nomeSessao]" class="form-control mb-4 text-uppercase"
                value="{{ $sessao[0]['nomeSessao'] ?? old('dto.nomeSessao') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="tipoSessao">TIPO</label>
            <select id="tipoSessao" class="form-control selectpicker text-uppercase" name="dto[tipoSessao]"
                data-style="btn btn-outline-info">
                <option value="">Escolha...</option>

                <option
                    {{ isset($sessao[0]['tipoSessao']) && $sessao[0]['tipoSessao'] == 'Ato solene' ? 'selected' : '' }}>
                    Ato solene</option>
                <option
                    {{ isset($sessao[0]['tipoSessao']) && $sessao[0]['tipoSessao'] == 'Especial' ? 'selected' : '' }}>
                    Especial</option>
                <option
                    {{ isset($sessao[0]['tipoSessao']) && $sessao[0]['tipoSessao'] == 'Extraordinária' ? 'selected' : '' }}>
                    Extraordinária</option>
                <option
                    {{ isset($sessao[0]['tipoSessao']) && $sessao[0]['tipoSessao'] == 'Ordinária' ? 'selected' : '' }}>
                    Ordinária</option>
                <option
                    {{ isset($sessao[0]['tipoSessao']) && $sessao[0]['tipoSessao'] == 'Secreta' ? 'selected' : '' }}>
                    Secreta</option>
                <option {{ isset($sessao[0]['tipoSessao']) && $sessao[0]['tipoSessao'] == 'Solene' ? 'selected' : '' }}>
                    Solene</option>
            </select>
        </div>

        <div class="form-group col-md-6" style="visibility: hidden;">
            <label for="statusSessao">TIPO</label>
            <select id="statusSessao" class="form-control selectpicker text-uppercase" name="dto[statusSessao]"
                data-style="btn btn-outline-info">

                <option
                    {{ isset($sessao[0]['statusSessao']) && $sessao[0]['statusSessao'] == 'CRIADA' ? 'selected' : 'selected' }}>
                    CRIADA</option>
                <option
                    {{ isset($sessao[0]['statusSessao']) && $sessao[0]['statusSessao'] == 'AUTORIZADA' ? 'selected' : '' }}>
                    AUTORIZADA</option>
                <option
                    {{ isset($sessao[0]['statusSessao']) && $sessao[0]['statusSessao'] == 'INICIADA' ? 'selected' : '' }}>
                    INICIADA</option>
                <option
                    {{ isset($sessao[0]['statusSessao']) && $sessao[0]['statusSessao'] == 'SUSPENSA' ? 'selected' : '' }}>
                    SUSPENSA</option>
                <option
                    {{ isset($sessao[0]['statusSessao']) && $sessao[0]['statusSessao'] == 'CANCELADA' ? 'selected' : '' }}>
                    CANCELADA</option>
                <option
                    {{ isset($sessao[0]['statusSessao']) && $sessao[0]['statusSessao'] == 'FINALIZADA' ? 'selected' : '' }}>
                    FINALIZADA</option>
            </select>
        </div>



    </div>
