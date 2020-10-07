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


	private $nombre;
	private $mail;

	//Constructor
	function __construct($pdo, $mail = ''){
		$this->pdo = $pdo;
		$this->mail = $mail;
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
				$this->params .= "nombre=" . $_POST["nombre"] . "&";
				$this->nombre = $_POST["nombre"];
			}else{
				$this->errores["nombre"] = true;
				$this->error = true;
			}
		}

		return new self($this->pdo);

	}

	public function edit($id){
		return new self($this->pdo, $id);
	}

	public function get(){
		
		$query = "SELECT * FROM USUARIOS WHERE MAIL='" . $this->mail . "'";

		//consulta paginada
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);

		return $listado;
	}

	public function ryc(){

		$assoc = [];
		
		$query = "SELECT * FROM CARGOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$cargos = queryResultToAssoc($result);

		$query = "SELECT * FROM AREAS";
		//consulta paginada
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$areas = queryResultToAssoc($result);


		array_push($assoc, $areas);
		array_push($assoc, $cargos);

		return $assoc;
	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){

			if(isset($_POST["id"]) && $_POST["id"] != ""){
				$consulta = "UPDATE USUARIOS
							 SET NOMBRE = '". $_POST["nombre"] ."',
							 	 MAIL = '". $_POST["email"] ."',
							 	 CARGO = '". $_POST["cargo_id"] ."',
							 	 AREA = '". $_POST["rol"] ."',
							 	 FECHA_ACTUALIZACION = TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd')
							 WHERE MAIL='" . $_POST["email"] . "'";
				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				print_r($consulta);
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			}else{
				//consulta de inserción
				//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
/*				$consulta = "INSERT INTO USUARIOS (NOMBRE, MAIL) values (
							'". $this->nombre .",
							'". $this->mail ."')" ;
*/
				$consulta = "INSERT INTO USUARIOS (NOMBRE, MAIL, FECHA_CREACION, CARGO, AREA) values (
							'". $_POST["nombre"] .",
							'". $_POST["email"] ."',
							TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'),
							'". $_POST["cargo_id"] .",
							'". $_POST["rol"] .")";

				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				//print_r($consulta);
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			}
		}else{
			//print_r("redirige");
			header("Location: ". base() . "/usuarios/new?" . $params);
			die();
		}

		

		//agrega resultados a retorno
		//array_push($assoc, $listado);
		//array_push($assoc, $errores);

		//$results["result"] = $result;

		oci_close($this->pdo);
		//return $assoc;
	}
}