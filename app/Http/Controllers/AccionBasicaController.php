<?php

namespace App\Http\Controllers;

use App\Models\AccionBasica;
use App\Http\Filters\AccionBasicaFilter;
use Illuminate\Http\Request;

class AccionBasicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = AccionBasica::all();
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
        $record = AccionBasica::create($request->all());
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
        $record = AccionBasica::find($id);
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
        $record = AccionBasica::findOrFail($id);
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
        $record = AccionBasica::findOrFail($id);
        $record->delete();
        return response()->json(null, 204);
    }

    /**
     * Display a listing of the resource filtered.
     * @param  AccionBasicaFilter $filters
     * @return \Illuminate\Http\Response
     */
    public function filteredList(AccionBasicaFilter $filters)
    {
        $records = AccionBasica::query();
        $filteredRecords = $filters->apply($records);
        return response()->json($filteredRecords, 200);
    }
}