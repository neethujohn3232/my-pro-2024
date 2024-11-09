<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::with('company')  
            ->select(['id', 'first_name', 'last_name', 'company_id', 'email', 'phone', 'created_at', 'updated_at']);
            return DataTables::of($employees)
            ->addColumn('company_name', function($employee) {
                return $employee->company->name ?? 'No Company'; 
            })
            ->toJson();
        }
    
        return view('employees.index');
    }
    
    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ]);
    
        Employee::create($request->all());
        return redirect()->route('employees.index');
    }
    
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }
    
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::all();
        return view('employees.edit', compact('employee', 'companies'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ]);
    
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return redirect()->route('employees.index');
    }
    
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
    
        return response()->json(['success' => 'Employee deleted successfully']);
    }
    
}
