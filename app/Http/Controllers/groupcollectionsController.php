<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\groupcollections;
use App\companynames;
use App\loantrans;
use App\loaninfo;
use App\accounttrans;
use App\purchaseheaders;
use App\loanbals;
use App\interestbals;
use App\loanschedules;
use App\loanproducts;
use App\allsavings;
use App\customers;
use App\groups;

 class groupcollectionsController extends Controller{

public function index(){
    return view('groupcollections/index');
}
public function view(){
    if(auth()->user()->branchid==1){
        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branch'])){
       $bra=$_GET['branch'];
            $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
            $this->application(" branch=$bra and date=$today   "); 
           
         
         }
        
         else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['branch'])){
            $date1=date("Y-m-d", strtotime($_GET['date1']));
            $date2=date("Y-m-d", strtotime($_GET['date2']));
           $this->application("date  BETWEEN '$date1' AND '$date2' ");
         
         }
    }else{
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2'])){
        $bra=auth()->user()->branchid;
        $today=date("'Y-m-d'");//, strtotime($_GET['date1']));
        $this->application(" date=$today and branch=$bra"); 
     
     }
    
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $bra=auth()->user()->branchid;
       $this->application(" date  BETWEEN '$date1' AND '$date2' and branch=$bra ");
     
     }
    }
}
public function application($where){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select COUNT(*) as count from groupcollections inner join groups on groups.id=groupcollections.groupid where $where ");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select *,groupcollections.id as id,DATE_FORMAT(date,'%d-%m-%Y')as date,groups.name as name,format(amount,0) as amount, format(surcharge,0) as surcharge,format(amount+surcharge,0) as total from groupcollections inner join groups on groups.id=groupcollections.groupid where $where  limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
      // echo json_encode($results);
                           //Showing The footer and totals 
   //$footer =  DB::getPdo()->prepare("select format(sum(loancredit),0) as loancredit  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 AND loantrans.branchno=$branch $where limit $offset,$rows");
   $footer =  DB::getPdo()->prepare(" select format(sum(amount),0) as amount, format(sum(surcharge),0) as surcharge,format(sum(amount+surcharge),0) as total from groupcollections inner join groups on groups.id=groupcollections.groupid where $where");
   $footer->execute();
   $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
   $results['footer']=$foots;
   echo json_encode($results);

    
}
public function save(Request $request){
    $bra=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
    $branch=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
    DB::beginTransaction();
    try{
       //inserting into purchase headers and transloans
       $truepen=0;
       $objpurchaseheaders= new purchaseheaders();
       $objpurchaseheaders->isActive=1;
       $objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['date'])); 
       $objpurchaseheaders->save();
       $groupamt=DB::select("select sum(penalty) as penz,groupid,count(groupid) as no ,scheduledate,expecteddate  from (select penalty,groupid,scheduledate,expecteddate from pen where groupid=$request[groupid] order by loanid desc limit 5 ) t");
foreach($groupamt as $amt){
    $truepen=$amt->penz;
}
$penate=str_replace( ',', '',$request['surcharge'])/(($truepen*0.1)*5);
$newpenate=substr($penate, 0, 2);
$Objgroupcollections=new groupcollections();
$Objgroupcollections->groupid=$request['groupid'];
$Objgroupcollections->amount=str_replace( ',', '',$request['amount']);
$Objgroupcollections->surcharge=(($truepen*0.1)*5)*$newpenate;
//$Objgroupcollections->paymentdet=$request['paymentdet'];
$Objgroupcollections->date=date("Y-m-d", strtotime($request['date']));;
$Objgroupcollections->branch=$bra;
$Objgroupcollections->headno=$objpurchaseheaders->id;
$file=$request->file('proof');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objgroupcollections->proof=$filename;

}
$file=$request->file('paymentdet');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objgroupcollections->bankslip=$filename;

}
$Objgroupcollections->save();
$objgroups=groups::find($request['groupid']);

