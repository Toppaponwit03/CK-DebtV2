<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class exportSFHP implements FromView
{
  

    public function view(): View
    {
        $data = DB::connection('ibmi2')->select("
        SELECT SFHP.ARMAST.CONTNO,
        SFHP.ARMAST.FDATE,
        SFHP.ARMAST.LDATE,
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
        
        WHERE SFHP.ARMAST.TOTPRC > SFHP.ARMAST.SMPAY AND HLDNO < 3
");
        return view('Exports.viewSFHP', [
            'data' =>  $data
        ]);
    }



    
}
