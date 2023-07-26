<div id="treeviewBasic" class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Chamando a API</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <p class="mb-3">1° Primeiro crio um controller chamado ApiController;</p>
            <p class="mb-3">2° Agora pasta app/providers e crio um novo arquivo "ApiSgvpProvider.php";</p>
            <p class="mb-3">3° Crio um nova pasta em app chamada de "Facades";</p>
            <p class="mb-3">4° Agora crio um arquivo dentro desta pasta chamado de "ApiSgvp.php";</p>
            <p class="mb-3">5° É necessário registrar este novo provider, vai em config/app.php e 'providers' =>
                insiro o
                "App\Providers\ApiSgvpProvider::class,";</p>
            <ul class="mt-3" id="myUL">
                <!-- ============================================================== -->
                <!-- APP -->
                <!-- ============================================================== -->
                <li>
                    <span class="caret">app</span>
                    <ul class="nested active">
                        <li>
                            <span class="caret caret-down">Http</span>
                            <ul class="nested">
                                <span class="caret caret-down">Controllers</span>
                                <ul class="nested">
                                    <li>
                                        <a href="" data-toggle="modal" data-target="#exampleModalapicontroller">
                                            <span>ApiController.php</span>
                                        </a>
                                    </li>
                                    <!-- ============================================================== -->
                                    <!-- Start CHAMADA MODAL ApiController -->
                                    <!-- ============================================================== -->
                                    @include('documentacao.includes.modal.apicontroller')
                                </ul>
                            </ul>
                        </li>
                        <li>
                            <span class="caret caret-down">providers</span>
                            <ul class="nested">
                                <li>
                                    <a href="" data-toggle="modal" data-target="#exampleModalApiSgvpProvider">
                                        <span>ApiSgvpProvider.php</span>
                                    </a>
                                </li>
                                <!-- ============================================================== -->
                                <!-- Start CHAMADA MODAL ApiSgvpProvider -->
                                <!-- ============================================================== -->
                                @include('documentacao.includes.modal.ApiSgvpProvider')
                            </ul>
                        </li>
                        <li>
                            <span class="caret caret-down">Facades</span>
                            <ul class="nested">
                                <li>
                                    <a href="" data-toggle="modal" data-target="#exampleModalApiSgvp">
                                        <span>ApiSgvp.php</span>
                                    </a>
                                </li>
                                <!-- ============================================================== -->
                                <!-- Start CHAMADA MODAL ApiSgvp -->
                                <!-- ============================================================== -->
                                @include('documentacao.includes.modal.ApiSgvp')
                            </ul>
                        </li>

                    </ul>
                </li>
                <!-- ============================================================== -->
                <!-- CONFIG -->
                <!-- ============================================================== -->
                <li>
                    <span class="caret">config</span>
                    <ul class="nested active">
                        <li>
                            <a href="" data-toggle="modal"
                                data-target="#exampleModalapp"><span>app.php</span></a>
                            <!-- ============================================================== -->
                            <!-- Start CHAMADA MODAL APP -->
                            <!-- ============================================================== -->
                            @include('documentacao.includes.modal.app')
                        </li>
                    </ul>
                </li>
            </ul>


        </div>
    </div>
</div>
