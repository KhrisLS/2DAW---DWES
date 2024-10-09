<html>
<body>
<h1>CONVERSOR BINARIO</h1> 
<?php 
   $num1 = $_GET["decimal"];
   $conversion = decimalABinario($num1);

   echo "
   <form>
      <label name='decimal'>Número Decimal: </label>
      <input type='text' name='decimal' value='$num1' readonly><br>
      <label name='binario'>Número Binario: </label>
      <input type='text' name='binario' value='$conversion' readonly>
   </form>
   ";

   function decimalABinario($num) {
      $binario = decbin($num);
      return $binario;
   }

?>

</body>
</html>