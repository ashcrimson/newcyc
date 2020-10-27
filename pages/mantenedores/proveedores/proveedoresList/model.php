<?php



namespace ProveedoresList;


/**
 * modelo de lista de  licitaciones
 */
class ModelProveedores {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	//filtro de por rut
	private $rut;
	//pagina 
	private $page;
	//resultados por pagina
	private $resultados = 10;

	//Constructor
	function __construct($pdo, $rut = '', int $page = 1){
		$this->pdo = $pdo;
		$this->rut = $rut;
		$this->page = $page;
	}

	//elimina registro indicado
	public function delete($rut): self{
		$sql = $this->pdo->prepare("DELETE FROM licitaciones WHERE RUT_PROVEEDOR = :rut");
		$sql->execute(["rut", $rut]);
	}

	//filtra consulta por nro de licitación(id, llave primaria)
	public function getId($rut): self{
		return new self($this->pdo, $rut, $this->page);
	}

	//filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->rut, $page);
	}

	//retorna el/los datos seleccionados
	public function get(){
		
		$assoc = [];
		$listado = [];
		$numeros = [];
		$totales = [];


		if ($this->rut){
			$where = " WHERE RUT_PROVEEDOR = '" . $this->rut . "'";
		}else{
			$where = "";
		}

		//consulta principal
		$consulta = "SELECT * FROM PROVEEDORES " . $where;
		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);

		//consulta para recuperar todos los numeros de licitaciones
		$result = oci_parse($this->pdo, $consulta);
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