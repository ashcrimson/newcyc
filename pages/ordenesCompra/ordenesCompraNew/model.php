<?php



namespace OrdenCompraNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelOrdenCompra {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";

	private $nro_orden_compra;
	private $id_contrato;
	private $estado;
	private $total;
	private $archivo_orden_compra;
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


		//validacion de datos recibidos
		$params = "";
		if(isset($_POST["submit"])){

			if(isset($_POST["nro_orden_compra"]) && $_POST["nro_orden_compra"] != ""){
				$this->params .= "nro_orden_compra" . $_POST["nro_orden_compra"] . "&";
				$this->nro_orden_compra = $_POST["nro_orden_compra"];
			}else{
				$this->errores["nro_orden_compra"] = true;
				$this->error = true;
			}

			if(isset($_POST["id_contrato"]) && $_POST["id_contrato"] != ""){
				$this->params .= "id_contrato" . $_POST["id_contrato"] . "&";
				$this->id_contrato = $_POST["id_contrato"];
			}else{
				$this->errores[] = "No mando el id del contrato";
				$this->error = true;
			}

			if(isset($_POST["estado"]) && $_POST["estado"] != ""){
				$this->params .= "estado" . $_POST["estado"] . "&";
				$this->estado = $_POST["estado"];
			}else{
				$this->errores[] = "No mando el estado";
				$this->error = true;
			}

			if(isset($_POST["total"]) && $_POST["total"] != ""){
				$this->params .= "total" . $_POST["total"] . "&";
				$this->total = $_POST["total"];
			}else{
				$this->errores[] = "No mando el total";
				$this->error = true;
			}

			if(isset($_POST["archivo_orden_compra"]) && $_POST["archivo_orden_compra"] != ""){
				$params .= "archivo_orden_compra=" . $_POST["archivo_orden_compra"] . "&";
			}else{
				$errores["archivo_orden_compra"] = true;
				$error = true;
			}
			
		}

		return new self($this->pdo);

	}

	public function execute(){

		
		//validar si faltó algo
		if(!$this->error){
			
			$numero = 0;

			$consulta = "INSERT INTO ORDEN_COMPRA VALUES (
				'". $this->nro_orden_compra ."', 
				'". $this->id_contrato ."', 
				TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'),
				'". $this->total ."', 
				'". $this->estado ."', 
				TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
				TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
				TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss')
				)";

			//ejecucion consulta
			$query = $consulta;
			$result = oci_parse($this->pdo, $query);
			//print_r($consulta);
			oci_execute($result);

			//oci_error();
			//$listado = queryResultToAssoc($result);
			oci_commit($this->pdo);
		}else{

			foreach($this->errores as $e){
				echo $e."<br>";
			}
			// header("Location: ". base() . "/ordenCompra/new?" . $params);
			die();
		}

		if(isset($_FILES["archivo_orden_compra"]) && $_FILES["archivo_orden_compra"] != ""){
				
			$cons = "select documentos_sequence.nextval as NRO_DOCUMENTO from dual";
			$result = oci_parse($this->pdo, $cons);
			oci_execute($result);
			$nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];
			print_r($nro_documento);

			$directorio = "uploads/";
			$archivo = $directorio . basename($_FILES["archivo_orden_compra"]["name"]);
			$tipo = $_FILES["archivo_orden_compra"]["type"];
			$peso = $_FILES["archivo_orden_compra"]["size"];
			
			$pdf = file_get_contents($_FILES['archivo_orden_compra']['tmp_name']);


			move_uploaded_file($_FILES["archivo_orden_compra"]["tmp_name"], $archivo);

			//consulta de inserción
			//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
			$consulta = "INSERT into DOCUMENTO (NRO_DOCUMENTO, TIPO_DOCUMENTO, NOMBRE, ARCHIVO, PESO_ARCHIVO, TIPO_ARCHIVO, FECHA_CREACION) values (
						'". $nro_documento ."',
						'oc',
						'". $archivo ."',
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

			if(!$blob->save($archivo)) {
				oci_rollback($this->pdo);
			}
			else {
				oci_commit($this->pdo);
			}

			oci_free_statement($result);
			$blob->free();
			//OJOOOOOOOOOOOOOO
			//DESPUES DE INSERTAR EL BLOB
			////Guardar en lka tbla documento_lictacion
			///LA RELACION DE ESTE DOCUMENTO $nro_documento ----> id y  $this->nro_licitacion ---> nro_lictacion

			$consulta2 = "INSERT into DOCUMENTO_ORDEN_COMPRA (NRO_DOCUMENTO, NRO_ORDEN_COMPRA) values (
				'". $nro_documento ."',
				'". $this->nro_orden_compra ."'
			)";

			$query2 = $consulta2;
			$result2 = oci_parse($this->pdo, $query2);
			oci_execute($result2, OCI_DEFAULT) or die ("No se pudo");
		}


		oci_close($this->pdo);
		// return $assoc;
		
	}

	public function get(){
		
		$assoc = [];


		//consulta para recuperar los ids de los contratos
		$query = "SELECT ID_CONTRATO FROM CONTRATOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$contratos = queryResultToAssoc($result);
		array_push($assoc, $contratos);




		oci_close($this->pdo);
		return $assoc;


	}
}