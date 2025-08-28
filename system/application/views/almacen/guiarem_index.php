<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/guiarem.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js?=<?=JS;?>"></script>

<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>
<script language="javascript">
    $(document).ready(function () {
        $("a#linkVerCliente, a#linkVerProveedor, a#linkVerProducto").fancybox({
            'width': 700,
            'height': 450,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': true,
            'type': 'iframe'
        });
        
        $("a#ocompra, a#comprobante").fancybox({
            'width': 800,
            'height': 500,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': false,
            'type': 'iframe'
        });

        //agregado autocompletar gcbq
        $("#nombre_producto").autocomplete({

            source: function (request, response) {

                $.ajax({
                    //contiene flagbs-bien o servicio
                    //url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/"+$("#flagBS").val()+"/"+$("#compania").val(),

                    url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/B/" + $("#compania").val(),
                    type: "POST",
                    data: {term: $("#nombre_producto").val()},
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }

                });

            },

            select: function (event, ui) {

                $("#buscar_producto").val(ui.item.codinterno);
                $("#producto").val(ui.item.codigo)
                $("#codproducto").val(ui.item.codinterno);
            },

            minLength: 2

        });

        $("#nombre_cliente").autocomplete({
            source: function (request, response) {

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                    type: "POST",
                    data: {term: $("#nombre_cliente").val()},
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },

            select: function (event, ui) {
                $("#buscar_cliente").val(ui.item.ruc)
                $("#cliente").val(ui.item.codigo);
                $("#ruc_cliente").val(ui.item.ruc);
            },

            minLength: 2

        });


        $("#nombre_proveedor").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete/",
                    type: "POST",
                    data: {term: $("#nombre_proveedor").val()},
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }

                });

            },
            select: function (event, ui) {
                $("#buscar_proveedor").val(ui.item.ruc)
                $("#proveedor").val(ui.item.codigo);
                $("#ruc_proveedor").val(ui.item.ruc);
            },

            minLength: 2

        });

        /////////////////7
    });
    function seleccionar_cliente(codigo, ruc, razon_social, empresa, persona) {
        $("#cliente").val(codigo);
        $("#ruc_cliente").val(ruc);
        $("#nombre_cliente").val(razon_social);
    }
    function seleccionar_proveedor(codigo, ruc, razon_social) {
        $("#proveedor").val(codigo);
        $("#ruc_proveedor").val(ruc);
        $("#nombre_proveedor").val(razon_social);
    }
    function seleccionar_producto(codigo, interno, familia, stock, costo) {
        $("#producto").val(codigo);
        $("#codproducto").val(interno);

        base_url = $("#base_url").val();
        url = base_url + "index.php/almacen/producto/listar_unidad_medida_producto/" + codigo;
        $.getJSON(url, function (data) {
            $.each(data, function (i, item) {
                nombre_producto = item.PROD_Nombre;
            });
            $("#nombre_producto").val(nombre_producto);
        });
    }

    function relacionado_comprobante(numero){
        alert('Guia de remision relacionada con el numero ' + numero);
    }

