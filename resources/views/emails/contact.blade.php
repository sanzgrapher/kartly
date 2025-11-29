@component('emails.layout', [
    'title' => 'New Contact Message 📧',
    'subtitle' => 'Someone reached out via your website',
])
    <h2>New Contact Message 📧</h2>
    <p>You've received a new message from your website contact form.</p>

    <div class="info-box">
        <p><strong>Contact Details:</strong></p>
        <p><strong>Name:</strong> {{ $data['name'] ?? '—' }}</p>
        <p><strong>Email:</strong> {{ $data['email'] ?? '—' }}</p>
    </div>

    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <h3>Message:</h3>
        <p style="margin: 0; line-height: 1.6;">{!! nl2br(e($data['message'] ?? '')) !!}</p>
    </div>

    <div style="background-color: #fff7ed; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
        <p style="font-size: 13px; color: #92400e; margin: 0;">
            <strong>Reply to:</strong> <a href="mailto:{{ $data['email'] ?? '' }}"
                style="color: #f97316;">{{ $data['email'] ?? '' }}</a>
        </p>
    </div>

    <p style="margin-top: 30px; font-weight: 600; color: #f97316;">The Kartly Team</p>
@endcomponent
