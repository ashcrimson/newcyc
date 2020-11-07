<?php



namespace UsuariosNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelUsuarios {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";
	private $feedback = "";

	private $nombre;
	private $mail;




	//Constructor
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	//retorna el/los datos seleccionados
	public function new(){

		$result = [];
		$assoc = [];
		$listado = [];


		//validacion de datos recividos
		$params = "";
		if(isset($_POST["submit"])){

			if(isset($_POST["nombre"]) && $_POST["nombre"] != ""){
				$this->params .= "nombre" . $_POST["nombre"] . "&";
				$this->nombre = $_POST["nombre"];
			}else{
				// $this->errores["id_contrato"] = true;
				// $this->error = true;
			}

			if(isset($_POST["email"]) && $_POST["email"] != ""){
				$this->params .= "email" . $_POST["email"] . "&";
				$this->email = $_POST["email"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}

			if(isset($_POST["rol"]) && $_POST["rol"] != ""){
				$this->params .= "rol" . $_POST["rol"] . "&";
				$this->rol = $_POST["rol"];
			}else{
				$this->errores["rol"] = true;
				// $this->error = true;
			}


			if(isset($_POST["cargo_id"]) && $_POST["cargo_id"] != ""){
				$this->params .= "cargo_id" . $_POST["cargo_id"] . "&";
				$this->cargo_id = $_POST["cargo_id"];
			}else{
				$this->errores["cargo_id"] = true;
				$this->error = true;
			}
			

		}

		return new self($this->pdo);

	}



	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){
			

			$consulta = "INSERT INTO USUARIOS (
				MAIL, 
				NOMBRE, 
				PASSWORD,
				ID_CARGO,
				ID_PERMISO,
				FECHA_CREACION,
				FECHA_ACTUALIZACION
				) 
			VALUES (
				'". $_POST["email"] ."',
				'". $_POST["nombre"] ."', 
				'12345',
				'". $_POST["cargo_id"] ."',
				'". $_POST["rol"] ."',
				TO_DATE('2020-11-05 00:00:00', 'YYYY-MM-DD HH24:MI:SS'),
				TO_DATE('2020-11-05 00:00:00', 'YYYY-MM-DD HH24:MI:SS')
				)";



			//ejecucion consulta
			$query = $consulta;

			print($consulta);
			$result = oci_parse($this->pdo, $query);

			// oci_bind_by_name($result, "mylastid", $last_id, 8, SQLT_INT);
			
			oci_execute($result);

			// var_dump($last_id);
			// exit();

			oci_commit($this->pdo);

			$consulta2 = "INSERT INTO USUARIOS_PERMISOS (
				MAIL_USUARIO, 
				ID_PERMISO)
			VALUES(
				'". $_POST["email"] ."',
				'". $_POST["rol"] ."'
				)";

			$query2 = $consulta2;
			$result2 = oci_parse($this->pdo, $query2);
			oci_execute($result2, OCI_DEFAULT) or die ("No se pudo");
			
		}else{
			
			print_r($this->errores);
			
			die();
		}

	
		

		//agrega resultados a retorno

		oci_close($this->pdo);
		
		//return $assoc;
	}

	public function edit($id){
		return new self($this->pdo, $id);
	}



	public function get(){
		
		$assoc = [];


		//consulta para recuperar cargos
		$query = "SELECT * FROM CARGOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$cargos = queryResultToAssoc($result);
		array_push($assoc, $cargos);


		//consulta para recuperar permisos
		$query = "SELECT * FROM PERMISOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$permisos = queryResultToAssoc($result);
		array_push($assoc, $permisos);



		oci_close($this->pdo);
		return $assoc;


	}

}