@component('emails.layout', [
    'title' => 'Reset Your Password',
    'subtitle' => 'Secure password reset for your account',
])
    <h2>Hello {{ $user->name }}!</h2>

    <p>You are receiving this email because we received a password reset request for your account.</p>

    <div class="text-center">
        <a href="{{ $resetUrl }}" class="btn"
            style="background-color: #f97316; color: #ffffff; text-decoration: none; display: inline-block; padding: 14px 32px; border-radius: 6px; font-weight: 600; font-size: 14px;">Reset
            Password</a>
    </div>

    <p>This password reset link will expire in 60 minutes.</p>

    <div class="info-box">
        <p><strong>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web
                browser:</strong></p>
        <p style="word-break: break-all; color: #6B7280;">{{ $resetUrl }}</p>
    </div>

    <p>If you did not request a password reset, no further action is required.</p>

    <div class="divider"></div>

    <p>Thanks,<br>
        The Kartly Team</p>
@endcomponent
