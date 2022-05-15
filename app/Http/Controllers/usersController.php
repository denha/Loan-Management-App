<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\users;

 class usersController extends Controller{

public function index(){
    return view('users/index');
}
public function view(){
$bra=auth()->user()->branchid;
if($bra==1){
        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select Count(*) as count ,companys.name as cname,users.id,users.name,users.email,if(admin=1,'Administrator','User') as level,admin from users inner join companys on companys.id=users.branchid where users.id!=1");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select companys.name as cname,users.id,users.name,users.email,roles.name as level,admin from users inner join companys on companys.id=users.branchid inner join roles on roles.id=users.admin where branchid=$bra and users.id!=1 limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);
}else{
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("select COUNT(*) as count from users inner join companys on companys.id=users.branchid inner join roles on roles.id=users.admin where users.id=$bra ");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare("select companys.name as cname,users.id,users.name,users.email,roles.name as level,admin from users inner join companys on companys.id=users.branchid inner join roles on roles.id=users.admin where branchid=$bra  limit $offset,$rows");
    $rst->execute();

    $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
   $results['rows']=$viewall;
   echo json_encode($results);   
}

    
}
public function save(Request $request){
    DB::beginTransaction();
    try{
        $bra1=auth()->user()->branchid;
        $email=$request['email'];
        $emailz=DB::select("select * from users where email='$email'");
        if(count($emailz)>0){
            return ['email'=>'exist'];
        }else{
    if($bra1==1){
        $bra=$request['branch'];;
        $company=DB::select("select name from companys where id=$bra");
        $companyname='';
        foreach($company as $c){
            $companyname=$c->name;
        }
        $Objusers=new users();
        //$Objusers->id=$request['id'];
        $Objusers->name=$request['name'];
        $Objusers->email=$request['email'];
        $Objusers->password=bcrypt($request['password']);
        $Objusers->admin=1;
        $Objusers->branchname=$companyname;
        $Objusers->branchid=$request['branch'];;
        $Objusers->isAdmin=0;
        $Objusers->admin=$request['roles'];
        $Objusers->remember_token=$request['remember_token'];
        $Objusers->created_at=$request['created_at'];
        $Objusers->updated_at=$request['updated_at'];
        //$Objusers->branchid=$request['branch'];//$auth()->user()->name;//
        
        $Objusers->save();
    }else{
        $bra=auth()->user()->branchid;
        $company=DB::select("select name from companys where id=$bra");
        $companyname='';
        foreach($company as $c){
            $companyname=$c->name;
        }
    $Objusers=new users();
$Objusers->id=$request['id'];
$Objusers->name=$request['name'];
$Objusers->email=$request['email'];
$Objusers->password=bcrypt($request['password']);
$Objusers->admin=$request['roles'];
$Objusers->branchname=$companyname;
$Objusers->branchid=$bra;
$Objusers->isAdmin=0;
$Objusers->admin=$request['roles'];
$Objusers->remember_token=$request['remember_token'];
$Objusers->created_at=$request['created_at'];
$Objusers->updated_at=$request['updated_at'];
//$Objusers->branchid=$request['branch'];//$auth()->user()->name;//

$Objusers->save();
    }
}
    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();
    }
    DB::commit();
}
//Auto generated code for updating
public function update(Request $request,$id){
    DB::beginTransaction();
    try{
        $bra=auth()->user()->branchid;
        $company=DB::select("select name from companys where id=$bra");
        $companyname='';
        foreach($company as $c){
            $companyname=$c->name;
        }
        $Objusers=users::find($id);

//$Objusers->id=$request['id'];
$Objusers->name=$request['name'];
//$Objusers->email=$request['email'];
$Objusers->password=bcrypt($request['password']);
$Objusers->admin=$request['roles'];
$Objusers->isAdmin=0;
$Objusers->branchname=$companyname;
$Objusers->branchid=$bra;
$Objusers->remember_token=$request['remember_token'];
$Objusers->created_at=$request['created_at'];
$Objusers->updated_at=$request['updated_at'];
$Objusers->save();
    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();
    }
    DB::commit();
}
 public function destroy($id){
        $Objusers=users::find($id);
        $Objusers->delete();



    }

public function viewcombo(){


    return users::all();
}
}
