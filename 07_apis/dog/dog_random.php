<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perro aleatorio</title>

    <style>
        img{
            height: 350px;
            width: 320px;
            border: 5px solid black;
            border-radius: 20%;
        }
    </style>
</head>

<body>


    <?php
    // DEFINIMOS LA URL DE LA API
    $apiUrlName = "https://dog.ceo/api/breeds/list/all";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrlName);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);
    $names = $datos["message"];


    function perroRandom(){
        global $names;
        $razaRandom = array_rand($names);
        $apiUrlImg = "https://dog.ceo/api/breed/" . $razaRandom . "/images/random";
        return $apiUrlImg; // Devuelvo la URL
    }

    // DEFINIMOS LA RAZA SELECCIONADA, si hay..
    $razaSeleccionada = "";
    $mostrarImagen = true;

    ?>

    <form method="get">
        <label for="razas">Selecciona una raza:</label>

        <select name="option" id="opciones">
            <option value="" hidden>-- Selecionna una raza --</option>
            <?php foreach ($names as $key => $value) { ?>
                <option value="<?php echo $key ?>">
                    <?php echo $key ?>
                </option>
            <?php } ?>
        </select>

        <!-- RANDOMIZAR LA FOTO SEGUN LA RAZA -->
        <button type="submit" name="random">Random</button>

    </form>


    <?php

    if (isset($_GET["option"]) && $_GET["option"] == ""){ ?>
        <p style="color: red">No has seleccionado ninguna raza</p>
    <?php
        $mostrarImagen = false;
    } 
    elseif (isset($_GET["option"])) {
        // ESTA ES LA IMAGEN QUE SELECCIONA EL USUARIO
        $razaSeleccionada = $_GET["option"];
        $apiUrlImg = "https://dog.ceo/api/breed/" . $razaSeleccionada . "/images/random";
    } 
    elseif (isset($_GET["random"])) {
        // IMAGEN RANDOM DEL PERRO
        $razaSeleccionada = perroRandom();
    } 
    else {
        // ESTA ES LA IMAGEN QUE SE MUESTRA POR DEFECTO
        $apiUrlImg = "https://dog.ceo/api/breed/affenpinscher/images/random";
    }
    

    if ($mostrarImagen){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrlImg);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);
    
        $datos = json_decode($respuesta, true);
        $dogs = $datos["message"];
    
        echo ('<br> <img src="'. $dogs .'" alt="Perro"> '); 
        
    }?>
    
</body>

</html>