################### ALL SAVINGS TABLE ####################
############ CASH AT HAND 
$objaccountranscash=new accounttrans;
$objaccountranscash->purchaseheaderid=$objpurchaseheaders->id;
$objaccountranscash->amount=str_replace( ',', '',$request['amount'])+(($truepen*0.1)*5)*$newpenate;
$objaccountranscash->total=str_replace( ',', '',$request['amount'])+(($truepen*0.1)*5)*$newpenate;
$objaccountranscash->accountcode=21;// Disburing Account
$objaccountranscash->narration=$objgroups->name." -Loan,Insurance,Interest,Compulsory & Surcharge";
$objaccountranscash->ttype="D";
$objaccountranscash->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountranscash->bracid=$branch;

$totalgroup=0;
$groupamt=DB::select("select sum(penalty) as penz,groupid,count(groupid) as no ,scheduledate,expecteddate  from (select penalty,groupid,scheduledate,expecteddate from pen where groupid=$request[groupid] order by loanid desc limit 5 ) t");
foreach($groupamt as $amt){
    $totalgroup=$amt->penz;
}
$groupmembers=DB::select("select loanid,memid, penalty,groupid ,scheduledate,expecteddate  from (select memid,pen.loanid,penalty,groupid,scheduledate,pen.expecteddate from pen inner join loantrans on loantrans.loanid=pen.loanid where groupid=$request[groupid] group by loanid  order by pen.loanid desc limit 5 ) t");
foreach($groupmembers as $members){
    $objallsavings= new allsavings();
    $objallsavings->branchno=$branch;
    $objallsavings->client_no=$members->memid;
    $objallsavings->recieptno=$request['paymentdet'];
    $objallsavings->date=date("Y-m-d", strtotime($request['date']));
    $objallsavings->headerid=$objpurchaseheaders->id;
    
        $id=$members->memid;
        $amount=$members->penalty;
        $mem=DB::select("select loaninterest, intmethod,loancat,customers.name as client,sum(loan) as loanbal,sum(interestcredit) as creditinterest,abs(sum(if(interestcredit<0,interestcredit,0))) as interestcredit,abs(sum(if(loan<0,loan,0))) as loanpaid,abs(sum(if(loan<0,loan,0))) as loan,loanid from loantrans inner join customers on loantrans.memid=customers.id inner join loaninfos on loantrans.loanid=loaninfos.id where loantrans.isActive=1 and loantrans.branchno=$branch and memid=$id group by loanid order by loanid desc limit 1");
        foreach($mem as $memberid){  
            $lnidz=$members->loanid;
            $loansz= DB::select("select id, loancredit from loantrans where isLoan=1 and isDisbursement=1 and loanid=$lnidz limit 1 ");
            
            foreach($loansz as $ln){
            $insurance=($ln->loancredit*0.02)/16;
            $savings=($ln->loancredit*0.2)/16;
            $interest=(($ln->loancredit*($memberid->loaninterest/100))*4)/16;
            $loanborrowed=($ln->loancredit/16);
            $surcharge=$totalgroup*0.1;

                if(str_replace( ',', '',$request['amount'])>0 && str_replace( ',', '',$request['surcharge'])>0){
                    if(str_replace( ',', '',$request['amount'])==$totalgroup){
        if($newpenate>0 ){
 ################ ALL SAVINGS AGAI ##############
 $objallsavings->loanint1=$interest*-1;
 $objallsavings->loanpdt1=($loanborrowed+$insurance+$savings)*-1;
 $objallsavings->savingpdt1=$savings;
 $objallsavings->narration="Interest,Insurance,Surcharge & Compulsory Payment";
 #################### LOANTRANS ######################
$objloantrans= new loantrans();
$objloantrans->memid=$members->memid;
$objloantrans->interestcredit=$interest*-1;
$objloantrans->loancredit=($interest+$loanborrowed+$savings+$insurance+($surcharge*$newpenate))*-1;
$objloantrans->date=date("Y-m-d", strtotime($request['date']));
$objloantrans->narration="Interest,Loan,Insurance & Compul savings";
$objloantrans->loanid=$memberid->loanid;
$objloantrans->branchno=$branch;
$objloantrans->isLoan=1;
$objloantrans->surcharge=($surcharge*$newpenate)*-1;
$objloantrans->headerid=$objpurchaseheaders->id;
$objloantrans->isActive=1;
$objloantrans->user=auth()->user()->name;
$objloantrans->isRepayment=1;
$objloantrans->paydet=$request['paymentdet'];
$objloantrans->loan=($loanborrowed+$savings+$insurance+($surcharge*$newpenate))*-1;
$objloantrans->save();

 // Inserting into accounts
 $objloaninfo= new loaninfo();
 $objloaninfo->isInterestPay=1;

  ########## ACCOUNTTRANS #################3
// Inserting into  cash account

// Inserting into  Loan interest Rec  
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$interest;
$objaccountrans1->total=$interest*-1;
$objaccountrans1->accountcode=122;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Interest Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$loanborrowed;
$objaccountrans1->total=$loanborrowed*-1;
$objaccountrans1->accountcode=121;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan  Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan insurance
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$insurance;
$objaccountrans1->total=$insurance*-1;
$objaccountrans1->accountcode=199;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan Insurance ";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$savings;
$objaccountrans1->total=$savings;
$objaccountrans1->accountcode=400;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Compulsory Savings";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
####################################SURCHARGE ##################3

$objallsavings->surcharge=($surcharge*$newpenate)*-1;
// Inserting into Surcharge Cash at Hand 
$objaccountrans5=new accounttrans;
$objaccountrans5->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans5->amount=$surcharge*$newpenate;
$objaccountrans5->total=($surcharge*$newpenate)*-1;
$objaccountrans5->accountcode=128; // Loan Code
$objaccountrans5->ttype="C";
//$objaccountrans5->cat='surcharge';
$objaccountrans5->narration=$memberid->client." -Surcharge Payment";
$objaccountrans5->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans5->bracid=$branch;
$objaccountrans5->save();
        }else{
            return['half'=>'No'];
            
        }

        }else{
            return['Loan'=>'No','figure'=>number_format($totalgroup)];   
        }    
    } else if(str_replace( ',', '',$request['amount'])){
        if(str_replace( ',', '',$request['amount'])==$totalgroup){

 ################ ALL SAVINGS AGAI ##############
 $objallsavings->loanint1=$interest*-1;
 $objallsavings->loanpdt1=($loanborrowed+$insurance+$savings)*-1;
 $objallsavings->savingpdt1=$savings;
 $objallsavings->narration="Interest,Insurance & Compulsory Payment";
 #################### LOANTRANS ######################
$objloantrans= new loantrans();
$objloantrans->memid=$members->memid;
$objloantrans->interestcredit=$interest*-1;
$objloantrans->loancredit=($interest+$loanborrowed+$savings+$insurance)*-1;
$objloantrans->date=date("Y-m-d", strtotime($request['date']));
$objloantrans->narration="Interest,Loan,Insurance & Compul savings";
$objloantrans->loanid=$memberid->loanid;
$objloantrans->branchno=$branch;
$objloantrans->isLoan=1;
$objloantrans->headerid=$objpurchaseheaders->id;
$objloantrans->isActive=1;
$objloantrans->user=auth()->user()->name;
$objloantrans->isRepayment=1;
$objloantrans->paydet=$request['paymentdet'];
$objloantrans->loan=($loanborrowed+$savings+$insurance)*-1;
$objloantrans->save();

 // Inserting into accounts
 $objloaninfo= new loaninfo();
 $objloaninfo->isInterestPay=1;

  ########## ACCOUNTTRANS #################3
// Inserting into  cash account

// Inserting into  Loan interest Rec  
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$interest;
$objaccountrans1->total=$interest*-1;
$objaccountrans1->accountcode=122;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Interest Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$loanborrowed;
$objaccountrans1->total=$loanborrowed*-1;
$objaccountrans1->accountcode=121;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan  Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan insurance
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$insurance;
$objaccountrans1->total=$insurance*-1;
$objaccountrans1->accountcode=199;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan Insurance ";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=$savings;
$objaccountrans1->total=$savings;
$objaccountrans1->accountcode=400;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Compulsory Savings";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
####################################SURCHARGE ##################3

$objallsavings->surcharge=0;
// Inserting into Surcharge Cash at Hand 
$objaccountrans5=new accounttrans;
$objaccountrans5->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans5->amount=0;
$objaccountrans5->total=0;
$objaccountrans5->accountcode=128; // Loan Code
$objaccountrans5->ttype="C";
//$objaccountrans5->cat='surcharge';
$objaccountrans5->narration=$memberid->client." -Surcharge Payment";
$objaccountrans5->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans5->bracid=$branch;
$objaccountrans5->save();

        }else{
            return['Loan'=>'No','figure'=>number_format($totalgroup)];   
        }

    } else if(str_replace( ',', '',$request['surcharge'])>0){
        if($newpenate>0 ){
################ ALL SAVINGS AGAI ##############
$objallsavings->loanint1=0;
$objallsavings->loanpdt1=0;
$objallsavings->savingpdt1=0;
$objallsavings->narration="Surcharge Payment";
#################### LOANTRANS ######################
$objloantrans= new loantrans();
$objloantrans->memid=$members->memid;
$objloantrans->interestcredit=0;
$objloantrans->loancredit=($surcharge*$newpenate)*-1;
$objloantrans->date=date("Y-m-d", strtotime($request['date']));
$objloantrans->narration="Surcharge Payment";
$objloantrans->loanid=$memberid->loanid;
$objloantrans->branchno=$branch;
$objloantrans->isLoan=1;
$objloantrans->surcharge=($surcharge*$newpenate)*-1;
$objloantrans->headerid=$objpurchaseheaders->id;
$objloantrans->isActive=1;
$objloantrans->user=auth()->user()->name;
$objloantrans->isRepayment=1;
$objloantrans->paydet=$request['paymentdet'];
$objloantrans->loan=($surcharge*$newpenate)*-1;;
$objloantrans->save();

// Inserting into accounts
$objloaninfo= new loaninfo();
$objloaninfo->isInterestPay=1;

 ########## ACCOUNTTRANS #################3
// Inserting into  cash account

// Inserting into  Loan interest Rec  
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=122;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Interest Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=121;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan  Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan insurance
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=199;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan Insurance ";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=400;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Compulsory Savings";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
####################################SURCHARGE ##################3

$objallsavings->surcharge=($surcharge*$newpenate)*-1;
// Inserting into Surcharge Cash at Hand 
$objaccountrans5=new accounttrans;
$objaccountrans5->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans5->amount=($surcharge*$newpenate);
$objaccountrans5->total=($surcharge*$newpenate)*-1;
$objaccountrans5->accountcode=128; // Loan Code
$objaccountrans5->ttype="C";
//$objaccountrans5->cat='surcharge';
$objaccountrans5->narration=$memberid->client." -Surcharge Payment";
$objaccountrans5->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans5->bracid=$branch;
$objaccountrans5->save();

        }else{
            return['half'=>'No'];
            
        }


    } 
          
            }
        }  
        $objallsavings->save();  
        $objaccountranscash->save(); 
}
}catch(\Exception $e){
        echo "failed to save ".$e;
        DB::rollBack();
    }
    DB::commit();

}
 public function destroy($id){
DB::beginTransaction();
try{

        $Objgroupcollections=groupcollections::find($id);
        $header=$Objgroupcollections->headno;
        DB::delete("delete from purchaseheaders where id= $header");
        DB::delete("delete from accounttrans where purchaseheaderid= $header");
        DB::delete("delete from loantrans where headerid= $header");
        DB::delete("delete from allsavings where headerid= $header");
        $Objgroupcollections->delete();
}catch(\Exception $e){
    echo "Failed to Save ".$e;
    DB::rollBack();
}
DB::commit();


    }

