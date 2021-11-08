<?php

	class Photo_upload{
		
		//properties.
		private $photo_to_upload;
		private $file_type;
		private $my_temp_image;
		private $my_new_image;
		private $photo_error;
		public	$file_name;
		
		function __construct($photo){
			$this->photo_to_upload = $photo;
			
			//kas on pilt ja mis tüüpi?
			$image_check = getimagesize($photo["tmp_name"]);
			if($image_check !== false){
				if($image_check["mime"] == "image/jpeg"){
					$this->file_type = "jpg";
				}
				if($image_check["mime"] == "image/png"){
					$this->file_type = "png";
				}
				if($image_check["mime"] == "image/gif"){
					$this->file_type = "gif";
				} 
			} else {
				$this->photo_error = True;
			}
			$this->my_temp_image = $this->create_image_from_file($this->photo_to_upload["tmp_name"], $this->file_type);
		}
		
		function __destruct(){
			if(isset($this->my_temp_image)){
				imagedestroy($this->my_temp_image);
			}
		}
		
		public function file_name($photo_filename_prefix){
			//teen ajatempli
            $time_stamp = microtime(1) * 10000;
            
            //moodustan failinime, kasutame eesliidet
            $this->file_name = $photo_filename_prefix ."_" .$time_stamp ."." .$this->file_type;
			return $this->file_name;
		}
				
		public function create_image_from_file($file){ //pikslikogumi loomine fnc.
			$my_temp_image = null;
			
			//teen graafikaobjekti, image objekti
            if($this->file_type == "jpg"){
                $my_temp_image = imagecreatefromjpeg($file);
            }
            if($this->file_type == "png"){
                $my_temp_image = imagecreatefrompng($file);
            }
            if($this->file_type == "gif"){
                $my_temp_image = imagecreatefromgif($file);
            }
			
			return $my_temp_image; //klassi muutuja tuleb panna $this see nagu global muutuja aga klassi sisene.
		}
		
		
		public function resize_photo($w, $h, $keep_orig_proportion = true){
			$image_w = imagesx($this->my_temp_image);
			$image_h = imagesy($this->my_temp_image);
			$new_w = $w;
			$new_h = $h;
			$cut_x = 0;
			$cut_y = 0;
			$cut_size_w = $image_w;
			$cut_size_h = $image_h;
			
			if($w == $h){
				if($image_w > $image_h){
					$cut_size_w = $image_h;
					$cut_x = round(($image_w - $cut_size_w) / 2);
				} else {
					$cut_size_h = $image_w;
					$cut_y = round(($image_h - $cut_size_h) / 2);
				}	
			} elseif($keep_orig_proportion){//kui tuleb originaaproportsioone säilitada
				if($image_w / $w > $image_h / $h){
					$new_h = round($image_h / ($image_w / $w));
				} else {
					$new_w = round($image_w / ($image_h / $h));
				}
			} else { //kui on vaja kindlasti etteantud suurust, ehk pisut ka kärpida
				if($image_w / $w < $image_h / $h){
					$cut_size_h = round($image_w / $w * $h);
					$cut_y = round(($image_h - $cut_size_h) / 2);
				} else {
					$cut_size_w = round($image_h / $h * $w);
					$cut_x = round(($image_w - $cut_size_w) / 2);
				}
			}
				
			//loome uue ajutise pildiobjekti
			$this->my_new_image = imagecreatetruecolor($new_w, $new_h);

			//säilitame png failide puhul läbipaistvuse.
			imagesavealpha($this->my_new_image, true);
			$trans_color = imagecolorallocatealpha($this->my_new_image, 0, 0, 0, 127);
			imagefill($this->my_new_image, 0, 0, $trans_color);
			imagecopyresampled($this->my_new_image, $this->my_temp_image, 0, 0, $cut_x, $cut_y, $new_w, $new_h, $cut_size_w, $cut_size_h);
		}
		
		public function add_watermark($watermark_file){ //public tähendab, et saab väljast poolt ilusti kutsuda.
			$watermark = imagecreatefrompng($watermark_file);
			$watermark_width = imagesx($watermark);
			$watermark_height = imagesy($watermark);
			$watermark_x = imagesx($this->my_new_image) - $watermark_width - 10;
			$watermark_y = imagesy($this->my_new_image) - $watermark_height - 10;
			imagecopy($this->my_new_image, $watermark, $watermark_x, $watermark_y, 0, 0, $watermark_width, $watermark_height);
			imagedestroy($watermark);
		}
		
		public function save_image($upload_directory){
			$notice = null;
			
			if($this->file_type == "jpg"){
				if(imagejpeg($this->my_new_image, $upload_directory .$this->file_name, 90)){
					$notice = "salvestamine õnnestus!";
				} else {
					$notice = "salvestamisel tekkis tõrge!";
				}
			}
			
			if($this->file_type == "png"){
				if(imagepng($this->my_new_image, $upload_directory .$this->file_name, 6)){
					$notice = "salvestamine õnnestus!";
				} else {
					$notice = "salvestamisel tekkis tõrge!";
				}
			}
			
			if($this->file_type == "gif"){
				if(imagegif($this->my_new_image, $upload_directory .$this->file_name)){
					$notice = "salvestamine õnnestus!";
				} else {
					$notice = "salvestamisel tekkis tõrge!";
				}
			}
			imagedestroy($this->my_new_image);
			return $notice;
		}
		
	}//lõpp.