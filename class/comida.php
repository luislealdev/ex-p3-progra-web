<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// session_start();

include 'baseDeDatos.php';

class Comida extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formNew':
                // Get all employees
                $this->getRecord("SELECT id, concat(nombre, ' ', apellido) as nombre FROM empleado");
                $empleadosOptions = ''; // Inicializa la variable como una cadena vacía

                // Recorre cada fila de la tabla empleados

                foreach ($this->bloq_registros as $empleado) {
                    // Concatena cada opción a la cadena empleadosOptions
                    $empleadosOptions .= '<option value="' . $empleado["id"] . '">' . $empleado["nombre"] . '</option>';
                }
                // Get all animals
                $this->getRecord("SELECT * FROM animal");
                $animalesOptions = ''; // Inicializa la variable como una cadena vacía

                // Recorre cada fila de la tabla empleados
                foreach ($this->bloq_registros as $animal) {
                    // Concatena cada opción a la cadena empleadosOptions
                    $animalesOptions .= '<option value="' . $animal["id"] . '">' . $animal["animal"] . '</option>';
                }

                $result = '<form class="p-40 flex" method="POST"><div class="container mt-4"> <h4 class="f-size-30">Comida</h4>';

                $result .= '<div class="flex align-center justify-content gap-25">
                    <div class="mt-20">
                    <div class="grid-c-2 gap-15">
                    <div>
                    <label for="concepto">Concepto</label>
                    <input type="text" name="concepto" value="' . (isset($registro) ? $registro->concepto : "") . '" placeholder="Concepto" class="form-control">
                    </div>
                    <div>
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" value="' . (isset($registro) ? $registro->cantidad : "") . '" placeholder="Cantidad" class="form-control">
                    </div>
                    </div>
                    <div class="grid-c-2 gap-15">
                    <div>
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" value="' . (isset($registro) ? $registro->fecha : "") . '" placeholder="Fecha" class="form-control">
                    </div>
                    <div>
                    <label for="hora">Hora</label>
                    <input type="text" name="hora" value="' . (isset($registro) ? $registro->hora : "") . '" placeholder="Hora" class="form-control">
                    </div>
                    ' .
                    // Create a select and options to select from employees variable

                    '
                    <div class="grid-c-2 gap-15">
                    <div>
                    <label for="concepto">Empleado</label>
                    <select name="id_empleado">' .
                    $empleadosOptions .
                    '</select>
                    </div>
                    ' .

                    // Create a select and options to select from employees variable
                    '
                    <div>
                    <label for="concepto">Animal</label>
                    <select name="id_animal">' .
                    $animalesOptions .
                    '</select>
                    </div>' .

                    '
                    </div>
                ';

                $result .= '<div>
                    <div>
                    <input type="hidden" name="action" value="' . (!isset($registro) ? 'insert' : "update")  . '">
                    <input type="submit" value="' . (!isset($registro) ? "Registrar" : "Actualizar")  .  '">
                    </div>
                ';

                $result .= '</div> </form>';
                break;

            case 'formEdit':
                $registro = $this->getRecord(
                    "
                    SELECT *, concat(e.nombre, ' ', e.apellido) AS nombre_empleado
                    FROM comida c 
                    JOIN empleado e ON c.id_empleado = e.id 
                    JOIN animal a ON c.id_animal = a.id 
                    WHERE c.id = " . $_POST['id']
                );

                // Get all employees
                $this->getRecord("SELECT id, concat(nombre, ' ', apellido) as nombre FROM empleado");
                $empleadosOptions = ''; // Inicializa la variable como una cadena vacía

                // Recorre cada fila de la tabla empleados
                foreach ($this->bloq_registros as $empleado) {
                    // Verifica si este empleado es el mismo que el empleado asociado al registro que se está editando
                    $selected = '';
                    if (isset($registro) && $empleado["id"] == $registro->id_empleado) {
                        $selected = 'selected';
                    }
                    // Concatena cada opción a la cadena empleadosOptions
                    $empleadosOptions .= '<option value="' . $empleado["id"] . '" ' . $selected . '>' . $empleado["nombre"] . '</option>';
                }

                // Get all animals
                $this->getRecord("SELECT * FROM animal");
                $animalesOptions = ''; // Inicializa la variable como una cadena vacía

                // Recorre cada fila de la tabla animales
                foreach ($this->bloq_registros as $animal) {
                    // Verifica si este animal es el mismo que el animal asociado al registro que se está editando
                    $selected = '';
                    if (isset($registro) && $animal["id"] == $registro->id_animal) {
                        $selected = 'selected';
                    }
                    // Concatena cada opción a la cadena animalesOptions
                    $animalesOptions .= '<option value="' . $animal["id"] . '" ' . $selected . '>' . $animal["animal"] . '</option>';
                }

                $result = '
                <form class="p-40" method="POST"> 
                    <h4 class="f-size-30">Editar comida</h4>
                    <input type="hidden" name="action" value="update">
                    <input name="id" value="' . $_POST['id'] . '" type="hidden">

                    <div class="grid-c-2 gap-15 mt-20">
                    <div>
                    <label for="concepto">Concepto</label>
                    <input type="text" name="concepto" value="' . (isset($registro) ? $registro->concepto : "") . '" placeholder="Concepto" class="form-control">
                    </div>
                    <div>
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" value="' . (isset($registro) ? $registro->cantidad : "") . '" placeholder="Cantidad" class="form-control">
                    </div>
                    </div>
                    <div class="grid-c-2 gap-15">
                    <div>
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" value="' . (isset($registro) ? $registro->fecha : "") . '" placeholder="Fecha" class="form-control">
                    </div>
                    <div>
                    <label for="hora">Hora</label>
                    <input type="text" name="hora" value="' . (isset($registro) ? $registro->hora : "") . '" placeholder="Hora" class="form-control">
                    </div>' .
                    // Create a select and options to select from employees variable
                    '
                    <label for="id_empleado">Empleado</label>
                    <select name="id_empleado">' .
                    $empleadosOptions .
                    '</select>' .

                    // Create a select and options to select from employees variable
                    '
                    <label for="id_animal">Animal</label>
                    <select name="id_animal">
                    ' .
                    $animalesOptions .
                    '</select>
                     <button class="p-10">Actualizar</button>
                    </form>
                ';


                break;
                // CRUD
            case 'insert':
                $this->query("INSERT INTO comida (concepto, cantidad, fecha, hora, id_animal, id_empleado) VALUES ('" . $_POST['concepto'] . "', '" . $_POST['cantidad'] . "', '" . $_POST['fecha'] . "', '" . $_POST['hora'] . "' , '" . $_POST['id_animal'] . "' , '" . $_POST['id_empleado'] . "')");
                $result = $this->action('report');
                break;
            case 'report':
                if ($_SESSION['role'] == 'admin') {
                    // Si es un administrador, mostrar todos los registros
                    $result = $this->despTablaDatos("
                            SELECT c.id, c.fecha, c.hora, c.concepto, c.cantidad, concat(e.nombre, ' ', e.apellido) AS nombre_empleado, a.animal ,c.aplicado 
                            FROM comida c 
                            JOIN empleado e ON c.id_empleado = e.id 
                            JOIN animal a ON c.id_animal = a.id  
                            ORDER BY c.fecha DESC
                        ");
                } else {
                    // Si no es un administrador, mostrar solo los registros del usuario actual
                    $result = $this->despTablaDatos("
                            SELECT c.id, c.fecha, c.hora, c.concepto, c.cantidad, concat(e.nombre, ' ', e.apellido) AS nombre_empleado, a.animal, h.ubicacion ,c.aplicado 
                            FROM comida c 
                            JOIN empleado e ON c.id_empleado = e.id 
                            JOIN animal a ON c.id_animal = a.id
                            JOIN habitat h ON a.id_habitad = h.id
                            WHERE c.id_empleado = {$_SESSION['id']}
                            ORDER BY c.fecha DESC
                        ");
                }
                break;

            case 'delete':
                $this->query("DELETE FROM comida WHERE id = " . $_POST['id']);
                $result = $this->action('report');
                break;
            case 'update':
                $this->query("UPDATE comida SET concepto = '" . $_POST['concepto'] . "', cantidad = '" . $_POST['cantidad'] . "', fecha = '" . $_POST['fecha'] . "', hora = '" . $_POST['hora'] . "' WHERE id = " . $_POST['id']);
                $result = $this->action('report');
                break;
            case 'marcarAplicado':
                $this->query("UPDATE comida SET aplicado = 1 WHERE id = " . $_POST['id']);
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

        // Verifica si el usuario es administrador
        $isAdmin = ($_SESSION['role'] == 'admin');

        // Botón para agregar registro (si es administrador)
        if ($isAdmin) {
            $datos .= '
            <div class="flex space-between align-center gap-15">
                <h3 class="f-size-30">Comida</h3> 
                <form method="post">
                    <button class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
                    <input type="hidden" name="action" value="formNew">
                </form>
            </div>';
        }

        // Fila de encabezados
        $datos .= '<thead><tr>';
        if ($isAdmin)
            $campos = array("id", "Fecha", "Hora", "Concepto", "Cantidad", "Encargado", "Animal", "Aplicado");
        else
            $campos = array("id", "Fecha", "Hora", "Concepto", "Cantidad", "Encargado", "Animal", "Ubicación", "Aplicado");
        foreach ($campos as $campo) {
            $datos .= '<th>' . $campo . '</th>';
        }
        // Si es administrador, agregar dos columnas adicionales para los botones de eliminar y editar
        if ($isAdmin) {
            $datos .= "<th>&nbsp</th><th>&nbsp</th>";
        }
        $datos .= '</tr></thead>';

        // Contenido y datos
        $datos .= '<tbody>';
        foreach ($this->bloq_registros as $row) {
            $datos .= '<tr>';
            foreach ($row as $columna => $valor) {
                // Verifica si la columna es "aplicado" y muestra un texto descriptivo y aplica estilos CSS
                if ($columna == "aplicado") {
                    $texto = ($valor == 1) ? "Aplicado" : "No Aplicado";
                    $color = ($valor == 1) ? "green" : "red";
                    $datos .= '<td class="text-align-center" style="color: ' . $color . '">' . $texto . '</td>';
                } else {
                    $datos .= '<td class="text-align-center">' . $valor . '</td>';
                }
            }
            // Si es administrador, agregar botones para eliminar y editar
            if ($isAdmin) {
                $datos .= '
        <td> 
            <form method="post">
                <button><i class="fa-regular fa-trash-can"></i></button>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="' . $row['id'] . '">
            </form>
        </td>';
                $datos .= '
        <td> 
            <form method="post">
                <button><i class="fa-solid fa-pen-to-square"></i></button> 
                <input type="hidden" name="action" value="formEdit">
                <input type="hidden" name="id" value="' . $row['id'] . '"> 
            </form>
        </td>';
            } else { // Si no es administrador, agregar botón para marcar como aplicado
                $datos .= '
        <td> 
            <form method="post">
                <button><i class="fa-solid fa-check"></i> Marcar como aplicado</button>
                <input type="hidden" name="action" value="marcarAplicado">
                <input type="hidden" name="id" value="' . $row['id'] . '">
            </form>
        </td>';
            }
            $datos .= "</tr>";
        }
        $datos .= '</tbody>';

        $datos .= '</table></div>';
        $htmlEnd = '</div>';
        return $htmlStart . $datos . $htmlEnd;
    }
}

$oComida = new Comida();
if (isset($_REQUEST['action'])) echo $oComida->action($_REQUEST['action']);
else echo $oComida->action('report');
