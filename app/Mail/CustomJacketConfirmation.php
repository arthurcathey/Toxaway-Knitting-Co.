<?php

namespace App\Mail;

use App\Models\CustomJacketRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomJacketConfirmation extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(public CustomJacketRequest $customJacket) {}

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Your Custom Varsity Jacket Request - Toxaway Knitting Co.',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.custom-jacket-confirmation',
      with: [
        'customJacket' => $this->customJacket,
      ],
    );
  }

  /**
   * Get the attachments for the message.
   */
  public function attachments(): array
  {
    return [];
  }
}
