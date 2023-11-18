<?php

namespace App\Listeners;

use App\Events\DataLogStatus;
use App\Models\tbl_DataLogStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenDataLogStatus implements ShouldQueue
{

    public function __construct()
    {
        //
    }


    public function handle(DataLogStatus $event)
    {
        tbl_DataLogStatus::create([
            'TagID' => @$event->UserInsert 
            ,'UserInsert' => @$event->UserInsert 
            ,'UserInsertTxt' => @$event->UserInsertTxt 
            ,'Details' => @$event->Details 
            ,'StatusDate' => @$event->StatusDate 
            ,'StatusCode' => @$event->StatusCode 
        ]);
    }
}
