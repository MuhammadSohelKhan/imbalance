<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <!-- Please, do not touch this -->
    <title> @yield('title') </title>
    <!-- Please, do not touch this -->

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('storage/files/1/template/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('storage/files/1/template/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('storage/files/1/template/css/style.css') }}" rel="stylesheet">

    <!-- Please, do not touch this -->
    @section('meta')
    @show
    <!-- Please, do not touch this -->
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid d-none d-lg-block">
        <div class="row py-3 px-xl-5 align-items-center justify-content-center">
            <div class="col-lg-3">
                <a href="" class="text-decoration-none">
                    <img src="/storage/files/1/image/front_home/logo-001-test.png" class="w-100" style="height: 65px;">
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5 justify-content-center">
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0"><span class="text-primary">E</span>COURSES</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                        <div class="navbar-nav py-0">
                        @php
                            $currentUrl = Request::url();
                            $explodedUrl = explode('/', $currentUrl);
                            $basePath = URL::to('/');
                            $endPath = '/'.end($explodedUrl);
                        @endphp
                        @foreach($menus as $menu)
                            @if($childCount = $menu->childs->count())
                            <div class="nav-item dropdown">
                                <a href="{{ $menu->link ?? '#' }}" class="nav-link dropdown-toggle @for($i=0; $i<$childCount; $i++) @if($endPath == $menu->childs[$i]->link) {{ 'active' }} @endif @endfor" data-toggle="dropdown">{{$menu->name??''}}</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                @foreach($menu->childs as $child)
                                    <a href="{{$child->link??'#'}}" class="dropdown-item @if($endPath == $child->link) {{ 'active' }} @endif">{{$child->name??''}}</a>
                                @endforeach
                                </div>
                            </div>
                            @else
                            <a href="{{$menu->link??'#'}}" class="nav-item nav-link @if($endPath == $menu->link || strtolower($menu->name) == 'home' && $basePath == $currentUrl) {{ 'active' }} @endif">{{$menu->name??''}}</a>
                            @endif
                        @endforeach
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Please, do not touch this -->
    @section('elements')
    @show
    <!-- Please, do not touch this -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white py-5 px-sm-3 px-lg-5" style="margin-top: 90px;">
        <div class="row pt-5">
            <div class="col-lg-7 col-md-12">
                <div class="row">
                    <div class="col-md-6 mb-5">
                        <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Get In Touch</h5>
                        <p><i class="fa fa-map-marker-alt mr-2"></i>123 Street, New York, USA</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                        <p><i class="fa fa-envelope mr-2"></i>info@example.com</p>
                        <div class="d-flex justify-content-start mt-4">
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-outline-light btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Our Courses</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Web Design</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Apps Design</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Marketing</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Research</a>
                            <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>SEO</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 mb-5">
                <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Newsletter</h5>
                <p>Rebum labore lorem dolores kasd est, et ipsum amet et at kasd, ipsum sea tempor magna tempor. Accu kasd sed ea duo ipsum. Dolor duo eirmod sea justo no lorem est diam</p>
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control border-light" style="padding: 30px;" placeholder="Your Email Address">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white">&copy; <a href="#">Domain Name</a>. All Rights Reserved. Designed by <a href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-lg-6 text-center text-md-right">
                <ul class="nav d-inline-flex">
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('storage/files/1/template/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('storage/files/1/template/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('storage/files/1/template/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('storage/files/1/template/mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('storage/files/1/template/js/main.js') }}"></script>


    <!-- Please, do not touch this -->
    @section('scripts')
    @show
    <!-- Please, do not touch this -->
</body>
</html>