@csrf
<div class="row mt-3">
    <div class="col-md-4 mb-4">
        <div class="contact-name">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="dto[nome]" class="form-control mb-4 text-uppercase"
                value="{{ $usuario[0]['nomeCompleto'] ?? old('dto.nome') }}" required>

        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="contact-email">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="dto[email]" class="form-control mb-4 text-uppercase"
                value="{{ $usuario[0]['email'] ?? old('dto.email') }}" required>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="contact-cargo">
            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="dto[cargo]" class="form-control mb-4 text-uppercase"
                value="{{ $usuario[0]['cargo'] ?? old('dto.cargo') }}" required>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4 mb-4">
        <label for="perfil">Perfil</label>
        <div class="contact-perfil">
            <select class="form-control" id="perfil" name="dto[perfil]" required>
                <option value="">Escolha um perfil</option>
                <option
                    {{ isset($usuario[0]['perfil']) && $usuario[0]['perfil'] == 'ADMINISTRADOR' ? 'selected' : '' }}>
                    ADMINISTRADOR</option>
                <option {{ isset($usuario[0]['perfil']) && $usuario[0]['perfil'] == 'PRESIDENTE' ? 'selected' : '' }}>
                    PRESIDENTE</option>
                <option {{ isset($usuario[0]['perfil']) && $usuario[0]['perfil'] == 'VEREADOR' ? 'selected' : '' }}>
                    VEREADOR</option>
                <option {{ isset($usuario[0]['perfil']) && $usuario[0]['perfil'] == 'LEGISLATIVO' ? 'selected' : '' }}>
                    LEGISLATIVO</option>
                <option {{ isset($usuario[0]['perfil']) && $usuario[0]['perfil'] == 'SECRETÁRIO' ? 'selected' : '' }}>
                    SECRETÁRIO</option>
                <option {{ isset($usuario[0]['perfil']) && $usuario[0]['perfil'] == 'LEITOR' ? 'selected' : '' }}>
                    LEITOR</option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="contact-cpf">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="dto[cpf]" class="form-control mb-4"
                value="{{ $usuario[0]['cpf'] ?? old('dto.cpf') }}" required>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="contact-phone">
            <label for="senha">Senha:</label>
            <input type="password" name="dto[senha]" id="senha" value="" class="form-control">
        </div>
    </div>

</div>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="contact-nomePolitico" style="display: none;">
            <label for="nomePolitico">Nome Político:</label>
            <input type="text" id="nomePolitico" name="dto[nomePolitico]" class="form-control mb-4 text-uppercase"
                value="{{ $usuario[0]['nomePolitico'] ?? old('dto.nomePolitico') }}">
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="contact-partido" style="display: none;">
            <label for="partido">Partido:</label>
            <input type="text" id="partido" name="dto[partido]" class="form-control mb-4 text-uppercase"
                value="{{ $usuario[0]['partido'] ?? old('dto.partido') }}">
        </div>
    </div>
</div>


<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="status">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="dto[status]" required>
                <option value="">Escolha um status</option>
                <option {{ isset($usuario[0]['status']) && $usuario[0]['status'] == 'CADASTRADO' ? 'selected' : '' }}>
                    CADASTRADO</option>
                <option {{ isset($usuario[0]['status']) && $usuario[0]['status'] == 'ATIVO' ? 'selected' : '' }}>
                    ATIVO</option>
                <option {{ isset($usuario[0]['status']) && $usuario[0]['status'] == 'INATIVO' ? 'selected' : '' }}>
                    INATIVO</option>
            </select>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-8 mb-4">
        <div class="contact-location">
            <div class="custom-file-container" data-upload-id="myFirstImage">
                <label>
                    <a href="javascript:void(0)" class="custom-file-container__image-clear"
                        title="Remover Imagem">Remover Imagem x</a>
                </label>
                <label class="custom-file-container__custom-file">
                    <input type="file" name="dto[fotoPerfil]"
                        class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <span class="custom-file-container__custom-file__custom-file-control">
                        @if (isset($usuario[0]['fotoPerfil']) && $usuario[0]['fotoPerfil'])
                            <img alt="avatar" src="{{ asset('uploads/' . $usuario[0]['fotoPerfil']) }}"
                                class="rounded-circle" width="150" height="150" />
                        @else
                            Escolha um arquivo
                        @endif
                    </span>
                </label>
                <div class="custom-file-container__image-preview"></div>
            </div>
        </div>
    </div>
</div>
