<?php 
 
  

namespace PrestacionesList;


/**
 * modelo de lista de  licitaciones
 */
class ModelPrestaciones {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	//filtro de por rut
	private $codigo;

	private $id;
	//pagina  
	private $page;
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

	$sql = "DELETE FROM PRESTACIONES WHERE CODIGO= '{$id}'";
        $result = oci_parse($this->pdo, $sql);
        oci_execute($result);
        oci_commit($this->pdo);

        return new self($this->pdo, '', $this->page);

	}

	//filtra consulta por nro de proveedor(id, llave primaria)
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

		 $where = "WHERE 1=1 ";

		 if ($_GET['codigo']){
		 	$where .= " and CODIGO = '" . $_GET['codigo'] . "'";
		 }

        if ($_GET['nombre']){
            $where .= " and NOMBRE = '" . $_GET['nombre'] . "'";
		}
		
		
 
		// consulta principal
		$consulta = "
			SELECT 
				*
			FROM
				 PRESTACIONES   
				 
			$where	 
				 
			";
			
			

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
		array_push($assoc, $totales);

		oci_close($this->pdo);
		return $assoc;

		
	}

    public function getDataListBox()
    {


        $query = "SELECT * FROM PRESTACIONES";
        $prestaciones = queryToArray($query,$this->pdo);



        return [
            'prestaciones' => $prestaciones,
        ];
    }
}