<?php
// Devuelve un array con usuarios permitidos (4 usuarios de ejemplo).
// Formato: [ ['user'=>'nombre','pass'=>'hash_password'], ... ]
// Las contraseñas están hasheadas con password_hash() para seguridad

return [
    // Contraseña: admin123
    ['user' => 'admin',    'pass' => '$2y$10$gkzpG3rIIxa3dMF6tct9auvv72sjh5uiS9On4qmBxSN3vwMczGLyG', 'estilo' => 'estilos.css'],
    // Contraseña: pass1
    ['user' => 'usuario1', 'pass' => '$2y$10$1gWcLkweqsKal7SDqClQPuom3fgxAfgtnFdTisnZb4Cw98MTwJ/WW', 'estilo' => 'oscuro.css'],
    // Contraseña: pass2
    ['user' => 'usuario2', 'pass' => '$2y$10$lr6/C0K3ataP6Ki6Eq8j1O2enm5CvjsWcQXiiaf2nZ8o/hOKviD.S', 'estilo' => 'contrastes.css'],
    // Contraseña: pass3
    ['user' => 'usuario3', 'pass' => '$2y$10$d6SbeEjaiWKEIPrnGFGOhuARuvDcnUs8g4ospa//JH6a4s4VpH2Pa', 'estilo' => 'contrasteGrande.css'],
];
