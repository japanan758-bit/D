<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    public function initiatePayment(float $amount, array $customerDetails): string;
    public function verifyPayment(string $paymentId): bool;
}
