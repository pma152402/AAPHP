<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuck Norris</title>
</head>

<body>
    <?php
    // DEFINIMOS LA URL DE LA API
    $apiUrlName = "https://api.chucknorris.io/jokes/categories";


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrlName);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);
    $categorias = $datos;       // SIN MESSAGE

    ?>
    <!-- FORMULARIO PARA OBTENER LA CATEGORIA -->
    <form method="get">
        <label>Chistes de Chuck Norris</label>
        <select name="option" id="opciones">
            <option value="" hidden>-- Selecionna una categoria --</option>
            <?php foreach ($categorias as $categoria) {  // SIN => 
            ?>
                <option value="<?php echo $categoria ?>">
                    <?php echo $categoria ?>
                </option>
            <?php } ?>
        </select>
        <br><br>
        <button type="submit" value="enviar">Enviar</button>
        <br>
    </form>

    <?php
    if (isset($_GET["option"]) && $_GET["option"] != "") {
        // CATEGORIA DEL SELECT
        $categoriaSeleccionada = $_GET["option"];

        // Definir la URL de la API para obtener un chiste de la categoría seleccionada
        $apiUrl = "https://api.chucknorris.io/jokes/random?category=" . $categoriaSeleccionada;

        // Inicializar cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);

        // DECODIFICAR LA RESPUESTA JSON     IMPORTANTE
        $datos = json_decode($respuesta, true);

        // SACAR EL CHISTE DE LA API
        $chiste = $datos["value"]; // El chiste está en el campo "value"

        // METER EL CHISTE EN EL TEXT AREA
        echo "<p>Categoria del chiste: '$categoriaSeleccionada'</p><br>";
        echo "<textarea rows='5' cols='50'>$chiste</textarea>";
    } 
    // AÑADIENDO LA CONDICION HAREMOS QUE NO APAREZCA AL ARRANCAR LA PAGINA
    elseif (isset($_GET["option"]) && $_GET["option"] == "") {
        echo "<p style='color: red'>No se ha seleccionado ninguna categoria, Chuck Norris esta triste.. cuidado</p>";
    }
    ?>
</body>

</html>