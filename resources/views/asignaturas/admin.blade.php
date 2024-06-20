@php
    $nombre = Auth::user()->name;
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
            <p class="text-xl text-gray-900 px-6">
                Administrador {{ $nombre }}
            </p>
            @if(!empty($secciones))
            <p class="p-6 text-lg text-gray-900">
                Total asignaturas:
            </p>
            @foreach ($secciones as $seccion)
                @php
                    $asignatura = $seccion->asignatura;
                    $solicitudes_anexos = $seccion->solicitudes_anexos;
                @endphp
                <div class="p-6 flex flex-col space-x-2">
                    <div class="flex-1">
                        <p class="text-lg text-gray-900">
                            {{ $asignatura->nombre }} - {{ $asignatura->codigo }} (seccion {{ $seccion->nombre }})
                            <br />
                            Capacidad: {{ $seccion->capacidad }} estudiantes
                            <br />
                            Estudiantes inscritos: {{ $seccion->total_estudiantes }} estudiantes
                        </p>
                    </div>
                    @if($solicitudes_anexos->count() > 0)
                    <div class="flex-1">
                        <p class="px-0 pt-2 text-lg text-gray-900">
                            Solicitudes de anexo: {{ $solicitudes_anexos->count() }}
                        </p>
                        @foreach ($solicitudes_anexos as $anexo)
                            <div class="flex space-x-2">
                                <div class="flex-1">
                                    <p class="text-lg text-gray-900">
                                        {{ $anexo->usuario->name }} <br /> solicita anexo para {{ $anexo->asignatura->nombre }} - {{ $anexo->asignatura->codigo }} (seccion {{ $anexo->seccion->nombre }})
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
                                    <div class="flex space-x-2 my-2">
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
                    </div>
                    @endif
                </div>
            @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
