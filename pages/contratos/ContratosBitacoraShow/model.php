<?php
 


namespace ContratosBitacoraShow;


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
		$this->id = $_GET["id"];
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


        $consulta = "select 
				documento.nombre AS DOCUMENTO,
				bitacora.*, 
                u.NOMBRE as USUARIO_CREA,
                u2.NOMBRE as USUARIO_ACTUALIZA
			from 
				BITACORA LEFT JOIN documento on bitacora.nro_documento = documento.nro_documento
                left join USUARIOS u on u.ID_USUARIO= bitacora.CREADO_POR
                left join USUARIOS u2 on u2.ID_USUARIO= bitacora.ACTUALIZADO_POR   
			where 
				ID_CONTRATO='" . $this->id . "' ".$where;


        //consulta paginada
        $query = queryPagination($consulta, $this->page);
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);
        $listado = queryResultToAssoc($result);


        $contrato['BITACORAS'] = $listado;

        //consulta para recuperar cantidad de páginas disponibles
        $result = oci_parse($this->pdo, $consulta);
        oci_execute($result);
        $totales = queryResultToAssoc($result);

        $contrato['TOTAL_DETALLES'] = $totales;

        // exit();
        return $contrato;
    }

    public function saveBitacora(){

        $nro_documento="NULL";
        $userId = authUser($this->pdo)['ID_USUARIO'];


        if($_FILES["archivo_bitacora"]["error"] == 0){

            $cons = "select documentos_sequence.nextval as NRO_DOCUMENTO from dual";
            $result = oci_parse($this->pdo, $cons);
            oci_execute($result);
            $nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];
            // print_r($nro_documento);

            
            $archivo = basename($_FILES["archivo_bitacora"]["name"]);
            $tipo = $_FILES["archivo_bitacora"]["type"];
            $peso = $_FILES["archivo_bitacora"]["size"];

            $pdf = file_get_contents($_FILES['archivo_bitacora']['tmp_name']);



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

            if (!$blob->save($pdf)) {
                oci_rollback($this->pdo);
            } else {
                oci_commit($this->pdo);
            }

            oci_free_statement($result); 
            $blob->free();
        }


        //Consulta guarda bitacora
        $query = "
            INSERT INTO 
                BITACORA (  
                    ID_CONTRATO, 
                    GLOSA, 
                    NRO_DOCUMENTO, 
                    FECHA_CREACION, 
                    CREADO_POR 
                )  
			VALUES (
				'{$_POST['id_contrato']}', 
				'{$_POST['glosa']}',  
				{$nro_documento}, 
				SYSDATE,
			    {$userId}    
			)
        ";

        $result = oci_parse($this->pdo, $query);

        if (oci_execute($result)){
            oci_commit($this->pdo);
            flash('Bitácora ingresada correctamente')->success();
        }else{
            oci_rollback($this->pdo);
            $error = oci_error($result);
            flash($error['message'])->error();
            redirect("/contratos/bitacora/show?id=".$_POST['id_contrato']);
        }


        oci_close($this->pdo);

        redirect( "/contratos/bitacora/show?id=".$_POST['id_contrato']);

    }




}