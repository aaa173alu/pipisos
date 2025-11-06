<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pisos & Inmuebles</title>

    <link rel="stylesheet" href="/pipisos/css/estilos.css" title="Modo claro">
    <link rel="alternate stylesheet" href="/pipisos/css/oscuro.css" title="Modo oscuro">
    <link rel="alternate stylesheet" href="/pipisos/css/contrastes.css" title="Modo contrastes">
    <link rel="alternate stylesheet" href="/pipisos/css/letraGrande.css" title="Modo letra grande">
    <link rel="alternate stylesheet" href="/pipisos/css/contrasteGrande.css" title="Modo letra grande y alto contraste">
    <link rel="stylesheet" href="/pipisos/css/impresion.css" media="print">
    <link rel="stylesheet" href="/pipisos/css/fontello.css">
</head>

<body>

    <header>
        <div class="top-header">
            <a href="/pipisos/index.php" class="logo">
                <img src="/pipisos/img/logo.png" alt="Pisos & Inmuebles">
            </a>

            <div class="search-user-row">
                <form class="search-bar" action="/pipisos/buscar.php" method="get">
                    <input type="text" name="q" placeholder="Buscar..." />
                    <button type="submit"><span class="icon-search"></span>Buscar</button>
                </form>

                <a href="/pipisos/menu.php">
                    <span class="icon-user-o"></span>
                </a>
            </div>
        </div>

        <input type="checkbox" id="menu-toggle" class="menu-toggle" />
        <label for="menu-toggle" class="menu-icon">☰</label>

    </header>