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

		$sql = "DELETE FROM ORDEN_COMPRA WHERE NRO_ORDEN_COMPRA= '{$id}'";
			$result = oci_parse($this->pdo, $sql);
			oci_execute($result);
			oci_commit($this->pdo);
	
			return new self($this->pdo, '', $this->page);
	
	}

	

	//filtra consulta por nro de contrato (id, llave primaria)
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
		$codigos = [];
		$totales = [];
 
        $where = "WHERE 1=1 ";


        if ($_GET['id_contrato']){
            $where .= " and ID_CONTRATO = '" . $_GET['id_contrato'] . "'";
		}
		
		if ($_GET['nro_orden_compra']){
            $where .= " and NRO_ORDEN_COMPRA = '" . $_GET['nro_orden_compra'] . "'";
		}
		
		if ($_GET['estado']){
            $where .= " and ESTADO = '" . $_GET['estado'] . "'";
		}
		
		if ($_GET['total']){
            $where .= " and TOTAL = '" . $_GET['total'] . "'";
        }


		//consulta principal
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
		array_push($assoc, $codigos);
		array_push($assoc, $totales);

		oci_close($this->pdo);
		return $assoc;


	}

    

}