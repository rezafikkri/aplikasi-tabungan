<?php

// include semua class yang ada didalam folder class
spl_autoload_register(function($class){
	include "class/class_".$class.".php";
});