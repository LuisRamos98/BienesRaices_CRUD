<?php

namespace App;

class Propiedad extends ActiveRecord{

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id','titulo',"precio","imagen",'descripcion','habitaciones','wc','estacionamiento','creado','vendedores_id'];

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
        $this->id = $args["id"] ?? null;
        $this->titulo = $args["titulo"] ?? '';
        $this->precio = $args["precio"] ?? '';
        $this->imagen = $args["imagen"] ?? '';
        $this->descripcion = $args["descripcion"] ?? '';
        $this->habitaciones = $args["habitaciones"] ?? '';
        $this->wc = $args["wc"] ?? '';
        $this->estacionamiento = $args["estacionamiento"] ?? '';
        $this->creado = date("y/m/d");
        $this->vendedores_id = $args["vendedores_id"] ?? "";
    }

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