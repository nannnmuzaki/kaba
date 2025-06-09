<?php

namespace App\Models;

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mary\Traits\Toast;

new
    #[Layout('components.layouts.dashboard.app')]
    #[Title('Dashboard')]
    class extends Component {

    use WithPagination; // Use the WithPagination trait for pagination
    use Toast;

    public string $search = '';
    public string $selectedCategoryId = ''; // Holds the selected category ID for filtering
    public int $perPage = 10; // Number of items per page for pagination

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

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    // Method to fetch the products data for the view
    public function with(): array
    {
        // Start building the product query
        $productsQuery = Product::query()
            ->select(['id', 'category_id', 'name', 'price', 'created_at']) // Ensure image_path is selected if used in table
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'name'); // Select id and name from categories
                }
            ])
            ->orderBy(...array_values($this->sortBy));
        ;

        if (!empty($this->search)) {
            $productsQuery->where('products.name', 'like', '%' . $this->search . '%');
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
            'products' => $productsQuery->latest()->paginate($this->perPage),
            'categoriesForFilter' => $categoriesForFilter,    // Pass categories to the view for the dropdown
            'selectedCategoryDisplayName' => $selectedCategoryDisplayName, // Pass the selected category name for display
        ];
    }

    /**
     * Method to handle product deletion.
     * Accepts the product ID (UUID string) as a parameter.
     *
     * @param string $productId The UUID of the product to delete.
     */
    public function delete(string $productId) // Corrected parameter type hint and name
    {

        try {
            // Find the product by its UUID and delete it
            Product::findOrFail($productId)->delete();

            $this->toast(
                type: 'success',
                title: 'Product deleted!',
                description: 'The product was successfully removed.',
                position: 'toast-bottom',
                icon: 'o-check-circle',
                timeout: 3000
            );

        } catch (ModelNotFoundException $e) {
            // Handle case where product is not found
            $this->toast(
                type: 'error',
                title: 'Deletion failed!',
                description: 'Product not found.',
                position: 'toast-bottom',
                icon: 'o-x-circle',
                timeout: 3000
            );
        } catch (\Exception $e) {
            // Handle other potential exceptions during deletion
            $this->toast(
                type: 'error',
                title: 'Deletion failed!',
                description: 'An unexpected error occurred.',
                position: 'toast-bottom',
                icon: 'o-x-circle',
                timeout: 3000
            );
        }

        // Reset pagination to the first page after deletion.
        // This helps ensure the table re-renders correctly with the updated data.
        $this->resetPage();
    }

}; ?>

{{-- The Blade view code remains mostly the same as it correctly passes $product->id --}}
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    {{-- Header for the product list --}}
    <x-mary-header title="Products List" subtitle="Manage your products" class="dark:text-white/90 mb-2!" separator />

    {{-- Button to add a new product --}}
    <div class="flex w-full justify-between">
        <x-mary-button label="Add Product" icon="o-plus" link="{{ route('add-product') }}"
            class="btn-md dark:bg-zinc-800 rounded-lg border-none hover:bg-zinc-700 shrink" wire-navigate />

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

    <div class="flex w-full mb-1 gap-2 items-center">
        <flux:input wire:model.live.debounce.500ms="search" class:input="dark:bg-zinc-950!" kbd="⌘K"
            icon="magnifying-glass" placeholder="Search..." />
    </div>

    {{-- Define table headers --}}
    @php
        $headers = [
            ['key' => 'name', 'label' => 'Product Name'],
            ['key' => 'category', 'label' => 'Category', 'sortable' => false],
            ['key' => 'price', 'label' => 'Price', 'sortBy' => 'price'],
            ['key' => 'created_at', 'label' => 'Created At', 'sortBy' => 'created_at'],
            ['key' => 'actions', 'label' => 'Actions', 'sortable' => false], // Column for action buttons
        ];
    @endphp

    {{-- Render the mary-table component --}}
    <x-mary-table :headers="$headers" :rows="$products" :sort-by="$sortBy" class="text-zinc-800 dark:text-white/90"
        with-pagination per-page="perPage">

        @scope('cell_price', $product)
        {{-- Format the price using number_format for "Rp 1.000.000" style --}}
        {{-- Assuming $product->price is the numerical value or has a getAmount() method --}}
        Rp
        {{ number_format($product->price instanceof \Money\Money ? $product->price->getAmount() : $product->price, 0, '', '.') }}
        @endscope

        @scope('cell_category', $product)
        {{-- Display the category name --}}
        {{ $product->category->name ?? 'Uncategorized' }}
        @endscope

        @scope('cell_created_at', $product)
        {{-- Format the created_at date --}}
        {{ $product->created_at->format('d/m/Y') }}<br>
        {{ $product->created_at->format('H:i:s') }}
        @endscope

        {{-- Custom scope for the 'name' cell --}}

        {{-- Custom scope for the 'actions' cell --}}
        @scope('cell_actions', $product)
        <div class="flex items-center space-x-2">
            <x-mary-button icon="o-pencil-square" link="{{ route('edit-product', ['productId' => $product->id]) }}"
                spinner class="btn-sm dark:bg-zinc-950 rounded-lg border-none hover:bg-green-700" wire:navigate />
            <x-mary-button icon="o-trash" wire:click="delete('{{ $product->id }}')"
                wire:confirm="Are you sure you want to delete this product?" spinner
                class="btn-sm dark:bg-zinc-950 border-none rounded-lg hover:bg-red-600" />
        </div>
        @endscope
    </x-mary-table>

    {{-- Mary UI Toast component --}}
    <x-mary-toast />
</div>