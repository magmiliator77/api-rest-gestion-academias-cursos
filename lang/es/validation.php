<?php

// Mensajes de error de validación en español.
// :attribute se cambia por el nombre del campo (ver 'attributes' al final).
return [
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser un texto.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'unique' => 'Ya existe un registro con ese :attribute.',
    'exists' => 'El valor de :attribute no existe.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha igual o posterior a :date.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'max' => [
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
        'numeric' => 'El campo :attribute no puede ser mayor que :max.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
        'numeric' => 'El campo :attribute debe ser como mínimo :min.',
    ],

    // Nombres de los campos tal y como se muestran en los errores
    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo',
        'password' => 'contraseña',
        'description' => 'descripción',
        'address' => 'dirección',
        'phone' => 'teléfono',
        'academy_id' => 'academia',
        'start_date' => 'fecha de inicio',
        'end_date' => 'fecha de fin',
        'capacity' => 'plazas',
        'surname' => 'apellidos',
        'date_of_birth' => 'fecha de nacimiento',
    ],
];
