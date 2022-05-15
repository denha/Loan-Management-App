<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\psbkrecords;

 class psbkrecordsController extends Controller{

public function index(){
    return view('psbkrecords/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from psbkrecords ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from psbkrecords limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objpsbkrecords=new psbkrecords();
$Objpsbkrecords->id=$request['id'];
$Objpsbkrecords->branch=$request['branch'];
$Objpsbkrecords->pbkno=$request['pbkno'];
$Objpsbkrecords->sn=$request['sn'];
$Objpsbkrecords->isNew=$request['isNew'];
$Objpsbkrecords->created_at=$request['created_at'];
$Objpsbkrecords->updated_at=$request['updated_at'];
$Objpsbkrecords->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objpsbkrecords=psbkrecords::find($id);

$Objpsbkrecords->id=$request['id'];
$Objpsbkrecords->branch=$request['branch'];
$Objpsbkrecords->pbkno=$request['pbkno'];
$Objpsbkrecords->sn=$request['sn'];
$Objpsbkrecords->isNew=$request['isNew'];
$Objpsbkrecords->created_at=$request['created_at'];
$Objpsbkrecords->updated_at=$request['updated_at'];
$Objpsbkrecords->save();
}
 public function destroy($id){
        $Objpsbkrecords=psbkrecords::find($id);
        $Objpsbkrecords->delete();



    }

public function viewcombo(){


    return psbkrecords::all();
}
}