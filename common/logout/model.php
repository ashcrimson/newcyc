<?php



namespace LogoutCYC;


/**
 * modelo de plantilla y control de permisos
 */
class ModelLogoutCYC {



	/**
	 *
	 */
	//Obj de conexion de db
	private $pdo;
	//usuario
	private $user;
	//permisos
	private $permisos;

	//Constructor
	function __construct($pdo, string $user = ''){
		$this->pdo = $pdo;
		$this->user = $user;
	}


	//obtiene permisos del usuario
	public function getId($user): self{
		return new self($this->pdo, $user);
	}

	//retorna el/los datos seleccionados
	public function get(){

		session_start();
		$_SESSION["mail"] = "";
		$_SESSION["nombre"] = "";
		session_unset();
		session_destroy();
		header("Location: ". base() . "/login");

	}
}