<pre>
Atsogo Estate Agency
Reservation Invoice
Invoice #: {{ $invoice_number }}
Date: {{ $date }}
Customer:
Email: {{ $user->email }}
Phone: {{ $user->phone_number }}
Plot	Location	Reservation ID	Reserved On	Expires On
{{ $plot->title }}	{{ $plot->location }}	{{ $reservation->id }}	{{ $reservation->created_at->format('Y-m-d H:i') }}	{{ $reservation->expires_at->format('Y-m-d H:i') }}
Reservation Fee: MWK {{ number_format($plot->price, 2) }}
Payment Status: {{ $reservation->status == 'completed' ? 'Paid' : 'Unpaid' }}
Instructions:
Please pay the reservation fee within 24 hours to secure your plot.
For questions, contact info@atsogo.mw
</pre> 