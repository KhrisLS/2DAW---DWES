<html>
   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pago realizado - MovilMad</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
 </head>
      
<body>
    <h1>Servicio de ALQUILER DE E-CARS</h1>

    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">PAGO REALIZADO CON ÉXITO </div>
		<div class="card-body">
	  
	  	
	   

	<!-- INICIO DEL FORMULARIO -->
	<form action="" method="post">
				
		<B>Gracias por su compra:</B>  <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> <BR>
		<B>Identificador Cliente:</B> <?php echo htmlspecialchars($_SESSION['usuario']['idcliente']); ?> <BR><BR>

        <B>Vehículo Devuelto:</B> <?php mostrarVehiculo(); ?> <BR>
        <B>Precio Total:</B> <?php mostrarTotal(); ?> <BR><BR>
				
		<div>
			<input type="submit" value="Volver" name="volver" class="btn btn-warning disabled">
		</div>		
	</form>

</body>
</html>