/**
 * Notification System with Redis and Real-time Updates
 */

class NotificationManager {
    constructor() {
        this.apiUrl = window.location.origin;
        this.notifications = [];
        this.unreadCount = 0;
        this.pollingInterval = null;
        this.eventSource = null;
        this.isRealTimeConnected = false;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadNotifications();
        this.initializeRealTime();
    }

    setupEventListeners() {
        // Clear all notifications
        $(document).on('click', '#clear-all-notifications', (e) => {
            e.preventDefault();
            this.markAllAsRead();
        });

        // Mark individual notification as read when clicked
        $(document).on('click', '.notification-item', (e) => {
            const notificationId = $(e.currentTarget).data('notification-id');
            if (notificationId) {
                this.markAsRead(notificationId);
            }
        });

        // Refresh notifications when dropdown is opened
        $(document).on('click', '#notification-bell', () => {
            this.loadNotifications();
        });
    }

    async loadNotifications() {
        try {
            const response = await fetch(`${this.apiUrl}/notifications`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.notifications = data.data.notifications;
                this.unreadCount = data.data.unread_count;
                this.updateUI();
            }
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    updateUI() {
        this.updateBadge();
        this.renderNotifications();
    }

    updateBadge() {
        const badge = $('#notification-badge');
        if (this.unreadCount > 0) {
            badge.text(this.unreadCount).show();
            badge.addClass('pulse');
        } else {
            badge.hide().removeClass('pulse');
        }
    }

    renderNotifications() {
        const container = $('#notifications-container');
        const noNotifications = $('#no-notifications');

        if (this.notifications.length === 0) {
            noNotifications.show();
            return;
        }

        noNotifications.hide();
        let html = '';

        this.notifications.forEach(notification => {
            const isRead = notification.read_at !== null;
            const timeAgo = this.timeAgo(new Date(notification.created_at));
            
            html += `
                <div class="notification-item notify-item ${isRead ? '' : 'unread'}" data-notification-id="${notification.id}">
                    <div class="notify-icon bg-primary">
                        <i class="fe-truck"></i>
                    </div>
                    <div class="notify-details">
                        <strong>${notification.title}</strong>
                        <p class="mb-1">${notification.message}</p>
                        ${notification.data && notification.data.route_name ? 
                            `<small class="text-muted">Route: ${notification.data.route_name}</small><br>` : ''}
                        ${notification.data && notification.data.vehicle_registration ? 
                            `<small class="text-muted">Vehicle: ${notification.data.vehicle_registration}</small><br>` : ''}
                        <small class="text-muted">${timeAgo}</small>
                    </div>
                    ${!isRead ? '<div class="unread-indicator"><i class="fe-circle text-primary"></i></div>' : ''}
                </div>
            `;
        });

        container.html(html);
    }

    async markAsRead(notificationId) {
        try {
            const response = await fetch(`${this.apiUrl}/notifications/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({ notification_id: notificationId })
            });

            if (response.ok) {
                this.loadNotifications(); // Refresh notifications
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    async markAllAsRead() {
        try {
            const response = await fetch(`${this.apiUrl}/notifications/mark-all-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (response.ok) {
                this.loadNotifications(); // Refresh notifications
                this.showToast('All notifications marked as read', 'success');
            }
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }

    /**
     * Initialize real-time notifications using Server-Sent Events
     */
    initializeRealTime() {
        try {
            // Close existing connection if any
            if (this.eventSource) {
                this.eventSource.close();
            }

            // Create new SSE connection
            this.eventSource = new EventSource(`${this.apiUrl}/notifications/stream`);

            this.eventSource.onopen = () => {
                console.log('Real-time notification connection opened');
                this.isRealTimeConnected = true;
                this.clearPolling(); // Stop polling since we have real-time connection
            };

            this.eventSource.onmessage = (event) => {
                try {
                    const data = JSON.parse(event.data);
                    this.handleRealTimeMessage(data);
                } catch (error) {
                    console.error('Error parsing SSE message:', error);
                }
            };

            this.eventSource.onerror = (error) => {
                console.error('SSE connection error:', error);
                this.isRealTimeConnected = false;
                
                // Fallback to polling if SSE fails
                this.startPolling();
            };

        } catch (error) {
            console.error('Failed to initialize real-time notifications:', error);
            // Fallback to polling
            this.startPolling();
        }
    }

    /**
     * Handle real-time messages from SSE
     */
    handleRealTimeMessage(data) {
        switch (data.type) {
            case 'connected':
                console.log('Real-time notifications connected');
                break;
                
            case 'new_notification':
                console.log('New notification received:', data.notification);
                this.handleNewNotification(data.notification);
                break;
                
            case 'heartbeat':
                // Connection is alive
                break;
                
            default:
                console.log('Unknown message type:', data.type);
        }
    }

    /**
     * Handle new notification received in real-time
     */
    handleNewNotification(notification) {
        // Add to notifications array
        this.notifications.unshift(notification);
        
        // Keep only last 10 notifications in memory
        if (this.notifications.length > 10) {
            this.notifications = this.notifications.slice(0, 10);
        }

        // Update unread count
        this.unreadCount++;

        // Update UI
        this.updateUI();

        // Show toast notification
        this.showNotificationToast(notification);

        // Add visual indicator for new notification
        this.highlightNotificationBell();
    }

    /**
     * Add visual highlight to notification bell
     */
    highlightNotificationBell() {
        const bell = $('#notification-bell');
        bell.addClass('notification-new');
        
        // Remove highlight after 3 seconds
        setTimeout(() => {
            bell.removeClass('notification-new');
        }, 3000);
    }

    /**
     * Fallback polling method
     */
    startPolling() {
        if (this.isRealTimeConnected) {
            return; // Don't start polling if real-time is working
        }

        // Clear any existing polling
        this.clearPolling();

        // Poll for new notifications every 10 seconds (faster than before)
        this.pollingInterval = setInterval(() => {
            this.checkForNewNotifications();
        }, 10000);
    }

    /**
     * Clear polling interval
     */
    clearPolling() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
            this.pollingInterval = null;
        }
    }

    async checkForNewNotifications() {
        try {
            const response = await fetch(`${this.apiUrl}/notifications/unread-count`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                if (data.unread_count > this.unreadCount) {
                    // New notification received
                    this.loadNotifications();
                    this.showNotificationToast();
                }
            }
        } catch (error) {
            console.error('Error checking for new notifications:', error);
        }
    }

    showNotificationToast(notification = null) {
        if (typeof toastr !== 'undefined') {
            const title = notification ? notification.title : 'New Notification';
            const message = notification ? notification.message : 'You have new notifications!';
            
            toastr.info(message, title, {
                timeOut: 8000,
                positionClass: 'toast-top-right',
                closeButton: true,
                progressBar: true
            });
        } else {
            // Fallback browser notification
            this.showBrowserNotification(notification);
        }
    }

    /**
     * Show browser notification as fallback
     */
    showBrowserNotification(notification) {
        if ('Notification' in window && Notification.permission === 'granted') {
            const title = notification ? notification.title : 'New Notification';
            const message = notification ? notification.message : 'You have new notifications!';
            
            new Notification(title, {
                body: message,
                icon: '/assets/images/logo.png',
                tag: 'trip-notification'
            });
        } else if ('Notification' in window && Notification.permission !== 'denied') {
            // Request permission
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    this.showBrowserNotification(notification);
                }
            });
        }
    }

    showToast(message, type = 'info') {
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        }
    }

    timeAgo(date) {
        const now = new Date();
        const diff = now - date;
        const seconds = Math.floor(diff / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        if (days > 0) return `${days}d ago`;
        if (hours > 0) return `${hours}h ago`;
        if (minutes > 0) return `${minutes}m ago`;
        return 'Just now';
    }

    destroy() {
        // Close SSE connection
        if (this.eventSource) {
            this.eventSource.close();
            this.eventSource = null;
        }

        // Clear polling
        this.clearPolling();
        
        this.isRealTimeConnected = false;
    }
}

// Initialize notification manager when document is ready
$(document).ready(function() {
    // Only initialize if user is a driver and element exists
    if ($('#notification-bell').length > 0) {
        window.notificationManager = new NotificationManager();
    }
});

// Cleanup on page unload
$(window).on('beforeunload', function() {
    if (window.notificationManager) {
        window.notificationManager.destroy();
    }
}); 