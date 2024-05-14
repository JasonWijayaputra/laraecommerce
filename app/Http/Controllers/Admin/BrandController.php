<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandFormRequest;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;

class BrandController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', '0')->get();
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands.index',  ['brands' => $brands, 'categories' => $categories]);
    }

    public function create()
    {
        $categories = Category::where('status', '0')->get();

        return view('admin.brands.create', compact('categories'));
    }

    public function store(BrandFormRequest $request)
    {
        // Validate the form data
        $validatedData = $request->validated();
        Brand::create($validatedData);
        return redirect('admin/brands')->with('message', 'Brands Added!');
    }
    public function edit(Brand $brand)
    {
        $categories = Category::where('status', '0')->get();

        return view('admin.brands.edit', compact('brand', 'categories'));
    }

    public function update(BrandFormRequest $request, $brand_id)
    {
        $validatedData = $request->validated();
        $validatedData['status'] = $request->status == true ? '1' : '0';
        Brand::find($brand_id)->update($validatedData);
        return redirect('admin/brands')->with('message', 'Brands Updated Successfully');
    }

    public function destroy($brand_id)
    {
        // Logic for deleting brand data
        $brand = Brand::findOrFail($brand_id);
        $brand->delete();
        return redirect('admin/brands')->with('message', 'Brand Deleted Successfully');
    }
}
