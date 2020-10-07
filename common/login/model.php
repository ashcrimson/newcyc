<?php



namespace LoginCYC;


/**
 * modelo de plantilla y control de permisos
 */
class ModelLoginCYC {



	/**
	 *
	 */
	//Obj de conexion de db
	private $pdo;
	//usuario
	private $user;
	//permisos
	private $permisos;

	//Constructor
	function __construct($pdo, string $user = ''){
		$this->pdo = $pdo;
		$this->user = $user;
	}


	//obtiene permisos del usuario
	public function getId($user): self{
		return new self($this->pdo, $user);
	}

	//retorna el/los datos seleccionados
	public function get(){


		if(!empty($_POST)){
			$mail = $_POST["email"];
			$usuario = (strstr($mail, '@', true) . "\n");
			$dominio = (str_replace("@", "", strstr($usuario, '@')) . "\n");
			$clave = $_POST["password"];

			if($dominio){

				$client = new \SoapClient("http://172.25.16.18/bus/webservice/ws.php?wsdl");

				$params = array(
					"id" => $usuario,
					"clave" => $clave
				);

				$response = $client->__soapCall("autentifica_ldap", $params);

				print_r($response);

				if($response->resp==1){
					session_destroy();
					session_start();
					$_SESSION["mail"] = $mail;
					$_SESSION["nombre"] = $response->nombre;
					header("Location: ". base() . "/home");
				}

			}
		}

// 		$where = "";	
// 		if ($this->permisos){
// //saca: falta cambiar clausula
// 			$where = " WHERE nro_licitacion = " . $this->nro_licitacion;
// 		}else{
// 			$where = "";
// 		}
	


// //saca: quzas haya que hacer join
// 		$query = "select * from USERS " . $where;
// 		$result = oci_parse($this->pdo, $query);

// 		//oci_execute($result);
// 		$assoc = [];
// /*desco
// 		while ($paso = oci_fetch_assoc($result)) {
// 			array_push($assoc, $paso);
// 		}
// */		
		return "";
	}
}