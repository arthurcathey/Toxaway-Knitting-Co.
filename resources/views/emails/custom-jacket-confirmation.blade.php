@component('mail::message')
# Thank You for Your Custom Jacket Request

Hello {{ $customJacket->full_name }},

We received your custom varsity jacket request and we're excited to get started! Our team is reviewing your specifications and will send you a detailed quote within 2-3 business days.

## Your Order Summary

**Style:** {{ $customJacket->base_style }}
**Primary Color:** {{ $customJacket->primary_color }}
**Secondary Color:** {{ $customJacket->secondary_color }}
**Material:** {{ $customJacket->material }}
**Front Text:** {{ $customJacket->front_text }}

@if ($customJacket->custom_details)
**Custom Details:**
{{ $customJacket->custom_details }}
@endif

## What's Next?

1. **Quote Review** - We'll send you a detailed quote based on your customization
2. **Approval & Payment** - Once approved, submit 50% deposit to begin production
3. **Production** - Your jacket will be hand-crafted with progress updates
4. **Delivery** - Final quality check and insured shipping to your address

**Timeline:** 8-10 weeks from approval to delivery

## Questions?

Reply to this email or contact us at hello@toxaway.test or (828) 555-0123.

Thank you for choosing Toxaway!

Best regards,
**The Toxaway Team**

---
Toxaway Knitting Co. | Heavyweight. American-Made. Built to Last.
@endcomponent
