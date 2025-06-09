<?php

namespace App\Livewire\Pages; // Assuming your Volt components are in App\Livewire\Pages

use App\Models\Product; // Import the Product model
use App\Models\Wishlist; // Import the Wishlist model
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Rule};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Mary\Traits\Toast; // Import Toast trait for notifications

new
    #[Layout('components.layouts.store.app')]
    #[Title('SmartBuild - PC Recommendation')]
    class extends Component {

    use Toast; // Use the Toast trait

    // Options for the select inputs
    public array $platformOptions = [];
    public array $socketOptions = [];
    public array $allSocketOptions = [];
    public array $workloadOptions = [];
    public array $budgetOptions = [];

    // Properties to hold selected values from the form
    #[Rule('required', message: 'Please select a CPU platform.')]
    public string $platform = '';

    #[Rule('required', message: 'Please select a CPU socket.')]
    public string $socket = '';

    #[Rule('required', message: 'Please select a PC workload.')]
    public string $workload = '';

    #[Rule('required', message: 'Please select your budget.')]
    public string $budget = '';

    // Property to hold the recommendation result (product IDs or message)
    public ?array $recommendationResult = null; // Will store component_type => product_id
    public Collection $recommendedBuildDetails; // Will store collection of Product models
    public float $totalBuildPrice = 0;
    public bool $showRecommendation = false;
    public ?string $recommendationMessage = null;


    /**
     * Mount the component and initialize select options.
     */
    public function mount(): void
    {
        $this->platformOptions = [
            ['id' => 'intel', 'name' => 'Intel'],
            ['id' => 'amd', 'name' => 'AMD'],
        ];

        $this->allSocketOptions = [
            // Replace with actual product IDs from your database
            ['id' => 'LGA1700', 'name' => 'LGA1700 (Intel Alder Lake, Raptor Lake)', 'platform' => 'intel'],
            ['id' => 'LGA1200', 'name' => 'LGA1200 (Intel Comet Lake, Rocket Lake)', 'platform' => 'intel'],
            ['id' => 'AM5', 'name' => 'AM5 (AMD Ryzen 7000 Series+)', 'platform' => 'amd'],
            ['id' => 'AM4', 'name' => 'AM4 (AMD Ryzen 1000-5000 Series)', 'platform' => 'amd'],
        ];

        $this->socketOptions = [];
        $this->recommendedBuildDetails = collect(); // Initialize as empty collection

        $this->workloadOptions = [
            ['id' => 'gaming', 'name' => 'Gaming'],
            ['id' => 'content_creation', 'name' => 'Content Creation (Video Editing, 3D)'],
            ['id' => 'office_general', 'name' => 'Office Work & General Use'],
            ['id' => 'programming', 'name' => 'Programming & Development'],
            ['id' => 'ai_ml', 'name' => 'AI & Machine Learning'],
        ];

        $this->budgetOptions = [
            ['id' => '5-10jt', 'name' => 'Rp 5.000.000 - Rp 10.000.000 (Entry-Level)'],
            ['id' => '10-20jt', 'name' => 'Rp 10.000.000 - Rp 20.000.000 (Mid-Range)'],
            ['id' => '20-35jt', 'name' => 'Rp 20.000.000 - Rp 35.000.000 (High-End)'],
            ['id' => '35jt+', 'name' => 'Rp 35.000.000+ (Enthusiast)'],
        ];
    }

    /**
     * Lifecycle hook for platform changes.
     */
    public function updatedPlatform(string $value): void
    {
        $this->socketOptions = $value ? collect($this->allSocketOptions)->where('platform', $value)->values()->all() : [];
        $this->socket = '';
        $this->resetRecommendationDetails();
    }

    /**
     * Lifecycle hooks to reset recommendation when inputs change.
     */
    public function updatedSocket(): void
    {
        $this->resetRecommendationDetails();
    }
    public function updatedWorkload(): void
    {
        $this->resetRecommendationDetails();
    }
    public function updatedBudget(): void
    {
        $this->resetRecommendationDetails();
    }

    /**
     * Helper to reset recommendation display.
     */
    private function resetRecommendationDetails(): void
    {
        $this->recommendationResult = null;
        $this->recommendedBuildDetails = collect();
        $this->totalBuildPrice = 0;
        $this->showRecommendation = false;
        $this->recommendationMessage = null;
    }

    /**
     * Process the form submission and generate a recommendation using if-else.
     */
    public function recommend(): void
    {
        $this->validate();
        $this->resetRecommendationDetails(); // Clear previous results

        $platform = $this->platform;
        $socket = $this->socket;
        $workload = $this->workload;
        $budget = $this->budget;

        $productIdsForBuild = null;

        // --- Recommendation Logic (using Product IDs) ---
        // IMPORTANT: Replace 'product_id_...' with actual IDs from your products table.
        if ($platform === 'amd' && $socket === 'AM4' && $workload === 'gaming' && $budget === '5-10jt') {
            $productIdsForBuild = [
                'CPU' => 'c9d0e1f2-a3b4-5678-9012-3def12345678',
                'GPU' => 'e1f2a3b4-c5d6-7890-1234-5f1234567890',
                'RAM' => 'f2a3b4c5-d6e7-8901-2345-612345678901',
                'Motherboard' => 'd0e1f2a3-b4c5-6789-0123-4ef123456789',
                'Storage' => 'c3d4e5f6-a7b8-9012-3456-7890abcdef12',
                'PSU' => 'd4e5f6a7-b8c9-0123-4567-890abcdef123',
                'Case' => 'e5f6a7b8-c9d0-1234-5678-90abcdef1234',
            ];
        }
        // --- Add more 'else if' blocks here for other combinations ---
        elseif ($platform === 'intel' && $socket === 'LGA1700' && $workload === 'office_general' && $budget === '5-10jt') {
            $productIdsForBuild = [
                'CPU' => 'your_product_id_for_i3_12100',
                // GPU might be integrated, so no specific product ID unless you list iGPUs as products
                'RAM' => 'your_product_id_for_klevv_16gb_ram_office',
                'Motherboard' => 'your_product_id_for_h610m_motherboard',
                'Storage' => 'your_product_id_for_klevv_512gb_ssd',
                'PSU' => 'your_product_id_for_fsp_hv_550w_psu',
                'Case' => 'your_product_id_for_tecware_forge_m_case',
            ];
        }

        if ($productIdsForBuild) {
            $this->recommendationResult = $productIdsForBuild; // Store the IDs
            $this->loadRecommendedProductDetails(array_values($productIdsForBuild));
        } else {
            $this->recommendationMessage = 'Sorry, we could not find a pre-configured build for your exact combination. Please try different options or contact our sales team for a custom build.';
        }

        $this->showRecommendation = true;
    }

    /**
     * Fetch actual product details from DB based on IDs.
     */
    private function loadRecommendedProductDetails(array $productIds): void
    {
        $userId = Auth::id();
        $query = Product::query()->whereIn('id', $productIds);

        if ($userId) {
            $query->withExists([
                'wishlist' => fn($q) => $q->where('user_id', $userId)
            ]);
        }

        // Fetch products and preserve order of IDs if possible, or map them back
        $productsFound = $query->get()->keyBy('id');

        $orderedProducts = collect();
        $currentTotalPrice = 0;

        // Reconstruct the build in order with component types
        // And associate the fetched product model with its component type
        // Ensure recommendationResult is not null before iterating
        if (is_array($this->recommendationResult)) {
            foreach ($this->recommendationResult as $componentType => $productId) {
                if ($productsFound->has($productId)) {
                    $product = $productsFound->get($productId);
                    // Add component_type to the product model for display purposes in the loop
                    $product->component_type = $componentType;
                    $orderedProducts->push($product);
                    $currentTotalPrice += $product->price; // Assuming price is an integer/float
                } else {
                    // Handle case where a product ID wasn't found (optional)
                    $placeholderProduct = new Product([
                        'id' => $productId,
                        'name' => $componentType . ' - Product Not Found',
                        'price' => 0,
                        'image_path' => null
                    ]);
                    $placeholderProduct->component_type = $componentType;
                    $placeholderProduct->wishlist_exists = false; // Default
                    $orderedProducts->push($placeholderProduct);
                }
            }
        }

        $this->recommendedBuildDetails = $orderedProducts;
        $this->totalBuildPrice = $currentTotalPrice;
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
                description: 'The product has been removed from your wishlist.',
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
                description: 'The product has been added to your wishlist.',
                position: 'toast-bottom',
                icon: 'o-heart',
                timeout: 3000
            );
        }

        // Refresh the recommended build details if they are currently shown
        // to update the wishlist_exists status on the cards.
        if ($this->showRecommendation && $this->recommendationResult) {
            $this->loadRecommendedProductDetails(array_values($this->recommendationResult));
        }

        // Optionally, dispatch an event if other parts of your application
        // need to react to wishlist changes (e.g., a global wishlist counter).
        // $this->dispatch('wishlist-updated');
    }

}; ?>

