<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new
    #[Layout('components.layouts.store.app')]
    #[Title('Terms of Use')]
    class extends Component {

}; ?>

<div class="prose prose-sm md:prose-base lg:prose-xl flex flex-col mx-auto px-4 py-8 text-white/90">
    <h1 class="text-lg md:text-2xl lg:text-3xl font-medium">Terms of Use</h1>
    <flux:separator />
    <div class="text-xs md:text-sm lg:text-base">
        <p>Welcome to KABA! These Terms of Use ("Terms") govern your access to and use of the KABA website located at kaba.com (the "Site"), including all content, features (such as our "SmartBuild" tool), and services offered by KABA ("we," "us," or "our"). KABA provides an online platform showcasing computer parts, offering PC build recommendations, and information about our physical retail store. Our Site also facilitates your purchase of products through our official KABA stores on third-party e-commerce platforms such as Tokopedia, Shopee, or Lazada ("Third-Party Platforms").</p>

    <p>By accessing or using our Site, you ("User," "you," "your") signify that you have read, understood, and agree to be bound by these Terms and our Privacy Policy, which is incorporated herein by reference. If you do not agree with these Terms, you must not access or use our Site.</p>

    <p>These Terms are in accordance with the applicable laws and regulations in the Republic of Indonesia.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">1. Acceptance of Terms</h2>
    <p>By using the Site, you affirm that you are at least 18 years of age or the age of legal majority in your jurisdiction and are fully able and competent to enter into the terms, conditions, obligations, affirmations, representations, and warranties set forth in these Terms, and to abide by and comply with these Terms. If you are using the Site on behalf of an organization or entity, you represent and warrant that you are authorized to agree to these Terms on their behalf and bind them to these Terms.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">2. Scope of Services</h2>
    <p>KABA offers the following services:</p>
    <ul>
        <li><strong>Product Showcase:</strong> Displaying a catalogue of computer parts with information, specifications, and images.</li>
        <li><strong>SmartBuild Feature:</strong> An interactive tool that provides users with computer build recommendations based on user-selected criteria such as CPU platform, socket, and intended workload.</li>
        <li><strong>Wishlist Functionality:</strong> Allowing users to save products of interest for future reference.</li>
        <li><strong>Information Hub:</strong> Providing details about our physical KABA retail store, including its location.</li>
        <li><strong>E-commerce Redirection:</strong> Facilitating online purchases by directing users to KABA's official stores on Third-Party Platforms (Tokopedia, Shopee, Lazada).</li>
    </ul>
    <p><strong>Important Note on Purchases:</strong></p>
    <p><strong>Online Purchases:</strong> When you choose to purchase a product online via links on our Site, you will be redirected to our official KABA store on a Third-Party Platform. All aspects of such transactions, including but not limited to order placement, payment processing, shipping, returns, and warranty claims related to that online purchase, are handled by the respective Third-Party Platform and are subject to their terms and conditions, privacy policies, and the policies of KABA's store on that specific platform.</p>
    <p><strong>Physical Store Purchases:</strong> Purchases made directly at KABA's physical retail store are subject to KABA's in-store policies, pricing, and availability at the time of purchase.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">3. Use of the Site</h2>
    <p>You agree to use the Site only for lawful purposes and in accordance with these Terms. You agree not to:</p>
    <ul>
        <li>Violate any applicable Indonesian or international law or regulation.</li>
        <li>Restrict or inhibit anyone's use or enjoyment of the Site.</li>
        <li>Use the Site in any manner that could disable, overburden, damage, or impair the Site.</li>
        <li>Use any automated device, process, or means to access the Site for any purpose without our express written permission.</li>
        <li>Introduce any viruses or other malicious or technologically harmful material.</li>
        <li>Attempt to gain unauthorized access to any parts of the Site or its related systems.</li>
        <li>Otherwise attempt to interfere with the proper working of the Site.</li>
    </ul>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">4. User Accounts</h2>
    <p>To access certain features of the Site, such as the Wishlist or saved SmartBuild configurations, you may be required to register for an account. If you create an account, you agree to:</p>
    <ul>
        <li>Provide accurate, current, and complete information.</li>
        <li>Maintain and promptly update your account information.</li>
        <li>Maintain the security of your password and accept all risks of unauthorized access to your account.</li>
        <li>Notify us immediately if you discover or otherwise suspect any security breaches related to the Site or your account.</li>
    </ul>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">5. Product Information, Pricing, and Availability</h2>
    <p>KABA strives to provide accurate and up-to-date information regarding products listed on the Site, including descriptions, specifications, and indicative pricing. However:</p>
    <p><strong>Accuracy:</strong> We do not warrant that product descriptions, pricing, images, availability, or other content on the Site are always accurate, complete, reliable, current, or error-free. Errors may occasionally occur.</p>
    <p><strong>Online Platforms:</strong> For products linked to our official stores on Third-Party Platforms, the information (including final pricing and availability) displayed on the respective Third-Party Platform at the time of purchase will prevail.</p>
    <p><strong>Physical Store:</strong> Information regarding products available at our physical store, including pricing and stock levels, may differ from that shown on the Site or on Third-Party Platforms. We recommend contacting our physical store directly for the most current information.</p>
    <p><strong>Changes:</strong> Product information, availability, and pricing are subject to change without notice.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">6. SmartBuild Feature</h2>
    <p>The "SmartBuild" feature is provided as a tool to assist you in selecting components for a computer build.</p>
    <p><strong>Informational Purposes Only:</strong> Recommendations generated by SmartBuild are for informational and guidance purposes only.</p>
    <p><strong>User Responsibility for Verification:</strong> <strong>YOU ARE SOLELY RESPONSIBLE FOR VERIFYING THE COMPATIBILITY, SUITABILITY, AND SPECIFICATIONS OF ALL COMPONENTS RECOMMENDED BY THE SMARTBUILD FEATURE BEFORE MAKING ANY PURCHASE, WHETHER ONLINE OR FROM OUR PHYSICAL STORE.</strong> This includes, but is not limited to, compatibility between CPU and motherboard, RAM specifications, power supply requirements, physical dimensions, and overall system performance for your intended use.</p>
    <p><strong>No Guarantee:</strong> KABA does not guarantee the compatibility, performance, suitability, or error-free nature of any build or component suggested by the SmartBuild feature. Component standards and availability change, and individual needs vary.</p>
    <p><strong>Availability:</strong> Components recommended by SmartBuild are not guaranteed to be in stock, either on Third-Party Platforms or at our physical store.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">7. Wishlist Feature</h2>
    <p>Our Site may offer a "Wishlist" feature allowing you to save products of interest. Adding a product to your Wishlist does not constitute a reservation or guarantee its availability or price, either at our physical store or on Third-Party Platforms.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">8. Intellectual Property Rights</h2>
    <p>The Site and its entire contents, features, and functionality (including but not limited to all information, software, text, displays, images, video, audio, and the design, selection, and arrangement thereof, including the SmartBuild tool) are owned by KABA, its licensors, or other providers of such material and are protected by Indonesian and international copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.</p>
    <p>These Terms permit you to use the Site for your personal, non-commercial use related to exploring products and services offered by KABA. You must not reproduce, distribute, modify, create derivative works of, publicly display, publicly perform, republish, download, store, or transmit any of the material on our Site without our prior written consent, except as incidentally necessary for typical web Browse.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">9. User Conduct</h2>
    <p>You agree not to post, upload, or transmit any content to or through the Site that is unlawful, infringing, defamatory, obscene, or otherwise objectionable. KABA reserves the right to remove any user-generated content and terminate user accounts for violations of these Terms.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">10. Links to Third-Party Websites</h2>
    <p>Our Site contains links that will redirect you to KABA's official stores on Third-Party Platforms (Tokopedia, Shopee, Lazada) for purchasing products. KABA has no control over, and assumes no responsibility for, the content, privacy policies, terms of use, or practices of any Third-Party Platforms. Your access and use of these Third-Party Platforms are solely at your own risk and subject to their respective terms and conditions. We encourage you to review them carefully.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">11. Disclaimers</h2>
    <p>THE SITE, ITS CONTENT (INCLUDING SMARTBUILD RECOMMENDATIONS), AND SERVICES ARE PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED.</p>
    <p>KABA HEREBY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, STATUTORY, OR OTHERWISE, INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT, AND FITNESS FOR PARTICULAR PURPOSE.</p>
    <p>NEITHER KABA NOR ANY PERSON ASSOCIATED WITH KABA MAKES ANY WARRANTY OR REPRESENTATION WITH RESPECT TO THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY, OR AVAILABILITY OF THE SITE OR ITS CONTENT. WITHOUT LIMITING THE FOREGOING, NEITHER KABA NOR ANYONE ASSOCIATED WITH KABA REPRESENTS OR WARRANTS THAT THE SITE, ITS CONTENT, OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE SITE WILL BE ACCURATE, RELIABLE, ERROR-FREE, OR UNINTERRUPTED, THAT DEFECTS WILL BE CORRECTED, OR THAT THE SITE OR THE SERVER THAT MAKES IT AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS.</p>
    <p>KABA SPECIFICALLY DISCLAIMS ANY LIABILITY FOR ISSUES ARISING FROM YOUR USE OF THE SMARTBUILD FEATURE, INCLUDING BUT NOT LIMITED TO COMPONENT INCOMPATIBILITY, UNSUITABILITY OF RECOMMENDED BUILDS, OR PERFORMANCE ISSUES. YOUR RELIANCE ON SMARTBUILD RECOMMENDATIONS IS SOLELY AT YOUR OWN RISK.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">12. Limitation of Liability</h2>
    <p>TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT WILL KABA, ITS AFFILIATES, LICENSORS, SERVICE PROVIDERS, EMPLOYEES, AGENTS, OFFICERS, OR DIRECTORS BE LIABLE FOR DAMAGES OF ANY KIND, UNDER ANY LEGAL THEORY, ARISING OUT OF OR IN CONNECTION WITH YOUR USE, OR INABILITY TO USE, THE SITE, ANY WEBSITES LINKED TO IT, ANY CONTENT ON THE SITE (INCLUDING SMARTBUILD RECOMMENDATIONS) OR SUCH OTHER WEBSITES, INCLUDING ANY DIRECT, INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING BUT NOT LIMITED TO, PERSONAL INJURY, PAIN AND SUFFERING, EMOTIONAL DISTRESS, LOSS OF REVENUE, LOSS OF PROFITS, LOSS OF BUSINESS OR ANTICIPATED SAVINGS, LOSS OF USE, LOSS OF GOODWILL, LOSS OF DATA, AND WHETHER CAUSED BY TORT (INCLUDING NEGLIGENCE), BREACH OF CONTRACT, OR OTHERWISE, EVEN IF FORESEEABLE.</p>
    <p>THIS LIMITATION OF LIABILITY DOES NOT AFFECT ANY LIABILITY THAT CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE INDONESIAN LAW.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">13. Indemnification</h2>
    <p>You agree to defend, indemnify, and hold harmless KABA, its affiliates, licensors, and service providers, and its and their respective officers, directors, employees, contractors, agents, licensors, suppliers, successors, and assigns from and against any claims, liabilities, damages, judgments, awards, losses, costs, expenses, or fees (including reasonable attorneys' fees) arising out of or relating to your violation of these Terms or your use of the Site, including, but not limited to, your reliance on any information obtained from the Site (such as SmartBuild recommendations) or your use of any services other than as expressly authorized in these Terms.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">14. Termination</h2>
    <p>We may terminate or suspend your access to all or part of the Site, without prior notice or liability, for any reason whatsoever, including without limitation if you breach these Terms. Upon termination, your right to use the Site will immediately cease. All provisions of the Terms which by their nature should survive termination shall survive termination.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">15. Governing Law and Dispute Resolution</h2>
    <p>These Terms and any dispute or claim arising out of, or related to, them shall be governed by and construed in accordance with the laws of the Republic of Indonesia, without giving effect to any choice or conflict of law provision.</p>
    <p>Any legal suit, action, or proceeding arising out of, or related to, these Terms or the Site shall be instituted exclusively in the competent courts located in Purbalingga District Court, Indonesia. You waive any and all objections to the exercise of jurisdiction over you by such courts and to venue in such courts.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">16. Changes to Terms</h2>
    <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will make reasonable efforts to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
    <p>By continuing to access or use our Site after any revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you are no longer authorized to use the Site.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">17. Severability</h2>
    <p>If any provision of these Terms is held by a court of competent jurisdiction to be invalid, illegal, or unenforceable for any reason, such provision shall be eliminated or limited to the minimum extent such that the remaining provisions of the Terms will continue in full force and effect.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">18. Entire Agreement</h2>
    <p>These Terms and our Privacy Policy constitute the sole and entire agreement between you and KABA regarding the Site and supersede all prior and contemporaneous understandings, agreements, representations, and warranties, both written and oral, regarding the Site.</p>

    <h2 class="text-sm! md:text-lg! lg:text-xl! font-bold">19. Contact Information</h2>
    <p>If you have any questions about these Terms, please contact us at:</p>
        <address>
            <span class="font-semibold">KABA</span><br>
            hello@kaba.com<br>
            Jl. Raya Mayjen Sungkono No.KM 5, Dusun 2, Blater, Kec. Kalimanah, Kabupaten Purbalingga, Jawa Tengah 53371
        </address>
    </div>
</div>