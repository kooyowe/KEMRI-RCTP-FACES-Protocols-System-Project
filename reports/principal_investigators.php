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
				include "../shared/pageheader.php"; 
			?>
			<div >
				<div class="page-body">
					<table width="100%" class="page-table">
						<tr>
							<td id="left" width="20%" valign="top" class="left-nav">
							<?php
								require_once("../admin/menu.php");
								//echo 'admina<br>menu';
							?>						
							</td>
							<td id="right" valign="top" align="left">
								<?php 
									require_once("rpt_principal_investigators.php");
								?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?php 
				#Page Footer
				include "../shared/footer.php";
			?>
		</div>
	</body>
</html>