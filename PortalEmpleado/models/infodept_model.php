<?php
  require_once('db/funciones.php');

  function mostrarDept() {
    $sql = "SELECT dept_no, dept_name
            FROM departments
            ORDER BY dept_no";
    return operarBd($sql);
  }

  function obtenerManager($dept) {
    $sql = "SELECT a.emp_no, b.first_name, b.last_name, b.birth_date, b.gender, b.hire_date
            FROM dept_manager a
            JOIN employees b ON a.emp_no = b.emp_no
            WHERE a.dept_no = :dept_no";
    $valores = [':dept_no' => $dept];
    return operarBd($sql, $valores);
  }

?>