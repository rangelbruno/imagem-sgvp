<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="myLargeModalLabel">Titulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text">
                    <button class="btn btn-success mb-4 mr-3 btn-lg vote-button" data-vote="SIM">SIM</button>
                    <button class="btn btn-danger mb-4 mr-3 btn-lg vote-button" data-vote="NAO">NÃO</button>

                    <button class="btn btn-dark mb-4 btn-lg vote-button" data-vote="abster">ABSTER</button>
                </p>
                <div id="vote-message" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="acompanhar-votacao">Acompanhar votação</button>

            </div>
        </div>
    </div>
</div>
