<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sedes = Sede::where('deleted_at', null)->get();

        return response()->json([
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
        try {
            $sede = Sede::create([
                'name' => $request->name,
                'email' => $request->email
            ]);
    
            return response()->json([
                'status' => true,
                'sede_created' => $sede,
                'message' => 'sede created successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'sede_created' => $sede,
                'message' => $th->getMessage()
            ]);
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
        $sede = Sede::find($id);

        $sede->name = $request->name;
        $sede->email = $request->email;
        $sede->update();

        return response()->json([
            'sede' => $sede
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sede = Sede::find($id);

        $sede->deleted_at = date('Y-m-d H:i:s');
        $sede->update();

        return response()->json([
            'status' => true,
            'sede' => $sede
        ]);
    }
}
