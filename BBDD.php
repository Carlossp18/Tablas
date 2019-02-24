<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BBDD
 *
 * @author alumno
 */
class BBDD {

    //put your code here
    private $conexion;
    private $info;
    private $host;
    private $user;
    private $pass;
    private $bd;

    public function __construct($host = "127.0.0.1", $user = "root", $pass = "", $bd = "dwes") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->bd = $bd;
        $this->conexion = new mysqli($host, $user, $pass, $bd);
        $this->conexion->set_charset("utf8");
    }

    public function __toString() {
        return $this->info;
    }

    public function checkState() {
        if ($this->conexion->errno == 0) {
            $this->info = "Conexión establecida correctamente";
            return 1;
        } else {
            $this->info = "Ha habido un error estableciendo la conexión";
            return 0;
        }
    }

    public function selectQuery($select) {
        $result = $this->conexion->query($select);
        return $this->getValues($result);
    }

    private function getValues($result) {
        $values = [];
        while ($array = $result->fetch_row()) {
            array_push($values, $array);
        }
        return $values;
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }

    /**
     * 
     * @param string $tableName
     * @return array
     */
    public function nombresCampos(string $tableName) {
        $campos = [];
        $sql = "SHOW COLUMNS FROM $tableName";
        $res = $this->conexion->query($sql);
        while ($row = $res->fetch_assoc()) {
            $campos[] = $row['Field'];
        }
        return $campos;
    }

    public function edit($camposNuevos, $campos) {
        $valNuevos = "";
        $val = "";
        foreach ($camposNuevos as $campo => $valor) {
            $valNuevos .= "$campo = '$valor', ";
        }
        $valNuevos = substr($valNuevos, 0, -2);

        foreach ($campos as $campo => $valor) {
            if ($valor == "")
                $val .= "$campo is null and ";
            else
                $val .= "$campo = '$valor' AND ";
        }
        $val = substr($val, 0, -4);

        $sentencia = "UPDATE producto SET $valNuevos where $val";
        var_dump($sentencia);
        $this->conexion->query($sentencia);
    }

}
