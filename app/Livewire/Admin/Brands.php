<?php

namespace App\Livewire\Admin;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use App\Models\Brand;
use Livewire\Component;
use Flux\Flux;

#[Title('Brand')]
#[Layout('components.layouts.admin')]
class Brands extends Component
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

        Brand::create($this->all());

        $this->reset();

        Flux::modal('add-brand')->close();

        Toaster::success('Brand created successfully.');
    }

    public function delete($id)
    {
        Brand::findOrFail($id)->delete();

        Flux::modal('delete-brand-' . $id)->close();

        Toaster::success('Brand soft deleted successfully.');
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
        Brand::onlyTrashed()->findOrFail($id)->restore();

        Toaster::success('Brand restored successfully.');

        Flux::modal('restore-brand-' . $id)->close();
    }

    public function forceDelete($id)
    {
        Brand::onlyTrashed()->findOrFail($id)->forceDelete();

        Toaster::success('Brand permanently deleted.');

        Flux::modal('force-delete-brand-' . $id)->close();
    }

    public function setEdit($id)
    {
        $brand = Brand::findOrFail($id);
        $this->editId = $id;
        $this->editData = [
            'name' => $brand->name,
        ];
    }

    public function edit()
    {
        $this->validate([
            'editData.name' => 'required|string|min:3'
        ]);

        $brand = Brand::findOrFail($this->editId);
        $brand->update($this->editData);

        $this->reset('editId', 'editData');

        Flux::modal('edit-brand-' . $brand->id)->close();

        Toaster::success('Brand updated successfully.');
    }

    public function render()
    {
        $query = Brand::query();

        if ($this->showTrashed) {
            $query->onlyTrashed();
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        $brands = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.brands', [
            'brands' => $brands,
            'pages' => $this->pages,
        ]);
    }
}
