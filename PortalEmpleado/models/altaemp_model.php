<?php
  require_once('db/funciones.php');

  function mostrarDept() {
    $sql = "SELECT dept_no, dept_name
            FROM departments
            ORDER BY dept_no";
    return operarBd($sql);
  }

  function ultimoNumEmpleado() {
    $sql = "SELECT emp_no
            FROM employees
            ORDER BY emp_no 
            DESC LIMIT 1";
    return operarBd($sql)[0];
  }

  function realizarAltaEmp($numEmp, $nombre, $apellido, $nacimiento, $genero) {
    $sql = "INSERT INTO employees (emp_no, birth_date, first_name, last_name, gender, hire_date)
            VALUES (:emp_no, :birth_date, :first_name, :last_name, :gender, CURDATE())";
    $valores = ['emp_no' => $numEmp, 'birth_date' => $nacimiento, 'first_name' => $nombre, 'last_name' => $apellido, 'gender' => $genero];
    return operarBD($sql, $valores);
  }

  function realizarAltaEnDept($numEmp, $dept) {
    $sql = "INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date)
            VALUES (:emp_no, :dept_no, CURDATE(), NULL)";
    $valores = ['emp_no' => $numEmp, 'dept_no' => $dept];
    return operarBd($sql, $valores);
  }

  function realizarAltaEnSalario($numEmp, $salario) {
    $sql = "INSERT INTO salaries (emp_no, salary, from_date, to_date)
            VALUES (:emp_no, :salary, CURDATE(), NULL)";
    $valores = ['emp_no' => $numEmp, 'salary' => $salario];
    return operarBd($sql, $valores);
  }

  function realizarAltaEnCargo($numEmp, $cargo) {
    $sql = "INSERT INTO titles (emp_no, title, from_date, to_date)
            VALUES (:emp_no, :title, CURDATE(), NULL)";
    $valores = ['emp_no' => $numEmp, 'title' => $cargo];
    return operarBd($sql, $valores);
  }

  
?>