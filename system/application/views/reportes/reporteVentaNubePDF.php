<!doctype html>
<html lang="ES">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>REPORTE CONSOLIDADO DE VENTAS</title>
    <?php 
      $logoMain = getConvertPDFToBase64('images/img_db/comprobante_orden_recepcion.jpg');
      $numberDocumento = ($cliente->tipo == 1) ? $cliente->ruc : $cliente->dni;
      $fecha = formatDate($row->OCOMC_Fecha);
      $fechaHoy = date('d/m/Y');
    ?>
    <style>
      html{
        font-family: 'helvetica' !important;
        margin: 20px 25px;
      }
      body{
        font-size: 7pt;
        font-family: 'helvetica' !important;
      }
      .center{
        text-align: center;
      }
      .width100 {
        width: 100%;
      }
      .bold, label{
        font-weight: 500;
        font-family: 'helvetica' !important;
        
      }
      .bold{

        background-color: #e1e1e1;
      }
      .right
      {
        text-align: right;
      }
      table{
        width: 100%;
        font-family: 'helvetica' !important;
      }
      table tr td{
        font-family: 'helvetica' !important;
        padding: 3px 5px;
      }
      p{
        margin: 5px;
      }
      #tbTableMain thead tr td, #tbTableMain tfoot tr td{
        padding: 7px;
        font-family: 'helvetica' !important;
      }
      #tbTableMain tbody tr td{
        padding: 5px;
      }
      .page_break{ page-break-before: always; }

      .grid
      {
        display: grid;
      }
    </style>
  <link rel="stylesheet" href="<?php base_url()?>css/grid12.css">
  </head>
  <body>
    <table border="0" cellspacing="0" cellspacing="0">
      <tr>
        <td class="bold center"><h3 style="margin: 0;">REPORTE DE DE VENTAS DEL DIA</h3></td>
      </tr>
    </table>

    <table border="0" cellspacing="0" cellspacing="0" style="margin-bottom: 5px;">
      <tr>
        <td style="width: 100%;" colspan="2">
            <label>EMPRESA: </label> <?php echo isset($datos_empresa[0]->EMPRC_RazonSocial) ? $datos_empresa[0]->EMPRC_RazonSocial : '' ?>
        </td>
      </tr>
      <tr>
        <td style="width: 100%;" colspan="2">
          <label>RUC: </label> <?php echo isset($datos_empresa[0]->EMPRC_Ruc) ? $datos_empresa[0]->EMPRC_Ruc : '' ?>
        </td>
      </tr>
      <tr>
        <td style="width: 100%;" colspan="2">
          <label>ESTABLECIMIENTO: </label> 
          <?php echo isset($establecimiento[0]->EESTABC_Descripcion) ? $establecimiento[0]->EESTABC_Descripcion: '-' ?>
        </td>
      </tr>
      <tr>
        <td style="width: 100%;">
          <label>FECHA: </label> <?php echo mysql_to_human($fecha1).' - '.mysql_to_human($fecha2)?>
        </td>
      </tr>
    </table>

    <table border="1" cellspacing="0" cellspacing="0" id="tbTableMain"> 
      <thead>
        <tr>
            <td class="bold center" colspan="7">COMPROBANTES</td>
        </tr>
        <tr style="background-color: #e1e1e1;">
          <td style="width: 7%;" class="center">
            <label>TIPO</label>   
          </td>
          <td style="width: 7%;" class="center">
            <label>SERIE</label>   
          </td>
          <td style="width: 8%;" class="center">
            <label>NUM DOC</label>
          </td>
          <td style="width: 18%;" class="center">
            <label>DENOMINACIÓN</label>   
          </td>
          <td style="width: 7%;" class="center">
            <label>MONEDA</label>   
          </td>
          <td style="width: 8%;" class="center">
            <label>TOTAL</label>   
          </td>
          <td style="width: 12%;" class="center">
            <label>FORMA PAGO</label>   
          </td>
        </tr>
      </thead>
      <tbody style="font-size:7pt !important">
        <?php 
        $cantidadDoc    = 0;
        $totalCPPSol    = 0;
        $totalCPPDol    = 0;
        $notaCreditoS   = 0;
        $notaCreditoD   = 0;
        $anuladoS       = 0;
        $anuladoD       = 0;
        foreach ($data as $key => $row) {
            $cantidadDoc++;
            $estado = $row->CPC_FlagEstado;
            $tachado1 = "";
            $tachado2 = "";
            if ($estado == "0") {
                $tachado1 = "<strike>";
                $tachado2 = "</strike>";
            }

            switch ($row->CPC_TipoDocumento) {
                case 'F':
                    $typeName = 'FACTURA';
                    break;
                case 'B':
                    $typeName ='BOLETA';
                    break;
                case 'C':
                    $typeName ='NOTA CREDITO';
                    break;
                case 'D':
                    $typeName ='NOTA DEBITO';
                    break;
                default:
                    $typeName ='COMPROBANTE';
                    break;
            }
          ?>
          <tr class="center">
            <td style="border-bottom: none;border-top: none;"><?php echo $tachado1.$typeName.$tachado2; ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo $tachado1.$row->CPC_Serie.'-'.$row->CPC_Numero.$tachado2; ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo $tachado1.$row->numero_documento_cliente.$tachado2; ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo $tachado1.$row->razon_social_cliente.$tachado2; ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo $tachado1.'('.$row->MONED_Simbolo.') '.$row->MONED_Descripcion.$tachado2; ?></td>
            <td style="border-bottom: none;border-top: none;">
                <?php echo $tachado1;
                    
                    if ($row->CPC_TipoDocumento=="C") {
                      echo -$row->CPC_total;
                      $totalCPPSol  -= ($row->MONED_Codigo == 1 && $estado=="1") ? $row->CPC_total : 0;
                      $totalCPPDol  -= ($row->MONED_Codigo == 2 && $estado=="1") ? $row->CPC_total : 0;
                      //$anuladoS     += ($row->MONED_Codigo == 1 && $estado=="0") ? $row->CPC_total : 0;
                      //$anuladoD     += ($row->MONED_Codigo == 2 && $estado=="0") ? $row->CPC_total : 0;
                      $notaCreditoS += ($row->MONED_Codigo == 1 && $estado=="1") ? $row->CPC_total : 0;
                      $notaCreditoD += ($row->MONED_Codigo == 2 && $estado=="1") ? $row->CPC_total : 0;
                    }else{
                      echo $row->CPC_total;
                      $totalCPPSol  += ($row->MONED_Codigo == 1 && $estado=="1") ? $row->CPC_total : 0;
                      $totalCPPDol  += ($row->MONED_Codigo == 2 && $estado=="1") ? $row->CPC_total : 0;
                      $anuladoS     += ($row->MONED_Codigo == 1 && $estado=="0") ? $row->CPC_total : 0;
                      $anuladoD     += ($row->MONED_Codigo == 2 && $estado=="0") ? $row->CPC_total : 0;

                    }
                    echo $tachado2;
                ?>
            </td>
            <td style="border-bottom: none;border-top: none;"><?php echo $tachado1.$row->FORPAC_Descripcion.$tachado2; ?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="bold">
            <td colspan="5">TOTAL DOCUMENTOS: <?php echo $cantidadDoc; ?></td>
            <td colspan="2">
                <label>TOTAL (S/.): </label> <?php echo $totalCPPSol ?>
            </td>
        </tr>
        <tr class="bold">
            <td colspan="5"></td>
            <td colspan="2"> 
                <label>TOTAL (US$): </label> <?php echo $totalCPPDol ?>
            </td>
        </tr>
      </tfoot>
    </table>

    <?php
        $formas=[];

        foreach ($data as $key1 => $cpp) 
        {
            $rowFP = $db->Comprobante_formapago_model->getList($cpp->CODCPC, 0 , true);
            foreach ($rowFP as $key2 => $rowOneFP) 
            {
                $indice = array_search($rowOneFP->FORPAP_Codigo, array_column($formas, 'Codigo'));
                $montoS = ($rowOneFP->MONED_Codigo == 1) ? $rowOneFP->monto : 0;
                $montoD = ($rowOneFP->MONED_Codigo == 2) ? $rowOneFP->monto : 0;

                if ($indice > -2){
                    $formas[$indice]["MontoS"] += $montoS;
                    $formas[$indice]["MontoD"] += $montoD;
                } else
                {
                    $datas=["Codigo"=>$rowOneFP->FORPAP_Codigo,"Nombre"=>$rowOneFP->FORPAC_Descripcion,"MontoS"=> $montoS, "MontoD" =>$montoD];
                    array_push($formas, $datas);
                }
            }            
        }
    ?>

    <br><br>
    <table border="1" cellspacing="0" cellspacing="0" style="width: 50%;">
        <tr>
            <th colspan="3" class="bold">TOTALES</th>
        </tr>
        <tr class="bold">
            <th>MEDIO DE PAGO</th>
            <th>SOLES</th>
            <th>DOLARES</th>
        </tr>

        <?php 
        $totalSoles = 0; $totalDolares = 0;
        foreach ($formas as $key => $form) { ?>
            <tr>
                <td>
                    <?php echo $form['Nombre']; ?>
                </td>
                <td class="center">
                    <?php 
                        echo number_format($form['MontoS'], 2);
                        $totalSoles += $form['MontoS'];
                    ?>
                </td>
                <td class="center">
                    <?php 
                        echo number_format($form['MontoD'], 2);
                        $totalDolares += $form['MontoD'];
                    ?>
                </td>
            </tr>
        <?php } ?>
        <tr class="bold">
            <th style="text-align:left;">TOTAL GLOBAL</th>
            <th>
                <?php echo number_format($totalSoles, 2) ?>
            </th>
            <th>
                <?php echo number_format($totalDolares, 2) ?>
            </th>
        </tr>
        <tr class="bold">
            <th style="text-align:left;">TOTAL ANULADO</th>
            <th>
                <?php echo number_format($anuladoS, 2) ?>
            </th>
            <th>
                <?php echo number_format($anuladoD, 2) ?>
            </th>
        </tr>
        <tr class="bold">
            <th style="text-align:left;">TOTALES NC</th>
            <th>
                <?php echo number_format(-$notaCreditoS, 2) ?>
            </th>
            <th>
                <?php echo number_format(-$notaCreditoD, 2) ?>
            </th>
        </tr>
        <tr class="bold">
            <th style="text-align:left;">TOTALES VENTA</th>
            <th>
                <?php echo number_format($totalSoles-$notaCreditoS-$anuladoS, 2) ?>
            </th>
            <th>
                <?php echo number_format($totalDolares-$notaCreditoD-$anuladoD, 2) ?>
            </th>
        </tr>
    </table>
  </body>        
</html>