<?php



namespace CargosNew;


/**
 * modelo de lista de  licitaciones
 */
class Modelcargos {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";


	private $id;
	private $nombre;

	//Constructor
	function __construct($pdo, $id = ''){
		$this->pdo = $pdo;
		$this->id = $id;
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
				$this->nombre = acentos($_POST["nombre"]);
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
		
		$query = "SELECT * FROM CARGOS WHERE ID_CARGO='" . $this->id . "'";

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
				$consulta = "UPDATE CARGOS
							 SET NOMBRE = '". $_POST["nombre"] ."'
							 WHERE ID_CARGO='" . $_POST["id"] . "'";
				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				//print_r($consulta);
				if($result){

                    $_SESSION["feedback"] = "Contrato actualizado correctamente";
                    flash("Cargo actualizado correctamente")->success() ;
                }
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			}else{
				$cons = "SELECT COUNT(*)+5 AS CTA FROM CARGOS";
				$result = oci_parse($this->pdo, $cons);
				if($result){

                    $_SESSION["feedback"] = "Contrato actualizado correctamente";
                    flash("Cargo ingresado correctamente")->success() ;
                }
				oci_execute($result);
				$numero = queryResultToAssoc($result)[0]["CTA"];
				

				/*$consulta = "INSERT into cargos (ID, NOMBRE) values (
							".$numero.",'". $this->nombre ."')";*/
				$consulta = "INSERT into cargos (ID_CARGO, NOMBRE) values (
							".$numero.", '". acentos($_POST["nombre"]) ."')";
				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				//print_r($consulta);
				if($result){

                    $_SESSION["feedback"] = "Contrato actualizado correctamente";
                    flash("Cargo ingresado correctamente")->success() ;
                }
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			}

			

		}else{
			//print_r("redirige");
			header("Location: ". base() . "/cargos/new?" . $params);
			die();
		}

		

		//agrega resultados a retorno
		//array_push($assoc, $listado);
		//array_push($assoc, $errores);

		//$results["result"] = $result;

		oci_close($this->pdo);
		header("Location:". base() ."/cargos");
		//return $assoc;
	}
}