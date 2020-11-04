<?php



namespace UsuariosNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelUsuarios {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";
	private $feedback = "";

	private $nombre;
	private $mail;




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

			if(isset($_POST["nombre"]) && $_POST["nombre"] != ""){
				$this->params .= "nombre" . $_POST["nombre"] . "&";
				$this->nombre = $_POST["nombre"];
			}else{
				// $this->errores["id_contrato"] = true;
				// $this->error = true;
			}

			if(isset($_POST["email"]) && $_POST["email"] != ""){
				$this->params .= "email" . $_POST["email"] . "&";
				$this->email = $_POST["email"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}

			if(isset($_POST["rol"]) && $_POST["rol"] != ""){
				$this->params .= "rol" . $_POST["rol"] . "&";
				$this->rol = $_POST["rol"];
			}else{
				$this->errores["rol"] = true;
				// $this->error = true;
			}


			if(isset($_POST["cargo_id"]) && $_POST["cargo_id"] != ""){
				$this->params .= "cargo_id" . $_POST["cargo_id"] . "&";
				$this->cargo_id = $_POST["cargo_id"];
			}else{
				$this->errores["cargo_id"] = true;
				$this->error = true;
			}
			

		}

		return new self($this->pdo);

	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){
			

			$consulta = "INSERT INTO USUARIOS (
				MAIL, 
				NOMBRE, 
				ID_CARGO
				) 
			VALUES (
				'". $this->licitacion ."',  
				'". $this->proveedor_id ."',
				null, 
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

			$directorio = "uploads/";
			$archivo = $directorio . basename($_FILES["archivo_contrato"]["name"]);
			$tipo = $_FILES["archivo_contrato"]["type"];
			$peso = $_FILES["archivo_contrato"]["size"];
			
			$pdf = file_get_contents($_FILES['archivo_contrato']['tmp_name']);


			move_uploaded_file($_FILES["archivo_contrato"]["tmp_name"], $archivo);

			//consulta de inserción
			
			$consulta = "INSERT into DOCUMENTO (NRO_DOCUMENTO, TIPO_DOCUMENTO, NOMBRE, ARCHIVO, PESO_ARCHIVO, TIPO_ARCHIVO, FECHA_CREACION) values (
						'". $nro_documento ."',
						'co',
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