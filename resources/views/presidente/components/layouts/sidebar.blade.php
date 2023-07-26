<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>

    <div class="p-4">

        <div class="text-center avatar avatar-xl">
            <img alt="avatar" src="{{ asset('assets/img/profile-7.jpg') }}" class="rounded-circle" />
            <p class="text-white"></p>
            <div class="btn-group mb-4 mr-2" role="group">
                <button id="btnOutline" type="button" class="btn btn-outline-white dropdown-toggle"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $nome }} <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevron-down">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg></button>
                <div class="dropdown-menu" aria-labelledby="btnOutline">
                    <a href="{{ route('logout') }}" class="dropdown-item"><i
                            class="flaticon-home-fill-1 mr-1"></i>FINALIZAR</a>

                </div>
            </div>
        </div>


        <div class="footer">
            <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script> All rights reserved | This template is made with <i class="icon-heart"
                    aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
        </div>

    </div>
</nav>
