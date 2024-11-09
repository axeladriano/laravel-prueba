<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return DB::table('events')
        ->orderByDesc('events.id')
        ->paginate(15, ['*'], 'page', $request->input('page'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $e = DB::table('events')->insertGetId([
                'nombre'=> $request->input('nombre'),
                'descripcion'=> $request->input('descripcion'),
                'fecha'=> $request->input('fecha'),
                'capacidad_max'=> $request->input('capacidad_max'),
                'created'=> now(),
            ]);
            $data = Db::table('events')->where('id','=',$e)->first();

            DB::commit();
            return response()->json(['message'=> 'Correcto','data'=> $data],200);
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

        $data = DB::table('reservations')->where('idEstado','=',1)->where('events_id',$id)->get();

        $ticket = $data->sum('tickets');
       $data = DB::table('events as r')
       ->select('r.*',
       )
       ->where('r.id','=',$id)->first();

       $d = [
        'id'=> $data->id,
        'nombre'=> $data->nombre,
        'descripcion'=> $data->descripcion,
        'fecha'=> $data->fecha,
        'capacidad_max'=> $data->capacidad_max,
        'restante'=> $data->capacidad_max - $ticket,
        'idEstado'=> $data->idEstado];

        return $d;
     
    }
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaccion();

            $e = DB::table('events')->where('id',$id)->update([
                'nombre'=> $request->input('nombre'),
                'descripcion'=> $request->input('descripcion'),
                'fecha'=> $request->input('fecha'),
                'capacidad'=> $request->input('capacidad_max'),
            ]);
            
            DB::commit();

            $data = Db::table('events')->where('id','=',$$id)->first();

            DB::commit();
            return response()->json(['message'=> 'Correcto','data'=> $data],200);
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
        return  DB::table('events')->where('id',$id)->delete();
    }
}
