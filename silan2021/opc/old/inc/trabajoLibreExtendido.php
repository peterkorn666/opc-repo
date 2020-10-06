<?php
 $sqlA = "SELECT * FROM areas_trabjos_libres WHERE id='$row->area_tl'";
 $queryA = mysql_query($sqlA,$con) or die(mysql_error());
 $rowA = mysql_fetch_array($queryA);
?>

<div class="row" style="margin-top:20px;">
	<div class="col-xs-10 col-md-offset-2">
        <table width="95%" style="width:93%;margin-bottom:0px;" class="table table-striped table_tl">
          <tr>
            <td><?=$row->Hora_inicio." ".$row->tipo_tl." ".$rowA["Area"]?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">
            	<div class="row">
                    <div class="col-xs-10"><?=$row->titulo_tl?></div>
                    <div class="col-xs-2 text-right"><?=$row->numero_tl?></div>	
                </div>		
                <div class="row">
                	<div class="col-xs-10">
                    	<?=$gestionAutores?>
                    </div>
                    <div class="col-xs-2 text-right"><a href="#" data-rel="<?=$row->ID?>" class="ver_resumen">ver resumen</a></div>
                </div>
                <div class="row resumen_tl<?=$row->ID?>">
                	<div class="col-xs-12">
                    	<div class="resumen_container">
                            <div class="div_resumen">
                                <strong>Objetivo</strong><br />
                                    <?=$row->resumen?>
                            </div>  
                            
                            <div class="div_resumen">
                                <strong>Desarrollo</strong><br />
                                    <?=$row->resumen2?>
                            </div>
                            
                            <div class="div_resumen">
                                <strong> Conclusiones</strong><br />
                                    <?=$row->resumen3?>
                            </div>
                            
                            <div class="div_resumen">    
                                <strong>Bibliograf&iacute;a</strong><br />
                                    <?=$row->resumen4?>
                            </div>
                         </div>
                    </div>
                </div>
            </td>
          </tr>
        </table>
     </div>
</div>