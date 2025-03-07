<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>{{ Auth::user()->firstName }} Delivery History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        /* Base font size adjustments */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
            /* Reduced base font size */
        }

        .back-link {
            color: orange;
            text-decoration: none;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        h1 {
            color: #333;
            /* Smaller heading */
            margin-bottom: 15px;
        }

        h2 {
            font-size: 20px;
            /* Smaller modal heading */
            margin-bottom: 12px;
        }

        h3 {
            font-size: 14px;
            /* Smaller sub-heading */
            margin-bottom: 10px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .orders-table th,
        .orders-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        .orders-table th {
            background-color: #ff9100;
            color: white;
            font-size: 12px;
            /* Slightly larger than td but still small */
        }

        .orders-table tr:hover {
            background-color: #f9f9f9;
        }

        .status-accepted {
            color: #28a745;
            font-weight: bold;
            font-size: 11px;
        }

        .no-orders {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .tracking-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .tracking-content {
            background: white;
            width: 90%;
            max-width: 600px;
            /* Slightly smaller modal */
            margin: 20px auto;
            padding: 15px;
            /* Reduced padding */
            border-radius: 15px;
            position: relative;
        }

        .tracking-timeline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 25px 0;
            padding: 15px 0;
            position: relative;
        }

        .timeline-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: #ddd;
            z-index: 1;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            height: 4px;
            background: #28a745;
            z-index: 2;
            transition: width 1s ease-in-out;
        }

        .tracking-step {
            position: relative;
            z-index: 3;
            text-align: center;
            width: 90px;
            /* Reduced width for steps */
        }

        .step-icon {
            position: relative;
            transition: all 0.4s ease;
            width: 35px;
            /* Smaller icons */
            height: 35px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
            /* Smaller icon size */
            color: #ddd;
            transition: all 0.5s ease;
        }

        .step-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid transparent;
            top: -3px;
            left: -3px;
        }

        .step-icon.completed::after {
            border-color: #28a745;
            animation: pulse 1.5s infinite;
        }

        .step-icon.active {
            border-color: #28a745;
            color: #28a745;
            transform: scale(1.2);
        }

        .step-icon.completed {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .step-label {
            font-size: 15px;
            /* Smaller step labels */
            color: #666;
            margin-top: 5px;
        }

        .step-label.active {
            color: #28a745;
            font-weight: bold;
        }

        .tracking-details {
            background: white;
            padding: 12px;
            border-radius: 15px;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            font-size: 15px;
        }

        .tracking-details h3 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #ff9100;
            padding-bottom: 10px;
            text-align: center;
        }

        .tracking-details p {
            margin: 12px 0;
            color: #555;
            font-size: 1.1em;
        }

        .track-btn {
            margin-top: 10px;
            background: #ff9100;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 11px;
        }

        .track-btn:hover {
            background: #e68300;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .close-modal {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 18px;
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: #ff9100;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }

        .tracking-details:hover {
            animation: pulse 2s infinite;
        }

        .delivery-timer {
            margin-top: 10px;
            background: #f0f0f0;
            height: 8px;
            /* Thinner progress bar */
            border-radius: 6px;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .timer-bar {
            height: 8px;
            background: #28a745;
            width: 0;
            transition: width 0.5s linear, background-color 0.5s ease;
        }

        .countdown-display {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .countdown-timer {
            font-size: 16px;
            /* Smaller but still readable timer */
            font-weight: bold;
            color: #28a745;
            margin: 8px 0;
            font-family: monospace;
        }

        .delivery-note {
            margin-top: 10px;
            color: #666;
            font-style: italic;
            text-align: center;
            font-size: 11px;
        }

        #currentStatus {
            color: #28a745 !important;
            font-weight: bold;
            font-size: 13px;
        }

        #estimatedDelivery {
            color: #28a745;
            font-weight: bold;
        }

        .step-icon.delivered {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
            transform: scale(1.1);
            transition: all 0.3s ease;
        }

        .track-btn.delivered {
            background-color: #28a745;
            position: relative;
        }

        .track-btn.delivered::after {
            content: '✓';
            position: absolute;
            top: -5px;
            right: -5px;
            background: white;
            color: #28a745;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            border: 2px solid #28a745;
        }

        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
            color: #ddd;
            transition: all 0.5s ease;
        }

        .step-icon.completed {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            transform: scale(1.1);
        }

        .timer-bar {
            background-color: #28a745;
        }

        .tracking-timeline {
            margin: 25px 0;
            padding: 15px 0;
        }

        .step-icon,
        .timer-bar {
            transition: all 0.5s ease;
        }

        .step-label {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .step-icon.completed+.step-label {
            color: #28a745;
            font-weight: bold;
        }

        .confirmation-container {
            text-align: center;
            padding: 20px;
        }

        .start-tracking-btn {
            background: #ff9100;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .start-tracking-btn:hover {
            background: #e68300;
            transform: translateY(-2px);
        }

        .delivered-container {
            text-align: center;
            padding: 20px;
        }

        .delivery-checkmark {
            font-size: 48px;
            color: #28a745;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div>
        <a href="{{ route('login') }}" class="back-link">Back to Home</a>
    </div>
    <h1>Delivery History</h1>

    @if (count($deliveryOrders) > 0)
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Order Date</th>
                    <th>Action</th>
                    <th>Track</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($deliveryOrders as $order)
                    <tr>
                        <td>{{ $order->orderId }}</td>
                        <td>
                            <img src="{{ asset('/images/' . $order->image) }}" alt="{{ $order->productName }}"
                                style="width:50px;">
                        </td>
                        <td>{{ $order->productName }}</td>
                        <td>{{ $order->category }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>₱{{ number_format($order->price, 2) }}</td>
                        <td>₱{{ number_format($order->totalAmount, 2) }}</td>
                        <td>{{ $order->paymentMethod }}</td>
                        <td class="status-accepted">{{ $order->orderStatus }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ date('M d, Y h:i A', strtotime($order->created_at)) }}</td>
                        <td>
                            <form action="/deliveredItems/{{ $order->orderId }}" method="post">
                                @csrf
                                <button type="submit">Delivered</button>
                            </form>
                        </td>
                        <td>
                            <button onclick="showTracking('{{ $order->orderStatus }}', '{{ $order->orderId }}')"
                                class="track-btn {{ $order->orderStatus === 'Delivered' ? 'delivered' : '' }}">
                                Track Order
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="trackingModal" class="tracking-modal">
            <div class="tracking-content">
                <span class="close-modal" onclick="closeTracking()">&times;</span>
                <h2><i class="fas fa-truck"></i> Order Tracking</h2>

                <div class="tracking-timeline">
                    <div class="timeline-line"></div>
                    <div class="progress-line" id="progressLine"></div>

                    <div class="tracking-step">
                        <div class="step-icon" id="orderPlaced">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="step-label">Order Placed</div>
                    </div>

                    <div class="tracking-step">
                        <div class="step-icon" id="orderConfirmed">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="step-label">Confirmed</div>
                    </div>

                    <div class="tracking-step">
                        <div class="step-icon" id="outForDelivery">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="step-label">Out for Delivery</div>
                    </div>

                    <div class="tracking-step">
                        <div class="step-icon" id="delivered">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="step-label">Delivered</div>
                    </div>
                </div>

                <div class="tracking-details" id="trackingDetails"></div>
            </div>
        </div>
    @else
        <div class="no-orders">
            <h3>No Delivery orders found.</h3>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let deliveryTimers = {};
        const DELIVERY_TIME_MINUTES = 2;

        // Add a flag to track if delivery is in progress
        function isDeliveryInProgress(orderId) {
            const deliveryState = localStorage.getItem(`delivery_state_${orderId}`);
            return deliveryState === 'in_progress';
        }

        function isDeliveryCompleted(orderId) {
            const deliveryState = localStorage.getItem(`delivery_state_${orderId}`);
            return deliveryState === 'completed';
        }

        function setDeliveryState(orderId, state) {
            localStorage.setItem(`delivery_state_${orderId}`, state);
        }

        function saveTimerState(orderId, startTime) {
            localStorage.setItem(`timer_${orderId}`, JSON.stringify({
                startTime: startTime,
                isActive: true
            }));
        }

        function loadTimerState(orderId) {
            const savedState = localStorage.getItem(`timer_${orderId}`);
            return savedState ? JSON.parse(savedState) : null;
        }

        function updateTrackingStatus(status, orderId) {
            // Check if delivery is already completed
            if (isDeliveryCompleted(orderId)) {
                markAsDelivered(orderId);
                return;
            }

            // Check if delivery is already in progress
            if (isDeliveryInProgress(orderId)) {
                const savedState = loadTimerState(orderId);
                if (savedState) {
                    const startTime = new Date(savedState.startTime);
                    const estimatedTime = new Date(startTime.getTime() + (DELIVERY_TIME_MINUTES * 60 * 1000));
                    const currentTime = new Date();
                    const totalRemainingSeconds = Math.max(0, Math.round((estimatedTime - currentTime) / 1000));

                    if (totalRemainingSeconds <= 0) {
                        markAsDelivered(orderId);
                    } else {
                        updateStatusIcons(totalRemainingSeconds);
                        updateTrackingDisplay(status, orderId, startTime, estimatedTime, totalRemainingSeconds);
                        startCountdown(totalRemainingSeconds, orderId);
                    }
                    return;
                }
            }

            // If not in progress and not completed, show confirmation button
            if (!isDeliveryInProgress(orderId) && !isDeliveryCompleted(orderId)) {
                showConfirmationButton(orderId, status);
            }
        }

        function showConfirmationButton(orderId, status) {
            document.getElementById('trackingDetails').innerHTML = `
                <div class="confirmation-container">
                    <h3>Start Delivery Tracking?</h3>
                    <p>Click the button below to start tracking your delivery</p>
                    <button onclick="startDeliveryTracking('${status}', '${orderId}')" class="start-tracking-btn">
                        Start Tracking
                    </button>
                </div>
            `;
        }

        function startDeliveryTracking(status, orderId) {
            // Set delivery state as in progress
            setDeliveryState(orderId, 'in_progress');

            // Initialize new timer
            const startTime = new Date();
            saveTimerState(orderId, startTime.toISOString());

            const estimatedTime = new Date(startTime.getTime() + (DELIVERY_TIME_MINUTES * 60 * 1000));
            const totalRemainingSeconds = DELIVERY_TIME_MINUTES * 60;

            updateStatusIcons(totalRemainingSeconds);
            updateTrackingDisplay(status, orderId, startTime, estimatedTime, totalRemainingSeconds);
            startCountdown(totalRemainingSeconds, orderId);
        }

        function startCountdown(totalSeconds, orderId) {
            if (deliveryTimers[orderId]) {
                clearInterval(deliveryTimers[orderId]);
            }

            let remainingSeconds = totalSeconds;

            deliveryTimers[orderId] = setInterval(() => {
                remainingSeconds--;

                if (remainingSeconds >= 0) {
                    const minutes = Math.floor(remainingSeconds / 60);
                    const seconds = remainingSeconds % 60;

                    const timerElements = document.querySelectorAll(`#remainingTime-${orderId}`);
                    timerElements.forEach(timerElement => {
                        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    });

                    updateProgressBar(orderId, remainingSeconds);
                    updateStatusIcons(remainingSeconds);

                } else {
                    clearInterval(deliveryTimers[orderId]);
                    setDeliveryState(orderId, 'completed');
                    localStorage.removeItem(`timer_${orderId}`);
                    markAsDelivered(orderId);
                }
            }, 1000);
        }

        function markAsDelivered(orderId) {
            setDeliveryState(orderId, 'completed');
            localStorage.removeItem(`timer_${orderId}`);

            // Update the tracking display to show delivered state
            document.getElementById('trackingDetails').innerHTML = `
                <div class="delivered-container">
                    <h3 style="color: #28a745;">Delivery Completed!</h3>
                    <p>Your order has been successfully delivered.</p>
                    <div class="delivery-checkmark">✓</div>
                </div>
            `;

            // Update all visual elements to show completed state
            updateStatusIcons(0);

            // Update the track button
            const trackBtn = document.querySelector(`button[onclick="showTracking('Delivered', '${orderId}')"]`);
            if (trackBtn) {
                trackBtn.classList.add('delivered');
            }
        }

        function updateStatusIcons(remainingSeconds) {
            const totalSeconds = DELIVERY_TIME_MINUTES * 60;
            const progress = ((totalSeconds - remainingSeconds) / totalSeconds) * 100;

            // Get all step icons
            const orderPlaced = document.getElementById('orderPlaced');
            const orderConfirmed = document.getElementById('orderConfirmed');
            const outForDelivery = document.getElementById('outForDelivery');
            const delivered = document.getElementById('delivered');

            // Reset all icons
            [orderPlaced, orderConfirmed, outForDelivery, delivered].forEach(icon => {
                icon.classList.remove('completed', 'active');
                icon.style.backgroundColor = '';
                icon.style.borderColor = '#ddd';
                icon.style.color = '#ddd';
            });

            // Update current status text based on progress
            let currentStatus = "Order Placed";

            // Update icons based on progress
            if (progress >= 0) {
                orderPlaced.classList.add('completed');
                orderPlaced.style.backgroundColor = '#28a745';
                orderPlaced.style.borderColor = '#28a745';
                orderPlaced.style.color = 'white';
            }

            if (progress >= 33) {
                orderConfirmed.classList.add('completed');
                orderConfirmed.style.backgroundColor = '#28a745';
                orderConfirmed.style.borderColor = '#28a745';
                orderConfirmed.style.color = 'white';
                currentStatus = "Order Confirmed";
            }

            if (progress >= 66) {
                outForDelivery.classList.add('completed');
                outForDelivery.style.backgroundColor = '#28a745';
                outForDelivery.style.borderColor = '#28a745';
                outForDelivery.style.color = 'white';
                currentStatus = "Out for Delivery";
            }

            if (progress >= 100) {
                delivered.classList.add('completed');
                delivered.style.backgroundColor = '#28a745';
                delivered.style.borderColor = '#28a745';
                delivered.style.color = 'white';
                currentStatus = "Delivered";
            }

            // Update the current status text
            const statusElement = document.getElementById('currentStatus');
            if (statusElement) {
                statusElement.textContent = currentStatus;
                statusElement.style.color = '#28a745';
            }
        }

        function updateTrackingDisplay(status, orderId, startTime, estimatedTime, totalRemainingSeconds) {
            const remainingMinutes = Math.floor(totalRemainingSeconds / 60);
            const remainingSeconds = totalRemainingSeconds % 60;

            const formattedEstimatedTime = estimatedTime.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            document.getElementById('trackingDetails').innerHTML = `
                <h3>Current Status: <span id="currentStatus"></span></h3>
                <p>Started At: <span>${startTime.toLocaleTimeString()}</span></p>
                <p>Estimated Delivery Time: <span id="estimatedDelivery">${formattedEstimatedTime}</span></p>
                <div class="countdown-display">
                    <p>Time Remaining:</p>
                    <div id="remainingTime-${orderId}" class="countdown-timer">
                        ${remainingMinutes}:${remainingSeconds.toString().padStart(2, '0')}
                    </div>
                </div>
                <div class="delivery-timer">
                    <div id="timerBar-${orderId}" class="timer-bar"></div>
                </div>
                <p class="delivery-note">🚚 Quantum Delivery: Your order will arrive in ${DELIVERY_TIME_MINUTES} minutes!</p>
            `;

            updateProgressBar(orderId, totalRemainingSeconds);
            // Update status icons and text immediately
            updateStatusIcons(totalRemainingSeconds);
        }

        function updateProgressBar(orderId, remainingSeconds) {
            const progress = ((DELIVERY_TIME_MINUTES * 60 - remainingSeconds) / (DELIVERY_TIME_MINUTES * 60) * 100);
            const timerBar = document.getElementById(`timerBar-${orderId}`);
            if (timerBar) {
                timerBar.style.width = `${progress}%`;
                timerBar.style.backgroundColor = '#28a745'; // Always green
            }
        }

        // Add page visibility handling
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                // When page becomes visible, check and update all active timers
                const allStorageKeys = Object.keys(localStorage);
                allStorageKeys.forEach(key => {
                    if (key.startsWith('timer_')) {
                        const orderId = key.replace('timer_', '');
                        const savedState = loadTimerState(orderId);
                        if (savedState && savedState.isActive) {
                            updateTrackingStatus('', orderId);
                        }
                    }
                });
            }
        });

        // Initialize all active timers when page loads
        window.addEventListener('load', () => {
            const allStorageKeys = Object.keys(localStorage);
            allStorageKeys.forEach(key => {
                if (key.startsWith('timer_')) {
                    const orderId = key.replace('timer_', '');
                    if (isDeliveryInProgress(orderId)) {
                        updateTrackingStatus('', orderId);
                    }
                }
            });
        });

        function showTracking(status, orderId) {
            document.getElementById('trackingModal').style.display = 'block';
            updateTrackingStatus(status, orderId);
        }

        function closeTracking() {
            document.getElementById('trackingModal').style.display = 'none';
            // Timer will continue running in the background
        }
    </script>
</body>

</html>
