<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    // Method to fetch the products data for the view
    public function with(): array
    {
        return [
            // Fetch products with specific columns and eager load category name
            'products' => Product::query()
                ->select(['id', 'category_id', 'name', 'price', 'created_at']) // Select specific columns from products
                ->with([
                    'category' => function ($query) {
                        $query->select('id', 'name'); // Select id and name from categories
                    }
                ])
                ->latest() // Order by latest
                ->paginate(3), // Paginate results
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
    <div class="flex w-full">
        <x-mary-button label="Add Product" icon="o-plus" link="{{ route('add-product') }}"
            class="btn-md dark:bg-zinc-800 rounded-lg border-none hover:bg-zinc-700 shrink" wire-navigate />
    </div>

    {{-- Define table headers --}}
    @php
        $headers = [
            ['key' => 'name', 'label' => 'Product Name'],
            ['key' => 'category', 'label' => 'Category'],
            ['key' => 'price', 'label' => 'Price'],
            ['key' => 'created_at', 'label' => 'Created At'],
            ['key' => 'actions', 'label' => 'Actions'], // Column for action buttons
        ];
    @endphp

    {{-- Render the mary-table component --}}
    {{-- Pass the defined headers and the $products data --}}
    {{-- wire:key is good practice for lists, with-pagination tells mary-table to handle pagination --}}
    <x-mary-table :headers="$headers" :rows="$products" class="text-white/90" with-pagination>
        @scope('cell_category', $product)
        {{ $product->category->name ?? 'N/A' }}
        @endscope

        @scope('cell_price', $product)
        {{-- Format the price using number_format for "Rp 1.000.000" style --}}
        {{-- Assuming $product->price is the numerical value or has a getAmount() method --}}
        Rp
        {{ number_format($product->price instanceof \Money\Money ? $product->price->getAmount() : $product->price, 0, '', '.') }}
        @endscope

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