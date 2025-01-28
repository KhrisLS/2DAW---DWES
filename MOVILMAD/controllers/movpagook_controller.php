<?php
    require_once ("models/movpagook_model.php");
    require_once ("controllers/funciones_controller.php");
    require_once("views/movpagook.php");

    if (isset($_COOKIE['pago'])) {
        $pago = unserialize($_COOKIE['pago']);
        var_dump($pago);
        $matricula = $pago['matricula'];
        $precioTotal = $pago['precioTotal'];
        $fechaDevolucion = $pago['fechaDevolucion'];

        realizarDevolucion($matricula, $precioTotal, $fechaDevolucion);

        if (isset($_POST['volver'])){
            header("Location: welcome.php");
            exit();
        }
    }

    function realizarDevolucion($matricula, $precioTotal, $fechaDevolucion){
        $valido = devolverVehiculo($matricula, $precioTotal, $fechaDevolucion);

        if($valido){
            actualizarDisponibilidadVehiculo($matricula, 'S');
            echo "Vehiculo con matrícula $matricula, se ha devuelto correctamente.";
        }else{
            echo "No se pudo devolver el vehiculo con matrícula $matricula.";
        } 
    }

    function mostrarVehiculo(){
        $pago = unserialize($_COOKIE['pago']);
        $matricula = $pago['matricula'];
        echo "$matricula";
    }

    function mostrarTotal(){
        $pago = unserialize($_COOKIE['pago']);
        $precioTotal = $pago['precioTotal'];
        echo "$precioTotal";
    }
?>