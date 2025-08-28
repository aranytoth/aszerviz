<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    protected $with = ['user'];

    public function index()
    {
        $companies = Company::orderBy('created_at', 'DESC')->paginate(20);
        return view('company.index', compact('companies'));
    }

    public function create()
    {
        $users = User::role('admin')->get();
        return view('company.create', compact('users'));
    }

    public function store(Request $request)
    {
        $params = $request->all();

        $company = new Company();
        $company->fill($params);
        $company->prefix = $company->createPrefix();
        if($company->save()){
            return redirect(route('company.index'))->with('success', 'Cég sikeresen létrehozva');
        } else {
            dd($company->getErrors());
        }
    }

    public function edit(Company $company) : View
    {
        
        $statuses = Company::$statuses;
        return view('company.edit', compact('company', 'statuses'));
    }

    public function update(Request $request, Company $company)
    {
        $params = $request->all();

        $company->fill($params);
        if(isset($params['company_logo'])){
            $company->storeImage();
        }
        if(empty($company->prefix)){
            $company->prefix = $company->createPrefix();
        }
        if($company->save()){
            return redirect(route('company.index'));
        } else {
            return redirect()->back();
        }
    }

    public function delete()
    {
        //TODO
    }
}
