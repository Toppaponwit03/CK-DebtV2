<?php

namespace App\Models\CK_Model;

use App\Models\CK_Model\tbl_calculate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_custagcal extends Model
{
    use HasFactory;

    protected $connection = 'ck';
    protected $table = 'Data_CusTags';
    protected $fillable = ['DataCus_id',
                            'date_Tag','Code_Tag','Status_Tag','Ordinal_Tag',
                            'Type_Customer','Resource_Customer','Credo_Code','Credo_Score','Credo_Status',
                            'Note_Tag','UserZone','UserBranch','UserInsert'];

    public function DataCusTagToDataCulcu()
    {
        return $this->hasOne(tbl_calculate::class,'DataTag_id','id');
    }
}
