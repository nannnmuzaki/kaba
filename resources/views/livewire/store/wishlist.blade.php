<?php

namespace App\Models;

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

new
    #[Layout('components.layouts.store.app')]
    #[Title('Wishlist')]
    class extends Component {
    use WithPagination;
    use Toast;

    public string $selectedCategoryId = '';
    public bool $showLoginModal = false; // Property to control the login modal visibility
    public string $search = '';

    /**
     * Runs when the component is initialized.
     * Sets the modal to show if the user is not logged in.
     */
    public function mount(): void
    {
        if (!Auth::check()) {
            $this->showLoginModal = true;
        }
    }

    /**
     * Lifecycle hook that runs when $selectedCategoryId is updated.
     */
    public function updatedSelectedCategoryId(): void
    {
        $this->resetPage();
    }

    /**
     * Sets the selected category ID for filtering within the wishlist.
     */
    public function filterWishlistByCategory(string $categoryId): void
    {
        $this->selectedCategoryId = $categoryId;
        $this->resetPage(); // Reset pagination when category filter changes
    }

    /**
     * Removes a product from the user's wishlist.
     */
    public function toggleWishlist(string $productId): void
    {
        $user = Auth::user();

        if (!$user) {
            // Optionally, redirect to login or show a message
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

        // Find the wishlist item for this user and product
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            // Item exists, so remove it
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
            // Item does not exist, so add it
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
    }

    // Method to fetch the data for the view
    public function with(): array
    {
        $user = Auth::user();
        $productsPaginator = null;

        if ($user) {
            $productsQuery = Product::query()
                ->whereHas('wishlist', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->select(['products.id', 'products.category_id', 'products.name', 'products.price', 'products.created_at', 'products.image_path'])
                ->with([
                    'category' => function ($query) {
                        $query->select('id', 'name');
                    }
                ]);

            if (!empty($this->search)) {
                $productsQuery->where('products.name', 'like', '%' . $this->search . '%');
                // You could also search in description or other fields:
                // ->orWhere('products.description', 'like', '%' . $this->search . '%');
            }

            if ($this->selectedCategoryId) {
                $productsQuery->where('products.category_id', $this->selectedCategoryId);
            }
            $productsPaginator = $productsQuery->latest('products.created_at')->paginate(12);
        } else {
            $productsPaginator = new LengthAwarePaginator(
                collect(),
                0,
                3,
                1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        $categoriesForFilter = Category::query()
            ->select(['id', 'name'])
            ->get()
            ->map(function ($category) {
                return ['id' => $category->id, 'name' => $category->name];
            })
            ->prepend(['id' => '', 'name' => 'All Categories'])
            ->all();

        $selectedCategoryDisplayName = 'Category'; // Default text
        if ($this->selectedCategoryId) {
            // Find the category name from the $categoriesForFilter array
            $foundCategory = collect($categoriesForFilter)->firstWhere('id', $this->selectedCategoryId);
            if ($foundCategory && $foundCategory['name'] !== 'All Categories') { // Ensure it's not the "All Categories" placeholder
                $selectedCategoryDisplayName = $foundCategory['name'];
            } elseif ($foundCategory && $foundCategory['name'] === 'All Categories') {
                $selectedCategoryDisplayName = 'Category'; // Reset to default if "All Categories" is selected
            }
        }

        return [
            'products' => $productsPaginator,
            'categoriesForFilter' => $categoriesForFilter,
            'isUserLoggedIn' => (bool) $user,
            'selectedCategoryDisplayName' => $selectedCategoryDisplayName,
        ];
    }
}; ?>

<div class="flex h-full w-5/6 mx-auto flex-1 flex-col gap-4 rounded-xl">
    {{-- Login Modal for Guests --}}
    <x-mary-modal wire:model="showLoginModal" title="Login Required" persistent class="backdrop-blur-sm"
        box-class="border-1 rounded-xl border-neutral-700">
        <div class="pt-4 border-t-1 border-neutral-700">
            <p class="mb-4 text-gray-600 dark:text-gray-300 font-medium">
                Please log in to access and manage your wishlist.
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Don't have an account? You can create one easily!
            </p>
        </div>
        <x-slot:actions>
            {{-- Clicking cancel will just close the modal via wire:model --}}
            <x-mary-button label="Cancel" @click="$wire.showLoginModal = false"
                class="btn-ghost dark:text-gray-300 rounded-lg" />
            <x-mary-button label="Login" link="{{ route('login') }}" class="btn-primary rounded-lg" wire:navigate />
        </x-slot:actions>
    </x-mary-modal>

    <div class="flex flex-col sm:flex-row justify-between -mt-1 sm:-mt-3 sm:items-end">
        <x-mary-header class="mb-2! sm:mb-0! dark:text-white/90">
            <x-slot:title class="text-lg ml-2 sm:ml-0 sm:text-2xl">Wishlist</x-slot:title>
        </x-mary-header>
        <div class="flex w-full sm:w-xs gap-2 items-center">
            <flux:dropdown>
                <flux:navbar.item class="cursor-pointer" icon:trailing="chevron-down">{{ $selectedCategoryDisplayName }}
                </flux:navbar.item>
                <flux:navmenu class="dark:bg-zinc-950!">
                    @foreach ($categoriesForFilter as $category)
                        <flux:navmenu.item wire:click="filterWishlistByCategory('{{ $category['id'] }}')"
                            class="border-b-1! dark:border-neutral-700! rounded-none first:rounded-t-sm! last:rounded-b-sm! last:border-none cursor-pointer">
                            {{ $category['name'] }}
                        </flux:navmenu.item>
                    @endforeach
                </flux:navmenu>
            </flux:dropdown>
            <flux:input wire:model.live.debounce.500ms="search" class:input="dark:bg-zinc-950!" kbd="⌘K"
                icon="magnifying-glass" placeholder="Search..." />
        </div>
    </div>
    <flux:separator />

    {{-- Only show content if user is logged in --}}
    @if ($isUserLoggedIn)
        @if ($products->isEmpty())
            <div class="text-center py-10">
                <p class="text-xl text-gray-500 dark:text-gray-400">Your wishlist is currently empty.</p>
                <p class="mt-2 text-gray-400 dark:text-gray-500">Browse our products to find something you like!</p>
                <flux:button href="{{ route('home') }}" icon="building-storefront" icon:variant="outline"
                    class="mt-4 rounded-lg dark:bg-zinc-800 dark:hover:bg-zinc-700 font-medium dark:text-white/90 border-none"
                    wire:navigate>
                    Browse Product
                </flux:button>
            </div>
        @else
            <div class="w-full grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-2">
                @foreach ($products as $product)
                    <a href="{{ route('product', ['product' => $product->id]) }}" class="cursor-pointer flex w-full h-full"
                        wire:navigate>
                        <x-mary-card
                            class="p-0! pb-4! !bg-zinc-900 text-white overflow-hidden relative rounded-xl shadow-lg w-full h-full transition-all duration-250 ease-in-out dark:hover:bg-zinc-800!">
                            <x-slot:figure class="relative overflow-hidden h-48 bg-transparent">
                                <img src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://placehold.co/600x400/27272a/404040?text=No+Image' }}"
                                    alt="{{ $product->name }}" class="w-full h-full object-cover object-center rounded-t-xl" />
                            </x-slot:figure>
                            <div class="p-4 pt-2">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-base font-medium text-white/90">
                                        Rp {{ number_format($product->price, 0, '', '.') }}
                                    </span>
                                    <x-mary-button tooltip-left="Remove from wishlist" icon="s-heart"
                                        class="btn-circle btn-sm !bg-transparent !border-none text-red-500 hover:text-red-700"
                                        @mousedown.stop="$wire.toggleWishlist('{{ $product->id }}')" />
                                </div>
                                <span class="text-sm text-white/90 leading-tight">
                                    {{ $product->name }}
                                </span>
                            </div>
                        </x-mary-card>
                    </a>
                @endforeach
            </div>

            @if ($products->hasPages())
                <div class="py-4">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    @else
        {{-- This section is effectively replaced by the modal for guests.
        If the modal is closed, this area would be what's "behind" it.
        We can leave a minimal message or make it blank if the modal is persistent.
        Given the modal is persistent, guests won't see past it until they interact.
        If they cancel, they'll see this section. Let's put a simple placeholder.
        --}}
        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
            Your wishlist will appear here once you log in.
        </div>
    @endif

    <x-mary-toast />
</div>