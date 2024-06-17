<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use App\Models\Anexo;
use App\Models\User;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = auth()->user();

        switch($usuario->role) {
            case 'teacher':
                return $this->teacherIndex();
            case 'student':
                return $this->studentIndex();
            case 'admin':
                return $this->adminIndex();
        }
    }

    public function adminIndex()
    {
    }

    public function teacherIndex()
    {
        $usuario = auth()->user();
        // Carga las asignaturas del usuario
        $asignaturas = $usuario->secciones->map(function ($seccion) {
            $temp_asignatura = $seccion->asignatura;
            $temp_asignatura->seccion = $seccion->nombre;
            return $temp_asignatura;
        });

        // Obtener informacion de los anexos de las asignaturas
        $solicitudes_anexo = $usuario->secciones->map(function ($seccion) {
            // Obtener anexos de esta seccion
            $anexos = Anexo::where('seccion_id', $seccion->id)->get();

            // Obtener informacion de los usuarios que solicitaron anexo
            $anexos = $anexos->map(function ($anexo) {
                $anexo_usuario = User::find($anexo->user_id);
                $anexo->usuario = $anexo_usuario;

                $anexo_seccion = Seccion::find($anexo->seccion_id);
                $anexo->seccion = $anexo_seccion;

                $anexo_asignatura = Asignatura::find($anexo_seccion->asignatura_id);
                $anexo->asignatura = $anexo_asignatura;
                return $anexo;
            });
            return $anexos;
        });

        // Devuelve la vista con las asignaturas
        return view('asignaturas.teacher', compact('asignaturas', 'solicitudes_anexo'));
    }

    public function studentIndex()
    {
        $usuario = auth()->user();
        // Carga las asignaturas del usuario
        $asignaturas = $usuario->secciones->map(function ($seccion) {
            $temp_asignatura = $seccion->asignatura;
            $temp_asignatura->seccion = $seccion->nombre;
            return $temp_asignatura;
        });

        // IDs de las asignaturas a excluir
        $excludedAsignaturasIds = $asignaturas->pluck('id');

        $secciones_no_inscritas = Seccion::all()->whereNotIn('asignatura_id', $excludedAsignaturasIds);

        $asignaturas_no_inscritas = collect();

        foreach ($secciones_no_inscritas as $seccion) {
            $temp_asignatura = $seccion->asignatura;
            $temp_asignatura->seccion = $seccion->nombre;
            $temp_asignatura->seccion_id = $seccion->id;

            // Obtener solicitudes de anexo del usuario
            $anexo = Anexo::where('user_id', $usuario->id)
                ->where('seccion_id', $seccion->id)
                ->first();

            $temp_asignatura->tiene_solicitud = $anexo ? true : false;

            if ($anexo) {
                $temp_asignatura->anexo_rechazado = $anexo->rechazado;
                $temp_asignatura->anexo_aceptado = $anexo->aceptado;
            }

            // Agregar la asignatura a la colección
            $asignaturas_no_inscritas->push($temp_asignatura);
        }

        // Devuelve la vista con las asignaturas
        return view('asignaturas.index', compact('asignaturas', 'asignaturas_no_inscritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Asignatura $asignatura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignatura $asignatura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignatura $asignatura)
    {
        //
    }
}
