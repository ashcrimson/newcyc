<?php



namespace ContratosNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelContratos {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";


	private $proveedor_id;
	private $selectContrato;
	private $licitacion;
	private $moneda_id;
	private $precio;
	private $cargo_id;
	private $fecha_inicio;
	private $fecha_termino;
	private $fecha_aprobacion;
	private $alerta_vencimiento;
	private $objeto_contrato;
	private $numero;
	private $monto;
	private $fecha_vencimiento;
	private $alerta_boleta;




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

			if(isset($_POST["proveedor_id"]) && $_POST["proveedor_id"] != ""){
				$this->params .= "proveedor_id" . $_POST["proveedor_id"] . "&";
				$this->proveedor_id = $_POST["proveedor_id"];
			}else{
				$this->errores["proveedor_id"] = true;
				$this->eror = true;
			}
			if(isset($_POST["selectContrato"]) && $_POST["selectContrato"] != ""){
				$this->params .= "selectContrato" . $_POST["selectContrato"] . "&";
				$this->selectContrato = $_POST["selectContrato"];
			}else{
				$this->errores["selectContrato"] = true;
				$this->eror = true;
			}
			if(isset($_POST["licitacion"]) && $_POST["licitacion"] != ""){
				$this->params .= "licitacion" . $_POST["licitacion"] . "&";
				$this->licitacion = $_POST["licitacion"];
			}else{
				$this->errores["licitacion"] = true;
				$this->eror = true;
			}
			if(isset($_POST["moneda_id"]) && $_POST["moneda_id"] != ""){
				$this->params .= "moneda_id" . $_POST["moneda_id"] . "&";
				$this->moneda_id = $_POST["moneda_id"];
			}else{
				$this->errores["moneda_id"] = true;
				$this->eror = true;
			}
			if(isset($_POST["precio"]) && $_POST["precio"] != ""){
				$this->params .= "precio" . $_POST["precio"] . "&";
				$this->precio = $_POST["precio"];
			}else{
				$this->errores["precio"] = true;
				$this->eror = true;
			}
			if(isset($_POST["cargo_id"]) && $_POST["cargo_id"] != ""){
				$this->params .= "cargo_id" . $_POST["cargo_id"] . "&";
				$this->cargo_id = $_POST["cargo_id"];
			}else{
				$this->errores["cargo_id"] = true;
				$this->eror = true;
			}
			if(isset($_POST["fecha_inicio"]) && $_POST["fecha_inicio"] != ""){
				$this->params .= "fecha_inicio" . $_POST["fecha_inicio"] . "&";
				$this->fecha_inicio = $_POST["fecha_inicio"];
			}else{
				$this->errores["fecha_inicio"] = true;
				$this->eror = true;
			}
			if(isset($_POST["fecha_termino"]) && $_POST["fecha_termino"] != ""){
				$this->params .= "fecha_termino" . $_POST["fecha_termino"] . "&";
				$this->fecha_termino = $_POST["fecha_termino"];
			}else{
				$this->errores["fecha_termino"] = true;
				$this->eror = true;
			}
			if(isset($_POST["fecha_aprobacion"]) && $_POST["fecha_aprobacion"] != ""){
				$this->params .= "fecha_aprobacion" . $_POST["fecha_aprobacion"] . "&";
				$this->fecha_aprobacion = $_POST["fecha_aprobacion"];
			}else{
				$this->errores["fecha_aprobacion"] = true;
				$this->eror = true;
			}
			if(isset($_POST["alerta_vencimiento"]) && $_POST["alerta_vencimiento"] != ""){
				$this->params .= "alerta_vencimiento" . $_POST["alerta_vencimiento"] . "&";
				$this->alerta_vencimiento = $_POST["alerta_vencimiento"];
			}else{
				$this->errores["alerta_vencimiento"] = true;
				$this->eror = true;
			}
			if(isset($_POST["objeto_contrato"]) && $_POST["objeto_contrato"] != ""){
				$this->params .= "objeto_contrato" . $_POST["objeto_contrato"] . "&";
				$this->objeto_contrato = $_POST["objeto_contrato"];
			}else{
				$this->errores["objeto_contrato"] = true;
				$this->eror = true;
			}
			if(isset($_POST["numero"]) && $_POST["numero"] != ""){
				$this->params .= "numero" . $_POST["numero"] . "&";
				$this->numero = $_POST["numero"];
			}else{
				$this->errores["numero"] = true;
				$this->eror = true;
			}
			if(isset($_POST["monto"]) && $_POST["monto"] != ""){
				$this->params .= "monto" . $_POST["monto"] . "&";
				$this->monto = $_POST["monto"];
			}else{
				$this->errores["monto"] = true;
				$this->eror = true;
			}
			if(isset($_POST["fecha_vencimiento"]) && $_POST["fecha_vencimiento"] != ""){
				$this->params .= "fecha_vencimiento" . $_POST["fecha_vencimiento"] . "&";
				$this->fecha_vencimiento = $_POST["fecha_vencimiento"];
			}else{
				$this->errores["fecha_vencimiento"] = true;
				$this->eror = true;
			}
			if(isset($_POST["alerta_boleta"]) && $_POST["alerta_boleta"] != ""){
				$this->params .= "alerta_boleta" . $_POST["alerta_boleta"] . "&";
				$this->alerta_boleta = $_POST["alerta_boleta"];
			}else{
				$this->errores["alerta_boleta"] = true;
				$this->eror = true;
			}

		}

		return new self($this->pdo);

	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){
			//consulta de inserción
			//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
			$consulta = "INSERT into LICITACIONES values (
/*cambiar tabla*/						'". $this->nro_licitacion ."',
						0,
						'". $this->descripcion_licitacion ."',
						".  $this->presupuesto .",
						TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), null, null)";

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
			header("Location: ". base() . "/contratos/new?" . $params);
			die();
		}

		

		//agrega resultados a retorno
		//array_push($assoc, $listado);
		//array_push($assoc, $errores);

		//$results["result"] = $result;

		oci_close($this->pdo);
		//return $assoc;
	}








	public function get(){
		
		$assoc = [];


		//consulta para recuperar ruts de los proveedores
		$query = "SELECT RUT FROM PROVEEDORES";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$proveedores = queryResultToAssoc($result);
		array_push($assoc, $proveedores);


		//consulta para recuperar numeros de licitaciones
		$query = "SELECT NRO_LICITACION FROM LICITACIONES";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$licitaciones = queryResultToAssoc($result);
		array_push($assoc, $licitaciones);


		//consulta para recuperar monedas
		$query = "SELECT NOMBRE FROM MONEDA";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$moneda = queryResultToAssoc($result);
		array_push($assoc, $moneda);


		//consulta para recuperar cargos
		$query = "SELECT * FROM CARGOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$cargos = queryResultToAssoc($result);
		array_push($assoc, $cargos);



		oci_close($this->pdo);
		return $assoc;


	}

}