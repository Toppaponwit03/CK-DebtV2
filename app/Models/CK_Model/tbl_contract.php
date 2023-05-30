<?php

namespace App\Models\CK_Model;

use App\Models\CK_Model\tbl_calculate;
use App\Models\CK_Model\tbl_custagcal;
use App\Models\CK_Model\tbl_typeLoan;
use App\Models\tbl_traceEmployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_contract extends Model
{
    use HasFactory;
    protected $connection = 'ck';
    protected $table = 'Pact_Contracts';
    protected $fillable = ['DataCus_id','DataTag_id',
                            'FlagActices_Con','NameActices_Con','CodeLoan_Con','Contract_Con','Status_Con',
                            'UserSent_Con','BranchSent_Con','Date_con','UserApp_Con','StatusApp_Con','UserCancel_Con','DateCancel_Con',
                            'DocApp_Con','DateDocApp_Con','ConfirmDocApp_Con','DateConfirmDocApp_Con','AuditDoc_Con','DateAuditDoc_Con','ConfirmApp_Con','DateConfirmApp_Con','Checkers_Con','Date_Checkers',
                            'Check_Bookcar','DateCheck_Bookcar','Special_Bookcar','DateSpecial_Bookcar','BookSpecial_Trans','Date_BookSpecial','Email_Con','Msteams_Id','LinkUpload_Con',
                            'DateDue_Con','Approve_monetary','Date_monetary','Commission_Trans','Date_Commission','FlagSpecial_Trans','Date_FlagSpecial','Bank_Close','Bank_Out',
                            'Memo_Objective','Memo_Con','Cus_Ref','PhoneCus_Ref',
                            'Data_Reg','Data_UnReg','Data_Purpose','Data_TypeLoan','Data_Factors',
                            'UserZone','UserBranch','UserInsert'];


    public function ConToCal()
    {
        return $this->hasOne(tbl_calculate::class,'DataTag_id','DataTag_id');
    }
    public function ContractToDataCusTags()
    {
        return $this->belongsTo(tbl_custagcal::class,'DataTag_id','id');
    }
    public function ConToLoan()
    {
        return $this->hasOne(tbl_typeLoan::class,'CodeLoan_Con','Loan_Code');
    }
    public function ConToEmp()
    {
        return $this->belongsTo(tbl_traceEmployee::class,'IdCK','BranchSent_Con');
    }

}
