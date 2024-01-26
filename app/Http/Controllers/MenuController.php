<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Menu;
        $tabla = 'menu';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Menu::select('menu.*')->orderBy('id', 'ASC')->get();
    }
}
