<?php 
 namespace App\Http\Controllers;
 date_default_timezone_set("Africa/Nairobi");
use Illuminate\Http\Request;
 use App\memberinfos;
 use App\loantrans;
 use App\loaninfo;
 use App\purchaseheaders;
 use App\accounttrans;
 use App\loanschedules;
 use App\loanproducts;
 use App\allsavings;
 use App\savings;
 use App\loanfees;
 use App\loanrepayments;
 use App\savingdefinations;
 use Illuminate\Support\Facades\DB;
 class suppliersController extends Controller{

public function index(){
$bra=auth()->user()->branchid;  
$loanfees=loanfees::where('isActive','=','1')->where('branchno',$bra)->get();
$officeid=auth()->user()->id;
$officername=auth()->user()->name;
    return view('suppliers/index')->with('loanfees',$loanfees)->with('officername',$officername)->with('officeid',$officeid);;
}
public function listloanapprovalfinal(){

    if(auth()->user()->branchid==1){
        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branch'])){
       $bra=$_GET['branch'];
            $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
            $this->viewlistloanapprovalfinal("branchid=$bra and applicationdate<=$today   "); 
           
         
         }
        
         else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['branch'])){
            $date1=date("Y-m-d", strtotime($_GET['date1']));
            $date2=date("Y-m-d", strtotime($_GET['date2']));
            $bra=$_GET['branch'];
           $this->viewlistloanapprovalfinal("applicationdate  BETWEEN '$date1' AND '$date2' and branchid=$bra");
         
         }
    }else{
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2'])){
        $bra=auth()->user()->branchid;
        $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
        $this->viewlistloanapprovalfinal(" applicationdate<=$today and branchid=$bra"); 
     
     }
    
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $bra=auth()->user()->branchid;
       $this->viewlistloanapprovalfinal(" applicationdate  BETWEEN '$date1' AND '$date2' and branchid=$bra ");
     
     }
    }
}
public function listloanapproval(){

    if(auth()->user()->branchid==1){
        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branch'])){
       $bra=$_GET['branch'];
            $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
            $this->viewlistloanapproval("branchid=$bra and applicationdate<=$today   "); 
           
         
         }
        
         else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['branch'])){
            $date1=date("Y-m-d", strtotime($_GET['date1']));
            $date2=date("Y-m-d", strtotime($_GET['date2']));
            $bra=$_GET['branch'];
           $this->viewlistloanapproval("applicationdate  BETWEEN '$date1' AND '$date2' and branchid=$bra");
         
         }
    }else{
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2'])){
        $bra=auth()->user()->branchid;
        $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
        $this->viewlistloanapproval(" applicationdate<=$today and branchid=$bra"); 
     
     }
    
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $bra=auth()->user()->branchid;
       $this->viewlistloanapproval(" applicationdate  BETWEEN '$date1' AND '$date2' and branchid=$bra ");
     
     }
    }
}
public function viewlistloanapprovalfinal($where){
    $results=array();
    $branch=auth()->user()->branchid;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $bra=auth()->user()->branchid;
    $admin=auth()->user()->isAdmin;
   // if($admin==0){
    $krows = DB::select("select COUNT(*) as count from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where isApprove=2 and $where");
    $results["total"]=$krows[0]->count;
    
    $sth =  DB::getPdo()->prepare("select format(approveamt,0) as approveamt,groups.name as gname,loaninfos.id as id, status, DATE_FORMAT(applicationdate,'%d-%m-%Y') as date,format(amount,0) as loancredit, intmethod as method,loanfee1,loanfee2,loanfee3,period as mode,loancat,customers.name,loaninterest,loanrepay,collateral,guanter from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where isApprove=2 and $where  limit $offset,$rows");
    $sth->execute();
       $dogs = $sth->fetchAll(\PDO::FETCH_OBJ);
    $results["rows"]=$dogs;
  
                 //Showing The footer and totals 
//$footer =  DB::getPdo()->prepare("select format(sum(loancredit),0) as loancredit  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 AND loantrans.branchno=$branch $where limit $offset,$rows");
$footer =  DB::getPdo()->prepare(" select format(sum(approveamt),0) as approveamt,format(sum(amount),0) as loancredit from customers inner join loaninfos on loaninfos.memeberid=customers.id   inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where isApprove=2 and $where ");
$footer->execute();
$foots=$footer->fetchAll(\PDO::FETCH_OBJ);
$results['footer']=$foots;
echo json_encode($results);   
}
public function viewlistloanapproval($where){
    $results=array();
    $branch=auth()->user()->branchid;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $bra=auth()->user()->branchid;
    $admin=auth()->user()->isAdmin;
   // if($admin==0){
    $krows = DB::select("select COUNT(*) as count from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where isApprove=0 and $where");
    $results["total"]=$krows[0]->count;
    
    $sth =  DB::getPdo()->prepare("select groups.name as gname,loaninfos.id as id, status, DATE_FORMAT(applicationdate,'%d-%m-%Y') as date,format(amount,0) as loancredit, intmethod as method,loanfee1,loanfee2,loanfee3,period as mode,loancat,customers.name,loaninterest,loanrepay,collateral,guanter from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where isApprove=0 and $where  limit $offset,$rows");
    $sth->execute();
       $dogs = $sth->fetchAll(\PDO::FETCH_OBJ);
    $results["rows"]=$dogs;
  
                 //Showing The footer and totals 
//$footer =  DB::getPdo()->prepare("select format(sum(loancredit),0) as loancredit  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 AND loantrans.branchno=$branch $where limit $offset,$rows");
$footer =  DB::getPdo()->prepare(" select format(sum(approveamt),0) as approveamt, format(sum(amount),0) as loancredit from customers inner join loaninfos on loaninfos.memeberid=customers.id   inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where isApprove=0 and $where ");
$footer->execute();
$foots=$footer->fetchAll(\PDO::FETCH_OBJ);
$results['footer']=$foots;
echo json_encode($results);   
}
public function view(){

   
     if(auth()->user()->branchid==1){
        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branch'])){
       $bra=$_GET['branch'];
            $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
            $this->loandisbursement("loantrans.branchno=$bra and applicationdate=$today "); 
           
         
         }
        
         else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['branch'])){
            $date1=date("Y-m-d", strtotime($_GET['date1']));
            $date2=date("Y-m-d", strtotime($_GET['date2']));
            $bra=$_GET['branch'];
           $this->loandisbursement("loantrans.branchno=$bra and applicationdate  BETWEEN '$date1' AND '$date2' ");
         
         }
    }else{
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2'])){
        $bra=auth()->user()->branchid;
        $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
        $this->loandisbursement(" applicationdate=$today and loantrans.branchno=$bra"); 
     
     }
    
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $bra=auth()->user()->branchid;
       $this->loandisbursement(" applicationdate  BETWEEN '$date1' AND '$date2' and loantrans.branchno=$bra ");
     
     }
    } 

}
public function viewapplication(){

    if(auth()->user()->branchid==1){
        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branch'])){
       $bra=$_GET['branch'];
            $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
            $this->application(" branchid=$bra and applicationdate=$today   "); 
           
         
         }
        
         else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['branch'])){
            $date1=date("Y-m-d", strtotime($_GET['date1']));
            $date2=date("Y-m-d", strtotime($_GET['date2']));
           $this->application("applicationdate  BETWEEN '$date1' AND '$date2' ");
         
         }
    }else{
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2'])){
        $bra=auth()->user()->branchid;
        $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
        $this->application(" applicationdate=$today and branchid=$bra"); 
     
     }
    
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $bra=auth()->user()->branchid;
       $this->application(" applicationdate  BETWEEN '$date1' AND '$date2' and branchid=$bra ");
     
     }
    }
}
public function save(Request $request){

    DB::beginTransaction();
    try{
        $branchid=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
        $memberid=$request['name'];
        $clientname="";
        $groupid=0;
        $id=DB::select("select customers.name as client,sum(loan) as loan from loantrans inner join customers on loantrans.memid=customers.id where loantrans.isActive=1 and memid=$memberid");
        $groupdata=DB::select("select groups.id from groups inner join groupmembers on groupmembers.groupid=groups.id where groupmembers.memberid=$memberid");
foreach($groupdata as $data){
    $groupid=$data->id;
}
        foreach($id as $finalid){
            if($finalid->loan!=0 ){
                return ['results'=>'true'];
            }else{
        $clientname=$finalid->client;
        // Inserting into purchaseheaders 
        $objheaders= new purchaseheaders();
        $objheaders->transdates=date("Y-m-d", strtotime($request['date']));
        $objheaders->isActive=1;
        $objheaders->save();
        $branch=auth()->user()->branchid;
         
        // Inserting into Loaninfos 
        $objloaninfo= new loaninfo();
        $objloaninfo->loanrepay=$request['repay'];
        $objloaninfo->period=$request['mode'];
        $objloaninfo->applicationdate=date("Y-m-d", strtotime($request['date']));
        $objloaninfo->loaninterest=$request['interest'];
        $objloaninfo->mode=$request['branch'];
        $objloaninfo->collateral=$request['security'];
        $objloaninfo->guanter=$request['gauranter'];
        $objloaninfo->memeberid=$request['name'];
        $objloaninfo->savings=str_replace( ',', '',$request['savingpdt1']);
        $objloaninfo->intmethod=$request['method'];
        $objloaninfo->amount=str_replace( ',', '',$request['amount']);
        $objloaninfo->loancat=$request['loancat'];
        $objloaninfo->loanfee1=$request['loanfee1'];
        $objloaninfo->loanfee2=$request['loanfee2'];
        $objloaninfo->loanfee3=$request['loanfee3'];
        $objloaninfo->status=1;
        $objloaninfo->appid=$request['appid'];
       // $objloaninfo->isApprove=2;
        $file=$request->file('nationalid');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->nationid=$filename;
    
        }
        $file=$request->file('security');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->security=$filename;
    
        }
        $file=$request->file('chairman');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->chairmanconsent=$filename;
    
        }
        $file=$request->file('agreement');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->agreement=$filename;
    
        }
        $file=$request->file('proof');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->proofofbiz=$filename;
    
        }
        $file=$request->file('paydet');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->disburseproof=$filename;
    
        }
        $objloaninfo->save();
        DB::update("update loaninfos set isApprove=4 where memeberid=$request[name]");
        #######################  Loan Schedule ##########################################
        $months=0;
        $rate=0;
        $totalinterest=0;
        $newinterest=0;
        $newloan=0;
        if($request['mode']=='Week'){
            $rate=($request['interest']/100);
            $months=$request['repay'];
        }
        else if($request['mode']=='Month'){
            $months=$request['repay']*4;
            $rate=($request['interest']/100)/4; 
        }else if($request['mode']=='Year'){
            $rate=($request['interest']/100)/12;
            $months=$request['repay']*12;
        }

        $objloancat=loanproducts::find($request['loancat']);// just added
        if($request['method']==2){
            $interestbal=0;
            $loanbal=0;
            $insurance=str_replace( ',', '',$request['amount'])*0.02;
            $savings=str_replace( ',', '',$request['amount'])*0.2;
            $newinterest=str_replace( ',', '',$request['amount'])*$rate;
            $newloan=($savings+$insurance+str_replace( ',', '',$request['amount']))/$months;
            $total=$newinterest+$newloan;
            $added=(str_replace( ',', '',$request['amount'])*0.2)/16+(str_replace( ',', '',$request['amount'])*0.02)/16;
            
               // intial loan schedule
               $loansch1 = new loanschedules();
               $loansch1->scheduledate=date('Y-m-d',strtotime($request['date']));
               $loansch1->branchno=$branchid;
               $loansch1->loanid=$objloaninfo->id;
               $loansch1->groupid=$groupid;
               $loansch1->expecteddate=date('Y-m-d',strtotime($request['date']."+2 week"));
               $loansch1->penalty=$total;
               $loansch1->runningbal=str_replace( ',', '',$request['amount'])+(($request['interest']/100)*str_replace( ',', '',$request['amount']))*$request['repay']+$savings+$insurance;
               $loansch1->save();
               // Posting into Loan Insurance 
                            // inserting into accountrans  Loans 
                $objaccountrans=new accounttrans;
                $objaccountrans->purchaseheaderid=$objheaders->id;
                $objaccountrans->amount= $insurance;
                $objaccountrans->accountcode=199;
                $objaccountrans->narration= $finalid->client." -Loan Insurance Rec";
                $objaccountrans->ttype="D";
                $objaccountrans->total=$insurance;
                $objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
                $objaccountrans->bracid=$branchid;
                $objaccountrans->save();

                // inserting into accountrans Cash Account 
                $objaccountrans=new accounttrans;
                $objaccountrans->purchaseheaderid=$objheaders->id;
                $objaccountrans->amount=$insurance;
                $objaccountrans->accountcode=621;
                $objaccountrans->narration=$finalid->client." -Loan Insurance Income";
                $objaccountrans->ttype="C";
                $objaccountrans->total=$insurance;
                $objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
                $objaccountrans->bracid=$branchid;
                $objaccountrans->save();

            for($x=2;$x<=17;$x++){
                $newdates=date('Y-m-d',strtotime($request['date'] ."+$x week"));
              // Second loan schedule posting
                $loansch= new loanschedules();
                $loansch->loanid=$objloaninfo->id;
                $loansch->branchno=$branchid;
                $loansch->loanamount=$newloan;
                $loansch->interest=$newinterest;;
                $loansch->loancat=$objloancat->loanpdt;// just added 25-05-2020
                $loansch->intmeth=2; // today
                $loansch->scheduledate=$newdates;
                $loansch->runningbal=($newloan+$newinterest)*-1;
                $loansch->nopayments=$x;
               // $loansch->expecteddate=$x==1?$newdates:0;
                $loansch->groupid=$groupid;
                $loansch->penalty=$total;
                $loansch->save();
                $totalinterest=$totalinterest+$newinterest;
                // Posting into Loan Repayments 
                $loanrepay= new loanrepayments();
                $interestbal=$interestbal+$newinterest;
                $loanbal=$loanbal+$newloan;
                $loanrepay->branchno=$branchid;
                $loanrepay->intrunbal=$interestbal;
                $loanrepay->loanrunbal=$loanbal;
                $loanrepay->loanid=$objloaninfo->id;
                $loanrepay->save();
            }
        }

        if($request['method']==1){
            $loanamount=str_replace( ',', '',$request['amount']);
            $loaninterest=str_replace( ',', '',$request['amount']);
            $emi=$this->emi_calculator(str_replace( ',', '',$request['amount']),$request['interest'],$request['repay'],$request['mode']);
           // intial loan schedule
             $loansch1 = new loanschedules();
             $loansch1->scheduledate=date('Y-m-d',strtotime($request['date']));
             $loansch1->branchno=$branchid;
             $loansch1->loanid=$objloaninfo->id;
             // getting total interest
             $ttinterest=0; 
             for($x=1;$x<=$months;$x++){
                $newinterest=$loaninterest*$rate;
                $monthlyprinciple=$emi-$newinterest;
                $ttinterest=$ttinterest+$newinterest;
                $loaninterest=$loaninterest-$monthlyprinciple;
               
             }
             $loansch1->runningbal=str_replace( ',', '',$request['amount'])+$ttinterest;
             $totalinterest= $ttinterest;
            // $loansch1->save();
             $interestbal=0;
             $loanbal=0;
            for($x=1;$x<=$months;$x++){
                $newinterest=$loanamount*$rate;
                $monthlyprinciple=$emi-$newinterest;
                $total=$newinterest+$monthlyprinciple;
                $newdates=date('Y-m-d',strtotime($request['date'] ."+$x week"));
                 // Second loan schedule posting
                 $loansch= new loanschedules();
                 $loansch->loanid=$objloaninfo->id;
                 $loansch->loanamount=$monthlyprinciple;
                 $loansch->interest=$newinterest;
                 $loansch->scheduledate=$newdates;
                 $loansch->branchno=$branchid;
                 $loansch->runningbal=($total)*-1;
                 $loansch->loancat=$objloancat->loanpdt;// just added 25-05-2020
                 $loansch->intmeth=1; // today
                 $loansch->nopayments=$x;
                 $loansch->groupid=$groupid;
                 $loansch->penalty=$total;
                 $loansch->save(); 
                 $loanamount=$loanamount-$monthlyprinciple;
                 //calculating interest running bal
                 $interestbal=$interestbal+$newinterest;
                 $loanbal=$loanbal+$monthlyprinciple;
                 $loanrepay= new loanrepayments();
                 $loanrepay->intrunbal=$interestbal;
                 $loanrepay->branchno=$branchid;
                 $loanrepay->loanrunbal=$loanbal;
                 $loanrepay->loanid=$objloaninfo->id;
                 $loanrepay->save();
            }
         }

