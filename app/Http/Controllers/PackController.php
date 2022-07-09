<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Pack;
use App\Models\PackContent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackController extends Controller
{
    //
    public function index()
    {

        $ingredients = Ingredient::orderBy('id', 'DESC')->get();
        $packs = Pack::get();
        return view('pages/pack/index')
            ->with('ingredients', $ingredients)
            ->with('packs', $packs);
    }

    public function createPack(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string',
            'image' => 'required|file',
            'unitPrice' => 'required'
        ]);

        if ($this->checkPackName($fields['name'])) {

            try {
                //code...
                $imageFullName = $request->file('image')->getClientOriginalName();
                $fileName = strtotime(Carbon::now()) . $imageFullName;
                $fields['image'] = $fileName;

                try {

                    Pack::create($fields);

                    $request->file('image')->storeAs('public/packs', $fileName);

                    return redirect()->back()->with('success', 'Pack registration successful');
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
    public function viewPack($id)
    {

        $pack = Pack::find($id);
        if ($pack) {
            $ingredients = PackContent::where('pack_id', $id)->with(['pack', 'ingredient'])->get();
            $packContents = PackContent::where('pack_id', $id)->get();
            $ingredientIds = [];
            foreach ($packContents as $menuContent) {
                array_push($ingredientIds, $menuContent->ingredient_id);
            }
            $notIngredients = Ingredient::whereNotIn('id', $ingredientIds)->get();
            return view('pages/pack/viewPack')
                ->with('pack', $pack)
                ->with('ingredients', $ingredients)
                ->with('notIngredients', $notIngredients);
        } else {
            return redirect()->route('pack-management');
        }
    }


    public function updatePack(Request $request)
    {

        $fields = [];

        $Pack = Pack::find($request['id']);

        if ($Pack) {

            if ($request['name'] != null) {
                if ($request['name'] != $Pack->name) {
                    if ($this->checkPackName($request['name'])) {
                        $fields['name'] = $request['name'];
                    } else {
                        return redirect()->back()->with('error', "this name has already been used");
                    }
                }
            }
            if ($request['unitPrice'] != null) {
                $fields['unitPrice'] = $request['unitPrice'];
            }

            if ($request['image'] != null) {
                $imageFullName = $request->file('image')->getClientOriginalName();
                $fileName = strtotime(Carbon::now()) . $imageFullName;
                $fields['image'] = $fileName;
            }


            try {

                Pack::where('id', $Pack->id)->update($fields);
                if ($request['image'] != null) {
                    $request->file('image')->storeAs('public/packs', $fileName);
                }
                return redirect()->back()->with('success', 'Pack updated successful');
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', "Pack does not exist");
        }
    }


    public function packIngredient($id, Request $request)
    {
        $fields = $request->validate([
            'ingredient_id' => 'required',
            'quantity' => 'required',
        ]);
        $fields += ['pack_id' => $id];


        if ($this->checkPackContent($id, $fields['ingredient_id'])) {

            try {
                //code...
                PackContent::create($fields);
                return redirect()->back()->with('success', "ingredient added successfully");
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {

            return redirect()->back()->with('error', 'this ingredient already exist in the pack');
        }
    }




    public function deletePack($id)
    {
        try {
            //code...
            Pack::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Pack deleted successful');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function deletePackIngredient($pack_id, $ingredient_id){

        try {
            //code...
            PackContent::where('pack_id', $pack_id)->where('ingredient_id', $ingredient_id)->delete();
            return redirect()->back()->with('success', 'Deleted successful');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function checkPackName($name)
    {
        if (Pack::where('name', $name)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }


    public function checkPackContent($pack_id, $ingredient_id)
    {
        if (PackContent::where('pack_id', $pack_id)->where('ingredient_id', $ingredient_id)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}
