<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// session_start();

include 'baseDeDatos.php';

class Especie extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formNew':
                $result = '<form class="p-40 flex" method="POST"><div class="container mt-4"> <h4 class="f-size-30">Especies</h4>';

                $result .= '<div class="flex align-center justify-content gap-25">
                    <label class="label col-md-4">Especies</label>
                    <div class="col-md-8">
                    <input type="text" name="especie" value="' . (isset($registro) ? $registro->especie : "") . '" placeholder="Especie" class="form-control">
                    </div>
                ';

                $result .= '<div>
                    <div class="col-md-8">
                    <input type="hidden" name="action" value="' . (!isset($registro) ? 'insert' : "update")  . '">
                    <input type="submit" value="' . (!isset($registro) ? "Registrar" : "Actualizar")  .  '">
                    </div>
                ';

                $result .= '</div> </form>';
                break;

            case 'formEdit':
                $registro = $this->getRecord("SELECT * FROM especie WHERE id = " . $_POST['id_especie']);

                $result = '
                <form class="p-40" method="POST"> 
                    <h4 class="f-size-30">Editar especie</h4>
                    <input type="hidden" name="action" value="update">
                    <input name="id_especie" value="' . $_POST['id_especie'] . '" type="hidden">
                    <input type="text" name="especie" value="' . (isset($registro) ? $registro->especie : "") . '" placeholder="Especie" class="form-control">
                     <button class="p-10">Actualizar</button>
                    </form>
                ';
                break;
                // CRUD
            case 'insert':
                $this->query("INSERT INTO especie (especie) VALUES ('" . $_POST['especie'] . "')");
                $result = $this->action('report');
                break;
            case 'report':
                $result = $this->despTablaDatos("SELECT * FROM especie");
                break;
            case 'delete':
                // No se permite eliminar especies.
                break;
            case 'update':
                $this->query("UPDATE especie SET especie = '" . $_POST['especie'] . "' WHERE id = " . $_POST['id_especie']);
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

        $datos .= '
            <div class="flex space-between align-center gap-15">
                <h3 class="f-size-30">Especies</h3> 
                <form method="post">
                    <button class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
                    <input type="hidden" name="action" value="formNew">
                </form>
            </div>';

        // Fila de encabezados
        $datos .= '<thead><tr>';
        $campos = array("ID", "Especie");
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
            // Botón para editar
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-solid fa-pen-to-square"></i></button> 
                    <input type="hidden" name="action" value="formEdit">
                    <input type="hidden" name="id_especie" value="' . $row['id'] . '"> 
                </form>
            </td>';
            $datos .= "</tr>";
        }
        $datos .= '</tbody>';
        $datos .= '</table></div>';
        $htmlEnd = '</div>';
        return $htmlStart . $datos . $htmlEnd;
    }
}

$oEspecies = new Especie();
if (isset($_REQUEST['action'])) echo $oEspecies->action($_REQUEST['action']);
else echo $oEspecies->action('report');

