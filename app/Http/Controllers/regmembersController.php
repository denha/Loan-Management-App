<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\purchaseheaders;
use App\accounttrans;
use App\customers;
use App\regmembers;

 class regmembersController extends Controller{

public function index(){
    $bra=auth()->user()->branchid;  

    return view('regmembers/index')->with('bra',$bra);
}
public function view(){

    if(auth()->user()->branchid==1){
        if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['branch'])){
       $bra=$_GET['branch'];
            $this->viewmembers($bra);  
         }

    }else{
    if(isset($_GET['page'])&& isset($_GET['rows'])){
        $bra=auth()->user()->branchid;
        $this->viewmembers($bra); 
     
     }
    
    }
}
public function viewmembers($where){
    //$bra=auth()->user()->branchid;
        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select COUNT(*) as count from customers  where branchnumber=$where ");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select *,customers.id as id,if(isNew=1,'YES','NO') as Newb, isNew ,format(fees,0) as memfees,marital,DATE_FORMAT(memdate,'%d-%m-%Y') memdate,customers.id as id,customers.education  from customers   where branchnumber=$where ORDER BY name asc limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    DB::beginTransaction();
    try{
        $bra=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
        $no=$request['name'];
        $checkacno=DB::select("select * from customers where regno='$no'");
        // if(count($checkacno)==0){
            
$Objpurchaseheaders=new purchaseheaders();
$Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['memdate']));
$Objpurchaseheaders->mode=$request['mode'];
$Objpurchaseheaders->supplier_id=$request['supplier_id'];
$Objpurchaseheaders->branch_id=$bra;
$Objpurchaseheaders->isActive=1;
$Objpurchaseheaders->save();
    $Objcustomers=new customers();

//$Objcustomers->id=$request['id'];
$Objcustomers->branchnumber=$bra;
$Objcustomers->name=$request['name'];
$Objcustomers->donorname=$request['donorname'];
$Objcustomers->isFunded=$request['isFunded'];
$Objcustomers->header=$Objpurchaseheaders->id;
$Objcustomers->tel=$request['tel'];
$Objcustomers->gender=$request['gender'];
$Objcustomers->marital=$request['marital'];
$Objcustomers->dependents=$request['dependents'];
$Objcustomers->spousename=$request['spousename'];
$Objcustomers->education=$request['education'];
$Objcustomers->busclass=$request['busclass'];
$Objcustomers->bustype=$request['bustype'];
$Objcustomers->buslocation=$request['buslocation'];
$Objcustomers->lengthinbus=$request['lengthinbus'];
$Objcustomers->ownership=$request['ownership'];
$Objcustomers->placeofresidence=$request['placeofresidence'];
$Objcustomers->nxtkinname=$request['nxtkinname'];
$Objcustomers->nxtofkinconc=$request['nxtofkinconc'];
$Objcustomers->nxtkinrship=$request['nxtkinrship'];
$Objcustomers->nxtkinnin=$request['nxtkinnin'];
$Objcustomers->sourceofinc=$request['sourceofinc'];
$Objcustomers->challenges=$request['challenges'];
$Objcustomers->borrowedfrombank=$request['borrowedfrombank'];
$Objcustomers->pendingloan=$request['pendingloan'];
$Objcustomers->howmuch=$request['howmuch'];
$Objcustomers->busearn=$request['busearn'];
$Objcustomers->isNew=$request['isNew'];
$Objcustomers->fees=str_replace( ',', '',$request['memfees']);//$request['memfees'];
$Objcustomers->memdate=date("Y-m-d", strtotime($request['memdate']));
$Objcustomers->created_at=$request['created_at'];
$Objcustomers->updated_at=$request['updated_at'];
$file=$request->file('photo');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->photo=$filename;

}
$file=$request->file('memform');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->formphoto=$filename;

}
$file=$request->file('memform2');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->formphoto2=$filename;

}
$file=$request->file('memform3');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->formphoto3=$filename;

}
$file=$request->file('proofofpayment');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment=$filename;

}
$file=$request->file('proofofpayment2');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment2=$filename;

}
$file=$request->file('proofofpayment3');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment3=$filename;

}
$file=$request->file('proofofpayment4');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment4=$filename;

}
$Objcustomers->save();

