<div class="card p-3">
    <div class="row">
        <div class="col">
            <div class="d-flex">
                <img src="{{ asset('dist/img/gif/editing.gif') }}" class="col"  style="max-width :75px;"> 
                <div class="col m-auto">
                    <h5> สถานะ ( Setting Status )</h5>
                </div>
            </div>
        </div>
        <div class="col text-end">
            <div type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="{{ route('static.create') }}?func={{'addStatus'}}"><i class="fa-solid fa-plus"></i></div>
        </div>
    </div>
    <hr>

    <div class="table-responsive">
        <table id="tbStatus" class="table table-sm table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>รหัสสถานะ</th>
                    <th>ชื่อสถานะ</th>
                    <th>กำลังใช้งาน</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach(@$status as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $item->Status_code }}</td>
                    <td>{{ $item->details }}</td>
                    <td>{{ $item->status }}</td>
                    <td class="text-nowrap">
                        <button class="btn btn-warning btn-sm " data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="{{ route('static.edit',$item->id) }}?func={{'editStatus'}}"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-danger btn-sm btn-removeUser" id="{{$item->id}}"><i class="fa-regular fa-trash-can"></i></button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

  </div>

  <script>
    $(document).ready(function () {
        $('#tbStatus').DataTable();
    })
 </script>