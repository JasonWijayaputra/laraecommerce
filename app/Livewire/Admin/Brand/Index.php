<?php

namespace App\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    public $brands;
    public $categories;
    public $brand_id;
    public $category_id;
    public $name;
    public $slug;
    public $status;

    // public function mount()
    // {
    //     $this->categories = Category::all();
    //     $this->brands = Brand::paginate(10);
    // }

    public function render()
    {
        $categories = Category::where('status', '0')->get();
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.brand.index',  ['brands' => $brands, 'categories' => $categories]);
    }

    public function storeBrand()
    {
        $validatedData = $this->validate([
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'nullable|boolean',
        ]);

        Brand::create($validatedData);

        $this->resetInputs();
        session()->flash('message', 'Brand created successfully.');
    }

    public function editBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brand_id = $brand->id;
        $this->category_id = $brand->category_id;
        $this->name = $brand->name;
        $this->slug = $brand->slug;
        $this->status = $brand->status;
    }

    public function updateBrand()
    {
        $validatedData = $this->validate([
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $this->brand_id,
            'status' => 'nullable|boolean',
        ]);

        $brand = Brand::findOrFail($this->brand_id);
        $brand->update($validatedData);

        $this->resetInputs();
        session()->flash('message', 'Brand updated successfully.');
    }

    public function deleteBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        session()->flash('message', 'Brand deleted successfully.');
    }

    private function resetInputs()
    {
        $this->reset(['brand_id', 'category_id', 'name', 'slug', 'status']);
    }
}
