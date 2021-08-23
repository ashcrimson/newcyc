<?php


 
namespace OrdenCompraShow;


use function Couchbase\passthruDecoder;

/**
 * modelo de lista de  licitaciones
 */
class ModelOrdenCompraShow {

	private $pdo;

	private $id;


	//Constructor
	function __construct($pdo){
                 
		$this->pdo = $pdo;
		$this->id = $_GET["id"];
	}

	public function get(){


        $consulta = "
			select 
				o.*, 
				d.nombre as nombre_documento,
				d.NRO_DOCUMENTO,   
				d.tipo_archivo,
				d.archivo,
				c.tipo,
			    u.NOMBRE as USUARIO_CREA,
				u2.NOMBRE AS USAURIO_ACTUALIZA
			from 
				ORDEN_COMPRA O 
				LEFT JOIN documento_orden_compra do on do.nro_orden_compra = o.nro_orden_compra
				LEFT JOIN documento d on d.nro_documento = do.nro_documento
				left join contratos c on c.id_contrato = o.id_contrato
                LEFT JOIN USUARIOS u on u.ID_USUARIO = o.CREADO_POR
                LEFT JOIN USUARIOS u2 on u2.ID_USUARIO = o.ACTUALIZADO_POR
			where 
			    o.nro_orden_compra = '{$this->id}'
				
				
			";

        $orden = queryToArray($consulta,$this->pdo)[0];

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
                od.NRO_ORDEN_COMPRA='{$this->id}'
        ";

        $detalles = queryToArray($query,$this->pdo);

        $orden['DETALLES'] = $detalles;

//        dd($orden);

        return $orden;

	}

	public function anula()
    {


        $query = "
            select  
                *
            from 
                ORDEN_COMPRA_DETALLES 
            where 
                NRO_ORDEN_COMPRA='{$_GET['nro_orden_compra']}'";

        $detalles = queryToArray($query,$this->pdo);

        foreach ($detalles as $index => $detalle) {
            $query="
                update DETALLE_CONTRATO set SALDO=SALDO+to_number('".$detalle['CANTIDAD']."') where CODIGO='".$detalle['CODIGO_DETALLE_CONTRATO']."'
            ";

            $result = oci_parse($this->pdo, $query);
            oci_execute($result);
        }

        //query actualizar el campo total de la compra
        $query="
            update 
                ORDEN_COMPRA 
            set 
                ESTADO='Anulada' 
            where 
                NRO_ORDEN_COMPRA='".$_GET['nro_orden_compra']."'
        ";

        $result = oci_parse($this->pdo, $query);
        oci_execute($result);


        oci_commit($this->pdo);
        oci_close($this->pdo);

        flash("Orden de compra anulada")->success();

        redirect('/ordenCompra');
    }

	
}