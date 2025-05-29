<?php

namespace App\Livewire\Admin;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use App\Models\Category;
use Livewire\Component;
use Flux\Flux;

#[Title('Category')]
#[Layout('components.layouts.admin')]
class Categories extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'tailwind';

    public $search = '';
    public bool $showTrashed = false;
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $editData = [
        'name' => '',
    ];
    public $editId = null;

    #[Validate('required|string|min:3')]
    public $name = '';

    public function save()
    {
        $this->validate();

        Category::create($this->all());

        $this->reset();

        Flux::modal('add-category')->close();

        Toaster::success('Category created successfully.');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();

        Flux::modal('delete-category-' . $id)->close();

        Toaster::success('Category soft deleted successfully.');
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
        Category::onlyTrashed()->findOrFail($id)->restore();

        Toaster::success('Category restored successfully.');

        Flux::modal('restore-category-' . $id)->close();
    }

    public function forceDelete($id)
    {
        Category::onlyTrashed()->findOrFail($id)->forceDelete();

        Toaster::success('Category permanently deleted.');

        Flux::modal('force-delete-category-' . $id)->close();
    }

    public function setEdit($id)
    {
        $category = Category::findOrFail($id);
        $this->editId = $id;
        $this->editData = [
            'name' => $category->name,
        ];
    }

    public function edit()
    {
        $this->validate([
            'editData.name' => 'required|string|min:3'
        ]);

        $category = Category::findOrFail($this->editId);
        $category->update($this->editData);

        $this->reset('editId', 'editData');

        Flux::modal('edit-category-' . $category->id)->close();

        Toaster::success('Category updated successfully.');
    }

    public function render()
    {
        $query = Category::query();

        if ($this->showTrashed) {
            $query->onlyTrashed();
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.categories', [
            'categories' => $categories,
            'pages' => $this->pages,
        ]);
    }
}
