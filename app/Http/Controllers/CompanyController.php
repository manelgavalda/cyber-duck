<?php

namespace App\Http\Controllers;

use Storage;
use App\Company;
use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;

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
    public function store(StoreCompany $request)
    {
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
    public function update(UpdateCompany $request, Company $company)
    {
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
        Storage::disk('public')->delete($company->logo_path);

        $company->delete();

        return redirect()->route('companies.index');
    }
}
