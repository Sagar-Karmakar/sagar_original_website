<x-mail::message>
# New free call booked

**{{ $booking->when() }}**

<x-mail::table>
| | |
| :-- | :-- |
| Name | {{ $booking->name }} |
| Partner | {{ $booking->partner_name ?: '—' }} |
| Joining | {{ $booking->partner_joining ? 'Both of them' : 'Just one of them for now' }} |
| Language | {{ $booking->language }} |
| Email | {{ $booking->email }} |
| WhatsApp | {{ $booking->phone }} |
</x-mail::table>

@if ($booking->notes)
**What they'd like you to know:**

{{ $booking->notes }}
@endif

<x-mail::button :url="$booking->whatsappUrl()" color="primary">
Message them on WhatsApp
</x-mail::button>

[See all bookings]({{ route('admin.bookings') }})
</x-mail::message>
