<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('companies.index', [
           'companies' => Company::paginate(10)
        ]);
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
            'logo' => 'dimensions:min_width=100,min_height=100'
        ]);

        if($request->file('logo')) {
            $request->merge(['logo_path' => $request->file('logo')->store('logos', 'public')]);
        }

        Company::create($request->all());

        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('companies.show', [
            'company' => $company
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'logo' => 'nullable|dimensions:min_width=100,min_height=100'
        ]);

        if($request->file('logo')) {
            Storage::disk('public')->delete($company->logo_path);
            $request->merge(['logo_path' => $request->file('logo')->store('logos', 'public')]);
        }

        $company->update($request->all());

        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index');
    }
}