</script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <input type="hidden" name="compania" id="compania" value="<?=$compania?>">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <div id="frmBusqueda">
                <form id="form_busqueda" name="form_busqueda" method="post">
                <div class="row fuente8 py-1">
                    <div class="col-sm-11 col-md-2">
                        <label for="fechai">FECHA DESDE:</label>
                        <input type="date" name="fechai" id="fechai" value="" placeholder="Desde" class="form-control h-1"/>
                    </div>
                    <div class="col-sm-11 col-md-2">
                        <label for="fechaf">FECHA HASTA:</label>
                        <input type="date" name="fechaf" id="fechaf" value="" placeholder="Hasta" class="form-control h-1"/>
                    </div>
                    <div class="col-sm-11 col-md-1">
                        <label for="seriei">SERIE:</label>
                        <input type="text" step="1" name="seriei" id="seriei" value="" placeholder="SERIE" class="form-control h-1"/>
                    </div>
                    <div class="col-sm-11 col-md-1">
                        <label for="numero">NÚMERO:</label>
                        <input type="text" step="1" name="numero" id="numero" value="" placeholder="NUMERO" class="form-control h-1"/>
                    </div>
                    
                </div>
                <div class="row fuente8 py-1">
                    <!-- CLIENTE -->
                    <div class="col-sm-11 col-md-1" <?=($tipo_oper == 'V') ? '' : 'hidden'; ?>>
                        <label for="ruc_cliente">RUC / DNI:</label>
                        <input type="hidden" name="cliente" id="cliente" value=""/>
                        <input type="number" step="1" name="ruc_cliente" id="ruc_cliente" value="" placeholder="RUC ó DNI" class="form-control h-1"/>
                    </div>
                    <div class="col-sm-11 col-md-3" <?=($tipo_oper == 'V') ? '' : 'hidden'; ?>>
                        <label for="nombre_cliente">NOMBRE Ó RAZÓN SOCIAL:</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control h-1" placeholder="Nombre ó razón social"/>
                    </div>
                    <!-- END CLIENTE -->

                    <!-- PROVEEDOR -->
                    <div class="col-sm-11 col-md-1" <?=($tipo_oper == 'C') ? '' : 'hidden'; ?>>
                        <label for="ruc_proveedor">RUC / DNI:</label>
                        <input type="hidden" name="proveedor" id="proveedor" value=""/>
                        <input type="number" step="1" name="ruc_proveedor" id="ruc_proveedor" value="" placeholder="RUC ó DNI" class="form-control h-1"/>
                    </div>
                    <div class="col-sm-11 col-md-3" <?=($tipo_oper == 'C') ? '' : 'hidden'; ?>>
                        <label for="nombre_proveedor">NOMBRE Ó RAZÓN SOCIAL:</label>
                        <input type="text" id="nombre_proveedor" name="nombre_proveedor" class="form-control h-1" placeholder="Nombre ó razón social"/>
                    </div>
                    <!-- END PROVEEDOR -->
                    
                </div>
                <div id="cabeceraResultado" class="header">
                    <?php echo $titulo_tabla; ?>
                    <?php echo $oculto; # ESTA VARIABLE CONTIENE EL TIPO DE OPERACION Y TIPO DE DOCUMENTO ?>
                </div>
            </form>
            </div>
            <div class="acciones">
                <div id="botonBusqueda">
                   <!-- <ul id="imprimirGuiarem" class="lista_botones">
                        <li id="imprimir">Imprimir</li>
                    </ul>-->
                    <ul id="nuevaGuiarem" class="lista_botones">
                        <li id="nuevo">Guia de Remisión</li>
                    </ul>
                    <ul id="limpiarG" class="lista_botones">
                        <li id="limpiar">Limpiar</li>
                    </ul>
                    <ul id="buscarG" class="lista_botones">
                        <li id="buscar">Buscar</li>
                    </ul>
                </div>
                <div id="lineaResultado">
                    <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td width="50%" align="left">Guias de remisión</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla; ?></div>
            <div id="frmResultado">
                <table class="fuente8 display" width="100%" cellspacing="0" cellpadding="3" border="0" id="table-guiarem">
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                    </div>
                    <thead>
                        <tr class="cabeceraTabla">
                            
                            <th style="width:07%;" data-orderable="true">FECHA</th>
                            <th style="width:05%;" data-orderable="true">SERIE</th>
                            <th style="width:07%;" data-orderable="true">NUMERO</th>
                            <th style="width:31.5%;" data-orderable="true">RAZON SOCIAL</th>
                            <th style="width:06%;" data-orderable="false">BOLETA</th>
                            <th style="width:06%;" data-orderable="false">FACTURA</th>
                            <th style="width:06%;" data-orderable="false">COTIZACIÓN</th>
                            <th style="width:10.5%;" data-orderable="false">O. C.</th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:06%;" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /*if (count($lista) < 0) {
                            foreach ($lista as $indice => $valor) {
                                $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla'; ?>
                                <tr class="<?php echo $class; ?>">
                                    <td>
                                        <div align="center"><?php echo $valor[0]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[1]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[2]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[3]; ?></div>
                                    </td>
                                    <td>
                                        <div align="left"><?php echo $valor[6]; ?></div>
                                    </td>
                                    <td>
                                    <!--No  visualiza la factura-->
                                        <div align="center"><?php echo $valor[14]; ?></div>
                                    </td>
                                    
                                    <td>
                                    <!--NO visualiza la guia de remision-->
                                        <div align="center"><?php echo $valor[13]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[12]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center" style="cursor:pointer; color:#003399; font-weight: normal; font-size: 11px;"><?php echo $valor[18]; ?></div> <!--HERE DATA OC -->
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[11]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center" class="editar_data_<?=$valor[0]?>"><?=$valor[8];?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?=$valor[9];?></div>
                                    </td>
                                    <td>
                                        <div align="left"><?=$valor[10];?></div>
                                    </td>
                                    <td>
                                        <div align="left"><?=$valor[20];?></div>
                                    </td>
                                    <td>
                                        <div align="left" class="pdfSunat_<?=$valor[0]?>">
                                            <span class="icon-loading"></span>
                                            <span class="pdfSunat_data_<?=$valor[0]?>"><?=$valor[19];?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="center"><?=$valor[17];?></div>
                                    </td>
                                    <td>
                                        <div align="center" class="disparador_<?=$valor[0]?>"> <!-- APROBAR -->
                                            <span class='icon-loading'></span>
                                            <span class="disparador_data_<?=$valor[0]?>"><?=$valor[15];?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        }*/?>
                    </tbody>
                </table>
            </div>
            <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
            <?php echo $oculto ?>
        </div>
    </div>
