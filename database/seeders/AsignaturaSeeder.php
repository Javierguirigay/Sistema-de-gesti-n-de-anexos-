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
            'name' => 'Pascual Perales',
            'role' => 'admin',
            'cedula' => '26999999',
            'username' => 'm26999999',
            'email' => 'pascualperales@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $profe1 = User::create([
            'name' => 'Pascualito Perales',
            'role' => 'teacher',
            'cedula' => '26999992',
            'username' => 'm26999992',
            'email' => 'pascualitoperales@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $estudiante3 = User::create([
            'name' => 'Pascual Perales 2',
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
        $asignatura1 = Asignatura::create(['nombre' => 'Matemáticas', 'codigo' => 'MAT-101']);
        $asignatura2 = Asignatura::create(['nombre' => 'Historia', 'codigo' => 'HIS-101']);

        // Crear algunas secciones
        $seccion1 = Seccion::create(['nombre' => '01', 'capacidad' => 1, 'asignatura_id' => $asignatura1->id]);
        $seccion2 = Seccion::create(['nombre' => '02', 'capacidad' => 1, 'asignatura_id' => $asignatura1->id]);
        $seccion3 = Seccion::create(['nombre' => '01', 'capacidad' => 3, 'asignatura_id' => $asignatura2->id]);

        // Relacionar profesor con asignaturas
        $profe1->asignaturas()->attach([$asignatura1->id, $asignatura2->id]);

        // Relacionar profesor con secciones
        $profe1->secciones()->attach([$seccion2->id, $seccion3->id]);
    }
}
