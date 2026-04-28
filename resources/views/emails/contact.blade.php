<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: #f4f4f7;
            font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 15px;
            color: #374151;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 580px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #6c63ff 0%, #5a55e8 100%);
            padding: 36px 40px;
            text-align: center;
        }

        .email-header .brand {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 2px;
            text-decoration: none;
        }

        .email-header .subtitle {
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            margin-top: 6px;
            letter-spacing: 0.5px;
        }

        /* Body */
        .email-body {
            padding: 40px;
        }

        .email-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .email-intro {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
            border-bottom: 1px solid #f1f1f1;
            padding-bottom: 20px;
        }

        /* Detail rows */
        .detail-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .detail-label {
            min-width: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #9ca3af;
            padding-top: 2px;
        }

        .detail-value {
            flex: 1;
            font-size: 14px;
            color: #1f2937;
            font-weight: 500;
        }

        .detail-value a {
            color: #6c63ff;
            text-decoration: none;
        }

        /* Message block */
        .message-block {
            background: #f9fafb;
            border-left: 4px solid #6c63ff;
            border-radius: 0 10px 10px 0;
            padding: 20px 22px;
            margin-top: 8px;
            font-size: 14px;
            color: #374151;
            line-height: 1.8;
            white-space: pre-line;
        }

        /* Reply CTA */
        .reply-cta {
            text-align: center;
            margin-top: 36px;
            padding-top: 24px;
            border-top: 1px solid #f1f1f1;
        }

        .reply-btn {
            display: inline-block;
            background: linear-gradient(135deg, #6c63ff, #5a55e8);
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Footer */
        .email-footer {
            background: #f9fafb;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #f1f1f1;
        }

        .email-footer p {
            font-size: 12px;
            color: #9ca3af;
            line-height: 1.7;
        }
    </style>
</head>
<body>

    <div class="email-wrapper">

        {{-- Header --}}
        <div class="email-header">
            <div class="brand">7ETTA</div>
            <div class="subtitle">New Contact Form Submission</div>
        </div>

        {{-- Body --}}
        <div class="email-body">
            <h1 class="email-title">📬 New Message Received</h1>
            <p class="email-intro">Someone has submitted the contact form on your website. Here are the details:</p>

            {{-- Name --}}
            <div class="detail-row">
                <span class="detail-label">From</span>
                <span class="detail-value">{{ $name }}</span>
            </div>

            {{-- Email --}}
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                </span>
            </div>

            {{-- Subject --}}
            <div class="detail-row">
                <span class="detail-label">Subject</span>
                <span class="detail-value">{{ $subject }}</span>
            </div>

            {{-- Message --}}
            <div class="detail-row" style="flex-direction: column;">
                <span class="detail-label" style="margin-bottom: 10px;">Message</span>
                <div class="message-block">{{ $body }}</div>
            </div>

            {{-- Reply CTA --}}
            <div class="reply-cta">
                <a href="mailto:{{ $email }}?subject=Re: {{ $subject }}" class="reply-btn">
                    ↩ Reply to {{ $name }}
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p>
                This email was sent from the <strong>7ETTA</strong> contact form.<br>
                © {{ date('Y') }} 7ETTA. All rights reserved.
            </p>
        </div>

    </div>

</body>
</html>
