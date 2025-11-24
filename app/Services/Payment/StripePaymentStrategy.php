<?php

namespace App\Services\Payment;

class StripePaymentStrategy implements PaymentGatewayInterface
{
    public function initiatePayment(float $amount, array $customerDetails): string
    {
        // Placeholder for Stripe Logic
        // \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // $intent = \Stripe\PaymentIntent::create([...]);
        return "dummy_payment_url";
    }

    public function verifyPayment(string $paymentId): bool
    {
        // Placeholder verification
        return true;
    }
}
