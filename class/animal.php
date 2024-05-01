<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// session_start();

include 'baseDeDatos.php';

class Animal extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formNew':
                $result = '<form class="p-40 flex" method="POST"><div class="container mt-4"> <h4 class="f-size-30">Animal</h4>';

                $result .= '<div class="flex align-center justify-content gap-25">
                    <label class="label col-md-4">Animal</label>
                    <div class="col-md-8">
                    <input type="text" name="animal" value="' . (isset($registro) ? $registro->animal : "") . '" placeholder="Animal" class="form-control">
                    <input type="number" name="edad" value="' . (isset($registro) ? $registro->edad : "") . '" placeholder="Edad" class="form-control">
                    <input type="number" name="id_especie" value="' . (isset($registro) ? $registro->id_especie : "") . '" placeholder="ID Especie" class="form-control">
                    <input type="number" name="id_habitad" value="' . (isset($registro) ? $registro->id_habitad : "") . '" placeholder="ID Habitad" class="form-control">
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
                $registro = $this->getRecord("SELECT * FROM animal WHERE id = " . $_POST['id_animal']);

                $result = '
                <form class="p-40" method="POST"> 
                    <h4 class="f-size-30">Editar animal</h4>
                    <input type="hidden" name="action" value="update">
                    <input name="id_animal" value="' . $_POST['id_animal'] . '" type="hidden">
                    <input type="text" name="animal" value="' . (isset($registro) ? $registro->animal : "") . '" placeholder="Animal" class="form-control">
                    <input type="number" name="edad" value="' . (isset($registro) ? $registro->edad : "") . '" placeholder="Edad" class="form-control">
                    <input type="number" name="id_especie" value="' . (isset($registro) ? $registro->id_especie : "") . '" placeholder="ID Especie" class="form-control">
                    <input type="number" name="id_habitad" value="' . (isset($registro) ? $registro->id_habitad : "") . '" placeholder="ID Habitad" class="form-control">
                     <button class="p-10">Actualizar</button>
                    </form>
                ';
                break;
                // CRUD
            case 'insert':
                $this->query("INSERT INTO animal (animal, edad, id_especie, id_habitad) VALUES ('" . $_POST['animal'] . "', '" . $_POST['edad'] . "', '" . $_POST['id_especie'] . "', '" . $_POST['id_habitad'] . "')");
                $result = $this->action('report');
                break;
            case 'report':
                $result = $this->despTablaDatos("SELECT * FROM animal");
                break;
            case 'delete':
                $this->query("DELETE FROM animal WHERE id_animal = " . $_POST['id_animal']);
                $result = $this->action('report');
                break;
            case 'update':
                $this->query("UPDATE animal SET animal = '" . $_POST['animal'] . "', edad = '" . $_POST['edad'] . "', id_especie = '" . $_POST['id_especie'] . "', id_habitad = '" . $_POST['id_habitad'] . "' WHERE id_animal = " . $_POST['id_animal']);
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
                <h3 class="f-size-30">Animales</h3> 
                <form method="post">
                    <button class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
                    <input type="hidden" name="action" value="formNew">
                </form>
            </div>';

        // Fila de encabezados
        $datos .= '<thead><tr>';
        $campos = array("ID", "Animal", "Edad", "ID Especie", "ID Habitad");
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
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-regular fa-trash-can"></i></button>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id_animal" value="' . $row['id'] . '">
                </form>
            </td>';
            // Botón para editar
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-solid fa-pen-to-square"></i></button> 
                    <input type="hidden" name="action" value="formEdit">
                    <input type="hidden" name="id_animal" value="' . $row['id'] . '"> 
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

$oAnimal = new Animal();
if (isset($_REQUEST['action'])) echo $oAnimal->action($_REQUEST['action']);
else echo $oAnimal->action('report');

