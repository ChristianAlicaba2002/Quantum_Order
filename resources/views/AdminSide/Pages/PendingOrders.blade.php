<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .orders-table th {
            background-color: #ff9100;
            color: white;
            padding: 12px;
            text-align: left;
            text-align: center;
        }

        .orders-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .new-order-row {
            background-color: #fff3e6;
            position: relative;
        }

        .new-order-badge {
            background-color: #ff9100;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-info {
            background-color: #ff9100;
            color: white;
        }

        .btn-info:hover {
            background-color: #e68300;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .notification-dot {
            width: 8px;
            height: 8px;
            background-color: #ff9100;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }

            100% {
                opacity: 1;
            }
        }

        .time-ago {
            font-size: 12px;
            color: #666;
            margin-left: 5px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            position: relative;
        }

        .status-accepted {
            background-color: #d4edda;
            color: #28a745;
            border: 1px solid #c3e6cb;
        }

        .status-declined {
            background-color: #f8d7da;
            color: #dc3545;
            border: 1px solid #f5c6cb;
        }

        .status-visited {
            background-color: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
        }

        .status-new {
            background-color: #fff3e6;
            color: #ff9100;
            border: 1px solid #ffcc80;
            animation: glow 2s infinite;
        }

        .status-time {
            font-size: 11px;
            opacity: 0.8;
            margin-left: 5px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background-color: #ff9100;
            border-radius: 50%;
            position: absolute;
            top: -3px;
            right: -3px;
            animation: pulse 1.5s infinite;
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 5px rgba(255, 145, 0, 0.2);
            }

            50% {
                box-shadow: 0 0 10px rgba(255, 145, 0, 0.4);
            }

            100% {
                box-shadow: 0 0 5px rgba(255, 145, 0, 0.2);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 14px;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .status-indicator.accepted {
            background-color: #d4edda;
            color: #28a745;
            border: 1px solid #c3e6cb;
        }

        .status-indicator.declined {
            background-color: #f8d7da;
            color: #dc3545;
            border: 1px solid #f5c6cb;
        }

        .status-indicator.pending {
            background-color: #fff3e6;
            color: #ff9100;
            border: 1px solid #ffcc80;
        }

        .status-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }

        .status-text {
            font-weight: bold;
        }

        .status-detail {
            font-size: 12px;
            opacity: 0.8;
        }

        .timestamp {
            font-size: 11px;
            opacity: 0.7;
            margin-left: 5px;
            white-space: nowrap;
        }

        @keyframes statusUpdate {
            0% {
                transform: scale(0.95);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .status-indicator.new-update {
            animation: statusUpdate 0.5s ease-out;
        }

        .status-indicator:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .accepted .status-icon {
            color: #28a745;
        }

        .declined .status-icon {
            color: #dc3545;
        }

        .pending .status-icon {
            animation: pulse 1.5s infinite;
        }
    </style>
</head>

<body>
    <a href="{{ route('AdminLogin') }}">Back to Dashboard</a>

    <div class="pending-orders">
        <h2>Pending Orders</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="orders-table">
            <table>
                <thead>
                    <tr></tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>More</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getOrders = DB::table('orders')->orderBy('created_at', 'desc')->get();
                    $currentTime = now();
                    ?>

                    @if ($getOrders->count() > 0)
                        @foreach ($getOrders as $order)
                            <?php
                            $orderTime = \Carbon\Carbon::parse($order->created_at);
                            $isNew = $orderTime->diffInHours($currentTime) < 24;
                            $timeAgo = $orderTime->diffForHumans();
                            $orderStatus = DB::table('orders')->where('orderId', $order->orderId)->value('orderStatus');
                            ?>
                            <tr class="{{ $isNew ? 'new-order-row' : '' }}">
                                <td>
                                    @if ($isNew)
                                        <span class="notification-dot"></span>
                                    @endif
                                    {{ $order->orderId }}
                                    @if ($isNew)
                                        <span class="new-order-badge">NEW</span>
                                    @endif
                                </td>
                                <td>{{ $order->firstName }}</td>
                                <td>₱{{ number_format($order->totalAmount, 2) }}</td>
                                <td>
                                    {{ date('M d, Y H:i', strtotime($order->updated_at)) }}
                                    <span class="time-ago">({{ $timeAgo }})</span>
                                </td>
                                <td>
                                    @if ($orderStatus === 'Accepted' || $orderStatus === 'Declined')
                                        <div class="status-indicator {{ strtolower($orderStatus) }}">
                                            <span class="status-icon">
                                                @if ($orderStatus === 'Accepted')
                                                    <i class="fas fa-check-circle"></i>
                                                @else
                                                    <i class="fas fa-times-circle"></i>
                                                @endif
                                            </span>
                                            <span class="status-text">Done</span>
                                            <span class="status-detail">({{ $orderStatus }})</span>
                                            <span
                                                class="timestamp">{{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}</span>
                                        </div>
                                    @else
                                        <div class="status-indicator pending">
                                            <span class="status-icon">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                            <span class="status-text">Pending</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="/order/{{ $order->orderId }}" class="btn btn-info">
                                        View Details
                                        @if ($isNew)
                                            <span class="notification-dot"></span>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">No pending orders found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Initialize Pusher
        const pusher = new Pusher('your-pusher-key', {
            cluster: 'ap1'
        });

        const channel = pusher.subscribe('orders');
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
        const pusher = new Pusher('your-pusher-key', {
            cluster: 'ap1'
        });

        const channel = pusher.subscribe('orders');
        channel.bind('order-status-updated', function(data) {
            updateOrderStatus(data.orderId, data.status);
        });
    </script>
</body>

</html>
