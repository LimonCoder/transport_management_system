<?php

namespace App\Services;

use App\Models\V2\Driver;
use App\Models\V2\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class NotificationService
{
    /**
     * Create a notification for trip assignment
     *
     * @param array $data
     * @return Notification
     */
    public function createTripNotification(array $data)
    {
        // Get the appropriate locale for the driver (default to Bangla for drivers)
        $notificationLocale = $this->getDriverLocale($data['driver_id']);
        
        // Set locale for notification translation
        $currentLocale = app()->getLocale();
        app()->setLocale($notificationLocale);
        
        $notification = Notification::create([
            'driver_id' => $data['driver_id'],
            'user_id' => $data['user_id'] ?? null,
            'trip_id' => $data['trip_id'],
            'type' => 'trip_assigned',
            'title' => __('message.new_trip_assigned'),
            'message' => __('message.trip_assigned_message', ['route_name' => $data['route_name'] ?? '']),
            'data' => [
                'route_name' => $data['route_name'] ?? '',
                'vehicle_registration' => $data['vehicle_registration'] ?? '',
                'trip_date' => $data['trip_date'] ?? '',
            ],
            'org_code' => $data['org_code']
        ]);
        
        // Restore original locale
        app()->setLocale($currentLocale);

        // Store notification in Redis for real-time access
        $this->storeInRedis($notification);

        // Trigger real-time notification via Redis pub/sub
        $this->triggerRealTimeNotification($notification);

        return $notification;
    }

    /**
     * Store notification in Redis
     *
     * @param Notification $notification
     */
    private function storeInRedis(Notification $notification)
    {
        $key = "notifications:driver:{$notification->driver_id}";
        
        $notificationData = [
            'id' => $notification->id,
            'type' => $notification->type,
            'title' => $notification->title,
            'message' => $notification->message,
            'data' => $notification->data,
            'created_at' => $notification->created_at->toDateTimeString(),
            'read_at' => $notification->read_at
        ];

        // Add to Redis list (keep last 50 notifications per driver)
        Redis::lpush($key, json_encode($notificationData));
        Redis::ltrim($key, 0, 49);
        
        // Set expiration for the key (30 days)
        Redis::expire($key, 30 * 24 * 60 * 60);

        // Store unread count
        $unreadKey = "notifications:unread:driver:{$notification->driver_id}";
        Redis::incr($unreadKey);
        Redis::expire($unreadKey, 30 * 24 * 60 * 60);
    }

    /**
     * Trigger real-time notification via Redis pub/sub
     *
     * @param Notification $notification
     */
    private function triggerRealTimeNotification(Notification $notification)
    {
        $channel = "driver_notifications:{$notification->driver_id}";
        
        $data = [
            'type' => 'new_notification',
            'notification' => [
                'id' => $notification->id,
                'type' => $notification->type,
                'title' => $notification->title,
                'message' => $notification->message,
                'data' => $notification->data,
                'created_at' => $notification->created_at->toDateTimeString(),
                'read_at' => $notification->read_at
            ]
        ];

        // Publish to Redis channel for real-time updates
        Redis::publish($channel, json_encode($data));
    }

    /**
     * Get notifications for a driver from Redis
     *
     * @param int $driverId
     * @param int $limit
     * @return array
     */
    public function getDriverNotifications($driverId, $limit = 10)
    {
        $key = "notifications:driver:{$driverId}";
        $notifications = Redis::lrange($key, 0, $limit - 1);
        
        return array_map(function($notification) {
            return json_decode($notification, true);
        }, $notifications);
    }

    /**
     * Get unread count for a driver
     *
     * @param int $driverId
     * @return int
     */
    public function getUnreadCount($driverId)
    {
        $key = "notifications:unread:driver:{$driverId}";
        return (int) Redis::get($key) ?: 0;
    }

    /**
     * Mark notification as read
     *
     * @param int $notificationId
     * @param int $driverId
     */
    public function markAsRead($notificationId, $driverId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->driver_id == $driverId) {
            $notification->markAsRead();
            
            // Decrease unread count in Redis
            $unreadKey = "notifications:unread:driver:{$driverId}";
            if (Redis::get($unreadKey) > 0) {
                Redis::decr($unreadKey);
            }
        }
    }

    /**
     * Mark all notifications as read for a driver
     *
     * @param int $driverId
     */
    public function markAllAsRead($driverId)
    {
        Notification::where('driver_id', $driverId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        // Reset unread count in Redis
        $unreadKey = "notifications:unread:driver:{$driverId}";
        Redis::del($unreadKey);
    }

    /**
     * Get notifications for a specific user (admin/operator)
     *
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getUserNotifications($userId, $limit = 10)
    {
        return Notification::where('user_id', $userId)
            ->orWhere('org_code', Auth::user()->org_code)
            ->latest()
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Check if driver exists and get user_id
     *
     * @param int $driverId
     * @return array|null
     */
    public function getDriverInfo($driverId)
    {
        $driver = Driver::with('user')->find($driverId);
        if (!$driver) {
            return null;
        }

        return [
            'driver_id' => $driver->id,
            'user_id' => $driver->user_id,
            'name' => $driver->name
        ];
    }

    /**
     * Get driver by user_id
     *
     * @param int $userId
     * @return array|null
     */
    public function getDriverByUserId($userId)
    {
        $driver = Driver::where('user_id', $userId)->first();
        if (!$driver) {
            return null;
        }

        return [
            'driver_id' => $driver->id,
            'user_id' => $driver->user_id,
            'name' => $driver->name
        ];
    }

    /**
     * Get the appropriate locale for a driver
     * For now, default to Bangla for all drivers
     * In future, this can be enhanced to check driver preferences
     *
     * @param int $driverId
     * @return string
     */
    private function getDriverLocale($driverId)
    {
        // For now, return Bangla for all drivers
        // In future, you can check driver's language preference from database
        return 'bn';
    }

    /**
     * Create a localized notification message
     *
     * @param string $type
     * @param array $data
     * @param string $locale
     * @return array
     */
    private function getLocalizedNotificationContent($type, $data, $locale = 'bn')
    {
        $currentLocale = app()->getLocale();
        app()->setLocale($locale);

        $content = [];

        switch ($type) {
            case 'trip_assigned':
                $content = [
                    'title' => __('message.new_trip_assigned'),
                    'message' => __('message.trip_assigned_message', ['route_name' => $data['route_name'] ?? ''])
                ];
                break;
            
            case 'trip_completed':
                $content = [
                    'title' => __('message.trip_completed'),
                    'message' => __('message.trip_completed_message', ['route_name' => $data['route_name'] ?? ''])
                ];
                break;
            
            case 'trip_cancelled':
                $content = [
                    'title' => __('message.trip_cancelled'),
                    'message' => __('message.trip_cancelled_message', ['route_name' => $data['route_name'] ?? ''])
                ];
                break;
            
            // Add more notification types here as needed
            default:
                $content = [
                    'title' => __('message.notification'),
                    'message' => $data['message'] ?? ''
                ];
        }

        app()->setLocale($currentLocale);
        return $content;
    }

    /**
     * Create a general notification with localization
     *
     * @param array $data
     * @return Notification
     */
    public function createNotification(array $data)
    {
        // Get the appropriate locale for the driver
        $notificationLocale = $this->getDriverLocale($data['driver_id']);
        
        // Get localized content
        $content = $this->getLocalizedNotificationContent(
            $data['type'],
            $data,
            $notificationLocale
        );

        $notification = Notification::create([
            'driver_id' => $data['driver_id'],
            'user_id' => $data['user_id'] ?? null,
            'trip_id' => $data['trip_id'] ?? null,
            'type' => $data['type'],
            'title' => $content['title'],
            'message' => $content['message'],
            'data' => $data['data'] ?? [],
            'org_code' => $data['org_code']
        ]);

        // Store notification in Redis for real-time access
        $this->storeInRedis($notification);

        // Trigger real-time notification via Redis pub/sub
        $this->triggerRealTimeNotification($notification);

        return $notification;
    }
} 