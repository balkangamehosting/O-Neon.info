<?php
session_start();

include("konfiguracija.php");
include("includes.php");

samo_vlasnik($_SESSION['a_id']);

$naslov = "Pregled vesti";
$fajl = "slajd";

$slajd = mysql_query("SELECT * FROM `vesti`");

include("assets/header.php");
?>
		<div class="widget stacked widget-table action-table">
					
			<div class="widget-header">
				<i class="icon-th-list"></i>
				<h3>Lista vesti - <a href="#dodaj-slajd" data-toggle="modal">Dodaj vest</a></h3>
			</div> <!-- /widget-header -->
				
			<div class="widget-content">
					
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Naslov</th>
							<th>Text</th>
							<th>Slika</th>
							<th class="td-actions"></th>
						</tr>
					</thead>
					<tbody>
<?php
					if(mysql_num_rows($slajd) == "0") echo '<tr><td colspan="4">Trenutno nema slajdova.</td></tr>';
					while($row = mysql_fetch_array($slajd))
					{
						$tekst = str_replace("<br />", "\n", $row['text']);
						
?>
						<tr>
							<td><?php echo $row['naslov']; ?></td>
							<td><?php echo $row['poruka']; ?></td>
							<td><img src="<?php echo $row['l_slika']; ?>" style="width: 350px; height: 130px;" /></td>
							<td class="td-actions">
								<button onclick="izbrisi_vest('<?php echo $row['id']; ?>')" type="submit" class="btn btn-small btn-warning">
									<i class="btn-icon-only icon-remove"></i>										
								</button>	
								<button href="#edit_vest" data-toggle="modal" onclick="edit_vest('<?php echo $row['id']; ?>', '<?php echo $row['naslov']; ?>', '<?php echo mysql_real_escape_string(htmlspecialchars($tekst)); ?>', '<?php echo $row['slika']; ?>')" class="btn btn-small btn-warning">
									<i class="btn-icon-only icon-edit"></i>										
								</button>	
							</td>
						</tr>
<?php
					}
?>
					</tbody>
				</table>						
								
			</div> <!-- /widget-content -->
			
		</div> <!-- /widget -->		
<?php
include("assets/footer.php");
?>
