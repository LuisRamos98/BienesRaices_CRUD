<?php

namespace App;

class Propiedad{

    protected static $db;
    protected static $columnasDB = ['id','titulo',"precio","imagen",'descripcion','habitaciones','wc','estacionamiento','creado','vendedores_id'];
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
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? '';
        $this->titulo = $args["titulo"] ?? '';
        $this->precio = $args["precio"] ?? '';
        $this->imagen = $args["imagen"] ?? '';
        $this->descripcion = $args["descripcion"] ?? '';
        $this->habitaciones = $args["habitaciones"] ?? '';
        $this->wc = $args["wc"] ?? '';
        $this->estacionamiento = $args["estacionamiento"] ?? '';
        $this->creado = date("y/m/d");
        $this->vendedores_id = $args["vendedores_id"] ?? '';
    }

    public function guardar(){
        //Sanitizar los atributos
        $atributos = $this->sanitizarAtributos();


        // Insertar en base de datos
        $query = "INSERT INTO propiedades (";
        $query .= join(",",array_keys($atributos)). ") VALUES ('";
        $query .= join("','",array_values($atributos))."')";

        // debugear($query);


        // Insertar en base de datos
        $query = "INSERT INTO propiedades (titulo,precio,imagen,descripcion,habitaciones,wc,estacionamiento,creado,vendedores_id) VALUES ('$this->titulo','$this->precio','$this->imagen','$this->descripcion','$this->habitaciones','$this->wc','$this->estacionamiento','$this->creado','$this->vendedores_id')";

        $resultado = self::$db->query($query);
        // debugear($resultado);
        return $resultado;
    }

    public static function setDB($database) {
        self::$db = $database;
    } 

    public function atributos() {

        $atributos = [];

        foreach(self::$columnasDB as $columna) {
            if($columna==="id") continue;
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

    //RETORNA LOS ERRORES
    public static function getErrores() {
        return self::$errores;
    }

    //Subida de Imagen
    public function setImagen($imagen){
        if($imagen){
            $this->imagen = $imagen;
        }
        
    }

    //Validacion
    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = "Debes ingresar un titulo";
        }

        if(!$this->precio) {
            self::$errores[] = "Debes ingresar un precio";
        }

        if( strlen($this->descripcion) < 50) {
            self::$errores[] = "Debes ingresar un descripcion y debe ser mayor a 50 caracteres";
        }

        if(!$this->habitaciones) {
            self::$errores[] = "El numero de habitacion es obligatoria";
        }

        if(!$this->wc) {
            self::$errores[] = "El numero de wc es obligatoria";
        }

        if(!$this->estacionamiento) {
            self::$errores[] = "El numero de estacionamientos es obligatoria";
        }

        if(!$this->vendedores_id) {
            self::$errores[] = "Ingrese un vendedor ";
        }

        if(!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
}