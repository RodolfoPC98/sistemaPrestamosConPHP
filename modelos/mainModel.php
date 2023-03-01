<?php

if($peticionAjax){
    require_once "../config/SERVER.php";
}else{
    require_once "./config/SERVER.php";
}

class mainModel{
    /* ------Función para conectar a BD ------------*/
    protected static function conectar(){
        $conexion = new PDO(SGBD, USER, PASS);
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;
    }
    /*---------- Función para ejecutar consultas simples --------*/
    protected static function ejecutar_consulta_simple($consulta){
        $sql=self::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }

    /* ------- Encriptar cadenas (url) --------*/
    public function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }
    /* ------- Desencriptar cadenas (url) --------*/
    protected static function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
    /* ------- Genera códigos aleatorios --------*/
    protected static function generar_codigo_aleatorio($letra,$longitud,$numero){
        for($i=1; $i<=$longitud; $i++){
            $aleatorio = rand(0,9);
            $letra.=$aleatorio;
        }
        return $letra."-".$numero;
    }
    /* ------- Limpiar cadenas --------*/
    protected static function limpiar_cadena($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("<script>", "", $cadena);
        $cadena=str_ireplace("</script>", "", $cadena);
        $cadena=str_ireplace("<script src>", "", $cadena);
        $cadena=str_ireplace("<script type>", "", $cadena);
        $cadena=str_ireplace("SELECT * FROM", "", $cadena);
        $cadena=str_ireplace("DELETE FROM", "", $cadena);
        $cadena=str_ireplace("INSERT INTO", "", $cadena);
        $cadena=str_ireplace("DROP TABLE", "", $cadena);
        $cadena=str_ireplace("DROP DATABASE", "", $cadena);
        $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena=str_ireplace("SHOW TABLES", "", $cadena);
        $cadena=str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena=str_ireplace("<?php", "", $cadena);
        $cadena=str_ireplace("?>", "", $cadena);
        $cadena=str_ireplace("--", "", $cadena);
        $cadena=str_ireplace(">", "", $cadena);
        $cadena=str_ireplace("<", "", $cadena);
        $cadena=str_ireplace("[", "", $cadena);
        $cadena=str_ireplace("]", "", $cadena);
        $cadena=str_ireplace("^", "", $cadena);
        $cadena=str_ireplace("==", "", $cadena);
        $cadena=str_ireplace(";", "", $cadena);
        $cadena=str_ireplace("::", "", $cadena);
        $cadena=stripslashes($cadena);
        $cadena=trim($cadena);
        return $cadena;
    }
    /* ------- Verificar datos de formularios --------*/
    protected static function verificar_datos($filtro, $cadena){
        if(preg_match("/^".$filtro."$/", $cadena)){
            return false;
        } else{
            return true;
        }
    }
    /* ------- Verificar fechas de formularios --------*/
    protected static function verificar_fecha($fecha){
        $valores=explode('-',$fecha);
        if(count($valores) == 3 && checkdate($valores[1],$valores[2],$valores[0])){
            return false;
        }else{
            return true;
        }
    }
    /* ------- Paginador de tablas --------*/
    protected static function paginador_tablas($pagina, $Npagians, $url, $botones){
        
    }
}