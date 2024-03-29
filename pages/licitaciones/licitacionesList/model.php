<?php

  

namespace LicitacionesList; 


/**
 * modelo de lista de  licitaciones
 */
class ModelLicitaciones {

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

		$where = "WHERE 1=1 ";

        if ($this->nro_licitacion){
            $where .= " and l.nro_licitacion = '" . $this->nro_licitacion . "'";
        }

        $consulta = "
			select 
				l.*, 
				d.nombre as nombre_documento,
				d.NRO_DOCUMENTO,   
				d.tipo_archivo,
				d.archivo,
				u.NOMBRE as USUARIO_CREA,
				u2.NOMBRE AS USAURIO_ACTUALIZA
				
			from 
				LICITACIONES L
				LEFT JOIN documento_licitaciones dl on dl.nro_licitacion = l.nro_licitacion
				LEFT JOIN documento d on d.nro_documento = dl.nro_documento
				LEFT JOIN USUARIOS u on u.ID_USUARIO = l.CREADO_POR
				LEFT JOIN USUARIOS u2 on u2.ID_USUARIO = l.ACTUALIZADO_POR
		    $where
			";


		//consulta paginada
		// $query = queryPagination($consulta, $this->page);
		// $result = oci_parse($this->pdo, $query);
		// oci_execute($result);
		// $listado = queryResultToAssoc($result);

		$listado = queryToArray($consulta,$this->pdo);

		//consulta para recuperar todos los numeros de licitaciones
		$query = "select NRO_LICITACION from licitaciones ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$numeros = queryResultToAssoc($result);


		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);

		if($result){
            $_SESSION["feedback"] = "Licitación ingresada correctamente";
		}
		
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		

		array_push($assoc, $listado);
		array_push($assoc, $numeros);
		array_push($assoc, $totales);
		array_push($assoc, $documentos);

		oci_close($this->pdo);
		return $assoc;
	}
}