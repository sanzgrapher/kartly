@component('emails.layout', ['title' => 'Verify Your Email Address', 'subtitle' => 'Complete your registration'])
    <h2>Hello {{ $user->name }}!</h2>

    <p>Thanks for signing up with Kartly! To complete your registration and start shopping, please verify your email address
        by clicking the button below.</p>

    <div class="text-center">
        <a href="{{ $verificationUrl }}" class="btn"
            style="background-color: #f97316; color: #ffffff; text-decoration: none; display: inline-block; padding: 14px 32px; border-radius: 6px; font-weight: 600; font-size: 14px;">Verify
            Email Address</a>
    </div>

    <p>This verification link will expire in 60 minutes.</p>

    <div class="info-box">
        <p><strong>If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into
                your web browser:</strong></p>
        <p style="word-break: break-all; color: #6B7280;">{{ $verificationUrl }}</p>
    </div>

    <p>If you did not create an account, no further action is required.</p>

    <div class="divider"></div>

    <p>Thanks,<br>
        The Kartly Team</p>
@endcomponent
