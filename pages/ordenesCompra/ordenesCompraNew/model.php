<?php


 
namespace OrdenCompraNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelOrdenCompra {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";
	private $feedback = "";

	private $nro_orden_compra;
	private $id_contrato;
	private $estado;
	private $total;
	private $archivo_orden_compra;
	private $nro_documento;
	private $archivo_nombre;
	private $fecha_creacion;
	private $pdf;
	private $detalle_contrato;
	private $cantidad;

	//Constructor
	function __construct($pdo, $nro_orden_compra = ''){
                 
		$this->pdo = $pdo;
		$this->nro_orden_compra = $_GET["nro_orden_compra"];
	}

	//retorna el/los datos seleccionados
	public function new(){

		$result = [];
		$assoc = [];
		$listado = [];


		//validacion de datos recibidos
		$params = "";
		if(isset($_POST["submit"])){

			if(isset($_POST["nro_orden_compra"]) && $_POST["nro_orden_compra"] != ""){
				$this->params .= "nro_orden_compra" . $_POST["nro_orden_compra"] . "&";
				$this->nro_orden_compra = $_POST["nro_orden_compra"];
			}else{
				// $this->errores["nro_orden_compra"] = true;
				// $this->error = true;
			}

			if(isset($_POST["id_contrato"]) && $_POST["id_contrato"] != ""){
				$this->params .= "id_contrato" . $_POST["id_contrato"] . "&";
				$this->id_contrato = $_POST["id_contrato"];
			}else{
				// $this->errores[] = "No mando el id del contrato";
				// $this->error = true;
			}

			if(isset($_POST["detalle_contrato"]) && $_POST["detalle_contrato"] != ""){
				$this->params .= "detalle_contrato" . $_POST["detalle_contrato"] . "&";
				$this->detalle_contrato = $_POST["detalle_contrato"];
			}else{
				// $this->errores[] = "No mando el id del contrato";
				// $this->error = true;
			}

			if(isset($_POST["cantidad"]) && $_POST["cantidad"] != ""){
				$this->params .= "cantidad" . $_POST["cantidad"] . "&";
				$this->cantidad = $_POST["cantidad"];
			}else{
				// $this->errores[] = "No mando el id del contrato";
				// $this->error = true;
			}

			if(isset($_POST["estado"]) && $_POST["estado"] != ""){
				$this->params .= "estado" . $_POST["estado"] . "&";
				$this->estado = $_POST["estado"];
			}else{
				// $this->errores[] = "No mando el estado";
				// $this->error = true;
			}

			if(isset($_POST["total"]) && $_POST["total"] != ""){
				$this->params .= "total" . $_POST["total"] . "&";
				$this->total = $_POST["total"];
			}else{
				// $this->errores[] = "No mando el total";
				// $this->error = true;
			}

			if(isset($_POST["archivo_orden_compra"]) && $_POST["archivo_orden_compra"] != ""){
				$params .= "archivo_orden_compra=" . $_POST["archivo_orden_compra"] . "&";
			}else{
				$errores["archivo_orden_compra"] = true;
				$error = true;
			}
			
		}

		return new self($this->pdo);

	}

	public function edit($nro_orden_compra)
    {  
          
          return new self($this->pdo, $nro_orden_compra);
	}

	public function get(){
		
		
		$query = "SELECT * FROM ORDEN_COMPRA WHERE NRO_ORDEN_COMPRA='" . $this->nro_orden_compra . "'";

		$ordenCompra = queryToArray($query,$this->pdo)[0];

		$ordenCompra['detalles_contrato'] = [];


        $query = 'select * from detalle_contrato where id_contrato='.$ordenCompra['ID_CONTRATO'];

        $result = queryToArray($query,$this->pdo);

        if ($result){
            $detalles = [];

            foreach ($result as $index => $item) {
                $codigo = $item['CODIGO'];
                $nombre = $item['DESC_PROD_SOLI']." / ".$item['DESC_TEC_PROD_OFERTADO'];
                $precio = $item['PRECIO_U_BRUTO'];
                $saldo = $item['SALDO'];

                $detalles[] = ['value' => $codigo,'text' => $nombre,'precio' => $precio,'saldo' => $saldo];
            }

            $ordenCompra['detalles_contrato'] = $detalles;

        }


        $query = "select 
                    * 
                from 
                    orden_compra_detalles do inner join detalle_contrato dc on dc.codigo=do.codigo_detalle_contrato 
                where 
                    NRO_ORDEN_COMPRA='" . $this->nro_orden_compra . "'";

        $result = queryToArray($query,$this->pdo);


        $ordenCompra['detalles_compra'] = $result ?? [];



		return $ordenCompra;
	

	}

