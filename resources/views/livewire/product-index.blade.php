<div class="flex flex-col">
    <div class="w-1/2 mb-6">
        <h2>{{ $updateMode ? 'Edit Product' : 'Add Product' }}</h2>
        <br>
        <form class="space-y-2" wire:submit.prevent="save">

            <flux:input wire:model="name" label="Name" placeholder="Product Name" class="w-1/3" />
            <flux:textarea wire:model="description" label="Description" placeholder="Describe your Product..." />
            <flux:input wire:model="price" label="Price (RM)" placeholder="Product Price" />
            <flux:button variant="primary" type="submit">
                Submit
            </flux:button>
        </form>
        <br>
    </div>

    @if (session('message'))
        <div class="bg-gray-500 px-4 py-6 rounded-lg w-full h-96 mb-6">
            <span class="text-pink-600">{{ session('message') }}</span>
        </div>
    @endif

    <table class="w-full border border-grey-200">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $index => $product)
                <tr>
                    <td class="border">{{ ($products->currentPage() - 1) * $products->perPage() + ($index + 1) }}</td>
                    <td class="border px-2">{{ $product->name }}</td>
                    <td class="border px-2">{{ $product->description }}</td>
                    <td class="border px-2">{{ $product->price }}</td>
                    <td class="flex justify-center border p-2 gap-2">
                        <flux:button wire:click="edit({{ $product->id }})" variant="filled">Edit</flux:button>
                        <flux:button wire:click="delete({{ $product->id }})" variant="danger">Delete</flux:button>
                    </td>

                </tr>
            @empty
                <tr>
                    <td>No data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>
        {{ $products->links() }}
    </div>
</div>
