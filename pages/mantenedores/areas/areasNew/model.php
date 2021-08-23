<?php



namespace AreasNew;


/**
 * modelo de lista de areas
 */
class Modelareas {

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


		//validacion de datos recibidos
		$params = "";
		if(isset($_POST["submit"])){
			if(isset($_POST["area"]) && $_POST["area"] != ""){
				$this->params .= "area=" . $_POST["area"] . "&";
				$this->area = acentos($_POST["area"]);
			}else{
				$this->errores["area"] = true;
				$this->error = true;
			}
		}

		return new self($this->pdo);

	}

	public function edit($id){
		return new self($this->pdo, $id);
	}

	public function get(){
		
		$query = "SELECT * FROM AREAS WHERE ID_AREA='" . $this->id . "'";

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

			    $consulta = "
                        UPDATE AREAS SET 
						     AREA = '{$_POST["area"]}',
						     ID_CARGO = {$_POST["id_cargo"]}
					    WHERE 
					        ID_AREA='{$_POST["id"]}'
			    ";


				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				//print_r($consulta);
				if($result){

                    $_SESSION["feedback"] = "Area actualizada correctamente";
                    flash("Area actualizada correctamente")->success() ;
                }
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			}else{
				$cons = "SELECT COUNT(*)+5 AS CTA FROM AREAS";
				$result = oci_parse($this->pdo, $cons);
				if($result){

                    $_SESSION["feedback"] = "Area actualizada correctamente";
                    flash("Area ingresada correctamente")->success() ;
                }
				oci_execute($result);

				$numero = queryResultToAssoc($result)[0]["CTA"];
				$nombre = acentos($_POST["area"]);

				$consulta = "
                        INSERT into areas (
                            ID_AREA, 
                            AREA,
                            ID_CARGO
                        ) 
                        values (
							'{$numero}', 
							'{$nombre}',
							{$_POST["id_cargo"]}
						)
				";

				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);
				//print_r($consulta);
				if($result){

                    $_SESSION["feedback"] = "Area actualizada correctamente";
                    flash("Area ingresada correctamente")->success() ;
                }
				oci_execute($result);

				//oci_error();
				//$listado = queryResultToAssoc($result);
				oci_commit($this->pdo);
			}

			

		}else{
			//print_r("redirige");
			header("Location: ". base() . "/areas/new?" . $params);
			die();
		}

		

		//agrega resultados a retorno
		//array_push($assoc, $listado);
		//array_push($assoc, $errores);

		//$results["result"] = $result;

		oci_close($this->pdo);
		header("Location:". base() ."/areas");
		//return $assoc;
	}

    public function getDataListBox()
    {
        $query = "SELECT * FROM CARGOS";
        $cargos = queryToArray($query,$this->pdo);

        return [
            'cargos' => $cargos,
        ];
	}
}