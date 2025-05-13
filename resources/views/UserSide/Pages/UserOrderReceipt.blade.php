<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>Order Receipt - {{ $order->orderId }}</title>
    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #ddd;
        }

        .receipt-header h1 {
            color: #ff9100;
            margin-bottom: 5px;
        }

        .receipt-header p {
            color: #666;
            margin: 5px 0;
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .order-info div {
            flex: 1;
        }

        .order-info h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .order-info p {
            margin: 5px 0;
            color: #666;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table th {
            border-bottom: 2px solid orange;
            color: black;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .total-section {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            margin: 0 5px;
        }

        .btn-primary {
            background-color: #ff9100;
            color: white;
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .thank-you {
            text-align: center;
            margin-top: 30px;
            color: #666;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 500px;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #aaa;
        }

        .close-modal:hover {
            color: #333;
        }

        /* Download options dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 4px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Print styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                max-width: 100%;
            }

            .action-buttons {
                display: none;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container" id="receipt">
        <div class="receipt-header">
            <h1>Order Receipt</h1>
            <p>Thank you for your purchase!</p>
            <p>{{ date('F d, Y') }}</p>
        </div>

        <div class="order-info">
            <div>
                <h3>Order Information</h3>
                <p><strong>Order ID:</strong> {{ $order->orderId }}</p>
                <p><strong>Date:</strong> {{ date('F d, Y', timestamp: strtotime($order->created_at)) }}</p>
                <p><strong>Status:</strong> {{ $order->orderStatus }}</p>
            </div>
            <div>
                <h3>Customer Information</h3>
                <p><strong>Name:</strong> {{ $order->firstName }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>Phone:</strong> {{ $order->phoneNumber }}</p>
            </div>
        </div>

        <h3>Order Items</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->productName }}"
                                class="product-image">
                            {{ $item->productName }}
                        </td>
                        <td> {{ $item->productId }}</td>
                        <td>{{ $item->category }}</td>
                        <td>₱{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p><strong>Total Amount: ₱{{ number_format($order->totalAmount, 2) }}</strong></p>
        </div>

        <div class="thank-you">
            <p>Thank you for shopping Quantum Order!</p>
            {{-- <p>For any questions or concerns, please contact our customer service.</p> --}}
        </div>

        <div class="action-buttons">
            <a href="{{ url('/') }}" class="btn btn-secondary">Back to Home</a>
            <div class="dropdown">
                <button class="btn btn-primary">Download Receipt</button>
                <div class="dropdown-content">
                    <a href="#" onclick="downloadReceipt(); return false;">Print Version</a>
                    <a href="#" onclick="exportToPDF(); return false;">Export to PDF</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 style="color: #ff9100; text-align: center;">Order Successful!</h2>
            <p style="text-align: center;">Your order has been placed successfully.</p>
            <p style="text-align: center;">Order ID: <strong>{{ $order->orderId }}</strong></p>
            <div style="text-align: center; margin-top: 20px;">
                <button onclick="closeModal()"
                    style="background: #ff9100; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="modal" style="display: none;">
        <div class="modal-content" style="text-align: center; padding: 30px;">
            <h3>Generating PDF...</h3>
            <p>Please wait while we prepare your receipt.</p>
            <div
                style="margin: 20px auto; border: 5px solid #f3f3f3; border-top: 5px solid #ff9100; border-radius: 50%; width: 50px; height: 50px; animation: spin 2s linear infinite;">
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                document.getElementById('successModal').style.display = 'block';
            @endif
        });

        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('successModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        function downloadReceipt() {
            const printWindow = window.open('', '_blank');

            const receiptContent = document.getElementById('receipt').innerHTML;

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Order Receipt - {{ $order->orderId }}</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 20px;
                        }
                        .receipt-container {
                            max-width: 800px;
                            margin: 0 auto;
                            padding: 20px;
                        }
                        .receipt-header {
                            text-align: center;
                            margin-bottom: 20px;
                            padding-bottom: 20px;
                            border-bottom: 1px dashed #ddd;
                        }
                        .receipt-header h1 {
                            color: #ff9100;
                            margin-bottom: 5px;
                        }
                        .receipt-header p {
                            color: #666;
                            margin: 5px 0;
                        }
                        .order-info {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 20px;
                            padding-bottom: 20px;
                            border-bottom: 1px solid #eee;
                        }
                        .order-info div {
                            flex: 1;
                        }
                        .order-info h3 {
                            color: #333;
                            margin-bottom: 10px;
                        }
                        .order-info p {
                            margin: 5px 0;
                            color: #666;
                        }
                        .items-table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 20px;
                        }
                        .items-table th,
                        .items-table td {
                            padding: 12px;
                            text-align: left;
                            border-bottom: 1px solid #ddd;
                        }
                        .items-table th {
                            background-color: #ff9100;
                            color: white;
                        }
                        .product-image {
                            width: 60px;
                            height: 60px;
                            object-fit: cover;
                            border-radius: 4px;
                        }
                        .total-section {
                            text-align: right;
                            font-size: 1.2em;
                            margin-top: 20px;
                            padding-top: 20px;
                            border-top: 1px solid #eee;
                        }
                        .thank-you {
                            text-align: center;
                            margin-top: 30px;
                            color: #666;
                        }
                        .action-buttons {
                            display: none;
                        }
                    </style>
                </head>
                <body>
                    <div class="receipt-container">
                        ${receiptContent}
                    </div>
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.onload = function() {
                printWindow.print();
            };
        }

        function exportToPDF() {
            document.getElementById('loadingModal').style.display = 'block';

            try {
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');

                // Colors
                const orangeColor = '#ff9100';
                const greyColor = '#666666';

                // Page settings
                const pageWidth = pdf.internal.pageSize.getWidth();
                let yPos = 20;

                // Receipt Header - match the receipt-header class style
                pdf.setTextColor(orangeColor);
                pdf.setFontSize(24);
                pdf.text('Order Receipt', pageWidth / 2, yPos, {
                    align: 'center'
                });

                yPos += 10;
                pdf.setTextColor(greyColor);
                pdf.setFontSize(12);
                pdf.text('Thank you for your purchase!', pageWidth / 2, yPos, {
                    align: 'center'
                });

                yPos += 7;
                const date = "{{ date('F d, Y h:i A', strtotime($order->updated_at)) }}";
                pdf.text(date, pageWidth / 2, yPos, {
                    align: 'center'
                });

                // Dashed line separator - match the border-bottom style
                yPos += 10;
                pdf.setDrawColor(221, 221, 221);
                pdf.setLineDashPattern([3, 3], 0);
                pdf.line(20, yPos, pageWidth - 20, yPos);
                pdf.setLineDashPattern([], 0);

                // Order Information Section - match the order-info class style
                yPos += 15;
                const colWidth = (pageWidth - (20 * 2)) / 2;

                // Left Column
                pdf.setTextColor(51, 51, 51);
                pdf.setFontSize(16);
                pdf.text('Order Information', 20, yPos);

                pdf.setFontSize(12);
                pdf.setTextColor(102, 102, 102);
                yPos += 10;
                pdf.text(`Order ID: {{ $order->orderId }}`, 20, yPos);
                yPos += 7;
                pdf.text(`Date: {{ date('F d, Y', strtotime($order->created_at)) }}`, 20, yPos);
                yPos += 7;
                pdf.text(`Status: {{ $order->orderStatus }}`, 20, yPos);

                // Right Column
                const rightCol = 20 + colWidth + 10;
                let rightY = yPos - 24;
                pdf.setFontSize(16);
                pdf.setTextColor(51, 51, 51);
                pdf.text('Customer Information', rightCol, rightY);

                pdf.setFontSize(12);
                pdf.setTextColor(102, 102, 102);
                rightY += 10;
                pdf.text(`Name: {{ $order->firstName }}`, rightCol, rightY);
                rightY += 7;
                pdf.text(`Address: {{ $order->address }}`, rightCol, rightY);
                rightY += 7;
                pdf.text(`Phone: {{ $order->phoneNumber }}`, rightCol, rightY);

                // Solid line separator
                yPos += 15;
                pdf.setDrawColor(238, 238, 238);
                pdf.setLineWidth(1);
                pdf.line(20, yPos, pageWidth - 20, yPos);

                // Order Items Table
                yPos += 15;
                pdf.setTextColor(51, 51, 51);
                pdf.setFontSize(16);
                pdf.text('Order Items', 20, yPos);

                // Table Headers
                yPos += 10;
                const headers = ['Product', 'ID', 'Category', 'Price', 'Quantity', 'Subtotal'];
                const colWidths = [45, 20, 30, 25, 20, 30];

                // Table header with bottom border only
                pdf.setLineWidth(2);
                pdf.setDrawColor(orangeColor);
                let xPos = 20;

                pdf.setFontSize(12);
                pdf.setTextColor(0, 0, 0);
                headers.forEach((header, i) => {
                    pdf.text(header, xPos, yPos);
                    xPos += colWidths[i];
                });

                // Orange line under headers
                yPos += 2;
                pdf.line(20, yPos, pageWidth - 20, yPos);

                // Table Content
                pdf.setTextColor(102, 102, 102);
                pdf.setLineWidth(1);
                pdf.setDrawColor(221, 221, 221);

                @foreach ($orderItems as $item)
                    yPos += 12;

                    // Add new page if needed
                    if (yPos > 250) {
                        pdf.addPage();
                        yPos = 20 + 10;
                    }

                    xPos = 20;
                    pdf.text('{{ $item->productName }}', xPos, yPos);
                    xPos += colWidths[0];

                    pdf.text('{{ $item->productId }}', xPos, yPos);
                    xPos += colWidths[1];

                    pdf.text('{{ $item->category }}', xPos, yPos);
                    xPos += colWidths[2];

                    pdf.text('₱{{ number_format($item->price, 2) }}', xPos, yPos);
                    xPos += colWidths[3];

                    pdf.text('{{ $item->quantity }}', xPos, yPos);
                    xPos += colWidths[4];

                    pdf.text('₱{{ number_format($item->price * $item->quantity, 2) }}', xPos, yPos);

                    // Add bottom border for each row
                    yPos += 2;
                    pdf.line(20, yPos, pageWidth - 20, yPos);
                @endforeach

                // Total Section - match the total-section class style
                yPos += 15;
                pdf.setLineWidth(1);
                pdf.setDrawColor(238, 238, 238);
                pdf.line(20, yPos, pageWidth - 20, yPos);

                yPos += 15;
                pdf.setFontSize(14);
                pdf.setTextColor(0, 0, 0);
                const totalText = 'Total Amount: ₱{{ number_format($order->totalAmount, 2) }}';
                pdf.text(totalText, pageWidth - 20 - pdf.getTextWidth(totalText), yPos);

                // Thank you message - match the thank-you class style
                yPos += 20;
                pdf.setTextColor(102, 102, 102);
                pdf.setFontSize(12);
                pdf.text('Thank you for shopping Quantum Order!', pageWidth / 2, yPos, {
                    align: 'center'
                });

                // Save PDF
                pdf.save(`Quantum_Order_Receipt_{{ $order->orderId }}.pdf`);

            } catch (error) {
                console.error('Error generating PDF:', error);
                alert('There was an error generating the PDF. Please try again.');
            } finally {
                document.getElementById('loadingModal').style.display = 'none';
            }
        }
    </script>
</body>

</html>