	public function getContratos(){

		$query = "SELECT * FROM CONTRATOS order by ID_CONTRATO asc";


		return queryToArray($query,$this->pdo);;
	}


	public function execute(){

		
		//validar si faltó algo
		if(!$this->error)
		{
			if(isset($_POST["id"]) && $_POST["id"] != "") {
				$query = "
                    UPDATE ORDEN_COMPRA SET 
						NRO_ORDEN_COMPRA='" . $_POST['nro_orden_compra'] . "', 
						ID_CONTRATO='" . $_POST['id_contrato'] . "', 
						FECHA_ENVIO=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), 
						TOTAL='" . $_POST['total'] . "', 
						ESTADO='" . $_POST['estado'] . "', 
						FECHA_CREACION=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), 
						FECHA_ACTUALIZACION=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), 
						FECHA_ELIMINACION=TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
						CODIGO='" . $_POST['detalle_contrato'] . "',
						CANTIDAD='" . $_POST['cantidad'] . "'
					WHERE 
						NRO_ORDEN_COMPRA='" . $_POST['id'] . "'
                ";


                $result = oci_parse($this->pdo, $query);

                if($result){
                    flash("Orden de compra actualizada correctamente")->success();
                }

                oci_execute($result);

               
			}
			else{
			

				$consulta = "INSERT INTO ORDEN_COMPRA VALUES (
					'". $this->nro_orden_compra ."', 
					'". $this->id_contrato ."', 
					TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'),
					'". $this->total ."', 
					'". $this->estado ."', 
					TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
					TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
					TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
					'". $this->detalle_contrato ."',
					'". $this->cantidad ."'
					
					)";

				//ejecucion consulta
				$query = $consulta;
				$result = oci_parse($this->pdo, $query);

				if($result){

					flash("Orden de compra ingresada correctamente")->success();
				}
				//print_r($consulta);
				oci_execute($result);


			}

            if($_FILES["archivo_orden_compra"]["error"] == 0){


                $cons = "select documentos_sequence.nextval as NRO_DOCUMENTO from dual";
                $result = oci_parse($this->pdo, $cons);
                oci_execute($result);
                $nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];

                $archivo = basename($_FILES["archivo_orden_compra"]["name"]);
                $tipo = $_FILES["archivo_orden_compra"]["type"];
                $peso = $_FILES["archivo_orden_compra"]["size"];

                $pdf = file_get_contents($_FILES['archivo_orden_compra']['tmp_name']);

                //consulta de inserción
                //$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
                $consulta = "INSERT into DOCUMENTO (NRO_DOCUMENTO, TIPO_DOCUMENTO, NOMBRE, ARCHIVO, PESO_ARCHIVO, TIPO_ARCHIVO, FECHA_CREACION) values (
						'". $nro_documento ."',
						'oc',
						'". $archivo ."',
						empty_blob(),
						'". $peso ."',
						'". $tipo ."',
						TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'))
						RETURNING archivo INTO :archivo";

                //ejecucion consulta
                $query = $consulta;
                $result = oci_parse($this->pdo, $query);

                $blob = oci_new_descriptor($this->pdo, OCI_D_LOB);
                oci_bind_by_name($result, ":archivo", $blob, -1, OCI_B_BLOB);
                //print_r($consulta);
                oci_execute($result, OCI_DEFAULT) or die ("Unable to execute query");

                if(!$blob->save($pdf)) {
                    oci_rollback($this->pdo);
                }
                else {
                    oci_commit($this->pdo);
                }

                oci_free_statement($result);
                $blob->free();
                //OJOOOOOOOOOOOOOO
                //DESPUES DE INSERTAR EL BLOB
                ////Guardar en lka tbla documento_lictacion
                ///LA RELACION DE ESTE DOCUMENTO $nro_documento ----> id y  $this->nro_licitacion ---> nro_lictacion

                $consulta2 = "INSERT into DOCUMENTO_ORDEN_COMPRA (NRO_DOCUMENTO, NRO_ORDEN_COMPRA) values (
				'". $nro_documento ."',
				'". $this->nro_orden_compra ."'
			)";

                $query2 = $consulta2;
                $result2 = oci_parse($this->pdo, $query2);
                oci_execute($result2, OCI_DEFAULT) or die ("No se pudo");
            }


            oci_commit($this->pdo);
            oci_close($this->pdo);

            $id = $_GET['nro_orden_compra'] ?? $_POST['nro_orden_compra'];

            redirect('/ordenCompra/new?nro_orden_compra='.$id);
		}else{

			foreach($this->errores as $e){
				echo $e."<br>";
			}
			// header("Location: ". base() . "/ordenCompra/new?" . $params);
			die();
		}


		
		
	}


    public function getErrors()
    {
        return $this->errores;
	}

    public function hayErrores()
    {
        return $this->error;
	}

    public function getId()
    {
        return $this->nro_orden_compra;
	}

    public function detalleDelete()
    {

        $query = "delete from orden_compra_detalles WHERE id=".$_GET['id'];
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);

        $query = "
            select  
                sum(CANTIDAD*PRECIO) as total
            from 
                ORDEN_COMPRA_DETALLES 
            where 
                NRO_ORDEN_COMPRA='".$_GET['nro_orden_compra']."' group by 1";

        $total = queryToArray($query,$this->pdo)[0]['TOTAL'];

        //query actualizar el campo total de la compra
        $query="
            update 
                ORDEN_COMPRA 
            set 
                TOTAL=TO_NUMBER('".$total."') 
            where 
                NRO_ORDEN_COMPRA='".$_GET['nro_orden_compra']."'
        ";

        $result = oci_parse($this->pdo, $query);
        oci_execute($result);

        //query cantidad total detalle contrato
        $query="
          update DETALLE_CONTRATO set SALDO=SALDO+to_number('".$_GET['cantidad']."') where CODIGO='".$_GET['codigo']."'
        ";



        $result = oci_parse($this->pdo, $query);
        oci_execute($result);


        oci_commit($this->pdo);
        oci_close($this->pdo);

        flash("Detalle eliminado")->success();

        redirect('/ordenCompra/new?nro_orden_compra='.$_GET['nro_orden_compra']);
	}

	public function detalleAdd()
    {

        $query = "
            INSERT INTO 
                ORDEN_COMPRA_DETALLES(
                    ID,
                    NRO_ORDEN_COMPRA, 
                    CODIGO_DETALLE_CONTRATO, 
                    CANTIDAD, 
                    PRECIO, 
                    FECHA_CREACION
                ) 
            VALUES(
                0,
                '".$_GET['nro_orden_compra']."', 
                '".$_GET['detalle_contrato']."', 
                TO_NUMBER('".$_GET['cantidad']."'),
                TO_NUMBER('".$_GET['precio']."'),
                SYSDATE 
            )
        ";


        $result = oci_parse($this->pdo, $query);

        oci_execute($result);

        $query = "
            select  
                sum(CANTIDAD*PRECIO) as total
            from 
                ORDEN_COMPRA_DETALLES 
            where 
                NRO_ORDEN_COMPRA='".$_GET['nro_orden_compra']."' group by 1";

        $total = queryToArray($query,$this->pdo)[0]['TOTAL'];


        //query actualizar el campo total de la compra
        $query="
            update 
                ORDEN_COMPRA 
            set 
                TOTAL=TO_NUMBER('".$total."') 
            where 
                NRO_ORDEN_COMPRA='".$_GET['nro_orden_compra']."'
        ";

        $result = oci_parse($this->pdo, $query);
        oci_execute($result);


        //query cantidad total detalle contrato
        $query="
          update DETALLE_CONTRATO set SALDO=SALDO-to_number('".$_GET['cantidad']."') where CODIGO='".$_GET['detalle_contrato']."'
        ";

        $result = oci_parse($this->pdo, $query);
        oci_execute($result);

        oci_commit($this->pdo);
        oci_close($this->pdo);

        flash("Detalle agregado")->success();

        redirect('/ordenCompra/new?nro_orden_compra='.$_GET['nro_orden_compra']);
	}
	
}