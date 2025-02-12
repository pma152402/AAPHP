<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemons</title>
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
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
    // DEFINIMOS LA URL DE LA API
    $apiUrlName = "https://pokeapi.co/api/v2/pokemon/";


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrlName);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);
    $pokemons = $datos["results"];  

    
    

    // DECLARAR VARIABLES
    $cantidad = 0;
    if (isset($_GET["cantidad"])) {
        $cantidad = intval($_GET["cantidad"]);
    } 
    else {
        $cantidad = 5;
    }
 
    //pagination
    if (isset($_GET["offset"])) {
        $offset = $_GET["offset"];
        if ($offset < 1) {
            $offset = 0;
        }
    } 
    else {
        $offset = 0;
    }
   
?>

    <form method="get">
        ¿Cuantos pokemons quieres mostrar?
        <input type="text" name="cantidad">
        <input type="submit" value="Mostrar">
    </form>

    <table>
        <thead>
            <th>Imagen</th>
            <th>Pokemon</th>
            <th>Tipos</th>
        </thead>
        <tbody>

            <?php
            $contador = 0;
            $numero = 1;
            $tipo = "https://pokeapi.co/api/v2/pokemon/1/types/0/name";
            

                foreach ($pokemons as $pokemon) {       
                    if ($contador < $cantidad ){
                        echo ("<tr>");
                        echo ("<td> <img src=' https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/" . $numero . ".png' alt='pokemon'> </td>");
                        echo ("<td>" . ucfirst($pokemon["name"]) . "</td>");
                        echo ("<td>" . $tipo . "</td>");  // no consigo sacar la imagen :(
                        echo ("</tr>");
                        $numero++;
                        $contador++;
                    }
                    elseif ($contador > $cantidad ) {  
                        break;
                    }
                }
            ?>
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

