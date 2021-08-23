<?php
 


namespace ProveedoresNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelProveedores  {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";
	private $feedback = "";
	private $rut;


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

			if(isset($_POST["rut"]) && $_POST["rut"] != ""){
				$this->params .= "rut" . $_POST["rut"] . "&";
				$this->rut = $_POST["rut"];
			}else{
				// $this->errores["id_contrato"] = true;
				// $this->error = true;
			}

			if(isset($_POST["nombre"]) && $_POST["nombre"] != ""){
				$this->params .= "nombre" . $_POST["nombre"] . "&";
				$this->nombre = $_POST["nombre"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}

			if(isset($_POST["nombre_fantasia"]) && $_POST["nombre_fantasia"] != ""){
				$this->params .= "nombre_fantasia" . $_POST["nombre_fantasia"] . "&";
				$this->nombre_fantasia = $_POST["nombre_fantasia"];
			}else{
				// $this->errores["id_admin"] = true;
				// // $this->error = true;
			}


			if(isset($_POST["telefono"]) && $_POST["telefono"] != ""){
				$this->params .= "telefono" . $_POST["telefono"] . "&";
				$this->telefono = $_POST["telefono"];
			}else{
				// $this->errores["proveedor_id"] = true;
				// $this->error = true;
			}

			if(isset($_POST["email"]) && $_POST["email"] != ""){
				$this->params .= "email=" . $_POST["email"] . "&";
				$this->email = $_POST["email"];
			}else{
				$this->errores["email"] = true;
				$this->error = true;
			}

			if(isset($_POST["direccion"]) && $_POST["direccion"] != ""){
				$this->params .= "direccion=" . $_POST["direccion"] . "&";
				$this->direccion = $_POST["direccion"];
			}else{
				$this->errores["direccion"] = true;
				$this->error = true;
			}

			if(isset($_POST["comuna"]) && $_POST["comuna"] != ""){
				$this->params .= "comuna=" . $_POST["comuna"] . "&";
				$this->comuna = $_POST["comuna"];
			}else{
				$this->errores["comuna"] = true;
				$this->error = true;
			}

			

			$feedback = "Contrato subido correctamente";

		}

		return new self($this->pdo);

	}

    public function edit($id)
    {
        return new self($this->pdo, $id);
    }

    public function get(){

        $query = "SELECT * FROM PROVEEDORES WHERE RUT_PROVEEDOR='" . $this->id . "'";

        //consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $listado = queryResultToAssoc($result);

        return $listado[0];
    }

    public function getDataListBox()
    {
        $assoc = [];


        //consulta para recuperar ruts de los proveedores
        $query = "SELECT * FROM PROVEEDORES";
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $proveedores = queryResultToAssoc($result);
        array_push($assoc, $proveedores);


        oci_close($this->pdo);

        return $assoc;
    }

	public function execute(){

		
		//validar si faltó algo
		if(!$this->error){
			

		    //actualiza
            if(isset($_POST["id"]) && $_POST["id"] != "") {
                $query = "
                    UPDATE PROVEEDORES SET 
						 RUT_PROVEEDOR='". $_POST["rut"] ."', 
                         RAZON_SOCIAL='". $_POST["nombre"] ."', 
                         NOMBRE_FANTASIA='". $_POST["nombre_fantasia"] ."',
                         TELEFONO='". $_POST["telefono"] ."',  
                         EMAIL='". $_POST["email"] ."',
						 DIRECCION='". $_POST["direccion"] ."',
						 COMUNA='". $_POST["comuna"] ."',
                         FECHA_CREACION=TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd')
                         
					WHERE 
					    RUT_PROVEEDOR='" . $_POST['id'] . "'
                ";


//                echo "<pre>";
//                var_dump($query);
//                exit();
//                echo "</pre>";


                $result = oci_parse($this->pdo, $query);

                if($result){
					
                    flash("Contrato actualizado correctamente")->success() ;
                }

                oci_execute($result);

                oci_commit($this->pdo);

            }
	        //inserta
	        else{

                $consulta = "INSERT INTO PROVEEDORES (
				RUT_PROVEEDOR, 
				RAZON_SOCIAL, 
				NOMBRE_FANTASIA, 
				TELEFONO, 
				EMAIL, 
				DIRECCION, 
				COMUNA,
				FECHA_CREACION
				) 
			VALUES (
				'". $_POST["rut"] ."', 
				'". acentos($_POST["nombre"]) ."',
				'". acentos($_POST["nombre_fantasia"]) ."',
				'". $_POST["telefono"] ."',
				'". $_POST["email"] ."',
				'". $_POST["direccion"] ."',
				'". $_POST["comuna"] ."',
				TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd')
				)";

                //ejecucion consulta
                $query = $consulta;
                $result = oci_parse($this->pdo, $query);

                if($result){
					
                    flash("Proveedor ingresado correctamente")->success() ;
                }

                oci_execute($result);


                oci_commit($this->pdo);
            }
			
		}else{
			
			print_r($this->errores);
			
			die();
		}

  

		//agrega resultados a retorno

		oci_close($this->pdo);

		header("Location:". base() ."/proveedores");
		
		//return $assoc;
	}


 


}