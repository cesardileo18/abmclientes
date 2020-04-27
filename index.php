<?php
include_once "config.php";
ini_set('display_errors' , '1');
ini_set('display_startup_errors','1');
ini_set('error_reporting', E_ALL);


if(file_exists("clientes.txt")){
$jsonClientes = file_get_contents("clientes.txt");
$aClientes = json_decode ($jsonClientes, true);

} else {

    $aClientes = array ();
}
$pos = isset ($_GET["pos"]) ? $_GET["pos"] : "";

if($_POST){ /* es posback, porque alguien le dio clik en guardar */
    //Definicion de variables 
    $dni = $_POST["txtDni"]; 
    $nombre = $_POST["txtNombre"];
    $telefono = $_POST["txtTelefono"];
    $correo = $_POST["txtCorreo"];

    if(isset($_GET["do"]) && $_GET["do"]  == "edit"){

        //Modificar la pocision del cliente a editar, cambiando por los nuevos campos 
        $aClientes[$pos] = array ("dni" => $dni,
                            "nombre" => $nombre,
                            "telefono" => $telefono, 
                            "correo" => $correo);   

        //Convertir el array en json
        $jsonClientes = json_encode($aClientes);

        //guardar el json en el archivo 
        file_put_contents("clientes.txt", $jsonClientes);

    } else {
        //convertinmos los datos del formulario en un array
        $aClientes[] = array ("dni" => $dni,
                            "nombre" => $nombre,
                            "telefono" => $telefono, 
                            "correo" => $correo);   

        //convertimos el array a json
        $jsonClientes = json_encode($aClientes);

        //guardamos el json en el archivo 
          
    } 
}

if (isset($_GET["do"]) && $_GET["do"]  == "delete"){
      unset($aClientes[$pos]);
      //Guardar en el archivo el nuevo array de clientes modificado 
     
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abm Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet" />
       <link rel="stylesheet" href="css/bootstrap.min.css" />
        <!-- menu nav -->
       <link rel="stylesheet" href="css/fontawesome/css/all.min.css" />
       <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css" />
       <link rel="stylesheet" href="estilos.css" />
</head>
<body>
   <div class="container">
      <div class="row">
         <div class="col-12 text-center py-3">
             <h1>Registro de Clientes</h1>
         </div>
     </div>
           <div class="row">
             <div class="col-6">
     <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                      <div class="col-12 form-group">
                          <label for="txtDni">Dni:</label>
                          <input type="txt" id="txtDni" name="txtDni" class="form-control" required value="<?php echo isset($aClientes[$pos]["dni"])? $aClientes[$pos]["dni"] : ""; ?>">
                       </div>
                   <div class="col-12 form-group">
                          <label for="txtNombre">Nombre:</label>
                          <input type="txt" id="txtNombre" name="txtNombre" class="form-control" required value="<?php echo isset ($aClientes[$pos]["nombre"])? $aClientes[$pos]["nombre"] : ""; ?>">
                  </div>
                  <div class="col-12 form-group">
                          <label for="txtTelefono">Telefono:</label>
                          <input type="txt" id="txtTelefono" name="txtTelefono" class="form-control" required value="<?php echo isset($aClientes[$pos]["telefono"])? $aClientes[$pos]["telefono"] : ""; ?>">
                   </div>
                   <div class="col-12 form-group">
                         <label for="txtCorreo">Correo:</label>
                         <input type="txt" id="txtCorreo" name="txtCorreo" class="form-control" required value="<?php echo isset($aClientes[$pos]["correo"])? $aClientes[$pos]["correo"] : ""; ?>">
                   </div>
               </div>
               <div class="row">
                <div class="col-12">
                    <button type="sumit" id="btnInsertar" name="btnInsertar" class="btn btn-primary">Guardar</button>
               </div>
            </div> 
        </form>
     </div>
     <div class="col-6">
          <table class="table table-hover border">
              <tr>
                  <th>DNI</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Acciones</th>
              </tr>
              <?php
              foreach ($aClientes as $pos => $cliente) { 
                      ?>
              <tr>
                    <td><?php echo $cliente["dni"];?></td>
                    <td><?php echo $cliente["nombre"];?></td>
                    <td><?php echo $cliente["correo"];?></td>  
                    <td>
                        <a href="?pos=<?php echo $pos; ?>&do=edit"><i class="far fa-edit"></i></a>
                        <a href="?pos=<?php echo $pos;?>&do=delete"><i class="far fa-trash-alt"></i>
                   </td>
              </tr>
                  <?php 
                     } ?>
         </table>
       </div>
   </div>
</div>
<footer>
    <div class="container">
         <div class="row"> 
             <div class="col-12 text-sm-right text-center">
             <a href="index.php?do=new"><i id="ingresar" class="fas fa-user-plus"></i></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
        
                     