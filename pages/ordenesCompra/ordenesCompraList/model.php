<?php



namespace OrdenCompraList;


/**
 * modelo de lista de  licitaciones
 */
class ModelOrdenCompra {

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
	private $resultados = 12;

	//Constructor
	function __construct($pdo, string $id = '', int $page = 1){
		$this->pdo = $pdo;
		$this->id = $id;
		$this->page = $page;
	}

	//elimina registro indicado
	public function delete($id): self{
        $sql = "DELETE FROM ORDEN_COMPRA WHERE NRO_ORDEN_COMPRA = ".$id;
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
		$listado = [];
		$numeros = [];
		$totales = [];


		if ($this->id){
			$where = " WHERE NRO_ORDEN_COMPRA = '" . $this->id . "'";
		}else{
			$where = "";
		}

		//consulta principal
		$consulta = "SELECT * FROM ORDEN_COMPRA ";// . $where . " ORDER BY FECHA_CREACION DESC";

		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);

		
		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		array_push($assoc, $listado);
		
		

		oci_close($this->pdo);
		return $assoc;
	}
}