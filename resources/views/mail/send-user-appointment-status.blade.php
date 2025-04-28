<x-mail::message>
    Dear customer,

    @if ($appointment->status == 'done')
        Your order has been completed by the admin. Please wait for the notification to pick up your order.
    @elseif ($appointment->status == 'pick-up')
        Your order has been completed and is now ready for pick up. Please visit our store at your earliest convenience.
    @else
    Your order has been picked up. The status will now be updated to completed. Thank you for choosing MMRC Tailoring!
    @endif

    Best regards,
    MMRC Tailoring ✂️ 
</x-mail::message>
