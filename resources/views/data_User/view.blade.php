@extends('layouts.master')
@section('content')
@include('data_User.script')

{{-- <div class="row">
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
</div> --}}

<div class="row g-2">
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
      <div class="card p-2">
        <div class="nav nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <button class="nav-link btn-light col-12" disabled>ตั้งค่าระบบ <i class="fa-solid fa-gear"></i></button>
          <button class="nav-link active col-12" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">ข้อมูลผู้ใช้ระบบ <i class="fa-solid fa-database"></i></button>
          <button class="nav-link col-12" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">ทีมตามหนี้ <i class="fa-solid fa-user-group"></i></button>
          <button class="nav-link col-12" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false">กลุ่มค้างงวด <i class="fa-solid fa-layer-group"></i></button>
          <button class="nav-link col-12" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">สถานะ <i class="fa-solid fa-hourglass-half"></i></button>
        </div>
      </div>
    </div>
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
          <div id="data-user">
            {{-- ข้อมูลผู้ใช้ระบบ --}}
            @include('data-static.section-append.data-user')
          </div>
        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
          <div id="data-employee">
            {{-- ข้อมูลทีมตามหนี้ --}}
            @include('data-static.section-append.data-employee')
          </div>
        </div>
        <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">
              <div id="data-groupdebt">
            {{-- ข้อมูลกลุ่มค้างงวด --}}
            @include('data-static.section-append.data-groupdebt')
          </div>
        </div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">
              <div id="data-status">
            {{-- ข้อมูลสถานะ --}}
            @include('data-static.section-append.data-status')
          </div>
        </div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
          ...
        </div>
      </div>
    </div>
</div>

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
