<?php
/* Clase para ejecutar las consultas a la Base de Datos */
class ejecutarSQL {
    private static $con; // Variable para almacenar la conexión

    // Método para establecer la conexión a la base de datos
    public static function conectar() {
        if (!isset(self::$con)) {
            // Crear conexión utilizando mysqli
            self::$con = new mysqli(SERVER, USER, PASS, BD);

            // Verificar si hay errores en la conexión
            if (self::$con->connect_error) {
                die("Error al conectar con la base de datos: " . self::$con->connect_error);
            }

            // Establecer el conjunto de caracteres a UTF-8
            self::$con->set_charset('utf8');
        }

        return self::$con;
    }

    // Método para realizar consultas SQL
    public static function consultar($query) {
        $con = self::conectar(); // Asegurar que la conexión esté activa
        $result = $con->query($query);

        // Verificar si la consulta falló
        if (!$result) {
            die("Error en la consulta SQL ejecutada: " . $con->error);
        }

        return $result;
    }

    // Método para cerrar la conexión
    public static function cerrar() {
        if (isset(self::$con)) {
            self::$con->close();
            self::$con = null; // Resetear la conexión
        }
    }
}

/* Clase para hacer las consultas Insertar, Eliminar y Actualizar */
class consultasSQL {
    public static function InsertSQL($tabla, $campos, $valores) {
        $query = "INSERT INTO $tabla ($campos) VALUES ($valores)";
        if (!ejecutarSQL::consultar($query)) {
            die("Ha ocurrido un error al insertar los datos en la tabla $tabla");
        }
        return true;
    }

    public static function DeleteSQL($tabla, $condicion) {
        $query = "DELETE FROM $tabla WHERE $condicion";
        if (!ejecutarSQL::consultar($query)) {
            die("Ha ocurrido un error al eliminar los registros en la tabla $tabla");
        }
        return true;
    }

    public static function UpdateSQL($tabla, $campos, $condicion) {
        $query = "UPDATE $tabla SET $campos WHERE $condicion";
        if (!ejecutarSQL::consultar($query)) {
            die("Ha ocurrido un error al actualizar los datos en la tabla $tabla");
        }
        return true;
    }
}
