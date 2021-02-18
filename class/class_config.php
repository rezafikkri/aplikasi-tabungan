<?php

/**
 * 
 */
class config {
	private $host = "localhost", // host
			$dbname = "tabungan", // database
			$username = "root", // username
			$password = ""; // password
	protected $db;
	
	function __construct() {
		// set session
		if(!isset($_SESSION)) {
			session_start();
		}

		ob_start();

		// set default time zone
		date_default_timezone_set("Asia/Jakarta");

		// connect to database
		try {
			$this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->username, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return true;
		} catch (PDOException $e) {
			echo "gagal konek ".$e->getMessage();
			die;
		}
	}

	public static function protocol() {
		if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}
		return $protocol;
	}

	public static function base_url($uri='') {
		if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}
		return self::protocol().$_SERVER['HTTP_HOST']."/aplikasi-tabungan/".$uri;
	}

	public static function generate_uuid() {
		return bin2hex(random_bytes(8));
	}

	/* form validation */
		private function maxLength_minLength($data,$type,$rule,$fieldForHuman) {
			$rule = str_replace("]", "", $rule);
			$arrRule = explode("[", $rule);

			if($type=="maxLength" && strlen($data)>end($arrRule)) {
				return $fieldForHuman." tidak boleh lebih dari ".end($arrRule)." karakter!";

			} elseif($type=="minLength" && strlen($data)<end($arrRule)) {
				return $fieldForHuman." tidak boleh kurang dari ".end($arrRule)." karakter!";

			} else {
				return null;
			}
		}

		private function generate_arrRuleReplace($rule){
			return explode("[", str_replace([']'], "", $rule));
		}

		private function cek_rules($data, $fieldForHuman, $rule) {
		    $rule = explode('|', $rule);
		    for($i = 0; $i < count($rule); $i++) {

		    	// required
		    	if(strtolower($rule[$i]) == "required") {
		    		if(empty(trim($data))) {
		    			return $fieldForHuman." tidak boleh kosong!";
		    		}
		    	}
		    	// max length
		    	else if(preg_match("/^maxLength\[\d+\]\z/i", $rule[$i])) {
		    		$cek = $this->maxLength_minLength($data,'maxLength',$rule[$i],$fieldForHuman);
		    		if($cek) {
		    			return $cek;
		    		}
		    	}
		    	// min length
		    	else if(preg_match("/^minLength\[\d+\]\z/i", $rule[$i])) {
		    		$cek = $this->maxLength_minLength($data,'minLength',$rule[$i],$fieldForHuman);
		    		if($cek) {
		    			return $cek;
		    		}
		    	}
		    	// email
		    	else if(strtolower($rule[$i]) == "email") {
		    		if(!empty(trim($data)) && !filter_var($data, FILTER_VALIDATE_EMAIL)) {
		    			return $fieldForHuman." salah!";
		    		}
		    	}
		    	// integer
		    	else if(strtolower($rule[$i]) == "integer") {
		    		if(!empty(trim($data)) && !preg_match("/^\+?[\d]+\z/", $data)) {
		    			return $fieldForHuman." salah!";
		    		}
		    	}
		    	// float
		    	else if(strtolower($rule[$i]) == "float") {
		    		if(!empty(trim($data)) && !preg_match("/^\d+,?\.?\d*\z/", $data)) {
		    			return $fieldForHuman." salah!";
		    		}
		    	}
		    	// unique table.field
		    	else if(!empty(trim($data)) && preg_match("/(^unique\[\w+\.\w+\])(\[\w+\.[\w\d-]+\])?\z/i", $rule[$i])) {
		    		$arrRuleReplace = $this->generate_arrRuleReplace($rule[$i]);
					$arrWhere1 = explode(".", $arrRuleReplace[1]);
					$table = $arrWhere1[0];
					$field1 = $arrWhere1[1];
					$execute = [ ':'.$field1 => $data ];

					if(isset($arrRuleReplace[2])) {
						$arrWhere2 = explode(".", $arrRuleReplace[2]);
						$field2 = $arrWhere2[0];
						$value = $arrWhere2[1];
						$where2 = 'and '.$field2.'!=:'.$field2;
						$execute = array_merge($execute, [':'.$field2 => $value]);
					} else {
						$where2 = null;
					}

		    		// cek apakah data sudah ada didatabase
		    		$cek = $this->db->prepare("SELECT $field1 from $table where $field1=:$field1 $where2");
		    		$cek->execute($execute);
		    		if($cek->rowCount() >= 1) {
		    			return $fieldForHuman." sudah ada, mohon cari ".$fieldForHuman." yang lain!";
		    		}
		    	}
		    	// must[]
		    	elseif(!empty(trim($data)) && preg_match("/^must\[[\w\s-]+(,[\w\s-]+)*\]\z/i", $rule[$i])) {
					$arrRuleReplace = $this->generate_arrRuleReplace($rule[$i]);
					$whiteListMust = explode(",", str_replace(" ", "", end($arrRuleReplace)));
					if(!in_array($data, $whiteListMust)) {
						return $fieldForHuman." harus berisi ".implode(" atau ", $whiteListMust);
					}
				}
				// regex custom
				elseif(!empty(trim($data)) && preg_match("/^regex\[\s.+\s\]\z/i", $rule[$i])) {
					$arrRuleReplace = explode("[ ", str_replace([' ]'], "", $rule[$i]));;
					$regexCustom = end($arrRuleReplace);
					if(!preg_match("$regexCustom", $data)) {
						return $fieldForHuman." salah!";
					}
				}
		    }

		    return false;
		}

		private function generate_realField_fieldForHuman($field) {
			if(preg_match("/^[\w\d\-\s]+\[[\w\d\-\s\/,&]+\]\z/", $field)) {
				$arrField = explode("[", $field);
				$realField = $arrField[0];
				$fieldForHuman = str_replace("]", "", $arrField[1]);
			} else {
				$realField = $field;
			}
			if(!isset($fieldForHuman)) {
				$fieldForHuman = $realField;
			}
			return ['realField'=>$realField, 'fieldForHuman'=>$fieldForHuman];
		}

		public function form_validation($param=null, $old_val=true) {
			if($param != null && is_array($param)) {
				foreach($param as $field=>$rule) {
					$arrDataField = $this->generate_realField_fieldForHuman($field);
					$data = filter_input(INPUT_POST, $arrDataField['realField'], FILTER_SANITIZE_STRING);
					if($data === null) $data = filter_input(INPUT_GET, $arrDataField['realField'], FILTER_SANITIZE_STRING);

					// jika data tidak valid
					$cek = $this->cek_rules($data, $arrDataField['fieldForHuman'], $rule);
					if($cek) {
						// set session error
						$_SESSION['tabungan']['form_errors'][$arrDataField['realField']] = $cek;
						$return = true;
					} else {
						$return = false;
					}
				}

				// set session old value
				if(isset($_SESSION['tabungan']['form_errors']) && $old_val==true) {
					foreach($param as $field=>$rule) {
						$arrDataField = $this->generate_realField_fieldForHuman($field);
						$data = filter_input(INPUT_POST, $arrDataField['realField'], FILTER_SANITIZE_STRING);
						$_SESSION['tabungan']['old_val'][$arrDataField['realField']] = $data;
					}
				}

				return $return;
			}
		}

		public function set_delimiter($delimiterOpen=null, $delimiterClose=null) {
		    
		    if( isset($_SESSION['tabungan']['form_errors']) && !empty(trim($delimiterOpen)) && !empty(trim($delimiterClose)) ) {

		    	foreach($_SESSION['tabungan']['form_errors'] as $key=>$val) {
		    		$_SESSION['tabungan']['form_errors'][$key] = $delimiterOpen.$val.$delimiterClose;
		    	}

		    	return true;
		    }
		    return false;
		}

		public function has_formErrors() {
		    if(isset($_SESSION['tabungan']['form_errors'])) {
		    	return true;
		    } else {
		    	return false;
		    }
		}

		public function get_form_errors() {
		    if(isset($_SESSION['tabungan']['form_errors'])) {
		    	$errors = $_SESSION['tabungan']['form_errors'];
		    	unset($_SESSION['tabungan']['form_errors']);
		    	return $errors;
		    }

		    return null;
		}

		public function get_old_value() {
		    if(isset($_SESSION['tabungan']['old_val'])) {
		    	$old_val = $_SESSION['tabungan']['old_val'];
		    	unset($_SESSION['tabungan']['old_val']);
		    	return $old_val;
		    }

		    return null;
		}
	/* form validation */
}
