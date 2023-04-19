<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/0a2677fa63.js" crossorigin="anonymous"></script>

</head>
<body></body>

<div class="container">
<h1>REGISTER</h1>
    <form id="register" action="{{route('register')}}" method="post" >
    @csrf
<div class="row">
    <div class="col-6">
       <p>Name :</p> <input class="form-control" type="text" name="name" id="name" require>
    </div>
</div>
<div class="row">
    <div class="col-6">
       <p>Email :</p> <input class="form-control" type="text" name="email" id="email" require>
    </div>
</div>
<div class="row">
    <div class="col-6">
       <p>password :</p> <input class="form-control" type="password" name="password" id="password" require>
    </div>
</div>
<!--<div class="row">
    <div class="col-6">
       <p>confirmpassword :</p> <input class="form-control" type="password" name="conpassword" id="name" require>
    </div>
</div>-->
<div class="row">
    <div class="col-6">
       <p>Branch :</p> <input class="form-control" type="text" name="Branch" id="Branch" require>
    </div>
</div>
<div class="row ">
    <div class="col-6 mb-3">
       <p>Position :</p> <input class="form-control" type="text" name="position" id="position" require>
    </div>
</div>
<input class="btn btn-primary" value="register" type="submit" id="submit" name="submit">
</form>
</div>




<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

</body>
</html>