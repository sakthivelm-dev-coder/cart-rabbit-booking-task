<p>
@if($forHost)
A new booking has been made for {{ $booking->date }} from {{ $booking->start_time }} to {{ $booking->end_time }}.<br>
Visitor: {{ $booking->visitor_name }} ({{ $booking->visitor_email }})
@else
Your booking is confirmed for {{ $booking->date }} from {{ $booking->start_time }} to {{ $booking->end_time }}.<br>
Thank you, {{ $booking->visitor_name }}!
@endif
</p>
