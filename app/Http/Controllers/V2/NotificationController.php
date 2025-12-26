<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get notifications for current user
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit', 10);

        if ($user->user_type === 'driver') {
            // Get driver notifications from Redis
            $driverInfo = $this->notificationService->getDriverByUserId($user->id);
            if ($driverInfo) {
                $notifications = $this->notificationService->getDriverNotifications($driverInfo['driver_id'], $limit);
                $unreadCount = $this->notificationService->getUnreadCount($driverInfo['driver_id']);
            } else {
                $notifications = [];
                $unreadCount = 0;
            }
        } else {
            // Admin/operator notifications
            $notifications = $this->notificationService->getUserNotifications($user->id, $limit);
            $unreadCount = count(array_filter($notifications, function($n) {
                return is_null($n['read_at']);
            }));
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'notifications' => $notifications,
                'unread_count' => $unreadCount
            ]
        ]);
    }

    /**
     * Get unread count for current user
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $unreadCount = 0;

        if ($user->user_type === 'driver') {
            $driverInfo = $this->notificationService->getDriverByUserId($user->id);
            if ($driverInfo) {
                $unreadCount = $this->notificationService->getUnreadCount($driverInfo['driver_id']);
            }
        } else {
            $notifications = $this->notificationService->getUserNotifications($user->id);
            $unreadCount = count(array_filter($notifications, function($n) {
                return is_null($n['read_at']);
            }));
        }

        return response()->json([
            'status' => 'success',
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $notificationId = $request->notification_id;

        if ($user->user_type === 'driver') {
            $driverInfo = $this->notificationService->getDriverByUserId($user->id);
            if ($driverInfo) {
                $this->notificationService->markAsRead($notificationId, $driverInfo['driver_id']);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => __('message.notification_marked_read')
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $user = Auth::user();

        if ($user->user_type === 'driver') {
            $driverInfo = $this->notificationService->getDriverByUserId($user->id);
            if ($driverInfo) {
                $this->notificationService->markAllAsRead($driverInfo['driver_id']);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => __('message.all_notifications_marked_read')
        ]);
    }

    /**
     * Server-Sent Events stream for real-time notifications
     */
    public function stream()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'driver') {
            return response()->json(['error' => __('message.only_drivers_access_stream')], 403);
        }

        $driverInfo = $this->notificationService->getDriverByUserId($user->id);
        if (!$driverInfo) {
            return response()->json(['error' => __('message.driver_not_found')], 404);
        }

        $driverId = $driverInfo['driver_id'];

        return new StreamedResponse(function() use ($driverId) {
            // Set headers for SSE
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');
            header('X-Accel-Buffering: no'); // Nginx specific

            // Send initial connection confirmation
            echo "data: " . json_encode(['type' => 'connected', 'message' => 'Real-time notifications connected']) . "\n\n";
            
            if (ob_get_level()) {
                ob_end_flush();
            }
            flush();

            $lastNotificationTime = time();
            
            while (true) {
                // Check for new notifications in Redis
                $newNotifications = $this->checkForNewNotifications($driverId, $lastNotificationTime);
                
                if (!empty($newNotifications)) {
                    foreach ($newNotifications as $notification) {
                        echo "data: " . json_encode([
                            'type' => 'new_notification',
                            'notification' => $notification
                        ]) . "\n\n";
                        
                        if (ob_get_level()) {
                            ob_end_flush();
                        }
                        flush();
                    }
                    $lastNotificationTime = time();
                }

                // Send heartbeat every 30 seconds
                if (time() % 30 === 0) {
                    echo "data: " . json_encode(['type' => 'heartbeat', 'timestamp' => time()]) . "\n\n";
                    if (ob_get_level()) {
                        ob_end_flush();
                    }
                    flush();
                }

                // Check if client disconnected
                if (connection_aborted()) {
                    break;
                }

                sleep(1); // Check every second
            }
        });
    }

    /**
     * Check for new notifications since last check
     */
    private function checkForNewNotifications($driverId, $lastCheckTime)
    {
        $key = "notifications:driver:{$driverId}";
        $notifications = Redis::lrange($key, 0, 4); // Get last 5 notifications
        
        $newNotifications = [];
        foreach ($notifications as $notificationJson) {
            $notification = json_decode($notificationJson, true);
            if ($notification && strtotime($notification['created_at']) > $lastCheckTime) {
                $newNotifications[] = $notification;
            }
        }

        return $newNotifications;
    }
} 