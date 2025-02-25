<?php

namespace App\Http\Controllers;

use App\Models\SeccionMenu;
use App\Http\Filters\SeccionMenuFilter;
use Illuminate\Http\Request;

class SeccionMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = SeccionMenu::all();
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
        $record = SeccionMenu::create($request->all());
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
        $record = SeccionMenu::with('menu')->find($id);
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
        $record = SeccionMenu::findOrFail($id);
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
        $record = SeccionMenu::findOrFail($id);
        $record->delete();
        return response()->json(null, 204);
    }

    /**
     * Display a listing of the resource filtered.
     * 
     * @param  SeccionMenuFilter $filters
     * @return \Illuminate\Http\Response
     */
    public function filteredList(SeccionMenuFilter $filters)
    {
        $records = SeccionMenu::with('menu')
            ->join('menu', 'menu.id', '=', 'seccion_menu.menu_id')
            ->select('seccion_menu.*');
        $filteredRecords = $filters->apply($records);
        return response()->json($filteredRecords, 200);
    }
}