</div>
<!--ANULACION DE DOCUMENTO-->
    <div class="modal fade modal-anulacion" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 700px; padding: 1em 3em 1em 3em; height: auto; margin: auto; font-family: Trebuchet MS, sans-serif; font-size: 10pt;">
                <form method="post" id="form-mail">
                    <div class="contenido" style="width: 100%; margin: auto; height: auto; overflow: auto;">
                        <div class="tempde_head">

                            <div class="row">
                                <div class="col-sm-11 col-md-11 col-lg-11" style="text-align: center;">
                                    <h3>DESHABILITAR GUIA (INTERNO)</h3>
                                </div>
                            </div>

                            <input type="hidden" id="idDocAnula" name="idDocAnula">
                        </div>

                        <div class="tempde_body">
                            
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <label for="anulaSerie">SERIE:</label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <label for="anulaNumero">NUMERO:</label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <span id="anulaSerie" name="anulaSerie" style="font-size: 20pt;"></span>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <span id="anulaNumero" name="anulaNumero" style="font-size: 20pt;"></span>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                                
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-sm-11 col-md-11 col-lg-11">
                                    <label for="motivo">MOTIVO (opcional):</label>
                                    <span class="mail-contactos"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-11 col-md-11 col-lg-11">
                                    <input type="text" class="form-control" id="motivo" name="motivo" value="" placeholder="motivo">
                                </div>
                            </div>
                            <br>
                        </div>

                        <div class="tempde_footer">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6"></div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <span class="icon-loading-md"></span>
                                    <div style="float: right">
                                        <span class="btn btn-success btn-sendAnulacion">Enviar</span>
                                        &nbsp;
                                        <span class="btn btn-danger btn-close-sendAnulacion">Cerrar</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- FIN ANULACION DE DOCUMENTO-->
