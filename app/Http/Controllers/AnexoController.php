<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use App\Models\Anexo;
use App\Models\Asignatura;
use App\Models\User_Asignatura;
use App\Models\Seccion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnexoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
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
    public function store(Request $request): RedirectResponse
    {
        // crear anexo y asociar a la seccion y al usuario que lo sube
        $request->validate([
            'seccion_id' => 'required',
        ]);

        $usuario = auth()->user();

        // Obtener solicitudes de anexo del usuario
        $anexos_usuario = Anexo::all()->where('user_id', $usuario->id);

        // Verificar si el usuario ya tiene una solicitud de anexo para la sección
        if ($anexos_usuario->where('seccion_id', $request->seccion_id)->first() !== null) {
            return redirect()->back()->with('error', 'Ya has enviado una solicitud de anexo para esta sección.');
        }

        // Obtener la sección
        $seccion = Seccion::find($request->seccion_id);

        // Obtener la asignatura a la que pertenece la sección
        $asignatura = Asignatura::find($seccion->asignatura_id);

        // Obtener las asignaturas dentro de las solicitudes de anexo del usuario
        $asignaturas_anexo = [];
        foreach($anexos_usuario as $anexo) {
            $seccion = Seccion::find($anexo->seccion_id);
            $temp_asignatura = Asignatura::find($seccion->asignatura_id);
            $asignaturas_anexo[] = $temp_asignatura->id;
        }

        // Verificar si el usuario ya está inscrito en la asignatura
        if (User_Asignatura::where('user_id', $usuario->id)->where('asignatura_id', $asignatura->id)->first() !== null) {
            return redirect()->back()->with('error', 'Ya estás inscrito en esta asignatura.');
        }

        // Verificar si el usuario ya tiene una solicitud de anexo para esta asignatura
        $asignatura_solicitada = in_array($asignatura->id, $asignaturas_anexo);
        if ($asignatura_solicitada) {
            return redirect()->back()->with('error', 'Ya has enviado una solicitud de anexo para esta asignatura.');
        }

        $anexo = new Anexo();
        $anexo->user_id = $usuario->id;
        $anexo->seccion_id = $request->seccion_id;
        $anexo->aceptado = false;
        $anexo->rechazado = false;
        $anexo->save();

        return redirect()->back()->with('success', 'Solicitud de anexo enviada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anexo $anexo): RedirectResponse
    {
        $usuario = auth()->user();
        if (!$usuario->role === 'teacher' || !$usuario->role === 'admin') {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        // Verifica si el usuario tiene la seccion
        $secciones_usuario = $usuario->secciones;
        $seccion = Seccion::find($anexo->seccion_id);
        
        if (!$secciones_usuario->contains($seccion)) {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        $aprobado = $request->input('aceptado');
        $rechazado = $request->input('rechazado');

        if ($aprobado && $rechazado) {
            return redirect()->back()->with('error', 'No puedes aceptar y rechazar una solicitud de anexo al mismo tiempo.');
        }

        if (!$aprobado && !$rechazado) {
            return redirect()->back()->with('error', 'Debes aceptar o rechazar la solicitud de anexo.');
        }

        $estudiante = User::find($anexo->user_id);

        // Verificar si el estudiante ya está inscrito en la asignatura
        $asignatura = Asignatura::find($seccion->asignatura_id);
        if (User_Asignatura::where('user_id', $estudiante->id)->where('asignatura_id', $asignatura->id)->first() !== null) {
            return redirect()->back()->with('error', 'El estudiante ya está inscrito en esta asignatura.');
        }

        if ($aprobado) {
            $anexo->aceptado = true;
            $anexo->rechazado = false;

            $estudiante = User::find($anexo->user_id);
            $estudiante->asignaturas()->attach([$seccion->asignatura_id]);
            $estudiante->secciones()->attach([$seccion->id]);
        } else {
            $anexo->aceptado = false;
            $anexo->rechazado = true;
        }

        $anexo->save();

        return redirect()->back()->with('success', 'Solicitud de anexo actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();
        return redirect(route('chirps.index'));
    }
}
