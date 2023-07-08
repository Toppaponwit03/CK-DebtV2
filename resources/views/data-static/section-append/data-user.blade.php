<div class="card p-3">
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
                @foreach(@$users as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><i class="fa-solid fa-circle {{ $user->password != 'NULL' ? 'text-green' : 'text-danger' }}"></i> {{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->password_val }}</td>
                    <td>{{ $user->Branch }}</td>
                    <td>{{ $user->position }}</td>
                    <td class="text-nowrap">
                        <button class="btn btn-warning btn-sm " data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="{{ route('static.edit',$user->id) }}?type={{1}}"><i class="fa-solid fa-user-pen"></i></button>
                        <a class="btn btn-primary btn-sm " href="{{ route('static.index') }}?type={{2}}&id={{$user->id}}"><i class="fa-solid fa-gears"></i></a>
                        <button class="btn btn-danger btn-sm btn-removeUser" id="{{$user->id}}"><i class="fa-solid fa-user-lock"></i></button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

  </div>

  <script>
    $(document).ready(function () {
        $('#tbUsers').DataTable();
    })
 </script>