<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reservations;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        return DB::table('reservations')
        ->orderByDesc('reservations.id')
        ->paginate(15, ['*'], 'page', $request->input('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            //(new Reservations)->validar($request->all());
            
            $e = DB::table('reservations')->insertGetId([
                'events_id'=> $request->input('events_id'),
                'id_user'=> $request->input('id_user'),
                'tickets'=> $request->input('tickets'),
            ]);
            $data = DB::table('reservations')->where('id',$e)->first();
            DB::commit();
            return response()->json(['data'=> $data],400);
        }
        catch(Exception $e)
        {
            DB::rollback();
            return response()->json(['Error'=> $e->getMessage()],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
           //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaccion();

            $e = DB::table('reservations')->where('id',$id)->update([
                'events_id'=> $request->input('events_id'),
                'id_user'=> $request->input('id_user'),
                'tickets'=> $request->input('tickets'),
            ]);
            $data = DB::table('reservations')->where('id',$id)->first();
            DB::commit();
            return response()->json(['data'=> $data],400);
        }
        catch(Exception $e)
        {
            DB::rollback();
            return response()->json(['Error'=> $e->getMessage()],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return  DB::table('reservations')->where('id',$id)->delete();
    }
}
