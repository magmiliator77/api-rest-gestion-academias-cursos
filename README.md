# API REST de gestión de academias y cursos (Práctica final 4.7)

API en Laravel, solo backend, que devuelve y recibe JSON. Los usuarios se registran y entran con un token de Laravel Sanctum, crean academias, dan de alta cursos en ellas y matriculan estudiantes en los cursos.

## Capturas

Cada captura es una petición de la colección de Postman y la respuesta JSON que devuelve el servidor, hechas en orden con los datos del seeder recién cargados (`migrate:fresh --seed`) y entrando como Ana.

### Autenticación

| POST `/api/register` → 201 | POST `/api/register` → 422 |
|---|---|
| ![Registro](docs/capturas/01-registro.png) | ![Registro con datos no válidos (422)](docs/capturas/02-registro-con-datos-no-validos.png) |

| POST `/api/login` → 401 | POST `/api/login` → 200 |
|---|---|
| ![Login con contraseña incorrecta (401)](docs/capturas/03-login-con-contrasena-incorrecta.png) | ![Login de Ana (guarda el token)](docs/capturas/04-login-de-ana.png) |

### Academias

| GET `/api/academies` → 401 | GET `/api/academies` → 200 |
|---|---|
| ![Listar academias sin token (401)](docs/capturas/05-listar-academias-sin-token.png) | ![Listar academias](docs/capturas/06-listar-academias.png) |

| POST `/api/academies` → 201 | POST `/api/academies` → 422 |
|---|---|
| ![Crear academia (201)](docs/capturas/07-crear-academia.png) | ![Crear academia con datos no válidos (422)](docs/capturas/08-crear-academia-con-datos-no-validos.png) |

| GET `/api/academies/4` → 200 | GET `/api/academies/99` → 404 |
|---|---|
| ![Ver una academia](docs/capturas/09-ver-una-academia.png) | ![Ver academia que no existe (404)](docs/capturas/10-ver-academia-que-no-existe.png) |

| PUT `/api/academies/4` → 200 | PUT `/api/academies/3` → 403 |
|---|---|
| ![Modificar mi academia](docs/capturas/11-modificar-mi-academia.png) | ![Modificar academia de Luis (403)](docs/capturas/12-modificar-academia-de-luis.png) |

| DELETE `/api/academies/3` → 403 | DELETE `/api/academies/4` → 200 |
|---|---|
| ![Borrar academia de Luis (403)](docs/capturas/13-borrar-academia-de-luis.png) | ![Borrar mi academia](docs/capturas/14-borrar-mi-academia.png) |

### Cursos

| GET `/api/courses` → 200 | POST `/api/courses` → 201 |
|---|---|
| ![Listar cursos](docs/capturas/15-listar-cursos.png) | ![Crear curso en mi academia (201)](docs/capturas/16-crear-curso-en-mi-academia.png) |

| POST `/api/courses` → 422 | POST `/api/courses` → 403 |
|---|---|
| ![Crear curso con fechas al revés (422)](docs/capturas/17-crear-curso-con-fechas-al-reves.png) | ![Crear curso en academia de Luis (403)](docs/capturas/18-crear-curso-en-academia-de-luis.png) |

| GET `/api/courses/5` → 200 | GET `/api/courses/99` → 404 |
|---|---|
| ![Ver un curso](docs/capturas/19-ver-un-curso.png) | ![Ver curso que no existe (404)](docs/capturas/20-ver-curso-que-no-existe.png) |

| PUT `/api/courses/5` → 200 | PUT `/api/courses/4` → 403 |
|---|---|
| ![Modificar mi curso](docs/capturas/21-modificar-mi-curso.png) | ![Modificar curso de Luis (403)](docs/capturas/22-modificar-curso-de-luis.png) |

| DELETE `/api/courses/4` → 403 | DELETE `/api/courses/5` → 200 |
|---|---|
| ![Borrar curso de Luis (403)](docs/capturas/23-borrar-curso-de-luis.png) | ![Borrar mi curso](docs/capturas/24-borrar-mi-curso.png) |

### Matrículas (N:N)

| GET `/api/academy/1/courses` → 200 | GET `/api/academy/99/courses` → 404 |
|---|---|
| ![Cursos de una academia, sin token](docs/capturas/25-cursos-de-una-academia-sin-token.png) | ![Cursos de una academia que no existe (404)](docs/capturas/26-cursos-de-una-academia-que-no-existe.png) |

| GET `/api/course/1/students` → 401 | GET `/api/course/1/students` → 200 |
|---|---|
| ![Estudiantes de un curso sin token (401)](docs/capturas/27-estudiantes-de-un-curso-sin-token.png) | ![Estudiantes de un curso](docs/capturas/28-estudiantes-de-un-curso.png) |

| POST `/api/courses/1/enroll/4` → 201 | POST `/api/courses/1/enroll/4` → 409 |
|---|---|
| ![Matricular a Javier en Inglés B1 (201)](docs/capturas/29-matricular-a-javier-en-ingles-b1.png) | ![Matricularlo otra vez (409)](docs/capturas/30-matricularlo-otra-vez.png) |

| POST `/api/courses/2/enroll/4` → 409 | POST `/api/courses/4/enroll/4` → 403 |
|---|---|
| ![Matricular en un curso lleno (409)](docs/capturas/31-matricular-en-un-curso-lleno.png) | ![Matricular en curso de Luis (403)](docs/capturas/32-matricular-en-curso-de-luis.png) |

| POST `/api/courses/1/enroll/99` → 404 | DELETE `/api/courses/1/unenroll/4` → 200 |
|---|---|
| ![Matricular a un estudiante que no existe (404)](docs/capturas/33-matricular-a-un-estudiante-que-no-existe.png) | ![Desmatricular a Javier](docs/capturas/34-desmatricular-a-javier.png) |

| DELETE `/api/courses/1/unenroll/4` → 404 |  |
|---|---|
| ![Desmatricularlo otra vez (404)](docs/capturas/35-desmatricularlo-otra-vez.png) |  |

### Cerrar sesión

| POST `/api/logout` → 200 | POST `/api/logout` → 401 |
|---|---|
| ![Logout](docs/capturas/36-logout.png) | ![Logout con el token ya borrado (401)](docs/capturas/37-logout-con-el-token-ya-borrado.png) |

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
