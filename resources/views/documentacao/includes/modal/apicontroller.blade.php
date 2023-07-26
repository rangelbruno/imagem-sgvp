<div class="modal fade" id="exampleModalapicontroller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">app/ApiController.php</h5>
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
                    use Illuminate\Http\Request; <br>
                    <b class="text-danger">use Illuminate\Support\Facades\Http;</b><br>
                    <b class="text-danger">use App\Facades\ApiSgvp;</b><br>
                    <br>
                    <b class="text-danger"> public function index()</b><br>
                    <b class="text-danger">{</b><br>
                    <b class="text-danger ml-3">return ApiSgvp::get('/usuarios/autenticar')->json();</b><br>
                    <b class="text-danger">}</b><br>

                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>