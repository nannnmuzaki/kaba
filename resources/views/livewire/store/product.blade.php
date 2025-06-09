<?php

namespace App\Models;

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout};
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;

new
    #[Layout('components.layouts.store.app')]
    class extends Component {
    use Toast;


    public Product $product;
    public Collection $relatedProducts;

    public function rendering(View $view)
    {
        $view->title($this->product->name . ' | KABA');
    }

    /**
     * Mount the component and load the main product with its wishlist status.
     */
    public function mount(Product $product): void
    {
        $this->loadProduct($product->id); // Load with wishlist status
        $this->loadRelatedProducts();
    }

    /**
     * Load the main product with its wishlist status.
     */
    protected function loadProduct(string $productId): void
    {
        $userId = Auth::id();
        $query = Product::query();

        if ($userId) {
            $query->withExists([
                'wishlist' => fn($q) => $q->where('user_id', $userId)
            ]);
        }

        $this->product = $query->findOrFail($productId);
    }

    /**
     * Load related products with their wishlist status.
     */
    public function loadRelatedProducts(): void
    {
        $userId = Auth::id();
        $query = Product::query();

        // Add wishlist status check if user is logged in
        if ($userId) {
            $query->withExists([
                'wishlist' => fn($q) => $q->where('user_id', $userId)
            ]);
        }

        if ($this->product->category_id) {
            $query->where('category_id', $this->product->category_id)
                ->where('id', '!=', $this->product->id);
        } else {
            // Fallback if no category
            $query->where('id', '!=', $this->product->id)
                ->inRandomOrder();
        }

        $this->relatedProducts = $query->take(8)->get();

        // Ensure collection is not empty (optional, good practice)
        if ($this->relatedProducts->isEmpty() && !$this->product->category_id) {
            $this->relatedProducts = Product::where('id', '!=', $this->product->id)
                ->inRandomOrder()
                ->take(4)
                ->get(); // Try again without category filter
        }

        $this->relatedProducts = $this->relatedProducts ?? collect();
    }

    /**
     * Helper function to format price to IDR.
     */
    public function formatPrice(int $price): string
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Toggle wishlist status for a product.
     */
    public function toggleWishlist(string $productId): void
    {
        $user = Auth::user();

        if (!$user) {
            $this->toast(
                type: 'info',
                title: 'Please login',
                description: 'You need to be logged in to manage your wishlist.',
                position: 'toast-bottom',
                icon: 'o-exclamation-circle',
                timeout: 3000
            );
            return;
        }

        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $this->toast(
                type: 'success',
                title: 'Removed from Wishlist',
                position: 'toast-bottom',
                icon: 'o-check-circle',
                timeout: 3000
            );
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $this->toast(
                type: 'success',
                title: 'Added to Wishlist!',
                position: 'toast-bottom',
                icon: 'o-heart',
                timeout: 3000
            );
        }

        // --- Crucial: Refresh data after toggling ---
        $this->loadProduct($this->product->id);
        $this->loadRelatedProducts();

        // Dispatch an event if other components need to know (optional)
        $this->dispatch('wishlist-updated');
    }

    /**
     * No need for `with()` here as we are loading data into public properties.
     * Livewire will automatically pass public properties to the view.
     */
}; ?>

