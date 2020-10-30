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
	private $resultados = 10;

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

		//consulta para recuperar todos los numeros de licitaciones
		$query = "select * from ORDEN_COMPRA ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$numeros = queryResultToAssoc($result);

		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		//consulta para id de contrato
		$query = "select * from ORDEN_COMPRA ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$id_contrato = queryResultToAssoc($result);

		//consulta para número orden de compra
		$query = "select NRO_ORDEN_COMPRA from ORDEN_COMPRA ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$nro_orden_compra = queryResultToAssoc($result);

		//consulta para estado orden de compra
		$query = "select ESTADO from ORDEN_COMPRA ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$estado = queryResultToAssoc($result);



		array_push($assoc, $listado);
		array_push($assoc, $numeros);
		array_push($assoc, $totales);
		array_push($assoc, $id_contrato);
		array_push($assoc, $nro_orden_compra);
		array_push($assoc, $estado);
		

		oci_close($this->pdo);
		return $assoc;
	}
}