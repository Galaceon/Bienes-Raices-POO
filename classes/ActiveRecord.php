<?php

namespace App;

class ActiveRecord {
    
    // Base de Datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];


    // Definir la conexion a la DB
    public static function setDB($database) {
        self::$db = $database;
    }

    public function guardar() {
        if(!empty($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }


    public function crear() {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=1');
        }

        return $resultado;
    }

    public function actualizar() {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        $resultado = self::$db->query($query);

        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=2');
        }
    }

    // Eliminar un registro
    public function eliminar() {
        // Eliminar la Propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();

            header('location: /admin?resultado=3');      
        }
    }


    // Idetificar y unir los atributos de la DB
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Validación
    public static function getErrores() {
        return self::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    //Subida de archivos
    public function setImagen($imagen) {
        // Elimina la imagen previa solo si hay ID y una imagen definida
        if (!empty($this->id) && !empty($this->imagen)) {
            $this->borrarImagen();
        }
    
        // Asignar la nueva imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Eliminar archivo
    public function borrarImagen() {
        $rutaImagen = CARPETA_IMAGENES . $this->imagen;
    
        // Verificar si el archivo existe y es un archivo (no carpeta)
        if (file_exists($rutaImagen) && is_file($rutaImagen)) {
            unlink($rutaImagen);
        }
    }

    // Lista todos los registros
    public static function all() {
        // Hacemos consulta SQL
        $query = "SELECT * FROM " . static::$tabla;

        // Llamamos a un metodo para recibir la consulta
        $resultado = self::consultarSQL($query);

        // Devolvemos los resultados de consulta a index.php
        return $resultado;
    }

     // Busca un registro por su id
     public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
     }

    
    // Metodo para obtener los objetos  de la consulta
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    // Pasa de array a objetos, ya que estamos trabajando con activeRecords, el cual pide objetos
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

}