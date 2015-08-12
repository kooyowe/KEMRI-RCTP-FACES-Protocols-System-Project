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
									Active Protocols
								</strong>
							</td>
							<td align="right" width="33%"><img src="../images/rctp_faces.jpeg" width="80px"></td>
						</tr>
					</table>
					<table width="100%" class="page-table">
						<tr>
							<td id="right" valign="top" align="left">
								<?php 
									$report->ActiveProtocols();
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