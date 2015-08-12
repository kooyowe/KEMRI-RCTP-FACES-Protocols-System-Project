<?php
date_default_timezone_set('Africa/Nairobi');
$currentDate = new DateTime();
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<body>
  <div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
    <table width="100%" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
		<tr>
			<td rowspan="4">
				<h2>Protocols Management System</h2>
			</td>
		</tr>
		<tr>
			<td align="right">
				<b>KEMRI-RCTP</b>
			</td>
		</tr>
		<tr>
			<td align="right">
				<b>Nairobi</b>
			</td>
		</tr>
		<tr>
			<td align="right">
				<b><u>'.date_format($currentDate,"jS F Y h:m:n A").'</u></b>
			</td>
		</tr>		
	</table>
	<table width="100%" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; border-bottom:1px solid green">
		<tr >
			<td>
			<p>
			Dear Dr. Gitare,
			</p>
			
			<p>
			<b><u>RE: KEMRI-RCTP PROTOCOL STUDY REMINDER</u></b>
			</p>
			
			<p>
			On behalf of KEMRI-RCTP, we are sending you this email as a reminder to renew your Protocol [SSC No 1234 – Study Protocol Description] in time. As you might be well aware, the current transaction for this protocol will expire on [expiry_date]. We hope you have been more than satisfied with our service so far.
			</p>
			
			<p>
			We are sincerely looking forward to receiving your renewal.
			</p>
			
			<p>
			Regards,<br>
			… Team
			</p>
			<br>
			<br>
			</td>
		</tr>
	</table>
	<span style="color:blue">You are getting this message as free service for being a user of the KEMRI-RCTP Protocols Management System(ProMS) to which you are a registered Principal Investigator.</span>
  </div>
</body>
</html>

';
?>