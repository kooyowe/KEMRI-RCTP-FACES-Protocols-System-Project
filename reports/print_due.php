<?php
	require_once("../shared/global_vars.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<?php 
		include "../shared/head.php"; 
	?>	
	<body >
		<div id="container">
			<?php
				//include "../shared/pageheader.php"; 
			?>
			<div >
				<div class="page-body">
					<table width="100%" class="page-table">
						<tr>
							<td align="left" width="33%"><img src="../images/kemris.jpeg" width="80px"></td>
							<td align="center">
								<strong>
									KEMRI-RCTP FACES<br>
									Protocols Management System<br>
									Due Protocols<br>
									<?php 
									$days=$_GET['days'];
									echo '
									<span style="font-size:12px">
										Due in ';
										if($days==30){
											echo '1 month';
										}elseif($days==44){
											echo '6 weeks';
										}elseif($days=="60"){
											echo '2 months';
										}
										$currentDate = new DateTime();
										echo '
										as of '.date_format($currentDate,"jS F Y").'
									</span>';
									?>
								</strong>
							</td>
							<td align="right" width="33%"><img src="../images/rctp_faces.jpeg" width="80px"></td>
						</tr>
					</table>
					<table width="100%" class="page-table">
						<tr>
							<td id="right" valign="top" align="left">
								<?php 
									$report->DueProtocols($days);
								?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			window.print();
		</script>
	</body>
</html>