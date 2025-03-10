<?php
  // Función para mostrar en el select las reservas hechas por el cliente
  function selectNumerosReserva() {
    $dni = buscarDni($_SESSION['usuario']);
    $reservas = obtenerReservas($dni);

    echo "<option value='' selected disabled>- SELECCIONA -</option>";
    foreach ($reservas as $reserva)
      echo "<option value='" . $reserva['id_reserva'] . "'>" . $reserva['id_reserva'] . "</option>";

  }

  // Función para mostrar los vuelos de la reserva indicada
  function mostrarVuelosReserva($reserva) {
    $vuelos = datosVuelosReserva($reserva);
    crearTablaVuelosReserva($vuelos);
  }

  // Función para crear la tabla de los vuelos de la reserva indicada
  function crearTablaVuelosReserva($vuelos) {
    echo "<table border='1' style='border-collapse: collapse; width: 810px; text-align: left;'>";
      echo '<tr>';
        echo '<th>Aerolínea</th>';
        echo '<th>Origen</th>';
        echo '<th>Destino</th>';
        echo '<th>Salida</th>';
        echo '<th>Llegada</th>';
        echo '<th>Asientos</th>';
      echo '</tr>';
    foreach ($vuelos as $vuelo) {
      echo '<tr>';
        echo '<td>' . $vuelo['nombre_aerolinea'] . '</td>';
        echo '<td>' . $vuelo['origen'] . '</td>';
        echo '<td>' . $vuelo['destino'] . '</td>';
        echo '<td>' . $vuelo['fechahorasalida'] . '</td>';
        echo '<td>' . $vuelo['fechahorallegada'] . '</td>';
        echo '<td>' . $vuelo['num_asientos'] . '</td>';
      echo '</tr>';
    }
    echo '</table>';
  }
?>