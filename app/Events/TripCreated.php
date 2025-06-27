<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\V2\Trip;

class TripCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trip;
    public $message;
    public $driverId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->driverId = $trip->driver_id;
        $this->message = "New trip assigned to you from {$trip->route_name}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driver.' . $this->driverId);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'trip_id' => $this->trip->id,
            'message' => $this->message,
            'route_name' => $this->trip->route_name,
            'vehicle_registration' => $this->trip->vehicle_registration_number,
            'trip_date' => $this->trip->trip_initiate_date,
            'created_at' => now()->toDateTimeString(),
            'type' => 'trip_assigned'
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'trip.created';
    }
} 