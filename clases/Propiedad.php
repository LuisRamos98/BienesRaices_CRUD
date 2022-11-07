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
        $this->vendedores_id = $args["vendedores_id"] ?? 1;
    }


    public function guardar() {
        if (isset($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }
    public function crear(){

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

    public function actualizar() {
        //Sanitizar los atributos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE propiedades SET ";
        $query .= join(", ",$valores);
        $query .= "WHERE id = '" . self::$db->escape_string($this->id ) . "' ";

        debugear($query);
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
        //Eliminamos Archivo anterior
        if(isset($this->id)) {
            //Comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

            if($existeArchivo) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
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


    //LISTAR TODAS LAS PROPIEDADES
    public static function all(){

        $query = "SELECT * FROM propiedades";

        $resultado = self::consultaSQL($query);
        return $resultado;
    }

    public static function find($id) {
        $query = "SELECT * FROM propiedades WHERE id=${id}";

        $resultado = self::consultaSQL($query);

        return array_shift($resultado);
    }

    public static function consultaSQL($query) {

        $array = [];

        //HACEMOS LA CONSULTA SQL
        $resultado = self::$db->query($query);
        
        //Iteramos el resultado
        while($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //liberamos memoria
        $resultado->free();

        // debugear($array);
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new self;
        
        foreach($registro as $key => $value) {
            $objeto->$key = $value;
        }

        return $objeto;
    }

    public function sincronizar($args = []) {

        foreach ($args as $key => $value) {
            if(property_exists($this,$key) && !is_null($value)) {
                $this->$key = $value;
            }            
        }
    }

}