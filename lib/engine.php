<?

namespace Gearbox;

use Gearbox\Engine\Config;

class Engine{

  static  $gearboxDir;
  static  $vendorDir;
  static  $baseDir;
  static private $config;
  static private $build_gears = [];

  static function createConfigFolder(){

    if(!file_exists(self::$baseDir."/config")){
      mkdir(self::$baseDir.'/config');
    }

    if(!file_exists(self::$baseDir."/config/config.php")){
      $content = file_get_contents(self::$vendorDir.'/gearbox/engine/files/config_exemple.txt');
      $file = self::$baseDir.'/config/config.php';
      file_put_contents($file, $content);
    }
  }

  static function startApp(){
		self::$config = new Config();
		if(file_exists(self::$baseDir."/config/config.php")) include self::$baseDir."/config/config.php";

    return self::buildGears();
	}

  static function gearboxDir($path = null){
    if(empty(self::$gearboxDir)){
      self::$gearboxDir = dirname(dirname(dirname(__FILE__)));
    }
    return empty($path) ? self::$gearboxDir : self::$gearboxDir . "/$path";
  }

  static function vendorDir($path = null){
    if(empty(self::$vendorDir)){
      self::$vendorDir = dirname(self::gearboxDir());
    }
    return empty($path) ? self::$vendorDir : self::$vendorDir . "/$path";
  }

  static function baseDir($path = null){
    if(empty(self::$vendorDir)){
      self::$baseDir = dirname(self::vendorDir());
    }
    return empty($path) ? self::$baseDir : self::$baseDir . "/$path";
  }

  static private function setConfig($call){
		$call(self::$config);
	}

  static function config($field = null){
    if(empty($field)){
      return self::$config;
    } else {
      return self::$config->{$field};
    }
	}

	static private function addGear($options = []){
		if (isset($options['build'])) self::$build_gears[] = $options['build'];
		if (isset($options['loader'])) spl_autoload_register($options['loader']);
	}

	static private function buildGears(){
		foreach (self::$build_gears as $gear) if(!$gear()) return false;
		return true;
	}
}