########################################## END OF LOAN SCHEDULE #################################################
// checking the current passbook in usage
$bookno=0;
$pass=DB::select("select pbsn from passbooks where memid=$request[name] order by id desc limit 1");
foreach($pass as $p){
    //$bookno=;

        //Saving into loantrans
$objloantrans= new loantrans();
$objloantrans->loancredit=str_replace( ',', '',$request['amount']);
$objloantrans->loan=str_replace( ',', '',$request['amount']);
$objloantrans->isLoan=1;
$objloantrans->isDisbursement=1;
$objloantrans->branchno=$branchid;
$objloantrans->pbkno=$p->pbsn;
$objloantrans->user=auth()->user()->name;
//$objloantrans->interestcredit=$interest;

$objloantrans->narration="Loan Disbursement ";
$objloantrans->headerid=$objheaders->id;
$objloantrans->date=date("Y-m-d", strtotime($request['date']));
$objloantrans->loanid=$objloaninfo->id;
$objloantrans->memid=$request['name'];
$objloantrans->paydet="N/A";
$objloantrans->isActive=1;
$objloantrans->expecteddate=date('Y-m-d',strtotime($request['date'] ."+$months week"));
$objloantrans->newdate=date('Y-m-d',strtotime($request['date'] ."+$months week"));
$objloantrans->save();
}
//Saving Interest 
 //Saving into loantrans
 $objloantrans1= new loantrans();
 $objloantrans1->loancredit=$totalinterest;
 $objloantrans1->interestcredit=$totalinterest;
 $objloantrans1->isLoan=0;
 $objloantrans1->branchno=$branchid;
 $objloantrans1->user=auth()->user()->name;
 $objloantrans1->isDisbursement=1;
 $objloantrans1->headerid=$objheaders->id;
 $objloantrans1->interestcredit=$totalinterest;
 $objloantrans1->narration="Loan Interest Charged";
 $objloantrans1->date=date("Y-m-d", strtotime($request['date']));
 $objloantrans1->loanid=$objloaninfo->id;
 $objloantrans1->memid=$request['name'];
 $objloantrans1->paydet="N/A";
 $objloantrans1->isActive=1;
 $objloantrans1->save();

  //Loan Insurance 
  $objloantrans1= new loantrans();
  $objloantrans1->loancredit=$insurance;
  $objloantrans1->loan=$insurance;
  $objloantrans1->isLoan=0;
  $objloantrans1->branchno=$branchid;
  $objloantrans1->user=auth()->user()->name;
  $objloantrans1->isDisbursement=1;
  $objloantrans1->headerid=$objheaders->id;
  $objloantrans1->interestcredit=0;
  $objloantrans1->narration="Loan Insurance Charged";
  $objloantrans1->date=date("Y-m-d", strtotime($request['date']));
  $objloantrans1->loanid=$objloaninfo->id;
  $objloantrans1->memid=$request['name'];
  $objloantrans1->paydet="N/A";
  $objloantrans1->isActive=1;
  $objloantrans1->save();

