<?php 

include('../connection.php');

// NOTE: id_investment_entry = id da cash flow de saida

try {
	
	if($_SERVER['REQUEST_METHOD'] === 'GET') {
		$response = array('success' => null, 'error' => null, 'warning' => null, 'data' => null);
		
		if(isset($_GET['action']) && $_GET['action'] == 'all' && $_GET['idUser'] != '' && $_GET['idBox'] != ''){
			$id_user = $_GET['idUser'];
			$id_box  = $_GET['idBox'];
			
			try {
				$stmt = $conn->prepare("SELECT ie.created_at,cf.value,cf.identifier,cf.id,ie.id_investment_box,ie.id_investment_entry 
										FROM investment_entry ie
										INNER JOIN cash_flow cf ON cf.id = ie.id_investment_entry
										WHERE ie.id_investment_box = ? AND cf.id_user = ? AND ie.deleted_at IS NULL;");
				$stmt->bind_param("ii",$id_box,$id_user);
				
				$stmt->execute();

				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					$datas = array();

					while ($row = $result->fetch_assoc()) {
						$datas[] = $row;
					}

					if (count($datas) > 0) {
						$response['success'] = 'successful investment entry return.';
						$response['data'] = $datas;
						http_response_code(200); // success
						$json = json_encode($response);
						echo $json;
						return;
					}
				} else {
					http_response_code(404);
					$response['warning'] = 'investment entry not found.';
					$json = json_encode($response);
					echo $json;
					return;
				}
			} catch(\Exception $e) {
				http_response_code(500); // Internal server error
				$response['error'] = $e->getMessage();
					
				$json  = json_encode($response);
				echo $json;
				return;	
			}
			
		} else {
			http_response_code(400); //error
			$response['error'] = 'Não foi possível carregar as informações do usuário.';
			$json  = json_encode($response);
			echo $json;
			return;
		}
		
	} else if($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		if(isset($_POST['action']) && $_POST['action'] == 'newInvestmentEntry'){
			
			$id_investment_box   = $_POST['id_investment_box'];
			$id_investment_entry = $_POST['id_investment_entry'];
			$created_at          = date('Y-m-d H:i:s');
			
			if($id_investment_box <= 0 || $id_investment_entry <= 0 || $id_investment_box == '' || $id_investment_entry == '') {
				http_response_code(400); // bad request
				$response['warning'] = 'Não foi possível criar um novo (Investment Entry), campos obrigatórios não informados!';
				$json = json_encode($response);
				echo $json;
				return;
			} else {
				
				$stmt = $conn->prepare("INSERT INTO investment_entry (id_investment_box,id_investment_entry,created_at) VALUES(?,?,?);");
				$stmt->bind_param("iis",$id_investment_box,$id_investment_entry,$created_at);
				
				try {
					//Executa o insert
					if($stmt->execute()){
						http_response_code(200);//success
						$response['success'] = 'Investment Entry cadastrado com sucesso.';
						
						$json =  json_encode($response);
						echo $json;
						return;
					} else {
						http_response_code(400); // bad request
						$response['error'] = 'Não foi possível cadastrar um novo Investment Entry.';
						
						$json  = json_encode($response);
						echo $json;
						return;
					}
				} catch(\Exception $e) {
					http_response_code(500); // Internal server error
					$response['error'] = $e->getMessage();
						
					$json  = json_encode($response);
					echo $json;
					return;	
				} 
				
			}
			
		} else {
			http_response_code(400); //error
			$response['error'] = 'Não foi possível criar um novo investment entry , algo deu errado.';
			$json  = json_encode($response);
			echo $json;
			return;
		}
	
	} else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		
		$response = array('success' => null, 'warning' => null, 'error' => null, 'data' => null);
		
			if(isset($_GET['id']) && $_GET['id'] > 0){
			$id         = $_GET['id'];
			$deleted_at = date('Y-m-d H:i:s');
			
			$stmt = $conn->prepare("UPDATE investment_entry SET deleted_at = ? WHERE id = ? ");
			$stmt->bind_param("si", $deleted_at, $id);
			
			if($stmt->execute()){
					http_response_code(200);
					$response['success'] = 'Investment entry de n°: '.$id.', deletado com sucesso.';
					$json = json_encode($response);
					echo $json;
					return;
			} else {
				http_response_code(400); // error
				$response['error'] = 'Não foi possível deletar o Investment entry de n°: '.$id.'.';
				$json = json_encode($response);
				echo $json;
				return;
			}
			
		} else {
			http_response_code(400);
			$response['error'] = 'Erro ao tentar deletar Investment entry, motivo ID não encontrado.';
			$json = json_encode($response);
			echo $json;
			return;
		}
		
	} else {
		http_response_code(405); // Método não permitido
		$response = ['warning' => 'Método não permitido'];
		$json = json_encode($response);
		echo $json;
		return;
	}
	
} catch(\Exception $e) {
	http_response_code(500);
	$response['error'] = 'Internal Server Error. '.$e->getMessage();
	$json = json_encode($response);
	echo $json;
	return;
}



