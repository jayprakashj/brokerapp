<?php

namespace App\Events;

use App\Http\Resources\Api\Dashboard\LeadListResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLeadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lead;

    /**
     * Create a new event instance.
     */
    public function __construct( $lead )
    {
        //
        $this->lead = $lead;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(config('app.broadcast-channel-name')),
        ];
    }

    public function broadcastAs (){
        return 'new-lead-generated';
    }

    public function broadcastWith (){
        return [
            'lead' => new LeadListResource( $this->lead )
        ];
    }
}