$objregmembers=new regmembers();
$objregmembers->id=$Objcustomers->id;
$objregmembers->branchnumber=$bra;
$objregmembers->save();
// Dealing with Registration Fees
// Accounting 
//$objcusto=customers::find($request['name']);

if($request['isNew']==1 && $request['isFunded']==0){
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['memfees']);
$objaccountrans->accountcode=21;
$objaccountrans->narration= $request['name']." Cash Deposit for Memship fees";
$objaccountrans->ttype="D";
$objaccountrans->total=str_replace( ',', '',$request['memfees']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['memdate']));
$objaccountrans->bracid=$bra;
$objaccountrans->save();

$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['memfees']);
$objaccountrans->accountcode=604;
$objaccountrans->narration=  $request['name']." Cash Deposit for Memship fees";
$objaccountrans->ttype="C";
$objaccountrans->total=str_replace( ',', '',$request['memfees']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['memdate']));
$objaccountrans->bracid=$bra;
$isSaved=$objaccountrans->save();
}else{
    


    $objaccountrans=new accounttrans;
    $objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
    $objaccountrans->amount=0;
    $objaccountrans->accountcode=21;
    $objaccountrans->narration= 0;
    $objaccountrans->ttype="D";
    $objaccountrans->total=0;
    $objaccountrans->transdate=date("Y-m-d", strtotime($request['memdate']));
    $objaccountrans->bracid=$bra;
    $objaccountrans->save();
    
    $objaccountrans=new accounttrans;
    $objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
    $objaccountrans->amount=0;
    $objaccountrans->accountcode=604;
    $objaccountrans->narration= 0;
    $objaccountrans->ttype="C";
    $objaccountrans->total=0;
    $objaccountrans->transdate=date("Y-m-d", strtotime($request['memdate']));
    $objaccountrans->bracid=$bra;
    $isSaved=$objaccountrans->save();  
}
        /* }else{

            return ['exists'=>'true'];
         }*/
   // return ['saved'=>true];
//}


    }catch(\Exception $e){
        echo "Failed to Save ".$e;
        DB::rollBack();
    }
    DB::commit();
}
//Auto generated code for updating
public function update(Request $request,$id){
    DB::beginTransaction();
    try{
    $bra=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
        $Objcustomers=customers::find($id);
        $Objcustomers->branchnumber=$bra;
//$Objcustomers->id=$request['id'];
$Objcustomers->name=$request['name'];
//$Objcustomers->regno=$request['name'];
$objcusto=customers::find($request['name']);
$Objcustomers->branchnumber=$bra;
$Objcustomers->gender=$request['gender'];
$Objcustomers->isFunded=$request['isFunded'];
$Objcustomers->donorname=$request['donorname'];
$Objcustomers->marital=$request['marital'];
$Objcustomers->tel=$request['tel'];
$Objcustomers->dependents=$request['dependents'];
$Objcustomers->spousename=$request['spousename'];
$Objcustomers->education=$request['education'];
$Objcustomers->busclass=$request['busclass'];
$Objcustomers->bustype=$request['bustype'];
$Objcustomers->buslocation=$request['buslocation'];
$Objcustomers->lengthinbus=$request['lengthinbus'];
$Objcustomers->ownership=$request['ownership'];
$Objcustomers->placeofresidence=$request['placeofresidence'];
$Objcustomers->nxtkinname=$request['nxtkinname'];
$Objcustomers->nxtofkinconc=$request['nxtofkinconc'];
$Objcustomers->nxtkinrship=$request['nxtkinrship'];
$Objcustomers->nxtkinnin=$request['nxtkinnin'];
$Objcustomers->sourceofinc=$request['sourceofinc'];
$Objcustomers->challenges=$request['challenges'];
$Objcustomers->borrowedfrombank=$request['borrowedfrombank'];
$Objcustomers->pendingloan=$request['pendingloan'];
$Objcustomers->howmuch=$request['howmuch'];
$Objcustomers->isNew=$request['isNew'];
$Objcustomers->busearn=$request['busearn'];
$Objcustomers->fees=str_replace( ',', '',$request['memfees']);//$request['memfees'];
$Objcustomers->memdate=date("Y-m-d", strtotime($request['memdate']));
$Objcustomers->created_at=$request['created_at'];
$Objcustomers->updated_at=$request['updated_at'];
$file=$request->file('photo');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->photo=$filename;

}
$file=$request->file('memform');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->formphoto=$filename;

}
$file=$request->file('memform2');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->formphoto2=$filename;

}
$file=$request->file('memform3');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->formphoto3=$filename;

}
$file=$request->file('proofofpayment');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment=$filename;

}
$file=$request->file('proofofpayment2');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment2=$filename;

}
$file=$request->file('proofofpayment3');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment3=$filename;

}
$file=$request->file('proofofpayment4');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objcustomers->proofpayment4=$filename;

}
$Objcustomers->save();

