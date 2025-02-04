<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>topAnime</title>
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    ?>
    <style>
        table{
            border: 2px solid black;
            margin: auto;
            background-color: antiquewhite;
        }
        .formulario{
            background-color: antiquewhite;
            border: 2px solid black;
        }
        .opciones{
            text-align: center;
        }
        button{

        }

    </style>
</head> 
<body>
    <?php
    // Si no hay categoria sacamos todos los animes
    if (isset($_GET["categoria"])) {
        $categoria = $_GET["categoria"];
    } else {
        $categoria = "todos";
    }

    // conexion con la api
    $url = "https://api.jikan.moe/v4/top/anime";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);
    $animes = $datos["data"];
    ?>

    <div class="formulario">
        <form method="get" class="opciones">
            <label>
                <input type="radio" name="categoria" value="serie"> Serie
            </label>
            <label>
                <input type="radio" name="categoria" value="pelicula"> Película
            </label>
            <label>
                <input type="radio" name="categoria" value="todos"> Todos
            </label>
            <button type="submit">Buscar</button>
        </form>

    </div>
    <br><br><br>

    <table>
        <thead>
            <tr>
                <th>Posición</th>
                <th>Titulo</th>
                <th>Nota</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($animes as $anime) {
                $tipo = $anime["type"]; 

                if ($categoria === "serie" && $tipo !== "TV") {
                    continue; 
                }
                if ($categoria === "pelicula" && $tipo !== "Movie") {
                    continue; 
                }
            ?>
                <tr>
                    <td><?php echo $anime["rank"] ?></td>
                    <td>
                        <a href="anime.php?id=<?php echo $anime["mal_id"] ?>">
                            <?php echo $anime["title"] ?>
                        </a>
                    </td>
                    <td><?php echo $anime["score"] ?></td>
                    <td>
                        <img width="60px" src="<?php echo $anime["images"]["jpg"]["image_url"] ?>">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button>Anterior</button>
    <button>Siguiente</button>
</body>

</html>