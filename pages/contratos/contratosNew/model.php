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
	private $feedback = "";

	private $id_contrato;
	private $proveedor_id;
	private $id_area;
	private $id_admin;
	private $estado_alerta;
	private $selectContrato;
	private $licitacion;
	private $moneda_id;
	private $precio;
	private $cargo_id;
	private $fecha_inicio;
	private $fecha_termino;
	private $fecha_aprobacion;
	private $fecha_alert;
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

			if(isset($_POST["id_contrato"]) && $_POST["id_contrato"] != ""){
				$this->params .= "id_contrato" . $_POST["id_contrato"] . "&";
				$this->id_contrato = $_POST["id_contrato"];
			}else{
				// $this->errores["id_contrato"] = true;
				// $this->error = true;
			}

			if(isset($_POST["id_area"]) && $_POST["id_area"] != ""){
				$this->params .= "id_area" . $_POST["id_area"] . "&";
				$this->id_area = $_POST["id_area"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}

			if(isset($_POST["id_admin"]) && $_POST["id_admin"] != ""){
				$this->params .= "id_admin" . $_POST["id_admin"] . "&";
				$this->id_admin = $_POST["id_admin"];
			}else{
				$this->errores["id_admin"] = true;
				// $this->error = true;
			}


			if(isset($_POST["proveedor_id"]) && $_POST["proveedor_id"] != ""){
				$this->params .= "proveedor_id" . $_POST["proveedor_id"] . "&";
				$this->proveedor_id = $_POST["proveedor_id"];
			}else{
				$this->errores["proveedor_id"] = true;
				$this->error = true;
			}
			if(isset($_POST["selectContrato"]) && $_POST["selectContrato"] != ""){
				$this->params .= "selectContrato" . $_POST["selectContrato"] . "&";
				$this->selectContrato = $_POST["selectContrato"];
			}else{
				$this->errores["selectContrato"] = true;
				$this->error = true;
			}
			if(isset($_POST["licitacion"]) && $_POST["licitacion"] != ""){
				$this->params .= "licitacion" . $_POST["licitacion"] . "&";
				$this->licitacion = $_POST["licitacion"];
			}else{
				$this->errores["licitacion"] = true;
				$this->error = true;
			}
			if(isset($_POST["moneda_id"]) && $_POST["moneda_id"] != ""){
				$this->params .= "moneda_id" . $_POST["moneda_id"] . "&";
				$this->moneda_id = $_POST["moneda_id"];
			}else{
				$this->errores["moneda_id"] = true;
				$this->error = true;
			}
			if(isset($_POST["precio"]) && $_POST["precio"] != ""){
				$this->params .= "precio" . $_POST["precio"] . "&";
				$this->precio = $_POST["precio"];
			}else{
				// $this->errores["precio"] = true;
				// $this->error = true;
			}
			if(isset($_POST["cargo_id"]) && $_POST["cargo_id"] != ""){
				$this->params .= "cargo_id" . $_POST["cargo_id"] . "&";
				$this->cargo_id = $_POST["cargo_id"];
			}else{
				// $this->errores["cargo_id"] = true;
				// $this->error = true;
			}
			if(isset($_POST["fecha_inicio"]) && $_POST["fecha_inicio"] != ""){
				$this->params .= "fecha_inicio" . $_POST["fecha_inicio"] . "&";
				$this->fecha_inicio = $_POST["fecha_inicio"];
			}else{
				$this->errores["fecha_inicio"] = true;
				$this->error = true;
			}
			if(isset($_POST["fecha_termino"]) && $_POST["fecha_termino"] != ""){
				$this->params .= "fecha_termino" . $_POST["fecha_termino"] . "&";
				$this->fecha_termino = $_POST["fecha_termino"];
			}else{
				$this->errores["fecha_termino"] = true;
				$this->error = true;
			}
			if(isset($_POST["fecha_aprobacion"]) && $_POST["fecha_aprobacion"] != ""){
				$this->params .= "fecha_aprobacion" . $_POST["fecha_aprobacion"] . "&";
				$this->fecha_aprobacion = $_POST["fecha_aprobacion"];
			}else{
				$this->errores["fecha_aprobacion"] = true;
				$this->error = true;
			}
			if(isset($_POST["fecha_alert"]) && $_POST["fecha_alert"] != ""){
				$this->params .= "fecha_alert" . $_POST["fecha_alert"] . "&";
				$this->fecha_alert = $_POST["fecha_alert"];
			}else{
				$this->errores["fecha_alert"] = true;
				$this->error = true;
			}
			if(isset($_POST["objeto_contrato"]) && $_POST["objeto_contrato"] != ""){
				$this->params .= "objeto_contrato" . $_POST["objeto_contrato"] . "&";
				$this->objeto_contrato = $_POST["objeto_contrato"];
			}else{
				$this->errores["objeto_contrato"] = true;
				$this->error = true;
			}
			if(isset($_POST["numero"]) && $_POST["numero"] != ""){
				$this->params .= "numero" . $_POST["numero"] . "&";
				$this->numero = $_POST["numero"];
			}else{
				$this->errores["numero"] = true;
				// $this->error = true;
			}
			if(isset($_POST["monto"]) && $_POST["monto"] != ""){
				$this->params .= "monto" . $_POST["monto"] . "&";
				$this->monto = $_POST["monto"];
			}else{
				$this->errores["monto"] = true;
				$this->error = true;
			}
			
			if(isset($_POST["estado_alerta"]) && $_POST["estado_alerta"] != ""){
				$this->params .= "estado_alerta" . $_POST["estado_alerta"] . "&";
				$this->estado_alerta = $_POST["estado_alerta"];
			}else{
				$this->errores["estado_alerta"] = true;
				// $this->error = true;
			}

			if(isset($_POST["archivo_contrato"]) && $_POST["archivo_contrato"] != ""){
				$params .= "archivo_contrato=" . $_POST["archivo_contrato"] . "&";
			}else{
				$errores["archivo_contrato"] = true;
				$error = true;
			}

			$feedback = "Contrato subido correctamente";

		}

		return new self($this->pdo);

	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){
			

			$consulta = "INSERT INTO CONTRATOS (
				NRO_LICITACION, 
				RUT_PROVEEDOR, 
				ID_CARGO, 
				ID_MONEDA, 
				TIPO, 
				MONTO, 
				ESTADO_ALERTA, 
				FECHA_INICIO, 
				FECHA_TERMINO, 
				FECHA_APROBACION, 
				FECHA_ALERTA_VENCIMIENTO, 
				FECHA_CREACION, 
				FECHA_ACTUALIZACION, 
				FECHA_ELIMINACION, 
				OBJETO_CONTRATO
				) 
			VALUES (
				'". $this->licitacion ."',  
				'". $this->proveedor_id ."',
				'". $this->id_admin ."', 
				'". $this->moneda_id ."',  
				'". $this->selectContrato ."',  
				". $this->monto .", 
				null, 
				TO_DATE('". $this->fecha_inicio ."','yyyy-mm-dd'),  
				TO_DATE('". $this->fecha_termino ."','yyyy-mm-dd'), 
				TO_DATE('". $this->fecha_aprobacion ."','yyyy-mm-dd'), 
				TO_DATE('". $this->fecha_alert ."','yyyy-mm-dd'), 
				TO_DATE('2020-10-19 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), 
				TO_DATE('2020-10-19 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), 
				TO_DATE('2020-10-19 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), 
				'". $this->objeto_contrato ."')
				RETURNING ID_CONTRATO INTO :mylastid";



			//ejecucion consulta
			$query = $consulta;
			$result = oci_parse($this->pdo, $query);

			if($result){
				$_SESSION["feedback"] = "Contrato ingresado correctamente";
			}

			oci_bind_by_name($result, "mylastid", $last_id, 8, SQLT_INT);
			
			oci_execute($result);

			// var_dump($last_id);
			// exit();

			oci_commit($this->pdo);
			
		}else{
			
			print_r($this->errores);
			
			die();
		}

		if(isset($_FILES["archivo_contrato"]) && $_FILES["archivo_contrato"] != ""){
				
			$cons = "select documentos_sequence.nextval as NRO_DOCUMENTO from dual";
			$result = oci_parse($this->pdo, $cons);
			oci_execute($result);
			$nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];
			// print_r($nro_documento);

			
			$nombre_archivo = basename($_FILES["archivo_contrato"]["name"]);
			$tipo = $_FILES["archivo_contrato"]["type"];
			$peso = $_FILES["archivo_contrato"]["size"];
			
			$binario = file_get_contents($_FILES['archivo_contrato']['tmp_name']);


			//consulta de inserción
			
			$consulta = "INSERT into DOCUMENTO (NRO_DOCUMENTO, TIPO_DOCUMENTO, NOMBRE, ARCHIVO, PESO_ARCHIVO, TIPO_ARCHIVO, FECHA_CREACION) values (
						'". $nro_documento ."',
						'co',
						'". $nombre_archivo ."',
						empty_blob(),
						'". $peso ."',
						'". $tipo ."',
						TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'))
						RETURNING archivo INTO :archivo";

			//ejecucion consulta
			$query = $consulta;
			$result = oci_parse($this->pdo, $query);

			$blob = oci_new_descriptor($this->pdo, OCI_D_LOB);
			oci_bind_by_name($result, ":archivo", $blob, -1, OCI_B_BLOB);
			//print_r($consulta);
			oci_execute($result, OCI_DEFAULT) or die ("Unable to execute query");

			if(!$blob->save($binario)) {
				oci_rollback($this->pdo);
			} else { 
				oci_commit($this->pdo);
			}

			oci_free_statement($result);
			$blob->free();
			//OJOOOOOOOOOOOOOO
			//DESPUES DE INSERTAR EL BLOB
			////Guardar en lka tbla documento_lictacion
			///LA RELACION DE ESTE DOCUMENTO $nro_documento ----> id y  $this->nro_licitacion ---> nro_lictacion

			
			$consulta2 = "INSERT into DOCUMENTO_CONTRATOS (NRO_DOCUMENTO, NRO_CONTRATO) values (
				'". $nro_documento ."',
				'". $last_id ."'
			)";

			$query2 = $consulta2;
			$result2 = oci_parse($this->pdo, $query2);
			oci_execute($result2, OCI_DEFAULT) or die ("No se pudo");
		}

		

		//agrega resultados a retorno

		oci_close($this->pdo);
		
		//return $assoc;
	}


 
	public function get(){
		
		$assoc = [];


		//consulta para recuperar ruts de los proveedores
		$query = "SELECT * FROM PROVEEDORES";
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