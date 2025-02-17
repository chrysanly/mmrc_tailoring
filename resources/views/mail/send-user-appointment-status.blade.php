<x-mail::message>
    Dear customer,

    Your appointment that is scheduled on {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }} from
    {{ \Carbon\Carbon::parse($appointment->time_from)->format('g:i A') }} to
    {{ \Carbon\Carbon::parse($appointment->time_to)->format('g:i A') }} has been completed by the admin. Please go to
    the shop and claim it.

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
