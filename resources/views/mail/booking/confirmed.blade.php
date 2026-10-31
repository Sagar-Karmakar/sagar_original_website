<x-mail::message>
# You're booked, {{ $booking->name }}

Your free 20-minute call with Sagar is on **{{ $booking->when() }}** (India time).

@if (config('booking.meeting_url'))
Join here when it's time: {{ config('booking.meeting_url') }}
@else
I'll send you the call link on WhatsApp before we start.
@endif

On the call, you tell me what's been happening between you two, and I'll tell you honestly whether Back to Us can help. Both partners are welcome. If only one of you can join, that's fine too.

The call is attached as a calendar invite.

<x-mail::button :url="$url" color="primary">
See or cancel your booking
</x-mail::button>

See you soon,<br>
Sagar Karmakar

<small>This is coaching, not therapy. If you ever feel afraid at home, call the Women Helpline 181, or 112 in an emergency. For emotional support any time, call Tele-MANAS on 14416.</small>
</x-mail::message>
