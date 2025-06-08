<?php

use App\Models\Product;
use App\Models\Category;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Rule};
use Livewire\WithFileUploads; // Trait for file uploads
use Mary\Traits\Toast; // For notifications
use Illuminate\Support\Facades\Storage;

new
    #[Layout('components.layouts.dashboard.app')] // Use the same layout
    #[Title('Edit Product')] // Change title to reflect editing
    class extends Component {
    use WithFileUploads; // Enable file uploads
    use Toast; // Enable toast notifications

    // Property to store the product being edited
    public Product $product;

    // Public properties to bind form inputs
    #[Rule('required|string|max:255')] // Validation rules for name
    public string $name = '';

    #[Rule('required|numeric|min:0')] // Validation rules for price
    public float $price = 0.0;

    #[Rule('required|exists:categories,id')] // Validation rules for category
    public string $category_id = '';

    #[Rule('required|string')] // Validation rules for description
    public ?string $description = '';

    #[Rule('nullable|url|max:2048')]
    public ?string $tokopedia_link = null;

    #[Rule('nullable|url|max:2048')]
    public ?string $shopee_link = null;

    #[Rule('nullable|url|max:2048')]
    public ?string $lazada_link = null;

    #[Rule('nullable|image|max:1024')] // Make photo optional for editing
    public $photo = null; // Property to hold a new uploaded file

    // Current image path to display existing image
    public ?string $currentImage = null;

    /**
     * Initialize the component with existing product data.
     */
    public function mount($productId)
    {
        // Find the product by ID or fail with a 404
        $this->product = Product::findOrFail($productId);

        // Fill the form with existing product data
        $this->name = $this->product->name;
        $this->price = $this->product->price;
        $this->category_id = $this->product->category_id;
        $this->description = $this->product->description;
        $this->tokopedia_link = $this->product->tokopedia_link;
        $this->shopee_link = $this->product->shopee_link;
        $this->lazada_link = $this->product->lazada_link;
        $this->currentImage = $this->product->image_path;
    }

    /**
     * Method to handle form submission and update the product.
     */
    public function update()
    {
        // Validate the form inputs
        $validatedData = $this->validate();

        // Update the product with new data
        $this->product->name = $validatedData['name'];
        $this->product->price = $validatedData['price'];
        $this->product->category_id = $validatedData['category_id'];
        $this->product->description = $validatedData['description'];
        $this->product->tokopedia_link = $validatedData['tokopedia_link'];
        $this->product->shopee_link = $validatedData['shopee_link'];
        $this->product->lazada_link = $validatedData['lazada_link'];

        // Handle file upload if a new photo was provided
        if ($this->photo) {
            // Store the new file in the 'public/products' directory
            $this->product->image_path = $this->photo->store('products', 'public');
        }

        // Save the updated product to the database
        $this->product->save();

        // Show a success notification
        $this->toast(
            type: 'success',
            title: 'Product updated!',
            description: 'The product has been updated successfully.',
            position: 'toast-bottom',
            icon: 'o-check-circle',
            timeout: 3000
        );

        // Optional: Redirect to product listing after update
        return $this->redirect(route('dashboard'), navigate: true);
    }

    /**
     * The Blade view for the component.
     */
    public function with(): array
    {
        $categories = Category::get()->map(function ($category) {
            return ['id' => $category->id, 'name' => $category->name];
        })->all();

        $config = [
            'toolbar' => ['heading', 'bold', 'italic', '|', 'quote', 'unordered-list', 'ordered-list', 'link', '|', 'preview'],
            'maxHeight' => '200px',
            'spellChecker' => false, // Disables the spell checker
            'nativeSpellcheck' => false, // Disables browser's native spell check within MDE
            'uploadImage' => false,
        ];

        return [
            'categories' => $categories,
            'config' => $config, // Configuration for the Markdown editor
        ];
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    {{-- Header for the edit product page --}}
    <x-mary-header title="Edit Product" class="dark:text-white/90 mb-2!" separator />

    {{-- Form for editing a product --}}
    {{-- wire:submit="update" calls the update method on form submission --}}
    <x-mary-form wire:submit="update">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Product Name Input --}}
            <x-mary-input label="Product Name" wire:model="name" placeholder="Enter product name"
                class="dark:text-white/90 dark:bg-zinc-950 rounded-md autofill:dark:bg-zinc-900" />

            {{-- Product Price Input --}}
            <x-mary-input label="Price" wire:model="price" prefix="Rp" locale="id-ID" placeholder="Enter price"
                class="dark:text-white/90 dark:bg-zinc-950 rounded-md" money />

            {{-- Product Category Input --}}
            <div class="md:col-span-2">
                <x-mary-select label="Category" placeholder="Select a category" wire:model="category_id"
                    :options="$categories" class="dark:text-white/90 dark:bg-zinc-950 rounded-md" />
            </div>

            {{-- Tokopedia link input --}}
            <div class="md:col-span-2"> {{-- Make description span two columns on medium screens and up --}}
                <x-mary-input label="Tokopedia Link" wire:model="tokopedia_link" placeholder="Enter Tokopedia link"
                    class="dark:text-white/90 dark:bg-zinc-950 rounded-md" />
            </div>

            {{-- Shopee link input --}}
            <div class="md:col-span-2"> {{-- Make description span two columns on medium screens and up --}}
                <x-mary-input label="Shopee Link" wire:model="shopee_link" placeholder="Enter Shopee link"
                    class="dark:text-white/90 dark:bg-zinc-950 rounded-md" />
            </div>

            {{-- Lazada link input --}}
            <div class="md:col-span-2"> {{-- Make description span two columns on medium screens and up --}}
                <x-mary-input label="Lazada Link" wire:model="lazada_link" placeholder="Enter Lazada link"
                    class="dark:text-white/90 dark:bg-zinc-950 rounded-md" />
            </div>

            {{-- Product Description Input --}}
            <div class="md:col-span-2"> {{-- Make description span two columns on medium screens and up --}}
                <x-mary-markdown wire:model="description" label="Description" :config="$config" />
            </div>


            {{-- Product Photo Upload --}}
            <div class="md:col-span-2"> {{-- Make photo upload span two columns --}}
                <x-mary-file name="photo" {{-- Name attribute for the file input --}} label="Product Photo"
                    hint="Only Image (Optional - Leave empty to keep current image)" wire:model="photo" {{-- Bind to the
                    photo property --}} accept="image/*" {{-- Accept only image files --}}
                    class="dark:text-white/90 dark:bg-zinc-950! rounded-md!" />

                {{-- Display current image if available --}}
                @if ($currentImage && !$photo)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Current Image:</p>
                        <img src="{{ Storage::url($currentImage) }}" class="rounded-md max-w-xs"
                            alt="Current product image" />
                    </div>
                @endif

                {{-- Display preview of new uploaded image --}}
                @if ($photo)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">New Image Preview:</p>
                        <img src="{{ $photo->temporaryUrl() }}" class="rounded-md max-w-xs"
                            alt="New product image preview" />
                    </div>
                @endif
            </div>
        </div>

        {{-- Form Actions --}}
        <x-slot:actions>
            {{-- Cancel Button (optional, redirect back to product listing) --}}
            <x-mary-button label="Cancel" link="{{ route('dashboard') }}"
                class="btn-primary dark:bg-zinc-800 rounded-lg border-none hover:bg-zinc-700" wire:navigate />

            {{-- Submit Button --}}
            <x-mary-button label="Update" icon="o-paper-airplane" spinner="update" {{-- Show spinner while update method
                is running --}} type="submit" {{-- This button submits the form --}}
                class="btn-primary dark:bg-zinc-800 rounded-lg border-none hover:bg-zinc-700" />
        </x-slot:actions>
    </x-mary-form>

    {{-- Mary UI Toast component --}}
    <x-mary-toast />
</div>

@assets
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"
    defer></script>
<script src="https://unpkg.com/easymde/dist/easymde.min.js" defer></script>
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
@endassets