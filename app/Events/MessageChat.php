<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $UserInsert;
    public string $tag_id;
    public string $created_At;



    public function __construct(string $message,string $UserInsert,string $tag_id,string $created_At)
    {
        $this->message = $message;
        $this->UserInsert = $UserInsert;
        $this->tag_id = $tag_id;
        $this->created_At = $created_At;

    }


    public function broadcastOn() : array
    {
        return ['public'];
    }

    public function broadcastAs() : string
    {
        return 'chat';
    }
}
