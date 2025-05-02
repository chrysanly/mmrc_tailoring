<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        @if ($status === 'in-progress')
            <div class="p-4 bg-light border rounded">
                <h2 class="text-dark">Dear Customer,</h2>
                <p class="text-secondary">
                    @if ($order->order_type === 'Customized')
                        Your order is now in progress. Our tailoring team is already working on it, and we’ll update you once it’s ready.
                        <strong>Estimated completion time of your customized order is 6-7 days.</strong>
                    @else
                        Your order is now in progress. Our tailoring team is already working on it, and we’ll update you once it’s ready.
                        <strong>Estimated completion time of your ready-made order is 4-5 days.</strong>
                    @endif
                </p>
                <p class="text-secondary">Thank you for choosing <strong>MMRC Tailoring</strong>! We appreciate your trust in us.</p>
                <p class="text-secondary">Best regards,</p>
                <p class="text-secondary fw-bold">MMRC Tailoring ✂️</p>
            </div>
        @endif

        @if ($status === 'done')
            <div class="p-4 bg-light border rounded">
                <h2 class="text-dark">Dear Customer,</h2>
                <p class="text-secondary">
                    Good day! We’re pleased to inform you that your order is Done. <br>
                    Please settle the remaining balance (₱{{ number_format($order->invoice->total - $order->invoice->total_payment, 2) }}) through Gcash and PayMaya or <br>
                    at our store while waiting for the pickup status of your order.
                </p>
                <p class="text-secondary">
                    Thank you for choosing <strong>MMRC Tailoring</strong>! We truly appreciate your trust in our services,
                    and we hope you're delighted with the final result.
                </p>
                <p class="text-secondary">
                    If you have any further questions or need additional assistance, feel free to reach out.
                </p>
                <p class="text-secondary">Best regards,</p>
                <p class="text-secondary fw-bold">MMRC Tailoring ✂️</p>
            </div>
        @endif

        @if ($status === 'pick-up')
            <div class="p-4 bg-light border rounded">
            <h2 class="text-dark">Dear Customer,</h2>
            <p class="text-secondary">
                We are pleased to inform you that your order has been done and is now ready for pick-up.
                Our tailoring team has worked diligently to ensure everything meets your expectations.
            </p>
            <p class="text-secondary">
                Thank you for choosing <strong>MMRC Tailoring</strong>! We truly appreciate your trust in our services,
                and we hope you're delighted with the final result.
            </p>
            <p class="text-secondary">
                If you have any further questions or need additional assistance, feel free to reach out.
            </p>
            <p class="text-secondary">Best regards,</p>
            <p class="text-secondary fw-bold">MMRC Tailoring ✂️</p>
            </div>
        @endif
    </div>
</body>
</html>
