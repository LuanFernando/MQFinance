<?php

include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if(isset($_POST['action']) && $_POST['action'] == 'newCashFlow'){
		$created_at  = date('Y-m-d H:i:s');
		$identifier  = $_POST['identifier'];
		$description = $_POST['description'];
		$type        = $_POST['type'];
		$value       = $_POST['value'];
		$id_user     = $_POST['id_user'];
		$photo_note  = null;
		
		//NOTE: Tratamento de valores monetarios antes de salvar no banco de dados.
		$value = str_replace(',', '.', $value);
		
		if($identifier == '' || $identifier == null || 
		   $description == '' || $description == null || 
		   $type == '' || $type == null || 
		   $value == '' || $value == null || $id_user == '' || $id_user <= 0){
			http_response_code(400); // bad request
			$response['warning'] = 'Não foi possível criar um novo (Cash Flow), campos obrigatórios não informados!';
			$json = json_encode($response);
			echo $json;
			return;
		} else {
			
			if(isset($_FILES['image'])){
				if($_FILES['image']['error'] === UPLOAD_ERR_OK){
					// Upload da imagem caso a mesma exista
					if(isset($_FILES['image'])){
						$ext =  strtolower(substr($_FILES['image']['name'],-4));// extensão do arquivo
						$nameFile = uniqid(); // gera um token para nameFile
						$newNameFile = $nameFile."_".date("Y.m.d-H.i.s").$ext;
						
						$dir = '../uploads/'; // Diretorio para uploads
						
						if(!is_dir($dir)){
							if(!mkdir($dir, 0777, true)){
								error_log('falha diretorio '. $dir);
							}
						}
						
						move_uploaded_file($_FILES['image']['tmp_name'], $dir.$newNameFile); // faz o upload
						
						$photo_note = $newNameFile; // seta nome do  arquivo para salvar na tabela
					}
				} else {
					$response['error'] = 'Erro no upload: '.$_FILES['image']['error'];
					http_response_code(400);// error
					$json = json_encode($response);
					echo $json;
					return;
				}	
			}			
					
			try {
				// Verifica upload de foto
				if($photo_note == null){
					$stmt = $conn->prepare("INSERT INTO cash_flow(identifier,description,type,value,created_at,id_user) VALUES(?,?,?,?,?,?)");
					$stmt->bind_param("ssidsi",$identifier,$description,$type,$value,$created_at,$id_user);
				} else {
					$stmt = $conn->prepare("INSERT INTO cash_flow(identifier,description,type,value,created_at,photo_note,id_user) VALUES(?,?,?,?,?,?,?)");
					$stmt->bind_param("ssidssi",$identifier,$description,$type,$value,$created_at,$photo_note,$id_user);
				}
				
				//Executa o insert
				if($stmt->execute()){
					http_response_code(200);//success
					$response['success'] = 'Cash Flow cadastrado com sucesso.';
					
					$json =  json_encode($response);
					echo $json;
					return;
				} else {
					http_response_code(400); // bad request
					$response['error'] = 'Não foi possível cadastrar um novo Cash Flow.';
					
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
    
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $response = array('success' => null, 'warning' => null, 'error' => null, 'data' => null);

    if (isset($_GET['action']) && $_GET['action'] == 'all' && $_GET['idUser'] > 0) {

		$id_user = $_GET['idUser'];
		
        try {
            $stmt = $conn->prepare("SELECT * FROM cash_flow WHERE deleted_at IS NULL AND id_user = ? ");
			$stmt->bind_param("i",$id_user);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $datas = array();

                while ($row = $result->fetch_assoc()) {
                    $datas[] = $row;
                }

                if (count($datas) > 0) {
                    $response['success'] = 'successful cash flow return.';
                    $response['data'] = $datas;
                    http_response_code(200); // success
                    $json = json_encode($response);
                    echo $json;
                    return;
                }
            } else {
                http_response_code(404);
                $response['warning'] = 'cash flow not found.';
                $json = json_encode($response);
                echo $json;
                return;
            }

        } catch (\Exception $e) {
            http_response_code(400);
            $response['error'] = $e->getMessage();
            $json = json_encode($response);
            echo $json;
            return;
        }
    } else if (isset($_GET['action']) && $_GET['action'] == 'unique') {
        $id = $_GET['id'];
		
		try {
			$stmt = $conn->prepare("SELECT * FROM cash_flow WHERE id = ? AND deleted_at IS NULL");
			$stmt->bind_param("i", $id);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$response['success'] = 'successful cash flow return.';
					$response['data'] = $row;
				}
				
				http_response_code(200);//success
				$json = json_encode($response);
				echo $json;
				return;
			} else {
				http_response_code(404);
				$response['warning'] = 'cash flow not found.';
				$json = json_encode($response);
				echo $json;
				return;
			}
						
		} catch (\Exception $e){
			http_response_code(400);
			$response['error'] = $e->getMessage();
			$json = json_encode($response);
			echo $json;
			return;
		}
    } else if (isset($_GET['action']) && $_GET['action'] == 'category' && $_GET['idUser'] > 0) {
        $category = $_GET['category']; // [0] saida [1] entrada
		$id_user  = $_GET['idUser'];
		
		try {
			$stmt = $conn->prepare("SELECT * FROM cash_flow WHERE type = ? AND deleted_at IS NULL AND id_user = ? ");
			$stmt->bind_param("ii", $category, $id_user);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			if($result->num_rows > 0){
				$datas = array();
				
				while($row = $result->fetch_assoc()){
					$datas[] = $row;
				}
				
				if(count($datas) > 0){
					$response['success'] = 'successful cash flow return.';
					$response['data'] = $datas;
					http_response_code(200);//success
					$json = json_encode($response);
					echo $json;
					return;
				}

			} else {
				http_response_code(404);
				$response['warning'] = 'cash flow not found.';
				$json = json_encode($response);
				echo $json;
				return;
			}
						
		} catch (\Exception $e){
			http_response_code(400);
			$response['error'] = $e->getMessage();
			$json = json_encode($response);
			echo $json;
			return;
		}
		
    } else {
        http_response_code(404); // not found
        $response['error'] = 'action not found.';
        $json = json_encode($response);
        echo $json;
        return;
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
	if(isset($_GET['id']) && $_GET['id'] > 0){
		$id         = $_GET['id'];
		$deleted_at = date('Y-m-d H:i:s');
		
		$stmt = $conn->prepare("UPDATE cash_flow SET deleted_at = ? WHERE id = ? ");
		$stmt->bind_param("si", $deleted_at, $id);
		
		if($stmt->execute()){
				http_response_code(200);
				$response['success'] = 'Cash Flow de n°: '.$id.', deletado com sucesso.';
				$json = json_encode($response);
				echo $json;
				return;
		} else {
			http_response_code(400); // error
			$response['error'] = 'Não foi possível deletar o Cash Flow de n°: '.$id.'.';
			$json = json_encode($response);
			echo $json;
			return;
		}
		
	} else {
		http_response_code(400);
		$response['error'] = 'Erro ao tentar deletar cash flow, motivo ID não encontrado.';
		$json = json_encode($response);
		echo $json;
		return;
	}
	
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  
  $put     =  json_decode(file_get_contents("php://input"), true);
		
	// Verifica se o JSON foi recebido com sucesso
	if($put === false || $put == null){
		http_response_code(400);//Método erro
		$response['error'] =  'Nenhuma informação recebida para ser atualizada.';
		$json = json_encode($response); 
		echo $json;
		return;
	}
		
  if(isset($put['action']) && $put['action'] == 'updateCashFlow'){
	$identifier = $put['identifier'];
	$description= $put['description'];
	$value      = $put['value'];
	$type       = $put['type'];
	$photo_note = null;
	$id         = $put['id'];
	$updated_at = date('Y-m-d H:i:s');
	
	//NOTE: Tratamento de valores monetarios antes de salvar no banco de dados.
	$value = str_replace(',', '.', $value);
	
	if($id <= 0 || $id == '' || $identifier == '' || $identifier == null || $description == '' || 
	$description == null || $value == '' || $value == null || $value <= 0){
		http_response_code(400); // bad request
		$response['warning'] = 'Não foi possível atualizar o (Cash Flow), campos obrigatórios não informados!';
		$json = json_encode($response);
		echo $json;
		return;
	} else {
		if(isset($_FILES['image'])){
			if($_FILES['image']['error'] === UPLOAD_ERR_OK){
				// Upload da imagem caso a mesma exista
				if(isset($_FILES['image'])){
					$ext =  strtolower(substr($_FILES['image']['name'],-4));// extensão do arquivo
					$nameFile = uniqid(); // gera um token para nameFile
					$newNameFile = $nameFile."_".date("Y.m.d-H.i.s").$ext;
					
					$dir = '../uploads/'; // Diretorio para uploads
					
					if(!is_dir($dir)){
						if(!mkdir($dir, 0777, true)){
							error_log('falha diretorio '. $dir);
						}
					}
					
					move_uploaded_file($_FILES['image']['tmp_name'], $dir.$newNameFile); // faz o upload
					
					$photo_note = $newNameFile; // seta nome do  arquivo para salvar na tabela
				}
			} else {
				$response['error'] = 'Erro no upload: '.$_FILES['image']['error'];
				http_response_code(400);// error
				$json = json_encode($response);
				echo $json;
				return;
			}	
		}			
				
		try {
			// Verifica upload de foto
			if($photo_note == null){
				$stmt = $conn->prepare("UPDATE cash_flow SET identifier = ?,description = ?,type = ?,value = ?,updated_at = ? WHERE id = ?");
				$stmt->bind_param("ssidsi",$identifier,$description,$type,$value,$updated_at, $id);
			} else {
				$stmt = $conn->prepare("UPDATE cash_flow SET identifier = ?,description = ?,type = ?,value = ?,updated_at = ?,photo_note = ? WHERE id = ?");
				$stmt->bind_param("ssidssi",$identifier,$description,$type,$value,$updated_at,$photo_note, $id);
			}
			
			//Executa
			if($stmt->execute()){
				http_response_code(200);//success
				$response['success'] = 'Cash Flow atualizado com sucesso.';
				
				$json =  json_encode($response);
				echo $json;
				return;
			} else {
				http_response_code(400); // bad request
				$response['error'] = 'Não foi possível atualizar o Cash Flow.';
				
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
  
} else {
    http_response_code(405); // Método não permitido
    $response = ['warning' => 'Método não permitido'];
    $json = json_encode($response);
    echo $json;
    return;
}
