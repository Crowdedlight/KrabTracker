<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Signature;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use phpDocumentor\Reflection\Types\Boolean;

class SignaturesUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $update = false;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($update)
    {
        if ($update)
        {
            $this->update = true;
        }
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['sigAction'];
    }
}
