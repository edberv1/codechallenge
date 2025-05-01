<h1>Thanks for your booking!</h1>
<p>You booked a ticket for: <strong>{{ $ticket->event->title }}</strong></p>
<p>Seat: {{ $ticket->seat_info ?? 'General Admission' }}</p>
<p>Date: {{ $ticket->event->start_time }}</p>
<p>Enjoy the event!</p>
