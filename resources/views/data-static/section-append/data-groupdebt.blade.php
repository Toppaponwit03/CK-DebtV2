<div class="card p-3">
    <div class="row">
        <div class="col">
            <div class="d-flex">
                <img src="{{ asset('dist/img/gif/editing.gif') }}" class="col"  style="max-width :75px;"> 
                <div class="col m-auto">
                    <h5> กลุ่มค้างงวด ( Setting Groupdebt )</h5>
                </div>
            </div>
        </div>
        <div class="col text-end">
            <div type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="{{ route('static.create') }}?func={{'addGroupdebt'}}"><i class="fa-solid fa-plus"></i></div>
        </div>
    </div>
    <hr>

    <div class="table-responsive">
        <table id="tbGroupdebt" class="table table-sm table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>กลุ่ม</th>
                    <th>รหัสกลุ่ม</th>
                    <th>รายละเอียด</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach(@$groupDebt as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $item->nameGroup }}</td>
                    <td>{{ $item->Groupdebt_Code }}</td>
                    <td>{{ $item->detail }}</td>
                    <td class="text-nowrap">
                        <button class="btn btn-warning btn-sm " data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="{{ route('static.edit',$item->id) }}?func={{'editGroupdebt'}}"><i class="fa-solid fa-pen-to-square"></i></button>
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
        $('#tbGroupdebt').DataTable();
     })
  </script>


