<?php
require_once "header.php";

if (isset($_SESSION["usuario"])) {
    header("Location: index.php");
} else if (isset($_POST['accion']) && $_POST['accion'] === 'login') {
    if ($opcionesAdmin->login($_POST)) {
        header("Location: index.php");
    } else {
        echo "Error de acceso: Nombre de cliente o contraseña incorrecta.";
    }
}
?>

<!--Creamos el inicio de sesion-->
<body class="Login-control">
      <div class="login-container">
          <div class="login-info-container">
            <h1 class="titulo-login"></h1>
            <br>
            <div style="display: flex; justify-content: center;">
                <img src="../img_config/icono_amg.png" alt="" style="width: 250px; height: 100px;">
            </div>
            
            <form  class="botones-container"name="login" id="login" action="" method="post">
              <input type="hidden" name="accion" value="login">
              
            
            <form value="#">
                <input class="botones form-control" type="email" id="loginEmail" name="loginEmail" placeholder="Correo" autofocus required>


                <input class="botones form-control" id="loginPassword" name="loginPassword"  type="password" placeholder="Contraseña" required>         
                
                <input type="submit" class="boton-acceder" id="login_m" value="Acceder">
  
            </form>
          </div>
            <img class="image-container" src="../img/img_login.jpg" alt="">
      </div>
    </form>
</body>



<?php require_once "footer.php"; ?>