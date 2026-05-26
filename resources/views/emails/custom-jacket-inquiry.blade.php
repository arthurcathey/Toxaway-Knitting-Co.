<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      line-height: 1.5;
      color: #292524;
      background-color: #fafaf9;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
    }

    .header {
      border-bottom: 2px solid #a8a29e;
      padding-bottom: 20px;
      margin-bottom: 30px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #1c1917;
    }

    .content {
      margin-bottom: 30px;
    }

    .section-title {
      font-size: 16px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #44403c;
      margin-top: 20px;
      margin-bottom: 10px;
    }

    .detail-box {
      padding: 15px;
      background-color: #f5f5f4;
      border-radius: 4px;
      margin-bottom: 15px;
    }

    .detail-label {
      font-size: 12px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #78716e;
      margin-bottom: 5px;
    }

    .button {
      display: inline-block;
      background-color: #1c1917;
      color: white;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 4px;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 12px;
      letter-spacing: 0.5px;
    }

    .footer {
      border-top: 1px solid #d6d3d1;
      padding-top: 20px;
      margin-top: 30px;
      font-size: 12px;
      color: #78716e;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Custom Jacket Inquiry</h1>
      <p style="margin: 8px 0 0 0; color: #78716e; font-size: 14px;">We received your custom jacket request</p>
    </div>

    <div class="content">
      <p>Hi {{ $request->customer_name }},</p>
      <p>Thank you for your interest in our custom jacket service! We've received your inquiry and our team will review your specifications shortly.</p>

      <div class="section-title">Request Details</div>
      <div class="detail-box">
        <div class="detail-label">Request ID</div>
        <p style="margin: 0; font-size: 16px; font-weight: bold;">#{{ $request->id }}</p>
      </div>

      <div class="detail-box">
        <div class="detail-label">Primary Color (Body)</div>
        <p style="margin: 0;">{{ $request->primary_color }}</p>
      </div>

      <div class="detail-box">
        <div class="detail-label">Secondary Color (Sleeves)</div>
        <p style="margin: 0;">{{ $request->secondary_color }}</p>
      </div>

      @if($request->special_requests)
      <div class="detail-box">
        <div class="detail-label">Special Requests</div>
        <p style="margin: 0;">{{ $request->special_requests }}</p>
      </div>
      @endif

      <p style="margin-top: 30px;">We'll reach out within 1-2 business days with a custom quote and next steps. If you have any additional information you'd like to share, feel free to reply to this email.</p>

      <p>Thank you for choosing Toxaway Knitting Company!</p>
    </div>

    <div class="footer">
      <p>Toxaway Knitting Company<br>
        123 Craft Lane, Brevard, NC 28712<br>
        <a href="https://toxawayknitting.com" style="color: #78716e;">Visit our website</a>
      </p>
    </div>
  </div>
</body>

</html>
