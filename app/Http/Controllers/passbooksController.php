<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\passbooks;
use App\purchaseheaders;
use App\customers;
use App\accounttrans;
use App\psbkrecords;

 class passbooksController extends Controller{

public function index(){
    $bra=auth()->user()->branchid;  
    return view('passbooks/index')->with('bra',$bra);
}
public function view(){


    if(auth()->user()->branchid==1){
        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branch'])){
       $bra=$_GET['branch'];
            $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
            $this->viewpassbooks(" where branch=$bra and pdate=$today  "); 
           
         
         }
        
         else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['branch'])){
            $date1=date("Y-m-d", strtotime($_GET['date1']));
            $date2=date("Y-m-d", strtotime($_GET['date2']));
            $bra=$_GET['branch'];
           $this->viewpassbooks("where pdate  BETWEEN '$date1' AND '$date2' and branch=$bra");
         
         }
    }else{
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2'])){
        $bra=auth()->user()->branchid;
        $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
      $this->viewpassbooks(" where pdate=$today and branch=$bra"); 
     
     }
    
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $bra=auth()->user()->branchid;
       $this->viewpassbooks("where pdate  BETWEEN '$date1' AND '$date2' and branch=$bra ");
     
     }
    }

    
}
public function save(Request $request){
    DB::beginTransaction();
    try{
        $bra=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
        $Objpurchaseheaders=new purchaseheaders();
        $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['pdate']));
        $Objpurchaseheaders->branch_id=$bra;
        $Objpurchaseheaders->isActive=1;
        $Objpurchaseheaders->save();

        if($request['isNew']==1){
    $Objpassbooks=new passbooks();
$Objpassbooks->id=$request['id'];
$Objpassbooks->pdate=date("Y-m-d", strtotime($request['pdate']));;
$Objpassbooks->memid=$request['memid'];
$Objpassbooks->headerid=$Objpurchaseheaders->id;
$Objpassbooks->amount=str_replace( ',', '',$request['amount']);
$Objpassbooks->paymentno=$request['paymentno'];
$Objpassbooks->pbsn=$request['pbsn'];
$Objpassbooks->isNew=$request['isNew'];
$Objpassbooks->isFunded=$request['isFunded'];
$Objpassbooks->branch=$bra;
$file=$request->file('proof');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objpassbooks->proof=$filename;

}
$Objpassbooks->created_at=$request['created_at'];
$Objpassbooks->updated_at=$request['updated_at'];
$Objpassbooks->save();

$objcustomers= customers::find($request['memid']);
// postingin PSBK RECORDS TABLE 
$objpsbkrecords= new psbkrecords();
$objpsbkrecords->branch=$objcustomers->branchnumber;
$objpsbkrecords->pbkno=$Objpassbooks->id;
$objpsbkrecords->sn=$request['pbsn'];
$objpsbkrecords->isNew=$request['isNew'];
$objpsbkrecords->save();
// Posting to Accounts 


$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['amount']);
$objaccountrans->accountcode=21;
$objaccountrans->narration= $objcustomers->name." Cash Deposit for Passbook";
$objaccountrans->ttype="D";
$objaccountrans->total=str_replace( ',', '',$request['amount']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['pdate']));
$objaccountrans->bracid=$bra;
$objaccountrans->save();