<script>
    $(document).ready(function(){
        /*ANULACION*/
            $(".btn-sendAnulacion").click(function(){
                
                codigo = $("#idDocAnula").val();
                motivo = $("#motivo").val();

                
                var url = "<?=base_url();?>index.php/almacen/guiarem/deshabilitar_guia";
                $.ajax({
                    url:url,
                    type:"POST",
                    data:{ guia: codigo, motivo: motivo},
                    dataType:"json",
                    error:function(data){
                    },
                    beforeSend: function(){
                        $(".tempde_footer .icon-loading-md").show();
                        $(".btn-sendAnulacion").hide();
                    },
                    success:function(data){
                        if (data.result == "success"){
                            Swal.fire({
                                icon: "success",
                                title: data.msj,
                                showConfirmButton: true,
                                timer: 2000
                            });
                            $("#buscarG").click();
                            $(".modal-anulacion").modal("hide");
                        }
                        
                        if(data.result == "error"){
                            Swal.fire({
                                icon: "error",
                                title: data.msj,
                                html: "<b>Comuníquese con SOPORTE TÉCNICO</b>",
                                showConfirmButton: true
                            });
                        }
                        if (data.result == "observacion"){
                            Swal.fire({
                                icon: "error",
                                title: data.msj,
                                html: "",
                                showConfirmButton: true
                            });
                        }
                    },
                    complete: function(){
                        $(".tempde_footer .icon-loading-md").hide();
                        $(".btn-sendAnulacion").show();
                    }
                });
            });

            $(".btn-close-sendAnulacion").click(function(){
                $(".modal-anulacion").modal("hide");
            });
        /*FIN ANULACION*/
        $("#nombre_producto").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/autocomplete_producto/B//",
                    type: "POST",
                    data: {
                        term: $("#nombre_producto").val(), TipCli: "", marca: "", modelo: "" 
                    },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $("#producto").val(ui.item.codigo);
                $("#nombre_producto").val(ui.item.descripcion);
                $("#codproducto").val(ui.item.codinterno);
            },
            minLength: 2
        });

        $("#nombre_producto").keyup(function(){
            var cadena = $("#nombre_producto").val();
            if ( cadena.length == 0 ){
                $("#producto").val("");
                $("#codproducto").val("");
            }
        });
    
        $('#table-guiarem').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/guiarem/datatable_guiarem/<?="$tipo_oper";?>',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $(".loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $(".loading-table").hide();

                    }
            },
            language: spanish,
            order: [[ 0, "desc" ]]
        });

        $("#buscarG").click(function(){

            fechai          = $("#fechai").val();
            fechaf          = $("#fechaf").val();

            seriei           = $("#seriei").val();
            numero          = $("#numero").val();

            ruc_cliente     = $("#ruc_cliente").val();
            nombre_cliente  = $("#nombre_cliente").val();

            ruc_proveedor   = $("#ruc_proveedor").val();
            nombre_proveedor = $("#nombre_proveedor").val();

            producto        = $("#producto").val();

            
            $('#table-guiarem').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                    url : '<?=base_url();?>index.php/almacen/guiarem/datatable_guiarem/<?="$tipo_oper";?>',
                    type: "POST",
                    data: { fechai: fechai, 
                                fechaf: fechaf,
                                seriei: seriei,
                                numero: numero,
                                ruc_cliente: ruc_cliente,
                                nombre_cliente: nombre_cliente,
                                ruc_proveedor: ruc_proveedor,
                                nombre_proveedor: nombre_proveedor,
                                producto: producto },
                    beforeSend: function(){
                        $(".loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $(".loading-table").hide();

                    }
                },
                language: spanish,
                order: [[ 0, "desc" ]]
            });
        });

        $("#limpiarG").click(function(){

            $("#form_busqueda")[0].reset();
            $("#cliente").val("");
            $("#proveedor").val("");
            $("#producto").val("");
            
            fechai = "";
            fechaf = "";
            seriei = "";
            numero = "";
            cliente = "";
            ruc_cliente = "";
            nombre_cliente = "";
            proveedor = "";
            ruc_proveedor = "";
            nombre_proveedor = "";
            producto = "";

            $('#table-guiarem').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                    url : '<?=base_url();?>index.php/almacen/guiarem/datatable_guiarem/<?="$tipo_oper";?>',
                    type: "POST",
                    data: { fechai: fechai, 
                                fechaf: fechaf,
                                seriei: seriei,
                                numero: numero,
                                ruc_cliente: ruc_cliente,
                                nombre_cliente: nombre_cliente,
                                ruc_proveedor: ruc_proveedor,
                                nombre_proveedor: nombre_proveedor,
                                producto: producto },
                    beforeSend: function(){
                        $(".loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $(".loading-table").hide();

                    }
                },
                language: spanish,
                order: [[ 0, "desc" ]]
            });
        });
    });

    function comprobante_ver_pdf_conmenbrete_guia(cod, conv, img) {
        url = base_url+"index.php/almacen/guiarem/guiarem_ver_pdf_conmenbrete/"+cod;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
    }

    function abrirAnulacionModal( id, serie, numero){
        $(".modal-anulacion").modal("toggle");
        $("#idDocAnula").val(id);
        $("#anulaSerie").html(serie);
        $("#anulaNumero").html(numero);
       
        $("#motivo").val("");
    }

</script>