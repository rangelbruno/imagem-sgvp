<x-layouts.app title="Bem-vindo" namepage="CadUSer">

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget widget-content-area br-4">
                <div class="widget-one">

                    <h6>CadUser</h6>
                    <hr>
                    <hr>
                    <form action="{{ route('usuarios.cadastrar') }}" method="POST">
                        @csrf
                        <div>
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome">
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email">
                        </div>
                        <div>
                            <label for="cargo">Cargo</label>
                            <input type="text" name="cargo" id="cargo">
                        </div>
                        <div>
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf">
                        </div>
                        <div>
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha">
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <input type="text" name="status" id="status">
                        </div>
                        <button type="submit">Cadastrar</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
