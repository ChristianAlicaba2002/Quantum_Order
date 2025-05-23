<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/pendingOrders.css') }}">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    
</head>

<body>
    <div class="back-button-container">
        <a class="back-button" href="{{ route('AdminLogin') }}">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>

    <div class="pending-orders">
        <h2>Pending Orders</h2>

        <p class="system-message">
            Welcome to the Quantum Order management system. Here you can view and process all pending customer orders in real-time. Orders marked with <span class="new-order-badge">NEW</span> require your immediate attention. Please process orders promptly to ensure customer satisfaction and timely delivery. Your quick response helps maintain our service quality standards.
        </p>

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
                            <tr class="{{ $isNew ? 'new-order-row' : '' }} status-{{ strtolower($orderStatus) }}">
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
                                <td class="status-cell {{ strtolower($orderStatus) }}">
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
    <script src="{{asset('js/pendingorders.js')}}"></script>
</body>

</html>
