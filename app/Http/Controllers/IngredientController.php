<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\MenuContent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    //
    public function createIngredient(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'image' => 'required|file'
        ]);

        if ($this->checkIngredientName($fields['name'])) {

            try {
                //code...
                $imageFullName = $request->file('image')->getClientOriginalName();
                $fileName = strtotime(Carbon::now()) . $imageFullName;
                $fields['image'] = $fileName;

                try {

                    Ingredient::create($fields);

                    $request->file('image')->storeAs('public/ingredients', $fileName);

                    return redirect()->back()->with('success', 'Ingredient registration successful');
                } catch (\Throwable $th) {
                    //throw $th;
                    return redirect()->back()->with('error', $th->getMessage());
                }
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', "this name has already been used");
        }
    }

    public function viewIngredient($id)
    {

        $ingredient = Ingredient::find($id);
        if ($ingredient) {
            $menus = MenuContent::where('ingredient_id', $id)->with(['menu', 'ingredient'])->get();
            return view('pages/menu/view')
            ->with('ingredient', $ingredient)
            ->with('menus', $menus);
        } else {
           return redirect()->route('menu-management');
        }
    }

    public function deleteIngredient($id)
    {
        try {
            //code...
            Ingredient::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Ingredient deleted successful');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateIngredient(Request $request)
    {
        $fields = [];

        $ingredient = Ingredient::find($request['id']);

        if ($ingredient) {

            if ($request['name'] != null) {
                if ($request['name'] != $ingredient->name) {
                    if ($this->checkIngredientName($request['name'])) {
                        $fields['name'] = $request['name'];
                    } else {
                        return redirect()->back()->with('error', "this name has already been used");
                    }
                }
            }

            if ($request['image'] != null) {
                $imageFullName = $request->file('image')->getClientOriginalName();
                $fileName = strtotime(Carbon::now()) . $imageFullName;
                $fields['image'] = $fileName;
            }


            try {

                Ingredient::where('id', $ingredient->id)->update($fields);
                if ($request['image'] != null) {
                    $request->file('image')->storeAs('public/ingredients', $fileName);
                }
                return redirect()->back()->with('success', 'Ingredient updated successful');
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', "Ingredient does not exist");
        }


    }

    public function checkIngredientName($name)
    {
        if (Ingredient::where('name', $name)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}
