<?php

/**
 * Modelo que accede a la base de datos para gestionar permisos
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 25/11/2017
 */

class PERMISO_Modelo {

	var $NombreGrupo; // declaración del atributo login
    var $NombreFuncionalidad; // declaración del atributo DNI
    var $NombreAccion; // declaración del atributo password
    var $sql;//almacena una consulta
    private $db;// declaración del atributo manejador de la bd
    
  
    public function __construct($NombreGrupo,$NombreFuncionalidad,$NombreAccion) {
		include_once '../Models/DB/BdAdmin.php';
		
		//asignación de valores de parámetro a los atributos de la clase
        $this->NombreGrupo = $NombreGrupo;
        $this->NombreFuncionalidad = $NombreFuncionalidad;
        $this->NombreAccion = $NombreAccion;

        // conectamos con la bd y guardamos el manejador en un atributo de la clase

        $this->db = ConnectDB();
	}
	
    //recoge todos los datos de la tabla permiso
	function AllData(){
		
		$sql = "SELECT * FROM `PERMISO` ";
		if (!($resultado = $this->db->query($sql))){
			return 'It does not exist in DB';
		}
		else{ // si existe se devuelve la tupla resultado
			$result = $resultado;
			return $result;
		}
	}

    //funcion utilizada en la creacion del showall de permisos
	function showall(){

		$sql = "SELECT GRUPO.NombreGrupo,FUNCIONALIDAD.NombreFuncionalidad,ACCION.NombreAccion 
			FROM `PERMISO`,`GRUPO`,`FUNCIONALIDAD`,`ACCION` 
			WHERE PERMISO.IdGrupo = GRUPO.IdGrupo AND PERMISO.IdFuncionalidad = FUNCIONALIDAD.IdFuncionalidad 
			AND ACCION.IdAccion = PERMISO.IdAccion ORDER BY GRUPO.NombreGrupo,FUNCIONALIDAD.NombreFuncionalidad,ACCION.NombreAccion";
        //Si no devuelve resultado muestra mensaje
		if (!($resultado = $this->db->query($sql))){
			return 'It does not exist in DB';
		}
		else{ // si existe se devuelve la tupla resultado
			$result = $resultado;
			return $result;
		}
	}

