<?php

namespace App\Models;

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Storage;

new
    #[Layout('components.layouts.store.app')]
    #[Title('KABA')]
    class extends Component {

    use WithPagination, Toast;

    public string $selectedCategoryId = '';
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedCategoryId(): void
    {
        $this->resetPage();
    }

    public function filterByCategory(string $categoryId): void
    {
        $this->selectedCategoryId = $categoryId;
    }

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

        // The component will re-render, and the `with()` method will re-evaluate
        // `wishlist_exists` for all products, updating the UI.
    }

    public function with(): array
    {
        $userId = Auth::id();

        // Start building the product query
        $productsQuery = Product::query()
            ->select(['id', 'category_id', 'name', 'price', 'created_at', 'image_path']) // Ensure image_path is selected if used in table
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'name'); // Select id and name from categories
                }
            ]);

        if (!empty($this->search)) {
            $productsQuery->where('products.name', 'like', '%' . $this->search . '%');
            // You could also search in description or other fields:
            // ->orWhere('products.description', 'like', '%' . $this->search . '%');
        }

        if ($userId) {
            $productsQuery->withExists([
                'wishlist' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ]);
        }

        // Apply category filter if a category is selected
        if ($this->selectedCategoryId) {
            $productsQuery->where('category_id', $this->selectedCategoryId);
        }

        // Prepare categories for the filter dropdown
        // Fetches all categories and prepends an "All Categories" option
        $categoriesForFilter = Category::query()
            ->select(['id', 'name'])
            ->get()
            ->map(function ($category) {
                return ['id' => $category->id, 'name' => $category->name];
            })
            ->prepend(['id' => '', 'name' => 'All Categories']) // Use empty string ID for "All"
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
            'products' => $productsQuery->latest()->paginate(12),
            'categoriesForFilter' => $categoriesForFilter,    // Pass categories to the view for the dropdown
            'selectedCategoryDisplayName' => $selectedCategoryDisplayName, // Pass the selected category name for display
        ];
    }

}; ?>

<div class="flex h-full w-5/6 mx-auto flex-1 flex-col gap-4 rounded-xl">
    <div class="flex w-full sm:w-xs mb-1 -mt-2 gap-2 items-center">
        <flux:input wire:model.live.debounce.500ms="search" class:input="dark:bg-zinc-950!" kbd="⌘K"
            icon="magnifying-glass" placeholder="Search..." />
        <flux:dropdown>
            <flux:navbar.item class="cursor-pointer" icon:trailing="chevron-down">{{ $selectedCategoryDisplayName }}
            </flux:navbar.item>
            <flux:navmenu class="dark:bg-zinc-950!">
                @foreach ($categoriesForFilter as $category)
                    {{-- Use wire:click to call filterByCategory method --}}
                    {{-- Pass the category ID (which is $category['id'] because of the map operation) --}}
                    <flux:navmenu.item wire:click="filterByCategory('{{ $category['id'] }}')"
                        class="border-b-1! dark:border-neutral-700! rounded-none first:rounded-t-sm! last:rounded-b-sm! last:border-none cursor-pointer">
                        {{ $category['name'] }} {{-- Access 'name' key from the mapped array --}}
                    </flux:navmenu.item>
                @endforeach
            </flux:navmenu>
        </flux:dropdown>
    </div>
    <flux:separator />

    <div class="w-full grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-2">

        @foreach ($products as $product)
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
    </div>

    {{ $products->links() }}

    <x-mary-toast />

</div>