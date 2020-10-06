<?php
require("init.php");
require("clases/Config.class.php");
require("clases/DB.class.php");
require("clases/lang.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$lang = new Language("es");
$config = $inscripcion->getConfig();
$db = \DB::getInstance();


?>
<link type="text/css" href="css/boostrap.css" rel="stylesheet">
<link type="text/css" href="consulta/estilos.css" rel="stylesheet">

<div class="row">
	<div class="col-xs-12">
    	<div class="table-responsive">
        	<table class="table">
            	<thead>
                	<tr>
                    	<th>Forma</th>
                        <th>Personas USD0</th>
                        <th>Personas USD100</th>
                        <th>Costo USD100</th>
                        <th>Personas USD140</th>
                        <th>Costo USD140</th>
                        <th>Personas USD200</th>
                        <th>Costo USD200</th>
                        <th>Personas USD-100</th>
                        <th>Costo USD-100</th>
                        <th>Personas USD-140</th>
                        <th>Costo USD-140</th>
                        <th>Personas USD-200</th>
                        <th>Costo USD-200</th>
                        <th>Total personas</th>
                        <th>Costo total</th>
                    </tr>
                </thead>
               				
                	<?php
                    	$sqlLunes = $db->query("SELECT COUNT(i.importe), i.forma_pago, (SELECT COUNT(d.importe) FROM inscriptos_recibo d WHERE d.forma_pago<>'' AND d.forma_pago=i.forma_pago AND d.importe='-200' AND d.fecha_creado LIKE '2017-12-04%' GROUP BY d.forma_pago) AS personasMenos200, (SELECT COUNT(c.importe) FROM inscriptos_recibo c WHERE c.forma_pago<>'' AND c.forma_pago=i.forma_pago AND c.importe='-140' AND c.fecha_creado LIKE '2017-12-04%' GROUP BY c.forma_pago) AS personasMenos140, (SELECT COUNT(b.importe) FROM inscriptos_recibo b WHERE b.forma_pago<>'' AND b.forma_pago=i.forma_pago AND b.importe='-100' AND b.fecha_creado LIKE '2017-12-04%' GROUP BY b.forma_pago) AS personasMenos100, (SELECT COUNT(a.importe) FROM inscriptos_recibo a WHERE a.forma_pago<>'' AND a.forma_pago=i.forma_pago AND a.importe='0' AND a.fecha_creado LIKE '2017-12-04%' GROUP BY a.forma_pago) AS personas0, (SELECT COUNT(p.importe) FROM inscriptos_recibo p WHERE p.forma_pago<>'' AND p.forma_pago=i.forma_pago AND p.importe='100' AND p.fecha_creado LIKE '2017-12-04%' GROUP BY p.forma_pago) AS personas100, (SELECT COUNT(t.importe) FROM inscriptos_recibo t WHERE t.forma_pago<>'' AND t.forma_pago=i.forma_pago AND t.importe='140' AND t.fecha_creado LIKE '2017-12-04%' GROUP BY t.forma_pago) AS personas140, (SELECT COUNT(u.importe) FROM inscriptos_recibo u WHERE u.forma_pago<>'' AND u.forma_pago=i.forma_pago AND u.importe='200' AND u.fecha_creado LIKE '2017-12-04%' GROUP BY u.forma_pago) AS personas200 FROM inscriptos_recibo i WHERE i.forma_pago<>'' AND i.fecha_creado LIKE '2017-12-04%' GROUP BY i.forma_pago;")->results();

						foreach($sqlLunes as $row) {
							$contadorPersonas0 += $row["personas0"];
							$contadorPersonas100 += $row["personas100"];
							$contadorPersonas140 += $row["personas140"];
							$contadorPersonas200 += $row["personas200"];
							$contadorPersonasMenos100 += $row["personasMenos100"];
							$contadorPersonasMenos140 += $row["personasMenos140"];
							$contadorPersonasMenos200 += $row["personasMenos200"];
                    ?>
                    <tr>
                    	<td><?php echo $lang->getValue($lang->set["FORMA_PAGO_RECIBO"]["array"][$row["forma_pago"]]) ?></td>
                        <td bgcolor="#FFFF99" align="center"><?=$row["personas0"]?></td>
                        <td bgcolor="#FFFF99" align="center"><?=$row["personas100"]?></td>
                        <?php $costo100 = $row["personas100"]*100; ?>
                        <td align="center"><?=$costo100?></td>
                        <td bgcolor="#FFFF99" align="center"><?=$row["personas140"]?></td>
                        <?php $costo140 = $row["personas140"]*140; ?>
                        <td align="center"><?=$costo140?></td>
                        <td bgcolor="#FFFF99" align="center"><?=$row["personas200"]?></td>
                        <?php $costo200 = $row["personas200"]*200; ?>
                        <td><?=$costo200?></td>
                        <td bgcolor="#FFFF99" align="center"><?=$row["personasMenos100"]?></td>
                        <?php $costoMenos100 = $row["personasMenos100"]*(-100); ?>
                        <td align="center"><?=$costoMenos100?></td>
                        <td bgcolor="#FFFF99" align="center"><?=$row["personasMenos140"]?></td>
                        <?php $costoMenos140 = $row["personasMenos140"]*(-140); ?>
                        <td align="center"><?=$costoMenos140?></td>
                        <td bgcolor="#FFFF99" align="center"><?=$row["personasMenos200"]?></td>
                        <?php $costoMenos200 = $row["personasMenos200"]*(-200); ?>
                        <td align="center"><?=$costoMenos200?></td>
                        <?php $total_personas = $row["personas0"]+$row["personas100"]+$row["personas140"]+$row["personas200"]+$row["personasMenos100"]+$row["personasMenos140"]+$row["personasMenos200"]; ?>
                        <td bgcolor="#FFFF99" align="center"><?=$total_personas?></td>
                        <?php $costo_total = $costo100 + $costo140 + $costo200 + $costoMenos100 + $costoMenos140 + $costoMenos200; ?>
                        <td><?=$costo_total?></td>
                    </tr>
                    <?php
						}
					?>
                    <tr>
                    	<td></td>
                    	<td align="center"><?=$contadorPersonas0?></td>
                        <td align="center"><?=$contadorPersonas100?></td>
                        <td></td>
                    	<td align="center"><?=$contadorPersonas140?></td>
                        <td></td>
                    	<td align="center"><?=$contadorPersonas200?></td>
                        <td></td>
                    	<td align="center"><?=$contadorPersonasMenos100?></td>
                        <td></td>
                    	<td align="center"><?=$contadorPersonasMenos140?></td>
                        <td></td>
                    	<td align="center"><?=$contadorPersonasMenos200?></td>
                    </tr>
			</table>
        </div>
	</div>
</div>