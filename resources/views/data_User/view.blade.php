@extends('layouts.master')
@section('content')
@include('data_User.script')
<div class="row">
  <form class="row g-3 needs-validation" novalidate>
    <div class="col-md-4">
      <label for="validationCustom01" class="form-label">First name</label>
      <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationCustom02" class="form-label">Last name</label>
      <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationCustomUsername" class="form-label">Username</label>
      <div class="input-group">
        <span class="input-group-text" id="inputGroupPrepend">@</span>
        <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
        <div class="invalid-feedback">
          Please choose a username.
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <label for="validationCustom03" class="form-label">City</label>
      <input type="text" class="form-control" id="validationCustom03" required>
      <div class="invalid-feedback">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationCustom04" class="form-label">State</label>
      <select class="form-select" id="validationCustom04" required>
        <option selected disabled value="">Choose...</option>
        <option>...</option>
      </select>
      <div class="invalid-feedback">
        Please select a valid state.
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationCustom05" class="form-label">Zip</label>
      <input type="text" class="form-control" id="validationCustom05" required>
      <div class="invalid-feedback">
        Please provide a valid zip.
      </div>
    </div>
    <div class="col-12">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
        <label class="form-check-label" for="invalidCheck">
          Agree to terms and conditions
        </label>
        <div class="invalid-feedback">
          You must agree before submitting.
        </div>
      </div>
    </div>
    <div class="col-12">
      <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
  </form>
    <div class="col">
        <div class="card p-2">
            <h5>ข้อมูลผู้ใช้ระบบ </h5>
            <hr>

            <table id="tbUsers" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ชื่อในระบบ</th>
                        <th>ชื่อผู้ใช้งาน</th>
                        <th>รหัสผ่าน</th>
                        <th>สาขา</th>
                        <th>ตำแหน่ง</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $i = 1
                    @endphp
                    @foreach(@$users as $user)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->password_val }}</td>
                        <td>{{ $user->Branch }}</td>
                        <td>{{ $user->position }}</td>
                        <td class="text-center">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-lg" data-link="{{ route('static.edit',$user->id) }}?type={{1}}"><i class="fa-solid fa-user-pen"></i></button> 
                            <a class="btn btn-primary" href="{{ route('static.index') }}?type={{2}}&id={{$user->id}}"><i class="fa-solid fa-gears"></i></a> 
                            <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </td>
                       
                    </tr>
                    @php 
                    $i = $i + 1
                    @endphp
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    $('#tbUsers').DataTable();
});
</script>
@endsection

@section('modal')

<div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
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

  <div class="modal fade" id="modal-md">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  
@endsection