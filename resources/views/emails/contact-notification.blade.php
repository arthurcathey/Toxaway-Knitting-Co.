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
      background-color: #f5f5f4;
      padding: 20px;
      border-radius: 4px;
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
      border-left: 4px solid #1c1917;
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

    .message-box {
      padding: 20px;
      background-color: #fafaf9;
      border: 1px solid #e7e5e4;
      border-radius: 4px;
      font-style: italic;
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
      <h1>New Contact Form Submission</h1>
      <p style="margin: 8px 0 0 0; color: #78716e; font-size: 14px;">Subject: {{ $subject }}</p>
    </div>

    <div class="content">
      <div class="section-title">Sender Information</div>
      <div class="detail-box">
        <div class="detail-label">Name</div>
        <p style="margin: 0;">{{ $name }}</p>
      </div>

      <div class="detail-box">
        <div class="detail-label">Email</div>
        <p style="margin: 0;"><a href="mailto:{{ $email }}">{{ $email }}</a></p>
      </div>

      @if($phone)
      <div class="detail-box">
        <div class="detail-label">Phone</div>
        <p style="margin: 0;"><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
      </div>
      @endif

      <div class="section-title">Message</div>
      <div class="message-box">
        {!! nl2br(e($message)) !!}
      </div>

      <p style="margin-top: 30px;">
        <a href="mailto:{{ $email }}?subject=Re: {{ urlencode($subject) }}" style="display: inline-block; background-color: #1c1917; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 12px;">REPLY TO {{ $name }}</a>
      </p>
    </div>

    <div class="footer">
      <p>This is an automated notification from your website contact form.<br>
        Do not reply to this email address.</p>
    </div>
  </div>
</body>

</html>
