<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricky</title>
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
            border: 5px solid black;
            border-radius: 50%;
            height: 150px;
            width: 150px;

        }
    </style>
</head>

<body>
    <?php
    // DEFINIMOS LA URL DE LA API
    $apiUrlName = "https://rickandmortyapi.com/api/character";


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrlName);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);
    $personajes = $datos["results"];       // SIN MESSAGE

    // DECLARAR VARIABLES
    $cantidad = 0;
    if (isset($_GET["cantidad"])) {
        $cantidad = intval($_GET["cantidad"]);
    } else {
        $cantidad = count($personajes);
    }

    $genero = "";
    if (isset($_GET["genero"])) {
        $genero = $_GET["genero"];
    }

    $especie = "";
    if (isset($_GET["especie"])) {
        $especie = $_GET["especie"];
    }



    ?>
    <form method="get" action="">
        Cantidad de personajes:
        <input type="text" name="cantidad">

        <select name="genero" id="genero">
            <option value="Cualquiera">Cualquiera</option>
            <option value=Female>Female</option>
            <option value=Male>Male</option>
        </select>

        <select name="especie" id="especie">
            <option value="Cualquiera">Cualquiera</option>
            <option value="Human">Human</option>
            <option value="Alien">Alien</option>
        </select>

        <button type="submit" value="enviar">Enviar</button>
    </form>

    <table>
        <thead>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Genero</th>
            <th>Especie</th>
            <th>Origen</th>
        </thead>
        <tbody>

            <?php
            $contador = 0;
            if ($cantidad <= 0) {
                echo ("<p style='color: red'>Por favor indica una cantidad de personajes a mostrar </p>");
            } 
            else {
                foreach ($personajes as $personaje) {  // SIN => 

                    if ($contador != $cantidad) {

                        // MUJERES CON CUALQUIER ESPECIE
                        if (($genero == "Female" && $personaje["gender"] == "Female") && ($especie == "Cualquiera" || $personaje["species"] == $especie)) {     // $genero ya contiene el valor de la URL, API
                            echo ("<tr>");
                            echo ("<td> <img src=" . $personaje["image"] . " alt='personaje'> . </td>");
                            echo ("<td>" . $personaje["name"] . "</td>");
                            echo ("<td>" . $personaje["gender"] . "</td>");
                            echo ("<td>" . $personaje["species"] . "</td>");
                            $origen = $personaje["origin"];
                            echo ("<td>" . $origen["name"] . "</td>");
                            echo ("</tr>");
                            $contador++;

                            
                        }

                        // HOMBRES CON CUALQUIER ESPECIE
                        elseif (($genero == "Male" && $personaje["gender"] == "Male")  && ($especie == "Cualquiera" || $personaje["species"] == $especie)) {     // $genero ya contiene el valor de la URL, API
                            echo ("<tr>");
                            echo ("<td> <img src=" . $personaje["image"] . " alt='personaje'> </td>");
                            echo ("<td>" . $personaje["name"] . "</td>");
                            echo ("<td>" . $personaje["gender"] . "</td>");
                            echo ("<td>" . $personaje["species"] . "</td>");
                            $origen = $personaje["origin"];
                            echo ("<td>" . $origen["name"] . "</td>");
                            echo ("</tr>");
                            $contador++;
                        }

                        // CUALQUIER GENERO Y ESPECIE                   MIRA ESTOOOOOOOOOO
                        elseif ($genero == "Cualquiera") {
                            echo ("<tr>");
                            echo ("<td> <img src=" . $personaje["image"] . " alt='personaje'> . </td>");
                            echo ("<td>" . $personaje["name"] . "</td>");
                            echo ("<td>" . $personaje["gender"] . "</td>");
                            echo ("<td>" . $personaje["species"] . "</td>");
                            $origen = $personaje["origin"];
                            echo ("<td>" . $origen["name"] . "</td>");
                            echo ("</tr>");
                            $contador++;
                        }
                    }
                }
            }

            ?>
        </tbody>
    </table>
</body>

</html>