<x-mail::message>
    **Dear Customer,**

    @if ($order->order_type === 'Customized')
        Your order is now in progress. Our tailoring team is already working on it,
        and we’ll update you once it’s ready. Estimated completion time of your customized order is 6-7 days
    @else
        Your order is now in progress. Our tailoring team is already working on it,
        and we’ll update you once it’s ready. Estimated completion time of your ready-made order is 4-5 days
    @endif

    Thank you for choosing MMRC Tailoring! We appreciate your trust in us.

    Best regards,
    MMRC Tailoring ✂️
</x-mail::message>
