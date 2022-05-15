<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\customers;
use App\regmembers;

 class customersController extends Controller{

public function index(){
    $bra=auth()->user()->branchid;  
    return view('customers/index')->with('bra',$bra);
}
public function view(){
$bra=auth()->user()->branchid;
if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['findname']) && empty($_GET['branch'])){
    $memid=$_GET['findname'];
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("select COUNT(*) as count from regmembers inner join customers on customers.id=regmembers.memeberid where customers.branchnumber=$bra and regmembers.id=$memid and isFunded=1");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare("select *,DATE_FORMAT(registrationdate,'%d-%m-%Y') registrationdate,DATE_FORMAT(witnessdate,'%d-%m-%Y') witnessdate,DATE_FORMAT(dob,'%d-%m-%Y')  as dob,DATE_FORMAT(kindob,'%d-%m-%Y') as kindob from regmembers inner join customers on customers.id=regmembers.memeberid where customers.branchnumber=$bra and customers.id=$memid and isFunded=1 order by name,acno asc limit $offset,$rows");
    $rst->execute();

    $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
   $results['rows']=$viewall;
   echo json_encode($results);

}else if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['findname']) && !empty($_GET['branch'])){
    $bra=$_GET['branch'];
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("select COUNT(*) as count from regmembers inner join customers on customers.id=regmembers.id where customers.branchnumber=$bra and isFunded=1 and regmembers.isActive=2 ");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare("select *,regmembers.acno,DATE_FORMAT(registrationdate,'%d-%m-%Y') registrationdate,DATE_FORMAT(witnessdate,'%d-%m-%Y') witnessdate,DATE_FORMAT(dob,'%d-%m-%Y')  as dob,DATE_FORMAT(kindob,'%d-%m-%Y') as kindob from regmembers inner join customers on customers.id=regmembers.id  where customers.branchnumber=$bra and isFunded=1 and regmembers.isActive=2 order by customers.name,customers.acno asc limit $offset,$rows");
    $rst->execute();

    $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
   $results['rows']=$viewall;
   echo json_encode($results);
    
}else{
    $bra=$bra=auth()->user()->branchid==1?0:$bra=auth()->user()->branchid;

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select COUNT(*) as count from regmembers inner join customers on customers.id=regmembers.id  where customers.branchnumber=$bra and isFunded=1 and regmembers.isActive=2");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select *,regmembers.acno,customers.name,DATE_FORMAT(registrationdate,'%d-%m-%Y') registrationdate,DATE_FORMAT(witnessdate,'%d-%m-%Y') witnessdate,DATE_FORMAT(dob,'%d-%m-%Y')  as dob,DATE_FORMAT(kindob,'%d-%m-%Y') as kindob from regmembers inner join customers on customers.id=regmembers.id  where customers.branchnumber=$bra and isFunded=1 and regmembers.isActive=2 order by customers.name asc limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);
}
//echo "dd";
    
}
public function save(Request $request){
    
    DB::beginTransaction();
    try{
        $branch=auth()->user()->branchid==1?$request['company']:$branch=auth()->user()->branchid;
        $acno=$request['acno'];
$checkacno=DB::select("select * from regmembers where acno='$acno'");
// if(count($checkacno)==0){
    $Objregmembers=new regmembers();
//$Objregmembers->id=$request['id'];
$Objregmembers->name=$request['name'];
$Objregmembers->id=$request['name'];
$Objregmembers->sex=$request['sex'];
$Objregmembers->dob=date("Y-m-d", strtotime($request['dob']));
$Objregmembers->address=$request['address'];
$Objregmembers->telephone1=$request['telephone1'];
$Objregmembers->telephone2=$request['telephone2'];
$Objregmembers->email=$request['email'];
$Objregmembers->district=$request['district'];
$Objregmembers->subcounty=$request['subcounty'];
$Objregmembers->parish=$request['parish'];
$Objregmembers->village=$request['village'];
$Objregmembers->religion=$request['religion'];
$Objregmembers->church=$request['church'];
$Objregmembers->education=$request['education'];
$Objregmembers->occupation=$request['occupation'];
$Objregmembers->marital=$request['marital'];
$Objregmembers->nochildren=$request['nochildren'];
$Objregmembers->namechildren=$request['namechildren'];
$Objregmembers->kinname=$request['kinname'];
$Objregmembers->kinsex=$request['kinsex'];
$Objregmembers->kindob=date("Y-m-d", strtotime($request['kindobs']));
$Objregmembers->kinoccupation=$request['kinoccupation'];
$Objregmembers->contactadd=$request['contactadd'];
$Objregmembers->kinemail=$request['kinemail'];
$Objregmembers->kintelephone1=$request['kintelephone1'];
$Objregmembers->kintelephone2=$request['kintelephone2'];
$Objregmembers->witnessname=$request['witnessname'];
$Objregmembers->witnessdate=date("Y-m-d", strtotime($request['witnessdate']));
$Objregmembers->registrationdate=date("Y-m-d", strtotime($request['registrationdate']));
$Objregmembers->acno=$request['acno'];
$Objregmembers->branchnumber=$branch;//auth()->user()->branchid;
$Objregmembers->isActive=2;

$Objregmembers->bname=$request['bname'];
$Objregmembers->baddress=$request['baddress'];
$Objregmembers->iscop=$request['cop'];
$Objregmembers->bperiod=$request['cbperiod'];

$Objregmembers->created_at=$request['created_at'];
$Objregmembers->updated_at=$request['updated_at'];
$file=$request->file('logo');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objregmembers->photo=$filename;

}
$result=$Objregmembers->save();//){
   // return ['return'=>$result];

//}



 /*}else{
     return ['checkacno'=>'exists'];
 }*/
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
        $branch=auth()->user()->branchid==1?$request['company']:$branch=auth()->user()->branchid;
        $Objregmembers=regmembers::find($id);

//$Objregmembers->membid=$request['name'];
$Objregmembers->name=$request['name'];
$Objregmembers->sex=$request['sex'];
$Objregmembers->dob=date("Y-m-d", strtotime($request['dob']));
$Objregmembers->address=$request['address'];
$Objregmembers->telephone1=$request['telephone1'];
$Objregmembers->telephone2=$request['telephone2'];
$Objregmembers->email=$request['email'];
$Objregmembers->district=$request['district'];
$Objregmembers->subcounty=$request['subcounty'];
$Objregmembers->parish=$request['parish'];
$Objregmembers->village=$request['village'];
$Objregmembers->religion=$request['religion'];
$Objregmembers->church=$request['church'];
$Objregmembers->education=$request['education'];
$Objregmembers->occupation=$request['occupation'];
$Objregmembers->marital=$request['marital'];
$Objregmembers->nochildren=$request['nochildren'];
$Objregmembers->namechildren=$request['namechildren'];
$Objregmembers->kinname=$request['kinname'];
$Objregmembers->kinsex=$request['kinsex'];
$Objregmembers->kindob=date("Y-m-d", strtotime($request['kindobs']));
$Objregmembers->kinoccupation=$request['kinoccupation'];
$Objregmembers->contactadd=$request['contactadd'];
$Objregmembers->kinemail=$request['kinemail'];
$Objregmembers->kintelephone1=$request['kintelephone1'];
$Objregmembers->kintelephone2=$request['kintelephone2'];
$Objregmembers->witnessname=$request['witnessname'];
$Objregmembers->witnessdate=date("Y-m-d", strtotime($request['witnessdate']));
$Objregmembers->registrationdate=date("Y-m-d", strtotime($request['registrationdate']));
$Objregmembers->acno=$request['acno'];
$Objregmembers->branchnumber=$branch;
$Objregmembers->isActive=2;
$Objregmembers->bname=$request['bname'];
$Objregmembers->baddress=$request['baddress'];
$Objregmembers->iscop=$request['cop'];
$Objregmembers->bperiod=$request['cbperiod'];
$Objregmembers->created_at=$request['created_at'];
$Objregmembers->updated_at=$request['updated_at'];
$file=$request->file('logo');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objregmembers->photo=$filename;

}
$isSaved=$Objregmembers->save();
//return ['isSaved'=>'1'];

    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();
    }
    DB::commit();
}
 public function destroy($id){
        $Objregmembers=regmembers::find($id);
       $client= DB::select("select sum(if(loanint1<0,abs(loanint1),0))+sum(if(loanpdt1<0,abs(loanpdt1),0))+sum(ansub)+sum(memship)+if(savingpdt1>0,sum(savingpdt1),0)+sum(if(shares>0,shares,0)) as total  from allsavings inner join customers on customers.id=allsavings.client_no  where customers.id=$id ");
       foreach($client as $cli){
           if($cli->total>0){
 return ['isdelete'=>'No'];
           }else{
            $Objregmembers->delete();
           }
       }
        



    }

public function viewcombo(){


    $bra=auth()->user()->branchid;

        return  DB::select("select customers.id as id, customers.name as name  from customers where branchnumber=$bra group by customers.id order by name asc");
}
public function viewcomboBranch($id){


return  DB::select("select customers.id as id, customers.name as name  from customers where branchnumber=$id group by customers.id order by name asc");
}
public function importnames(Request $request){
    DB::beginTransaction();
    try{
    $file=$request->file('files');
    $destinationPath="images";
    if($file!=Null){
        $filename=$file->getClientOriginalName();
        //moving it to the folder
        $finalfile=$file->move($destinationPath,$filename);
        
        $handle = fopen($finalfile, "r");
while(($data=fgetcsv($handle,1000,","))!==FALSE  ){
    $bra=auth()->user()->branchid;
    $customers = new customers();
    $customers->name=$data[0];
    $customers->acno=$data[1];
    $customers->branchnumber=auth()->user()->branchid;
    $customers->save();


}
    }


    }catch(\Exception $e){

        echo "Failed ".$e;
        DB::rollBack();
    }
    DB::commit();
}
public function fundedMembers($id){

return DB::select("select customers.id,name,branchnumber from customers where isFunded=1 and branchnumber=$id");

}
}