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
	public $pdo;
	//filtro de licitacion
	private $id;
	//pagina 
	private  $page;
	//resultados por pagina
	private $resultados = 10;

	private $authUser; 

	//Constructor
	function __construct($pdo, string $id = '', int $page = 1){
		$this->pdo = $pdo;
		$this->id = $id;
		$this->page = $page;

        session_start();
        
        $query = "SELECT * FROM USUARIOS WHERE mail='".$_SESSION['mail']."'";


        $this->authUser = queryToArray($query,$pdo)[0];

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

        
        if($this->authUser['ID_PERMISO'] == 1 || $this->authUser['ID_PERMISO'] == 3 )
        {
            $where = 'where 1=1';
        } elseif($this->authUser['ID_PERMISO'] == 4 ) {

 

            $where = "WHERE c.id_contrato in (select id_contrato from contratos_asignacion where id_area = '".$this->authUser['ID_AREA']."')";
        
        }  
        
        
        else {

            $where = "WHERE c.ID_CARGO='".$this->authUser['ID_CARGO']."' ";

           
        }

        if ($this->id){
            $where .= " and c.ID_CONTRATO = '" . $this->id . "'";
        }

        if ($_GET['rut_proveedor']){
            $where .= " and p.RUT_PROVEEDOR = '" . $_GET['rut_proveedor'] . "'";
        }

        if ($_GET['cargos']){
            $where .= " and c.ID_CARGO = '" . $_GET['cargos'] . "'";
        }

        if ($_GET['licitacion']){
            $where .= " and c.NRO_LICITACION = '" . $_GET['licitacion'] . "'";
        }

        if ($_GET['objeto']){
            $where .= " and c.OBJETO_CONTRATO = '" . $_GET['objeto'] . "'";
        }

        if ($_GET['id_mercado_publico']){
            $where .= " and c.ID_MERCADO_PUBLICO = '" . $_GET['id_mercado_publico'] . "'";
        }

        //consulta principal
		$consulta = "
			select  
                c.*,  
                saldoContrato(c.ID_CONTRATO) as saldo,
				p.razon_social,
				d.nombre as nombre_documento,
			    d.NRO_DOCUMENTO,   
				d.tipo_archivo,
                d.archivo,
                m.nombre as nombre_moneda,
                m.equivalencia as equivalencia,
                ca.nombre as nombre_cargo,
                TOTAL_COMPRAS_CONTRATO(c.id_contrato) AS TOTAL,
                u.NOMBRE as USUARIO_CREA,
                u2.NOMBRE as USUARIO_ACTUALIZA,
			    a.AREA as asignado_a
			from 
				CONTRATOS C LEFT JOIN PROVEEDORES P ON c.rut_proveedor = p.rut_proveedor
				LEFT JOIN documento_contratos dc on dc.nro_contrato = c.id_contrato
                LEFT JOIN documento d on d.nro_documento = dc.nro_documento
                LEFT JOIN moneda m on m.codigo = c.id_moneda
                LEFT JOIN cargos ca on ca.id_cargo = c.id_cargo
               
                left join USUARIOS u on u.ID_USUARIO= c.CREADO_POR
                left join USUARIOS u2 on u2.ID_USUARIO= c.ACTUALIZADO_POR
                left join CONTRATOS_ASIGNACION ca on ca.ID_CONTRATO = c.ID_CONTRATO
                left join AREAS a on ca.ID_AREA = a.ID_AREA               
                
			$where
			ORDER BY
				c.id_contrato
            ";
            
           

		//consulta paginada
//		$query = queryPagination($consulta, $this->page);
//		$result = oci_parse($this->pdo, $query);
//		oci_execute($result);
//		$listado = queryResultToAssoc($result);

        $listado = queryToArray($consulta,$this->pdo);




		//se iteran todos los contrtos para añadirles las bitacoras
		$listado = array_map(function ($contrato){

            //consulta para recuperar todos las bitacoras
			$query = "select 
				documento.nombre AS DOCUMENTO,
				bitacora.* 
			from 
				BITACORA LEFT JOIN documento on bitacora.nro_documento = documento.nro_documento
			where 
				ID_CONTRATO='{$contrato['ID_CONTRATO']}'";
            $result = oci_parse($this->pdo, $query);
            oci_execute($result);
            $bitacoras = queryResultToAssoc($result);

            $contrato['BITACORAS'] = $bitacoras;


            //consulta para recuperar los detalles del contrato
            $query = "select 
                    c.id_contrato, 
                    de.*
                    
                from 
                    CONTRATOS C LEFT JOIN DETALLE_CONTRATO DE ON c.id_contrato = de.id_contrato
                    where 
                        C.ID_CONTRATO='{$contrato['ID_CONTRATO']}'";
            $result = oci_parse($this->pdo, $query);
            oci_execute($result);
            $detalles= queryResultToAssoc($result);

            $contrato['DETALLES'] = $detalles;

            $query = "select * from AREAS where ID_CARGO='{$contrato['ID_CARGO']}'";
            $areas = queryToArray($query,$this->pdo);

            $contrato['AREAS'] = $areas ?? [];

            $query = "select * from CONTRATOS_ASIGNACION where ID_CONTRATO='{$contrato['ID_CONTRATO']}'";
            $asignado = queryToArray($query,$this->pdo)[0];

            $contrato['ASIGNADO'] = $asignado ? 1 : 0;



            return $contrato;

		},$listado);


		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);


		oci_close($this->pdo);

		return [
		    'listado' => $listado,
		    'totales' => $totales
        ];
	}

    public function getDataListBox()
    {

        $query = "SELECT * FROM PROVEEDORES";
        $proveedores = queryToArray($query,$this->pdo);

        if($this->authUser['ID_PERMISO'] == 1 )
        {
            $where = 'where 1=1';
        } else {

            $where = "WHERE ID_CARGO='".$this->authUser['ID_CARGO']."' ";
           
        }

        $query = "SELECT * FROM CONTRATOS " .$where;
        $contratos = queryToArray($query,$this->pdo);

        $query = "SELECT * FROM LICITACIONES";
        $licitaciones = queryToArray($query,$this->pdo);

        $query = "SELECT * FROM CARGOS";
        $cargos = queryToArray($query,$this->pdo);

        return [
            'proveedores' => $proveedores,
            'contratos' => $contratos,
            'licitaciones' => $licitaciones,
            'cargos' => $cargos,
        ];
    }
    //elimina registro indicado
    public function saveBitacora(): self{


        if(isset($_FILES["archivo_bitacora"]) && $_FILES["archivo_bitacora"] != "") {

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

        $id_contrato= $_POST['id_contrato'];
        $glosa= $_POST['glosa'];


        //Consulta guarda bitacora
        $consulta = "
            INSERT INTO BITACORA (  
                    ID_CONTRATO, 
                    GLOSA, 
                    NRO_DOCUMENTO, 
                    FECHA_CREACION 
                )  
			VALUES (
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

        header("Location: ". base() . "/contratos");

    }


    public function asignar(): self{


        $id_contrato= $_POST['id_contrato'];
        $idArea= $_POST['area'];

        $consulta = "
            INSERT INTO CONTRATOS_ASIGNACION (  
                    ID_CONTRATO, 
                    ID_AREA 
                )  
			VALUES (
				'{$id_contrato}', 
				'{$idArea}'  
			)
	    ";



        $result = oci_parse($this->pdo, $consulta);
        oci_execute($result);
        oci_commit($this->pdo);

        if ($result){
            $_SESSION["feedback"] = "Contrato asignado correctamente";
        }



        header("Location: ". base() . "/contratos");

    }

}