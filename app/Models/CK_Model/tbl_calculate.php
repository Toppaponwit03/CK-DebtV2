<?php

namespace App\Models\CK_Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_calculate extends Model
{
    use HasFactory;

    protected $connection = 'ck';
    protected $table = 'Data_CusTagCalculates';
    protected $fillable = ['DataCus_id','DataTag_id',
                            'Date_Calcu','CodeLoans','TypeLoans','RateCartypes','RateBrands','RateGroups','RateModals','RateYears','RateGears','RatePrices',
                            'Promotions','Cash_Car','Process_Car','Percent_Car','Timelack_Car','Interest_Car','Interestmore_Car','Flag_Interest','totalInterest_Car','InterestYear_Car',
                            'Vat_Rate','Period_Rate','Tax_Rate','Tax2_Rate','Duerate_Rate','Duerate2_Rate','Profit_Rate','TotalPeriod_Rate','TypeAssetsPoss',
                            'DateOccupiedcar','NumDateOccupiedcar','RatePrice_Car','Cus_grade','Payment_Status','TotalLand_Rate','Insurance','Insurance_PA','Plan_PA',
                            'Rate_ownership1','Rate_ownership2','Rate_ownership3','Rate_ownership4','Rate_ownership5','Rate_trade1','Rate_trade2','Rate_trade3','Commission','Note_Cal','Note_Credo'
                            ,'Prices_balance','Result_rate','UserZone','UserBranch','UserInsert'];
    

}
