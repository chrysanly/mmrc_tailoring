<x-mail::message>
    **Dear Customer,**

    @if ($order->order_type === 'Customized')
We are pleased to inform you that your customized order has been completed and is now ready.
    Our tailoring team has worked diligently to ensure everything meets your expectations.
    @else
We are pleased to inform you that your ready-made order has been completed and is now ready.
    Our tailoring team has worked diligently to ensure everything meets your expectations.
    @endif

    Thank you for choosing MMRC Tailoring! We truly appreciate your trust in our services,
    and we hope you're delighted with the final result.

    If you have any further questions or need additional assistance, feel free to reach out.

    Best regards,
    MMRC Tailoring ✂️
</x-mail::message>
