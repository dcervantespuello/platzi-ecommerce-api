<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class ModelRated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Model */
    private Model $qualifier;
    /** @var Model */
    private Model $rateable;
    private float $score;

    /**
     * Create a new event instance.
     */
    public function __construct(Model $qualifier, Model $rateable, float $score)
    {
        $this->qualifier = $qualifier;
        $this->rateable = $rateable;
        $this->score = $score;
    }

    public function getQualifier()
    {
        return $this->qualifier;
    }

    public function getRateable()
    {
        return $this->rateable;
    }

    public function getScore()
    {
        return $this->score;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
