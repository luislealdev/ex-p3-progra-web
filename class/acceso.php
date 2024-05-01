<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'baseDeDatos.php';
class Acceso extends BaseDeDatos
{
    function action($cual)
    {
        // $result = '';
        switch ($cual) {
            case 'login':
                $this->login();
            default:
        }
    }

    function login()
    {
        if (isset($_POST['mail']) && isset($_POST['password'])) {
            // Obtenemos el correo y lo guardamos en una variable
            $correo = $_POST['mail'];
            // Obtenemos la contraseña y la guardamos en una variable
            // Encriptamos contraseña para evitar inyección de código SQL
            $pass = $_POST['password'];
            // Conectamos a la base de datos
            // El uso de la base de datos está dividido en tres pasos
            // Paso 1: Abrir la conexión
            // Paso 2: Procesar la consulta
            // 2.1 Realizar la consulta

            $query = "SELECT u.nombre, u.apellido, u.id, u.nombre, tu.tipo_empleado AS role FROM Empleado u JOIN TipoEmpleado tu ON tu.id = u.id_tipo_empleado WHERE u.correo = '$correo' AND u.clave = '$pass';";
            echo $query;
            $registro = $this->getRecord($query);
            var_dump($registro);
            // 2.2 Procesar el resultado
            if ($this->num_registros == 1) {
                // Si es un usuario registrado
                $_SESSION['correo'] = $correo;
                $_SESSION['nombre'] = $registro->nombre . ' ' . $registro->apellido;
                $_SESSION['id'] = $registro->id;
                $_SESSION['role'] = $registro->role;

                // var_dump($_SESSION);

                if ($registro->role == 'admin')
                    header('location: ../admin');
                else
                    header('location: ../');
            } else
                // Error en las credenciales reenviar localidad del usuario
                header('location: ../auth/index.php?e=1');
        } else {
            header('location: ../auth/index.php?e=1');
        };
    }
}

$oAcceso = new Acceso();
if (isset($_REQUEST['action'])) echo $oAcceso->action($_REQUEST['action']);