//Compulsory Savings  
$objloantrans1= new loantrans();
$objloantrans1->loancredit=$savings;
$objloantrans1->loan=$savings;
$objloantrans1->interestcredit=0;
$objloantrans1->isLoan=0;
$objloantrans1->branchno=$branchid;
$objloantrans1->user=auth()->user()->name;
$objloantrans1->isDisbursement=1;
$objloantrans1->headerid=$objheaders->id;
$objloantrans1->interestcredit=0;
$objloantrans1->narration="Compulsory Savings";
$objloantrans1->date=date("Y-m-d", strtotime($request['date']));
$objloantrans1->loanid=$objloaninfo->id;
$objloantrans1->memid=$request['name'];
$objloantrans1->paydet="N/A";
$objloantrans1->isActive=1;
$objloantrans1->save();

 ########################################## ALL SAVINGS ##########################
 $objloancat=loanproducts::find($request['loancat']);
 $objallsavings= new allsavings();
 $objallsavings->client_no=$memberid;
 $objallsavings->branchno=$branchid;
 $objallsavings->headerid=$objheaders->id;
 $objallsavings->recieptno=$request['paydet'];//str_replace( ',', '',$request['date']);
 $objallsavings->date=date("Y-m-d", strtotime($request['date']));
 $objallsavings->narration="Loan Disbursement ";

 // Posting for loan insurance and coumpsaving 
 $objallsavingsInsurance= new allsavings();
 $objallsavingsInsurance->client_no=$memberid;
 $objallsavingsInsurance->branchno=$branchid;
 $objallsavingsInsurance->headerid=$objheaders->id;
 $objallsavingsInsurance->recieptno="N/A";//str_replace( ',', '',$request['date']);
 $objallsavingsInsurance->date=date("Y-m-d", strtotime($request['date']));
 $objallsavingsInsurance->narration="Insurance & Compulsory Savings ";

     if($objloancat->loanpdt=="loanpdt1"){
        $objallsavings->loanpdt1=str_replace( ',', '',$request['amount']);
        $objallsavings->loanint1=$totalinterest;
        $objallsavingsInsurance->loanpdt1=$insurance+$savings;
      
     }else if($objloancat->loanpdt=="loanpdt2"){
        $objallsavings->loanpdt2=str_replace( ',', '',$request['amount']);
        $objallsavings->loanint2=$totalinterest;        
     }
    else if($objloancat->loanpdt=="loanpdt3"){
        $objallsavings->loanpdt3=str_replace( ',', '',$request['amount']);
        $objallsavings->loanint3=$totalinterest;        
     }
    else if($objloancat->loanpdt=="loanpdt4"){
        $objallsavings->loanpdt4=str_replace( ',', '',$request['amount']);
        $objallsavings->loanint4=$totalinterest;        
     }
    else if($objloancat->loanpdt=="loanpdt5"){
        $objallsavings->loanpdt5=str_replace( ',', '',$request['amount']);
        $objallsavings->loanint5=$totalinterest;        
    }
    if(str_replace( ',', '',$request['savingpdt1'])>0){
        //$objallsavings->savingpdt1=str_replace( ',', '',$request['savingpdt1']);
    }

    // ######################### Savings Deducts ###################
    $isSavin=DB::select("SELECT * FROM `loanfees`inner join savingdefinations on savingdefinations.savingac=loanfees.savingac where loanfees.isActive=1 and loanfees.branchno=$branchid");
    foreach($isSavin as $say){
        if($say->feevar=="loanfee1" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee1'])>0){
            $savingpdt=$say->savingpdt;
            $objallsavings->$savingpdt=str_replace( ',', '',$request['loanfee1'])*-1;
        }
        if($say->feevar=="loanfee2" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee2'])>0){
            $savingpdt=$say->savingpdt;
            $objallsavings->$savingpdt=str_replace( ',', '',$request['loanfee2'])*-1;
        }
        if($say->feevar=="loanfee3" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee3'])>0){
            $savingpdt=$say->savingpdt;
            $objallsavings->$savingpdt=str_replace( ',', '',$request['loanfee3'])*-1;
        }    

    }
 
 $objallsavings->save();
 $objallsavingsInsurance->save();
 // saving compulsory savings 
 if(str_replace( ',', '',$request['savingpdt1'])>0){
    $savings=savingdefinations::where('savingpdt','=','savingpdt1')->where('isActive','=',1)->where('branchno','=',$branchid)->get();
    foreach($savings as $sav){
       /* inserting into cash Account 
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['savingpdt1']);
$objaccountrans->accountcode=$sav->operatingac;
$objaccountrans->narration= $finalid->client." ".$sav->productname." "."Cash Deposit";
$objaccountrans->ttype="D";
$objaccountrans->total=str_replace( ',', '',$request['savingpdt1']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();

// inserting into accountrans savings
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['savingpdt1']);
$objaccountrans->accountcode=$sav->savingac;
$objaccountrans->narration= $finalid->client." ".$sav->productname." "."Cash Deposit";
$objaccountrans->ttype="C";
$objaccountrans->total=str_replace( ',', '',$request['savingpdt1']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();*/
 
    }

}
 // Savings Statments 
############################################# Saving Statments ######################
$savingT=DB::select("SELECT * FROM `loanfees`inner join savingdefinations on savingdefinations.savingac=loanfees.savingac where loanfees.isActive=1 and loanfees.branchno=$branchid");
foreach($savingT as $say){
    if($say->feevar=="loanfee1" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee1'])>0){
        $savingpdt=$say->savingpdt;
        $this->savingstrans(date("Y-m-d", strtotime($request['date'])),$memberid,$request['paydet'],str_replace( ',', '',$request['loanfee1']),$savingpdt,str_replace( ',', '',$request['loanfee1']),$objallsavings->id,$say->name,$branchid);
    }
    if($say->feevar=="loanfee2" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee2'])>0){
        $savingpdt=$say->savingpdt;
        $this->savingstrans(date("Y-m-d", strtotime($request['date'])),$memberid,$request['paydet'],str_replace( ',', '',$request['loanfee2']),$savingpdt,str_replace( ',', '',$request['loanfee2']),$objallsavings->id,$say->name,$branchid);
    }
    if($say->feevar=="loanfee3" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee3'])>0){
        $savingpdt=$say->savingpdt;
        $this->savingstrans(date("Y-m-d", strtotime($request['date'])),$memberid,$request['paydet'],str_replace( ',', '',$request['loanfee3']),$savingpdt,str_replace( ',', '',$request['loanfee3']),$objallsavings->id,$say->name,$branchid);
    }
}
 ########################################## If no processing fees ###################################################
 $loanfees=loanfees::where('isActive','=',1)->get();
 $loanaccounts=loanproducts::find($request['loancat']);