$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['amount']);
$objaccountrans->accountcode=620;
$objaccountrans->narration= $objcustomers->name." Cash Deposit for Passbook";
$objaccountrans->ttype="C";
$objaccountrans->total=str_replace( ',', '',$request['amount']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['pdate']));
$objaccountrans->bracid=$bra;
$isSaved=$objaccountrans->save();
}else{
    $Objpassbooks=new passbooks();
$Objpassbooks->id=$request['id'];
$Objpassbooks->pdate=date("Y-m-d", strtotime($request['pdate']));;
$Objpassbooks->memid=$request['memid'];
$Objpassbooks->headerid=$Objpurchaseheaders->id;
$Objpassbooks->amount=0;
$Objpassbooks->paymentno=$request['paymentno'];
$Objpassbooks->pbsn=$request['pbsn'];
$Objpassbooks->isNew=$request['isNew'];
$Objpassbooks->isFunded=$request['isFunded'];
$Objpassbooks->branch=$bra;
$Objpassbooks->created_at=$request['created_at'];
$Objpassbooks->updated_at=$request['updated_at'];
$Objpassbooks->save();

// Posting to Accounts 
$objcustomers= customers::find($request['memid']);

$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
$objaccountrans->amount=0;
$objaccountrans->accountcode=21;
$objaccountrans->narration= " ";
$objaccountrans->ttype="D";
$objaccountrans->total=0;
$objaccountrans->transdate=date("Y-m-d", strtotime($request['pdate']));
$objaccountrans->bracid=$bra;
$objaccountrans->save();

$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$Objpurchaseheaders->id;
$objaccountrans->amount=0;
$objaccountrans->accountcode=620;
$objaccountrans->narration= " ";
$objaccountrans->ttype="C";
$objaccountrans->total=0;
$objaccountrans->transdate=date("Y-m-d", strtotime($request['pdate']));
$objaccountrans->bracid=$bra;
$isSaved=$objaccountrans->save();

}
    }catch(\Exception $e){
        echo "Failed to save ".$e;
        DB::rollBack();
    }
    DB::commit();
}
//Auto generated code for updating
public function update(Request $request,$id){
    DB::beginTransaction();
    try{
        $bra=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
        $Objpassbooks=passbooks::find($id);
      if($request['isNew']==1 && $request['isFunded']==0){
      
       // $Objpassbooks->id=$request['id'];
        $Objpassbooks->pdate=date("Y-m-d", strtotime($request['pdate']));;
        $Objpassbooks->memid=$request['memid'];
        $Objpassbooks->headerid=$request['headerid'];;
        $Objpassbooks->amount=str_replace( ',', '',$request['amount']);
        $Objpassbooks->paymentno=$request['paymentno'];
        $Objpassbooks->branch=$bra;
        $Objpassbooks->isNew=$request['isNew'];
        $Objpassbooks->isFunded=$request['isFunded'];
        $Objpassbooks->branch=$bra;
        $Objpassbooks->pbsn=$request['pbsn'];
        $Objpassbooks->created_at=$request['created_at'];
        $Objpassbooks->updated_at=$request['updated_at'];
        $Objpassbooks->save();
        $objcustomers= customers::find($request['memid']);
        //Updating 
        accounttrans::where('purchaseheaderid','=',$request['headerid'])->where('ttype','=','D')->update([
'amount'=>str_replace( ',', '',$request['amount']),
'accountcode'=>21,
'narration'=>$objcustomers->name." Cash Deposit for Passbook",
'total'=>str_replace( ',', '',$request['amount']),
'transdate'=>date("Y-m-d", strtotime($request['pdate'])),
'bracid'=>$bra

        ]);
        accounttrans::where('purchaseheaderid','=',$request['headerid'])->where('ttype','=','C')->update([
            'amount'=>str_replace( ',', '',$request['amount']),
            'accountcode'=>620,
            'narration'=>$objcustomers->name." Cash Deposit for Passbook",
            'total'=>str_replace( ',', '',$request['amount']),
            'transdate'=>date("Y-m-d", strtotime($request['pdate'])),
            'bracid'=>$bra
            
                    ]);
        }else{
            $Objpassbooks->pdate=date("Y-m-d", strtotime($request['pdate']));;
            $Objpassbooks->memid=$request['memid'];
            $Objpassbooks->headerid=$request['headerid'];;
            $Objpassbooks->amount=str_replace( ',', '',$request['amount']);
            $Objpassbooks->paymentno=$request['paymentno'];
            $Objpassbooks->branch=$bra;
            $Objpassbooks->isNew=$request['isNew'];
            $Objpassbooks->isFunded=$request['isFunded'];
            $Objpassbooks->branch=$bra;
            $Objpassbooks->created_at=$request['created_at'];
            $Objpassbooks->updated_at=$request['updated_at'];
            $Objpassbooks->save();
            $objcustomers= customers::find($request['memid']);
            //Updating 
            accounttrans::where('purchaseheaderid','=',$request['headerid'])->where('ttype','=','D')->update([
    'amount'=>str_replace( ',', '',$request['amount']),
    'accountcode'=>21,
    'narration'=>$objcustomers->name." Cash Deposit for Passbook",
    'total'=>str_replace( ',', '',$request['amount']),
    'transdate'=>date("Y-m-d", strtotime($request['pdate'])),
    'bracid'=>$bra
    
            ]);
            accounttrans::where('purchaseheaderid','=',$request['headerid'])->where('ttype','=','C')->update([
                'amount'=>str_replace( ',', '',$request['amount']),
                'accountcode'=>620,
                'narration'=>$objcustomers->name." Cash Deposit for Passbook",
                'total'=>str_replace( ',', '',$request['amount']),
                'transdate'=>date("Y-m-d", strtotime($request['pdate'])),
                'bracid'=>$bra
                
                        ]); 
        }

    }catch(\Exception $e){
        echo "failed to Save ".$e;
        DB::rollBack();

    }
    DB::commit();
}
 public function destroy($id){
     DB::beginTransaction();
     try{
        $Objpassbooks=passbooks::find($id);
        purchaseheaders::where('id','=',$Objpassbooks->headerid)->delete();
        accounttrans::where('purchaseheaderid','=',$Objpassbooks->headerid)->delete();
        $Objpassbooks->delete();
        psbkrecords::where('pbkno',$id)->delete();
     }catch(\Exception $e){
         echo "Failed to save ".$e;
         DB::rollBack();
     }
DB::commit();


    }

public function viewcombo(){


    return passbooks::all();
}
public function viewpassbooks($where){
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("select COUNT(*) as count from passbooks inner join customers on customers.id=passbooks.memid $where");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare("select *,if(passbooks.isFunded=1,'YES','NO') as isFundedB,if(passbooks.isNew=1,'YES','NO') as isNewB,passbooks.isFunded,passbooks.isNew,passbooks.id,name,DATE_FORMAT(pdate,'%d-%m-%Y') as pdate,format(amount,0) as amount from passbooks inner join customers on customers.id=passbooks.memid $where limit $offset,$rows");
    $rst->execute();
    $dogs = $rst->fetchAll(\PDO::FETCH_OBJ);
    $results["rows"]=$dogs;


$footer =  DB::getPdo()->prepare("select format(sum(amount),0) as amount from passbooks inner join customers on customers.id=passbooks.memid $where ");
$footer->execute();
$foots=$footer->fetchAll(\PDO::FETCH_OBJ);
$results['footer']=$foots;
echo json_encode($results);  
}
public function passbookdetails($id){
$objpassbooks=DB::select("select *,DATE_FORMAT(pdate,'%d-%m-%Y')as pdate,format(amount,0) as amount from passbooks inner join customers on customers.id=passbooks.memid where passbooks.id=$id");
//return $objpassbooks;
return view('passbookdetails.index')->with('passbooks',$objpassbooks);
}
}