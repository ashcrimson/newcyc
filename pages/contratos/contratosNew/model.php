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


	private $id_contrato;
	private $nro_licitacion;
	private $rut_proveedor;
	private $id_area;
	private $id_admin;
	private $id_moneda;
	private $tipo;
	private $monto;
	private $estado_alerta;
	private $fecha_inicio;
	private $fecha_termino;
	private $fecha_aprobacion;
	private $fecha_alerta_vencimiento;
	private $fecha_creacion;
	private $fecha_actualizacion;
	private $fecha_eliminacion;
	private $objeto_contrato;


	//Constructor
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	//retorna el/los datos seleccionados
	public function new(){

		$result = [];
		$assoc = [];
		$listado = [];


		//validacion de datos recibidos
		$params = "";
		if(isset($_POST["submit"])){
			if(isset($_POST["id_contrato"]) && $_POST["id_contrato"] != ""){
				$this->params .= "id_contrato=" . $_POST["id_contrato"] . "&";
				$this->id_contrato = $_POST["id_contrato"];
			}else{
				$this->errores["id_contrato"] = true;
				$this->error = true;
			}

			if(isset($_POST["nro_licitacion"]) && $_POST["nro_licitacion"] != ""){
				$this->params .= "nro_licitacion=" . $_POST["nro_licitacion"] . "&";
				$this->nro_licitacion = $_POST["nro_licitacion"];
			}else{
				$this->errores["nro_licitacion"] = true;
				$this->error = true;
			}

			if(isset($_POST["rut_proveedor"]) && $_POST["rut_proveedor"] != ""){
				$this->params .= "rut_proveedor=" . $_POST["rut_proveedor"] . "&";
				$this->rut_proveedor = $_POST["rut_proveedor"];
			}else{
				$this->errores["rut_proveedor"] = true;
				$this->error = true;
			}

			if(isset($_POST["id_area"]) && $_POST["id_area"] != ""){
				$this->params .= "id_area=" . $_POST["id_area"] . "&";
				$this->id_area = $_POST["id_area"];
			}else{
				$this->errores["id_area"] = true;
				$this->error = true;
			}

			if(isset($_POST["id_admin"]) && $_POST["id_admin"] != ""){
				$this->params .= "id_admin=" . $_POST["id_admin"] . "&";
				$this->id_admin = $_POST["id_admin"];
			}else{
				$this->errores["id_admin"] = true;
				$this->error = true;
			}

			if(isset($_POST["id_moneda"]) && $_POST["id_moneda"] != ""){
				$this->params .= "id_moneda=" . $_POST["id_moneda"] . "&";
				$this->id_moneda = $_POST["id_moneda"];
			}else{
				$this->errores["id_moneda"] = true;
				$this->error = true;
			}

			if(isset($_POST["tipo"]) && $_POST["tipo"] != ""){
				$this->params .= "tipo=" . $_POST["tipo"] . "&";
				$this->tipo = $_POST["tipo"];
			}else{
				$this->errores["tipo"] = true;
				$this->error = true;
			}

			if(isset($_POST["monto"]) && $_POST["monto"] != ""){
				$this->params .= "monto=" . $_POST["monto"] . "&";
				$this->tipo = $_POST["monto"];
			}else{
				$this->errores["monto"] = true;
				$this->error = true;
			}

			if(isset($_POST["estado_alerta"]) && $_POST["estado_alerta"] != ""){
				$this->params .= "estado_alerta=" . $_POST["estado_alerta"] . "&";
				$this->tipo = $_POST["estado_alerta"];
			}else{
				$this->errores["estado_alerta"] = true;
				$this->error = true;
			}

			if(isset($_POST["fecha_inicio"]) && $_POST["fecha_inicio"] != ""){
				$this->params .= "fecha_inicio=" . $_POST["fecha_inicio"] . "&";
				$this->tipo = $_POST["fecha_inicio"];
			}else{
				$this->errores["fecha_inicio"] = true;
				$this->error = true;
			}

			if(isset($_POST["fecha_termino"]) && $_POST["fecha_termino"] != ""){
				$this->params .= "fecha_termino=" . $_POST["fecha_termino"] . "&";
				$this->tipo = $_POST["fecha_termino"];
			}else{
				$this->errores["fecha_termino"] = true;
				$this->error = true;
			}

			if(isset($_POST["fecha_aprobacion"]) && $_POST["fecha_aprobacion"] != ""){
				$this->params .= "fecha_aprobacion=" . $_POST["fecha_aprobacion"] . "&";
				$this->tipo = $_POST["fecha_aprobacion"];
			}else{
				$this->errores["fecha_aprobacion"] = true;
				$this->error = true;
			}

			if(isset($_POST["fecha_alerta_vencimiento"]) && $_POST["fecha_alerta_vencimiento"] != ""){
				$this->params .= "fecha_alerta_vencimiento=" . $_POST["fecha_alerta_vencimiento"] . "&";
				$this->tipo = $_POST["fecha_alerta_vencimiento"];
			}else{
				$this->errores["fecha_alerta_vencimiento"] = true;
				$this->error = true;
			}

			if(isset($_POST["fecha_creacion"]) && $_POST["fecha_creacion"] != ""){
				$this->params .= "fecha_creacion=" . $_POST["fecha_creacion"] . "&";
				$this->tipo = $_POST["fecha_creacion"];
			}else{
				$this->errores["fecha_creacion"] = true;
				$this->error = true;
			}

			if(isset($_POST["fecha_actualizacion"]) && $_POST["fecha_actualizacion"] != ""){
				$this->params .= "fecha_actualizacion=" . $_POST["fecha_actualizacion"] . "&";
				$this->tipo = $_POST["fecha_actualizacion"];
			}else{
				$this->errores["fecha_actualizacion"] = true;
				$this->error = true;
			}

			if(isset($_POST["fecha_eliminacion"]) && $_POST["fecha_eliminacion"] != ""){
				$this->params .= "fecha_eliminacion=" . $_POST["fecha_eliminacion"] . "&";
				$this->tipo = $_POST["fecha_eliminacion"];
			}else{
				$this->errores["fecha_eliminacion"] = true;
				$this->error = true;
			}

			if(isset($_POST["objeto_contrato"]) && $_POST["objeto_contrato"] != ""){
				$this->params .= "objeto_contrato=" . $_POST["objeto_contrato"] . "&";
				$this->tipo = $_POST["objeto_contrato"];
			}else{
				$this->errores["objeto_contrato"] = true;
				$this->error = true;
			}
		}

		return new self($this->pdo);

	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){

			
			

			//consulta de inserción
			
			// $consulta = "INSERT into CONTRATOS values (
			// 			'". $this->id_contrato ."',
			// 			'". $this->nro_licitacion ."',
			// 			'". $this->rut_proveedor ."',
			// 			'". $this->id_area ."',
			// 			'". $this->id_admin ."',
			// 			'". $this->id_moneda ."',
			// 			'". $this->tipo ."',
			// 			'". $this->monto ."',
			// 			'". $this->estado_alerta ."',
			// 			'". $this->fecha_inicio ."',
			// 			'". $this->fecha_termino ."',
			// 			'". $this->fecha_aprobacion ."',
			// 			'". $this->fecha_alerta_vencimiento ."',
			// 			'". $this->fecha_creacion ."',
			// 			'". $this->fecha_actualizacion ."',
			// 			'". $this->fecha_eliminacion ."',
			// 			'". $this->objeto_contrato."'
			// 			)";

			$consulta = "INSERT INTO CONTRATOS VALUES (44, '111', '111', '1', '1', '1', '1', 1000, 1, '14/10/20', '14/10/20', '14/10/20', '14/10/20', '14/10/20', '14/10/20', '14/10/20', 'hola')";

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
		$query = "SELECT RUT_PROVEEDOR FROM PROVEEDORES";
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