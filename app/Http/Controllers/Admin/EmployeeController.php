<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public const IMAGE_TYPE = 1;
    public const PDF_TYPE = 2;

    public function index()
    {
        $filters = request()->all('search');
        $employees = Employee::filter(request()->only('search'))->paginate();

        return Inertia::render('Admin/Employees/Employees', compact('filters', 'employees'));
    }

    public function store(UpdateEmployeeRequest $request)
    {
        try {
            Employee::create($request->only('first_name', 'last_name', 'title', 'employment_date', 'personal_code'));
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai creat cu succes un nou angajat')
        ]);
    }

    public function reactivate(Employee $employee)
    {
        try {
            $employee->update([
                'employment_date' => Carbon::now(),
                'unemployment_date' => NULL,
            ]);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('I-ai reactivat cu succes contractul de muncă')
        ]);
    }

    public function deactivate(Employee $employee)
    {
        try {
            $employee->update([
                'unemployment_date' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('I-ai dezactivat cu succes contractul de muncă')
        ]);
    }
}
