<?php

$baseUrl = 'http://localhost';
?>
<html>
	<head>
		<title>API MQ FINANCE</title>
		   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		   
	</head>
	<body style="
    display: flex;
    flex-direction: column;
    align-content: center;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    font-weight: 700;
	padding: 8px;
">
		<h2>Welcome to MQ Finance!</h2>
		<h4>Control of incoming and outgoing cash flow of individuals.</h4>
		
		<!-- <div style="display: flex;gap: 12px;padding: 24px;">
			<div style="padding:50%;background-color:#008080;border-radius:5px;"><label>M</label></div>
			<div style="padding:50%;background-color:#A020F0;border-radius:5px;"><label>Q</label></div>
		</div> -->
		
		<label>Endpoints</label>
		
		<table class='table'>
			<thead>
			<tr>
				<th>Action</th>
				<th>Url</th>
				<th>Type</th>
			</tr>
			</thead>
			<tbody>
				<tr>
					<td>New User MQFinance</td>
					<td>http://<?php echo $baseUrl; ?>/api/users.php</td>
					<td><label style='color:orange;'>POST</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in body</label> </p>
						<table class='table' style='background-color:#45484e; color: #fff;'>
						<tbody style='background-color:#45484e; color: #fff;'>
						<tr style='background-color:#45484e; color: #fff;'>
						<td style='background-color:#45484e; color: #fff;'>action</td>
						<td style='background-color:#45484e; color: #fff;'>newUser</td>
						</tr>
						<td style='background-color:#45484e; color: #fff;'>name</td>
						<td style='background-color:#45484e; color: #fff;'>Fulano Teste</td>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>password</td>
						<td style='background-color:#45484e; color: #fff;'>1234456789</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>user_name</td>
						<td style='background-color:#45484e; color: #fff;'>fulano.teste</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>image</td>
						<td style='background-color:#45484e; color: #fff;'>photo.PNG</td>
						</tr>
						</tbody>
						</table>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Auth User MQFinance</td>
					<td>http://<?php echo $baseUrl; ?>/api/users.php</td>
					<td><label style='color:orange;'>POST</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in body</label> </p>
						<table class='table' style='background-color:#45484e; color: #fff;'>
						<tbody style='background-color:#45484e; color: #fff;'>
						<tr style='background-color:#45484e; color: #fff;'>
						<td style='background-color:#45484e; color: #fff;'>action</td>
						<td style='background-color:#45484e; color: #fff;'>auth</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>username</td>
						<td style='background-color:#45484e; color: #fff;'>fulano.teste</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>password</td>
						<td style='background-color:#45484e; color: #fff;'>123456789</td>
						</tr>
						</tbody>
						</table>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>All Cash Flow</td>
					<td>http://<?php echo $baseUrl; ?>/api/cash_flow.php?action=all&idUser=1</td>
					<td>GET</td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in body</label> </p>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Unique Cash Flow</td>
					<td>http://<?php echo $baseUrl; ?>/api/cash_flow.php?action=unique&id=1</td>
					<td>GET</td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in body</label> </p>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Category Cash Flow</td>
					<td>http://<?php echo $baseUrl; ?>/api/cash_flow.php?action=category&category=0&idUser=1</td>
					<td>GET</td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in body</label> </p>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Delete Cash Flow</td>
					<td>http://<?php echo $baseUrl; ?>/api/cash_flow.php?id=1</td>
					<td><label style='color:red;'>DELETE</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request  -- <label style='color:orange;'>Must be sent in body</label> </p>
					</div>
					</td>
				</tr>
				
				
				<tr>
					<td>New Cash Flow</td>
					<td>http://<?php echo $baseUrl; ?>/api/cash_flow.php</td>
					<td><label style='color:orange;'>POST</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in body</label> </p>
						<table class='table' style='background-color:#45484e; color: #fff;'>
						<tbody style='background-color:#45484e; color: #fff;'>
						<tr style='background-color:#45484e; color: #fff;'>
						<td style='background-color:#45484e; color: #fff;'>action</td>
						<td style='background-color:#45484e; color: #fff;'>newCashFlow</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>identifier</td>
						<td style='background-color:#45484e; color: #fff;'>New Computer Game</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>description</td>
						<td style='background-color:#45484e; color: #fff;'>Apple 10</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>type</td>
						<td style='background-color:#45484e; color: #fff;'>0</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>value</td>
						<td style='background-color:#45484e; color: #fff;'>10000.00</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>image</td>
						<td style='background-color:#45484e; color: #fff;'>note.PNG</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>id_user</td>
						<td style='background-color:#45484e; color: #fff;'>1</td>
						</tr>
						</tbody>
						</table>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Update Cash Flow</td>
					<td>http://<?php echo $baseUrl; ?>/api/cash_flow.php</td>
					<td><label style='color:orange;'>PUT</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in json</label> </p>
						<label>{
							"action" :  "updateCashFlow",
							"identifier" : "Compra de dezembro 2023",
							"description" :  "O valor foi pago no cartão",
							"value" :   77.6,
							"id" :  6,
							"type" : 0
							}
						</label>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>All Investment Box</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_box.php?action=all</td>
					<td><label style='color:orange;'>GET</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request</p>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Unique Investment Box</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_box.php?action=unique&id=1</td>
					<td><label style='color:orange;'>GET</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request</p>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>New Investment Box</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_box.php</td>
					<td><label style='color:orange;'>POST</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request</p>
						<table class='table' style='background-color:#45484e; color: #fff;'>
						<tbody style='background-color:#45484e; color: #fff;'>
						<tr style='background-color:#45484e; color: #fff;'>
						<td style='background-color:#45484e; color: #fff;'>action</td>
						<td style='background-color:#45484e; color: #fff;'>newInvestmentBox</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>identifier</td>
						<td style='background-color:#45484e; color: #fff;'>Travel</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>color_box</td>
						<td style='background-color:#45484e; color: #fff;'>blue</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>id_user</td>
						<td style='background-color:#45484e; color: #fff;'>1</td>
						</tr>
						</tbody>
						</table>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Delete Investment Box</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_box.php?id=6</td>
					<td><label style='color:red;'>DELETE</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request</p>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>Update Investment Box</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_box.php</td>
					<td><label style='color:orange;'>PUT</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request -- <label style='color:orange;'>Must be sent in json</label> </p>
						<label>{
								"action" :  "updateInvestmentBox",
								"identifier" : "Teste 1",
								"color_box" :  "red",
								"id" :  1
								}
						</label>
					</div>
					</td>
				</tr>
				
				<tr>
					<td>All Investment Entry</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_entry.php?action=all&idUser=1&idBox=9</td>
					<td><label style='color:orange;'>GET</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request</p>
					</div>
					</td>
				</tr>
				
				
				<tr>
					<td>Delete Investment Entry</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_entry.php?id=1</td>
					<td><label style='color:red;'>DELETE</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request</p>
					</div>
					</td>
				</tr>
				
				
				<tr>
					<td>New Investment Entry</td>
					<td>http://<?php echo $baseUrl; ?>/api/investment_entry.php</td>
					<td><label style='color:orange;'>POST</label></td>
				</tr>
				
				<tr>
					<td colspan='3'>
					<div style='background-color:#45484e; color: #fff;padding:8px;'>
						<p>example request</p>
						<table class='table' style='background-color:#45484e; color: #fff;'>
						<tbody style='background-color:#45484e; color: #fff;'>
						<tr style='background-color:#45484e; color: #fff;'>
						<td style='background-color:#45484e; color: #fff;'>action</td>
						<td style='background-color:#45484e; color: #fff;'>newInvestmentEntry</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>id_investment_box</td>
						<td style='background-color:#45484e; color: #fff;'>9</td>
						</tr>
						<tr>
						<td style='background-color:#45484e; color: #fff;'>id_investment_entry</td>
						<td style='background-color:#45484e; color: #fff;'>2</td>
						</tr>
						</tbody>
						</table>
					</div>
					</td>
				</tr>
				
				
			</tbody>
		</table>
		
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

	</body>
</html>