    //funcion SEARCH:
    // hace una búsqueda en la tabla con
    //los datos proporcionados. Si van vacios devuelve todos
	function SEARCH()
    {
        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT GRUPO.NombreGrupo,FUNCIONALIDAD.NombreFuncionalidad,ACCION.NombreAccion 
					FROM `PERMISO`,`GRUPO`,`FUNCIONALIDAD`,`ACCION` 
					WHERE PERMISO.IdGrupo = GRUPO.IdGrupo AND PERMISO.IdFuncionalidad = FUNCIONALIDAD.IdFuncionalidad 
					AND ACCION.IdAccion = PERMISO.IdAccion 
					AND GRUPO.NombreGrupo LIKE '%".$this->NombreGrupo."%'
					AND FUNCIONALIDAD.NombreFuncionalidad LIKE '%".$this->NombreFuncionalidad."%'
					AND ACCION.NombreAccion LIKE '%".$this->NombreAccion."%'
					ORDER BY GRUPO.NombreGrupo,FUNCIONALIDAD.NombreFuncionalidad,ACCION.NombreAccion";
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->db->query($sql))){
         return 'Query Error about DB';

        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo SEARCH

    //Método ADD()
//Inserta en la tabla  de la bd  los valores
// de los atributos del objeto. Comprueba si la clave/s esta vacia y si
//existe ya en la tabla
    function ADD($IdFuncionalidad,$IdAccion,$IdGrupo)
    {
        if (($IdFuncionalidad <> '')&&($IdAccion <> '')&&($IdGrupo <> '')){ // si el atributo clave de la entidad no esta vacio
            $funcionalidad="SELECT IdFuncionalidad FROM `FUNCIONALIDAD` WHERE (NombreFuncionalidad = '$IdFuncionalidad')";
            $accion="SELECT IdAccion FROM `ACCION` WHERE (NombreAccion = '$IdAccion')";
            $grupo="SELECT IdGrupo FROM `GRUPO` WHERE (NombreGrupo = '$IdGrupo')";

            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `PERMISO` WHERE (IdFuncionalidad = ($funcionalidad)) AND (IdAccion = ($accion)) AND (IdGrupo = ($grupo))";

            if (!$result = $this->db->query($sql)){ // si da error la ejecución de la query
                echo"0";exit;
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `PERMISO` (`IdFuncionalidad`,`IdAccion`,`IdGrupo`) 
				VALUES ((".$funcionalidad."),(".$accion."),(".$grupo."));";


                    if (!$this->db->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje

                        return 'Unknowed Error';


                    }
                    else{ //si no da error en la insercion devolvemos mensaje de éxito

                        return 'Success insert'; //operacion de insertado correcta
                    }

                }
                else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
                    return 'It is already in DB'; // ya existe
            }
        }
        else{ // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
            return 'Introduce a value'; // introduzca un valor para el usuario
        }
    } // fin del metodo ADD




    // función DELETE():
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
    function DELETE($GRUPO,$FUNCIONALIDAD)
    {
        // se construye la sentencia sql de busqueda con los atributos de la clase

        $idgrup = "SELECT IdGrupo FROM `GRUPO` WHERE (NombreGrupo = '".$GRUPO."')";
        $idfunc = "SELECT IdFuncionalidad FROM `FUNCIONALIDAD` WHERE (NombreFuncionalidad = '".$FUNCIONALIDAD."')";
        // se ejecuta la query
        $result = $this->db->query($idgrup);

        // si existe una tupla con ese valor de clave
        if ($result->num_rows == 1)
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `PERMISO` WHERE (IdGrupo = (".$idgrup.")) AND (IdFuncionalidad = (".$idfunc.")) ";

            // se ejecuta la query

            $this->db->query($sql);
            // se devuelve el mensaje de borrado correcto
            return 'Correctly delete';
        } // si no existe el login a borrar se devuelve el mensaje de que no existe
        else


            return 'It does not exist in DB';
    } // fin metodo DELETE

    //comprueba que una funcionalidad tenga una accion insertada
	public function check($controlador, $accion, $userid) {
		$sql1= "SELECT * FROM `PERMISO`,`USU_GRUPO` 
			WHERE PERMISO.IdFuncionalidad = (SELECT FUNCIONALIDAD.IdFuncionalidad 
				FROM `FUNC_ACCION`,`FUNCIONALIDAD`,`ACCION` 
				WHERE FUNC_ACCION.IdFuncionalidad = FUNCIONALIDAD.IdFuncionalidad 
				AND FUNC_ACCION.IdAccion = ACCION.IdAccion AND ACCION.NombreAccion = '".$accion."' 
				AND FUNCIONALIDAD.NombreFuncionalidad = '".$controlador."' ) 
			AND PERMISO.IdAccion = (SELECT ACCION.IdAccion 
				FROM `FUNC_ACCION`,`FUNCIONALIDAD`,`ACCION` 
				WHERE FUNC_ACCION.IdFuncionalidad = FUNCIONALIDAD.IdFuncionalidad 
				AND FUNC_ACCION.IdAccion = ACCION.IdAccion 	AND ACCION.NombreAccion = '".$accion."' 
				AND FUNCIONALIDAD.NombreFuncionalidad = '".$controlador."' ) 
			AND USU_GRUPO.IdGrupo = PERMISO.IdGrupo 
			AND USU_GRUPO.login = '".$userid."'";

		$resul = $this->db->query($sql1);

		if($resul->num_rows == 1){
			return true;
		}else 
			return false;

	}

    //comprueba que una funcionalidad esta asignada a un grupo
	public function checkGrupo($grupo, $userid) {
		$sql1= "SELECT * FROM `USU_GRUPO`,`GRUPO` 
				WHERE GRUPO.IdGrupo = USU_GRUPO.IdGrupo && GRUPO.NombreGrupo = '".$grupo."' 
				&& USU_GRUPO.login = '".$userid."'";

		$resul = $this->db->query($sql1);

		if($resul->num_rows == 1){
			return true;
		}else 
			return false;

	}

}
