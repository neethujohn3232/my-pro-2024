<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class CompanyController extends Controller
{
    const IMAGE_FOLDER = 'logos';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companies = Company::select(['id', 'name', 'email', 'logo', 'website', 'updated_at']);
            return DataTables::of($companies)->toJson();
        }
    
        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'website' => 'nullable|url',
        ]);
    
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
    
        // if ($request->hasFile('logo')) {
        //     $image_name = $request->file('logo')->store(self::IMAGE_FOLDER, 'public');
        //     $company->logo = basename($image_name);
        // }
        if ($request->hasFile('logo')) {
            $image_name = $request->file('logo')->store('logos-img', 'public');
            $company->logo = 'storage/' . $image_name;  // Save the accessible path
        }
        $company->save();
        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
        ]);

        $company = Company::findOrFail($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                Storage::delete('public/logos/' . $company->logo);
            }
            $path = $request->file('logo')->store('public/logos');
            $company->logo = basename($path);
        }

        $company->save();
        return response()->json(['success' => 'Company details updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
    
        // Delete the logo file if it exists
        if ($company->logo) {
            Storage::delete('public/logos/' . $company->logo);
        }
    
        $company->delete();
    
        // Return a JSON response for AJAX
        return response()->json(['success' => 'Company deleted successfully']);
    }
    
}
