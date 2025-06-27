<?php

namespace App;

class Propiedad {

    // Base de Datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    // Errores
    protected static $errores = [];


    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    // Definir la conexion a la DB
    public static function setDB($database) {
        self::$db = $database;
    }

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }

    


    public function guardar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);
    }

    // Idetificar y unir los atributos de la DB
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
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
        // Verificacion de la existencia del contenido (mensajes a imprimir en DOM en caso de error)
        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if(!$this->precio || $this->precio <= 0) {
            self::$errores[] = "Debes añadir un precio valido";
        }
        if(strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }
        if(!$this->habitaciones) {
            self::$errores[] = "Debes añadir el numero de habitaciones";
        }
        if(!$this->wc) {
            self::$errores[] = "Debes añadir el numero de baños";
        }
        if(!$this->estacionamiento) {
            self::$errores[] = "Debes añadir el numero de estacionamientos";
        }
        if(!$this->vendedorId) {
            self::$errores[] = "Debes añadir un vendedor";
        }
        if(!$this->imagen) {
            self::$errores[] = 'La imagen es obligatoria';
        }

        return self::$errores;
    }

    public function setImagen($imagen) {
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Lista todas las propiedades
    public static function all() {
        // Hacemos consulta SQL
        $query = "SELECT * FROM propiedades";

        // Llamamos a un metodo para recibir la consulta
        $resultado = self::consultarSQL($query);

        // Devolvemos los resultados de consulta a index.php
        return $resultado;
    }

    // Metodo para obtener los objetos  de la consulta
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    // Pasa de array a objetos, ya que estamos trabajando con activeRecords, el cual pide objetos
    protected static function crearObjeto($registro) {
        $objeto = new self;

        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }


}