<div class="w-5/6 grid grid-cols-1 lg:grid-cols-2 justify-items-center gap-4 mt-2 mx-auto rounded-lg mb-4">
    <div class="overflow-hidden flex aspect-16/9 lg:aspect-4/3 rounded-lg justify-self-center lg:w-full">
        <img src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://placehold.co/600x400/27272a/404040?text=No+Image' }}"
            alt="{{ $product->name }}" class="w-full h-full rounded-lg object-cover object-center">
    </div>
    <div class="flex flex-col lg:w-full">
        <h1 class="text-lg xl:text-xl font-semibold text-zinc-800 dark:text-white/90">{{ $product->name }}</h1>
        <div class="flex flex-row gap-2 items-center mt-2">
            <span
                class="text-sm xl:text-base font-semibold text-zinc-200 bg-zinc-700 dark:bg-zinc-800 px-4 py-2 rounded-lg">{{ $this->formatPrice($product->price) }}</span>
            <x-mary-button
                tooltip-right="{{ ($product->wishlist_exists ?? false) ? 'Remove from wishlist' : 'Add to wishlist' }}"
                icon="{{ ($product->wishlist_exists ?? false) ? 's-heart' : 'o-heart' }}"
                class="product-wishlist !bg-transparent !border-none dark:hover:bg-zinc-800! rounded-lg p-1 hover:text-red-500 {{ ($product->wishlist_exists ?? false) ? 'text-red-500' : 'text-white/90' }}"
                wire:click="toggleWishlist('{{ $product->id }}')" />
        </div>
        <div
            class="prose dark:prose-invert text-xs xl:text-sm text-zinc-700 dark:text-zinc-400 mt-4 mb-4 h-min lg:h-40 xl:h-64 lg:overflow-y-scroll">
            {!! $product->html_description !!}
        </div>
        <flux:separator />
        <div class="flex flex-col sm:flex-row justify-between gap-4 mt-4">
            <div class="flex flex-row no-wrap gap-2 items-start w-full sm:w-2/3">
                <flux:icon icon="map-pin" class="text-zinc-800 dark:text-white/90 xl:size-8" />
                <p class="text-xs md:text-sm text-zinc-700 dark:text-white/70">Jl. Raya Mayjen Sungkono No.KM 5, Dusun
                    2, Blater, Kec. Kalimanah, Kabupaten Purbalingga, Jawa Tengah 53371</p>
            </div>
            <div class="flex gap-2 items-start">
                <a href="{{ $product->shopee_link }}" target="_blank"
                    class="hover:bg-zinc-800 cursor-pointer rounded-lg p-1">
                    <svg class="size-6 xl:size-9" xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                        viewBox="0 0 36 36" fill="none">
                        <path
                            d="M23.9114 26.9445C24.2564 24.126 22.4414 22.329 17.6489 20.799C15.3269 20.007 14.2334 18.969 14.2589 17.5425C14.3564 15.9585 15.8309 14.805 17.7869 14.7675C19.3273 14.7841 20.8297 15.2479 22.1114 16.1025C22.2854 16.2105 22.4069 16.1925 22.5059 16.0425C22.6409 15.8265 22.9784 15.303 23.0909 15.1125C23.1674 14.9925 23.1824 14.8335 22.9889 14.6925C22.7114 14.487 21.9329 14.07 21.5144 13.8945C20.3225 13.3901 19.0422 13.128 17.7479 13.1235C14.8829 13.1355 12.6284 14.946 12.4379 17.3625C12.3159 19.1085 13.1809 20.522 15.0329 21.603C15.4274 21.831 17.5529 22.677 18.3989 22.941C21.0599 23.769 22.4414 25.254 22.1159 26.9865C21.8204 28.557 20.1674 29.5725 17.8889 29.6025C16.0844 29.5335 14.4584 28.797 13.1984 27.8175L12.9869 27.6525C12.8309 27.5325 12.6599 27.54 12.5564 27.6975C12.4814 27.813 11.9924 28.518 11.8694 28.7025C11.7539 28.8645 11.8169 28.9545 11.9369 29.0535C12.4619 29.493 13.1624 29.973 13.6379 30.216C14.955 30.8872 16.4039 31.2595 17.8814 31.3065C18.9451 31.3571 20.0071 31.1759 20.9939 30.7755C22.6364 30.078 23.6984 28.6845 23.9114 26.9445ZM17.9999 2.1015C14.8979 2.1015 12.3689 5.0265 12.2504 8.6865H23.7479C23.6264 5.025 21.0989 2.1 17.9999 2.1M29.7764 35.997L29.6564 35.9985L5.98043 35.9955C4.36943 35.9355 3.18593 34.6305 3.02393 33.009L3.00893 32.7165L1.94843 9.4275C1.94148 9.33394 1.95368 9.23995 1.98429 9.15127C2.01489 9.06258 2.06326 8.98107 2.12644 8.91172C2.18962 8.84236 2.26628 8.78662 2.35173 8.7479C2.43718 8.70917 2.52963 8.68828 2.62343 8.6865H10.0859C10.2674 3.852 13.7399 0 17.9999 0C22.2599 0 25.7294 3.8535 25.9124 8.685H33.3644C33.4578 8.68529 33.5501 8.70451 33.6358 8.74151C33.7215 8.7785 33.7988 8.83249 33.863 8.90022C33.9272 8.96795 33.977 9.04801 34.0094 9.13554C34.0418 9.22308 34.0561 9.31628 34.0514 9.4095L32.8919 32.7915L32.8814 32.988C32.7404 34.629 31.4129 35.9535 29.7764 35.997Z"
                            fill="white" fill-opacity="0.9" />
                    </svg>
                </a>
                <a href="{{ $product->lazada_link }}" target="_blank"
                    class="hover:bg-zinc-800 cursor-pointer rounded-lg p-1">
                    <svg class="size-7 xl:size-10" xmlns="http://www.w3.org/2000/svg" width="42" height="42"
                        viewBox="0 0 42 42" fill="none">
                        <path
                            d="M30.0842 5.49516L24.4615 8.74141C22.5522 9.84391 19.446 9.83866 17.5245 8.72916L11.865 5.46191L3.9375 10.039L21.0525 19.9213L38.0625 10.1012L30.0842 5.49516Z"
                            stroke="white" stroke-opacity="0.9" stroke-width="0.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M38.0625 10.5338V27.3951L21.8452 36.7602C21.6045 36.8992 21.3314 36.9724 21.0534 36.9724C20.7754 36.9724 20.5023 36.8992 20.2615 36.7602L3.9375 27.3347V10.4717M21.0534 20.3539V36.9676"
                            stroke="white" stroke-opacity="0.9" stroke-width="0.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
                <a href="{{ $product->tokopedia_link }}" target="_blank"
                    class="hover:bg-zinc-800 cursor-pointer rounded-lg p-1 -ml-1 -mt-[2px]">
                    <svg class="size-7 xl:size-10" xmlns="http://www.w3.org/2000/svg" width="42" height="42"
                        viewBox="0 0 42 42" fill="none">
                        <path
                            d="M23.6625 11.3244C20.6613 8.78953 8.91876 9.35828 8.91876 9.35828L8.50488 37.927C8.50488 37.927 24.128 38.0443 28.9388 37.927C33.7495 37.8098 37.1121 33.9825 37.1638 31.0338C37.2154 28.085 37.1638 9.87628 37.1638 9.87628C31.163 9.1509 26.7145 9.72053 23.6625 11.3244Z"
                            stroke="white" stroke-opacity="0.9" stroke-width="0.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M17.0896 27.2549C20.4607 27.2549 23.1936 24.522 23.1936 21.1509C23.1936 17.7797 20.4607 15.0469 17.0896 15.0469C13.7184 15.0469 10.9856 17.7797 10.9856 21.1509C10.9856 24.522 13.7184 27.2549 17.0896 27.2549Z"
                            stroke="white" stroke-opacity="0.9" stroke-width="0.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M28.0376 25.6642C29.2619 26.2197 30.6475 26.3065 31.9316 25.9081C33.2157 25.5097 34.3088 24.6538 35.0036 23.5028C35.6984 22.3519 35.9466 20.9859 35.701 19.6641C35.4554 18.3423 34.7331 17.1566 33.6712 16.332C32.6094 15.5074 31.2817 15.1013 29.9403 15.1908C28.5988 15.2802 27.3369 15.8589 26.3938 16.8172C25.4508 17.7754 24.8923 19.0465 24.8244 20.3892C24.7564 21.7319 25.1837 23.0529 26.0251 24.1014M8.91887 9.35854L4.98662 12.204L4.8125 34.4483L8.505 37.9282M29.4831 9.70854C29.2186 8.14127 28.415 6.71558 27.2112 5.67766C26.0075 4.63975 24.4791 4.05478 22.8899 4.02376C21.3008 3.99274 19.7507 4.51762 18.5073 5.50777C17.264 6.49791 16.4054 7.89116 16.0799 9.44691"
                            stroke="white" stroke-opacity="0.9" stroke-width="0.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M17.9585 17.506C18.1212 17.9858 18.1067 18.5079 17.9178 18.978C17.7289 19.4481 17.378 19.835 16.9285 20.0688C16.479 20.3026 15.9607 20.3678 15.4674 20.2525C14.974 20.1373 14.5382 19.8493 14.2388 19.4406C13.8495 20.1498 13.6986 20.9653 13.8083 21.7669C13.918 22.5684 14.2826 23.3134 14.8481 23.8919C15.4137 24.4704 16.1503 24.8516 16.9492 24.9794C17.748 25.1071 18.5668 24.9746 19.2846 24.6013C20.0023 24.2281 20.5811 23.6339 20.9353 22.9066C21.2895 22.1793 21.4004 21.3573 21.2517 20.5621C21.1029 19.7668 20.7024 19.0405 20.1092 18.4904C19.5161 17.9402 18.7617 17.5954 17.9576 17.5069M30.0965 17.2041C30.3034 17.6509 30.3439 18.1569 30.2106 18.631C30.0773 19.105 29.7791 19.5158 29.3696 19.7892C28.9601 20.0627 28.4664 20.1809 27.9775 20.1224C27.4886 20.0639 27.0366 19.8327 26.7032 19.4704C26.4022 20.1977 26.343 21.0025 26.5343 21.766C26.7257 22.5295 27.1575 23.2113 27.766 23.7106C28.3744 24.21 29.1274 24.5005 29.9135 24.5392C30.6997 24.5779 31.4775 24.3627 32.1321 23.9256C32.7867 23.4884 33.2834 22.8523 33.5488 22.1113C33.8142 21.3702 33.8343 20.5635 33.6062 19.8101C33.378 19.0568 32.9137 18.3968 32.2817 17.9275C31.6497 17.4583 30.8836 17.2046 30.0965 17.2041ZM21.3158 27.4906C21.3158 25.0257 23.093 24.0238 25.4467 24.0238C27.5423 24.0238 28.7323 26.8694 28.7323 26.8694C26.6727 27.7454 24.4515 28.1774 22.2136 28.1372C23.5036 29.3344 25.1276 30.1102 26.8695 30.3615C26.8695 30.3615 26.1458 30.904 23.6626 30.904C21.6448 30.9049 21.3158 28.7585 21.3158 27.4906Z"
                            stroke="white" stroke-opacity="0.9" stroke-width="0.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M26.5273 27.623C26.5804 28.5067 26.5044 29.3934 26.3015 30.255" stroke="white"
                            stroke-opacity="0.9" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <flux:separator class="col-span-full mb-4" />
    {{-- Related Products Section --}}
    <div class="flex flex-col col-span-full w-full">
        <x-mary-header class="w-full dark:text-white/90! mb-4!" size="text-xl xl:text-2xl" title="Related Products"
            subtitle="You might also like these products" />
        <flux:separator class="mb-2 col-span-full" />
    </div>
    <div class="col-span-full w-full grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @if($relatedProducts->isNotEmpty())
            @foreach ($relatedProducts as $product)
                <a href="{{ route('product', ['product' => $product->id]) }}" class="cursor-pointer flex w-full h-full"
                    wire:navigate>
                    {{-- Product Card --}}
                    <x-mary-card
                        class="p-0! pb-4! !bg-zinc-900 text-white/90 overflow-hidden relative rounded-xl shadow-lg transition-all duration-250 ease-in-out dark:hover:bg-zinc-800! w-full h-full">
                        {{-- Product Image (Figure Slot) --}}
                        <x-slot:figure class="relative overflow-hidden h-48 bg-transparent">
                            <img src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://placehold.co/600x400/27272a/404040?text=No+Image' }}"
                                alt="{{ $product->name }}" class="w-full h-full object-cover object-center rounded-t-xl" />
                        </x-slot:figure>

                        {{-- Main Content (Default Slot) --}}
                        <div class="p-4 pt-2"> {{-- Added padding and reduced top padding to bring content closer to image --}}
                            <div class="flex items-center justify-between mb-2">
                                {{-- Price --}}
                                <span class="text-base font-medium text-white/90">
                                    Rp
                                    {{ number_format($product->price instanceof \Money\Money ? $product->price->getAmount() : $product->price, 0, '', '.') }}
                                </span>
                                <x-mary-button
                                    tooltip-left="{{ ($product->wishlist_exists ?? false) ? 'Remove from wishlist' : 'Add to wishlist' }}"
                                    icon="{{ ($product->wishlist_exists ?? false) ? 's-heart' : 'o-heart' }}"
                                    class="btn-circle btn-sm !bg-transparent !border-none hover:text-red-500 {{ ($product->wishlist_exists ?? false) ? 'text-red-500' : 'text-white/90' }}"
                                    @mousedown.stop="$wire.toggleWishlist('{{ $product->id }}')" />
                            </div>

                            {{-- Product Name --}}
                            <span class="text-sm text-white/90 leading-tight">
                                {{ $product->name }}
                            </span>
                        </div>
                    </x-mary-card>
                </a>
            @endforeach
        @endif
    </div>
    <x-mary-toast />
</div>