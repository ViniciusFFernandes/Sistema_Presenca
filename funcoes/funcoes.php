<?php 
    function converteData($string){
        if ($string != "") {
					$string = explode(" ", $string);
					$data = explode("-", $string[0]);
					$dataFormatada = $data[2] . "/" . $data[1] . "/" . $data[0];
					if (!empty($string[1])) {
						$dataFormatada .= " " . $string[1];
					}
				}else {
					return "";
				}
				return $dataFormatada;
    }
?>