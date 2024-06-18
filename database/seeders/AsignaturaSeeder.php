<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Asignatura;
use App\Models\Seccion;
use Illuminate\Support\Facades\Hash;

class AsignaturaSeeder extends Seeder
{
    public function run()
    {
        // Crear algunos estudiantes
        $estudiante1 = User::create([
            'name' => 'Javier Guirigay',
            'role' => 'admin',
            'cedula' => '29589425',
            'username' => 'm29589425',
            'email' => 'javierguirigay21@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $profe1 = User::create([
            'name' => 'Heickel Loretto',
            'role' => 'teacher',
            'cedula' => '23999999',
            'username' => 'm23999999',
            'email' => 'Heickelloretto@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $profe2 = User::create([
            'name' => 'Anibal farinas',
            'role' => 'teacher',
            'cedula' => '23539583',
            'username' => 'm23539583',
            'email' => 'afarinas.udomonagas@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $estudiante3 = User::create([
            'name' => 'Pascual Perales',
            'role' => 'student',
            'cedula' => '26999993',
            'username' => 'm26999993',
            'email' => 'paacualperales2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $estudiante4 = User::create([
            'name' => 'Diana Fermin',
            'role' => 'student',
            'cedula' => '26999994',
            'username' => 'm26999994',
            'email' => 'dianafermin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Crear algunas asignaturas
        $asignatura1 = Asignatura::create(['nombre' => 'Modelos 1', 'codigo' => 'Mod-111']);
        $asignatura2 = Asignatura::create(['nombre' => 'Planificación Estratégica', 'codigo' => 'PlE-600']);
        $asignatura3 = Asignatura::create(['nombre' => 'Dinamicos', 'codigo' => 'Din-999']);
        $asignatura4 = Asignatura::create(['nombre' => 'Programación Orientada a Objetos', 'codigo' => 'POO-001']);
        $asignatura5 = Asignatura::create(['nombre' => 'Electronica', 'codigo' => 'Elc-000']);
        // Crear algunas secciones
        $seccion1 = Seccion::create(['nombre' => '01', 'capacidad' => 1, 'asignatura_id' => $asignatura1->id]);
        $seccion2 = Seccion::create(['nombre' => '02', 'capacidad' => 1, 'asignatura_id' => $asignatura1->id]);
        $seccion3 = Seccion::create(['nombre' => '01', 'capacidad' => 3, 'asignatura_id' => $asignatura2->id]);
        $seccion4 = Seccion::create(['nombre' => '02', 'capacidad' => 3, 'asignatura_id' => $asignatura2->id]);
        $seccion5 = Seccion::create(['nombre' => '01', 'capacidad' => 3, 'asignatura_id' => $asignatura3->id]);
        $seccion6 = Seccion::create(['nombre' => '02', 'capacidad' => 3, 'asignatura_id' => $asignatura3->id]);
        $seccion7 = Seccion::create(['nombre' => '01', 'capacidad' => 3, 'asignatura_id' => $asignatura4->id]);
        $seccion8 = Seccion::create(['nombre' => '02', 'capacidad' => 3, 'asignatura_id' => $asignatura4->id]);
        $seccion9 = Seccion::create(['nombre' => '01', 'capacidad' => 3, 'asignatura_id' => $asignatura5->id]);
        $seccion10 = Seccion::create(['nombre' => '02', 'capacidad' => 3, 'asignatura_id' => $asignatura5->id]);
        // Relacionar profesor con asignaturas
        $profe1->asignaturas()->attach([$asignatura1->id, $asignatura2->id]);
        $profe2->asignaturas()->attach([$asignatura3->id, $asignatura4->id, $asignatura5->id]);
        // Relacionar profesor con secciones
        $profe1->secciones()->attach([$seccion1->id, $seccion2->id, $seccion3->id, $seccion4->id]);
        $profe2->secciones()->attach([$seccion5->id, $seccion6->id, $seccion7->id, $seccion8->id, $seccion9->id, $seccion10->id]);    
    }
}
