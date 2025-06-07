<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new
    #[Layout('components.layouts.store.app')]
    #[Title('Contact Us')]
    class extends Component {

}; ?>

<div class="prose prose-sm md:prose-base lg:prose-xl flex flex-col mx-auto px-4 py-8 text-white/90">
    <h1 class="text-lg md:text-2xl lg:text-3xl font-medium">Contact Us</h1>
    <flux:separator />
    <div class="text-xs md:text-sm lg:text-base">
        <p>We're here to help! Whether you have a question about our products, need assistance with our "SmartBuild"
            feature, want to inquire about stock at our physical store, or have any other queries, please don't hesitate
            to get in touch. Our team is dedicated to providing you with the best possible service.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Visit Our Store</h2>
        <p>Come and explore our range of computer parts in person, or get expert advice from our friendly staff.</p>

        <h4>KABA Computer Store</h4>
        <address>
            Jl. Raya Mayjen Sungkono No.KM 5, Dusun 2, Blater, Kec. Kalimanah, Kabupaten Purbalingga, Jawa Tengah
            53371
        </address>

        <h4>Store Operating Hours:</h4>
        <ul>
            <li>Monday - Friday: 8:00 AM - 8:00 PM WIB</li>
            <li>Saturday - Sunday: 8:00 AM - 6:00 PM WIB</li>
        </ul>

        <h4>KABA Online Store</h4>
        <ul>
            <li>Tokopedia Store: <a href="https://tokopedia.com/kaba" target="_blank"
                    rel="noopener noreferrer">tokopedia.com/kaba</a></li>
            <li>Shopee Store: <a href="https://shopee.co.id/kaba" target="_blank"
                    rel="noopener noreferrer">shopee.com/kaba</a></li>
            <li>Lazada Store: <a href="https://lazada.co.id/shop/kaba" target="_blank"
                    rel="noopener noreferrer">lazada.com/kaba</a></li>
        </ul>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Get In Touch Online</h2>
        <h4>General Inquiries & Customer Support:</h4>
        <ul>
            <li>Email: <a href="mailto:hello@kaba.com">hello@kaba.com</a></li>
            <li>Phone: <a href="tel:+628123456789">+628123456789</a></li>
            <li>WhatsApp Business: <a href="https://wa.me/628123456789">+628123456789</a></li>
        </ul>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Connect With Us on Social Media</h2>
        <p>Stay updated with our latest products, promotions, and tech tips!</p>
        <ul>
            <li>Twitter: <a href="https://twitter.com/kaba" target="_blank"
                    rel="noopener noreferrer">twitter.com/kaba</a></li>
            <li>Facebook: <a href="https://facebook.com/kaba" target="_blank"
                    rel="noopener noreferrer">facebook.com/kaba</a></li>
            <li>Instagram: <a href="https://instagram.com/kaba" target="_blank"
                    rel="noopener noreferrer">instagram.com/kaba</a></li>
        </ul>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Looking for quick answers?</h2>
        <p>You might find what you need on our <a href="{{ route('faq') }}" wire:navigate>FAQ page</a>.</p>

        <p>We look forward to hearing from you!</p>
    </div>
</div>