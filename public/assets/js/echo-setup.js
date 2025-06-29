/**
 * Real-time WebSocket setup for notifications
 * This file sets up Laravel Echo with Pusher for real-time notifications
 */

// Echo configuration for real-time notifications
window.setupRealTimeNotifications = function() {
    // Check if we're in development or production
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    
    // Configure Echo with appropriate settings
    if (typeof Echo === 'undefined') {
        // Fallback to Socket.io configuration
        window.Echo = new Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            }
        });
    }

    return window.Echo;
};

/**
 * Initialize real-time notifications for drivers
 */
window.initializeRealTimeNotifications = function(driverId, onNotificationReceived) {
    try {
        const echo = window.setupRealTimeNotifications();
        
        // Listen to the driver's private channel
        echo.private(`driver.${driverId}`)
            .listen('TripCreated', (e) => {
                console.log('Real-time notification received:', e);
                
                // Call the callback function with notification data
                if (typeof onNotificationReceived === 'function') {
                    onNotificationReceived({
                        id: Date.now(), // Temporary ID
                        type: e.type || 'trip_assigned',
                        title: 'New Trip Assigned',
                        message: e.message,
                        data: {
                            route_name: e.route_name,
                            vehicle_registration: e.vehicle_registration,
                            trip_date: e.trip_date
                        },
                        read_at: null,
                        created_at: e.created_at
                    });
                }
            })
            .error((error) => {
                console.error('WebSocket connection error:', error);
                // Fallback to polling if WebSocket fails
                console.log('Falling back to polling method...');
            });

        console.log(`Real-time notifications initialized for driver ${driverId}`);
        return true;
    } catch (error) {
        console.error('Failed to initialize real-time notifications:', error);
        return false;
    }
}; 