<?php
  require_once('db/funciones.php');

  function mostrarEmp() {
    $sql = "SELECT emp_no, first_name, last_name
            FROM employees
            ORDER BY emp_no";
    return operarBd($sql);
  }

  function datosPersonales($emp) {
    $sql = "SELECT *
            FROM employees
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $emp];
    return operarBd($sql, $valores);
  }

  function departamentos($emp) {
    $sql = "SELECT a.emp_no, a.dept_no, b.dept_name, a.from_date, a.to_date
            FROM dept_emp a
            JOIN departments b ON a.dept_no = b.dept_no
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $emp];
    return operarBd($sql, $valores);
  }

  function cargoManager($emp) {
    $sql = "SELECT b.dept_name
            FROM dept_manager a
            JOIN departments b ON a.dept_no = b.dept_no
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $emp];
    return operarBd($sql, $valores);
  }

  function cargos($emp) {
    $sql = "SELECT *
            FROM titles
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $emp];
    return operarBd($sql, $valores);
  }

  function salarios($emp) {
    $sql = "SELECT *
            FROM salaries
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $emp];
    return operarBd($sql, $valores);
  }
?>