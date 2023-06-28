<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class exportSFHP implements FromQuery
{
    use Exportable;
    public function query()
    {
        $data = DB::connection('ibmi2')->select("
        SELECT SFHP.ARMAST.CONTNO,
 	   SFHP.CUSTMAST.SNAM,
 	   SFHP.CUSTMAST.NAME1,
 	   SFHP.CUSTMAST.NAME2,
 	   SFHP.CUSTMAST.MOBILENO,
 	   SFHP.ARMAST.SALCOD,
 	   SFHP.ARMAST.BILLCOLL,
 	   SFHP.ARMAST.HLDNO,
 	   SFHP.ARMAST.EXP_AMT,
 	   SFHP.ARMAST.LPAYD,
 	   SFHP.ARMAST.LPAYA
 	   
        FROM SFHP.ARMAST
        LEFT JOIN SFHP.CUSTMAST ON SFHP.CUSTMAST.CUSCOD = SFHP.ARMAST.CUSCOD
        LEFT JOIN SFHP.INVTRAN ON SFHP.ARMAST.CONTNO = SFHP.INVTRAN.CONTNO
        ");
        return collect($data);
    }

        // กำหนดค่าสำหรับภาษาไทย
        public function map($data): array
        {
            return [
                $data->CONTNO,
                $data->SNAM,
                $data->NAME1,
                $data->NAME2,
                $data->MOBILENO,
                $data->SALCOD,
                $data->BILLCOLL,
                $data->HLDNO,
                $data->EXP_AMT,
                $data->LPAYD,
                $data->LPAYA,
            ];
        }
    
        // กำหนดชื่อหัวคอลัมน์
        public function headings(): array
        {
            return [
                'เลขที่สัญญา',
                'นามสกุล',
                'ชื่อ',
                'นามสกุล',
                'หมายเลขโทรศัพท์',
                'รหัสพนักงานขาย',
                'รหัสเจ้าหนี้',
                'หมายเลขใบเก็บเงิน',
                'ยอดที่ค้างชำระ',
                'วันที่ชำระล่าสุด',
                'ยอดชำระล่าสุด',
            ];
        }
    
}