// echo $loanfees->count();
 if($loanfees->count()<1){
     
     /*****************    Accounts ********************************************************/
// inserting into accountrans  Loans 
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['amount']);
$objaccountrans->accountcode=$loanaccounts->accountcode;
$objaccountrans->narration= $finalid->client." -Loan Disbursement "."($loanaccounts->name)";
$objaccountrans->ttype="D";
$objaccountrans->total=str_replace( ',', '',$request['amount']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();

// inserting into accountrans Cash Account 
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['amount']);
$objaccountrans->accountcode=$loanaccounts->disbursingac;
$objaccountrans->narration=$finalid->client." -Loan Disbursement "."($loanaccounts->name)";
$objaccountrans->ttype="C";
$objaccountrans->total=str_replace( ',', '',$request['amount'])*-1;
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();

// Loan interest Recivables
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=$totalinterest;
$objaccountrans->total=$totalinterest;
$objaccountrans->accountcode="122";
$objaccountrans->narration=$finalid->client." -Loan Interest Recievable "."($loanaccounts->name)";
$objaccountrans->ttype="D";
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();

// Loan interest Income
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=$totalinterest;
$objaccountrans->total=$totalinterest;
$objaccountrans->accountcode="600";
$objaccountrans->narration=$finalid->client." -Loan Interest income "."($loanaccounts->name)";
$objaccountrans->ttype="C";
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();

 }else{
 /*****************    Accounts ********************************************************/
// inserting into accountrans  Loans 
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['amount']);
$objaccountrans->accountcode=$loanaccounts->accountcode;
$objaccountrans->narration= $finalid->client." -Loan Disbursement "."($loanaccounts->name)";
$objaccountrans->ttype="D";
$objaccountrans->total=str_replace( ',', '',$request['amount']);
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();
// Loan interest Recivables
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=$totalinterest;
$objaccountrans->total=$totalinterest;
$objaccountrans->accountcode="122";
$objaccountrans->narration=$finalid->client." -Loan Interest Recievable "."($loanaccounts->name)";
$objaccountrans->ttype="D";
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();
// Loan interest Income
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=$totalinterest;
$objaccountrans->total=$totalinterest;
$objaccountrans->accountcode="600";
$objaccountrans->narration=$finalid->client." -Loan Interest income "."($loanaccounts->name)";
$objaccountrans->ttype="C";
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();
###########################################  LOAN FEESS #########################
$resultfees=DB::select("select * from loanfees");
$resultz=DB::select("select * from loanfees where isSavings=1");
if(count($resultz)>0){// if deduct from savings
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['amount']);
$objaccountrans->total=str_replace( ',', '',$request['amount'])*-1;
$objaccountrans->accountcode=$loanaccounts->disbursingac;
$objaccountrans->narration=$finalid->client." -Loan Disbursement- "."($loanaccounts->name)";
$objaccountrans->ttype="C";
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=$branchid;
$objaccountrans->save();
// selecting loan fees
foreach($resultz as $rs){
    if($rs->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
        // Loan Fee1 
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee1']),str_replace( ',', '',$request['loanfee1']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])));
        // Savings Ac
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee1']),str_replace( ',', '',$request['loanfee1'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])));
    }
    if($rs->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
        // Loan Fee2 
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee2']),str_replace( ',', '',$request['loanfee2']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])));
        // Savings Ac
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee2']),str_replace( ',', '',$request['loanfee2'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])));
    }
    if($rs->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
                // Loan Fee1 
     $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee3']),str_replace( ',', '',$request['loanfee3']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])));
                // Savings Ac
     $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee3']),str_replace( ',', '',$request['loanfee3'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])));
    }

}


}else{
$resultscount=DB::select("select  sum(if(isDeduct=1,isDeduct,0)) as Deductnew,sum(if(isDeduct=0,isDeduct,0)) as Nodeductnew from loanfees");
$number=1;
$totalamount=0;
foreach($resultfees as $finalfees){
    if($finalfees->isDeduct==1){
        if($finalfees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
            $totalamount=$totalamount+str_replace( ',', '',$request['loanfee1']);
        }
        if($finalfees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
           $totalamount=$totalamount+str_replace( ',', '',$request['loanfee2']);
        }
        if($finalfees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
            $totalamount=$totalamount+str_replace( ',', '',$request['loanfee3']);
        }
    }
}
$ded=0;$noded=0;
foreach($resultscount as $ct){
    $ded=$ct->Deductnew;
    $noded=$ct->Nodeductnew;
}
foreach($resultfees as $fees){
    // if loan fee is ISDeduct
    
    if($ded>0 && $noded==0){
        if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
            if($fees->isDeduct==0){  
                $answer="No";   
            }else{
                $answer="Yes";
            }
            $this->deductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee1",$branchid);
        }
        if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
            if($fees->isDeduct==0){  
                $answer="No";   
            }else{
                $answer="Yes";
            }
            $this->deductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee2",$branchid);
        }
        if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
            if($fees->isDeduct==0){  
                $answer="No";   
            }else{
                $answer="Yes";
            }
            $this->deductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee3",$branchid);
        }
        if($number==1){
            $this->cashaccount($request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount'])-$totalamount,date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct",$branchid);
            }
            echo "Both ";
}
    else if($fees->isDeduct==0){
        if($number==1){
        $this->cashaccount($request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct",$branchid);
        }
        if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
            $this->deductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee1",$branchid);
        }
        if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
            $this->deductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee2",$branchid);
        }
        if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
            $this->deductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee3",$branchid);
        }
       // echo "NOt Deducted";
    }else if($fees->isDeduct==1){
            if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
                $this->deductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee1",$branchid);
            }
            if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
                $this->deductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee2",$branchid);
            }
            if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
                $this->deductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee3",$branchid);
            }
            if($number==1){
                $this->cashaccount($request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount'])-$totalamount,date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct");
                }
               // echo "Deducted";
    }

    $number=$number+1;
}

    }
 }
            }
        }
        // Audit Trails
       /* $objaudits= new audits();
$objaudits->event="Loan Disbursement -".$clientname. " of ".$request['amount'];
$objaudits->branchno=auth()->user()->branchid;
$objaudits->username=auth()->user()->name;
$objaudits->save();*/
    }catch(\Exception $e){
        DB::rollback();
        echo "Failed".$e;
    }
    DB::commit();

}
 
