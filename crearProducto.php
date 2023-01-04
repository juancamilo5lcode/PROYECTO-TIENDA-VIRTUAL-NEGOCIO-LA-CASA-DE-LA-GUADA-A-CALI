<?php
if (isset($_REQUEST['guardar'])) {
    include_once "db_ecommerce.php";
    $conectar=conn();

    $nombre = mysqli_real_escape_string($conectar, $_REQUEST['nombre'] ?? '');
    $precio = mysqli_real_escape_string($conectar, $_REQUEST['precio'] ?? '');
    $existencia = mysqli_real_escape_string($conectar, $_REQUEST['existencia'] ?? '');
    $descripcion = mysqli_real_escape_string($conectar, $_REQUEST['descripcion'] ?? '');
    $foto =  $_FILES['foto'];

    $nombre_foto = $foto['name'];
    $type = $foto['type'];
    $url_temp = $foto['tmp_name'];

    $imgProducto = 'img_producto.png';
    if($nombre_foto != '')
    {
        $destino = 'images/uploads/';
        $img_nombre = 'img_' .md5(date('d-m-Y H:m:s'));
        $imgProducto = $img_nombre. '.jpg';
        $src = $destino.$imgProducto;
    }

    $query = "INSERT INTO productos
        (nombre       ,precio    ,existencia, descripcion, foto   ) VALUES
        ('" . $nombre . "','" . $precio . "','" . $existencia . "', '" . $descripcion . "', '" . $imgProducto. "');
        ";
    $res = mysqli_query($conectar, $query);
    if ($res) {
        echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=productos&mensaje=Producto creado exitosamente" />  ';
    } 
    if($res){
        if($nombre_foto != ''){
            move_uploaded_file($url_temp,$src);
        }
    }
    
    else {
?>
        <div class="alert alert-danger" role="alert">
            Error al crear producto <?php echo mysqli_error($conectar); ?>
        </div>
<?php
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Crear Producto</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="panel.php?modulo=crearProducto" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control"  required="required" >
                            </div>
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="text" name="precio" class="form-control"  required="required" >
                            </div>
                            <div class="form-group">
                                <label>Existencia</label>
                                <input type="text" name="existencia" class="form-control"  required="required" >
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="descripcion" class="form-control"  required="required" >
                            </div>
                            <div class="photo">
                            <label for="foto">Foto</label>
                                <div class="prevPhoto">
                                <span class="delPhoto notBlock">X</span>
                                <label for="foto"></label>
                                </div>
                                <div class="upimg">
                                <input type="file" name="foto" id="foto">
                                </div>
                                <div id="form_alert"></div>
                        </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>