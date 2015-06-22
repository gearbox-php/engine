<?

namespace Gearbox\Engine;
use Gearbox\Engine as en;

class Scripts{

  static function createFileExample(){
    $path = en::vendorDir().'/gearbox';
    $baseDir = en::baseDir();
    if(file_exists($path)){
			$dir = dir($path);
      while ($gear = $dir->read()) {
				if ($gear != "." && $gear != ".." && is_dir($path.'/'.$gear)) {
          $examplePath = $path.'/'.$gear.'/examples';
          if(file_exists($examplePath)){
            $command = ("cp -r $examplePath/* $baseDir/");
            echo $command."\n";
            exec($command);
          }
        }
      }
    }
  }
}
