<?php

namespace agik\Module\Commands;

use Illuminate\Console\Command;


class MakeModules extends Command
{

  public $module_path;
  public $module_name;
  public $module_prefix;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {module_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
      parent::__construct();
      
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

      if(!is_dir(base_path()."/modules")){
        @mkdir(base_path()."/modules");
      }

      $module_name=$this->argument('module_name');
      $module_path=base_path()."/modules/$module_name";

      $this->module_path=$module_path;
      $this->module_name=$module_name;
      $this->module_prefix=strtolower($module_name);

      if(!file_exists($module_path)){
        if($module_name){
          $this->smartCopy(__DIR__."/../template",base_path()."/modules/$module_name");
          $this->info("Module {$module_name} created!");
          $this->createRouteFile();
          $this->createViewFile();
          $this->createControllerFile();
        }else{
          $this->info("Module {$module_name} invalid!");
        }
      }else{
        $this->info("Module {$module_name} Is Exists");
      }


    }

    //copy dir
    public function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755)) 
    { 
      $result=false; 

      if (is_file($source)) { 
        if ($dest[strlen($dest)-1]=='/') { 
          if (!file_exists($dest)) { 
            cmfcDirectory::makeAll($dest,$options['folderPermission'],true); 
          } 
          $__dest=$dest."/".basename($source); 
        } else { 
          $__dest=$dest; 
        } 
        $result=copy($source, $__dest); 
        chmod($__dest,$options['filePermission']); 

      } elseif(is_dir($source)) { 
        if ($dest[strlen($dest)-1]=='/') { 
          if ($source[strlen($source)-1]=='/') { 
                    //Copy only contents 
          } else { 
                    //Change parent itself and its contents 
            $dest=$dest.basename($source); 
            @mkdir($dest); 
            chmod($dest,$options['filePermission']); 
          } 
        } else { 
          if ($source[strlen($source)-1]=='/') { 
                    //Copy parent directory with new name and all its content 
            @mkdir($dest,$options['folderPermission']); 
            chmod($dest,$options['filePermission']); 
          } else { 
                    //Copy parent directory with new name and all its content 
            @mkdir($dest,$options['folderPermission']); 
            chmod($dest,$options['filePermission']); 
          } 
        } 

        $dirHandle=opendir($source); 
        while($file=readdir($dirHandle)) 
        { 
          if($file!="." && $file!="..") 
          { 
           if(!is_dir($source."/".$file)) { 
            $__dest=$dest."/".$file; 
          } else { 
            $__dest=$dest."/".$file; 
          } 
                    //echo "$source/$file ||| $__dest<br />"; 
          $result=$this->smartCopy($source."/".$file, $__dest, $options); 
        } 
      } 
      closedir($dirHandle); 

    } else { 
      $result=false; 
    } 
    return $result; 
  }

    //create route file
  public function createRouteFile(){
    $module_name=$this->module_name;
    $module_path=$this->module_path;
    $module_prefix=$this->module_prefix;

    $route=fopen($module_path.'/routes'.'/web.php', "w");
    $txt_route = "<?php\n";
    $txt_route .="\n";
    $txt_route .="Route::namespace('Modules\\$module_name\App\Http\Controllers')->prefix('$module_prefix')->group(function(){";
    $txt_route .="\n";
    $txt_route .="\n";
    $txt_route .="\n";
    $txt_route .="\n";
    $txt_route .="Route::get('/', 'ExampleController@index');";
    $txt_route .="\n";
    $txt_route .="\n";
    $txt_route .="\n";
    $txt_route .="\n";
    $txt_route .="});";
    fwrite($route, $txt_route);
    fclose($route);
  }

   //create controller file
  public function createControllerFile(){
    $module_name=$this->module_name;
    $module_path=$this->module_path;
    $module_prefix=$this->module_prefix;

    $file=fopen($module_path.'/App/Http/Controllers'.'/ExampleController.php', "w");
    $txt_file = "<?php\n";
    $txt_file .="\n";
    $txt_file .="namespace Modules\\$module_name\App\Http\Controllers;";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="class ExampleController extends \App\Http\Controllers\Controller";
    $txt_file .="\n";
    $txt_file .="{";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="public function __construct()";
    $txt_file .="\n";
    $txt_file .="{";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="}";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="public function index(){";
    $txt_file .="\n";
    $txt_file .="return view('$module_prefix::index');";
    $txt_file .="\n";
    $txt_file .="}";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="}";
    fwrite($file, $txt_file);
    fclose($file);
  }

   //create route file
  public function createViewFile(){
    $module_name=$this->module_name;
    $module_path=$this->module_path;
    $module_prefix=$this->module_prefix;

    $file=fopen($module_path.'/resources/views'.'/index.php', "w");
    $txt_file = "<?php\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="echo '<h1>This $module_name Module</h1>'";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="\n";
    $txt_file .="?>";
    fwrite($file, $txt_file);
    fclose($file);
  }


}