//Auto generated code for updating
public function update(Request $request,$id2,$headerid){
    DB::beginTransaction();
    try{
    $month=$request['repay'];
    $memberid=$request['memid'];
    $branch=auth()->user()->branchid;
    $groupid=0;
    $groupdata=DB::select("select groups.id from groups inner join groupmembers on groupmembers.groupid=groups.id where groupmembers.memberid=$memberid");
    foreach($groupdata as $data){
        $groupid=$data->id;
  $id=DB::select("select customers.name as client,sum(loan) as loan,branchnumber from loantrans inner join customers on loantrans.memid=customers.id where loantrans.isActive=1 and memid='$memberid'");
  foreach($id as $finalid){
    $clientname=$finalid->client;
    // Inserting into purchaseheaders 
    $objheaders= purchaseheaders::find($headerid);
    $objheaders->transdates=date("Y-m-d", strtotime($request['date']));
    $objheaders->isActive=1;
    $objheaders->save();
    // Inserting into Loaninfos  
     $objloaninfo= loaninfo::find($id2);
     $objloaninfo->loanrepay=$request['repay'];
     $objloaninfo->period=$request['mode'];
     $objloaninfo->loaninterest=$request['interest'];
     $objloaninfo->mode=$request['branch'];
     $objloaninfo->collateral=$request['security'];
     $objloaninfo->guanter=$request['gauranter'];
    // $objloaninfo->memeberid=$request['name'];
     $objloaninfo->intmethod=$request['method'];
     $file=$request->file('paydet');
     $destinationPath="images";
     if($file!=Null){
         $filename=$file->getClientOriginalName();
         //moving it to the folder
         $file->move($destinationPath,$filename);
         $objloaninfo->disburseproof=$filename;
 
     }
     $objloaninfo->loancat=$request['loancat'];
     $objloaninfo->loanfee1=$request['loanfee1'];
     $objloaninfo->loanfee2=$request['loanfee2'];
     $objloaninfo->loanfee3=$request['loanfee3'];
     //$objloaninfo->isApprove=2;
     $objloaninfo->save();
     // Deleting Loan Schdeule
DB::delete("delete  from loanschedules where loanid=$id2");
DB::delete("delete  from loanrepayments where loanid=$id2");
     #######################  Loan Schedule ##########################################
     $months=0;
     $rate=0;
     $totalinterest=0;
     $newinterest=0;
     $newloan=0;
     if($request['mode']=='Week'){
        $months=$request['repay'];
        $rate=$request['interest']/100; 
     }
     else if($request['mode']=='Month'){
        $months=$request['repay']*4;
        $rate=($request['interest']/100)/4;
     }else if($request['mode']=='Year'){
         $rate=($request['interest']/100)/12;
         $months=$request['repay']*12;
     }
     $objloancat=loanproducts::find($request['loancat']);// just added
     if($request['method']==2){
         $interestbal=0;
         $loanbal=0;
         $insurance=str_replace( ',', '',$request['amount'])*0.02;
         $savings=str_replace( ',', '',$request['amount'])*0.2;
         $newinterest=str_replace( ',', '',$request['amount'])*$rate;
         $newloan=($savings+$insurance+str_replace( ',', '',$request['amount']))/$months;
         $total=$newinterest+$newloan;
         $added=(str_replace( ',', '',$request['amount'])*0.2)/16+(str_replace( ',', '',$request['amount'])*0.02)/16;
            // intial loan schedule
            $loansch1 = new loanschedules();
            $loansch1->scheduledate=date('Y-m-d',strtotime($request['date']));
            $loansch1->loanid=$objloaninfo->id;
            $loansch1->penalty=$total;
            $loansch1->expecteddate=date('Y-m-d',strtotime($request['date']."+2 week"));
            $loansch1->groupid=$groupid;
            $loansch1->runningbal=($savings+$insurance+str_replace( ',', '',$request['amount']))+(($request['interest']/100)*str_replace( ',', '',$request['amount']))*$request['repay'];
            $loansch1->save();
            // Posting into Loan Insurance 
            // inserting into accountrans  Loans 
            // inserting into Cash Account
            accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
            '=',199)->update(
                ['amount'=>$insurance,
                'total'=>$insurance,
                'narration'=>$finalid->client.' -Loan Insurance Receivables ',
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                ]);
            // inserting into Loan Interest Recievables
            accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
            '=','621')->update(
                ['amount'=>$insurance,
                'total'=>$insurance,
                'narration'=>$finalid->client.' -Loan Insurance  Income ',
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                    
                ]);

    
         for($x=2;$x<=17;$x++){
             $newdates=date('Y-m-d',strtotime($request['date'] ."+$x week"));
           // Second loan schedule posting
             $loansch= new loanschedules();
             $loansch->loanid=$objloaninfo->id;
             $loansch->loanamount=$newloan;
             $loansch->interest=$newinterest;;
             $loansch->loancat=$objloancat->loanpdt;// just added 25-05-2020
             $loansch->intmeth=2; // today
             $loansch->penalty=$total;
             $loansch->groupid=$groupid;
             $loansch->scheduledate=$newdates;
             $loansch->runningbal=($newloan+$newinterest)*-1;
             $loansch->nopayments=$x;
             $loansch->save();
             $totalinterest=$totalinterest+$newinterest;
             // Posting into Loan Repayments 
             $loanrepay= new loanrepayments();
             $interestbal=$interestbal+$newinterest;
             $loanbal=$loanbal+$newloan;
             $loanrepay->intrunbal=$interestbal;
             $loanrepay->loanrunbal=$loanbal;
             $loanrepay->loanid=$objloaninfo->id;
             $loanrepay->save();
         }
     }

     if($request['method']==1){
         $loanamount=str_replace( ',', '',$request['amount']);
         $loaninterest=str_replace( ',', '',$request['amount']);
         $emi=$this->emi_calculator(str_replace( ',', '',$request['amount']),$request['interest'],$request['repay'],$request['mode']);
        // intial loan schedule
          $loansch1 = new loanschedules();
          $loansch1->scheduledate=date('Y-m-d',strtotime($request['date']));
          $loansch1->loanid=$objloaninfo->id;
          // getting total interest
          $ttinterest=0; 
          for($x=1;$x<=$months;$x++){
             $newinterest=$loaninterest*$rate;
             $monthlyprinciple=$emi-$newinterest;
             $ttinterest=$ttinterest+$newinterest;
             $loaninterest=$loaninterest-$monthlyprinciple;
            
          }
          $loansch1->runningbal=str_replace( ',', '',$request['amount'])+$ttinterest;
          $totalinterest= $ttinterest;
          $loansch1->save();
          $interestbal=0;
          $loanbal=0;
         for($x=1;$x<=$months;$x++){
             $newinterest=$loanamount*$rate;
             $monthlyprinciple=$emi-$newinterest;
             $total=$newinterest+$monthlyprinciple;
             $newdates=date('Y-m-d',strtotime($request['date'] ."+$x week"));
              // Second loan schedule posting
              $loansch= new loanschedules();
              $loansch->loanid=$objloaninfo->id;
              $loansch->loanamount=$monthlyprinciple;
              $loansch->interest=$newinterest;
              $loansch->scheduledate=$newdates;
              $loansch->runningbal=($total)*-1;
              $loansch->loancat=$objloancat->loanpdt;// just added 25-05-2020
              $loansch->intmeth=1; // today
              $loansch->nopayments=$x;
              $loansch->save(); 
              $loanamount=$loanamount-$monthlyprinciple;
              //calculating interest running bal
              $interestbal=$interestbal+$newinterest;
              $loanbal=$loanbal+$monthlyprinciple;
              $loanrepay= new loanrepayments();
              $loanrepay->intrunbal=$interestbal;
              $loanrepay->loanrunbal=$loanbal;
              $loanrepay->loanid=$objloaninfo->id;
              $loanrepay->save();
         }
      }


########################################## END OF LOAN SCHEDULE #################################################
$pass=DB::select("select pbsn from passbooks where memid=$request[memid] order by id desc limit 1");
foreach($pass as $p){
    //Saving into loantrans
    loantrans::where('loanid','=',$id2)->where('narration','=','Loan Disbursement')->update(

        ['loancredit'=>str_replace( ',', '',$request['amount']),
        'loan'=>str_replace( ',', '',$request['amount']),
        'isLoan'=>1,
        'isDisbursement'=>1,
        'memid'=>$request['memid'],
        'paydet'=>'N/A',
        'pbkno'=>$p->pbsn,
        'isActive'=>1,
        'interestcredit'=>0,
        'date'=>date('Y-m-d',strtotime($request['date'])),
        
        ]);
    }
//Saving Interest 

loantrans::where('loanid','=',$id2)->where('narration','=','Loan Interest Charged')->update(

    ['loancredit'=>$totalinterest,
    'loan'=>0,
    'isLoan'=>0,
    'isDisbursement'=>1,
    'loanid'=>$objloaninfo->id,
    'memid'=>$request['memid'],
    'paydet'=>'N/A',
    'isActive'=>1,
    'interestcredit'=>$totalinterest,
    'date'=>date('Y-m-d',strtotime($request['date'])),
  


    ]);

    //insurance

loantrans::where('loanid','=',$id2)->where('narration','=','Loan Insurance Charged')->update(

    ['loancredit'=>$insurance,
    'loan'=>$insurance,
    'isLoan'=>0,
    'isDisbursement'=>1,
    'loanid'=>$objloaninfo->id,
    'memid'=>$request['memid'],
    'paydet'=>$request['paydet'],
    'isActive'=>1,
    'interestcredit'=>0,
    'date'=>date('Y-m-d',strtotime($request['date'])),
  


    ]);

        //cusmplusar savings 

loantrans::where('loanid','=',$id2)->where('narration','=','Compulsory Savings')->update(

    ['loancredit'=>$savings,
    'loan'=>$savings,
    'isLoan'=>0,
    'isDisbursement'=>1,
    'loanid'=>$objloaninfo->id,
    'memid'=>$request['memid'],
    'paydet'=>$request['paydet'],
    'isActive'=>1,
    'interestcredit'=>0,
    'date'=>date('Y-m-d',strtotime($request['date'])),
  


    ]);

########################################## ALL SAVINGS ##########################
$savingids=0;
$objloancat=loanproducts::find($request['loancat']);
$idallsaving=allsavings::where('headerid','=',$headerid)->get();
foreach($idallsaving as $savingid){
    $savingids=$savingid->id;
}
//return $savingids-1;
$objallsavings= allsavings::find($savingids-1);
$objallsavingsInsur= allsavings::find($savingids);

$objallsavings->client_no=$request['memid'];
$objallsavings->recieptno=$request['paydet'];
$objallsavings->date=date("Y-m-d", strtotime($request['date']));
$objallsavings->narration="Loan Disbursement ";
// insurance
$objallsavingsInsur->client_no=$request['memid'];
$objallsavingsInsur->recieptno=$request['paydet'];
$objallsavingsInsur->date=date("Y-m-d", strtotime($request['date']));
$objallsavingsInsur->narration="Insurance & Compulsory Savings ";

 if($objloancat->loanpdt=="loanpdt1"){
    $objallsavings->loanpdt1=str_replace( ',', '',$request['amount']);
    $objallsavings->loanint1=$totalinterest;
    $objallsavingsInsur->loanpdt1=$insurance+$savings;
    $objallsavingsInsur->loanint1=0;
  
 }else if($objloancat->loanpdt=="loanpdt2"){
    $objallsavings->loanpdt2=str_replace( ',', '',$request['amount']);
    $objallsavings->loanint2=$totalinterest;        
 }
else if($objloancat->loanpdt=="loanpdt3"){
    $objallsavings->loanpdt3=str_replace( ',', '',$request['amount']);
    $objallsavings->loanint3=$totalinterest;        
 }
else if($objloancat->loanpdt=="loanpdt4"){
    $objallsavings->loanpdt4=str_replace( ',', '',$request['amount']);
    $objallsavings->loanint4=$totalinterest;        
 }
else if($objloancat->loanpdt=="loanpdt5"){
    $objallsavings->loanpdt5=str_replace( ',', '',$request['amount']);
    $objallsavings->loanint5=$totalinterest;        
}
if(str_replace( ',', '',$request['savingpdt1'])>0){
   // $objallsavings->savingpdt1=str_replace( ',', '',$request['savingpdt1']);
}
    // ######################### Savings Deducts ###################
    $isSavin=DB::select("SELECT * FROM `loanfees`inner join savingdefinations on savingdefinations.savingac=loanfees.savingac where loanfees.isActive=1 and loanfees.branchno=$branch");
    foreach($isSavin as $say){
        if($say->feevar=="loanfee1" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee1'])>0){
            $savingpdt=$say->savingpdt;
            $objallsavings->$savingpdt=str_replace( ',', '',$request['loanfee1'])*-1;
        }
        if($say->feevar=="loanfee2" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee2'])>0){
            $savingpdt=$say->savingpdt;
            $objallsavings->$savingpdt=str_replace( ',', '',$request['loanfee2'])*-1;
        }
        if($say->feevar=="loanfee3" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee3'])>0){
            $savingpdt=$say->savingpdt;
            $objallsavings->$savingpdt=str_replace( ',', '',$request['loanfee3'])*-1;
        }    

    }
    
$objallsavings->save();
$objallsavingsInsur->save();

 // Savings Statments 
############################################# Saving Statments ######################
$savingT=DB::select("SELECT * FROM `loanfees`inner join savingdefinations on savingdefinations.savingac=loanfees.savingac where loanfees.isActive=1 and loanfees.branchno=$branch");
foreach($savingT as $say){
    if($say->feevar=="loanfee1" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee1'])>0){
        $savingpdt=$say->savingpdt;
        $this->savingstransupdate(date("Y-m-d", strtotime($request['date'])),$memberid,$request['paydet'],str_replace( ',', '',$request['loanfee1']),$savingpdt,str_replace( ',', '',$request['loanfee1']),$savingids,$say->name,auth()->user()->branchid);
    }
    if($say->feevar=="loanfee2" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee2'])>0){
        $savingpdt=$say->savingpdt;
        $this->savingstransupdate(date("Y-m-d", strtotime($request['date'])),$memberid,$request['paydet'],str_replace( ',', '',$request['loanfee2']),$savingpdt,str_replace( ',', '',$request['loanfee2']),$savingids,$say->name,auth()->user()->branchid);
    }
    if($say->feevar=="loanfee3" && $say->isSavings==1 && str_replace( ',', '',$request['loanfee3'])>0){
        $savingpdt=$say->savingpdt;
        $this->savingstransupdate(date("Y-m-d", strtotime($request['date'])),$memberid,$request['paydet'],str_replace( ',', '',$request['loanfee3']),$savingpdt,str_replace( ',', '',$request['loanfee3']),$savingids,$say->name,auth()->user()->branchid);
    }
}


// Edit Compulsory savings 
 // saving compulsory savings 
 if(str_replace( ',', '',$request['savingpdt1'])>0){
    $savings=savingdefinations::where('savingpdt','=','savingpdt1')->where('isActive','=',1)->where('branchno','=',auth()->user()->branchid)->get();
    foreach($savings as $sav){
/* inserting into Cash Account
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
'=',$sav->operatingac)->update(
     ['amount'=>str_replace( ',', '',$request['savingpdt1']),
    'total'=>str_replace( ',', '',$request['savingpdt1']),
    'narration'=>$finalid->client." ".$sav->productname." "."Cash Deposit",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    ]);
       // inserting into cash Savings
       accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
       '=',$sav->savingac)->update(
            ['amount'=>str_replace( ',', '',$request['savingpdt1']),
           'total'=>str_replace( ',', '',$request['savingpdt1']),
           'narration'=>$finalid->client." ".$sav->productname." "."Cash Deposit",
           'transdate'=>date("Y-m-d", strtotime($request['date'])),
           ]);


*/
 
    }

}

########################################## If no processing fees ###################################################
$loanfees=loanfees::where('isActive','=',1)->get();
$loanaccounts=loanproducts::find($request['loancat']);
if($loanfees->count()<1){
 
 #####################    Accounts ##################################
// inserting into Loan Account
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
'=',$loanaccounts->accountcode)->update(
     ['amount'=>str_replace( ',', '',$request['amount']),
    'total'=>str_replace( ',', '',$request['amount']),
    'narration'=>$finalid->client.' -Loan Disbursement '."($loanaccounts->name)",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),   
    ]);
// inserting into Cash Account
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
'=',$loanaccounts->disbursingac)->update(
     ['amount'=>str_replace( ',', '',$request['amount']),
    'total'=>str_replace( ',', '',$request['amount'])*-1,
    'narration'=>$finalid->client.' -Loan Disbursement '."($loanaccounts->name)",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    ]);
