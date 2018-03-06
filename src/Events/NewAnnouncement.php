<?php
declare(strict_types = 1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class NewAnnouncement
 *
 * @package App\Events
 */
class NewAnnouncement implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * @var string
     */
    protected $channel_name;

    /**
     * Create a new event instance.
     */
    public function __construct(string $title, string $message, string $type, int $ttl, string $transition, string $channel_name)
    {
        $this->data = [
            'title'      => $title,
            'message'    => $message,
            'type'       => $type,
            'transition' => $transition,
            'ttl'        => $ttl,
        ];

        $this->channel_name = $channel_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->channel_name);
    }
}
