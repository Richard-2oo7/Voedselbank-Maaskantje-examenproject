<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medewerkers = Employee::query()->filter(request(['search']))->with('role')->paginate(14)->withQueryString();
        $roles = Role::all();

        return inertia('Medewerkers',[
            'medewerkers' => $medewerkers,
            'medewerkerFuncties' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //valideer
        $validatedEmployee = $request->validate([
            'naam' => 'required|string|max:255',
            'gebruikersnaam' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:employees',
            'role_id' => 'required|exists:employees',
        ]);
        $validatedEmployee['password'] = Hash::make('password');
        //maak nieuwe klant
        Employee::create($validatedEmployee);

        return redirect()->back()->with('message' , 'Medewerker succesvol aangemaakt!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //valideer
        $validatedEmployee = $request->validate([
            'id' => 'required|exists:employees',
            'naam' => 'required|string|max:255',
            'gebruikersnaam' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|' . Rule::unique('employees', 'email')->ignore($id),
            'role_id' => 'required|exists:employees',
        ]);

        //zoek de werknemer
        $employee = Employee::find($id);
        
        //update de werknemer
        $employee->update($validatedEmployee);

        return redirect()->back()->with('message' , 'Medewerker succesvol geupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //valideer
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:employees,id',
        ]);

        try{
            //verwijder alle medewerkers
            $ids = $request->input('ids');
            Employee::whereIn('id', $ids)->delete();

            //stuur reactie
            return redirect()->back()->with('message', 'Medewerker succesvol verwijderd!');
        }
        catch(\Exception $e){
            //stuur reactie
            return redirect()->back()->with('message', 'Fout bij Medewerker verwijderen!');
        }
    }
}
