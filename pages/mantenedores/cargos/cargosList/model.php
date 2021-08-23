<?php



namespace CargosList;


/**
 * modelo de lista de  licitaciones
 */
class ModelCargos {

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

        $sql = "DELETE FROM CARGOS WHERE ID_CARGO = ".$id;
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
			$where = " WHERE ID_CARGO = '" . $this->id . "'";
		}else{
			$where = "";
		}
/*
		$parameters = [];
		$sql = $this->pdo->prepare("SELECT * FROM licitaciones" . $where);
		$sql->execute($parameters);

		$query = "select * from licitaciones " . $where;
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		//oci_fetch_all($result, $res);

		//consulta principal
		$query = "
		select * from (
			select consulta.*, rownum rn from (
			    select *
			    from LICITACIONES" . 
			    $where .
				"
			    order by FECHA_CREACION desc
			) consulta 
			where rownum <= " . $this->fin . "
		) cosnulta
		where rn > " . $this->inicio . "
		";*/
		//consulta principal
		$consulta = "SELECT * FROM CARGOS " . $where . " ORDER BY ID_CARGO DESC";

		//print_r($consulta);

		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);

		//consulta para recuperar todos los cargos
		$query = "select ID_CARGO from CARGOS ";
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