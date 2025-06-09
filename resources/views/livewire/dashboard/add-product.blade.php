<?php

use App\Models\Product;
use App\Models\Category;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Rule};
use Livewire\WithFileUploads; // Trait for file uploads
use Mary\Traits\Toast; // For notifications

new
    #[Layout('components.layouts.dashboard.app')] // Use the same layout
    #[Title('Add New Product')] // Set a title for this page
    class extends Component {
    use WithFileUploads; // Enable file uploads
    use Toast; // Enable toast notifications

    // Public properties to bind form inputs
    #[Rule('required|string|max:255')] // Validation rules for name
    public string $name = '';

    #[Rule('required|numeric|min:0')] // Validation rules for price
    public float $price = 0.0;

    #[Rule('required|exists:categories,id')] // Validation rules for category
    public string $category_id = '';

    #[Rule('required|string')] // Validation rules for description
    public ?string $description = ''; // Allow description to be null

    #[Rule('nullable|url|max:2048')]
    public ?string $tokopedia_link = null;

    #[Rule('nullable|url|max:2048')]
    public ?string $shopee_link = null;

    #[Rule('nullable|url|max:2048')]
    public ?string $lazada_link = null;

    #[Rule('required|image|max:1024')] // Validation rules for image upload (optional, max 1MB)
    public $photo; // Property to hold the uploaded file

    /**
     * Method to handle form submission and create a new product.
     */
    public function store()
    {
        // Validate the form inputs
        $validatedData = $this->validate();

        // Create a new Product instance
        $product = new Product;

        // Assign validated data to the product model
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->category_id = $validatedData['category_id'];
        $product->description = $validatedData['description'];
        $product->tokopedia_link = $validatedData['tokopedia_link'];
        $product->shopee_link = $validatedData['shopee_link'];
        $product->lazada_link = $validatedData['lazada_link'];

        // Handle file upload if a photo was provided
        if ($this->photo) {
            // Store the file in the 'public/products' directory
            // and get the storage path.
            $product->image_path = $this->photo->store('products', 'public');
        }

        // Save the product to the database
        $product->save();

        // Show a success notification
        $this->toast(
            type: 'success',
            title: 'Product created!',
            description: 'The new product has been added.',
            position: 'toast-bottom', // Adjust position as needed
            icon: 'o-check-circle',
            timeout: 3000
        );

        // Reset the form fields after successful submission
        $this->reset();

        // Optional: Redirect to the product listing page after creation
        return $this->redirect(route('dashboard'), navigate: true);
    }

    /**
     * The Blade view for the component.
     */
    public function with(): array
    {
        $config = [
            'toolbar' => ['heading', 'bold', 'italic', '|', 'quote', 'unordered-list', 'ordered-list', 'link', '|', 'preview'],
            'maxHeight' => '200px',
            'spellChecker' => false, // Disables the spell checker
            'nativeSpellcheck' => false, // Disables browser's native spell check within MDE
            'uploadImage' => false,
        ];

        $categories = Category::get()->map(function ($category) {
            return ['id' => $category->id, 'name' => $category->name];
        })->all();

        return [
            'categories' => $categories,
            'config' => $config,
        ];
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    {{-- Header for the add product page --}}
    <x-mary-header title="Add New Product" class="text-zinc-800 dark:text-white/90 mb-2!" separator />

    {{-- Form for adding a new product --}}
    {{-- wire:submit="store" calls the store method on form submission --}}
    {{-- @submit.prevent prevents default browser form submission --}}
    <x-mary-form wire:submit="store">
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
                    hint="Only Image" wire:model="photo" {{-- Bind to the photo property --}} accept="image/*" {{--
                    Accept only image files --}} class="dark:text-white/90 dark:bg-zinc-950! rounded-md!" />
                {{-- Optional: Display a preview of the uploaded photo --}}
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="my-10 rounded-md max-w-xs" />
                @endif
            </div>
        </div>

        {{-- Form Actions --}}
        <x-slot:actions>
            {{-- Cancel Button (optional, e.g., redirect back) --}}
            <x-mary-button label="Cancel" link="{{ route('dashboard') }}"
                class="btn-primary dark:bg-zinc-800 rounded-lg border-none hover:bg-zinc-700" wire:navigate />

            {{-- Submit Button --}}
            <x-mary-button label="Save" icon="o-paper-airplane" spinner="store" {{-- Show spinner while store method is
                running --}} type="submit" {{-- This button submits the form --}}
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