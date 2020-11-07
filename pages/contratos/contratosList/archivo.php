<?php

  

namespace Archivos;


/**
 * modelo de lista de  licitaciones
 */
class Archivos {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	//filtro de licitacion
	private $id;
	//pagina 
	private  $page;
	//resultados por pagina
	private $resultados = 10;

	//Constructor
	function __construct($pdo, string $id = '', int $page = 1){
		$this->pdo = $pdo;
		$this->id = $id;
		$this->page = $page;
	}

	

	//filtra consulta por nro de contrato (id, llave primaria)
	public function getId($id): self{
        return new self($this->pdo, $id, $this->page);
	}

	//filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->id, $page);
	}

	//retorna el/los datos seleccionados
	public function get(){
        $query = "SELECT * FROM documento WHERE id_contrato = " . (int) $_GET['id'];
        $result = oci_parse($this->pdo, $query);
		oci_execute($result);
        $row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS);
        if (!$row) {
            header('Status: 404 Not Found');
        } else {
            $archivo = $row['ARCHIVO']->load();
            header("Content-type:" .$row['TIPO_ADJUNTO']);
            print $archivo;
}
    }
   

}