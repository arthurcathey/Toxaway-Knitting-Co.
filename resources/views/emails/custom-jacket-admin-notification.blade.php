@component('mail::message')
# New Custom Jacket Quote Request

A new custom jacket request has been submitted and requires review.

## Customer Information

**Name:** {{ $customJacket->full_name }}
**Email:** {{ $customJacket->email }}
**Phone:** {{ $customJacket->phone }}
@if ($customJacket->user_id)
**Account:** Registered user (ID: {{ $customJacket->user_id }})
@else
**Account:** Guest submission
@endif

## Jacket Specifications

**Style:** {{ $customJacket->base_style }}
**Primary Color (Body):** {{ $customJacket->primary_color }}
**Secondary Color (Sleeves):** {{ $customJacket->secondary_color }}
**Material:** {{ $customJacket->material }}
**Front Text:** {{ $customJacket->front_text }}

@if ($customJacket->custom_details)
**Custom Details:**
{{ $customJacket->custom_details }}

@endif
@if ($customJacket->inspiration_image)
**Reference Image:** {{ asset('storage/' . $customJacket->inspiration_image) }}
@endif

## Request Details

**Submitted:** {{ $customJacket->created_at->format('F j, Y \a\t H:i A') }}
**Status:** Pending
**Request ID:** #{{ $customJacket->id }}

## Next Steps

1. Review the specifications
2. Create a detailed quote
3. Add the quote to the system
4. Admin will send quote to customer

@component('mail::button', ['url' => url('/admin')])
View in Admin Panel
@endcomponent

---
Toxaway Knitting Co. Admin
@endcomponent
