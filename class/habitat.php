<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'baseDeDatos.php';

class Habitat extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formNew':
                $result = '<form class="p-40 flex" method="POST">
                                <div class="container mt-4">
                                    <h4 class="f-size-30">Agregar hábitat</h4>
                                    <div class="flex align-center justify-content gap-25">
                                        <label class="label col-md-4">Ubicación</label>
                                        <div class="col-md-8">
                                            <input type="text" name="ubicacion" placeholder="Ubicación" class="form-control">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-8">
                                            <input type="hidden" name="action" value="insert">
                                            <input type="submit" value="Registrar">
                                        </div>
                                    </div>
                                </div>
                            </form>';
                break;

            case 'formEdit':
                $registro = $this->getRecord("SELECT * FROM habitat WHERE id = " . $_POST['id_habitat']);

                $result = '<form class="p-40" method="POST"> 
                                <h4 class="f-size-30">Editar hábitat</h4>
                                <input type="hidden" name="action" value="update">
                                <input name="id_habitat" value="' . $_POST['id_habitat'] . '" type="hidden">
                                <input name="ubicacion" value="' . $registro->ubicacion . '" class="mt-10 p-10">
                                <button class="p-10">Actualizar</button>
                            </form>';
                break;

            case 'insert':
                $this->query("INSERT INTO habitat (ubicacion) VALUES ('" . $_POST['ubicacion'] . "')");
                $result = $this->action('report');
                break;

            case 'report':
                $result = $this->despTablaDatos("SELECT * FROM habitat ORDER BY ubicacion");
                break;

            case 'delete':
                $this->query("DELETE FROM habitat WHERE id_habitat = " . $_POST['id_habitat']);
                $result = $this->action('report');
                break;

            case 'update':
                $this->query("UPDATE habitat SET ubicacion = '" . $_POST['ubicacion'] . "' WHERE id = " . $_POST['id_habitat']);
                $result = $this->action('report');
                break;

            default:
        }

        return $result;
    }

    function despTablaDatos($query)
    {
        $htmlStart = '<div class="flex column m-50">';
        $datos = '<table class="customTable center-text mt-50">';
        $this->query($query);
        $this->getRecord($query);

        $datos .= '<div class="flex space-between align-center gap-15">
                        <h3 class="f-size-30">Hábitats</h3> 
                        <form method="post">
                            <button class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
                            <input type="hidden" name="action" value="formNew">
                        </form>
                    </div>';

        // Fila de encabezados
        $datos .= '<thead><tr>';
        $campos = array("id", "Ubicación");
        foreach ($campos as $campo) {
            $datos .= '<th>' . $campo . '</th>';
        }
        $datos .= "<th>&nbsp</th><th>&nbsp</th>";
        $datos .= '</tr></thead>';

        // Contenido y datos
        $datos .= '<tbody>';
        foreach ($this->bloq_registros as $row) {
            $datos .= '<tr>';
            foreach ($row as $columna) {
                $datos .= '<td class="text-align-center">' . $columna . '</td>';
            }
            // Botón para borrar 
            $datos .= '<td> 
                            <form method="post">
                                <button><i class="fa-regular fa-trash-can"></i></button>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_habitat" value="' . $row['id'] . '">
                            </form>
                        </td>';
            // Botón para editar
            $datos .= '<td> 
                            <form method="post">
                                <button><i class="fa-solid fa-pen-to-square"></i></button> 
                                <input type="hidden" name="action" value="formEdit">
                                <input type="hidden" name="id_habitat" value="' . $row['id'] . '"> 
                            </form>
                        </td>';
            $datos .= "</tr>";
        }
        $datos .= '</tbody>';
        $datos .= '</table></div>';
        $htmlEnd = '</div>';
        echo ($htmlStart . $datos . $htmlEnd);
    }
}

$oHabitat = new Habitat();
if (isset($_REQUEST['action'])) {
    echo $oHabitat->action($_REQUEST['action']);
} else {
    echo $oHabitat->action('report');
}
?>
