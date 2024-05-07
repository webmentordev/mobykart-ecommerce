<x-mail::message>
# 🚀 Order has been placed

Dear Valued Customer,

We've received your order details, and we're thrilled to assist you further. To proceed with the checkout process in case you've lost the payment link, please click the button below to access Stripe's secure checkout page. Please note that this link will expire in 6 hours. In case you have any difficulty or if the link expires, please feel free to reach out to us at **{{ config('app.contact') }}**, and we'll be happy to assist you promptly. 

<x-mail::button :url="$url">
Stripe checkout
</x-mail::button>

Best Regards,<br>
{{ config('app.name') }}
</x-mail::message>