// Dealing with Registration Fees
// Accounting 
if($request['isNew']==1 && $request['isFunded']==0){
accounttrans::where('purchaseheaderid','=',$request['header'])->where('accountcode','=',21)->update([
'amount'=>str_replace( ',', '',$request['memfees']),
'narration'=>$request['name'].' Cash Deposit for Memship fees',
'total'=>str_replace( ',', '',$request['memfees']),
'transdate'=>date("Y-m-d", strtotime($request['memdate'])),

]);

accounttrans::where('purchaseheaderid','=',$request['header'])->where('accountcode','=',604)->update([
    'amount'=>str_replace( ',', '',$request['memfees']),
    'narration'=>$request['name'].' Cash Deposit for Memship fees',
    'total'=>str_replace( ',', '',$request['memfees']),
    'transdate'=>date("Y-m-d", strtotime($request['memdate'])),
    
    ]);
}else{
echo $id;
    $objregmembers= regmembers::find($id);
    if($request['isFunded']==1){
        $objregmembers->isActive=2;
    }else{
        $objregmembers->isActive=0;
    }

    $objregmembers->save();
    
    accounttrans::where('purchaseheaderid','=',$request['header'])->where('accountcode','=',21)->update([
        'amount'=>0,
        'narration'=>'',
        'total'=>0,
        'transdate'=>date("Y-m-d", strtotime($request['memdate'])),
        
        ]);
        
        accounttrans::where('purchaseheaderid','=',$request['header'])->where('accountcode','=',604)->update([
            'amount'=>0,
            'narration'=>'',
            'total'=>0,
            'transdate'=>date("Y-m-d", strtotime($request['memdate'])),
            
            ]);
           

}

//return ['yes'=>true];

//$Objcustomers->save();
    }catch(\Exception $e){
        echo "Failed to Update".$e;
        DB::rollBack();
    }
    DB::commit();
}
 public function destroy($id){
     $records=DB::select("select * from loaninfos where memeberid=$id");
     if(count($records)>0){
        return ['hasRecords'=>'yes']; 
     }else{
    $role=auth()->user()->admin;
    if($role==1 || $role==6){
        $Objcustomers=customers::find($id);
        $Objcustomers->delete();
    }else{
        return['failed'=>true];
    }

     }


    }

public function viewcombo(){


    return customers::all();
}
public function memberdetails($id){
    $details=DB::select("select customers.*,photo as photo,name as names,DATE_FORMAT(memdate,'%d-%m-%Y') memdate from customers where id=$id");
    //$details=customers::where('regno','=',$id)->get();
    //return $details;
    return view('memberdetails.index')->with('details',$details);
}
public function registeredMembers($id){
return DB::select("select customers. id, customers.name as name  from customers inner join loaninfos on loaninfos.memeberid=customers.id where isApprove=4 and branchnumber=$id group by memeberid");
}
}