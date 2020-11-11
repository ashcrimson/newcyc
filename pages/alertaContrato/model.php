<?php



namespace AlertaContrato;

/**
 * modelo de lista de  alertas de contrato
 */
class ModelAlertaContrato {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	//filtro de licitacion
	private $id_contrato;
	//pagina 
	private  $page;
	//resultados por pagina
	private $resultados = 10;

	//Constructor
	function __construct($pdo, string $id_contrato = '', int $page = 1){
		$this->pdo = $pdo;
		$this->id_contrato = $id_contrato;
		$this->page = $page;
	}

	//filtra consulta por nro de licitación(id, llave primaria)
	public function getId($id_contrato): self{
		return new self($this->pdo, $id_contrato, $this->page);
	}

	//filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->id_contrato, $page);
	}

	//retorna el/los datos seleccionados
	public function get(){
		
		$assoc = [];
		$listado = [];
		$numeros = [];
		$totales = [];


		if ($this->id_contrato){
			$where = " WHERE id_contrato = '" . $this->id_contrato . "'";
		}else{
			$where = "";
		}
		//consulta principal
		$consulta = "
		select 
			c.*, 
			p.razon_social
			
		from 
			CONTRATOS C LEFT JOIN PROVEEDORES P ON c.rut_proveedor = p.rut_proveedor
			
		$where
		ORDER BY
			id_contrato
		";

		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);
 
		//consulta para recuperar todos los numeros de licitaciones
		$query = "select NRO_LICITACION from licitaciones ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$numeros = queryResultToAssoc($result);

		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		

		array_push($assoc, $listado);
		array_push($assoc, $totales);

		oci_close($this->pdo);
		return $assoc;
	}
}