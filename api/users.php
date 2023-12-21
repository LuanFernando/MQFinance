<?php

include('../connection.php');

if($_POST['action'] == 'auth'){
	if($_POST['username'] != null && $_POST['username'] != '' && $_POST['password'] != null && $_POST['password'] != ''){	
		$response = array('success' => null,'warning' => null,'error' => null,'user' => null);
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$query = "SELECT id, name, user_token, password, deleted_at, status, path_photo FROM users WHERE user_name = ? AND status = 1";
		$stmt  = $conn->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result->num_rows > 0){
		
			$row = $result->fetch_assoc();
			
			if(password_verify($password,$row['password']) && empty($row['deleted_at'])){
				http_response_code(200); //success
				$response['success'] = 'Usuário autenticado com sucesso.';
				$response['user']    = $row;
			} else {
				http_response_code(401); //Não autorizado
				$response['warning'] = 'Usuário não autorizado!';
			}
			
		} else {
			http_response_code(404); // Not found
			$response['warning'] = 'Nenhum usuário encontrado.';
		}
		
		$json = json_encode($response);
		echo $json;
		return;
	} else {
		$response = array('success' => null,'warning' => null,'error' => null,'extra' => null);
		
		http_response_code(401);
		$response['warning'] = 'Verifique as credenciais fornecidas';
		
		$json = json_encode($response);
		echo $json;
		return;
	}
} else if($_POST['action'] == 'newUser'){
	
	$response    = array('success' => null,'warning' => null,'error' => null, 'extra' => null);
	
	$name       = $_POST['name'];
	$user_name  = $_POST['user_name'];
	$password   = $_POST['password'];
	
	if(empty($name) || empty($user_name) || empty($password)){
		http_response_code(400); // bad request
		$response['warning'] = 'Não foi possível criar o usuário, campos obrigatórios não informados!';
		$json = json_encode($response);
		echo $json;
		return;
	} else {
		$user_token = uniqid(); // gera um token unico
		$status     = 1; // 0 false - 1 true 
		$path_photo = null;
		$created_at = date('Y-m-d H:i:s'); // data e hora atual
		$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Gera um hash seguro da senha
		
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
					
					$path_photo = $newNameFile; // seta nome do  arquivo para salvar na tabela
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
			if($path_photo == null){
				$stmt = $conn->prepare("INSERT INTO users(name ,user_name ,password ,user_token ,status ,created_at ) VALUES(?,?,?,?,?,?)");
				$stmt->bind_param("ssssis", $name , $user_name, $hashed_password, $user_token,$status, $created_at);
			} else {
				$stmt = $conn->prepare("INSERT INTO users(name ,user_name ,password ,user_token ,status ,created_at ,path_photo ) VALUES(?,?,?,?,?,?,?)");
				$stmt->bind_param("ssssiss", $name , $user_name, $hashed_password, $user_token,$status, $created_at, $path_photo);
			}
			
			//Executa o insert
			if($stmt->execute()){
				http_response_code(200);//success
				$response['success'] = 'Usuário cadastrado com sucesso.';
				
				$json =  json_encode($response);
				echo $json;
				return;
			} else {
				http_response_code(400); // bad request
				$response['error'] = 'Não foi possível cadastrar o usuário.';
				
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

