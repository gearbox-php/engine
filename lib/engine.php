<?

namespace Gearbox;

use Gearbox\Engine\Config;
use Gearbox\Engine\Loader;

class Engine{

  static  $gearboxDir;
  static  $vendorDir;
  static  $baseDir;
  static private $config;
  static private $build_gears = [];
  static private $run_app = null;

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

    self::buildGears();
    return self::runApp();
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

	static function addGear($options = []){
		if (isset($options['build'])) self::$build_gears[] = $options['build'];
		if (isset($options['loader'])) Loader::register($options['loader']);
    if (isset($options['run'])){
        if(empty(self::$run_app))
          self::$run_app = $options['run'];
        else
          throw new \Exception('Duas Gears estão tentando rodar o sistema.');
    }
	}

	static private function buildGears(){
		foreach (self::$build_gears as $gear) $gear();
	}

  static private function runApp(){
    return self::$run_app();
	}
}
