<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\fuel;
use App\Http\Resources\Fuel as FuelResource;

class FuelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fuel = Fuel::paginate(4);
        return FuelResource::collection($fuel);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fuel = $request->isMethod('put') ? Fuel::findorfail($request->fuel_id) : new Fuel;
        $fuel->id = $request->input('fuel_id');
        $fuel->tank = $request->input('tank');
        $fuel->dispenser_1 = $request->input('dispenser_1');
        $fuel->dispenser_2 = $request->input('dispenser_2');

        if($fuel->save()){
            return new FuelResource($fuel);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fuel = fuel::findorfail($id);
        return new FuelResource($fuel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fuel = fuel::findorfail($id);

        if($fuel->delete()){
            return new FuelResource($fuel);
        }
    }
}