// inserting into Loan Interest Recievables
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
'=','122')->update(
     ['amount'=>$totalinterest,
    'total'=>$totalinterest,
    'narration'=>$finalid->client.' -Loan Interest Rec '."($loanaccounts->name)",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    
    
    ]);
//Loan Interest Income
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
'=','600')->update(
     ['amount'=>$totalinterest,
    'total'=>$totalinterest,
    'narration'=>$finalid->client.' -Loan Interest Income '."($loanaccounts->name)",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    
    
    ]);

}else{
    
########################################    Accounts ##################################
// inserting into accountrans  Loans 
// inserting into Loan Account
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
'=',$loanaccounts->accountcode)->update(
     ['amount'=>str_replace( ',', '',$request['amount']),
    'total'=>str_replace( ',', '',$request['amount']),
    'narration'=>$finalid->client.' -Loan Disbursement '."($loanaccounts->name)",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),   
    ]);
// inserting into Loan Interest Recievables
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
'=','122')->update(
     ['amount'=>$totalinterest,
    'total'=>$totalinterest,
    'narration'=>$finalid->client.' -Loan Interest Rec '."($loanaccounts->name)",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    
    
    ]);
//Loan Interest Income
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
'=','600')->update(
     ['amount'=>$totalinterest,
    'total'=>$totalinterest,
    'narration'=>$finalid->client.' -Loan Interest Income '."($loanaccounts->name)",
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    
    
    ]);
###########################################  LOAN FEESS #########################
$resultfees=DB::select("select * from loanfees");
$resultz=DB::select("select * from loanfees where isSavings=1");
if(count($resultz)>0){// if deduct from savings
    accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
    '=',$loanaccounts->disbursingac)->update(
         ['amount'=>str_replace( ',', '',$request['amount']),
        'total'=>str_replace( ',', '',$request['amount'])*-1,
        'narration'=>$finalid->client." -Loan Disbursement- "."($loanaccounts->name)",
        'transdate'=>date("Y-m-d", strtotime($request['date'])),
        
        
        ]);
