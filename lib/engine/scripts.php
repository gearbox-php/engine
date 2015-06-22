<?

namespace Gearbox\Engine;
use Gearbox\Engine as en;

class Scripts{

  static function createFileExample(){
    $path = en::vendorDir().'/gearbox';
    $baseDir = en::baseDir();
    if(file_exists($path)){
			$dir = dir($path);
      while ($view = $dir->read()) {
				if ($view != "." && $view != ".." && is_dir($path.'/'.$view)) {
          $examplePath = $path.'/'.$view.'/example';
          if(file_exists($examplePath)){
            exec("cp -r $examplePath/* $baseDir/");
          }
        }
      }
  }
}