public function viewcombo(){


    return groupcollections::all();
}

public function groupbalance($id){
    $totalloan=0;
    $installment=0;
    $totalsurcharge=0;
    $surcharge=DB::select("select sum(surcharge)as surchage  from allsavings inner join groupmembers on groupmembers.memberid=allsavings.client_no where groupid=$id");
    $groupmembers=DB::select("select loanid,memid, sum(penalty) as penalty,groupid ,scheduledate,expecteddate  from (select memid,pen.loanid,penalty,groupid,scheduledate,pen.expecteddate from pen inner join loantrans on loantrans.loanid=pen.loanid where groupid=$id group by loanid  order by pen.loanid desc limit 5 ) t");
   $loan =DB::select("select if(sum(loancredit) is null,0,sum(loancredit-surcharge)) as loancredit from customers inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid left outer join  loantrans on loantrans.memid=customers.id where groups.id=$id");
   foreach($loan as $loanz){
       $totalloan=$loanz->loancredit;
   }
   foreach($groupmembers as $members){
       $installment=$members->penalty;
   }
   foreach($surcharge as $sir){
       $totalsurcharge=$sir->surchage;
   }
  
   echo json_encode(['loanbal'=>number_format($totalloan,2),'installments'=>number_format($installment,2),'surcharge'=>number_format($totalsurcharge,2)]);
}
/*public function paymentdetails($id){

    //$group=groupcollections::find($id);
    $group=DB::select("select format(amount+surcharge,0) as total, groups.name,paymentdet,bankslip,proof,DATE_FORMAT(date,'%d-%m-%Y') as date,format(amount,0) as amount,format(surcharge,0) as surcharge from groupcollections inner join groups on groups.id=groupcollections.groupid where groupcollections.id=$id");
    //return $group;
    return view('paymentdetails.index')->with('groupdata',$group);
}*/
public function paymentdetails($id,$date){
    $newdate =date("Y-m-d", strtotime($date));
    //$group=groupcollections::find($id);
    $group=DB::select("select * from indpayments where grpid=$id and date='$newdate' ");
    //return $group;
    return view('paymentdetails.index')->with('groupdata',$group);
}
public function update(Request $request,$id){


    DB::beginTransaction();
    try{
        $truepen=0;
        $headerid=$request['headno'];
        $bra=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
        $branch=auth()->user()->branchid==1?$request['branch']:$bra=auth()->user()->branchid;
        $groupamt=DB::select("select sum(penalty) as penz,groupid,count(groupid) as no ,scheduledate,expecteddate  from (select penalty,groupid,scheduledate,expecteddate from pen where groupid=$request[groupid] order by loanid desc limit 5 ) t");
        foreach($groupamt as $amt){
            $truepen=$amt->penz;
        }
        $penate=str_replace( ',', '',$request['surcharge'])/(($truepen*0.1)*5);
        $newpenate=substr($penate, 0, 2);

$Objgroupcollections=groupcollections::find($id);
$Objgroupcollections->groupid=$request['groupid'];
$Objgroupcollections->amount=str_replace( ',', '',$request['amount']);
$Objgroupcollections->surcharge=str_replace( ',', '',$request['surcharge']);
$Objgroupcollections->paymentdet=$request['paymentdet'];
$Objgroupcollections->date=date("Y-m-d", strtotime($request['date']));
$file=$request->file('proof');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objgroupcollections->proof=$filename;

}
$file=$request->file('paymentdet');
$destinationPath="images";
if($file!=Null){
    $filename=$file->getClientOriginalName();
    //moving it to the folder
    $file->move($destinationPath,$filename);
    $Objgroupcollections->bankslip=$filename;

}
$Objgroupcollections->save();
$objgroups=groups::find($request['groupid']);
// Updating cash at hand 
################### ALL SAVINGS TABLE ####################
############ CASH AT HAND 
//Loan Interest Income
DB::statement("delete  from accounttrans where purchaseheaderid=$headerid");
DB::statement("delete from loantrans where headerid=$headerid");
DB::statement("delete from allsavings where headerid=$headerid");
$objaccountranscash=new accounttrans;
$objaccountranscash->purchaseheaderid=$headerid;
$objaccountranscash->amount=str_replace( ',', '',$request['amount'])+(($truepen*0.1)*5)*$newpenate;
$objaccountranscash->total=str_replace( ',', '',$request['amount'])+(($truepen*0.1)*5)*$newpenate;
$objaccountranscash->accountcode=21;// Disburing Account
$objaccountranscash->narration=$objgroups->name." -Loan,Insurance,Interest,Compulsory & Surcharge";
$objaccountranscash->ttype="D";
$objaccountranscash->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountranscash->bracid=$branch;

$totalgroup=0;
$groupamt=DB::select("select sum(penalty) as penz,groupid,count(groupid) as no ,scheduledate,expecteddate  from (select penalty,groupid,scheduledate,expecteddate from pen where groupid=$request[groupid] order by loanid desc limit 5 ) t");
foreach($groupamt as $amt){
    $totalgroup=$amt->penz;
}

$groupmembers=DB::select("select loanid,memid, penalty,groupid ,scheduledate,expecteddate  from (select memid,pen.loanid,penalty,groupid,scheduledate,pen.expecteddate from pen inner join loantrans on loantrans.loanid=pen.loanid where groupid=$request[groupid] group by loanid  order by pen.loanid desc limit 5 ) t");
foreach($groupmembers as $members){
    $objallsavings= new allsavings();
    $objallsavings->branchno=$branch;
    $objallsavings->client_no=$members->memid;
    $objallsavings->recieptno=$request['paymentdet'];
    $objallsavings->date=date("Y-m-d", strtotime($request['date']));
    $objallsavings->headerid=$headerid;
    
        $id=$members->memid;
        $amount=$members->penalty;
        $mem=DB::select("select loaninterest, intmethod,loancat,customers.name as client,sum(loan) as loanbal,sum(interestcredit) as creditinterest,abs(sum(if(interestcredit<0,interestcredit,0))) as interestcredit,abs(sum(if(loan<0,loan,0))) as loanpaid,abs(sum(if(loan<0,loan,0))) as loan,loanid from loantrans inner join customers on loantrans.memid=customers.id inner join loaninfos on loantrans.loanid=loaninfos.id where loantrans.isActive=1 and loantrans.branchno=$branch and memid=$id group by loanid order by loanid desc limit 1");
        foreach($mem as $memberid){  
            $lnidz=$members->loanid;
            $loansz= DB::select("select id, loancredit from loantrans where isLoan=1 and loanid=$lnidz and isDisbursement=1 limit 1");
            
            foreach($loansz as $ln){
            $insurance=($ln->loancredit*0.02)/16;
            $savings=($ln->loancredit*0.2)/16;
            $interest=(($ln->loancredit*($memberid->loaninterest/100))*4)/16;
            $loanborrowed=($ln->loancredit/16);
            $surcharge=$totalgroup*0.1;

                if(str_replace( ',', '',$request['amount'])>0 && str_replace( ',', '',$request['surcharge'])>0){
                    if(str_replace( ',', '',$request['amount'])==$totalgroup){
        if($newpenate>0 ){
 ################ ALL SAVINGS AGAI ##############
 $objallsavings->loanint1=$interest*-1;
 $objallsavings->loanpdt1=($loanborrowed+$insurance+$savings)*-1;
 $objallsavings->savingpdt1=$savings;
 $objallsavings->narration="Interest,Insurance,Surcharge & Compulsory Payment";
 #################### LOANTRANS ######################
 $objloantrans= new loantrans();
 $objloantrans->memid=$members->memid;
 $objloantrans->interestcredit=$interest*-1;
 $objloantrans->loancredit=($interest+$loanborrowed+$savings+$insurance+($surcharge*$newpenate))*-1;
 $objloantrans->date=date("Y-m-d", strtotime($request['date']));
 $objloantrans->narration="Interest,Loan,Insurance & Compul savings";
 $objloantrans->loanid=$memberid->loanid;
 $objloantrans->branchno=$branch;
 $objloantrans->isLoan=1;
 $objloantrans->surcharge=($surcharge*$newpenate)*-1;
 $objloantrans->headerid=$headerid;
 $objloantrans->isActive=1;
 $objloantrans->user=auth()->user()->name;
 $objloantrans->isRepayment=1;
 $objloantrans->paydet=$request['paymentdet'];
 $objloantrans->loan=($loanborrowed+$savings+$insurance+($surcharge*$newpenate))*-1;
 $objloantrans->save();

 // Inserting into accounts
 $objloaninfo= new loaninfo();
 $objloaninfo->isInterestPay=1;

  ########## ACCOUNTTRANS #################3
// Inserting into  cash account

// Inserting into  Loan interest Rec  
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$interest;
$objaccountrans1->total=$interest*-1;
$objaccountrans1->accountcode=122;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Interest Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$loanborrowed;
$objaccountrans1->total=$loanborrowed*-1;
$objaccountrans1->accountcode=121;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan  Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan insurance
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$insurance;
$objaccountrans1->total=$insurance*-1;
$objaccountrans1->accountcode=199;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan Insurance ";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$savings;
$objaccountrans1->total=$savings;
$objaccountrans1->accountcode=400;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Compulsory Savings";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
####################################SURCHARGE ##################3

$objallsavings->surcharge=($surcharge*$newpenate)*-1;
// Inserting into Surcharge Cash at Hand 
$objaccountrans5=new accounttrans;
$objaccountrans5->purchaseheaderid=$headerid;
$objaccountrans5->amount=$surcharge*$newpenate;
$objaccountrans5->total=($surcharge*$newpenate)*-1;
$objaccountrans5->accountcode=128; // Loan Code
$objaccountrans5->ttype="C";
//$objaccountrans5->cat='surcharge';
$objaccountrans5->narration=$memberid->client." -Surcharge Payment";
$objaccountrans5->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans5->bracid=$branch;
$objaccountrans5->save();
        }else{
            return['half'=>'No'];
            
        }

        }else{
            return['Loan'=>'No','figure'=>number_format($totalgroup)];   
        }    
    } else if(str_replace( ',', '',$request['amount'])){
        if(str_replace( ',', '',$request['amount'])==$totalgroup){

 ################ ALL SAVINGS AGAI ##############
 $objallsavings->loanint1=$interest*-1;
 $objallsavings->loanpdt1=($loanborrowed+$insurance+$savings)*-1;
 $objallsavings->savingpdt1=$savings;
 $objallsavings->narration="Interest,Insurance & Compulsory Payment";
 #################### LOANTRANS ######################
$objloantrans= new loantrans();
$objloantrans->memid=$members->memid;
$objloantrans->interestcredit=$interest*-1;
$objloantrans->loancredit=($interest+$loanborrowed+$savings+$insurance)*-1;
$objloantrans->date=date("Y-m-d", strtotime($request['date']));
$objloantrans->narration="Interest,Loan,Insurance & Compul savings";
$objloantrans->loanid=$memberid->loanid;
$objloantrans->branchno=$branch;
$objloantrans->isLoan=1;
$objloantrans->headerid=$headerid;
$objloantrans->isActive=1;
$objloantrans->user=auth()->user()->name;
$objloantrans->isRepayment=1;
$objloantrans->paydet=$request['paymentdet'];
$objloantrans->loan=($loanborrowed+$savings+$insurance)*-1;
$objloantrans->save();

 // Inserting into accounts
 $objloaninfo= new loaninfo();
 $objloaninfo->isInterestPay=1;

  ########## ACCOUNTTRANS #################3
// Inserting into  cash account

// Inserting into  Loan interest Rec  
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$interest;
$objaccountrans1->total=$interest*-1;
$objaccountrans1->accountcode=122;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Interest Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$loanborrowed;
$objaccountrans1->total=$loanborrowed*-1;
$objaccountrans1->accountcode=121;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan  Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan insurance
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$insurance;
$objaccountrans1->total=$insurance*-1;
$objaccountrans1->accountcode=199;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan Insurance ";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=$savings;
$objaccountrans1->total=$savings;
$objaccountrans1->accountcode=400;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Compulsory Savings";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
####################################SURCHARGE ##################3

$objallsavings->surcharge=0;
// Inserting into Surcharge Cash at Hand 
$objaccountrans5=new accounttrans;
$objaccountrans5->purchaseheaderid=$headerid;
$objaccountrans5->amount=0;
$objaccountrans5->total=0;
$objaccountrans5->accountcode=128; // Loan Code
$objaccountrans5->ttype="C";
//$objaccountrans5->cat='surcharge';
$objaccountrans5->narration=$memberid->client." -Surcharge Payment";
$objaccountrans5->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans5->bracid=$branch;
$objaccountrans5->save();

        }else{
            return['Loan'=>'No','figure'=>number_format($totalgroup)];   
        }

    } else if(str_replace( ',', '',$request['surcharge'])>0){
        if($newpenate>0 ){
################ ALL SAVINGS AGAI ##############
$objallsavings->loanint1=0;
$objallsavings->loanpdt1=0;
$objallsavings->savingpdt1=0;
$objallsavings->narration="Surcharge Payment";
#################### LOANTRANS ######################
$objloantrans= new loantrans();
$objloantrans->memid=$members->memid;
$objloantrans->interestcredit=0;
$objloantrans->loancredit=($surcharge*$newpenate)*-1;
$objloantrans->date=date("Y-m-d", strtotime($request['date']));
$objloantrans->narration="Surcharge Payment";
$objloantrans->loanid=$memberid->loanid;
$objloantrans->branchno=$branch;
$objloantrans->isLoan=1;
$objloantrans->surcharge=($surcharge*$newpenate)*-1;
$objloantrans->headerid=$headerid;
$objloantrans->isActive=1;
$objloantrans->user=auth()->user()->name;
$objloantrans->isRepayment=1;
$objloantrans->paydet=$request['paymentdet'];
$objloantrans->loan=($surcharge*$newpenate)*-1;;
$objloantrans->save();

// Inserting into accounts
$objloaninfo= new loaninfo();
$objloaninfo->isInterestPay=1;

 ########## ACCOUNTTRANS #################3
// Inserting into  cash account

// Inserting into  Loan interest Rec  
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=122;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Interest Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=121;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan  Repayment";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan insurance
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=199;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Loan Insurance ";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
// Inserting into  Loan 
$objaccountrans1=new accounttrans;
$objaccountrans1->purchaseheaderid=$headerid;
$objaccountrans1->amount=0;
$objaccountrans1->total=0;
$objaccountrans1->accountcode=400;// Disburing Account
$objaccountrans1->narration=$memberid->client." - Compulsory Savings";
$objaccountrans1->ttype="C";
$objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans1->bracid=$branch;
$objaccountrans1->save();
####################################SURCHARGE ##################3

$objallsavings->surcharge=($surcharge*$newpenate)*-1;
// Inserting into Surcharge Cash at Hand 
$objaccountrans5=new accounttrans;
$objaccountrans5->purchaseheaderid=$headerid;
$objaccountrans5->amount=($surcharge*$newpenate);
$objaccountrans5->total=($surcharge*$newpenate)*-1;
$objaccountrans5->accountcode=128; // Loan Code
$objaccountrans5->ttype="C";
//$objaccountrans5->cat='surcharge';
$objaccountrans5->narration=$memberid->client." -Surcharge Payment";
$objaccountrans5->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans5->bracid=$branch;
$objaccountrans5->save();

        }else{
            return['half'=>'No'];
            
        }


    } 
          
            }
        }  
        $objallsavings->save();  
        $objaccountranscash->save(); 
}
    }catch(\Exception $e){
        echo "failed to save ".$e;
        DB::rollBack();
    }
    DB::commit();



}
}
