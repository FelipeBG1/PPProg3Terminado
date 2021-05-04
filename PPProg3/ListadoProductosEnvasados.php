<?php

require_once "./clases/ProductoEnvasado.php";

$tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : 0;

        if($tabla != "Mostrar")
        {
            echo json_encode(ProductoEnvasado::Traer());
        }
        else
        {
            $array = ProductoEnvasado::Traer();
            echo "<table>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    CODIGO_BARRA
                </td>
                <td>
                    NOMBRE
                </td>
                <td>
                    ORIGEN
                </td>
                <td>
                    PRECIO
                </td>
                <td>
                    FOTO
                </td>
                </tr>";

            foreach($array as $item)
            {
                echo "<tr>
                        <td>
                            $item->id
                        </td>
                        <td>
                            $item->codigo_barra
                        </td>
                        <td>
                            $item->nombre
                        </td>
                        <td>
                            $item->origen
                        </td>
                        <td>
                            $item->precio
                        </td>
                        <td>
                            <img src=$item->foto alt=fotoProducto width=50px height=50px>
                        </td>
                    </tr>";
            }

        }
?>