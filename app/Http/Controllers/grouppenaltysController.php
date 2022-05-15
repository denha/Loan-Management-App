<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\grouppenaltys;

 class grouppenaltysController extends Controller{

public function index(){
    return view('grouppenaltys/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from grouppenaltys ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from grouppenaltys limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objgrouppenaltys=new grouppenaltys();
$Objgrouppenaltys->id=$request['id'];
$Objgrouppenaltys->penalty=$request['penalty'];
$Objgrouppenaltys->groupid=$request['groupid'];
$Objgrouppenaltys->memberid=$request['memberid'];
$Objgrouppenaltys->date=$request['date'];
$Objgrouppenaltys->created_at=$request['created_at'];
$Objgrouppenaltys->updated_at=$request['updated_at'];
$Objgrouppenaltys->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objgrouppenaltys=grouppenaltys::find($id);

$Objgrouppenaltys->id=$request['id'];
$Objgrouppenaltys->penalty=$request['penalty'];
$Objgrouppenaltys->groupid=$request['groupid'];
$Objgrouppenaltys->memberid=$request['memberid'];
$Objgrouppenaltys->date=$request['date'];
$Objgrouppenaltys->created_at=$request['created_at'];
$Objgrouppenaltys->updated_at=$request['updated_at'];
$Objgrouppenaltys->save();
}
 public function destroy($id){
        $Objgrouppenaltys=grouppenaltys::find($id);
        $Objgrouppenaltys->delete();



    }

public function viewcombo(){


    return grouppenaltys::all();
}
}