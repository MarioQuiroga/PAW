<?php  
	require_once __DIR__ . "/conexion_db.php";

	class articulo {
		private $titulo;


		public function __construct(){
				
		}
		public function get_id_art($nombre_art){

			 $pdo =new Conexion();
			 $pdo=$pdo->retornar_conexion();
			 $query = $pdo->prepare("SELECT id_articulo FROM articulo WHERE titulo = '$nombre_art' "); //inner join comentarios on id_articulo=id_art
	        $query->execute();
	        return $query->fetchAll();
		}

	
		public function selectAll(){
	        
			
			 $pdo= new Conexion();
			 $pdo=$pdo->retornar_conexion();
	        $query = $pdo->prepare("SELECT * FROM articulo "); //inner join comentarios on id_articulo=id_art
	        $query->execute();
	        return $query->fetchAll();

    	}
    	public static function insertarObjetoBD($datos){
    			$campos = ['titulo', 'fecha', 'foto'];

    		  	$campos =join(',', $campos);
    		  	$pdoString =implode(',', array_fill(0, count($datos), '?')); // Retorna el values parametrizado para PDO
        		
				 $pdo =new Conexion();
				 $pdo=$pdo->retornar_conexion();
        		$query = $pdo->prepare("INSERT INTO articulo ($campos) VALUES ($pdoString)");

        		$data = [];
        			foreach ($datos as $campo) {
            		$data[] = $campo;
        			}
      		  	$query->execute($data);
      		  	
    	}
    	public static function actualizarObjeto($columna,$dato,$dato_ant){
    		
			 $pdo =new Conexion();
			 $pdo=$pdo->retornar_conexion();

			//$query = $pdo->prepare("SELECT foto FROM articulo WHERE foto=$dato_ant");
    		$query = $pdo->prepare("UPDATE articulo SET $columna=$dato WHERE titulo=$dato_ant");
			$query->execute();
			}
		public static function borrarObjeto($columna,$dato,$id_art){
			
			 $pdo =new Conexion();
			 $pdo=$pdo->retornar_conexion();
			//primero borro todas las tabla asociadas
			$query = $pdo->prepare("DELETE FROM comentarios WHERE id_art= $id_art");
			$query->execute();
			$query = $pdo->prepare("DELETE FROM articulo_tag WHERE id_articulo= $id_art");
			$query->execute();
			$query = $pdo->prepare("DELETE FROM articulo WHERE $columna= $dato");
			$query->execute();
    	}
  
			
		
		}

?>
 