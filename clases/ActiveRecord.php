<?php

namespace App;

class ActiveRecord {

    protected static $db;
    protected static $columnasDB = [];
    protected static $errores = [];
    protected static $tabla = '';


    public function guardar() {
        if (!is_null($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }
    public function crear(){

        //Sanitizar los atributos
        $atributos = $this->sanitizarAtributos();

        // Insertar en base de datos
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(",",array_keys($atributos)). ") VALUES ('";
        $query .= join("','",array_values($atributos))."')";

        $resultado = self::$db->query($query);

        //MENSAJE DE RESULTADO O ERROR
        if($resultado) {
            // echo "Insertado correctamente";
            header("Location: /admin?resultado=1");
        }
        
    }

    //Actualizar
    public function actualizar() {
        //Sanitizar los atributos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(", ",$valores);
        $query .= "WHERE id = '" . self::$db->escape_string($this->id ) . "' ";
        $query .=  " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado) {
            // echo "Insertado correctamente";
            header("Location: /admin?resultado=2");
        }
    }

    //Eliminar
    public function eliminar() {
        
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        // debugear($query);
        $resultado = self::$db->query($query);

        if($resultado){
            //ELIMINAMOS LA IMAGEN 
            $this->borrarImagen();
            //Redirecionamos
            header("Location: /admin?resultado=3");
        }
    }

    public static function setDB($database) {
        self::$db = $database;
    } 

    public function atributos() {

        $atributos = [];

        foreach(static::$columnasDB as $columna) {
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

    //Subida de Imagen
    public function setImagen($imagen){
        //Eliminamos Archivo anterior
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }
        if($imagen){
            $this->imagen = $imagen;
        }
        
    }

    //Elinada de Imagen
    public function borrarImagen() {
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //RETORNA LOS ERRORES
    public static function getErrores() {
        return static::$errores;
    }
    

    //Validacion
    public function validar() {
        static::$errores = [];
        return static::$errores;
    }


    //LISTAR TODAS LAS PROPIEDADES
    public static function all(){

        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultaSQL($query);
        return $resultado;
    }

    //Obtener una cantidad determinada de resultados
    public static function get($cantidad){

        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultaSQL($query);
        return $resultado;
    }

    public static function find($id) {

        $query = "SELECT * FROM " . static::$tabla . " WHERE id=${id}";
        $resultado = self::consultaSQL($query);

        return array_shift($resultado);
    }

    public static function consultaSQL($query) {

        $array = [];

        //HACEMOS LA CONSULTA SQL
        $resultado = self::$db->query($query);
        
        //Iteramos el resultado
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //liberamos memoria
        $resultado->free();

        // debugear($array);
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        
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