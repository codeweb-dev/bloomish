<div>
    <div class="my-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            @if (!$showTrashed)
            Category
            @else
            Deleted Category
            @endif
        </h1>

        <div class="flex items-center gap-3">
            <flux:button icon="archive-box" wire:click="$toggle('showTrashed')">
                {{ $showTrashed ? 'Show Active' : 'View Trash' }}
            </flux:button>

            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search categories..." icon="magnifying-glass" />
            </div>
            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                    <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:modal.trigger name="add-category">
                <flux:button icon:trailing="plus">Add Category</flux:button>
            </flux:modal.trigger>

            <flux:modal name="add-category" class="md:w-96">
                <form wire:submit="save">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Add New Category</flux:heading>
                            <flux:text class="mt-2">Fill out the form below to create a new category listing in your
                                store.
                            </flux:text>
                        </div>

                        <flux:input label="Name" placeholder="Enter category name" clearable wire:model.blur="name"
                            required />

                        <div class="flex">
                            <flux:spacer />

                            <flux:button type="submit" variant="primary">Save Category</flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>
        </div>
    </div>

    <x-admin-components.table :headers="['ID', 'Name', 'Date', '']">
        @foreach ($categories as $category)
        <tr class="hover:bg-white/5 bg-black/5 transition-all">
            <td class="px-3 py-4">{{ $category->id }}</td>
            <td class="px-3 py-4">{{ $category->name }}</td>
            <td class="px-3 py-4">{{ $category->created_at->format('M d, h:i A') }}</td>
            <td class="px-3 py-4">
                <flux:dropdown>
                    <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                    <flux:menu>
                        @if (!$showTrashed)
                        <flux:menu.item icon="eye">
                            <flux:modal.trigger name="view-category-{{ $category->id }}">
                                View
                            </flux:modal.trigger>
                        </flux:menu.item>
                        <flux:menu.item icon="pencil-square">
                            <flux:modal.trigger name="edit-category-{{ $category->id }}"
                                wire:click="setEdit({{ $category->id }})">
                                Edit
                            </flux:modal.trigger>
                        </flux:menu.item>
                        <flux:menu.item icon="trash" variant="danger">
                            <flux:modal.trigger name="delete-category-{{ $category->id }}">
                                Delete
                            </flux:modal.trigger>
                        </flux:menu.item>
                        @else
                        <flux:menu.item icon="arrow-path">
                            <flux:modal.trigger name="restore-category-{{ $category->id }}">
                                Restore
                            </flux:modal.trigger>
                        </flux:menu.item>
                        <flux:menu.item icon="trash" variant="danger">
                            <flux:modal.trigger name="force-delete-category-{{ $category->id }}">
                                Delete Permanently
                            </flux:modal.trigger>
                        </flux:menu.item>
                        @endif
                    </flux:menu>

                </flux:dropdown>

                <flux:modal name="force-delete-category-{{ $category->id }}" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Delete Category Permanently?</flux:heading>
                            <flux:text class="mt-2">
                                This will permanently delete <strong>{{ $category->name }}</strong> from your store.
                                This action cannot be undone.
                            </flux:text>
                        </div>

                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="button" variant="danger" wire:click="forceDelete({{ $category->id }})">
                                Delete Permanently
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="restore-category-{{ $category->id }}" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Restore Category?</flux:heading>
                            <flux:text class="mt-2">
                                You're about to restore <strong>{{ $category->name }}</strong>. This category will
                                become
                                active and visible in your store again.
                            </flux:text>
                        </div>

                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="button" variant="primary" wire:click="restore({{ $category->id }})">
                                Confirm Restore
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="delete-category-{{ $category->id }}" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Soft Delete Category?</flux:heading>
                            <flux:text class="mt-2">
                                Are you sure you want to delete <strong>{{ $category->name }}</strong>?,
                                This category will not be permanently deleted — it will be moved to trash and
                                can be restored later.
                            </flux:text>
                        </div>

                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="button" variant="danger" wire:click="delete({{ $category->id }})">
                                Move to Trash
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="view-category-{{ $category->id }}" class="min-w-[24rem] md:w-[32rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Category Details</flux:heading>
                            <flux:text class="mt-2">Here are the details for <strong>{{ $category->name }}</strong>.
                            </flux:text>
                        </div>

                        <div class="space-y-2">
                            <flux:label>Name</flux:label>
                            <p class="text-sm text-gray-300">{{ $category->name }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">

                            <div class="col-span-2">
                                <flux:label>Created At</flux:label>
                                <p class="text-sm text-gray-400">{{ $category->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <flux:modal.close>
                                <flux:button variant="primary">Close</flux:button>
                            </flux:modal.close>
                        </div>
                    </div>
                </flux:modal>

                <flux:modal name="edit-category-{{ $category->id }}" class="md:w-96">
                    <form wire:submit.prevent="edit">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Edit Category</flux:heading>
                                <flux:text class="mt-2">Update the details for <strong>{{ $category->name }}</strong>.
                                </flux:text>
                            </div>

                            <flux:input label="Name" placeholder="Enter category name" clearable
                                wire:model.defer="editData.name" required />

                            <div class="flex">
                                <flux:spacer />
                                <flux:button type="submit" variant="primary">Update Category</flux:button>
                            </div>
                        </div>
                    </form>
                </flux:modal>
            </td>
        </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
