<?php



namespace ProveedoresNew;
   

/**
 * modelo de lista de  licitaciones
 */
class ModelProveedores {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";
	private $rut;


	private $id;
	private $nombre;

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
			if(isset($_POST["rut"]) && $_POST["rut"] != ""){
				$this->params .= "rut=" . $_POST["rut"] . "&";
				$this->rut = $_POST["rut"];
			}else{
				$this->errores["rut"] = true;
				$this->error = true;
			}

			if(isset($_POST["nombre"]) && $_POST["nombre"] != ""){
				$this->params .= "nombre=" . $_POST["nombre"] . "&";
				$this->nombre = $_POST["nombre"];
			}else{
				$this->errores["nombre"] = true;
				$this->error = true;
			}

			if(isset($_POST["nombre_fantasia"]) && $_POST["nombre_fantasia"] != ""){
				$this->params .= "nombre_fantasia=" . $_POST["nombre_fantasia"] . "&";
				$this->nombre_fantasia = $_POST["nombre_fantasia"];
			}else{
				$this->errores["nombre_fantasia"] = true;
				$this->error = true;
			}

			if(isset($_POST["telefono"]) && $_POST["telefono"] != ""){
				$this->params .= "telefono=" . $_POST["telefono"] . "&";
				$this->telefono = $_POST["telefono"];
			}else{
				$this->errores["telefono"] = true;
				$this->error = true;
			}

			if(isset($_POST["email"]) && $_POST["email"] != ""){
				$this->params .= "email=" . $_POST["email"] . "&";
				$this->email = $_POST["email"];
			}else{
				$this->errores["email"] = true;
				$this->error = true;
			}

			if(isset($_POST["direccion"]) && $_POST["direccion"] != ""){
				$this->params .= "direccion=" . $_POST["direccion"] . "&";
				$this->direccion = $_POST["direccion"];
			}else{
				$this->errores["direccion"] = true;
				$this->error = true;
			}

			if(isset($_POST["comuna"]) && $_POST["comuna"] != ""){
				$this->params .= "comuna=" . $_POST["comuna"] . "&";
				$this->comuna = $_POST["comuna"];
			}else{
				$this->errores["comuna"] = true;
				$this->error = true;
			}
		}

		return new self($this->pdo);

	}

	public function edit($rut){
		return new self($this->pdo, $rut);
	}



	public function execute(){
		
		//validar si faltó algo
		if(!$this->error)
		{

				$rut = $_POST["rut"];	
				$nombre = $_POST["nombre"];
				$nombre_fantasia = $_POST["nombre_fantasia"];
				$telefono = $_POST["telefono"];
				$email = $_POST["email"];
				$direccion = $_POST["direccion"];
				$consulta = "INSERT into PROVEEDORES (RUT_PROVEEDOR, RAZON_SOCIAL, NOMBRE_FANTASIA, TELEFONO, EMAIL, DIRECCION, FECHA_CREACION) values (
							'". $rut."', 
							'". $nombre ."',
							'". $nombre_fantasia ."',
							'". $telefono ."',
							'". $email ."',
							'". $direccion ."',
							TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd')
							)";
				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				//print_r($consulta);
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			

			print_r($consulta);

		}else{
			//print_r("redirige");
			header("Location: ". base() . "/proveedores/new?" . $params);
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