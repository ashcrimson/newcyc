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
	private $feedback = "";

	private $nro_orden_compra;
	private $id_contrato;
	private $estado;
	private $total;
	private $archivo_orden_compra;
	private $nro_documento;
	private $archivo_nombre;
	private $fecha_creacion;
	private $pdf;
	private $detalle_contrato;
	private $cantidad;

	//Constructor
	function __construct($pdo, $nro_orden_compra = ''){
                 
		$this->pdo = $pdo;
		$this->nro_orden_compra = $_GET["nro_orden_compra"];
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
				// $this->errores["nro_orden_compra"] = true;
				// $this->error = true;
			}

			if(isset($_POST["id_contrato"]) && $_POST["id_contrato"] != ""){
				$this->params .= "id_contrato" . $_POST["id_contrato"] . "&";
				$this->id_contrato = $_POST["id_contrato"];
			}else{
				// $this->errores[] = "No mando el id del contrato";
				// $this->error = true;
			}

			if(isset($_POST["detalle_contrato"]) && $_POST["detalle_contrato"] != ""){
				$this->params .= "detalle_contrato" . $_POST["detalle_contrato"] . "&";
				$this->detalle_contrato = $_POST["detalle_contrato"];
			}else{
				// $this->errores[] = "No mando el id del contrato";
				// $this->error = true;
			}

			if(isset($_POST["cantidad"]) && $_POST["cantidad"] != ""){
				$this->params .= "cantidad" . $_POST["cantidad"] . "&";
				$this->cantidad = $_POST["cantidad"];
			}else{
				// $this->errores[] = "No mando el id del contrato";
				// $this->error = true;
			}

			if(isset($_POST["estado"]) && $_POST["estado"] != ""){
				$this->params .= "estado" . $_POST["estado"] . "&";
				$this->estado = $_POST["estado"];
			}else{
				// $this->errores[] = "No mando el estado";
				// $this->error = true;
			}

			if(isset($_POST["total"]) && $_POST["total"] != ""){
				$this->params .= "total" . $_POST["total"] . "&";
				$this->total = $_POST["total"];
			}else{
				// $this->errores[] = "No mando el total";
				// $this->error = true;
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

	public function edit($nro_orden_compra)
    {  
          
          return new self($this->pdo, $nro_orden_compra);
	}

	public function get(){
		
		
		$query = "SELECT * FROM ORDEN_COMPRA WHERE NRO_ORDEN_COMPRA='" . $this->nro_orden_compra . "'";
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $listado = queryResultToAssoc($result);
		// array_push($assoc, $listado);
    
		return $listado[0];
	

	}

	public function getContratos(){

		$assoc = [];


		//consulta para recuperar los ids de los contratos
		$query = "SELECT * FROM CONTRATOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$contratos = queryResultToAssoc($result);
		// array_push($assoc, $contratos);

		return $contratos;
	}

	public function getDetalleContrato(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=1";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato = queryResultToAssoc($result);
		

		return $detalle_contrato;
	}

	public function getDetalleContrato2(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=2";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato2 = queryResultToAssoc($result);
		

		return $detalle_contrato2;
	}

	public function getDetalleContrato3(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=3";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato3 = queryResultToAssoc($result);
		

		return $detalle_contrato3;
	}

	public function getDetalleContrato4(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=4";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato4 = queryResultToAssoc($result);
		

		return $detalle_contrato4;
	}

	public function getDetalleContrato5(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=5";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato5 = queryResultToAssoc($result);
		

		return $detalle_contrato5;
	}

	public function getDetalleContrato6(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=6";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato6 = queryResultToAssoc($result);
		

		return $detalle_contrato6;
	}

	public function getDetalleContrato7(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=7";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato7 = queryResultToAssoc($result);
		

		return $detalle_contrato7;
	}

	public function getDetalleContrato8(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=8";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato8 = queryResultToAssoc($result);
		

		return $detalle_contrato8;
	}
	
	public function getDetalleContrato9(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=9";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato9 = queryResultToAssoc($result);
		

		return $detalle_contrato9;
	}

	public function getDetalleContrato10(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=10";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato10 = queryResultToAssoc($result);
		

		return $detalle_contrato10;
	}
	
	public function getDetalleContrato11(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=11";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato11 = queryResultToAssoc($result);
		

		return $detalle_contrato11;
	}

	public function getDetalleContrato12(){

		$assoc = [];


		//consulta para recuperar los detalles de los contratos
		$query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO=12";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$detalle_contrato12 = queryResultToAssoc($result);
		

		return $detalle_contrato12;
	}

	public function execute(){

		
		//validar si faltó algo
		if(!$this->error)
		{
			if(isset($_POST["id"]) && $_POST["id"] != "") {
				$query = "
                    UPDATE ORDEN_COMPRA SET 
						NRO_ORDEN_COMPRA='" . $_POST['nro_orden_compra'] . "', 
						ID_CONTRATO='" . $_POST['id_contrato'] . "', 
						FECHA_ENVIO=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), 
						TOTAL='" . $_POST['total'] . "', 
						ESTADO='" . $_POST['estado'] . "', 
						FECHA_CREACION=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), 
						FECHA_ACTUALIZACION=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), 
						FECHA_ELIMINACION=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
						CODIGO='" . $_POST['detalle_contrato'] . "',
						CANTIDAD='" . $_POST['cantidad'] . "'
					WHERE 
						NRO_ORDEN_COMPRA='" . $_POST['id'] . "'
                ";


                $result = oci_parse($this->pdo, $query);

                if($result){
                    $_SESSION["feedback"] = "Orden de compra actualizada correctamente";
                }

                oci_execute($result);

                oci_commit($this->pdo);
 
               
			}else{
			
				// $numero = 0; 

				$consulta = "INSERT INTO ORDEN_COMPRA VALUES (
					'". $this->nro_orden_compra ."', 
					'". $this->id_contrato ."', 
					TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'),
					'". $this->total ."', 
					'". $this->estado ."', 
					TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
					TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
					TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
					'". $this->detalle_contrato ."',
					'". $this->cantidad ."'
					
					)";

				

				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);

				if($result){
					$_SESSION["feedback"] = "Orden de compra ingresada correctamente";
				}
				//print_r($consulta);
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			
			}	
		}else{

			foreach($this->errores as $e){
				echo $e."<br>";
			}
			// header("Location: ". base() . "/ordenCompra/new?" . $params);
			die();
		}

		if($_FILES["archivo_orden_compra"]["error"] == 0){

				
			$cons = "select documentos_sequence.nextval as NRO_DOCUMENTO from dual";
			$result = oci_parse($this->pdo, $cons);
			oci_execute($result);
			$nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];
			
			$archivo = basename($_FILES["archivo_orden_compra"]["name"]);
			$tipo = $_FILES["archivo_orden_compra"]["type"];
			$peso = $_FILES["archivo_orden_compra"]["size"];
			
			$pdf = file_get_contents($_FILES['archivo_orden_compra']['tmp_name']);

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

			if(!$blob->save($pdf)) {
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

	
}