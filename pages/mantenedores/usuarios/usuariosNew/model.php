<?php



namespace UsuariosNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelUsuarios {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	public $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";
	private $feedback = "";

	private $nombre;
	private $mail;
	private $anexo;
	private $id;




	//Constructor
	function __construct($pdo,$id= null){
		$this->pdo = $pdo;
        $this->id = $id;
	}

	//retorna el/los datos seleccionados
	public function new(){

		$result = [];
		$assoc = [];
		$listado = [];


		//validacion de datos recividos
		$params = "";
		if(isset($_POST["submit"])){

			if(isset($_POST["nombre"]) && $_POST["nombre"] != ""){
				$this->params .= "nombre" . $_POST["nombre"] . "&";
				$this->nombre = $_POST["nombre"];
			}else{
				// $this->errores["id_contrato"] = true;
				// $this->error = true;
			}

			if(isset($_POST["email"]) && $_POST["email"] != ""){
				$this->params .= "email" . $_POST["email"] . "&";
				$this->email = $_POST["email"];
			}else{
				// $this->errores["id_area"] = true;
				// $this->error = true;
			}

			if(isset($_POST["rol"]) && $_POST["rol"] != ""){
				$this->params .= "rol" . $_POST["rol"] . "&";
				$this->rol = $_POST["rol"];
			}else{
				$this->errores["rol"] = true;
				// $this->error = true;
			}


			if(isset($_POST["cargo_id"]) && $_POST["cargo_id"] != ""){
				$this->params .= "cargo_id" . $_POST["cargo_id"] . "&";
				$this->cargo_id = $_POST["cargo_id"];
			}else{
				$this->errores["cargo_id"] = true;
				$this->error = true;
			}

			if(isset($_POST["anexo"]) && $_POST["anexo"] != ""){
				$this->params .= "anexo" . $_POST["anexo"] . "&";
				$this->anexo = $_POST["anexo"];
			}else{
				$this->errores["anexo"] = true;
				$this->error = true;
			}
			

		}

		return new self($this->pdo);

	}



	public function execute(){

	    $authUser = authUser($this->pdo);

//	    if ($authUser['ID_PERMISO']==1){

            $cargoId = $_POST['cargo_id'];
//        }else{
//            $cargoId = $authUser['ID_CARGO'];
//        }


		//validar si faltó algo
		if(!$this->error){


		    //actualiza registro
            if(isset($_POST["id"]) && $_POST["id"] != ""){

                $query = "
                    UPDATE 
                        USUARIOS 
	                SET 
                        NOMBRE='{$_POST['nombre']}',
	                    MAIL='{$_POST['email']}',
                        ID_CARGO='{$cargoId}',
                        ANEXO='{$_POST['anexo']}',
                        ID_PERMISO='{$_POST['rol']}',
                        ID_AREA='{$_POST['id_area']}',
                        FECHA_ACTUALIZACION=SYSDATE
	                WHERE 
	                    ID_USUARIO='{$_POST['id']}'
                ";

                $result = oci_parse($this->pdo, $query);


                if (oci_execute($result)){
                    oci_commit($this->pdo);
                    flash("Usuario actualizado correctamente")->success() ;
                }else{
                    oci_rollback($this->pdo);
                    $error = oci_error($result);
                    flash($error['message'])->error();
                }


            }

            //nuevo registro
            else {
                $query = "INSERT INTO USUARIOS (
                    MAIL, 
                    NOMBRE, 
                    PASSWORD,
                    ID_CARGO,
                    ID_PERMISO,
                    ANEXO,
                    ID_AREA,
                    ESTADO,
                    FECHA_CREACION,
                    FECHA_ACTUALIZACION
                    ) 
                VALUES (
                    '". $_POST["email"] ."',
                    '". $_POST["nombre"] ."', 
                    '12345',
                    '". $cargoId ."',
                    '". $_POST["rol"] ."',
                    '". $_POST["anexo"] ."',
                    '". $_POST["id_area"] ."',
                    'ACTIVO',
                    SYSDATE,
                    SYSDATE
				)";


                $result = oci_parse($this->pdo, $query);

                oci_bind_by_name($result, "mylastid", $last_id, 8, SQLT_INT);


                if (oci_execute($result)){
                    oci_commit($this->pdo);
                    flash("Usuario creado correctamente")->success() ;
                }else{
                    oci_rollback($this->pdo);
                    $error = oci_error($result);
                    flash($error['message'])->error();
                }
            }




            oci_close($this->pdo);

			// $consulta2 = "INSERT INTO USUARIOS_PERMISOS (
			// 	MAIL,
			// 	ID_PERMISO)
			// VALUES(
			// 	'". $_POST["email"] ."',
			// 	'". $_POST["rol"] ."'
			// 	)";

			// $query2 = $consulta2;
			// $result2 = oci_parse($this->pdo, $query2);
			// oci_execute($result2, OCI_DEFAULT) or die ("No se pudo");
			
		}else{
			
			print_r($this->errores);
			
			die();
		}


		redirect("/usuarios");

	}

	public function edit($id){
		return new self($this->pdo, $id);
	}



    public function get(){

        $query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='" . $this->id . "'";

        return queryToArray($query,$this->pdo)[0];
    }

    public function getDataListBox()
    {
        $authUser = authUser($this->pdo);

        if ($authUser['ID_PERMISO']==1){
            $queryAreas = "SELECT * FROM AREAS WHERE ID_CARGO='{$authUser['ID_CARGO']}'";
            $queryPermisos = "select * from PERMISOS where ID_PERMISO not in (4)";
        }
        else if ($authUser['ID_PERMISO']==2){
            $queryAreas = "SELECT * FROM AREAS WHERE ID_CARGO='{$authUser['ID_CARGO']}'";
            $queryPermisos = "select * from PERMISOS where ID_PERMISO=4";
        }else{
            $queryAreas = "SELECT * FROM AREAS";
            $queryPermisos = "select * from PERMISOS";
        }

        $areas = queryToArray($queryAreas,$this->pdo);


        return [
            'cargos' => queryToArray("SELECT * FROM CARGOS",$this->pdo),
            'permisos' => queryToArray($queryPermisos,$this->pdo),
            'areas' => $areas
        ];
    }

}