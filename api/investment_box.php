<?php 

include('../connection.php');

try {
	/**
	* color_box = [blue,red,green,yellow,white,orange]
	*/
	if($_SERVER['REQUEST_METHOD'] === 'GET') {
		
		$response = array('success' => null, 'warning' => null, 'error' => null, 'data' => null);
		
		if(isset($_GET['action']) && $_GET['action'] == 'all'){
			$stmt = $conn->prepare("SELECT * FROM investment_box WHERE deleted_at IS NULL");
			$stmt->execute();
			
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$datas = array();

				while ($row = $result->fetch_assoc()) {
					$datas[] = $row;
				}

				if (count($datas) > 0) {
					$response['success'] = 'successful investment box return.';
					$response['data'] = $datas;
					http_response_code(200); // success
					$json = json_encode($response);
					echo $json;
					return;
				}
			} else {
				http_response_code(404);
				$response['warning'] = 'investment box not found.';
				$json = json_encode($response);
				echo $json;
				return;
			}
		} else if(isset($_GET['action']) && $_GET['action'] == 'unique'){
			$id = $_GET['id'];
			$stmt = $conn->prepare("SELECT * FROM investment_box WHERE deleted_at IS NULL AND id = ? ");
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$datas = array();

				while ($row = $result->fetch_assoc()) {
					$datas[] = $row;
				}

				if (count($datas) > 0) {
					$response['success'] = 'successful investment box return.';
					$response['data'] = $datas;
					http_response_code(200); // success
					$json = json_encode($response);
					echo $json;
					return;
				}
			} else {
				http_response_code(404);
				$response['warning'] = 'investment box not found.';
				$json = json_encode($response);
				echo $json;
				return;
			}
		}
		
	} else if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$response = array('success' => null, 'warning' => null, 'error' => null, 'data' => null);
		
		if(isset($_POST['action']) && $_POST['action'] == 'newInvestmentBox'){
			$identifier = $_POST['identifier'];
			$color_box  = (empty($_POST['color_box']) || $_POST['color_box'] == '' || $_POST['color_box'] == null ? 'white' : $_POST['color_box'] );
			$created_at = date('Y-m-d H:i:s');
			$id_user    = $_POST['id_user'];
			
			if($identifier == '' || $identifier == null){
				http_response_code(400); // bad request
				$response['warning'] = 'Não foi possível criar um novo (Investment Box), campos obrigatórios não informados!';
				$json = json_encode($response);
				echo $json;
				return;
			} else {
				$stmt =  $conn->prepare("INSERT INTO investment_box (identifier,color_box,created_at,id_user) VALUES(?,?,?,?)");
				$stmt->bind_param('sssi',$identifier,$color_box,$created_at,$id_user);	

				try {
					//Executa o insert
					if($stmt->execute()){
						http_response_code(200);//success
						$response['success'] = 'Investment Box cadastrado com sucesso.';
						
						$json =  json_encode($response);
						echo $json;
						return;
					} else {
						http_response_code(400); // bad request
						$response['error'] = 'Não foi possível cadastrar um novo Investment Box.';
						
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
		}
		
	} else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
		$response = array('success' => null, 'warning' => null, 'error' => null, 'data' => null);
		
		 $put     =  json_decode(file_get_contents("php://input"), true);
		
		// Verifica se o JSON foi recebido com sucesso
		if($put === false || $put == null){
			http_response_code(400);//Método erro
			$response['error'] =  'Nenhuma informação recebida para ser atualizada.';
			$json = json_encode($response); 
			echo $json;
			return;
		}
	
		if(isset($put['action']) && $put['action'] == 'updateInvestmentBox'){
			$id         = $put['id'];
			$identifier = $put['identifier'];
			$color_box  = (empty($put['color_box']) || $put['color_box'] == '' || $put['color_box'] == null ? 'white' : $put['color_box'] );
			$updated_at = date('Y-m-d H:i:s');
			
			if($identifier == '' || $identifier == null || $id <= 0){
				http_response_code(400); // bad request
				$response['warning'] = 'Não foi possível atualizar (Investment Box), campos obrigatórios não informados!';
				$json = json_encode($response);
				echo $json;
				return;
			} else {
				$stmt =  $conn->prepare("UPDATE investment_box SET identifier = ?,color_box = ?,updated_at = ? WHERE id = ? ");
				$stmt->bind_param('sssi',$identifier,$color_box,$updated_at,$id);

				try {
					if($stmt->execute()){
						http_response_code(200);//success
						$response['success'] = 'Investment Box atualizado com sucesso.';
						
						$json =  json_encode($response);
						echo $json;
						return;
					} else {
						http_response_code(400); // bad request
						$response['error'] = 'Não foi possível atualizado Investment Box.';
						
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
		}
		
	} else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
			$response = array('success' => null, 'warning' => null, 'error' => null, 'data' => null);
		
			if(isset($_GET['id']) && $_GET['id'] > 0){
			$id         = $_GET['id'];
			$deleted_at = date('Y-m-d H:i:s');
			
			$stmt = $conn->prepare("UPDATE investment_box SET deleted_at = ? WHERE id = ? ");
			$stmt->bind_param("si", $deleted_at, $id);
			
			if($stmt->execute()){
					http_response_code(200);
					$response['success'] = 'Investment Box de n°: '.$id.', deletado com sucesso.';
					$json = json_encode($response);
					echo $json;
					return;
			} else {
				http_response_code(400); // error
				$response['error'] = 'Não foi possível deletar o Investment Box de n°: '.$id.'.';
				$json = json_encode($response);
				echo $json;
				return;
			}
			
		} else {
			http_response_code(400);
			$response['error'] = 'Erro ao tentar deletar Investment Box, motivo ID não encontrado.';
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
