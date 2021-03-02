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

	
}