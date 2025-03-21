<x-mail::message>
    **Dear Customer,**  

    Your appointment has been rescheduled to {{ $appointment->date->format('Y-m-d') }} {{ $appointment->time_from }} - {{ $appointment->time_to }}. Sorry for the inconvenience. 

    Thank you for choosing **{{ config('app.name') }}**! We appreciate your trust in us.  

    **Best regards,**  
    **{{ config('app.name') }}** ✂️  
</x-mail::message>