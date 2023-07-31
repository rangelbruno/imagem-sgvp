<div class="modal fade" id="exampleModalApiSgvpProvider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">app/providers/ApiSgvpProvider.php</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18">
                        </line>
                        <line x1="6" y1="6" x2="18" y2="18">
                        </line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text">
                    <b class="text-danger">public function register()</b><br>
                    <b class="text-danger">{</b><br>
                    <b class="text-danger ml-2">$this->app->bind('api-sgvp', function(){</b><br>
                    <b class="text-danger ml-3">return Http::withOptions([</b><br>
                    <b class="text-danger ml-4">'verify' => false,</b><br>
                    <b class="text-danger ml-4">'base_uri' => 'https://sgvp-backend-api.herokuapp.com/api/'</b><br>
                    <b class="text-danger ml-3">]);</b><br>
                    <b class="text-danger ml-2"> });</b><br>
                    <b class="text-danger"> }</b><br>

                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
