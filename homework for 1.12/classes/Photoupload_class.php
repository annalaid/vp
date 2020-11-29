<?php
	class Photoupload{
		private $uploadedphoto;
		private $photofiletype;
		private $mytempimage;
		private $mynewimage;
		private $timestamp;
		private $filenameprefix = "vp_";
		public $filename;

		function __construct($photoinput){
			$this->uploadedphoto = $photoinput;
			//var_dump($this->uploadedphoto);
			//teeme piksliobjekti
			$this->createImageFromFile();
		}//construct lõppeb

		function __destruct(){
			if(isset($this->mytempimage)) {
				imagedestroy($this->mytempimage);
			}
		}

		public function getSize($filesizelimit) {
			$notice = 0;
			$size = $this->uploadedphoto["size"];
			if ($size > $filesizelimit) {
				return $notice;
			}
			else {
				return $size;
			}
		}

		public function setFilename($prefix = "", $suffix = "") {
			if ($prefix == "") {
				$prefix = $this->filenameprefix;
			}
			if ($suffix == "") {
				$suffix = $this->photofiletype;
			}
			$this->timestamp = microtime(1) * 10000;
			$this->filename = $prefix .$this->timestamp ."." .$suffix;
			return $this->filename;
		}

		public function file_exists($dir, $name) {
			if(file_exists($dir .$name)) {
				return true;
			}
			else {
				return false;
			}
		}

		private function createImageFromFile(){
			if($this->photofiletype == "jpg"){
				$this->mytempimage = imagecreatefromjpeg($this->uploadedphoto["tmp_name"]);
			}
			if($this->photofiletype == "png"){
				$this->mytempimage = imagecreatefrompng($this->uploadedphoto["tmp_name"]);
			}
			if($this->photofiletype == "gif"){
				$this->mytempimage = imagecreatefromgif($this->uploadedphoto["tmp_name"]);
			}
		}

		public function resizePhoto($w, $h, $keeporigproportion = true){
			$imagew = imagesx($this->mytempimage);
			$imageh = imagesy($this->mytempimage);
			$neww = $w;
			$newh = $h;
			$cutx = 0;
			$cuty = 0;
			$cutsizew = $imagew;
			$cutsizeh = $imageh;

			if($w == $h){
				if($imagew > $imageh){
					$cutsizew = $imageh;
					$cutx = round(($imagew - $cutsizew) / 2);
				} else {
					$cutsizeh = $imagew;
					$cuty = round(($imageh - $cutsizeh) / 2);
				}
			} elseif($keeporigproportion){//kui tuleb originaaproportsioone säilitada
				if($imagew / $w > $imageh / $h){
					$newh = round($imageh / ($imagew / $w));
				} else {
					$neww = round($imagew / ($imageh / $h));
				}
			} else { //kui on vaja kindlasti etteantud suurust, ehk pisut ka kärpida
				if($imagew / $w < $imageh / $h){
					$cutsizeh = round($imagew / $w * $h);
					$cuty = round(($imageh - $cutsizeh) / 2);
				} else {
					$cutsizew = round($imageh / $h * $w);
					$cutx = round(($imagew - $cutsizew) / 2);
				}
			}

			//loome uue ajutise pildiobjekti
			$this->mynewimage = imagecreatetruecolor($neww, $newh);
			//kui on läbipaistvusega png pildid, siis on vaja säilitada läbipaistvusega
			imagesavealpha($this->mynewimage, true);
			$transcolor = imagecolorallocatealpha($this->mynewimage, 0, 0, 0, 127);
			imagefill($this->mynewimage, 0, 0, $transcolor);
			imagecopyresampled($this->mynewimage, $this->mytempimage, 0, 0, $cutx, $cuty, $neww, $newh, $cutsizew, $cutsizeh);
		}

		public function imageType($photoFileTypes) {
			$notice = null;
			// Kas on pilt
			$check = getimagesize($this->uploadedphoto["tmp_name"]);
			// Kui jah, siis mis tüüpi + loo pildifail
			if(in_array($check["mime"], $photoFileTypes)){
				$this->photofiletype = substr($check["mime"], -3);
				if ($this->photofiletype == "peg") {
					$this->photofiletype = "jpg";
				}
				$notice = 1;
				$this->createImageFromFile();
			} else {
				$notice = 0;
			}
			return $notice;
		}

		public function savePhotoFile($target){
			$notice = null;
			if($this->photofiletype == "jpg"){
				if(imagejpeg($this->mynewimage, $target, 90)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			if($this->photofiletype == "png"){
				if(imagepng($this->mynewimage, $target, 6)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			if($this->photofiletype == "gif"){
				if(imagegif($this->mynewimage, $target)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			imagedestroy($this->mynewimage);
			return $notice;
		}

		public function addWatermark($watermark){
			if(isset($this->mynewimage)){
				$watermark = imagecreatefrompng($watermark);
				$wmw = imagesx($watermark);
				$wmh = imagesy($watermark);
				$wmx = imagesx($this->mynewimage) - $wmw - 10;
				$wmy = imagesy($this->mynewimage) - $wmh - 10;
				//kopeerin vesimärgi vähendatud pildile
				imagecopy($this->mynewimage, $watermark, $wmx, $wmy, 0, 0, $wmw, $wmh);
				imagedestroy($watermark);
			}
		}

		public function saveOriginalPhoto($target){
			$notice = null;
			if(move_uploaded_file($this->uploadedphoto["tmp_name"], $target)){
				$notice .= 1;
			} else {
				$error .= 0;
			}
			return $notice;
		}

	}//class lõppeb
