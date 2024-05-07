<x-mail::message>
# 🚚 Order has been dispatched

Dear Valued Customer,

We are excited to inform you that your recent order with **{{ config('app.name') }}** is now in transit! Your satisfaction is our top priority, and we are thrilled that your purchase is on its way to you.

Your order has been carefully processed and is now en route to the shipping address provided during checkout. Our logistics team is working diligently to ensure that your items are delivered to you safely and promptly.

**Order ID:** {{ $order }}<br>
**Logistics:** {{ $logistics }}<br>
**Tracking Number:** {{ $transit }}<br>
**Estimated Delivery Date:** {{ \Carbon\Carbon::now()->addDays(4)->format('d M, Y') }} to {{ \Carbon\Carbon::now()->addDays(8)->format('d M, Y') }}

Should you have any questions about your order or require further assistance, please feel free to contact our dedicated customer support team at **{{ config('app.contact') }}**. We are here to assist you every step of the way.


Best Regards,<br>
{{ config('app.name') }}
</x-mail::message>