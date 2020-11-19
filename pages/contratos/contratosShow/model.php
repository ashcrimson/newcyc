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




    //Constructor
    function __construct($pdo, $id = ''){
        $this->pdo = $pdo;
        $this->id = $id;

    }

    public function show($id)
    {
        return new self($this->pdo, $id);
    }



    public function get(){

        $query = "SELECT * FROM CONTRATOS WHERE ID_CONTRATO='" . $this->id . "'";

        //consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $contrato = queryResultToAssoc($result)[0];

        $query = "SELECT * FROM DETALLE_CONTRATO WHERE ID_CONTRATO='" . $this->id . "'";

        //consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $contrato['DETALLES'] = queryResultToAssoc($result);

        // var_dump($contrato);
        // exit();
        return $contrato;
    }




}