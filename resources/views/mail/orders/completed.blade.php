<x-mail::message>
# 🎁 Order has been completed

Dear Valued Customer,

We are thrilled to inform you that your recent order **{{ $order }}** with **{{ config('app.name') }}** has been successfully completed! Your satisfaction is our top priority, and we are delighted to have been able to fulfill your order. We would like to express our gratitude for choosing {{ config('app.name') }} for your purchase. Your support means the world to us, and we hope that the products you've ordered will exceed your expectations.

If you have any questions about your order or need further assistance, please don't hesitate to reach out to our dedicated customer support team at **{{ config('app.contact') }}**. We're here to help!

Best Regards,<br>
{{ config('app.name') }}
</x-mail::message>