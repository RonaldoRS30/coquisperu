<!--vista => producto_view.php-->

<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/producto.js?=<?=JS;?>"></script>

<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<style>
    .costo{
        display: inline-block;
        position: relative;
        padding: 0.5em;
        cursor: pointer;
    }
    .costo:hover{
        background: rgba(51,51,51,.1);
    }
    .costo .editar_costo{
        text-align: left;
        position: absolute;
        visibility: hidden;
        padding: 0.7em 0.7em 0.7em 0.7em;
        width: 25em;
        top: -25%;
        right: 100%;
        background: rgba(51,51,51,.9);
    }
    .costo:hover .editar_costo{
        visibility: visible;
        width: 25em;
        background: rgba(51,51,51,.9);
        border-radius: 0.1em 0.1em 0.1em 0.1em;
    }
    .costo:hover input, .costo:hover .editar_costo img{
        opacity: 1;
    }
    .editar_costo input, .editar_costo img{
        opacity: 0;
        width: auto;
    }
    .busqueda_opcinal{
        position: relative;
        text-align: center;
    }
    .busqueda_opcinal_1{
        position: absolute;
        background-color: #004488;
        color: #f1f4f8;
        width: 98px;
        height: 70px;
        top: 14px;
        left: 135px;
        -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        -moz-box-shadow:    0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        box-shadow:         0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        cursor: pointer;
    }
    .control_1 .seleccionado{
        position: absolute;
        border-radius: 3px;
        background-color: #29fb00;
        width: 98px;
        height: 5px;
        bottom: 20px;
        left: 135px;
    }
    .busqueda_opcinal_2{
        position: absolute;
        background: #109EC8;
        color: #f1f4f8;
        width: 95px;
        height: 70px;
        top: 14px;
        right: 102px;
        cursor: pointer;
        -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        -moz-box-shadow:    0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        box-shadow:         0px 0px 0px 3px rgba(47, 50, 50, 0.34);
    }
    .control_2 .seleccionado{
        position: absolute;
        border-radius: 3px;
        background-color: #ab1c27;
        width: 96px;
        height: 5px;
        bottom: 21px;
        right: 102px;
    }
</style>

