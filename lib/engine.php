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

  static function createExamplesFiles(PackageEvent $event){

    $package = $event->getOperation()->getPackage();
    $installationManager = $event->getComposer()->getInstallationManager();
    $originDir = $installationManager->getInstallPath($package);

    if (file_exists($originDir.'/examples')) {
        $basedir = self::baseDir();
        exec("copy -r $originDir/examples/* $basedir/");
    }
  }

  static function startApp(){
		self::$config = new Config();
		if(file_exists(self::$baseDir."/config/config.php")) include self::$baseDir."/config/config.php";

    self::buildGears();
    return self::runApp();
	}

  static function getConfig(){
    return self::$config;
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
        if(empty(self::$run_app)) {
          self::$run_app = $options['run'];
        } else
          throw new \Exception('Duas Gears estão tentando rodar o sistema.');
    }
	}

	static private function buildGears(){
		foreach (self::$build_gears as $gear) $gear();
	}

  static private function runApp(){
    $app = self::$run_app;
    return $app();
	}
}
