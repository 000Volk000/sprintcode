<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Destino;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AsignaturaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use function Laravel\Prompts\table;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $asignaturas = Asignatura::with('destino')->get();

        return view('asignatura.index', compact('asignaturas'))->with('i', 0);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $asignatura = new Asignatura();
        $ciudades = Destino::all();

        return view('asignatura.create', compact('ciudades', 'asignatura'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsignaturaRequest $request): RedirectResponse
    {
        Asignatura::create($request->validated());

        return Redirect::route('asignaturas.index')
            ->with('success', 'Asignatura created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $asignatura = Asignatura::find($id);

        return view('asignatura.show', compact('asignatura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $asignatura = Asignatura::find($id);
        $ciudades = Destino::all();

        return view('asignatura.edit', compact('asignatura', 'ciudades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsignaturaRequest $request, Asignatura $asignatura): RedirectResponse
    {
       Asignatura::find($request->id)->update($request->validated());

        return Redirect::route('asignaturas.index')
            ->with('success', 'Asignatura updated successfully');
    }

    public function searchByCity($id){
        $asignaturas = DB::table('asignaturas')->where('idCiudad', $id)->get();
        $destino = DB::table('destinos')->where('id', $id)->get()->first();
        return view('asignatura', ['asignaturas' => $asignaturas, 'destino' => $destino]);

    }

    public function destroy($id): RedirectResponse
    {
        Asignatura::find($id)->delete();

        return Redirect::route('asignaturas.index')
            ->with('success', 'Asignatura deleted successfully');
    }
}
