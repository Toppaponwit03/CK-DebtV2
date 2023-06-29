<table>
    <thead>
    <tr>
        <th>เลขที่สัญญา'</th>
        <th>คำนำหน้า'</th>
        <th>ชื่อ'</th>
        <th>นามสกุล'</th>
        <th>งวดแรก''</th>
        <th>งวดสุดท้าย'</th>
        <th>หมายเลขโทรศัพท์'</th>
        <th>รหัสพนักงานขาย'</th>
        <th>รหัสเจ้าหนี้'</th>
        <th>หมายเลขใบเก็บเงิน'</th>
        <th>ยอดที่ค้างชำระ'</th>
        <th>วันที่ชำระล่าสุด'</th>
        <th>ยอดชำระล่าสุด'</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr class="">
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->CONTNO )) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->SNAM)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->NAME1)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->NAME2)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->FDATE)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->LDATE)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->MOBILENO)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->SALCOD)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->BILLCOLL)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->HLDNO)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->EXP_AMT)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->LPAYD)) }}</td>
           <td>{{ trim(iconv('Tis-620', 'utf-8', $item->LPAYA)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>