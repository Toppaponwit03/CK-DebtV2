<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataLogStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $TagID 
    ,$UserInsert
    ,$UserInsertTxt
    ,$Details
    ,$StatusDate
    ,$StatusCode;

    public function __construct($TagID,$UserInsert,$UserInsertTxt,$Details,$StatusDate,$StatusCode)
    {
        $this->TagID = $TagID;
        $this->UserInsert = $UserInsert; 
        $this->UserInsertTxt = $UserInsertTxt; 
        $this->Details = $Details; 
        $this->StatusDate = $StatusDate; 
        $this->StatusCode = $StatusCode; 
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
