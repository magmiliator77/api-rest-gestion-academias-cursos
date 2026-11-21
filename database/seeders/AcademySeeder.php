<?php

namespace Database\Seeders;

use App\Models\Academy;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class AcademySeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios de prueba creados a mano (la contraseña de todos es "password").
        // Se guarda cifrada sola, porque el modelo User tiene 'password' => 'hashed'
        $ana = User::create([
            'name' => 'Ana',
            'email' => 'ana@example.com',
            'password' => 'password',
        ]);

        $luis = User::create([
            'name' => 'Luis',
            'email' => 'luis@example.com',
            'password' => 'password',
        ]);

        // Academias: dos de Ana y una de Luis
        $idiomas = Academy::create([
            'user_id' => $ana->id,
            'name' => 'Academia Babel',
            'description' => 'Cursos de idiomas para todas las edades',
            'address' => 'Calle Mayor 12, Almería',
            'phone' => '950123456',
            'email' => 'info@babel.example.com',
        ]);

        $informatica = Academy::create([
            'user_id' => $ana->id,
            'name' => 'Código Sur',
            'description' => 'Formación en programación y ofimática',
            'address' => 'Avenida del Mediterráneo 40, Almería',
            'phone' => '950654321',
            'email' => 'hola@codigosur.example.com',
        ]);

        $musica = Academy::create([
            'user_id' => $luis->id,
            'name' => 'Escuela de Música Allegro',
            'description' => 'Clases de piano, guitarra y lenguaje musical',
            'address' => 'Plaza de la Constitución 3, Roquetas de Mar',
            'phone' => '950987654',
            'email' => 'allegro@example.com',
        ]);

        // Cursos de cada academia
        $ingles = Course::create([
            'academy_id' => $idiomas->id,
            'name' => 'Inglés B1',
            'description' => 'Preparación del examen oficial de nivel B1',
            'start_date' => '2027-01-11',
            'end_date' => '2027-06-18',
            'capacity' => 15,
        ]);

        $frances = Course::create([
            'academy_id' => $idiomas->id,
            'name' => 'Francés para principiantes',
            'description' => 'Nivel A1 desde cero',
            'start_date' => '2027-02-01',
            'end_date' => '2027-05-28',
            'capacity' => 2,
        ]);

        $php = Course::create([
            'academy_id' => $informatica->id,
            'name' => 'PHP y Laravel',
            'description' => 'Desarrollo web en entorno servidor',
            'start_date' => '2027-01-18',
            'end_date' => '2027-04-30',
            'capacity' => 20,
        ]);

        $guitarra = Course::create([
            'academy_id' => $musica->id,
            'name' => 'Guitarra española',
            'description' => 'Iniciación a la guitarra',
            'start_date' => '2027-01-14',
            'end_date' => '2027-06-10',
            'capacity' => 10,
        ]);

        // Estudiantes
        $marta = Student::create([
            'name' => 'Marta',
            'surname' => 'García López',
            'email' => 'marta@example.com',
            'phone' => '600111222',
            'date_of_birth' => '2004-03-15',
        ]);

        $pablo = Student::create([
            'name' => 'Pablo',
            'surname' => 'Ruiz Martín',
            'email' => 'pablo@example.com',
            'phone' => '600333444',
            'date_of_birth' => '2002-11-02',
        ]);

        $lucia = Student::create([
            'name' => 'Lucía',
            'surname' => 'Fernández Gil',
            'email' => 'lucia@example.com',
            'phone' => '600555666',
            'date_of_birth' => '2006-07-21',
        ]);

        Student::create([
            'name' => 'Javier',
            'surname' => 'Sánchez Pérez',
            'email' => 'javier@example.com',
            'phone' => null,
            'date_of_birth' => '1999-01-30',
        ]);

        // Matrículas: attach añade la fila en la tabla pivote con su fecha
        $ingles->students()->attach($marta->id, ['enrolled_at' => now()]);
        $ingles->students()->attach($pablo->id, ['enrolled_at' => now()]);
        $frances->students()->attach($marta->id, ['enrolled_at' => now()]);
        $frances->students()->attach($lucia->id, ['enrolled_at' => now()]);
        $php->students()->attach($pablo->id, ['enrolled_at' => now()]);
        $guitarra->students()->attach($lucia->id, ['enrolled_at' => now()]);
    }
}
