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

    {{-- Data Tables --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.bootstrap5.min.css">

    {{-- Icon Title --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('dist/img/leasingLogo1.jpg') }}">
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    {{--Icon awesome --}}
    <script src="https://kit.fontawesome.com/0a2677fa63.js" crossorigin="anonymous"></script>

    {{--apex charts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    {{-- sweetalert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <style>
        .text-green{
            color : #47CD64;
        }
        .bg-pt-blue{
            background-color :	#bae1ff;
            color : #fff;
        }
        .bg-pt-green{
            background-color :	#baffc9;
            color : #fff;
        }
        .bg-pt-yellow{
            background-color :	#ffffba;
            color : #fff;
        }
        .bg-pt-orange{
            background-color :	#ffdfba;
            color : #fff;
        }
        .bg-pt-red{
            background-color :	#ffb3ba;
            color : #fff;
        }

        .bg-pt2-blue{
            background-color :	#a2d2ff;
            color : #fff;
        }

        .bg-pt2-red{
            background-color :	#ffafcc;
            color : #fff;
        }
        .bg-pt2-purple{
            background-color :	#cdb4db;
            color : #fff;
        }

        .bg-warm-orange-1{
            background-color :	#fec5bb;
            color : #fff;
        }
        .bg-warm-orange-2{
            background-color :	#ffd7ba;
            color : #fff;
        }
        .bg-warm-orange-3{
            background-color :	#ffe5d9;
            color : #fff;
        }
        .bg-warm-green-1{
            background-color :	#ece4db;
            color : #fff;
        }
        .bg-warm-green-2{
            background-color :	#d8e2dc;
            color : #fff;
        }
        .bg-warm-1{
            background-color :	#fec5bb;
            color : #fff;
        }
        .bg-indigo{
            background-color : #34495e;
            color : #fff;
        }
        body {
            font-family: 'Kanit', sans-serif;
        }
        .title {
            padding: 1.25rem;
            font-weight: 800;
            font-size:1.9rem;
            text-align: center;
            margin: auto;
        }
        .scroll{
            width: 300px;
            height: 600px;
            background-color: #DCDCDC;
            overflow: scroll;
        }
        .scrollbar
        {
            float: left;
            height: 300px;
            width: 65px;
            background: #Fff;
            overflow-y: scroll;
            margin-bottom: 25px;
        }
        .force-overflow
        {
            min-height: 450px;
        }
        #scroll-bar::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.0);
            border-radius: 10px;
            background-color: #Fff;
        }

        #scroll-bar::-webkit-scrollbar
        {
            width: 12px;
            background-color: #F5F5F5;
        }

        #scroll-bar::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
            background-color: #fff;
        }
        #scroll-bar:hover::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            background-color: #ececec;
        }
        #scroll-bar:hover::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            background-color: #Fff;
            opacity: 0.5;
        }


    </style>

<body id="page-top">
    <div id="wrapper">
        @include('layouts.slideNav')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @yield('modal')

    @include('layouts.publicScript')
        <script>
            $(document).on("load", function() {
            $('#data-table').hide();
            $('#data-table-onload').show();
            });
            $(document).ready(function () {

                $("#data-tbody").css("visibility", "");
                $('#data-table').show();
            $('#data-table-onload').hide();
            });
        </script>

  <div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-fullscreen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade " id="modal-lgDB">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-pt-blue">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-md">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
<div class="modal fade " id="modal-sm"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-transparent" style="border:0;">
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>

  <!-- Modal Load.. -->
  <div class="modal fade " id="modal-sm-load"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content bg-transparent" style="border:0;">
        <div class="modal-body">
            <div class="row">
                <div class="col mx-3 text-center">
                <lord-icon
                  src="https://cdn.lordicon.com/ypttvtwr.json"
                  trigger="loop"
                  style="width:200px;height:200px">
              </lord-icon>
              <div class="bg-white p-2 pt-3 rounded-5">
                <h6 class=""><b>กำลังอัพเดทข้อมูล โปรดรอซักครู่... </b></h6>
              </div>
                </div>
              </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- DataTable -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
</body>

</html>
