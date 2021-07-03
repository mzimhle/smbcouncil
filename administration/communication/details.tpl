<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Comm Sent</title>
</head>
<body>
	<a href="/administration/communication/"><h3>Go Back</h3></a>
	{$commData._comm_name} - {$commData._comm_email|default:"N/A"} - {$commData._comm_cellphone|default:"N/A"}<br />
	Output: {$commData._comm_output}<br /><br />
	{if $commData._comm_html eq ''}
	Message: {$commData._comm_message}
	{else}
	Mailer Sent: <br /><br />
	<table>
		<tr><td align="center" width="200px">
			{$commData._comm_html}
		</td></tr>
	</table>
	{/if}
</body>
</html>
