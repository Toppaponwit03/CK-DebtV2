{{--
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
           <img src="{{ asset('dist/img/leasingLogo1.jpg') }}" style="width:15rem; border-radius:50%" />  
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Username') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> 
--}}



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ระบบติดตามหนี้</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">


    <link rel="icon" type="image/x-icon" href="{{ asset('dist/img/leasingLogo1.jpg') }}">
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>



    </head>

<body class="bg-gradient-light">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5" style="max-height : 500px; min-height : 500px;">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 m-auto d-none d-lg-block text-center">
                                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button  type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{asset('dist/img/imglogin4.jpg')}}" alt="" style="width : 100%;">
                                            <div class="carousel-caption d-none d-md-block ">
                                                <h5>Chookiat Debt</h5>
                                                <p>ระบบติดตามหนี้</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{asset('img/undraw_com.svg')}}" alt="" style="width : 100%;">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Chookiat Commission</h5>
                                                <p>ระบบคำนวนค่าคอมมิชชั่น</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                               
                            </div>
                            <div class="col-lg-6 ">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Chookiat Hatyai</h1>
                                    </div>
                                    <form class="user"  method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <div>
                                                <x-jet-label for="email" value="{{ __('Username') }}" />
                                                <x-jet-input id="email" class="form-control form-control-user" type="email" name="email" :value="old('email')" required autofocus />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <i class="fa fa-cc-discover" aria-hidden="true"></i>
                                            <x-jet-label for="password" value="{{ __('Password') }}" />
                                            <x-jet-input id="password" class="form-control form-control-user" type="password" name="password" required autocomplete="current-password" />
                                        </div>
                                      
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <label for="remember_me" class="">
                                                    <x-jet-checkbox id="remember_me" name="remember" />
                                                    <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="">
                                            <x-jet-button class="btn btn-primary btn-user btn-block">
                                                {{ __('Log in') }}
                                            </x-jet-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
