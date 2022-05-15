<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\groupmembers;

 class groupmembersController extends Controller{

public function index(){
    return view('groupmembers/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from groupmembers ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from groupmembers limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objgroupmembers=new groupmembers();
$Objgroupmembers->id=$request['id'];
$Objgroupmembers->groupid=$request['groupid'];
$Objgroupmembers->memberid=$request['memberid'];
$Objgroupmembers->created_at=$request['created_at'];
$Objgroupmembers->updated_at=$request['updated_at'];
$Objgroupmembers->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objgroupmembers=groupmembers::find($id);

$Objgroupmembers->id=$request['id'];
$Objgroupmembers->groupid=$request['groupid'];
$Objgroupmembers->memberid=$request['memberid'];
$Objgroupmembers->created_at=$request['created_at'];
$Objgroupmembers->updated_at=$request['updated_at'];
$Objgroupmembers->save();
}
 public function destroy($id){
        $Objgroupmembers=groupmembers::find($id);
        $Objgroupmembers->delete();



    }

public function viewcombo(){


    return groupmembers::all();
}
}