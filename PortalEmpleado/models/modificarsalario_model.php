<?php
  require_once('db/funciones.php');

  function mostrarEmp() {
    $sql = "SELECT emp_no, first_name, last_name
            FROM employees
            ORDER BY emp_no";
    return operarBd($sql);
  }

  function obtenerDiaUltimaModificacion($emp) {
    $sql = "SELECT from_date
              FROM salaries
              WHERE emp_no = :emp_no AND to_date IS NULL";
    $valores = [':emp_no' => $emp];
    return operarBd($sql, $valores);
  }

  function actualizarSalarioExistente($emp) {
    $sql = "UPDATE salaries
            SET to_date = CURDATE()
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $emp];
    return operarBd($sql, $valores);
  }

  function insertarNuevoSalario($emp, $salario) {
    $sql = "INSERT INTO salaries (emp_no, salary, from_date, to_date)
            VALUES (:emp_no, :salary, CURDATE(), NULL)";
    $valores = [':emp_no' => $emp, 'salary' => $salario];
    return operarBd($sql, $valores);
  }
?>