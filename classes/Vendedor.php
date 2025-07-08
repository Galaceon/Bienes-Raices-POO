<?php

namespace App;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'email', 'imagen'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $imagen;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar() {
        // Verificacion de la existencia del contenido (mensajes a imprimir en DOM en caso de error)
        if(!$this->nombre) {
            self::$errores[] = "Debes escribir tu nombre";
        }
        if(!$this->apellido) {
            self::$errores[] = "Debes escribir tu apellido";
        }
        if(!$this->telefono) {
            self::$errores[] = "Debes escribir tu número telefónico";
        }

        if(!preg_match('/[0-9]{9}/', $this->telefono)) {
            self::$errores[] = "Formato de Teléfono no Válido";
        }

        if(!$this->email) {
            self::$errores[] = "Debes escribir tu email";
        }

        if(!$this->imagen) {
            self::$errores[] = 'La imagen es obligatoria';
        }


        return self::$errores;
    }
}