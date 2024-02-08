<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstacionamientoModel;
use App\Models\Sede;

class EstacionamientoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $estacionamientos = EstacionamientoModel::where('deleted_at', null)->get();
        $sedes = Sede::where('deleted_at', null)->get();

        foreach($estacionamientos as $row) {
            $row['sede'] = $row->sede;
        }

        return response()->json([
            'status' => true,
            'estacionamientos' => $estacionamientos,
            'sedes' => $sedes
        ]);
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
        $estacionamiento = EstacionamientoModel::create([
            'numero' => $request->nro,
            'sede_id' => $request->sede_id
        ]);

        return response()->json([
            'status' => true,
            'estacionamiento' => $estacionamiento
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EstacionamientoModel  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(EstacionamientoModel $estacionamiento)
    {
        return response()->json($estacionamiento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EstacionamientoModel  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(EstacionamientoModel $estacionamiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $estacionamiento = EstacionamientoModel::findOrFail($id);
        // $estacionamiento->update($request->all());
        // $data = EstacionamientoModel::where('status',1)->get();
        $estacionamiento = EstacionamientoModel::find($id);

        $estacionamiento->numero = $request->nro;
        $estacionamiento->sede_id = $request->sede_id;
        $estacionamiento->update();

        return response()->json($estacionamiento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estacionamiento = EstacionamientoModel::find($id);

        $estacionamiento->deleted_at = date('Y-m-d H:i:s');
        $estacionamiento->update();

        return response()->json($estacionamiento);
    }
}