<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?=$titulo_busqueda;?></div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <div class="row fuente8 py-1">
            <div class="col-sm-1 col-md-1 col-lg-1 form-group">
                <label for="txtCodigo">Código: </label>
                <input id="txtCodigo" name="txtCodigo" type="text" class="form-control w-porc-90 h-1" placeholder="Codigo" maxlength="30" value="<?=$codigo;?>">
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="txtNombre">Nombre: </label>
                <input id="txtNombre" name="txtNombre" type="text" class="form-control w-porc-90 h-1" maxlength="100" placeholder="Nombre producto" value="<?php echo $nombre; ?>">
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="txtFamilia">Categoría: </label>
                <select name="txtFamilia" id="txtFamilia" class="form-control w-porc-90 h-2">
                    <option value=""> TODOS </option><?php
                    if ($familias != NULL){
                        foreach ($familias as $i => $v){ ?>
                            <option value="<?=$v->FAMI_Codigo;?>"><?=$v->FAMI_Descripcion;?></option> <?php
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                <label for="txtMarca">Marca: </label>
                <input id="txtMarca" type="text" class="form-control w-porc-90 h-1" name="txtMarca" maxlength="100" placeholder="Marca producto" value="<?=$marca;?>">
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                <label for="txtModelo">Modelo: </label>
                <select name="txtModelo" id="txtModelo" class="form-control w-porc-90 h-2">
                    <option value=""> TODOS </option><?php
                    if ($modelos != NULL){
                        foreach ($modelos as $indice => $val){
                            if ($val->PROD_Modelo != ''){ ?>
                                <option value="<?=$val->PROD_Modelo;?>"><?=$val->PROD_Modelo;?></option> <?php
                            }
                        }
                    } ?>
                </select>
            </div>
            

            <input id="codigoInterno" name="codigoInterno" type="hidden" class="cajaGrande" maxlength="100" placeholder="Codigo original" value="<?=$codigoInterno;?>">
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <ul id="imprimirProducto" class="lista_botones">
                                <li id="excel">Lista de precios</li>
                            </ul>
                            <ul id="limpiarP" class="lista_botones">
                                <li id="limpiar">Limpiar</li>
                            </ul>
                            <ul id="buscarP" class="lista_botones">
                                <li id="buscar">Buscar</li>
                            </ul>
                        </div>
                        <div id="lineaResultado">Registros encontrados</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="header text-align-center"><?=$titulo;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                    </div>
                    <table class="fuente8 display" id="table-productos">
                        <thead>
                            <tr class="cabeceraTabla">
                                <th style="width: 05%" data-orderable="true">CÓDIGO</th>
                                <th style="width: 20%" data-orderable="true">NOMBRE</th>
                                <th style="width: 10%" data-orderable="false">UNIDAD MEDIDA</th>
                                <?php
                                foreach ($categorias as $key => $val){ ?>
                                    <th style="text-indent: 0;" data-orderable="false"><?=$val->TIPCLIC_Descripcion;?></th> <?php
                                }?>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script language="javascript" >
    
    $(document).ready(function() {

        $('#table-totales').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            autoWidth: false,
            paging: false,
            language: spanish
        });

        $('#table-precios').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            autoWidth: false,
            paging: false,
            language: spanish
        });

        $('#table-productos').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : "<?=base_url();?>index.php/almacen/producto/datatable_producto_precio/<?=$flagBS;?>",
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                    },
                    error: function(){
                    }
            },
            language: spanish
        });

        $("#buscarP").click(function(){
            codigo = $('#txtCodigo').val();
            producto = $('#txtNombre').val();
            familia = $('#txtFamilia').val();
            marca = $('#txtMarca').val();
            modelo = $('#txtModelo').val();

            $('#table-productos').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/producto/datatable_producto_precio/<?=$flagBS;?>",
                        type: "POST",
                        data: { txtCodigo: codigo, txtNombre: producto, txtFamilia: familia, txtMarca: marca, txtModelo: modelo },
                        error: function(){
                        }
                },
                language: spanish
            });
        });

        $("#limpiarP").click(function(){

            $("#txtCodigo").val("");
            $("#txtNombre").val("");
            $("#txtFamilia").val("");
            $("#txtMarca").val("");
            $("#txtModelo").val("");

            codigo = "";
            producto = "";
            familia = "";
            marca = "";
            modelo = "";

            $('#table-productos').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/producto/datatable_producto_precio/<?=$flagBS;?>",
                        type: "POST",
                        data: { txtCodigo: codigo, txtNombre: producto, txtFamilia: familia, txtMarca: marca, txtModelo: modelo },
                        error: function(){
                        }
                },
                language: spanish
            });
        });

        $("#nvo_autocompleteCodigoSunat").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?=base_url();?>index.php/almacen/producto/autocompleteIdSunat/",
                    type: "POST",
                    data: {
                        term: $("#nvo_autocompleteCodigoSunat").val()
                    },
                    dataType: "json",
                    success: function (data) {
                        response( $.map(data, function(item) {
                                return {
                                    label: item.descripcion,
                                    value: item.descripcion,
                                    idsunat: item.idsunat
                                }})
                            );
                    }
                });
            },
            select: function(event, ui) {
                $("#nvo_codigoSunat").val(ui.item.idsunat);
            },
            minLength: 2
        });

        $("#nvo_codigo").change(function(){
          $.ajax({
              type: "POST",
              dataType: "json",
              url: "<?=base_url();?>index.php/almacen/producto/existsCode/",
              data: {
                codigo: $(this).val(),
                producto: $("#id").val()
              },
              success: function(data){
                if (data.match == true){
                  Swal.fire({
                    icon: "info",
                    title: "Código registrado.",
                    html: "<b class='color-red'>El código ingresado ha sido registrado anteriormente.</b>",
                    showConfirmButton: true
                  });
                }
              }
          });
        });

        $("#nvo_nombre").change(function(){
          $.ajax({
              type: "POST",
              dataType: "json",
              url: "<?=base_url();?>index.php/almacen/producto/existsNombre/",
              data: {
                nombre: $(this).val(),
                producto: $("#id").val()
              },
              success: function(data){
	              if (data.match == true){
                  Swal.fire({
                    icon: "info",
                    title: "Nombre registrado.",
                    html: "<b class='color-red'>El nombre ingresado ha sido registrado anteriormente.</b>",
                    showConfirmButton: true
                  });
              	}
              }
          });
        });

        $("#nvo_descripcion").keyup(function(){
            var descripcion = $("#nvo_descripcion").val().length;

            longitud = 800 - descripcion;
            $(".contadorCaracteres").html(longitud);
        });

        $(".nvo_limpiar").click(function(){
            clean();
        });
    });

    function clean(){
        $("#form_nvo")[0].reset();
        $("#id").val("");
        $(".contadorCaracteres").html("800");

        $("#nvo_codigo").removeAttr("readOnly");
    }
</script>