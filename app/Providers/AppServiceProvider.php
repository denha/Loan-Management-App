<?php

namespace App\Providers;
use App\modules;
use App\requirements;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function menu(){
        $fil=fopen("example.txt","a");
        $result = DB::select('select name,id from modules');
        foreach($result as $row)
        {
            fwrite($fil,$row->name);
            //view()->share('sidemenu',$result);
            $result1 = DB::select("SELECT * FROM requirements WHERE  module_id=$row->id");
            foreach($result1 as $row1)
            {
                fwrite($fil,$row1->name);
               // view()->share('req',$result1); 
            }
            //fwrite($fil,"</ul></li></ul>");
        }
        
           
          
        
      
        
        
    }

    public function boot()
    {
        //
        
        $this->menu();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
