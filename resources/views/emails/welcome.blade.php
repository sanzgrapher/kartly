@component('emails.layout', ['title' => 'Welcome to Kartly', 'subtitle' => 'We\'re excited to have you!'])
    <h2>Hello {{ $user->name }}! 👋</h2>
    <p>Welcome to <strong>Kartly</strong>, your new favorite online store. We're thrilled to have you as part of our
        community and can't wait to help you find exactly what you're looking for!</p>

    <div class="info-box">
        <p><strong>✨ Here's what you can do now:</strong></p>
        <p>🛍️ Browse our amazing collection of products</p>
        <p>🛒 Add items to your cart and checkout</p>
        <p>💝 Enjoy exclusive discounts and special offers</p>
        <p>📦 Track your orders in real-time</p>
    </div>

    <p>If you have any questions or need help with anything, don't hesitate to reach out to our support team. We're always
        here to help!</p>

    <p style="margin-top: 30px;">Happy shopping! 🎉</p>
    <p style="margin-top: 20px; font-weight: 600; color: #f97316;">The Kartly Team</p>
@endcomponent
