<?php 	
	/**
	*  
	*/
	require_once __DIR__ . "/conexion_db.php";
	class Imagen 
	{
		private $id = -1;
		public function __construct($id0=-1){
			$this->id = $id0;
		}

		public function save_img($img,$tipo){
			 $pdo =new Conexion();
			 $pdo=$pdo->retornar_conexion();

			$source_img = $img;
			$source_img = imagecreatefromstring($source_img);
			$width = imagesx($source_img);
			$height = imagesy($source_img);

			$thumbnail_w = 100;
			$thumbnail_h = 100;
			$dest_img = imagecreatetruecolor($thumbnail_w, $thumbnail_h);
			imagecopyresampled($dest_img, $source_img, 0, 0, 0, 0,
				$thumbnail_w, $thumbnail_h,
				$width, $height);

			ob_start();
			if (!imagepng($dest_img)) {
				die();
			}
			$dest_img_data = ob_get_contents();
			ob_end_clean();

			$query = $pdo->prepare("INSERT INTO imagenes (imagen, tipo_imagen) VALUES (:imagen, :tipo)");
			$query->bindParam(':imagen', $img, PDO::PARAM_LOB);
			$query->bindParam(':tipo', $tipo, PDO::PARAM_STR);
			$query->execute();
			
			/*$pdo=self::retornar_conexion();
			
			$this->id = $pdo->lastInsertId();*/
		}
		public function get_img_id($img){
			return $this->id;
		}

	
		
		public function thumbnail($imgid){
			 $pdo =new Conexion();
			 $pdo=$pdo->retornar_conexion();
			$query=$pdo->prepare("SELECT imagen from imagenes where id_imagen=?");
			$query->execute([$imgid]);
			$result = $query->fetch();

			$source_img = $result['imagen'];
			$source_img = imagecreatefromstring($source_img);
			$width = imagesx($source_img);
			$height = imagesy($source_img);

			$thumbnail_w = 100;
			$thumbnail_h = 70;
			$dest_img = imagecreatetruecolor($thumbnail_w, $thumbnail_h);
			imagecopyresampled($dest_img, $source_img, 0, 0, 0, 0,
				$thumbnail_w, $thumbnail_h,
				$width, $height);

			ob_start();
			if (!imagepng($dest_img)) {
				die();
			}
			$dest_img_data = ob_get_contents();
			ob_end_clean();

			$this->save_img($dest_img_data, "image/png");
		}

	public static function obtener_imgs(){
		 $pdo =new Conexion();
			 $pdo=$pdo->retornar_conexion();
		$query = $pdo->prepare("SELECT id_imagen,imagen FROM imagenes ");
        $query->execute();
        //$imagenes=$pdo->query("SELECT imagen FROM imagenes ");
        return $query->fetchall();
	}
	}
	?>