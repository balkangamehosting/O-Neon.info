<?php
session_start();

include("konfiguracija.php");
include("includes.php");

samo_vlasnik($_SESSION['a_id']);

$naslov = "Pregled SMS zemalja";
$fajl = "smszemlje";


	include("assets/header.php");
	

		$smszemlje = mysql_query("SELECT * FROM `billing_smszemlje`");
?>
			<div class="widget stacked widget-table action-table">
					
				<div class="widget-header">
					<i class="icon-th-list"></i>
					<h3>Lista zemalja</h3>
				</div> <!-- /widget-header -->
				
				<div class="widget-content">
					
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="45px" class="tip" title="test">ID</th>
								<th>Poruka</th>
								<th>Broj</th>
								<th>Cijena</th>
								<th>Dostupno</th>
								<th>Zemlja</th>
								<th>Currency</th>
							</tr>
						</thead>
						<tbody>
					<?php	
							if(mysql_num_rows($smszemlje) == 0) {
								echo'<tr><td colspan="5"><m>Trenutno nema dodatih zemalja.</m></td></tr>';
							}
							while($row = mysql_fetch_array($smszemlje)) 
							{	
							?>
							<tr>
								<td>#<?php echo $row['id']; ?></td>
								<td><?php echo $row['poruka']; ?></td>
								<td><?php echo $row['broj']; ?></td>
								<td><?php echo $row['cijena']; ?></td>
								<td><?php echo $row['status']; ?></td>
								<td><?php echo $row['zemlja']; ?></td>
								<td><?php echo $row['currency']; ?></td>								
							</tr>	
					<?php	}

					?>
							</tbody>
						</table>						
								
				</div> <!-- /widget-content -->
			
			</div> <!-- /widget -->		
<?
include("assets/footer.php");
?>
