<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kartly' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Instrument Sans', 'Helvetica Neue', Arial, sans-serif;
            background-color: #FDFDFC;
            color: #1b1b18;
            line-height: 1.6;
        }

        .email-wrapper {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .email-container {
            max-width: 680px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Brand label styles -- will be used inside the header */
        .email-brand {
            text-align: center;
            padding: 0;
        }

        .email-header .email-brand {
            margin-bottom: 8px;
        }

        .email-header .email-brand a {
            color: rgba(255, 255, 255, 0.95);
            text-decoration: none;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1px;
            display: inline-block;
            text-transform: uppercase;
            opacity: 0.95;
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #ffffff;
            padding: 50px 40px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 32px;
            margin-bottom: 8px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .email-header p {
            font-size: 15px;
            opacity: 0.95;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        /* Content */
        .email-content {
            padding: 50px 40px;
        }

        .email-content h2 {
            color: #1b1b18;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .email-content h3 {
            color: #1b1b18;
            font-size: 16px;
            margin: 25px 0 15px 0;
            font-weight: 600;
            letter-spacing: -0.2px;
        }

        .email-content p {
            margin-bottom: 16px;
            font-size: 15px;
            color: #555;
            letter-spacing: 0.2px;
            line-height: 1.7;
        }

        .email-content a {
            color: #f97316;
            text-decoration: none;
            font-weight: 500;
        }

        .email-content a:hover {
            text-decoration: underline;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background-color: #f97316;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 24px 0;
            transition: all 0.3s ease;
            font-size: 14px;
            letter-spacing: 0.3px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #ea580c;
            text-decoration: none;
        }

        /* Info Box */
        .info-box {
            background-color: #f5f5f3;
            padding: 20px 24px;
            margin: 24px 0;
            border-radius: 6px;
            border-left: 3px solid #f97316;
        }

        .info-box p {
            margin: 8px 0;
            font-size: 15px;
            color: #555;
        }

        .info-box strong {
            color: #1b1b18;
            font-weight: 600;
        }

        /* Order Details Table */
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
            font-size: 14px;
        }

        .order-table th {
            background-color: #f5f5f3;
            border-bottom: 1px solid #e5e5e2;
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            color: #1b1b18;
            font-size: 13px;
            letter-spacing: 0.3px;
        }

        .order-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e5e5e2;
            font-size: 14px;
            color: #555;
        }

        .order-table tr:last-child td {
            border-bottom: none;
        }

        .order-table tr:nth-child(even) {
            background-color: #fafaf8;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: #e5e5e2;
            margin: 32px 0;
        }

        /* Footer */
        .email-footer {
            background-color: #f5f5f3;
            border-top: 1px solid #e5e5e2;
            padding: 40px;
            text-align: center;
            font-size: 13px;
            color: #999;
        }

        .email-footer p {
            margin: 6px 0;
        }

        .email-footer a {
            color: #f97316;
            text-decoration: none;
            font-weight: 500;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        .social-links {
            margin: 16px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 12px;
            color: #f97316;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .footer-brand {
            font-weight: 600;
            color: #f97316;
            font-size: 15px;
            margin-bottom: 8px;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #999;
        }

        .text-orange {
            color: #f97316;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .highlight {
            background-color: #fff7ed;
            color: #ea580c;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 600;
        }

        /* Showcase Box */
        .showcase-box {
            background-color: #f5f5f3;
            border-radius: 6px;
            padding: 24px;
            margin: 24px 0;
            text-align: center;
        }

        .showcase-box p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .email-container {
                width: 100%;
                border-radius: 0;
            }

            .email-header {
                padding: 40px 24px;
            }

            .email-header h1 {
                font-size: 28px;
            }

            .email-header p {
                font-size: 14px;
            }

            .email-content {
                padding: 30px 24px;
            }

            .email-content h2 {
                font-size: 22px;
                margin-bottom: 16px;
            }

            .email-content h3 {
                font-size: 15px;
            }

            .email-footer {
                padding: 30px 20px;
                font-size: 12px;
            }

            .order-table th,
            .order-table td {
                padding: 12px;
                font-size: 13px;
            }

            .btn {
                padding: 12px 28px;
                font-size: 13px;
            }

            .showcase-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <!-- Brand -->
                <div class="email-brand">
                    <a href="{{ url('/') }}">Kartly</a>
                </div>
                <h1>{{ $title ?? 'Welcome to Kartly' }}</h1>
                @if (isset($subtitle))
                    <p>{{ $subtitle }}</p>
                @endif
            </div>

            <!-- Content -->
            <div class="email-content">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p class="footer-brand">Kartly</p>
                <p>© {{ now()->year }} Kartly. All rights reserved.</p>
                <div class="social-links">
                    <a href="{{ url('/') }}">Privacy Policy</a> | <a href="{{ url('/') }}">Terms</a> | <a
                        href="{{ url('/') }}">Contact Us</a>
                </div>
                <p class="text-muted" style="margin-top: 20px;">You received this email because you have an account with
                    Kartly.</p>
            </div>
        </div>
    </div>
</body>

</html>
