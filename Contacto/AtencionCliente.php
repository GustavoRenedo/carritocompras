<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atencion al Cliente</title>
    <link rel="stylesheet" href="estilos1.css">
    <link rel="icon" href="imgInicio/favicon.ico">
    
</head>


        
<body>
    <div class="container w-75  mt-5 rounded shadow">
    <div class="row align-items-stretch">
            <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

            </div>
            <div class="col bg-white p-5 rounded-end">
                <div class="text-end">

                </div>

                <form action="enviar.php" method="post" class="form_contact">
                <h2 class="fw-bold text-center py-5">Atención al cliente</h2>

                        <div class="card-body">

                            <div class="mb-4">
                                <label for="names" class="form-lable">Nombre</label>
                                <input type="text" class="form-control" id="names" name="nombre" required>
                            </div>

                            <div class="mb-4">
                                <label for="phone">Telefono / Celular</label>
                                <input type="text" id="phone" name="telefono">
                            </div>

                            <div class="mb-4">
                                <label for="email">Correo electronico *</label>
                                <input type="text" id="email" name="correo" required>
                            </div>

                            <div class="mb-4">
                                <label for="mensaje">Mensaje *</label>
                                <textarea id="mensaje" name="mensaje" required></textarea>
                            </div>

                                <div class="mb-4">
                                <input type="submit" value="Enviar Mensaje" id="btnSend">
                            </div>
                        
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 text-center">
                                    <a href="/PaginaPr.php">Regresar a la tienda</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
            </section>

</body>
</html>
<?php require_once "footer.php"; ?>