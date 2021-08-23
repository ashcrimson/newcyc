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
    private $descripcion;

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

            if(isset($_POST["descripcion"]) && $_POST["descripcion"] != ""){
				$this->params .= "descripcion" . $_POST["descripcion"] . "&";
				$this->total = $_POST["descripcion"];
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


        $query = "
            select 
                cd.CODIGO,
                cd.DESC_PROD_SOLI || ' / ' || cd.PRESENTACION_PROD_SOLI  DESCRIPCION,
                od.CANTIDAD,
                od.PRECIO,
                od.PRECIO * od.CANTIDAD as subtotal
            from 
                ORDEN_COMPRA_DETALLES od inner join DETALLE_CONTRATO cd on od.CODIGO_DETALLE_CONTRATO=cd.CODIGO
            where 
                od.NRO_ORDEN_COMPRA='{$this->nro_orden_compra}'
        ";

        $detalles = queryToArray($query,$this->pdo);


        $ordenCompra['detalles_compra'] = $detalles ?? [];



		return $ordenCompra;
	

	}

	public function getContratos(){

		$query = "SELECT * FROM CONTRATOS order by ID_CONTRATO asc";

		$contratos = queryToArray($query,$this->pdo);

		$res = [];

        foreach ($contratos as $index => $contrato) {

            $nombre = $contrato['TIPO'].$contrato['ID_CONTRATO']." / ".$contrato['ID_MERCADO_PUBLICO'];

            $res[] = [
                'id' => $contrato['ID_CONTRATO'],
                'nombre' => utf8_encode($nombre),
            ];
		}


		return $res;
	}


	public function execute(){

	    $detalles = json_decode($_POST['detalles']);


	    $actualiza = false;
        $tienDetalles = count($detalles) > 0 ? 1 : 0;
        $userId = authUser($this->pdo)['ID_USUARIO'];
        $total = $tienDetalles ? $_POST['total'] : $_POST['total_campo'];
		
		//validar si faltó algo
		if(!$this->error)
		{
			if(isset($_POST["id"]) && $_POST["id"] != "") {
				$query = "
                    UPDATE ORDEN_COMPRA SET 
						NRO_ORDEN_COMPRA='" . $_POST['nro_orden_compra'] . "', 
						ID_CONTRATO='" . $_POST['id_contrato'] . "', 
						FECHA_ENVIO=SYSDATE, 
						TOTAL='". $total ."',  
						ESTADO='" . $_POST['estado'] . "', 
						FECHA_CREACION=SYSDATE, 
						FECHA_ACTUALIZACION=SYSDATE, 
						FECHA_ELIMINACION=SYSDATE,
						CODIGO='" . $_POST['detalle_contrato'] . "',
						CANTIDAD='" . $_POST['cantidad'] . "',
                        DESCRIPCION='" . $_POST['descripcion'] . "',
                        TIENE_DETALLES='" . $_POST['tiene_detalles'] . "',
                        ACTUALIZADO_POR ='{$userId}'
					WHERE 
						NRO_ORDEN_COMPRA='" . $_POST['id'] . "'
                ";

                $result = oci_parse($this->pdo, $query);


                if (oci_execute($result)){
                    oci_commit($this->pdo);
                    flash("Orden de compra actualizada correctamente")->success();
                    $actualiza=true;
                }else{
                    oci_rollback($this->pdo);
                    $error = oci_error($result);
                    flash($error['message'])->error();
                    redirect('/ordenCompra/new');
                }


               
			}
			else{

			    $query = "
			        INSERT INTO 
                        ORDEN_COMPRA(
                            NRO_ORDEN_COMPRA, 
                            ID_CONTRATO, 
                            FECHA_ENVIO, 
                            TOTAL, 
                            ESTADO, 
                            FECHA_CREACION, 
                            DESCRIPCION, 
                            TIENE_DETALLES, 
                            CREADO_POR 
                        ) 
                        VALUES(
                            '{$this->nro_orden_compra}', 
                            {$this->id_contrato}, 
                            SYSDATE, 
                            {$total}, 
                            '{$this->estado}', 
                            SYSDATE, 
                            '{$_POST['descripcion']}', 
                            {$tienDetalles}, 
                            {$userId}
                        )
			    ";


                $result = oci_parse($this->pdo, $query);


                if (oci_execute($result)){
                    oci_commit($this->pdo);
                    flash("Orden de compra ingresada correctamente")->success();
                }else{
                    oci_rollback($this->pdo);
                    $error = oci_error($result);
                    flash($error['message'])->error();
                    redirect('/ordenCompra/new');
                }

                if ($tienDetalles){
                    $this->agregarDetalles($detalles,$this->nro_orden_compra);
                }



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

//            $id = $_GET['nro_orden_compra'] ?? $_POST['nro_orden_compra'];


            redirect('/ordenCompra');;
		}else{

            unset($_POST['id']);
            unset($_POST['submit']);

            $data = http_build_query($_POST);

            flash(errorsToList($this->errores))->error();
            redirect('/ordenCompra/new/?'.$data);
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


    public function agregarDetalles($detlles,$nro_orden_compra)
    {

        foreach ($detlles as $index => $detlle) {
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
                    '{$nro_orden_compra}', 
                    '".$detlle->id."', 
                    TO_NUMBER('".$detlle->cantidad."'),
                    TO_NUMBER('".$detlle->precio."'),
                    SYSDATE
                     
                )
            ";


            $result = oci_parse($this->pdo, $query);
            oci_execute($result);


            //query cantidad total detalle contrato
            $query="
              update DETALLE_CONTRATO set SALDO=SALDO-to_number('".$detlle->cantidad."') where CODIGO='".$detlle->id."'
            ";


            $result = oci_parse($this->pdo, $query);
            oci_execute($result);
        }



	}
	
}