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
#[Layout('components.layouts.app')]
#[Title('Dashboard')]
class extends Component {

    use WithPagination; // Use the WithPagination trait for pagination
    use Toast;

    // Method to fetch the products data for the view
    public function with(): array
    {
        return [
            // Fetch latest products and paginate them, 3 items per page
            // This should work correctly with UUIDs now that the model is configured
            'products' => Product::latest()->paginate(3),
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
        // Remove this dd() once you confirm the method works correctly
        // dd('Delete method reached with ID: ' . $productId);

        try {
            // Find the product by its UUID and delete it
            Product::findOrFail($productId)->delete();

            // Optional: Add a success notification (using mary-ui's toast or similar)
            $this->toast(
                type: 'success',
                title: 'Product deleted!',
                description: 'The product was successfully removed.',
                position: 'toast-bottom', // Adjust position as needed
                icon: 'o-check-circle',
                timeout: 3000
            );

        } catch (ModelNotFoundException $e) {
            // Handle case where product is not found
            $this->toast(
                type: 'error',
                title: 'Deletion failed!',
                description: 'Product not found.',
                position: 'toast-bottom', // Adjust position as needed
                icon: 'o-x-circle',
                timeout: 3000
            );
        } catch (\Exception $e) {
            // Handle other potential exceptions during deletion
             $this->toast(
                type: 'error',
                title: 'Deletion failed!',
                description: 'An unexpected error occurred.',
                position: 'toast-bottom', // Adjust position as needed
                icon: 'o-x-circle',
                timeout: 3000
            );
        }

        // Reset pagination to the first page after deletion.
        // This helps ensure the table re-renders correctly with the updated data.
        $this->resetPage();
    }

    // You might need an editProduct method if you uncomment the edit button
    // public function editProduct(string $productId) // Also update this if used
    // {
    //     // Logic to open an edit modal or redirect
    //     $this->dispatch('openModal', 'product.edit', ['productId' => $productId]);
    // }
}; ?>

{{-- The Blade view code remains mostly the same as it correctly passes $product->id --}}
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    {{-- Header for the product list --}}
    <x-mary-header title="Products List" class="dark:text-white/90 mb-2!" separator/>

    {{-- Button to add a new product --}}
    <div class="flex w-full">
        <x-mary-button label="Add Product" icon="o-plus" link="{{ route('add-product') }}" class="btn-md dark:bg-zinc-900 rounded-lg border-none hover:bg-zinc-800 shrink" wire-navigate />
    </div>

    {{-- Define table headers --}}
    @php
        $headers = [
            ['key' => 'name', 'label' => 'Product Name'],
            ['key' => 'price', 'label' => 'Price'],
            ['key' => 'created_at', 'label' => 'Created At'],
            ['key' => 'actions', 'label' => 'Actions'], // Column for action buttons
        ];
    @endphp

    {{-- Render the mary-table component --}}
    {{-- Pass the defined headers and the $products data --}}
    {{-- wire:key is good practice for lists, with-pagination tells mary-table to handle pagination --}}
    <x-mary-table :headers="$headers" :rows="$products" class="text-white/90" with-pagination>
        @scope('cell_price', $product)
            {{-- Format the price using number_format for "Rp 1.000.000" style --}}
            {{-- Assuming $product->price is the numerical value or has a getAmount() method --}}
            Rp {{ number_format($product->price instanceof \Money\Money ? $product->price->getAmount() : $product->price, 0, '', '.') }}
        @endscope
        {{-- Custom scope for the 'actions' cell --}}
        @scope('cell_actions', $product)
            <div class="flex items-center space-x-2">
                {{-- Edit button (uncomment and implement editProduct if needed) --}}
                {{-- Ensure editProduct method also accepts string $productId if you use it --}}
                <x-mary-button icon="o-pencil-square" link="{{ route('edit-product', ['productId' => $product->id]) }}" spinner class="btn-sm dark:bg-zinc-950 rounded-lg border-none hover:bg-green-700" wire:navigate />

                {{-- Delete button --}}
                {{-- Calls the delete method with the product's ID (UUID string) --}}
                {{-- Note the single quotes around {{ $product->id }} for safety when passing strings --}}
                <x-mary-button icon="o-trash" wire:click="delete('{{ $product->id }}')" wire:confirm="Are you sure you want to delete this product?" spinner class="btn-sm dark:bg-zinc-950 border-none rounded-lg hover:bg-red-600" />
            </div>
        @endscope
    </x-mary-table>

    {{-- Mary UI Toast component --}}
    <x-mary-toast />
</div>
