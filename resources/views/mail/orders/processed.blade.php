<x-mail::message>
# 🔔 Order has been processed

Dear Valued Customer,

We're excited to let you know that your order **{{ $order }}** with **{{ config('app.name') }}** has been successfully processed! Your satisfaction is our priority, and we're thrilled to have taken this step towards completing your purchase.

Should you have any questions about your order or require further assistance, please feel free to contact our dedicated customer support team at **{{ config('app.contact') }}**. We're here to assist you every step of the way.

Best Regards,<br>
{{ config('app.name') }}
</x-mail::message>
