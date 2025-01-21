<?php
    require_once ("models/movalquilar_model.php");
    require_once ("controllers/funciones_controller.php");
    require_once("views/movalquilar.php");

    function listaVehiculos(){
        $vehiculos = vehiculosDisponibles();

        // Opción por defecto
        echo "<option value=''>-- SELECCIONA UNA OPCIÓN --</option>";

        // Usamos los datos obtenidos
        foreach ($vehiculos as $row) {
            echo "<option value='" . $row["matricula"] . "'>" . $row["marca"] . " - " . $row["modelo"]. "</option>";
        }
    }

    



?>