<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'driver_id', 
        'trip_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
        'org_code'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\V1\User::class);
    }

    /**
     * Get the driver that owns the notification.
     */
    public function driver()
    {
        return $this->belongsTo(\App\Models\V2\Driver::class);
    }

    /**
     * Get the trip associated with the notification.
     */
    public function trip()
    {
        return $this->belongsTo(\App\Models\V2\Trip::class);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Determine if the notification has been read.
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope for notifications by user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for notifications by driver.
     */
    public function scopeForDriver($query, $driverId)
    {
        return $query->where('driver_id', $driverId);
    }
} 