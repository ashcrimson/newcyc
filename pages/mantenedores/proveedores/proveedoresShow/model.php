<?php
  
 

namespace ProveedoresShow;
 

/**
 * modelo de lista de  licitaciones
 */
class ModelProveedores {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	
	private $rut;


    //Constructor
    function __construct($pdo, $rut = ''){
        $this->pdo = $pdo;
        $this->rut = $rut;

    }

	//retorna el/los datos seleccionados
	public function show($rut)
    {
        return new self($this->pdo, $rut);
    }

    

    public function get(){
 
        $query = "SELECT * FROM PROVEEDORES WHERE RUT_PROVEEDOR='" . $this->rut. "'";

        //consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
		$proveedor = queryResultToAssoc($result)[0];
		
		$query = "SELECT * FROM PROVEEDORES_CONTACTO WHERE RUT_PROVEEDOR='" . $this->rut . "'";

		//consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $proveedor['CONTACTO'] = queryResultToAssoc($result);

        return $proveedor;
    }

    

	}


 