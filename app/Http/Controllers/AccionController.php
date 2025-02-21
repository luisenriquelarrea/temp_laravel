<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use App\Http\Filters\AccionFilter;
use Illuminate\Http\Request;

class AccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Accion::all();
        return response()->json($records, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = Accion::create($request->all());
        return response()->json($record, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $record = Accion::with('seccionMenu')->find($id);
        if (!$record)
            return response()->json(['message' => 'record not found'], 404);
        return response()->json($record, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $record = Accion::findOrFail($id);
        $record->update($request->all());
        return response()->json($record, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $record = Accion::findOrFail($id);
        $record->delete();
        return response()->json(null, 204);
    }

    /**
     * Display a listing of the resource filtered.
     * 
     * @param  AccionFilter $filters
     * @return \Illuminate\Http\Response
     */
    public function filteredList(AccionFilter $filters)
    {
        $records = Accion::with('seccionMenu')
            ->join('seccion_menu', 'seccion_menu.id', '=', 'accion.seccion_menu_id')
            ->select('accion.*');
        $filteredRecords = $filters->apply($records);
        return response()->json($filteredRecords, 200);
    }
}