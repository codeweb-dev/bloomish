<?php

namespace App\Livewire\Admin;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Livewire\Component;
use Flux\Flux;

#[Title('Products')]
#[Layout('components.layouts.admin')]
class Products extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'tailwind';

    public $search = '';
    public bool $showTrashed = false;
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $editData = [
        'name' => '',
        'description' => '',
        'price' => '',
        'stock' => '',
        'image_url' => '',
        'category_id' => '',
        'brand_id' => '',
    ];
    public $editId = null;

    #[Validate('required|string|min:3')]
    public $name = '';

    #[Validate('required|string|min:10')]
    public $description = '';

    #[Validate('required|numeric|min:0')]
    public $price = '';

    #[Validate('required|numeric|min:0')]
    public $stock = '';

    #[Validate('nullable|string|url')]
    public $image_url = '';

    #[Validate('required|exists:categories,id')]
    public $category_id = '';

    #[Validate('required|exists:brands,id')]
    public $brand_id = '';

    public function save()
    {
        $this->validate();

        Product::create($this->all());

        $this->reset();

        Flux::modal('add-product')->close();

        Toaster::success('Product created successfully.');
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();

        Flux::modal('delete-product-' . $id)->close();

        Toaster::success('Product soft deleted successfully.');
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function restore($id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();

        Toaster::success('Product restored successfully.');

        Flux::modal('restore-product-' . $id)->close();
    }

    public function forceDelete($id)
    {
        Product::onlyTrashed()->findOrFail($id)->forceDelete();

        Toaster::success('Product permanently deleted.');

        Flux::modal('force-delete-product-' . $id)->close();
    }

    public function setEdit($id)
    {
        $product = Product::findOrFail($id);
        $this->editId = $id;
        $this->editData = [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'image_url' => $product->image_url,
            'category_id' => $product->category_id,
            'brand_id' => $product->brand_id,
        ];
    }

    public function edit()
    {
        $this->validate([
            'editData.name' => 'required|string|min:3',
            'editData.description' => 'required|string|min:10',
            'editData.price' => 'required|numeric|min:0',
            'editData.stock' => 'required|numeric|min:0',
            'editData.image_url' => 'nullable|string|url',
            'editData.category_id' => 'required|exists:categories,id',
            'editData.brand_id' => 'required|exists:brands,id',
        ]);

        $product = Product::findOrFail($this->editId);
        $product->update($this->editData);

        $this->reset('editId', 'editData');

        Flux::modal('edit-product-' . $product->id)->close();

        Toaster::success('Product updated successfully.');
    }

    public function render()
    {
        $query = Product::with('category', 'brand');
        $categories = Category::all();
        $brands = Brand::all();

        if ($this->showTrashed) {
            $query->onlyTrashed();
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.products', [
            'products' => $products,
            'pages' => $this->pages,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
