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

    .order-item {
      padding: 15px;
      background-color: #f5f5f4;
      border-left: 4px solid #1c1917;
      margin-bottom: 10px;
    }

    .item-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .summary {
      background-color: #f5f5f4;
      padding: 20px;
      border-radius: 4px;
      margin: 20px 0;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 14px;
    }

    .summary-total {
      font-size: 18px;
      font-weight: bold;
      border-top: 1px solid #d6d3d1;
      padding-top: 10px;
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
      <h1>Order Confirmation</h1>
      <p style="margin: 8px 0 0 0; color: #78716e; font-size: 14px;">Thank you for your order!</p>
    </div>

    <div class="content">
      <p>Hi there,</p>
      <p>We've received your order and it's being prepared for shipment. Here are your order details:</p>

      <div class="section-title">Order Number</div>
      <p style="font-size: 18px; font-weight: bold; margin: 10px 0;">{{ $order->order_number }}</p>

      <div class="section-title">Order Items</div>
      @foreach($items as $item)
      <div class="order-item">
        <div class="item-row">
          <strong>{{ $item->product_name }}</strong>
          <strong>${{ number_format($item->price, 2) }}</strong>
        </div>
        <div class="item-row">
          <span>Size: {{ $item->size }}</span>
          <span>Qty: {{ $item->quantity }}</span>
        </div>
      </div>
      @endforeach

      <div class="summary">
        <div class="summary-row">
          <span>Subtotal:</span>
          <strong>${{ number_format($order->subtotal, 2) }}</strong>
        </div>
        <div class="summary-row">
          <span>Shipping:</span>
          <strong>${{ number_format($order->shipping_cost, 2) }}</strong>
        </div>
        <div class="summary-row summary-total">
          <span>Total:</span>
          <strong>${{ number_format($order->total, 2) }}</strong>
        </div>
      </div>

      <div class="section-title">Shipping Address</div>
      <p style="margin: 10px 0; line-height: 1.6;">
        {{ $order->shipping_name }}<br>
        {{ $order->shipping_address }}<br>
        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
        {{ $order->shipping_phone }}
      </p>

      <p style="margin-top: 30px;">We'll send you a tracking number as soon as your order ships. If you have any questions, please don't hesitate to reach out at <a href="mailto:support@toxawayknitting.com">support@toxawayknitting.com</a>.</p>
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
