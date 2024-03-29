<?php
 


namespace ContratosShow;


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

    public function show($id)
    {
        return new self($this->pdo, $id);
    }

    //filtra consulta por nro de contrato (id, llave primaria)
	public function getId($id): self{
        return new self($this->pdo, $id, $this->page);
	}

    //filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->id, $page);
	}



    public function get(){

        $query = "SELECT * FROM CONTRATOS WHERE ID_CONTRATO='" . $this->id . "'";

        //consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $contrato = queryResultToAssoc($result)[0];


        $where = '';
 
 
        if ($_GET['codigo']){
            $where .= " and CODIGO = '" . $_GET['codigo'] . "'";
        }


        $consulta = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO='" . $this->id . "' ".$where;


        //consulta paginada
        $query = queryPagination($consulta, $this->page);
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $listado = queryResultToAssoc($result);


        $contrato['DETALLES'] = $listado;

        //consulta para recuperar cantidad de páginas disponibles
        $result = oci_parse($this->pdo, $consulta);
        oci_execute($result);
        $totales = queryResultToAssoc($result);

        $contrato['TOTAL_DETALLES'] = $totales;

        // exit();
        return $contrato;
    }

    // public function suma(){
    //     $where = '';

 
    //     if ($_GET['codigo']){
    //         $where .= " and CODIGO = '" . $_GET['codigo'] . "'";
    //     }
    //     $consulta="SELECT
    //         SUM( PRECIO_U_BRUTO )AS SUMA
    //         FROM
    //             DETALLE_CONTRATO
    //         WHERE
    //             ID_CONTRATO='" . $this->id . "' ".$where;
    //         $result = oci_parse($this->pdo, $query);
    //         oci_execute($result);
    //         $suma = queryResultToAssoc($result);

    //         dd($consulta);

    //         return $suma;
    // }




}