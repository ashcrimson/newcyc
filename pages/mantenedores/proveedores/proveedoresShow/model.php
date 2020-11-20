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
	
	private $id;


    //Constructor
    function __construct($pdo, $id = ''){
        $this->pdo = $pdo;
        $this->id = $id;

    }

	//retorna el/los datos seleccionados
	public function show($id)
    {
        return new self($this->pdo, $id);
    }

    

    public function get(){
 
        $query = "SELECT * FROM PROVEEDORES WHERE RUT_PROVEEDOR='" . $this->id. "'";

        //consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
		$proveedor = queryResultToAssoc($result)[0];
		
		$query = "SELECT * FROM PROVEEDORES_CONTACTO WHERE RUT_PROVEEDOR='" . $this->id . "'";

		//consulta paginada
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $proveedor['CONTACTO'] = queryResultToAssoc($result);

        return $proveedor;
    }

    

	}


 