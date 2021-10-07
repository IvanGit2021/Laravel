<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe; /* Uses database Model Recipe */

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*Functions to return views with different recipes concerning type */
    
    public function meat(){

        $recipes = Recipe::where('type', 'carne')->get();
        return view('pages.meat')->with('recipes', $recipes);

    }
    public function fish(){

        $recipes = Recipe::where('type', 'peixe')->get();
        return view('pages.fish')->with('recipes', $recipes);

    }
    public function dessert(){

        $recipes = Recipe::where('type', 'sobremesa')->get();
        return view('pages.dessert')->with('recipes', $recipes);

    }
    public function soup(){

        $recipes = Recipe::where('type', 'sopa')->get();
        return view('pages.soup')->with('recipes', $recipes);

    }
    public function vegetarian(){

        $recipes = Recipe::where('type', 'vegetariano')->get();
        return view('pages.vegetarian')->with('recipes', $recipes);

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
    public function update(Request $request, $id)
    {
        //
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
