<?php



namespace UsuariosList;


/**
 * modelo de lista de  licitaciones
 */
class ModelUsuarios {

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


        $query = "update USUARIOS set ESTADO='INACTIVO' WHERE ID_USUARIO='{$id}'";

        $result = oci_parse($this->pdo, $query);


        if (oci_execute($result)){
            oci_commit($this->pdo);
            flash("Usuario desactivado correctamente")->success() ;
        }else{
            oci_rollback($this->pdo);
            $error = oci_error($result);
            flash($error['message'])->error();
        }

		
        oci_commit($this->pdo);

        redirect('/usuarios');

    }

	//filtra consulta por nro de licitación(id, llave primaria)
	public function getId($id): self{
		return new self($this->pdo, $id, $this->page);
	}

	//filtra consulta por nro de página
	public function getPage(int $page): self{
		return new self($this->pdo, $this->id, $page);
	}

	//retorna el/los datos seleccionados
	public function get(){

        $authUser = authUser($this->pdo);

		$assoc = [];
		$listado = [];
		$mail = [];
		$totales = [];

		$where = 'where 1=1';

        if ($authUser['ID_PERMISO']==2){
            $where .= " and u.ID_CARGO='{$authUser['ID_CARGO']}'";
        }


		//consulta principal
		$consulta = "
            SELECT 
                U.*,
                c.NOMBRE AS NOMBRE_CARGO,
                p.NOMBRE_PERMISO AS NOMBRE_PERMISO,
                a.AREA as nombre_area
            FROM 
                USUARIOS u left join CARGOS c on u.ID_CARGO=c.ID_CARGO
                left join PERMISOS p on u.ID_PERMISO= p.ID_PERMISO
                left join AREAS a on a.ID_AREA = u.ID_AREA
            {$where}
        ";


        //consulta paginada
		$query = queryPagination($consulta, $this->page);
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$listado = queryResultToAssoc($result);

		//consulta para recuperar todos los codigos de monedas
		$query = "select * from licitaciones ";
		//$query = "select CODIGO from licitaciones ";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$codigos = queryResultToAssoc($result);

		//consulta para recuperar cantidad de páginas disponibles
		$result = oci_parse($this->pdo, $consulta);
		oci_execute($result);
		$totales = queryResultToAssoc($result);

		

		array_push($assoc, $listado);
		array_push($assoc, $codigos);
		array_push($assoc, $totales);

		oci_close($this->pdo);
		return $assoc;
	}

    public function restore()
    {
        $id = $_GET['id'];


        $query = "update USUARIOS set ESTADO='ACTIVO' WHERE ID_USUARIO='{$id}'";

        $result = oci_parse($this->pdo, $query);


        if (oci_execute($result)){
            oci_commit($this->pdo);
            flash("Usuario restaurado correctamente")->success() ;
        }else{
            oci_rollback($this->pdo);
            $error = oci_error($result);
            flash($error['message'])->error();
        }


        oci_commit($this->pdo);

        redirect('/usuarios');


	}
}