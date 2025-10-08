<!-- resources/views/emails/booking_query.blade.php -->

<h2>New Booking Query</h2>
<p><strong>Name:</strong> {{ $query->full_name }}</p>
<p><strong>Email:</strong> {{ $query->email }}</p>
<p><strong>Phone:</strong> {{ $query->phone }}</p>
<p><strong>Project:</strong> {{ $query->project_id ?? '' }}</p>
<p><strong>Flat:</strong> {{ $query->flat_id ?? '' }}</p>
<p><strong>Date:</strong> {{ $query->preferred_date }}</p>
<p><strong>Message:</strong><br>{{ $query->message }}</p>