// selecting loan fees
foreach($resultz as $rs){
    if($rs->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
        // Loan Fee1 
        $this->isSavingDeductupdate($headerid,str_replace( ',', '',$request['loanfee1']),str_replace( ',', '',$request['loanfee1']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])));
        // Savings Ac
        $this->isSavingDeductupdate($headerid,str_replace( ',', '',$request['loanfee1']),str_replace( ',', '',$request['loanfee1'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])));
    }
    if($rs->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
        // Loan Fee2 
        $this->isSavingDeductupdate($headerid,str_replace( ',', '',$request['loanfee2']),str_replace( ',', '',$request['loanfee2']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])));
        // Savings Ac
        $this->isSavingDeductupdate($headerid,str_replace( ',', '',$request['loanfee2']),str_replace( ',', '',$request['loanfee2'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])));
    }
    if($rs->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
                // Loan Fee1 
     $this->isSavingDeductupdate($headerid,str_replace( ',', '',$request['loanfee3']),str_replace( ',', '',$request['loanfee3']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])));
                // Savings Ac
     $this->isSavingDeductupdate($headerid,str_replace( ',', '',$request['loanfee3']),str_replace( ',', '',$request['loanfee3'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])));
    }

}


}else{

$resultscount=DB::select("select  sum(if(isDeduct=1,isDeduct,0)) as Deductnew,sum(if(isDeduct=0,isDeduct,0)) as Nodeductnew from loanfees");
$number=1;
$totalamount=0;
foreach($resultfees as $finalfees){
if($finalfees->isDeduct==1){
    if($finalfees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
        $totalamount=$totalamount+str_replace( ',', '',$request['loanfee1']);
    }
    if($finalfees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
       $totalamount=$totalamount+str_replace( ',', '',$request['loanfee2']);
    }
    if($finalfees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
        $totalamount=$totalamount+str_replace( ',', '',$request['loanfee3']);
    }
}
}
$ded=0;$noded=0;
foreach($resultscount as $ct){
    $ded=$ct->Deductnew;
    $noded=$ct->Nodeductnew;
}
foreach($resultfees as $fees){
// if loan fee is ISDeduct
if($ded>0 && $noded==0){
    if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
        if($fees->isDeduct==0){  
            $answer="No";   
        }else{
            $answer="Yes";
        }
        $this->updatedeductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee1");
    }
    if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
        if($fees->isDeduct==0){  
            $answer="No";   
        }else{
            $answer="Yes";
        }
        $this->updatedeductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee2");
    }
    if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
        if($fees->isDeduct==0){  
            $answer="No";   
        }else{
            $answer="Yes";
        }
        $this->updatedeductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee3");
    }
    if($number==1){
        $this->updatecashaccount($request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount'])-$totalamount,date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct");
        }
        echo "Both ";
}
else if($fees->isDeduct==0){
    if($number==1){
    $this->updatecashaccount($request['loancat'],$headerid,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct");
    }
    if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
        $this->updatedeductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$headerid,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee1");
    }
    if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
        $this->updatedeductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$headerid,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee2");
    }
    if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
        $this->updatedeductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$headerid,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee3");
    }
}else{
        if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
            $this->updatedeductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$headerid,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee1");
        }
        if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
            $this->updatedeductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$headerid,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee2");
        }
        if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
            $this->upatedeductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$headerid,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee3");
        }
        if($number==1){
            $this->updatecashaccount($request['loancat'],$headerid,str_replace( ',', '',$request['amount'])-$totalamount,date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct");
            }
}
$number=$number+1;
}



}      
}
}
	} 
}catch(\Exception $e){
    DB::rollback();
    echo "Failed".$e;
}
DB::commit();

    }

    
 


 public function destroy($id,$headerid){
     DB::beginTransaction();
     try{
$user=auth()->user()->name;
   DB::delete("delete from loantrans where loanid='$id'");
   DB::delete("delete from accounttrans  where purchaseheaderid='$headerid'");
   DB::delete("delete from purchaseheaders where id='$headerid'");
  // DB::delete("delete from loaninfos where id='$id'");
   DB::delete("delete from loanschedules where loanid=$id");
   DB::delete("delete from loanrepayments where loanid=$id");
  $results= DB::select("select id from allsavings where headerid='$headerid'");
  foreach($results as $rs){
  DB::delete("delete from savings where savingsid=$rs->id");
  }
   
   DB::delete("delete from allsavings where headerid='$headerid'");
   // DB::delete("delete from loaninfos where id='$id'");
   $data=loaninfo::find($id);
   $mid=$data->memeberid;
   $appid=$data->appid;
   DB::update("update loaninfos set isApprove=1 where memeberid=$mid and id=$appid");
   $data->delete();

     }catch(\Exception $e){
         echo "Failed".$e;
         DB::rollback();
     }
     DB::commit();

    }
    public function viewcombo(){

        return suppliers::all();

    }

    public function loandisbursement($where){
        $results=array();
        //$branch=auth()->user()->branchid;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        //$bra=auth()->user()->branchid;
        $admin=auth()->user()->isAdmin;
       // if($admin==0){
        $krows = DB::select("select COUNT(*) as count  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id where isLoan=1 and isDisbursement=1 and loantrans.isActive=1 and $where  ");
        $results["total"]=$krows[0]->count;
        
        $sth =  DB::getPdo()->prepare("select appid,format(savings,0) as savings, intmethod as method,loanfee1,loanfee2,loanfee3,period as mode,loancat,loanid,DATE_FORMAT(date,'%d-%m-%Y') as date,memid,paydet,customers.name,loaninterest,loanrepay,collateral,FORMAT(loancredit,0) as loancredit,guanter,headerid from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod where isLoan=1 and isDisbursement=1 and loantrans.isActive=1 and $where limit $offset,$rows");
        $sth->execute();
           $dogs = $sth->fetchAll(\PDO::FETCH_OBJ);
        $results["rows"]=$dogs;
      
                     //Showing The footer and totals 
   //$footer =  DB::getPdo()->prepare("select format(sum(loancredit),0) as loancredit  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 AND loantrans.branchno=$branch $where limit $offset,$rows");
   $footer =  DB::getPdo()->prepare(" select format(sum(loancredit),0) as loancredit from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 and $where ");
   $footer->execute();
   $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
   $results['footer']=$foots;
   echo json_encode($results);
    }
    public function application($bra){
        $results=array();
        //$bra=auth()->user()->branchid;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        //$bra=auth()->user()->branchid;
        $admin=auth()->user()->isAdmin;
       // if($admin==0){
        $krows = DB::select("select COUNT(*) as count from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where savings is Null and $bra");
        $results["total"]=$krows[0]->count;
        
        $sth =  DB::getPdo()->prepare("select format(approveamt,0) as approveamt,rejectrsn, headno,loanofficer, proofofbiz proof,loaninfos.id, memeberid as memid,guanter,loanrepay, groups.name as gname,(case when isApprove=0 then 'Pending' when isApprove=2 then 'In Progress' when isApprove=4 then 'Approved' when isApprove=3 then 'Rejected' end) as status, loaninfos.id as id,format(savings,0) as savings, DATE_FORMAT(applicationdate,'%d-%m-%Y') as date,format(amount,0) as loancredit, intmethod as method,format(loanfee1,0)loanfee1,loanfee2,loanfee3,period as mode,loancat,customers.name,loaninterest,loanrepay,collateral,guanter,security from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where savings is Null and $bra    limit $offset,$rows");
        $sth->execute();
           $dogs = $sth->fetchAll(\PDO::FETCH_OBJ);
        $results["rows"]=$dogs;
      
                     //Showing The footer and totals 
   //$footer =  DB::getPdo()->prepare("select format(sum(loancredit),0) as loancredit  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 AND loantrans.branchno=$branch $where limit $offset,$rows");
   $footer =  DB::getPdo()->prepare(" select format(sum(approveamt),0) as approveamt,format(sum(amount),0) as loancredit from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where savings is Null and $bra ");
   $footer->execute();
   $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
   $results['footer']=$foots;
   echo json_encode($results);
    }
    /*public function authloans($where){
        $admin=auth()->user()->isAdmin;
        if($admin==1){
        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $bra=auth()->user()->branchid;
        $admin=auth()->user()->isAdmin;
       // if($admin==0){
        $krows = DB::select("select COUNT(*) as count from  customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where isLoan=1 and isDisbursement=1 and loantrans.isActive=1  $where");
        $results["total"]=$krows[0]->count;
        
        $sth =  DB::getPdo()->prepare("select loanid,DATE_FORMAT(date,'%d-%m-%Y') as date,headerid,memid,paydet,customers.name,loaninterest,loanrepay,collateral,format(loancredit,0) as loancredit,guanter from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 $where limit $offset,$rows");
        $sth->execute();
           $dogs = $sth->fetchAll(\PDO::FETCH_OBJ);
        $results["rows"]=$dogs;
              //Showing The footer and totals 
              $footer =  DB::getPdo()->prepare("select format(sum(loancredit),0) as loancredit  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 $where limit $offset,$rows");
   $footer->execute();
   $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
   $results['footer']=$foots;
   echo json_encode($results);







        }

    }*/
    // Function to calculate EMI 
   public  function emi_calculator($p, $r, $t,$yearormonth) 
    { 
        $emi; 
        $r;$t;
      if($yearormonth=="Year"){
        // one month interest 
        $r = $r / (12 * 100); 
          
        // one month period 
        $t = $t * 12;  
      }else if($yearormonth=="Month"){ 
                $r = $r / ( 100); 
                $t = $t ;  
      }
        $emi = ($p * $r * pow(1 + $r, $t)) /  
                      (pow(1 + $r, $t) - 1); 
      
        return ($emi); 
    }

    public function deductions($loanfees,$loancategory,$headerid,$amount,$rdate,$client,$fees,$isDeduct,$catidentify,$bra){
        $loanaccounts=loanproducts::find($loancategory); 
        // Loan Fee1 
        if($isDeduct=="No"){
        $objaccountrans=new accounttrans;
        $objaccountrans->purchaseheaderid=$headerid;
        $objaccountrans->amount=$loanfees;//str_replace( ',', '',$request['loanfee1']);
        $objaccountrans->total=$loanfees;
        $objaccountrans->accountcode=$fees->code;
        $objaccountrans->narration=$client." -$fees->name "."($loanaccounts->name)";
        $objaccountrans->ttype="C";
        $objaccountrans->transdate=$rdate;
        $objaccountrans->bracid=$bra;
        $objaccountrans->cat=$catidentify;
        $objaccountrans->save();
        // inserting into accountrans Cash Account for fee1
        $objaccountrans=new accounttrans;
        $objaccountrans->purchaseheaderid=$headerid;
        $objaccountrans->amount=$loanfees;
        $objaccountrans->accountcode=$loanaccounts->disbursingac;
        $objaccountrans->narration=$client." -$fees->name "."($loanaccounts->name)";
        $objaccountrans->ttype="D";
        $objaccountrans->total=$loanfees;
        $objaccountrans->transdate=$rdate;
        $objaccountrans->cat=$catidentify;
        $objaccountrans->bracid=$bra;
        $objaccountrans->save();
        }
        if($isDeduct=="Yes"){
        $objaccountrans=new accounttrans;
        $objaccountrans->purchaseheaderid=$headerid;
        $objaccountrans->amount=$loanfees;//str_replace( ',', '',$request['loanfee1']);
        $objaccountrans->total=$loanfees;
        $objaccountrans->accountcode=$fees->code;
        $objaccountrans->narration=$client." -$fees->name "."($loanaccounts->name)";
        $objaccountrans->ttype="C";
        $objaccountrans->cat=$catidentify;
        $objaccountrans->transdate=$rdate;
        $objaccountrans->bracid=$bra;
        $objaccountrans->save();    
        }
    }
    public function cashaccount($loancategory,$headerid,$amount,$rdate,$client,$cashaccount,$bra){
        $loanaccounts=loanproducts::find($loancategory);
        if($cashaccount=="Deduct"){
            // inserting into accountrans Cash Account 
       $objaccountrans=new accounttrans;
       $objaccountrans->purchaseheaderid=$headerid;
       $objaccountrans->amount=abs($amount);
       $objaccountrans->accountcode=$loanaccounts->disbursingac;
       $objaccountrans->narration=$client." -Loan Disbursement "."($loanaccounts->name)";
       $objaccountrans->ttype="C";
       $objaccountrans->total=$amount*-1;
       $objaccountrans->transdate=$rdate;
       $objaccountrans->bracid=$bra;
       $objaccountrans->save();
        }
    }
    public function isSavingDeduct($headerid,$amount,$total,$accountcode,$narration,$ttype,$tdate,$bra){
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$headerid;
$objaccountrans->amount=$amount;
$objaccountrans->total=$total;
$objaccountrans->accountcode=$accountcode;
$objaccountrans->narration=$narration;
$objaccountrans->ttype=$ttype;
$objaccountrans->transdate=$tdate;
$objaccountrans->bracid=$bra;
$objaccountrans->save();
    }
    public function isSavingDeductupdate($headerid,$amount,$total,$accountcode,$narration,$ttype,$tdate){
        accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=',$ttype)->where('accountcode','=',$accountcode)->update(
     ['amount'=>$amount,
    'total'=>$total,
    'narration'=>$narration,
    'transdate'=>$tdate,
    
    
    ]);

            }
    public function savingstrans($tdate,$clientid,$paydet,$total,$savingcat,$moneyout,$savingid,$narration,$branch){
        $objsaving1=new savings();
        $objsaving1->date=$tdate;
        $objsaving1->client_no=$clientid;
        $objsaving1->paydet=$paydet;
        $objsaving1->isCharge=0;
        $objsaving1->isFee=1;
        $objsaving1->branchno=$branch;
        $objsaving1->total=$total*-1;
        $objsaving1->category=$savingcat;
        $objsaving1->moneyout=$moneyout;
        $objsaving1->savingsid=$savingid;
        $objsaving1->narration=$narration;
        $objsaving1->save();
    }
    public function savingstransupdate($tdate,$clientid,$paydet,$total,$savingcat,$moneyout,$savingid,$narration,$branch){
       $saving= DB::select("select id from savings where savingsid=$savingid");
       foreach($saving as $sy){
        $objsaving1= savings::find($sy->id);
        $objsaving1->date=$tdate;
        $objsaving1->client_no=$clientid;
        $objsaving1->paydet=$paydet;
        $objsaving1->isCharge=0;
        $objsaving1->branchno=$branch;
        $objsaving1->total=$total*-1;
        $objsaving1->category=$savingcat;
        $objsaving1->moneyout=$moneyout;
        $objsaving1->savingsid=$savingid;
        $objsaving1->narration=$narration;
        $objsaving1->save();
       }
    }
    public function updatecashaccount($loancategory,$headerid,$amount,$rdate,$client,$cashaccount){
        $loanaccounts=loanproducts::find($loancategory);
        if($cashaccount=="Deduct"){
            // inserting into accountrans Cash Account 
       accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
       '=',$loanaccounts->disbursingac)->update(
            ['amount'=>abs($amount),
           'total'=>$amount*-1,
           'narration'=>$client." -Loan Disbursement "."($loanaccounts->name)",
           'transdate'=>$rdate,
           
           
           ]);
        }
    }
    public function updatedeductions($loanfees,$loancategory,$headerid,$amount,$rdate,$client,$fees,$isDeduct,$loancatid){
        $loanaccounts=loanproducts::find($loancategory); 
        // Loan Fee1 
        if($isDeduct=="No"){
        // Inserting into loan processing one 
        accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
        '=',$fees->code)->where('cat','=',$loancatid)->update(
             ['amount'=>$loanfees,
            'total'=>$loanfees,
            'narration'=>$client." -$fees->name "."($loanaccounts->name)",
            'transdate'=>$rdate,
            
            
            ]);    
                            // inserting  Cash Account 
       accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
       '=',$loanaccounts->disbursingac)->where('cat','=',$loancatid)->update(
            ['amount'=>$loanfees,
           'total'=>$loanfees,
           'narration'=>$client." -$fees->name "."($loanaccounts->name)",
           'transdate'=>$rdate,
           
           
           ]);
        }
        if($isDeduct=="Yes"){
                    // inserting  one sided loanfees 
       accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
       '=',$fees->code)->where('cat','=',$loancatid)->update(
            ['amount'=>$loanfees,
           'total'=>$loanfees,
           'narration'=>$client." -$fees->name "."($loanaccounts->name)",
           'transdate'=>$rdate,
           
           
           ]); 
                               // inserting  one sided loanfees 
       accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
       '=',$loanaccounts->disbursingac)->where('cat','=',$loancatid)->update(
            ['amount'=>0,
           'total'=>0,
           'narration'=>$client." -$fees->name "."($loanaccounts->name)",
           'transdate'=>$rdate,
           
           
           ]);   
        }
    }
    public function loandisburse(){
        return view('loandisburse/index');
    }
}
