<x-mail::message>
@if ($byClient)
# A free call was cancelled

{{ $booking->couple() }} cancelled their call on **{{ $booking->when() }}**. That time is open again.

[See all bookings]({{ route('admin.bookings') }})
@else
# Your free call is cancelled

Hi {{ $booking->name }}, I'm sorry, I had to cancel our call on **{{ $booking->when() }}**.

Please pick another time that suits you.

<x-mail::button :url="route('call')" color="primary">
Pick a new time
</x-mail::button>

Sagar Karmakar
@endif
</x-mail::message>
