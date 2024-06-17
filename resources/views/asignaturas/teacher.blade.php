@php
    // Obtener nombre de usuario y rol
    $nombre = Auth::user()->name;
    $rol = Auth::user()->role;
@endphp

<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <p class="text-xl text-gray-900 px-6">
                Profesor {{ $nombre }}
            </p>
            @if(!empty($asignaturas))
            <p class="px-6 text-lg text-gray-900">
                Asignaturas dictadas:
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
            @if(!empty($solicitudes_anexo))
            <p class="px-6 text-lg text-gray-900">
                Solicitudes de anexo:
            </p>
            @foreach ($solicitudes_anexo as $_anexo)
                @foreach ($_anexo as $anexo)
                    <div class="p-6 flex space-x-2">
                        <div class="flex-1">
                            <p class="text-lg text-gray-900">
                                {{ $anexo->usuario->name }} solicita anexo para {{ $anexo->asignatura->nombre }} - {{ $anexo->asignatura->codigo }} (seccion {{ $anexo->seccion->nombre }})
                            </p>
                            @if($anexo->rechazado)
                                <p class="text-lg text-red-500">
                                    Anexo rechazado
                                </p>
                            @elseif($anexo->aceptado)
                                <p class="text-lg text-green-600">
                                    Anexo aprobado
                                </p>
                            @else
                            <div class="flex space-x-2 mt-4">
                                <form method="post" action="{{ route('anexos.update', $anexo->id) }}">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="rechazado" value="true">
                                    <x-primary-button>
                                        {{ __('Rechazar anexo') }}
                                    </x-primary-button>
                                </form>
                                <form method="post" action="{{ route('anexos.update', $anexo->id) }}">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="aceptado" value="true">
                                    <x-primary-button>
                                        {{ __('Aprobar anexo') }}
                                    </x-primary-button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
            @endif
            @if(session('error'))
                <p class="px-6 text-lg text-red-500">{{ session('error') }}</p>
            @endif
            @if(session('success'))
                <p class="px-6 text-lg text-green-800">{{ session('success') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>
