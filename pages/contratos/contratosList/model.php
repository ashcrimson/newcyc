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
	private int $page;
	//resultados por pagina
	private $resultados = 10;

	//Constructor
	function __construct($pdo, string $nro_licitacion = '', int $page = 1){
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
	public function getId($nro_licitacion): self{
		return new self($this->pdo, $nro_licitacion, $this->page);
	}

	//filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->nro_licitacion, $page);
	}

	//retorna el/los datos seleccionados
	public function get(){
		
		$assoc = [];
		$listado = [];
		$numeros = [];
		$totales = [];


		if ($this->nro_licitacion){
			$where = " WHERE nro_licitacion = '" . $this->nro_licitacion . "'";
		}else{
			$where = "";
		}

		//consulta principal
		/*$consulta = "
		SELECT
			P.RUT,
			P.NOMBRE AS RAZON,
			C.TIPO,
			C.ID,
			c.nro_licitacion,
			MONEDA.NOMBRE AS MONEDA,
			C.PRECIO,
			MONEDA.EQUIVALENCIA,
			C.FECHA_INICIO,
			C.FECHA_TERMINO,
			C.FECHA_APROVACION,
			C.FECHA_ACTUALIZACION,
			D.DETALLE,
			C.FECHA_ALERTA_VENCIMIENTO
		FROM
			PROVEEDORES P,
			CYC C,
			MONEDA,
			DETALLE_CONTRATO D" . 
		$where . "
		ORDER BY C.FECHA_CREACION ASC";*/

		$consulta = "SELECT
			P.RUT,
			P.NOMBRE AS RAZON,
			C.TIPO,
			C.ID,
			c.nro_licitacion,
			M.NOMBRE AS MONEDA,
			C.PRECIO,
			M.EQUIVALENCIA,
			C.FECHA_INICIO,
			C.FECHA_TERMINO,
			C.FECHA_APROVACION,
			C.FECHA_ACTUALIZACION,
			D.DETALLE,
			C.FECHA_ALERTA_VENCIMIENTO
		FROM
			CYC C inner join PROVEEDORES P on c.rut_proveedor=p.rut
			inner join MONEDA M on c.id_moneda=m.codigo
            inner join DETALLE_CONTRATO D on c.nro_licitacion=d.nro_licitacion ";

		//$consulta = "SELECT * FROM CYC";
		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);


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


		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		

		array_push($assoc, $listado);
		array_push($assoc, $proveedores);
		array_push($assoc, $cargos);
		array_push($assoc, $licitaciones);
		array_push($assoc, $totales);

		oci_close($this->pdo);
		return $assoc;
	}
}