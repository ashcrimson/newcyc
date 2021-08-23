<?php
 


namespace PrestacionesNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelPrestaciones {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";
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

			if(isset($_POST["codigo"]) && $_POST["codigo"] != ""){
				$this->params .= "codigo" . $_POST["codigo"] . "&";
				$this->codigo = $_POST["codigo"];
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
			if(isset($_POST["selectFonasa"]) && $_POST["selectFonasa"] != ""){

				$this->params .= "selectFonasa" . $_POST["selectFonasa"] . "&";
				$this->selectFonasa = $_POST["selectFonasa"];
			}else{
				$this->errores["selectFonasa"] = true;
				$this->error = true;
			}
			if(isset($_POST["valor_nivel_1"]) && $_POST["valor_nivel_1"] != ""){
				$this->params .= "valor_nivel_1" . $_POST["valor_nivel_1"] . "&";
				$this->valor_nivel_1 = $_POST["valor_nivel_1"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}
			if(isset($_POST["valor_nivel_2"]) && $_POST["valor_nivel_2"] != ""){
				$this->params .= "valor_nivel_2" . $_POST["valor_nivel_2"] . "&";
				$this->valor_nivel_2 = $_POST["valor_nivel_2"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}
			if(isset($_POST["valor_nivel_3"]) && $_POST["valor_nivel_3"] != ""){
				$this->params .= "valor_nivel_3" . $_POST["valor_nivel_3"] . "&";
				$this->valor_nivel_3 = $_POST["valor_nivel_3"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}


			

			$feedback = "Prestación subida correctamente";

		}

		return new self($this->pdo);

	}

    public function edit($id)
    {
        return new self($this->pdo, $id);
    }

    public function get(){

        $query = "SELECT * FROM PRESTACIONES WHERE CODIGO='" . $this->id . "'";

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
        $query = "SELECT * FROM PRESTACIONES";
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $prestaciones = queryResultToAssoc($result);
        array_push($assoc, $prestaciones);


        oci_close($this->pdo);

        return $assoc;
    }

	public function execute(){

		
		//validar si faltó algo
		if(!$this->error){
			

		    //actualiza
            if(isset($_POST["codigo"]) && $_POST["codigo"] != "") {
                $query = "
                    UPDATE PRESTACIONES SET 
						 CODIGO='". $_POST["codigo"] ."', 
						 NOMBRE='". $_POST["nombre"] ."',
						 FONASA='". $_POST["selectFonasa"] ."',
						 VALOR_NIVEL_1='". $_POST["valor_nivel_1"] ."',
						 VALOR_NIVEL_2='". $_POST["valor_nivel_2"] ."',
						 VALOR_NIVEL_2='". $_POST["valor_nivel_3"] ."',
                         
					WHERE 
					    CODIGO='" . $_POST['codigo'] . "'
                ";


//                echo "<pre>";
//                var_dump($query);
//                exit();
//                echo "</pre>";


                $result = oci_parse($this->pdo, $query);

                if($result){
                    $_SESSION["feedback"] = "Prestación actualizada correctamente";
                }

                oci_execute($result);

                oci_commit($this->pdo);

            }
	        //inserta
	        else{

                $consulta = "INSERT INTO PRESTACIONES (
				CODIGO, 
				NOMBRE,
				VALOR_NIVEL_1,
				VALOR_NIVEL_2,
				VALOR_NIVEL_3,
				FONASA
				) 
			VALUES (
				'". $_POST["code"] ."', 
				'". $_POST["nombre"] ."',
				'". $_POST["valor_nivel_1"] ."',
				'". $_POST["valor_nivel_2"] ."',
				'". $_POST["valor_nivel_3"] ."',
				'". $_POST["selectFonasa"]  ."'
				)";

                //ejecucion consulta
                $query = $consulta;
                $result = oci_parse($this->pdo, $query);

                if($result){
                    $_SESSION["feedback"] = "Prestación ingresada correctamente";
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
		
		//return $assoc;
	}


 


}