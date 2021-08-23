<?php



namespace AreasList;

 
/**
 * modelo de lista de areas
 */
class ModelAreas {

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

	//elimina registro indicado
	public function delete($id): self{

        $sql = "DELETE FROM AREAS WHERE ID_AREA = ".$id;
        $result = oci_parse($this->pdo, $sql);
        oci_execute($result);
        oci_commit($this->pdo);

        return new self($this->pdo, '', $this->page);

	}

	//filtra consulta por nro de licitación(id, llave primaria)
	public function getId($id): self{
		return new self($this->pdo, $id, $this->page);
	}

	//filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->id, $page);
	}

	//retorna el/los datos seleccionados
	public function get(){
		
		$assoc = [];

		if ($this->id){
			$where = " WHERE ID_AREA = '" . $this->id . "'";
		}else{
			$where = "";
		}

		//consulta principal
		$consulta = "SELECT a.*,c.NOMBRE nombre_cargo FROM AREAS a left join CARGOS c on a.ID_CARGO=c.ID_CARGO " . $where . " ORDER BY ID_AREA DESC";


		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);

		//consulta para recuperar todas las areas
		$query = "select ID_AREA from AREAS ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$numeros = queryResultToAssoc($result);

		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		

		array_push($assoc, $listado);
		array_push($assoc, $numeros);
		array_push($assoc, $totales);

		oci_close($this->pdo);


		return $assoc;
	}
}