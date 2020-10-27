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
				$consulta = "INSERT into PROVEEDORES (RUT_PROVEEDOR, RAZON_SOCIAL, FECHA_CREACION) values (
							'". $rut."', 
							'". $nombre ."',
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