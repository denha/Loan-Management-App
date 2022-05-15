<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\cycles;

 class cyclesController extends Controller{

public function index(){
    return view('cycles/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from cycles ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from cycles limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objcycles=new cycles();
$Objcycles->id=$request['id'];
$Objcycles->cycle=$request['cycle'];
$Objcycles->memid=$request['memid'];
$Objcycles->created_at=$request['created_at'];
$Objcycles->updated_at=$request['updated_at'];
$Objcycles->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objcycles=cycles::find($id);

$Objcycles->id=$request['id'];
$Objcycles->cycle=$request['cycle'];
$Objcycles->memid=$request['memid'];
$Objcycles->created_at=$request['created_at'];
$Objcycles->updated_at=$request['updated_at'];
$Objcycles->save();
}
 public function destroy($id){
        $Objcycles=cycles::find($id);
        $Objcycles->delete();



    }

public function viewcombo(){


    return cycles::all();
}
}