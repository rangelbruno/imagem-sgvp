<div class="modal fade" id="exampleModalapp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">config/app.php</h5>
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
                    /*
                    * Application Service Providers...
                    */
                    App\Providers\AppServiceProvider::class,
                    App\Providers\AuthServiceProvider::class,
                    // App\Providers\BroadcastServiceProvider::class,
                    App\Providers\EventServiceProvider::class,
                    App\Providers\RouteServiceProvider::class,
                    <b class="text-danger">App\Providers\ApiSgvpProvider::class,</b>
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
