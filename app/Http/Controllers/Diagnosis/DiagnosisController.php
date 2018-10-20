<?php

namespace App\Http\Controllers\Diagnosis;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Incidence\Incidence;
use App\Models\TypeInput;
use App\Models\Solicitude;

class DiagnosisController extends Controller
{
    public function index(){
        dd(route('diagnosis.show', ['id' => 1]));
        $solicitudes = Solicitude::where('is_deleted', 0)->get()->pluck('title', 'id');
        return view('diagnosis.parameterization.index')->with('solicitudes', $solicitudes);
    }

    public function create(){
        try{
            $inputs = TypeInput::all()->pluck('name','id');
        }catch(QueryException $queryException){
            abort(404, 'Ha sucedido un problema al cargar los tipos de campos');
        }
                
        return view('diagnosis.parameterization.create')->with(['inputs' => $inputs]);
    }    

    public function show($id){
        $incidencia = Incidence::with('solicitude')->find($id);
        dd($incidencia);
        return view('diagnosis.consulta.index');
    }
}