<?php



namespace LicitacionesNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelLicitaciones {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";


	private $nro_licitacion;
	private $presupuesto;
	private $descripcion_licitacion;
	private $archivo_licitacion;
	private $nro_documento;
	private $archivo_nombre;
	private $fecha_creacion;
	private $pdf;

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
			if(isset($_POST["nro_licitacion"]) && $_POST["nro_licitacion"] != ""){
				$this->params .= "nro_licitacion=" . $_POST["nro_licitacion"] . "&";
				$this->nro_licitacion = $_POST["nro_licitacion"];
			}else{
				$this->errores["nro_licitacion"] = true;
				$this->error = true;
			}

			if(isset($_POST["presupuesto"]) && $_POST["presupuesto"] != ""){
				$this->params .= "presupuesto=" . $_POST["presupuesto"] . "&";
				$this->presupuesto = $_POST["presupuesto"];
			}else{
				$this->errores["presupuesto"] = true;
				$this->error = true;
			}


			if(isset($_POST["descripcion_licitacion"]) && $_POST["descripcion_licitacion"] != ""){
				$this->params .= "descripcion_licitacion=" . $_POST["descripcion_licitacion"] . "&";
				$this->descripcion_licitacion = $_POST["descripcion_licitacion"];
			}else{
				$this->errores["descripcion_licitacion"] = true;
				$this->error = true;
			}

			if(isset($_POST["archivo_licitacion"]) && $_POST["archivo_licitacion"] != ""){
				$params .= "archivo_licitacion=" . $_POST["archivo_licitacion"] . "&";
			}else{
				$errores["archivo_licitacion"] = true;
				$error = true;
			}
		}

		return new self($this->pdo);

	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){

			$numero = 0;
			if(isset($_FILES["archivo_licitacion"]) && $_FILES["archivo_licitacion"] != ""){
				
				$cons = "SELECT COUNT(*)+1 AS NRO_DOCUMENTO FROM DOCUMENTO";
				$result = oci_parse($this->pdo, $cons);
				oci_execute($result);
				$nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];
				print_r($nro_documento);

				$directorio = "uploads/";
				$archivo = $directorio . basename($_FILES["archivo_licitacion"]["name"]);
				$tipo = $_FILES["archivo_licitacion"]["type"];
				$peso = $_FILES["archivo_licitacion"]["size"];
				
				$pdf = file_get_contents($_FILES['archivo_licitacion']['tmp_name']);
				move_uploaded_file($_FILES["archivo_licitacion"]["tmp_name"], $archivo);

				//consulta de inserción
				//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
				$consulta = "INSERT into DOCUMENTO (NRO_DOCUMENTO, NOMBRE, ARCHIVO, PESO_ARCHIVO, TIPO_ARCHIVO, FECHA_CREACION) values (
							'". $nro_documento ."',
							'". $archivo ."',
							empty_blob(),
							'". $peso ."',
							'". $tipo ."',
							TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'))
							RETURNING pdf INTO :pdf";

				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				$blob = oci_new_descriptor($this->pdo, OCI_D_LOB);
				oci_bind_by_name($result, ":pdf", $blob, -1, OCI_B_BLOB);
				//print_r($consulta);
				oci_execute($result, OCI_DEFAULT) or die ("Unable to execute query");

				if(!$blob->save($pdf)) {
					oci_rollback($this->pdo);
				}
				else {
					oci_commit($this->pdo);
				}

				oci_free_statement($result);
				$blob->free();
			}


			
			$consulta = "INSERT into LICITACIONES values (
						'". $this->nro_licitacion ."',
						'". $this->descripcion_licitacion ."',
						".  $this->presupuesto .",
						TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'), null, null)";

			//ejecucion consulta
			$query = $consulta;
			$result = oci_parse($this->pdo, $query);
			//print_r($consulta);
			oci_execute($result);

			//oci_error();
			//$listado = queryResultToAssoc($result);
			oci_commit($this->pdo);
		}else{
			//print_r("redirige");
			header("Location: ". base() . "/licitaciones/new?" . $params);
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