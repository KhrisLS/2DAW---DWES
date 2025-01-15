<?php
function errores($errno, $errstr, $errfile, $errline){
    //Control de errores
    echo "<p><strong>ERROR:</strong> $errstr</p><br>";
    die();
}

set_error_handler("errores");
?>

