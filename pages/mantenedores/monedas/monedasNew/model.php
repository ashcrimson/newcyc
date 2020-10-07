<?php



namespace MonedasNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelMonedas {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";

	private $codigo;
	private $nombre;
	private $factor_conversion;


	//Constructor
	function __construct($pdo, $codigo = ''){
		$this->pdo = $pdo;
		$this->codigo = $codigo;
	}

	//retorna el/los datos seleccionados
	public function new(){

		$result = [];
		$assoc = [];
		$listado = [];


		//validacion de datos recividos
		$params = "";
		if(isset($_POST["submit"])){
			if(isset($_POST["codigo"]) && $_POST["codigo"] != ""){
				$this->params .= "codigo=" . $_POST["codigo"] . "&";
				$this->codigo = $_POST["codigo"];
			}else{
				$this->errores["codigo"] = true;
				$this->error = true;
			}

			if(isset($_POST["nombre"]) && $_POST["nombre"] != ""){
				$this->params .= "nombre=" . $_POST["nombre"] . "&";
				$this->nombre = $_POST["nombre"];
			}else{
				$this->errores["nombre"] = true;
				$this->error = true;
			}
			if(isset($_POST["factor_conversion"]) && $_POST["factor_conversion"] != ""){
				$this->params .= "factor_conversion=" . $_POST["factor_conversion"] . "&";
				$this->factor_conversion = $_POST["factor_conversion"];
			}else{
				$this->errores["factor_conversion"] = true;
				$this->error = true;
			}
		}

		return new self($this->pdo);

	}

	public function edit($codigo){
		return new self($this->pdo, $codigo);
	}

	public function get(){
		
		$query = "SELECT * FROM MONEDA WHERE CODIGO='" . $this->codigo . "'";
		//consulta paginada
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);

		return $listado;
	}


	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){
			//consulta de inserción
			//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";



			if(isset($_POST["id"]) && $_POST["id"] != ""){
				$query = "UPDATE MONEDA
							 SET CODIGO = '". $_POST["codigo"] ."',
							 NOMBRE = '". $_POST["nombre"] ."',
							 EQUIVALENCIA = ". $_POST["factor_conversion"] ."
							  WHERE CODIGO='" . $_POST["id"] . "'";
				//ejecucion consulta
				$result = oci_parse($this->pdo, $query);
				print_r($query);
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			}else{/*
				$query = "INSERT INTO MONEDA VALUES (
							'". $this->codigo ."',
							'". $this->nombre ."',
							".  $this->factor_conversion .",
							0
						)";
				*/
				$query = "INSERT INTO MONEDA VALUES(
						  '". $_POST["codigo"] ."',
							 '". $_POST["nombre"] ."',
							 ". $_POST["factor_conversion"] .",
							 0
						  )";
print_r($query);
				//ejecucion consulta
				$result = oci_parse($this->pdo, $query);
				//print_r($consulta);
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);


			}
		}else{
			//print_r("redirige");
			header("Location: ". base() . "/moneda/new?" . $params);
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