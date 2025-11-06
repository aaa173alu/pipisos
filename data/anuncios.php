<?php
// Devuelve un array indexado con ejemplos de anuncios.
// Cada anuncio incluye campos requeridos por la práctica.
return [
    [
        'id' => 1,
        'tipo' => 'venta',
        'vivienda' => 'vivienda',
        'titulo' => 'Piso céntrico en Madrid',
        'texto' => 'Bonito piso de 3 habitaciones y 2 baños, con garaje incluido.',
        'fecha' => '2023-12-01',
        'ciudad' => 'Madrid',
        'pais' => 'España',
        'precio' => 250000,
        'caracteristicas' => [
            'superficie' => '95 m²',
            'habitaciones' => 3,
            'banos' => 2,
            'planta' => 2,
            'anio' => 2001,
        ],
        'fotos' => [
            'principal' => '/pipisos/img/casa-barcelona.svg',
            'galeria' => [
                '/pipisos/img/casa1_1.jpg',
                '/pipisos/img/casa1_2.jpg',
                '/pipisos/img/casa1_3.jpg',
            ],
        ],
        'usuario' => 'usuario1',
    ],
    [
        'id' => 2,
        'tipo' => 'alquiler',
        'vivienda' => 'chalet',
        'titulo' => 'Chalet con piscina en Málaga',
        'texto' => 'Amplio chalet familiar con jardín y piscina privada.',
        'fecha' => '2024-06-15',
        'ciudad' => 'Málaga',
        'pais' => 'España',
        'precio' => 320000,
        'caracteristicas' => [
            'superficie' => '220 m²',
            'habitaciones' => 4,
            'banos' => 3,
            'planta' => 1,
            'anio' => 1998,
        ],
        'fotos' => [
            'principal' => '/pipisos/img/chalet-malaga.svg',
            'galeria' => [
                '/pipisos/img/chalet1.jpg',
                '/pipisos/img/chalet2.jpg',
            ],
        ],
        'usuario' => 'usuario2',
    ],
];