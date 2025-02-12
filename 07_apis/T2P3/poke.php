<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémons</title>
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );
    ?>
    <style>
        table {
            border: 2px solid black;
            background-color: antiquewhite;
        }

        th {
            color: brown;
            padding-left: 10px;
            padding-right: 20px;
        }

        td {
            padding-left: 50px;
            padding-right: 20px;
        }

        tr {
            padding-left: 50px;
            padding-right: 20px;
        }

        img {
            height: 100px;
            width: 100px;
        }
    </style>
    </head>
<body>
    <?php

        if (isset($_GET["limit"])) {
            $cantidad = $_GET["limit"];
            if ($cantidad < 1) {
                $cantidad = 5;
            }
        } else {
            $cantidad = 5;
        }

        if (isset($_GET["offset"])) {
            $offset = $_GET["offset"];
            if ($offset < 1) {
                $offset = 0;
            }
        } else {
            $offset = 0;
        }
        // Formar la URL
        $pokeAPI = "https://pokeapi.co/api/v2/pokemon/?offset=$offset&limit=$limite";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $pokeAPI);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);


        $datos = json_decode($respuesta, true);
        $pokemons = $datos["results"];

        // Formar URL pokemon
        $nombre = $pokemon["name"];
        $urlAPI = "https://pokeapi.co/api/v2/pokemon/$nombre";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $urlAPI);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);
        $datos = json_decode($respuesta, true);

        

    ?>

    <form method="get">
        ¿Cuantos pokemons quieres mostrar?
        <input type="text" name="cantidad">
        <input type="submit" value="Mostrar">
    </form>

        <table>
            <thead>
                <tr>
                    <th>Pokemon</th>
                    <th>Imagen</th>
                    <th>Tipos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pokemons as $pokemon) { ?>
                <tr>
                    <td><?php echo ucfirst($datos["name"]); ?></td>
                    <td><img src=" https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/" . $numero . ".png' alt='pokemon'> </td>                        
                    <td>
                        <?php foreach ($datos["types"] as $type) { ?>
                            <?php echo ucfirst($type["type"]["name"])." "; ?>
                        <?php } ?>
                    </td>
                <?php } ?>
                </tr>
            </tbody>
        </table>
        <?php 
            if ($offset <= 0) { ?>
                <a href=""hidden>Anterior</a>
        <?php } 
            else { // ANTERIOR ?>
                <a href="?offset=<?= ($offset - $cantidad) ?>&limit=<?= $cantidad ?>" >Anterior</a>
        <?php } ?>
            <!-- SIGUIENTE-->
            <a href="?offset=<?= ($offset + $cantidad) ?>&limit=<?= $cantidad ?>" >Siguiente</a>
    </body>
</html>