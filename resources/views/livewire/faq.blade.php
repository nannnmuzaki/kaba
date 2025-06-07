<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new
    #[Layout('components.layouts.store.app')]
    #[Title('FAQ')]
    class extends Component {

}; ?>

<div class="prose prose-sm md:prose-base lg:prose-xl flex flex-col mx-auto px-4 py-8 text-white/90">
    <h1 class="text-lg md:text-2xl lg:text-3xl font-medium">Frequently Asked Questions</h1>
    <flux:separator />
    <div class="text-xs md:text-sm lg:text-base">
        <p>Here are some frequently asked questions to help you get the most out of your KABA experience.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">About KABA</h2>

        <p><strong>1. What is KABA?</strong></p>
        <p>KABA is your premier online destination for discovering and comparing computer parts. We provide detailed
            information and specifications to help you build or upgrade your PC. Our key feature, "SmartBuild," offers
            tailored PC build recommendations based on your specific needs. We also guide you to purchase these products
            from our official KABA stores on trusted e-commerce platforms like Tokopedia, Shopee, or Lazada, and provide
            details for our physical retail store.</p>

        <p><strong>2. How is KABA different from other e-commerce sites?</strong></p>
        <p>KABA specializes in providing in-depth product information and expert build recommendations. While you browse
            and configure on our site, online purchases are securely completed through our official stores on major
            e-commerce platforms like Tokopedia, Shopee, or Lazada. This ensures you benefit from their robust
            transaction systems while we focus on product expertise. You also have the option to visit our physical
            store.</p>

        <p><strong>3. Why does KABA link to Tokopedia, Shopee, or Lazada for online purchases?</strong></p>
        <p>We partner with these leading e-commerce platforms for your online purchases because they offer secure and
            reliable systems for payment processing, order fulfillment, and customer service. This ensures a smooth and
            trusted transaction experience.</p>

        <p><strong>4. Does KABA have a physical store?</strong></p>
        <p>Yes, KABA has a physical retail store. You can find our store location details on our product pages and our
            "Contact Us" section. While you are welcome to visit our store, our website also facilitates convenient
            online purchasing by directing you to our official KABA stores on Tokopedia, Shopee, and Lazada.</p>

        <p><strong>5. Can I buy products directly from the KABA physical store?</strong></p>
        <p>Absolutely! You can visit our physical store to browse products, get advice from our team, and make purchases
            directly, subject to in-store availability. Our website also offers the flexibility of purchasing online
            through our official stores on Tokopedia, Shopee, and Lazada.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Products</h2>

        <p><strong>6. Is the product information on KABA accurate?</strong></p>
        <p>We dedicate significant effort to ensuring the accuracy and currency of all product information, including
            specifications and descriptions, on our site. However, we always recommend verifying the latest details on
            the respective Tokopedia, Shopee, or Lazada product page before completing an online purchase, or by
            inquiring with our team at the physical store.</p>

        <p><strong>7. Is the pricing on KABA the final price?</strong></p>
        <p>Prices displayed on KABA are continuously updated but are subject to change. The final price for any online
            purchase will be the one listed on our official KABA store page on Tokopedia, Shopee, or Lazada at the
            moment of your transaction. Prices at our physical store may also differ due to location-specific promotions
            or operational factors.</p>

        <p><strong>8. How do I know if a product is in stock?</strong></p>
        <p>For online purchases, product availability is managed by our official KABA stores on Tokopedia, Shopee, and
            Lazada. The most accurate stock information will be displayed on the product page once you are on one of
            these platforms. For availability at our physical store, we recommend contacting the store directly or
            visiting.</p>

        <p><strong>9. Are prices and availability the same online (Tokopedia/Shopee/Lazada) and at the KABA physical
                store?</strong></p>
        <p>Prices, promotions, and stock availability can sometimes differ between our online stores on Tokopedia,
            Shopee, Lazada, and our physical retail store. We recommend checking the specific platform for online
            purchases or inquiring at our physical store for the most current information.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">SmartBuild Feature</h2>

        <p><strong>10. What is the "SmartBuild" feature?</strong></p>
        <p>SmartBuild is an innovative tool on the KABA website designed to simplify your PC building process. It
            provides personalized PC part recommendations based on your requirements, such as your preferred CPU
            platform (AMD/Intel), CPU socket (e.g., AM4, AM5), and your primary usage (e.g., gaming, professional
            rendering, office work).</p>

        <p><strong>11. How does SmartBuild work?</strong></p>
        <p>Simply input your preferences for CPU platform, socket, and intended workload into the SmartBuild interface.
            Our system then analyzes your needs and suggests a curated list of compatible components—including CPU,
            motherboard, RAM, GPU, storage, and power supply—from our extensive product catalogue.</p>

        <p><strong>12. Are the "SmartBuild" recommendations guaranteed to be compatible or the best possible
                build?</strong></p>
        <p>SmartBuild recommendations are provided as an expert starting point to help guide your component selection.
            While we design the tool to aim for compatibility based on common standards, it is crucial that you
            independently verify the compatibility and suitability of all parts before making any purchase. PC
            technology is complex and constantly evolving. KABA is not liable for any incompatibility issues or if a
            specific build does not meet unique performance expectations. Your own research and due diligence are
            essential.</p>

        <p><strong>13. How can I purchase parts recommended by "SmartBuild"?</strong></p>
        <p>SmartBuild will provide you with a list of recommended components. To purchase these online, you can add them
            to your Wishlist and then use the links on our product pages to find them in our official KABA stores on
            Tokopedia, Shopee, or Lazada. Alternatively, you can note down the parts list and inquire about their
            availability at our physical KABA store.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Wishlist Feature</h2>

        <p><strong>14. What is the Wishlist feature?</strong></p>
        <p>The Wishlist feature on KABA allows you to save and organize products from our catalogue that you are
            interested in. This makes it easy to revisit your selections, compare items, and plan your purchases.</p>

        <p><strong>15. Does adding a product to my Wishlist reserve it or guarantee the price?</strong></p>
        <p>Adding an item to your Wishlist is a convenient way to save it for later viewing but does not constitute a
            reservation of the product or a guarantee of its price. Product availability and pricing are subject to
            change without notice, both on our online partner platforms and at our physical store.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Purchasing Process (Online)</h2>

        <p><strong>16. How do I buy a product online that's listed on KABA?</strong></p>
        <ol>
            <li>Explore our product catalogue or use SmartBuild for recommendations.</li>
            <li>Add desired items to your Wishlist for easy tracking.</li>
            <li>From a product detail page or your Wishlist, click the provided link to view the product on Tokopedia,
                Shopee, or Lazada.</li>
            <li>You will be directed to the product page within KABA's official store on that platform.</li>
            <li>Add the product to your cart on the chosen platform and complete your purchase using their secure
                checkout process.</li>
        </ol>

        <p><strong>17. What payment methods can I use for online purchases?</strong></p>
        <p>All online payments are securely processed through our official stores on Tokopedia, Shopee, or Lazada. These
            platforms typically offer a wide range of payment methods common in Indonesia, including bank transfers,
            virtual accounts, credit/debit cards, and various e-wallets. Please check the available options during
            checkout on their respective platforms.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Orders & Shipping (Online Purchases)</h2>

        <p><strong>18. Who handles my order once I'm redirected for an online purchase?</strong></p>
        <p>Once you complete your purchase through our official KABA store on Tokopedia, Shopee, or Lazada, that
            specific platform, in conjunction with our store team there, will handle all aspects of your order
            processing, payment confirmation, and shipping.</p>

        <p><strong>19. How can I track my online order?</strong></p>
        <p>After placing an order on Tokopedia, Shopee, or Lazada, you will receive order confirmation and shipment
            tracking information directly from that platform. You can typically track your order's progress through your
            account on their website or mobile application.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Returns & Warranties (Online Purchases)</h2>

        <p><strong>20. What is the return policy for online purchases?</strong></p>
        <p>Return policies for online purchases are governed by the terms and conditions of the Third-Party Platform
            (Tokopedia, Shopee, or Lazada) where you made your purchase, as well as the specific policies of our
            official KABA store on that platform. Please review these policies carefully before completing your
            purchase. All return requests should be initiated through the platform where the transaction occurred.</p>

        <p><strong>21. How do product warranties work for online purchases?</strong></p>
        <p>Product warranties are typically provided by the product manufacturer or distributor. These warranties are
            managed through our official KABA stores on Tokopedia, Shopee, or Lazada, in accordance with the terms
            specified for each product. Please check the warranty information provided on the product page on the
            respective platform for details on coverage and claims procedures.</p>

        <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">Privacy & Security</h2>

        <p><strong>22. Is my personal information safe with KABA?</strong></p>
        <p>Protecting your privacy is a priority at KABA. We handle any data you provide, such as SmartBuild preferences
            or Wishlist items, in accordance with our <a href="/privacy-policy">Privacy Policy</a>. For online
            purchases, KABA does not collect or store your payment information, as these transactions are securely
            managed by our partner platforms (Tokopedia, Shopee, Lazada).</p>

        <p><strong>23. Is it safe to make payments when I'm redirected for online purchases?</strong></p>
        <p>Yes, it is very safe. When you are redirected to our official stores on Tokopedia, Shopee, or Lazada, you are
            using their highly secure and encrypted payment gateways. These are established e-commerce leaders in
            Indonesia that employ robust security measures to protect your financial information.</p>

        <p>Should you have any further questions, please don't hesitate to visit our <a href="{{ route('contact-us') }}"
                wire:navigate>Contact Us</a> or visit
            our physical store!</p>
    </div>
</div>