let pusher = new Pusher('your-pusher-key', {
    cluster: 'ap1'
});

let channel = pusher.subscribe('orders');
channel.bind('new-order', function(data) {
    // Play notification sound
    const audio = new Audio('/path/to/notification-sound.mp3');
    audio.play();

    // Refresh the page to show new order
    location.reload();
});

// Function to format time ago
function updateTimeAgo() {
    const timeElements = document.querySelectorAll('.time-ago');
    timeElements.forEach(element => {
        const timestamp = element.getAttribute('data-time');
        const timeAgo = moment(timestamp).fromNow();
        element.textContent = `(${timeAgo})`;
    });
}

// Update time ago every minute
setInterval(updateTimeAgo, 60000);

// Function to update status indicators in real-time
function updateOrderStatus(orderId, status) {
    const statusCell = document.querySelector(`[data-order-id="${orderId}"]`);
    if (statusCell) {
        const statusIndicator = document.createElement('div');
        statusIndicator.className = `status-indicator ${status.toLowerCase()} new-update`;

        const icon = status === 'Accepted' ? 'check-circle' : 'times-circle';
        const color = status === 'Accepted' ? '#28a745' : '#dc3545';

        statusIndicator.innerHTML = `
            <span class="status-icon">
                <i class="fas fa-${icon}"></i>
            </span>
            <span class="status-text">Done</span>
            <span class="status-detail">(${status})</span>
            <span class="timestamp">Just now</span>
        `;

        statusCell.innerHTML = '';
        statusCell.appendChild(statusIndicator);

        // Optional: Play a sound notification
        const audio = new Audio('/path/to/notification-sound.mp3');
        audio.play();
    }
}

// Update timestamps periodically
setInterval(() => {
    document.querySelectorAll('.timestamp').forEach(timestamp => {
        const time = timestamp.getAttribute('data-time');
        if (time) {
            timestamp.textContent = moment(time).fromNow();
        }
    });
}, 60000);

// Listen for status updates if using Pusher
 pusher = new Pusher('your-pusher-key', {
    cluster: 'ap1'
});

 channel = pusher.subscribe('orders');
channel.bind('order-status-updated', function(data) {
    updateOrderStatus(data.orderId, data.status);
});
