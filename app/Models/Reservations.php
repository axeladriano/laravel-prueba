<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Reservations extends Model
{
    use HasFactory;


    protected $fillable = [
        'events_id'
    ];

    public function validar($request)
    {
         $validacion = Validator::make($request,[
            'tickets'=> 'required',
         ],[
            'tickets.required'=> 'El tiene que events_id debe ser requerido',
         ]);
         if($validacion->fails())
         {
            throw new \ValidationException($validacion);
         }
    }

}
