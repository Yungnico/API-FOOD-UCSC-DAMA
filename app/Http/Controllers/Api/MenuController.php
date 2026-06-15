<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::with('productos')->get());
    }

    public function store(Request $request)
    {
        $menu = Menu::create($request->all());

        if ($request->has('productos')) {
            $menu->productos()->attach($request->productos);
        }

        return response()->json($menu, 201);
    }

    public function show($id)
    {
        return response()->json(Menu::with('productos')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        if ($request->has('productos')) {
            $menu->productos()->sync($request->productos);
        }

        return response()->json($menu);
    }

    public function destroy($id)
    {
        Menu::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}