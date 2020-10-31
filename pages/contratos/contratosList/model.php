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
		$sql = $this->pdo->prepare("DELETE FROM licitaciones WHERE nro_licitacion = :nro_licitacion");
		$sql->execute(["nro_licitacion", $nro_licitacion]);
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
		$numeros = [];
		$totales = [];
		$contratos = [];


		if ($this->id){
			$where = " WHERE ID_CONTRATO = '" . $this->id . "'";
		}else{
			$where = "";
		}


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

		

		

		//consulta para recuperar razón social de la otra tabla
		$consulta = "
			select 
				c.*, 
				p.razon_social,
				d.nombre as nombre_documento
			from 
				CONTRATOS C LEFT JOIN PROVEEDORES P ON c.rut_proveedor = p.rut_proveedor
				LEFT JOIN documento_contratos dc on dc.nro_contrato = c.id_contrato
				LEFT JOIN documento d on d.nro_documento = dc.nro_documento
		
			";
		//consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);


		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		//consulta para recuperar todos los documentos
		$query = "select * from documento";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$documentos = queryResultToAssoc($result);

		
		// Arryas que forman la tabla principal con paginación
		array_push($assoc, $listado);
		array_push($assoc, $totales); 

		// Arrays que forman los listbox para filtros
		array_push($assoc, $proveedores);
		array_push($assoc, $cargos);
		array_push($assoc, $licitaciones);
		array_push($assoc, $contratos);
		array_push($assoc, $documentos);

		oci_close($this->pdo);
		return $assoc;
	}

    //elimina registro indicado
    public function saveBitacora(): self{


        if(isset($_FILES["archivo_bitacora"]) && $_FILES["archivo_bitacora"] != "") {

            $cons = "select documentos_sequence.nextval as NRO_DOCUMENTO from dual";
            $result = oci_parse($this->pdo, $cons);
            oci_execute($result);
            $nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];
            // print_r($nro_documento);

            $directorio = "uploads/";
            $archivo = $directorio . basename($_FILES["archivo_bitacora"]["name"]);
            $tipo = $_FILES["archivo_bitacora"]["type"];
            $peso = $_FILES["archivo_bitacora"]["size"];

            $pdf = file_get_contents($_FILES['archivo_bitacora']['tmp_name']);


            move_uploaded_file($_FILES["archivo_bitacora"]["tmp_name"], $archivo);

            //consulta de inserción

            $consulta = "INSERT into DOCUMENTO (NRO_DOCUMENTO, TIPO_DOCUMENTO, NOMBRE, ARCHIVO, PESO_ARCHIVO, TIPO_ARCHIVO, FECHA_CREACION) values (
						'" . $nro_documento . "',
						'co',
						'" . $archivo . "',
						empty_blob(),
						'" . $peso . "',
						'" . $tipo . "',
						TO_DATE('" . date('yy-m-d') . "','yyyy-mm-dd'))
						RETURNING archivo INTO :archivo";

            //ejecucion consulta
            $query = $consulta;
            $result = oci_parse($this->pdo, $query);

            $blob = oci_new_descriptor($this->pdo, OCI_D_LOB);
            oci_bind_by_name($result, ":archivo", $blob, -1, OCI_B_BLOB);
            //print_r($consulta);
            oci_execute($result, OCI_DEFAULT) or die ("Unable to execute query");

            if (!$blob->save($archivo)) {
                oci_rollback($this->pdo);
            } else {
                oci_commit($this->pdo);
            }

            oci_free_statement($result);
            $blob->free();
        }

        $id_contrato= $_POST['id_contrato'];
        $glosa= $_POST['glosa'];


        //Consulta guarda bitacora
        $consulta = "
            INSERT INTO BITACORA ( 
                    ID, 
                    ID_CONTRATO, 
                    GLOSA, 
                    NRO_DOCUMENTO, 
                    FECHA_CREACION 
                ) 
			VALUES (
			    1,
				'{$id_contrato}', 
				'{$glosa}',  
				$nro_documento, 
				TO_DATE('2020-10-19 00:00:00', 'YYYY-MM-DD HH24:MI:SS')  
			)
	    ";


        $result = oci_parse($this->pdo, $consulta);

        if($result){
            $_SESSION["feedback"] = "Contrato ingresado correctamente";
        }

        oci_execute($result);

        oci_commit($this->pdo);

        return new self($this->pdo, $this->id, $this->page);

    }

}