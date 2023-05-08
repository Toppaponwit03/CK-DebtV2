    <div class="row p-2">
        <table class="table">
            <thead >
                <tr class="bg-primary">
                    <th>วันที่จ่ายล่าสุด</th>
                    <th>ยอดจ่ายเดือนนี้</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{@$data->lastPaymentdate}} </td>
                    <td>{{ ( @$data->TotalPay != NULL ) ? @$data->TotalPay : '-' }} </td>   
                
                </tr>
            </tbody>
        </table>  
    </div>
   <div class="row px-1">
        <div class="table-responsive">
            <table class="table table-sm text-center text-nowrap mb-2" id="tbPay">
                <thead>
                    <tr class="bg-primary text-center">
                        <th>สาขารับชำระ</th>
                        <th>วันที่ใบรับ</th>
                        <th>เลขที่ใบรับ</th>
                        <th>ชำระค่า</th>
                        <th>ชำระโดย</th>
                        <th>จำนวนชำระ</th>
                        <th>ชำระค่าปรับ</th>
                        <th>ส่วนลดค่าปรับ</th>
                        <th>รับสุทธิ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(@$datapay as $value)
                    @php 
                   $dateTMB =  App\datethai\thaidate::simpleDateFormatFull($value->TMBILDT);
                    @endphp
                    <tr>
                        <td> {{ $value->LOCATRECV }} </td>
                        <td> {{ $dateTMB }} </td>
                        <td> {{ $value->TMBILL }} </td>
                        <td> {{ $value->PAYFOR }} </td>
                        <td> {{ $value->PAYTYP }} </td>
                        <td> {{ $value->PAYAMT }} </td>
                        <td> {{ $value->PAYINT }} </td>
                        <td> {{ $value->DSCINT }} </td>
                        <td> {{ $value->NETPAY }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<script>
    $('#tbPay').DataTable({
        ordering: false,
        searching: false,
    });
</script>