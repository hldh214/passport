<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Follow implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var array
     */
    public $causer;
    /**
     * @var array
     */
    public $target;
    /**
     * @var string
     */
    public $type;

    /**
     * Create a new event instance.
     *
     * @param  array  $causer
     * @param  array  $target
     * @param  string  $type
     */
    public function __construct(array $causer, array $target, string $type)
    {
        $this->causer = $causer;
        $this->target = $target;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('follow.' . $this->target['id']);
    }
}