<div class="flex flex-col w-5/6 mx-auto gap-4">
    <h1 class="text-lg sm:text-xl mx-auto font-semibold dark:text-white/90 mb-4 text-center">SmartBuild - PC Build Based
        on Your Needs</h1>

    <x-mary-form wire:submit="recommend"
        class="border border-neutral-200 dark:border-neutral-700 rounded-xl px-6 py-8 md:px-8 md:pb-16 lg:w-1/2 mx-auto dark:bg-zinc-950">
        {{-- CPU Platform --}}
        <x-mary-select label="CPU Platform" placeholder="Select a CPU Platform" wire:model.live="platform"
            :options="$platformOptions" class="dark:text-white/90 dark:bg-zinc-950 rounded-lg text-xs sm:text-sm"
            placeholder-value="" />

        {{-- CPU Socket --}}
        <x-mary-select label="CPU Socket"
            placeholder="{{ $platform ? 'Select a CPU Socket' : 'Select CPU Platform first' }}" wire:model.live="socket"
            :options="$socketOptions" class="dark:text-white/90 dark:bg-zinc-950 rounded-lg text-xs sm:text-sm"
            placeholder-value="" :disabled="!$platform" />

        {{-- PC Workload --}}
        <x-mary-select label="Primary PC Workload" placeholder="What will you primarily use this PC for?"
            wire:model.live="workload" :options="$workloadOptions"
            class="dark:text-white/90 dark:bg-zinc-950 rounded-lg text-xs sm:text-sm" placeholder-value="" />

        {{-- Budget --}}
        <x-mary-select label="Your Budget Range" placeholder="Select your approximate budget" wire:model.live="budget"
            :options="$budgetOptions" class="dark:text-white/90 dark:bg-zinc-950 rounded-lg text-xs sm:text-sm"
            placeholder-value="" />

        {{-- Form Actions --}}
        <x-slot:actions>
            <div class="w-full flex pt-2 sm:justify-end">
                <x-mary-button label="Give Me a Recommendation" spinner="recommend" type="submit"
                    class="bg-primary-600 hover:bg-primary-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-white/90 text-xs sm:text-sm font-semibold py-3 px-6 rounded-lg transition duration-150 ease-in-out w-full h-min sm:w-auto" />
            </div>
        </x-slot:actions>
    </x-mary-form>


    {{-- Display Recommendation Result --}}
    @if ($showRecommendation)
        <flux:separator class="mt-12" />
        <div class="w-full mx-auto"> {{-- Increased max-width for card grid --}}
            @if ($recommendationMessage)
                <div
                    class="border-zinc-200 dark:border-neutral-700 rounded-xl p-8 md:p-10 md:w-2/3 mx-auto shadow-lg mt-4 dark:bg-zinc-800">
                    <h2 class="text-sm md:text-base font-semibold dark:text-white/90 mb-2">Recommendation Status</h2>
                    <p class="text-xs md:text-sm dark:text-white/80">{{ $recommendationMessage }}</p>
                </div>
            @elseif ($recommendedBuildDetails->isNotEmpty())
                <div class="mb-6">
                    <h2 class="text-lg sm:text-xl font-semibold text-center dark:text-white/90 mb-1 text-center">Recommended PC
                        Build</h2>
                    <p class="text-center text-xs sm:text-sm dark:text-zinc-400 mb-6">This build is tailored to your selections.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($recommendedBuildDetails as $product)
                        <a href="{{ route('product', ['product' => $product->id]) }}" class="cursor-pointer flex w-full h-full"
                            wire:navigate>
                            {{-- Product Card --}}
                            <x-mary-card
                                class="p-0! pb-4! bg-zinc-900! text-white/90 overflow-hidden relative rounded-xl shadow-lg w-full h-full transition-all duration-250 ease-in-out dark:hover:bg-zinc-800!">
                                {{-- Product Image (Figure Slot) --}}
                                <x-slot:figure class="relative overflow-hidden h-48 bg-transparent">
                                    <img src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://placehold.co/600x400/27272a/404040?text=No+Image' }}"
                                        alt="{{ $product->name }}" class="w-full h-full object-cover object-center rounded-t-xl" />
                                </x-slot:figure>

                                {{-- Main Content (Default Slot) --}}
                                <div class="p-4 pt-2"> {{-- Added padding and reduced top padding to bring content closer to image
                                    --}}
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
                </div>

                <flux:separator class="mt-10" />

                <div class="mt-8 border-neutral-700">
                    <h3 class="text-sm md:text-base font-medium dark:text-white/90">
                        Total Estimated Build Price:
                        <span class="text-white/90">{{ $this->formatPrice($totalBuildPrice) }}</span>
                    </h3>
                </div>
                <p class="mt-2 text-xs dark:text-zinc-400">
                    *Component prices are estimates and subject to change.
                </p>
            @endif
        </div>
    @endif

    <x-mary-toast />
</div>