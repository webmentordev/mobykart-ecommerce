<x-mail::message>
# 🚨 Order has been refunded

Dear Valued Customer,

We regret to inform you that your recent order with **{{ config('app.name') }}**, Order **{{ $order }}**, has been refunded. The refund process can take up to **4 - 7 business days**. We understand this may come as a disappointment, and we sincerely apologize for any inconvenience this may have caused.

Your satisfaction is of utmost importance to us, and we strive to provide a seamless shopping experience. Should you have any questions or concerns regarding the refund process or your order, please don't hesitate to contact our customer support team at **{{ config('app.contact') }}**. We are here to assist you in any way we can.

Best Regards,<br>
{{ config('app.name') }}
</x-mail::message>
