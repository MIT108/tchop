<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\MenuContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dotenv\Util\Str;

class MenuController extends Controller
{
    //
    public function index()
    {

        $ingredients = Ingredient::orderBy('id', 'DESC')->get();
        $menus = Menu::get();
        return view('pages/menu/index')
            ->with('ingredients', $ingredients)
            ->with('menus', $menus);
    }
    public function viewMenu($id)
    {

        $menu = Menu::find($id);
        if ($menu) {
            $ingredients = MenuContent::where('menu_id', $id)->with(['menu', 'ingredient'])->get();
            $menuContents = MenuContent::where('menu_id', $id)->get();
            $ingredientIds = [];
            foreach ($menuContents as $menuContent) {
                array_push($ingredientIds, $menuContent->ingredient_id);
            }
            $notIngredients = Ingredient::whereNotIn('id', $ingredientIds)->get();
            return view('pages/menu/viewMenu')
                ->with('menu', $menu)
                ->with('ingredients', $ingredients)
                ->with('notIngredients', $notIngredients);
        } else {
            return redirect()->route('menu-management');
        }
    }

    public function createMenu(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string',
            'image' => 'required|file',
            'description' => 'required|string'
        ]);

        if ($this->checkMenuName($fields['name'])) {

            try {
                //code...
                $imageFullName = $request->file('image')->getClientOriginalName();
                $fileName = strtotime(Carbon::now()) . $imageFullName;
                $fields['image'] = $fileName;

                try {

                    Menu::create($fields);

                    $request->file('image')->storeAs('public/menus', $fileName);

                    return redirect()->back()->with('success', 'Menu registration successful');
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
    public function updateMenu(Request $request)
    {

        $fields = [];

        $Menu = Menu::find($request['id']);

        if ($Menu) {

            if ($request['name'] != null) {
                if ($request['name'] != $Menu->name) {
                    if ($this->checkMenuName($request['name'])) {
                        $fields['name'] = $request['name'];
                    } else {
                        return redirect()->back()->with('error', "this name has already been used");
                    }
                }
            }
            if ($request['description'] != null) {
                $fields['description'] = $request['description'];
            }

            if ($request['image'] != null) {
                $imageFullName = $request->file('image')->getClientOriginalName();
                $fileName = strtotime(Carbon::now()) . $imageFullName;
                $fields['image'] = $fileName;
            }


            try {

                Menu::where('id', $Menu->id)->update($fields);
                if ($request['image'] != null) {
                    $request->file('image')->storeAs('public/Menus', $fileName);
                }
                return redirect()->back()->with('success', 'Menu updated successful');
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', "Menu does not exist");
        }
    }
    public function menuIngredient($id, Request $request)
    {
        try {
            //code...

            $ingredients = Ingredient::get();
            foreach ($ingredients as $ingredient) {
                if ($request[$ingredient->id] == 1) {
                    if ($this->checkMenuContent($id, $ingredient->id)) {
                        MenuContent::create([
                            'menu_id' => $id,
                            'ingredient_id' => $ingredient->id
                        ]);
                    }
                }
            }
            return redirect()->back()->with('success', "ingredient added successfully");
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function deleteMenu($id)
    {
        try {
            //code...
            Menu::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Menu deleted successful');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function deleteMenuIngredient($menu_id, $ingredient_id){

        try {
            //code...
            MenuContent::where('menu_id', $menu_id)->where('ingredient_id', $ingredient_id)->delete();
            return redirect()->back()->with('success', 'Deleted successful');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function checkMenuContent($menu_id, $ingredient_id){
        if (MenuContent::where('menu_id', $menu_id)->where('ingredient_id', $ingredient_id)->count() > 0) {
            return false;
        }else{
            return true;
        }
    }


    public function checkMenuName($name)
    {
        if (Menu::where('name', $name)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}
