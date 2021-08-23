<?php



namespace TemplateCYC;


/**
 * modelo de plantilla y control de permisos
 */
class ModelTemplateCYC {

	/**
	 *
	 */
	//Obj de conexion de db
	public $pdo;
	//mail usuario
	private $mail;
	//permisos
	private $permisos;

	//Constructor
	function __construct($pdo, string $mail = ''){
		$this->pdo = $pdo;
		$this->mail = $mail;
	}


	//fija mial del usuario
	public function mail($mail): self{
		return new self($this->pdo, $mail);
	}

	//retorna los datos del usuario
	public function get(){
	
		$where = "";	
		if ($this->mail){
//saca: falta cambiar clausula
			//$where = " WHERE nro_licitacion = " . $this->nro_licitacion;
			$query = "SELECT PERMISOS.* from PERMISOS
						INNER JOIN USUARIOS_PERMISOS ON
						USUARIOS_PERMISOS.ID_PERMISO = PERMISOS.ID_PERMISO
						WHERE MAIL = '" . $this->mail . "'";

			$result = oci_parse($this->pdo, $query);
			oci_execute($result);
			$datos = queryResultToAssoc($result);
			//oci_execute($result);
			return $datos;
		}
	


//saca: quzas haya que hacer join
/*desco
		while ($paso = oci_fetch_assoc($result)) {
			array_push($assoc, $paso);
		}
*/		
		return "";
	}
}