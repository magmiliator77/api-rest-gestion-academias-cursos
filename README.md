# API REST de gestión de academias y cursos (Práctica final 4.7)

API en Laravel, solo backend, que devuelve y recibe JSON. Los usuarios se registran y entran con un token de Laravel Sanctum, crean academias, dan de alta cursos en ellas y matriculan estudiantes en los cursos.

## Cómo arrancarlo

```bash
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

Con `--seed` se crean los datos de prueba (sin `--seed` las tablas quedan vacías):

- Usuarios `ana@example.com` y `luis@example.com`, los dos con la contraseña `password`.
- Ana tiene dos academias (Academia Babel y Código Sur) y Luis una (Escuela de Música Allegro).
- Cuatro cursos y cuatro estudiantes, con algunas matrículas. El curso de francés está lleno (2 plazas) para probar el error de plazas.

La API queda en `http://localhost/api`. En Postman hay que mandar la cabecera `Accept: application/json` y, en las rutas protegidas, `Authorization: Bearer <token>`.

## Tablas

| Tabla | Campos |
|---|---|
| users | id, name, email, password, timestamps |
| academies | id, user_id, name, description, address, phone, email, timestamps |
| courses | id, academy_id, name, description, start_date, end_date, capacity, timestamps |
| students | id, name, surname, email, phone, date_of_birth, timestamps |
| course_student | id, course_id, student_id, enrolled_at, timestamps |

Relaciones: un usuario tiene muchas academias (1:N), una academia tiene muchos cursos (1:N) y cursos y estudiantes se relacionan N:N con la tabla pivote `course_student`.

## Endpoints

### Autenticación

| Método | Ruta | Token | Qué hace | Respuesta |
|---|---|---|---|---|
| POST | /api/register | No | Crea el usuario y devuelve su token | 201, o 422 si los datos no son válidos |
| POST | /api/login | No | Comprueba email y contraseña y devuelve un token | 200, o 401 si no coinciden |
| POST | /api/logout | Sí | Borra el token con el que se hace la petición | 200, o 401 sin token |

### Academias y cursos (CRUD con `apiResource`)

Todas necesitan token (401 sin él). Cualquier usuario puede ver todas las academias y cursos, pero solo el dueño puede modificarlos o borrarlos (403 si no es suyo). Un curso es del dueño de su academia.

| Método | Ruta | Qué hace | Respuesta |
|---|---|---|---|
| GET | /api/academies | Lista todas las academias | 200 |
| POST | /api/academies | Crea una academia del usuario | 201, o 422 |
| GET | /api/academies/{id} | Muestra una academia | 200, o 404 |
| PUT | /api/academies/{id} | Modifica una academia propia | 200, 403, 404 o 422 |
| DELETE | /api/academies/{id} | Borra una academia propia y sus cursos | 200, 403 o 404 |
| GET | /api/courses | Lista todos los cursos | 200 |
| POST | /api/courses | Crea un curso en una academia propia | 201, 403 o 422 |
| GET | /api/courses/{id} | Muestra un curso | 200, o 404 |
| PUT | /api/courses/{id} | Modifica un curso de una academia propia | 200, 403, 404 o 422 |
| DELETE | /api/courses/{id} | Borra un curso de una academia propia | 200, 403 o 404 |

### Cursos de una academia y matrículas (rutas no-REST, relación N:N)

| Método | Ruta | Token | Qué hace | Respuesta |
|---|---|---|---|---|
| GET | /api/academy/{academy}/courses | No | Cursos de una academia | 200, o 404 |
| GET | /api/course/{course}/students | Sí | Estudiantes del curso con su fecha de matrícula | 200, o 404 |
| POST | /api/courses/{course}/enroll/{student} | Sí | Matricula al estudiante (`attach`) | 201; 403 si el curso no es tuyo; 404; 409 si ya está matriculado o no quedan plazas |
| DELETE | /api/courses/{course}/unenroll/{student} | Sí | Desmatricula al estudiante (`detach`) | 200; 403; 404 si no existe o no estaba matriculado |
