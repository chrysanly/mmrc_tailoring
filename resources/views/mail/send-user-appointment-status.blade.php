<x-mail::message>
Dear customer,

your appointment that is scheduled on [{{ $date }}] has been {{ $status }} by admin.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
