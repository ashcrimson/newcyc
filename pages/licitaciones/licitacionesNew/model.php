<?php



namespace LicitacionesNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelLicitaciones {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $errores = [];


	//Constructor
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	//retorna el/los datos seleccionados
	public function new(){
		error_reporting(0);

		if(isset($_POST["submit"])){

			if($_POST["nro_licitacion"]=='' ?? false){
				$this->errores[] = "llene el campo ID Licitación";
			}

            if($_POST["presupuesto"]=='' ?? false){
                $this->errores[] = "llene el campo presupuesto";
            }


            if($_POST["descripcion_licitacion"]=='' ?? false){
                $this->errores[] = "llene el campo descripción ";
            }


			if(isset($_FILES["archivo_licitacion"]) && $_FILES['archivo_licitacion']['error']==UPLOAD_ERR_NO_FILE){
//				$this->errores[] = "No se cargo ningun archivo";
			}

		}

		return new self($this->pdo);

	}

	public function execute(){

	    $user = authUser($this->pdo);

	    //validar si faltó algo
		if(count($this->errores) > 0){


            unset($_POST['id']);
            unset($_POST['submit']);

            $data = http_build_query($_POST);

            flash(errorsToList($this->errores))->error();
            redirect('/licitaciones/new/?'.$data);
			
		}else{



            if($_POST["id"] ?? false){

                //consulta de inserción
                $query = "
                    UPDATE 
                        LICITACIONES 
	                SET     
	                    NRO_LICITACION='{$_POST['nro_licitacion']}', 
	                    DETALLE='{$_POST['descripcion_licitacion']}', 
	                    PRESUPUESTO={$_POST['presupuesto']}, 
	                    FECHA_ACTUALIZACION=SYSDATE, 
	                    ACTUALIZADO_POR={$user['ID_USUARIO']}
	                WHERE
                        NRO_LICITACION='{$_POST['id']}'
    
                ";


                $result = oci_parse($this->pdo, $query);

                if (oci_execute($result)){
                    oci_commit($this->pdo);
                    flash('Licitación ingresada correctamente')->success();
                }else{
                    oci_rollback($this->pdo);
                    $error = oci_error($result);
                    flash($error['message'])->error();
                    redirect('/licitaciones/new');
                }

            }else{

                //consulta de inserción
                $query = "
        
                    INSERT INTO LICITACIONES(
                        NRO_LICITACION, 
                        DETALLE, 
                        PRESUPUESTO, 
                        FECHA_CREACION, 
                        CREADO_POR 
                    ) 
                    VALUES(
                        '{$_POST['nro_licitacion']}', 
                        '{$_POST['descripcion_licitacion']}', 
                        {$_POST['presupuesto']}, 
                        SYSDATE, 
                        {$user['ID_USUARIO']}
                    )
    
                ";



                $result = oci_parse($this->pdo, $query);

                if (oci_execute($result)){
                    oci_commit($this->pdo);
                    flash('Licitación actualizada correctamente')->success();
                }else{
                    oci_rollback($this->pdo);
                    $error = oci_error($result);
                    flash($error['message'])->error();
                    redirect('/licitaciones/new');
                }

            }

		}

		if(isset($_FILES["archivo_licitacion"]) && $_FILES["archivo_licitacion"] != ""){
				
			$cons = "select documentos_sequence.nextval as NRO_DOCUMENTO from dual";
			$result = oci_parse($this->pdo, $cons);
			oci_execute($result);
			$nro_documento = queryResultToAssoc($result)[0]["NRO_DOCUMENTO"];
			// print_r($nro_documento);

			
			$archivo = basename($_FILES["archivo_licitacion"]["name"]);
			$tipo = $_FILES["archivo_licitacion"]["type"];
			$peso = $_FILES["archivo_licitacion"]["size"];
			
			$pdf = file_get_contents($_FILES['archivo_licitacion']['tmp_name']);


			//consulta de inserción
		
			$consulta = "INSERT into DOCUMENTO (NRO_DOCUMENTO, TIPO_DOCUMENTO, NOMBRE, ARCHIVO, PESO_ARCHIVO, TIPO_ARCHIVO, FECHA_CREACION) values (
						'". $nro_documento ."',
						'rl',
						'". $archivo ."',
						empty_blob(),
						'". $peso ."',
						'". $tipo ."',
						TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'))
						RETURNING archivo INTO :archivo";

			//ejecucion consulta
			$query = $consulta;
			$result = oci_parse($this->pdo, $query);

			if($result){
				$_SESSION["feedback"] = "Licitación ingresada correctamente";
			}

			$blob = oci_new_descriptor($this->pdo, OCI_D_LOB);
			oci_bind_by_name($result, ":archivo", $blob, -1, OCI_B_BLOB);
			//print_r($consulta);
			oci_execute($result, OCI_DEFAULT);

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

			$consulta2 = "INSERT into DOCUMENTO_LICITACIONES (NRO_DOCUMENTO, NRO_LICITACION) values (
				'". $nro_documento ."',
				'". $this->nro_licitacion ."'
			)";

			$query2 = $consulta2;
			$result2 = oci_parse($this->pdo, $query2);
			oci_execute($result2, OCI_DEFAULT);
		}


		oci_close($this->pdo);

        redirect('/licitaciones');

	}

    public function get(){

        $query = "SELECT * FROM LICITACIONES WHERE NRO_LICITACION='{$_GET['id']}'";

        $licitacion = queryToArray($query,$this->pdo)[0];

        return $licitacion;
    }
}