<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class NewController extends Controller
{
    /* Blocks url connection for all excepts logged user and index and show pages*/
    public function __construct()
    {
        
        $this->middleware('auth', ['except' => ['index', 'show']]);
       
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        /* Check if admin is logged, if not redirects to with error msg*/
        if (auth()->user()->id != 1) {     

            return redirect('/')->with('error', 'Página não permitida');
        }
        /*Gets recipes from DB where column new = 1 (was inserted but still not accepted by admin) and shows in view */
        $recipes = Recipe::Where('new', '1')->get(); 
        return view('pages.new')->with('recipes', $recipes);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update($id)
    {
        $recipe = Recipe::find($id);
        if (auth()->user()->id != 1) {
            return redirect('/home')->with('error', 'Página não permitida');
        }
        /*Changes new to 0 (it will show in main page because was accepted by admin)*/
        $recipe->new = 0;
        $recipe->save();

        return redirect('/home/new')->with('success', 'Receita inserida com sucesso');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
