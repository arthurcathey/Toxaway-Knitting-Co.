<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class StripePaymentService
{
  private string $secretKey;
  private string $baseUrl = 'https://api.stripe.com/v1';

  public function __construct()
  {
    $this->secretKey = config('services.stripe.secret');
  }

  /**
   * Create a payment intent for order processing
   */
  public function createPaymentIntent(
    float $amount,
    string $currency = 'usd',
    array $metadata = [],
    string $description = null
  ): array {
    try {
      $response = Http::withBasicAuth($this->secretKey, '')
        ->post("{$this->baseUrl}/payment_intents", [
          'amount' => (int)($amount * 100), // Convert to cents
          'currency' => $currency,
          'metadata' => $metadata,
          'description' => $description,
          'statement_descriptor' => 'TOXAWAY KNITTING',
        ]);

      if ($response->successful()) {
        return [
          'success' => true,
          'client_secret' => $response->json('client_secret'),
          'payment_intent_id' => $response->json('id'),
        ];
      }

      return [
        'success' => false,
        'error' => $response->json('error.message') ?? 'Payment intent creation failed',
      ];
    } catch (Exception $e) {
      return [
        'success' => false,
        'error' => $e->getMessage(),
      ];
    }
  }

  /**
   * Retrieve payment intent status
   */
  public function retrievePaymentIntent(string $paymentIntentId): array
  {
    try {
      $response = Http::withBasicAuth($this->secretKey, '')
        ->get("{$this->baseUrl}/payment_intents/{$paymentIntentId}");

      if ($response->successful()) {
        $data = $response->json();
        return [
          'success' => true,
          'status' => $data['status'],
          'amount' => $data['amount'] / 100, // Convert back to dollars
          'charge_id' => $data['charges']['data'][0]['id'] ?? null,
        ];
      }

      return [
        'success' => false,
        'error' => 'Failed to retrieve payment intent',
      ];
    } catch (Exception $e) {
      return [
        'success' => false,
        'error' => $e->getMessage(),
      ];
    }
  }

  /**
   * Confirm a payment intent
   */
  public function confirmPaymentIntent(
    string $paymentIntentId,
    string $paymentMethodId
  ): array {
    try {
      $response = Http::withBasicAuth($this->secretKey, '')
        ->post("{$this->baseUrl}/payment_intents/{$paymentIntentId}/confirm", [
          'payment_method' => $paymentMethodId,
          'return_url' => route('checkout.success'),
        ]);

      if ($response->successful()) {
        $data = $response->json();
        return [
          'success' => true,
          'status' => $data['status'],
          'requires_action' => isset($data['client_secret']),
          'client_secret' => $data['client_secret'] ?? null,
        ];
      }

      return [
        'success' => false,
        'error' => $response->json('error.message') ?? 'Payment confirmation failed',
      ];
    } catch (Exception $e) {
      return [
        'success' => false,
        'error' => $e->getMessage(),
      ];
    }
  }

  /**
   * Create a charge directly (for simpler payment flow)
   */
  public function createCharge(
    string $paymentMethodId,
    int $amountCents,
    string $currency = 'usd',
    array $metadata = []
  ): array {
    try {
      $response = Http::withBasicAuth($this->secretKey, '')
        ->post("{$this->baseUrl}/charges", [
          'amount' => $amountCents,
          'currency' => $currency,
          'payment_method' => $paymentMethodId,
          'off_session' => true,
          'confirm' => true,
          'metadata' => $metadata,
          'statement_descriptor' => 'TOXAWAY KNITTING',
        ]);

      if ($response->successful()) {
        $data = $response->json();
        return [
          'success' => true,
          'charge_id' => $data['id'],
          'status' => $data['status'],
          'amount' => $data['amount'] / 100,
        ];
      }

      return [
        'success' => false,
        'error' => $response->json('error.message') ?? 'Charge creation failed',
      ];
    } catch (Exception $e) {
      return [
        'success' => false,
        'error' => $e->getMessage(),
      ];
    }
  }

  /**
   * Verify webhook signature
   */
  public static function verifyWebhookSignature(string $payload, string $signature): bool
  {
    try {
      $secret = config('services.stripe.webhook_secret');
      $computedSignature = hash_hmac('sha256', $payload, $secret);

      return hash_equals($computedSignature, $signature);
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * Get the public key for client-side Stripe.js
   */
  public function getPublicKey(): string
  {
    return config('services.stripe.public');
  }
}
