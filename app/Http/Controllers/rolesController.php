<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\roles;

 class rolesController extends Controller{

public function index(){
    return view('roles/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from roles ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from roles limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objroles=new roles();
$Objroles->id=$request['id'];
$Objroles->name=$request['name'];
$Objroles->created_at=$request['created_at'];
$Objroles->updated_at=$request['updated_at'];
$Objroles->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objroles=roles::find($id);

$Objroles->id=$request['id'];
$Objroles->name=$request['name'];
$Objroles->created_at=$request['created_at'];
$Objroles->updated_at=$request['updated_at'];
$Objroles->save();
}
 public function destroy($id){
        $Objroles=roles::find($id);
        $Objroles->delete();



    }

public function viewcombo(){


    return roles::all();
}
}