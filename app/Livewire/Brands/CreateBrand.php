<?php

namespace App\Livewire\Brands;

use Livewire\Component;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateBrand extends Component
{
    public $name, $slug, $status, $brand_id;
    protected $listeners = [
        'reloadBrands' => '$refresh'
    ];
    public function mount()
    {
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.brands.create-brand');
    }
    public function save()
    {
        DB::beginTransaction();
        try {
            Brand::create([
                'name' => $this->name,
                'slug' => Str::slug($this->slug),
                'status' => $this->status ? '1' : '0',
            ]);
            $this->dispatchBrowserEvent('closeModal');

            $this->initializedProperties();

            session()->flash('message', 'Brand added successfully.');
            // $this->emit('reloadBrands');
            // $this->emit('closeModal', 'modal_create_product');
            // $this->initializedProperties();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd('Error', $th->getMessage());
        }
        DB::commit();
    }
    public function initializedProperties()
    {
        $this->name = null;
        $this->slug = null;
        $this->status = null;
        $this->brand_id = null;
    }
}
