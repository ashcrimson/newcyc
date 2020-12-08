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
	//filtro de por rut
	private $nro_orden_compra;

	private $id;
	//pagina 
	private $page;
	//resultados por pagina
	private $resultados = 10;

	//Constructor
	function __construct($pdo, $id = '', int $page = 1){
		$this->pdo = $pdo;
		$this->id = $id;
		$this->page = $page;
	}

	//elimina registro indicado
	public function delete($nro_orden_compra): self{

	$sql = "DELETE FROM ORDEN_COMPRA WHERE NRO_ORDEN_COMPRA= '{$nro_orden_compra}'";
        $result = oci_parse($this->pdo, $sql);
        oci_execute($result);
        oci_commit($this->pdo);

        return new self($this->pdo, '', $this->page);

	}

	//filtra consulta por nro de licitación(id, llave primaria)
	public function getId($nro_orden_compra): self{
		return new self($this->pdo, $nro_orden_compra, $this->page);
	}

	//filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->nro_orden_compra, $page);
	}

	//retorna el/los datos seleccionados
	public function get(){
		
		$assoc = [];
		$listado = [];
		$numeros = [];
		$totales = [];

		// $where = "WHERE 1=1 ";

		// if ($this->rut){
		// 	$where .= " and p.RUT_PROVEEDOR = '" . $this->rut . "'";
		// }else{
		// 	$where = "";
		// }
 
		// consulta principal
		$consulta = "
			select 
				o.*, 
				d.nombre as nombre_documento,
			    d.NRO_DOCUMENTO,   
				d.tipo_archivo,
				d.archivo
				
			from 
				ORDEN_COMPRA O 
				LEFT JOIN documento_orden_compra do on do.nro_orden_compra = o.nro_orden_compra
				LEFT JOIN documento d on d.nro_documento = do.nro_documento
			$where
			ORDER BY
				nro_documento
				
		
			";
		
		//consulta para recuperar todos los codigos de monedas
		$query = "select * from licitaciones ";
		//$query = "select CODIGO from licitaciones ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$codigos = queryResultToAssoc($result);

		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);
			
		// $consulta = "SELECT * FROM PROVEEDORES";

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