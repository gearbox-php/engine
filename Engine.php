<?

namespace GearBox;

class Engine{

  static  $vendorDir;
  static  $baseDir;
  static  $config;

  static function createConfigFolder(){
    self::$vendorDir = dirname(dirname(__FILE__));
    self::$baseDir = dirname($vendorDir);

    if(!file_exists(self::$baseDir."/config"))
      mkdir(self::$baseDir.'/config');

    $content = file_get_contents(self::$vendorDir.'/gearbox/engine/files/config_exemple.txt');
    $file = self::$baseDir.'/config/config.php';
    file_put_contents($file, $content);
  }

  static function startApp(){
    self::$vendorDir = dirname(dirname(__FILE__));
    self::$baseDir = dirname($vendorDir);
		self::$config = new GearBoxConfig();

		if(file_exists(self::$baseDir."/config/config.php")) include self::$baseDir."/config/config.php";
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

}
