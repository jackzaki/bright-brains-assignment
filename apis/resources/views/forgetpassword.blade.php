<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title></title>
<style type="text/css">
	body{
		font-size: 12px;
		line-height: 21px;
		margin: 0;
		padding: 0;
		font-family:'Open Sans';
		font-style:normal;
		font-weight:400;
		src:local('Open Sans'), local('OpenSans'), url('http://fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3bO3LdcAZYWl9Si6vvxL-qU.woff') format('woff');
	}
	table{
		border-spacing: 0;
		border-collapse: 0;
		border-color: #ddd;
		font-size: 12px;
	}
</style>
</head>
<body>
	<table width="100%">
		<tr>
			<td align="center">
				<table width="100%" style="border:1px solid #ddd; max-width: 768px;">
					<tr>
						<td style="background-color: #f1f1f1; padding: 10px; font-size: 10px;">
							<table width="100%">
								<tr>
									<td align="left"><b>Email:</b>&nbsp;moneyexpressmx@gmail.com</td>
									<td align="right"><b>Phone Number:</b>&nbsp;+XX XXXXX XXXXX</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding: 10px;">
							<table width="100%">
								<tr>
									<td align="center"><img src="http://localhost/moneyexpress/apis/public/email-template/logo_black.png" alt="logo" width="150" /></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding: 15px;">
							<table width="100%">
								<tr>
									<td align="left">
										<h1 style="color: #666; ">Welcome! <span style="color: #0073B7"><?php //$name; ?></span></h1>
										<p>
											Thanks, for connecting with MoneyExpressMX. Please click on below button for forget password. 
											<?php print_r($code); ?>
										</p>
										<br>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding: 10px;" align="center">
							<table width="80%" style="background-color: #f5f5f5; border:1px solid #f1f1f1;">
								<tr>
									<td align="center" style="padding: 15px 10px;">
										<?php print_r($data); ?>
										<button></button>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding: 10px 10px 50px 10px;" align="center">
							<table width="100%" style="max-width: 500px;">
								<tr>
									<td width="40%" align="right" valign="center"><h3 style=" margin: 0">Download our app</h3></td>
									<td width="60%" align="center"><a href="#"><img src="http://localhost/moneyexpress/apis/public/email-template/app-store.png" alt="iphone App store" width="100" /></a>&nbsp;&nbsp;<a href="#"><img src="http://localhost/moneyexpress/apis/public/email-template/google-play.png" width="100" alt="android play store"></a></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
</body>
</html>