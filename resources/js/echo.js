import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Configure Laravel Echo with Redis Broadcasting
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || 'local-key',
    cluster: process.env.MIX_PUSHER_APP_CLUSTER || 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss']
}); 