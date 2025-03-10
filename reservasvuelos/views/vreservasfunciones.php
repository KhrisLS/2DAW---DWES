<?php
function listaVuelos(){
    $vuelos = vuelosDisponibles();

    // Opción por defecto
    echo "<option value='' selected disabled>-- SELECCIONA UN VUELO --</option>";

    // Usamos los datos obtenidos
    foreach ($vuelos as $row) {
        echo "<option value='" . $row["id_vuelo"] . "'>" . $row["id_aerolinea"] . " - " . $row["origen"] . " - " . $row["destino"]. "</option>";
    }
}

// Función para mostrar los vuelos agregados al carrito
function mostrarVuelosAgregados($vuelosAgregados) {
    if (isset($vuelosAgregados[$_SESSION['usuario']])) {
      $vuelos = $vuelosAgregados[$_SESSION['usuario']];
      crearTablaVuelos($vuelos);
    } else
      echo 'Aún no has agregado ningún vuelo';
}

// Función para crear la tabla de los vuelos agregados al carrito
function crearTablaVuelos($vuelos) {
    echo "<table border='1' style='border-collapse: collapse; width: 810px; text-align: left;'>";
      echo '<tr>';
        echo '<th>Origen</th>';
        echo '<th>Destino</th>';
        echo '<th>Fecha de salida</th>';
        echo '<th>Fecaha de llegada</th>';
        echo '<th>Aerolínea</th>';
        echo '<th>Precio por asiento</th>';
        echo '<th>Asientos reservados</th>';
        echo '<th>Precio total</th>';
      echo '</tr>';
    foreach ($vuelos as $vuelo) {
        $datos = detallesVuelo($vuelo[vuelo]);
      echo '<tr>';
        echo '<td>' . $datos['origen'] . '</td>';
        echo '<td>' . $datos['destino'] . '</td>';
        echo '<td>' . $datos['fechahorasalida'] . '</td>';
        echo '<td>' . $datos['fechahorallegada'] . '</td>';
        echo '<td>' . $datos['nombre_aerolinea'] . '</td>';
        echo '<td>' . $datos['precio_asiento'] . ' €</td>';
        echo '<td>' . $vuelo['asientos'] . '</td>';
        echo '<td>' . $datos['precio_asiento'] * $vuelo['asientos'] . ' €</td>';
      echo '</tr>';
    }
    echo '</table>';
}
?>