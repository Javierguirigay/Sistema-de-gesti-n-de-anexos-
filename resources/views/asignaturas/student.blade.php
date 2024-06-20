@php
    // Obtener nombre de usuario y rol
    $nombre = Auth::user()->name;
    $rol = Auth::user()->role;
@endphp

<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @if(session('error'))
                <p class="px-6 text-lg text-red-500">{{ session('error') }}</p>
            @endif
            @if(session('success'))
                <p class="px-6 text-lg text-green-800">{{ session('success') }}</p>
            @endif
            @if(!empty($asignaturas))
            <p class="p-6 text-lg text-gray-900">
                Asignaturas inscritas: @if($asignaturas->count() === 0) No tienes asignaturas inscritas @endif
            </p>
            @foreach ($asignaturas as $asignatura)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <p class="text-lg text-gray-900">
                            {{ $asignatura->nombre }} - {{ $asignatura->codigo }} (seccion {{ $asignatura->seccion }})
                        </p>
                    </div>
                </div>
            @endforeach
            @endif
            @if(!empty($asignaturas_no_inscritas))
            <p class="p-6 text-lg text-gray-900">
                Asignaturas no inscritas:
            </p>
            @foreach ($asignaturas_no_inscritas as $asignatura)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <p class="text-lg text-gray-900">
                            {{ $asignatura->nombre }} - {{ $asignatura->codigo }} (seccion {{ $asignatura->seccion }})
                        </p>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <!-- Si no tiene solicitud de anexo para esta asignatura, mostrar un boton
                        para crear una solicitud de Anexo a la asignatura -->
                    @if(!$asignatura->tiene_solicitud)
                    <form method="POST" action="{{ route('anexos.store') }}">
                        @csrf
                        <input type="hidden" name="seccion_id" value="{{ $asignatura->seccion_id }}">
                        <x-primary-button>
                            {{ __('Solicitar anexo') }}
                        </x-primary-button>
                    </form>
                    <!-- Si la solicitud de anexo fue rechazada, mostrar un mensaje indicando
                        que el anexo fue rechazado -->
                    @elseif($asignatura->anexo_rechazado)
                    <p class="text-sm w-1/4 text-red-500">
                        Anexo rechazado
                    </p>
                    @elseif(!$asignatura->anexo_aceptado)
                    <!-- Si tiene solicitud de anexo para esta asignatura, mostrar un mensaje
                        indicando que ya se ha solicitado un anexo -->
                    <p class="text-sm w-1/4 text-gray-900">
                        Ya has solicitado un anexo para esta asignatura
                    </p>
                    @endif
                </div>
            @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
