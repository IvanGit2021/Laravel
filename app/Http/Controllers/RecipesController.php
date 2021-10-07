<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use Illuminate\Support\Facades\Storage;


class RecipesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show','meat','fish','vegetarian','dessert']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    public function index()
    {
        //Shows recipes accepted by admin with max 9 per page
        $recipes = Recipe::Where('new', '0')->paginate(9);
        
        return view('pages.index')->with('recipes', $recipes);
    }

    public function index2()
    {
        if (auth()->user()->id != 1) {
            return redirect('/')->with('error', 'Página não permitida');
        }
        //Shows recipes still not accepted by admin
        $recipes = Recipe::Where('new', '1')->paginate(9);
        return view('pages.new')->with('recipes', $recipes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
             //Requires values insertion on form
            'title' => 'required',
            'ingredients' => 'required',
            'cooking' => 'required',
            'image' => 'image|nullable|max:1999'
        ]);

        //Handle file upload

        if ($request->hasFile('image')) {
            //GEt filename with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //Get just the filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Gets name to store with timestamp so all names are different
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            //Upload image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noImage.jpg';
        }

        $recipe = new Recipe();
        $recipe->title = $request->input('title');
        $recipe->ingredients = $request->input('ingredients');
        $recipe->cooking = $request->input('cooking');
        $recipe->type = $request->input('type');
        $recipe->user_id = auth()->user()->id;
        $recipe->new = 1;
        $recipe->image = $fileNameToStore;
        $recipe->save();

        return redirect('/recipes')->with('success', 'Receita enviada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::find($id);
        return view('pages.show')->with('recipe', $recipe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);

        if (auth()->user()->id != 1) {
            return redirect('/')->with('error', 'Página não permitida');
        }
        return view('pages.edit')->with('recipe', $recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //same as store
    {
        $this->validate($request, [

            'title' => 'required',
            'ingredients' => 'required',
            'cooking' => 'required'
        ]);
        if ($request->hasFile('image')) {
            //GEt filename with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //Get just the filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            //Upload image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        }
        $recipe = Recipe::find($id);
        $recipe->title = $request->input('title');
        $recipe->ingredients = $request->input('ingredients');
        $recipe->cooking = $request->input('cooking');
        $recipe->type = $request->input('type');
        if ($request->hasFile('image')) {
            $recipe->image = $fileNameToStore;
        }
        $recipe->save();

        return redirect('/recipes')->with('success', 'Receita alterada com sucesso');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if (auth()->user()->id != 1) {
            return redirect('/')->with('error', 'Página não permitida');
        }
        //Deletes img from DB and folder
        if($recipe->image != 'noImage.jpg')
        Storage::delete('public/images/'.$recipe->image);
        $recipe->delete();
        return redirect('/recipes')->with('success', 'Receita removida com sucesso');
    }
}
