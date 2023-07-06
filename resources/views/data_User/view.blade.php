@extends('layouts.master')
@section('content')
@include('data_User.script')
<div class="row">
    <div class="col">
        <div class="card p-2">
            <div class="row">
                <div class="col">
                    <h5>ข้อมูลผู้ใช้ระบบ </h5>
                </div>
                <div class="col text-end">
                    <div type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="{{ route('static.create') }}?func={{'addUser'}}"><i class="fa-solid fa-user-plus"></i></div>
                </div>
            </div>
            <hr>

            <div class="table-responsive">
                <table id="tbUsers" class="table table-sm table-bordered table-striped" style="width:100%">
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
                            <td><i class="fa-solid fa-circle {{ $user->password != 'NULL' ? 'text-green' : 'text-danger' }}"></i> {{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->password_val }}</td>
                            <td>{{ $user->Branch }}</td>
                            <td>{{ $user->position }}</td>
                            <td class="text-center text-nowrap">
                                <button class="btn btn-warning btn-sm " data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="{{ route('static.edit',$user->id) }}?type={{1}}"><i class="fa-solid fa-user-pen"></i></button>
                                <a class="btn btn-primary btn-sm " href="{{ route('static.index') }}?type={{2}}&id={{$user->id}}"><i class="fa-solid fa-gears"></i></a>
                                <button class="btn btn-danger btn-sm btn-removeUser" id="{{$user->id}}"><i class="fa-solid fa-user-lock"></i></button>
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
