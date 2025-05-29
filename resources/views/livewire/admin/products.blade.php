<div>
    <div class="my-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            @if (!$showTrashed)
            Products
            @else
            Deleted Products
            @endif
        </h1>

        <div class="flex items-center gap-3">
            <flux:button icon="archive-box" wire:click="$toggle('showTrashed')">
                {{ $showTrashed ? 'Show Active' : 'View Trash' }}
            </flux:button>

            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search products..." icon="magnifying-glass" />
            </div>
            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                    <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:modal.trigger name="add-product">
                <flux:button icon:trailing="plus">Add Product</flux:button>
            </flux:modal.trigger>

            <flux:modal name="add-product" class="md:w-96">
                <form wire:submit="save">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Add New Product</flux:heading>
                            <flux:text class="mt-2">Fill out the form below to create a new product listing in your
                                store.
                            </flux:text>
                        </div>

                        <flux:input label="Name" placeholder="Enter product name" clearable wire:model.blur="name"
                            required />

                        <flux:textarea label="Description" placeholder="Enter product description..."
                            wire:model.blur="description" required />

                        <flux:input type="number" label="Price" placeholder="Enter product price"
                            wire:model.blur="price" required />


                        <flux:input type="number" label="Stock" placeholder="Enter product stock"
                            wire:model.blur="stock" required />

                        <flux:input type="text" label="Image Url" placeholder="Enter image url (Optional)"
                            wire:model.blur="image_url" />

                        <flux:select wire:model.blur="category_id" placeholder="Choose category..." label="Category"
                            required>
                            @foreach ($categories as $category)
                            <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:select wire:model.blur="brand_id" placeholder="Choose brand..." label="Brand" required>
                            @foreach ($brands as $brand)
                            <flux:select.option value="{{ $brand->id }}">{{ $brand->name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <div class="flex">
                            <flux:spacer />

                            <flux:button type="submit" variant="primary">Save Product</flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>
        </div>
    </div>

    <x-admin-components.table
        :headers="['ID', 'Product', 'Description', 'Sells', 'Stock', 'Brand', 'Category', 'Date', '']">
        @foreach ($products as $product)
        <tr class="hover:bg-white/5 bg-black/5 transition-all">
            <td class="px-3 py-4">{{ $product->id }}</td>
            <td class="px-3 py-4 flex items-center gap-2">
                <flux:avatar src="{{ $product->image_url }}" />
                <div class="flex flex-col">
                    <span class="font-bold">{{ $product->name }}</span>
                    <span>PHP{{ number_format($product->price, 2) }}</span>
                </div>
            </td>
            <td class="px-3 py-4">{{ $product->description }}</td>
            <td class="px-3 py-4">{{ $product->sells_count }}</td>
            <td class="px-3 py-4">{{ $product->stock }}</td>
            <td class="px-3 py-4">
                <flux:badge size="sm" icon="check-badge">{{ $product->brand->name }}</flux:badge>
            </td>
            <td class="px-3 py-4">
                <flux:badge size="sm" icon="adjustments-horizontal">{{ $product->category->name }}</flux:badge>
            </td>
            <td class="px-3 py-4">{{ $product->created_at->format('M d, h:i A') }}</td>
            <td class="px-3 py-4">
                <flux:dropdown>
                    <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                    <flux:menu>
                        @if (!$showTrashed)
                        <flux:menu.item icon="eye">
                            <flux:modal.trigger name="view-product-{{ $product->id }}">
                                View
                            </flux:modal.trigger>
                        </flux:menu.item>
                        <flux:menu.item icon="pencil-square">
                            <flux:modal.trigger name="edit-product-{{ $product->id }}"
                                wire:click="setEdit({{ $product->id }})">
                                Edit
                            </flux:modal.trigger>
                        </flux:menu.item>
                        <flux:menu.item icon="trash" variant="danger">
                            <flux:modal.trigger name="delete-product-{{ $product->id }}">
                                Delete
                            </flux:modal.trigger>
                        </flux:menu.item>
                        @else
                        <flux:menu.item icon="arrow-path">
                            <flux:modal.trigger name="restore-product-{{ $product->id }}">
                                Restore
                            </flux:modal.trigger>
                        </flux:menu.item>
                        <flux:menu.item icon="trash" variant="danger">
                            <flux:modal.trigger name="force-delete-product-{{ $product->id }}">
                                Delete Permanently
                            </flux:modal.trigger>
                        </flux:menu.item>
                        @endif
                    </flux:menu>

                </flux:dropdown>

                <flux:modal name="force-delete-product-{{ $product->id }}" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Delete Product Permanently?</flux:heading>
                            <flux:text class="mt-2">
                                This will permanently delete <strong>{{ $product->name }}</strong> from your store.
                                This action cannot be undone.
                            </flux:text>
                        </div>

                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="button" variant="danger" wire:click="forceDelete({{ $product->id }})">
                                Delete Permanently
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="restore-product-{{ $product->id }}" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Restore Product?</flux:heading>
                            <flux:text class="mt-2">
                                You're about to restore <strong>{{ $product->name }}</strong>. This product will become
                                active and visible in your store again.
                            </flux:text>
                        </div>

                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="button" variant="primary" wire:click="restore({{ $product->id }})">
                                Confirm Restore
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="delete-product-{{ $product->id }}" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Soft Delete Product?</flux:heading>
                            <flux:text class="mt-2">
                                Are you sure you want to delete <strong>{{ $product->name }}</strong>?,
                                This product will not be permanently deleted — it will be moved to trash and
                                can be restored later.
                            </flux:text>
                        </div>

                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="button" variant="danger" wire:click="delete({{ $product->id }})">
                                Move to Trash
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="view-product-{{ $product->id }}" class="min-w-[24rem] md:w-[32rem]">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <flux:avatar src="{{ $product->image_url }}" size="xl" />
                            <div>
                                <flux:heading size="lg">{{ $product->name }}</flux:heading>
                                <flux:text class="text-sm text-gray-400">ID: {{ $product->id }}</flux:text>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <flux:label>Description</flux:label>
                            <p class="text-sm text-gray-300">{{ $product->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <flux:label>Price</flux:label>
                                <p class="text-sm font-medium">PHP{{ number_format($product->price, 2) }}</p>
                            </div>

                            <div>
                                <flux:label>Stock</flux:label>
                                <p class="text-sm font-medium">{{ $product->stock }}</p>
                            </div>

                            <div>
                                <flux:label>Brand</flux:label>
                                <flux:badge size="sm" icon="check-badge">{{ $product->brand->name }}</flux:badge>
                            </div>

                            <div>
                                <flux:label>Category</flux:label>
                                <flux:badge size="sm" icon="adjustments-horizontal">{{ $product->category->name }}
                                </flux:badge>
                            </div>

                            <div class="col-span-2">
                                <flux:label>Created At</flux:label>
                                <p class="text-sm text-gray-400">{{ $product->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <flux:modal.close>
                                <flux:button variant="primary">Close</flux:button>
                            </flux:modal.close>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="edit-product-{{ $product->id }}" class="md:w-96">
                    <form wire:submit.prevent="edit">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Edit Product</flux:heading>
                                <flux:text class="mt-2">Update the details for <strong>{{ $product->name }}</strong>.
                                </flux:text>
                            </div>

                            <flux:input label="Name" placeholder="Enter product name" clearable
                                wire:model.defer="editData.name" required />

                            <flux:textarea label="Description" placeholder="Enter product description..."
                                wire:model.defer="editData.description" required />

                            <flux:input type="number" label="Price" placeholder="Enter product price"
                                wire:model.defer="editData.price" required />

                            <flux:input type="number" label="Stock" placeholder="Enter product stock"
                                wire:model.defer="editData.stock" required />

                            <flux:input type="text" label="Image Url" placeholder="Enter image url (Optional)"
                                wire:model.defer="editData.image_url" />

                            <flux:select wire:model.defer="editData.category_id" placeholder="Choose category..."
                                label="Category" required>
                                @foreach ($categories as $category)
                                <flux:select.option value="{{ $category->id }}">{{ $category->name }}
                                </flux:select.option>
                                @endforeach
                            </flux:select>

                            <flux:select wire:model.defer="editData.brand_id" placeholder="Choose brand..."
                                label="Brand" required>
                                @foreach ($brands as $brand)
                                <flux:select.option value="{{ $brand->id }}">{{ $brand->name }}</flux:select.option>
                                @endforeach
                            </flux:select>

                            <div class="flex">
                                <flux:spacer />
                                <flux:button type="submit" variant="primary">Update Product</flux:button>
                            </div>
                        </div>
                    </form>
                </flux:modal>
            </td>
        </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
