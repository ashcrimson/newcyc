<?php



namespace ContratosList;


/**
 * modelo de lista de  licitaciones
 */
class ModelContratos {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	//filtro de licitacion
	private $nro_licitacion;
	//pagina 
	private  $page;
	//resultados por pagina
	private $resultados = 10;

	//Constructor
	function __construct($pdo, string $id = '', int $page = 1){
		$this->pdo = $pdo;
		$this->nro_licitacion = $nro_licitacion;
		$this->page = $page;
	}

	//elimina registro indicado
	public function delete($nro_licitacion): self{
		$sql = $this->pdo->prepare("DELETE FROM licitaciones WHERE nro_licitacion = :nro_licitacion");
		$sql->execute(["nro_licitacion", $nro_licitacion]);
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
		$contratos = [];


		if ($this->nro_licitacion){
			$where = " WHERE nro_licitacion = '" . $this->nro_licitacion . "'";
		}else{
			$where = "";
		}


		//consulta para recuperar ruts y razon social de los proveedores
		$query = "select * from PROVEEDORES";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$proveedores = queryResultToAssoc($result);


		//consulta para recuperar cargos administradores tecnicos
		$query = "select * from CARGOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$cargos = queryResultToAssoc($result);


		//consulta para recuperar numeros de licitaciones
		$query = "select NRO_LICITACION from LICITACIONES";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$licitaciones = queryResultToAssoc($result);

		

		//consulta para recuperar razón social de la otra tabla
		$consulta = "select c.*, p.razon_social from CONTRATOS C LEFT JOIN PROVEEDORES P ON c.rut_proveedor = p.rut_proveedor";
		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);


		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		
		// Arryas que forman la tabla principal con paginación
		array_push($assoc, $listado);
		array_push($assoc, $totales); 

		// Arrays que forman los listbox para filtros
		array_push($assoc, $proveedores);
		array_push($assoc, $cargos);
		array_push($assoc, $licitaciones);
		
		
		

		oci_close($this->pdo);
		return $assoc;
	}
}