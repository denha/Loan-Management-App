<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
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

  class companynamesController extends Controller{

public function index(){
    return view('companynames/index1');
}
public function view(){
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1']) && empty($_GET['date2'])){
       
        $today=date("'Y-m-d'");
$this->loanrepayments(" and date=$today");
    }
    if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
       
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
       // $branch=$_GET['branch'];
        $this->loanrepayments("and date  BETWEEN '$date1' AND '$date2'  ");
     
     }
     if(isset($_GET['page'])&& isset($_GET['rows'])  && empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branch'])){
       
        $today=date("'Y-m-d'");
        $branch=$_GET['branch'];
        $this->authrepay("and date=$today and users.branchid=$branch ");
     
     }
 

    
}
public function save(Request $request){ 
    DB::beginTransaction();
    try{
    $branch=auth()->user()->branchid;
    $id=$request['name'];
    $amount=str_replace( ',', '',$request['amount']);
    $mem=DB::select("select intmethod,loancat,customers.name as client,sum(loan) as loanbal,sum(interestcredit) as creditinterest,abs(sum(if(interestcredit<0,interestcredit,0))) as interestcredit,abs(sum(if(loan<0,loan,0))) as loanpaid,abs(sum(if(loan<0,loan,0))) as loan,loanid from loantrans inner join customers on loantrans.memid=customers.id inner join loaninfos on loantrans.loanid=loaninfos.id where loantrans.isActive=1 and loantrans.branchno=$branch and memid=$id group by loanid order by loanid desc limit 1");
    foreach($mem as $memberid){  
//GLOBAL VARIABLES
       $interest=0;
       $loan=0;

        $loandet=DB::select("select intrunbal,loanrunbal from loanrepayments inner join loaninfos  on loanrepayments.loanid=loaninfos.id where  branchno=$branch and loanid=$memberid->loanid  order by loanrepayments.id ");
       $isIntbal=$this->getInterestRBal($memberid->loanid,$memberid->interestcredit,$memberid->creditinterest,$memberid->loanpaid);
       $interestiteration=$memberid->interestcredit;
       $loaniteration=$memberid->loanpaid;
       ################################  DISCONTINUED ################################
       if($isIntbal==1){
        while($amount>0){
                          //Principle
        if($loaniteration+$amount>$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
           $loa=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))-$loaniteration;
           $loan=$loan+$loa;
            $amount=$amount-$loa;
            $loaniteration=$loaniteration+$loa;
            
        }else if($loaniteration+$amount<=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
            $loan=$loan+$amount;
            $amount=$amount-$amount;
            $loaniteration=$loaniteration+$amount;
        }  
        if($amount<=0){
            break;
        }
        if($memberid->creditinterest==0){
            break;
        }                   // Interest
        if($interestiteration+$amount>$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
          $inter=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))-$interestiteration;
         $interest=$interest+$inter;
         $amount=$amount-$inter;
         $interestiteration=$interestiteration+$inter;
         
         }else if($interestiteration+$amount<=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
         $interest=$interest+$amount;
         $amount=$amount-$amount;
         $interestiteration=$interestiteration+$amount;
    
         } 
  
         }
       }else if($isIntbal!=1 ){
// Dealing with the entire Interest
        while($amount>0){
            // if one block figure is entered
            if($memberid->creditinterest+$memberid->loanbal==$amount){
                $loan=$memberid->loanbal;
                $interest=$memberid->creditinterest;
                break;
            }
                        // Interest
                     if($interestiteration+$amount>$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
                            $inter=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))-$interestiteration;
                            
                            $interest=$interest+$inter;
                            $amount=$amount-$inter;
                            $interestiteration=$interestiteration+$inter;
                        }else if($interestiteration+$amount<=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
                            $interest=$interest+$amount;
                            $amount=$amount-$amount;
                            $interestiteration=$interestiteration+$amount;
    
                        } 
                        //Principle
            if($loaniteration+$amount>$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
               // echo "The principle is ".$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"));
                $loa=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))-$loaniteration;
                $loan=$loan+$loa;
                $amount=$amount-$loa;
                $loaniteration=$loaniteration+$loa;
           
             }else if($loaniteration+$amount<=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
                $loan=$loan+$amount;
                $amount=$amount-$amount;
                $loaniteration=$loaniteration+$amount;
            }
         }  
       }
// discontinued on 26/11/2020
      /* Chopping off the interest if($amount<=$memberid->creditinterest){
           $interest=$amount;
       }else if($amount>$memberid->creditinterest){
           $interest=$memberid->creditinterest;
           
           if($amount-$memberid->creditinterest>$memberid->loanbal){
            $loan=$memberid->loanbal;
           }else{
            $loan=$amount-$memberid->creditinterest;
          }
       }else if($memberid->creditinterest==0){
           $loan=$amount;
       }*/
       $objallsavings= new allsavings();
$objallsavings->branchno=$branch;
$objallsavings->client_no=$request['name'];
$objallsavings->recieptno=$request['paymentdetails'];
$objallsavings->date=date("Y-m-d", strtotime($request['date']));
$loanpdts=loanproducts::find($memberid->loancat);
       //inserting into purchase headers and transloans
                   $objpurchaseheaders= new purchaseheaders();
                   $objpurchaseheaders->isActive=1;
                   $objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['date'])); 
                   $objpurchaseheaders->save();
if(str_replace( ',', '',$request['amount'])>0){

                   ###################################################################################################
                   // Posting Interest Alone 
                           if(round($interest,0)>0 && $loan<=0){
                               if($loanpdts->loanpdt=="loanpdt1"){
                                   $objallsavings->narration="Interest Repayment";
                                   $objallsavings->loanint1=$interest*-1;
                                   $objallsavings->loanpdt1=0;
                                   $objallsavings->headerid=$objpurchaseheaders->id;
                                   //$objallsavings->save();
                                }
                                if($loanpdts->loanpdt=="loanpdt2"){
                                    $objallsavings->narration="Interest Repayment";
                                    $objallsavings->loanint2=$interest*-1;
                                    $objallsavings->headerid=$objpurchaseheaders->id;
                                   // $objallsavings->save();
                                 } if($loanpdts->loanpdt=="loanpdt3"){
                                    $objallsavings->narration="Interest Repayment";
                                    $objallsavings->loanint3=$interest*-1;
                                    $objallsavings->headerid=$objpurchaseheaders->id;
                                   // $objallsavings->save();
                                 }
                                 if($loanpdts->loanpdt=="loanpdt4"){
                                    $objallsavings->narration="Interest Repayment";
                                    $objallsavings->loanint4=$interest*-1;
                                    $objallsavings->headerid=$objpurchaseheaders->id;
                                   // $objallsavings->save();
                                 }
                                 if($loanpdts->loanpdt=="loanpdt5"){
                                    $objallsavings->narration="Interest Repayment";
                                    $objallsavings->loanint5=$interest*-1;
                                    $objallsavings->headerid=$objpurchaseheaders->id;
                                    //$objallsavings->save();
                                 }
                                 // posting in loantrans;
                               $objloantrans= new loantrans();
                               $objloantrans->memid=$request['name'];
                               $objloantrans->interestcredit=$interest*-1;
                               $objloantrans->loancredit=$interest*-1;
                               $objloantrans->date=date("Y-m-d", strtotime($request['date']));
                               $objloantrans->narration= "Interest Repayment";
                               $objloantrans->loanid=$memberid->loanid;
                               $objloantrans->isLoan=1;
                               $objloantrans->branchno=$branch;
                               $objloantrans->headerid=$objpurchaseheaders->id;
                               $objloantrans->user=auth()->user()->name;
                               $objloantrans->isRepayment=1;
                               $objloantrans->paydet=$request['paymentdetails'];
                               $objloantrans->isActive=1;
                           
                              // DB::statement("update loantrans set isLastPay=0 where memid=$request[name]");
                              // $objloantrans->isLastPay=1;
                               //$objloantrans->save();
                               // Inserting into accounts
                               $objloaninfo= new loaninfo();
                               $objloaninfo->isInterestPay=1;
                              // $objloaninfo->save();
                    ###########################################################################################################
                   // inserting into accountrans  interest recivable 
                   $objaccountrans1=new accounttrans;
                   $objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
                   $objaccountrans1->amount=$interest;
                   $objaccountrans1->total=$interest*-1;
                   $objaccountrans1->accountcode="122";
                   $objaccountrans1->narration= $memberid->client." -Interest Repayment";
                   $objaccountrans1->ttype="C";
                   $objaccountrans1->bracid=auth()->user()->branchid;
                   $objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
                   //$objaccountrans->save();
                   // Recieving Account                      
                   ############################################# Cash Account ##########################################################   
                               // inserting into accountrans  
                               $objaccountrans2=new accounttrans;
                               $objaccountrans2->purchaseheaderid=$objpurchaseheaders->id;
                               $objaccountrans2->amount=$interest;
                               $objaccountrans2->accountcode=$loanpdts->disbursingac;// Disbursing Account
                               $objaccountrans2->narration=$memberid->client." -Interest Repayment";
                               $objaccountrans2->ttype="D";
                               $objaccountrans2->total=$interest;
                               $objaccountrans2->transdate=date("Y-m-d", strtotime($request['date']));
                               $objaccountrans2->bracid=auth()->user()->branchid;
                              // $objaccountrans->save();
                   ######################## Dammy Account for Editing #############################################
                               $objaccountrans3=new accounttrans;
                               $objaccountrans3->purchaseheaderid=$objpurchaseheaders->id;
                               $objaccountrans3->amount="";
                               $objaccountrans3->accountcode=$loanpdts->accountcode;
                               $objaccountrans3->narration="";
                               $objaccountrans3->ttype="";
                               $objaccountrans3->total="";
                               $objaccountrans3->transdate="";
                               $objaccountrans3->bracid=auth()->user()->branchid;
                              // $objaccountrans->save();
                   
                   #######################################################################################################
                   
                           }else if(round($interest,0)>0 && $loan >0){
                                   // purchaseing into purchae headers 
                                   /*$objpurchaseheaders= new purchaseheaders();
                                   $objpurchaseheaders->isActive=1;
                                   $objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['date']));*/
                                   //$objpurchaseheaders->save();
                   
                   ########################################################################################################
                   if($loanpdts->loanpdt=="loanpdt1"){
                    $objallsavings->narration="Interest & Loan Repayment";
                    $objallsavings->loanint1=$interest*-1;
                    $objallsavings->loanpdt1=$loan*-1;
                    $objallsavings->headerid=$objpurchaseheaders->id;
                    //$objallsavings->save();
                 }
                 if($loanpdts->loanpdt=="loanpdt2"){
                    $objallsavings->narration="Interest & Loan Repayment";
                    $objallsavings->loanint2=$interest*-1;
                    $objallsavings->loanpdt2=$loan*-1;
                    $objallsavings->headerid=$objpurchaseheaders->id;
                   // $objallsavings->save();
                 }   if($loanpdts->loanpdt=="loanpdt3"){
                    $objallsavings->narration="Interest & Loan Repayment";
                    $objallsavings->loanint3=$interest*-1;
                    $objallsavings->loanpdt3=$loan*-1;
                    $objallsavings->headerid=$objpurchaseheaders->id;
                   // $objallsavings->save();
                 }
                 if($loanpdts->loanpdt=="loanpdt4"){
                    $objallsavings->narration="Interest & Loan Repayment";
                    $objallsavings->loanint4=$interest*-1;
                    $objallsavings->loanpdt4=$loan*-1;
                    $objallsavings->headerid=$objpurchaseheaders->id;
                   // $objallsavings->save();
                 }
                 if($loanpdts->loanpdt=="loanpdt5"){
                    $objallsavings->narration="Interest & Loan Repayment";
                    $objallsavings->loanint5=$interest*-1;
                    $objallsavings->loanpdt5=$loan*-1;
                    $objallsavings->headerid=$objpurchaseheaders->id;
                   // $objallsavings->save();
                 } 
                               $objloantrans= new loantrans();
                               $objloantrans->memid=$request['name'];
                               $objloantrans->interestcredit=$interest*-1;
                               $objloantrans->loancredit=($interest+$loan)*-1;
                               $objloantrans->date=date("Y-m-d", strtotime($request['date']));
                               $objloantrans->narration="Interest & Loan Repayment";
                               $objloantrans->loanid=$memberid->loanid;
                               $objloantrans->branchno=$branch;
                               $objloantrans->isLoan=1;
                               $objloantrans->headerid=$objpurchaseheaders->id;
                               $objloantrans->isActive=1;
                               $objloantrans->user=auth()->user()->name;
                               $objloantrans->isRepayment=1;
                               $objloantrans->paydet=$request['paymentdetails'];
                               $objloantrans->loan=$loan*-1;
                              // $objloantrans->save();
                   
                                // Inserting into accounts
                                $objloaninfo= new loaninfo();
                                $objloaninfo->isInterestPay=1;
                                //$objloaninfo->save();
                            
                                // Inserting into  cash account 
                                $objaccountrans1=new accounttrans;
                                $objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
                                $objaccountrans1->amount=$interest+$loan;
                                $objaccountrans1->total=$interest+$loan;
                                $objaccountrans1->accountcode=$loanpdts->disbursingac;// Disburing Account
                                $objaccountrans1->narration=$memberid->client." -Loan and Interest Repayment";
                                $objaccountrans1->ttype="D";
                                $objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
                                $objaccountrans1->bracid=auth()->user()->branchid;
                               // $objaccountrans->save();
                                // Inserting into income account
                                $objaccountrans2=new accounttrans;
                                $objaccountrans2->purchaseheaderid=$objpurchaseheaders->id;
                                $objaccountrans2->amount=$interest;
                                $objaccountrans2->accountcode="122";
                                $objaccountrans2->ttype="C";
                                $objaccountrans2->total=$interest*-1;
                                $objaccountrans2->narration=$memberid->client." -Interest Repayment";
                                $objaccountrans2->transdate=date("Y-m-d", strtotime($request['date']));
                                $objaccountrans2->bracid=auth()->user()->branchid;
                                //$objaccountrans->save();
                                // inserting / reducing loan account
                                $objaccountrans3=new accounttrans;
                                $objaccountrans3->purchaseheaderid=$objpurchaseheaders->id;
                                $objaccountrans3->amount=abs($loan*-1);
                                $objaccountrans3->total=$loan*-1;
                                $objaccountrans3->accountcode=$loanpdts->accountcode;// Accout code
                                $objaccountrans3->narration=$memberid->client." -Loan Repayment ";
                                $objaccountrans3->ttype="C";
                                $objaccountrans3->bracid=auth()->user()->branchid;
                                $objaccountrans3->transdate=date("Y-m-d", strtotime($request['date']));
                               // $objaccountrans->save();
                                echo "Hey";
                   
                   
                           }
                           else if($loan>0 && round($interest,0)<=0){
                              
                   
                                   // purchaseing into purchae headers 
                                  /* $objpurchaseheaders= new purchaseheaders();
                                   $objpurchaseheaders->isActive=1; 
                                   $objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['date']));*/
                                  // $objpurchaseheaders->save();
                   ############################################################################################################               
                              // $newloan=$request['amount']-$memberid->interestcredit;
                               //$newloan=$request['amount']-$newinterest;
                               if($loanpdts->loanpdt=="loanpdt1"){
                                $objallsavings->narration="Loan Repayment";
                                $objallsavings->loanpdt1=$loan*-1;
                                $objallsavings->headerid=$objpurchaseheaders->id;
                               // $objallsavings->save();
                             }
                             if($loanpdts->loanpdt=="loanpdt2"){
                                $objallsavings->narration="Loan Repayment";
                                $objallsavings->loanpdt2=$loan*-1;
                                $objallsavings->headerid=$objpurchaseheaders->id;
                                //$objallsavings->save();
                             }
                             if($loanpdts->loanpdt=="loanpdt3"){
                                $objallsavings->narration="Loan Repayment";
                                $objallsavings->loanpdt3=$loan*-1;
                                $objallsavings->headerid=$objpurchaseheaders->id;
                               // $objallsavings->save();
                             }
                             if($loanpdts->loanpdt=="loanpdt4"){
                                $objallsavings->narration="Loan Repayment";
                                $objallsavings->loanpdt4=$loan*-1;
                                $objallsavings->headerid=$objpurchaseheaders->id;
                                //$objallsavings->save();
                             }
                             if($loanpdts->loanpdt=="loanpdt5"){
                                $objallsavings->narration="Loan Repayment";
                                $objallsavings->loanpdt5=$loan*-1;
                                $objallsavings->headerid=$objpurchaseheaders->id;
                                //$objallsavings->save();
                             }
                               
                               $objloantrans= new loantrans();
                               $objloantrans->memid=$request['name'];
                               $objloantrans->interestcredit=$interest*-1;
                               $objloantrans->loancredit=$interest*-1+$loan*-1;
                               $objloantrans->date=date("Y-m-d", strtotime($request['date']));
                               $objloantrans->narration=" Loan Repayment";
                               $objloantrans->user=auth()->user()->name;
                               $objloantrans->loanid=$memberid->loanid;
                               $objloantrans->isLoan=1;
                               $objloantrans->branchno=$branch;
                               $objloantrans->isRepayment=1;
                               $objloantrans->headerid=$objpurchaseheaders->id;
                               $objloantrans->isActive=1;
                               $objloantrans->paydet=$request['paymentdetails'];
                               $objloantrans->loan=$loan*-1;
                               //$objloantrans->save();
                               //get loan info
                               $objloaninfo= new loaninfo();
                                $objloaninfo->isInterestPay=1;
                               // $objloaninfo->save();
                            
                                // Inserting into  cash account 
                                $objaccountrans1=new accounttrans;
                                $objaccountrans1->purchaseheaderid=$objpurchaseheaders->id;
                                $objaccountrans1->amount=$loan;
                                $objaccountrans1->total=$loan;
                                $objaccountrans1->accountcode=$loanpdts->disbursingac;// Disbursing Account
                                $objaccountrans1->narration=$memberid->client." -Loan Repayment";
                                $objaccountrans1->ttype="D";
                                $objaccountrans1->transdate=date("Y-m-d", strtotime($request['date']));
                                $objaccountrans1->bracid=auth()->user()->branchid;
                                //$objaccountrans->save();
                                //inserting into loan account
                                  // Inserting into  cash account 
                                  $objaccountrans2=new accounttrans;
                                  $objaccountrans2->purchaseheaderid=$objpurchaseheaders->id;
                                  $objaccountrans2->amount=abs($loan*-1);
                                  $objaccountrans2->total=abs($loan*-1)*-1;
                                  $objaccountrans2->accountcode=$loanpdts->accountcode; // Loan Code
                                  $objaccountrans2->ttype="C";
                                  $objaccountrans2->narration=$memberid->client." -Loan Repayment";
                                  $objaccountrans2->transdate=date("Y-m-d", strtotime($request['date']));
                                  $objaccountrans2->bracid=auth()->user()->branchid;
                                  //$objaccountrans->save();
                   
                    ######################## Dammy Account for Editing #############################################
                               $objaccountrans3=new accounttrans;
                               $objaccountrans3->purchaseheaderid=$objpurchaseheaders->id;
                               $objaccountrans3->amount="";
                               $objaccountrans3->accountcode="122";
                               $objaccountrans3->narration="";
                               $objaccountrans3->ttype="";
                               $objaccountrans3->total="";
                               $objaccountrans3->transdate="";
                               $objaccountrans3->bracid=auth()->user()->branchid;
                               //$objaccountrans->save();
                           }
                           // Throwing Dammy data in accounttrans
                           if(str_replace( ',', '',$request['surcharge'])<1){
                               // Dammy for cash account
                            $objaccountrans=new accounttrans;
                            $objaccountrans->purchaseheaderid=$objpurchaseheaders->id;
                            $objaccountrans->amount="";
                            $objaccountrans->accountcode="21";
                            $objaccountrans->narration="";
                            $objaccountrans->ttype="";
                            $objaccountrans->total="";
                            $objaccountrans->transdate="";
                            $objaccountrans->cat="surcharge";
                            $objaccountrans->bracid=auth()->user()->branchid;
                            $objaccountrans->save();
                            // Dammy for surcharge account
                            $objaccountrans=new accounttrans;
                            $objaccountrans->purchaseheaderid=$objpurchaseheaders->id;
                            $objaccountrans->amount="";
                            $objaccountrans->accountcode="128";
                            $objaccountrans->narration="";
                            $objaccountrans->ttype="";
                            $objaccountrans->total="";
                            $objaccountrans->transdate="";
                            $objaccountrans->stockidentify="";
                            $objaccountrans->bracid=auth()->user()->branchid;
                            $objaccountrans->save();

                           }

}else{
    //################################################ if is than a zero
}

########################################################### SURCHARGE ##############################
if(str_replace( ',', '',$request['surcharge'])>0){
    if(str_replace(',','',$request['amount'])<1){
        $objloaninfo= new loaninfo();
         $objallsavings->headerid=$objpurchaseheaders->id;
         $objallsavings->narration=" Surcharge Payment";
        $objloaninfo->isInterestPay=1;
        $objloantrans= new loantrans();
        $objloantrans->memid=$request['name'];
        $objloantrans->interestcredit=0;
        $objloantrans->loancredit=0;
        $objloantrans->date=date("Y-m-d", strtotime($request['date']));
        $objloantrans->narration=" Surcharge Payment";
        $objloantrans->user=auth()->user()->name;
        $objloantrans->loanid=$memberid->loanid;
        $objloantrans->isLoan=1;
        $objloantrans->branchno=$branch;
        $objloantrans->isRepayment=1;
        $objloantrans->headerid=$objpurchaseheaders->id;
        $objloantrans->isActive=1;
        $objloantrans->paydet=$request['paymentdetails'];
        $objloantrans->loan=0;
        // creating dam accounts for everyhting
      // Inserting into  cash account 
        $objaccountrans=new accounttrans;
        $objaccountrans->purchaseheaderid=$objpurchaseheaders->id;
        $objaccountrans->amount='';
        $objaccountrans->total='';
        $objaccountrans->accountcode=$loanpdts->disbursingac;// Disbursing Account
        $objaccountrans->narration=$memberid->client." -Loan Repayment";
        $objaccountrans->ttype="D";
        $objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
        $objaccountrans->bracid=auth()->user()->branchid;
        $objaccountrans->save();
                                        //inserting into loan account
                                          // Inserting into  cash account 
        $objaccountrans=new accounttrans;
        $objaccountrans->purchaseheaderid=$objpurchaseheaders->id;
        $objaccountrans->amount='';
        $objaccountrans->total='';
        $objaccountrans->accountcode=$loanpdts->accountcode; // Loan Code
        $objaccountrans->ttype="C";
        $objaccountrans->narration=$memberid->client." -Loan Repayment";
        $objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
        $objaccountrans->bracid=auth()->user()->branchid;
        $objaccountrans->save();
                                          //$objaccountrans->save();
                           
 ######################## Dammy Account for Editing #############################################
        $objaccountrans=new accounttrans;
        $objaccountrans->purchaseheaderid=$objpurchaseheaders->id;
        $objaccountrans->amount="";
        $objaccountrans->accountcode="122";
        $objaccountrans->narration="";
        $objaccountrans->ttype="";
        $objaccountrans->total="";
        $objaccountrans->transdate="";
        $objaccountrans->bracid=auth()->user()->branchid;
        $objaccountrans->save();
    }
echo "Yes";
$objloantrans->surcharge=str_replace( ',', '',$request['surcharge']);
$objallsavings->surcharge=str_replace( ',', '',$request['surcharge'])*-1;
// Inserting into Surcharge Recievables 
$objaccountrans4=new accounttrans;
$objaccountrans4->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans4->amount=str_replace( ',', '',$request['surcharge']);
$objaccountrans4->total=str_replace( ',', '',$request['surcharge']);
$objaccountrans4->accountcode=128; // Loan Code
$objaccountrans4->ttype="C";
$objaccountrans4->narration=$memberid->client." -Surcharge Payment";
$objaccountrans4->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans4->bracid=auth()->user()->branchid;

// Inserting into Surcharge Cash at Hand 
$objaccountrans5=new accounttrans;
$objaccountrans5->purchaseheaderid=$objpurchaseheaders->id;
$objaccountrans5->amount=str_replace( ',', '',$request['surcharge']);
$objaccountrans5->total=str_replace( ',', '',$request['surcharge']);
$objaccountrans5->accountcode=21; // Loan Code
$objaccountrans5->ttype="D";
$objaccountrans5->cat='surcharge';
$objaccountrans5->narration=$memberid->client." -Surcharge Payment";
$objaccountrans5->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans5->bracid=auth()->user()->branchid;

}
//savings
$objloantrans->save();
$objloaninfo->save();
$objallsavings->save();
if(str_replace( ',', '',$request['amount'])>0){
$objaccountrans1->save();
$objaccountrans2->save();
$objaccountrans3->save();
}
if(str_replace( ',', '',$request['surcharge'])>0){
$objaccountrans4->save();
$objaccountrans5->save();
}
    }

    
    
}catch(\Exception $e){
    echo "Failed ".$e;
    DB::rollback();
}
DB::commit();
    

}
// NEW function for reducing a number interms of monthly loan and interest

public function totalIntLoan($totalloan,$scheduleloan){
    while($totalloan>$scheduleloan){
        $totalloan=$totalloan-$scheduleloan;
        if($totalloan==0){
            $totalloan=$scheduleloan;
        }
    }
    return $totalloan;
}
//Auto generated code for updating
public function update(Request $request,$headerid,$deleteloan){
  
    $totalinterest=0;
    DB::beginTransaction();
    try{
        $branch=auth()->user()->branchid;
    $id=$request['name'];
    $amount=str_replace( ',', '',$request['amount']);
    $mem=DB::select("select intmethod,loancat,sum(loan) as loanbal, customers.id as clientid,customers.name as client,sum(interestcredit) as creditinterest,abs(sum(if(interestcredit<0,interestcredit,0))) as interestcredit,abs(sum(if(loan<0,loan,0))) as loanpaid,abs(sum(if(loan<0,loan,0))) as loan,loanid from loantrans inner join customers on loantrans.memid=customers.id inner join loaninfos on loantrans.loanid=loaninfos.id where loantrans.isActive=1 and name='$id' and loantrans.branchno=$branch and loantrans.headerid!=$headerid");
    foreach($mem as $memberid){
//GLOBAL VARIABLES
$interest=0;
$loan=0;

################ BEGINING OF DISCONTINUATION ##############3
// select if its reducing balance or flatline
 $loandet=DB::select("select intrunbal,loanrunbal from loanrepayments inner join loaninfos  on loanrepayments.loanid=loaninfos.id where loanid=$memberid->loanid and loanrepayments.branchno=$branch  order by loanrepayments.id ");
 $isIntbal=$this->getInterestRBal($memberid->loanid,$memberid->interestcredit,$memberid->creditinterest,$memberid->loanpaid);
$interestiteration=$memberid->interestcredit;
$loaniteration=$memberid->loanpaid;
if($isIntbal==1){
    while($amount>0){
                      //Principle
    if($loaniteration+$amount>$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
       $loa=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))-$loaniteration;
       $loan=$loan+$loa;
        $amount=$amount-$loa;
        $loaniteration=$loaniteration+$loa;
        
    }else if($loaniteration+$amount<=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
        $loan=$loan+$amount;
        $amount=$amount-$amount;
        $loaniteration=$loaniteration+$amount;
    }  
    if($amount<=0){
        break;
    }
    if($memberid->creditinterest==0){
        break;
    }                   // Interest
    if($interestiteration+$amount>$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
      $inter=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))-$interestiteration;
     $interest=$interest+$inter;
     $amount=$amount-$inter;
     $interestiteration=$interestiteration+$inter;
     
     }else if($interestiteration+$amount<=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
     $interest=$interest+$amount;
     $amount=$amount-$amount;
     $interestiteration=$interestiteration+$amount;

     } 

     }
   }else if($isIntbal!=1 ){
// Dealing with the entire Interest
    while($amount>0){
        // if one block figure is entered
        if($memberid->creditinterest+$memberid->loanbal==$amount){
            $loan=$memberid->loanbal;
            $interest=$memberid->creditinterest;
            break;
        }
                    // Interest
                 if($interestiteration+$amount>$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
                        $inter=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))-$interestiteration;
                        
                        $interest=$interest+$inter;
                        $amount=$amount-$inter;
                        $interestiteration=$interestiteration+$inter;
                    }else if($interestiteration+$amount<=$this->getintRBal($memberid->loanid,$this->getPosition($interestiteration,$this->getintRBal($memberid->loanid,$interestiteration),$memberid->loanid,"interest"))){
                        $interest=$interest+$amount;
                        $amount=$amount-$amount;
                        $interestiteration=$interestiteration+$amount;

                    } 
                    //Principle
        if($loaniteration+$amount>$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
           // echo "The principle is ".$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"));
            $loa=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))-$loaniteration;
            $loan=$loan+$loa;
            $amount=$amount-$loa;
            $loaniteration=$loaniteration+$loa;
       
         }else if($loaniteration+$amount<=$this->getLoanRBal($memberid->loanid,$this->getPosition($loaniteration,$this->getLoanRBal($memberid->loanid,$loaniteration),$memberid->loanid,"loan"))){
            $loan=$loan+$amount;
            $amount=$amount-$amount;
            $loaniteration=$loaniteration+$amount;
        }
     }  
   } ############ END OF DISCONTINUATION 
// Computation for only interest  discontinuted on 28/11/2020
  /* if($amount<=$memberid->creditinterest){
    $interest=$amount;
}else if($amount>$memberid->creditinterest){
    $interest=$memberid->creditinterest;
    
    if($amount-$memberid->creditinterest>$memberid->loanbal){
     $loan=$memberid->loanbal;
    }else{
     $loan=$amount-$memberid->creditinterest;
   }
}else if($memberid->creditinterest==0){
    $loan=$amount;
}
*/
// code for taking off only the interest 

$allsavingid=allsavings::where('headerid',$headerid)->where('branchno','=',$branch)->get();
$savyid=0;
foreach($allsavingid as $savy){
    $savyid=$savy->id;
}
$objallsavings= allsavings::find($savyid);
$loanpdts=loanproducts::find($memberid->loancat);
$newsurcharge=str_replace( ',', '',$request['surcharge'])>0?str_replace( ',', '',$request['surcharge']):0;
if(str_replace( ',', '',$request['amount'])>0){
    

$objallsavings->client_no=$memberid->clientid;
$objallsavings->recieptno=$request['paymentdetails'];
$objallsavings->date=date("Y-m-d", strtotime($request['date']));

###################################################################################################
        if($interest>0 && $loan<=0){
            if($loanpdts->loanpdt=="loanpdt1"){
                $objallsavings->narration="Interest Repayment";
                $objallsavings->loanint1=$interest*-1;
                $objallsavings->loanpdt1=0;
               // $objallsavings->headerid=$objpurchaseheaders->id;
                //$objallsavings->save();
             }
             if($loanpdts->loanpdt=="loanpdt2"){
                 $objallsavings->narration="Interest Repayment";
                 $objallsavings->loanint2=$interest*-1;
                // $objallsavings->headerid=$objpurchaseheaders->id;
                // $objallsavings->save();
              } if($loanpdts->loanpdt=="loanpdt3"){
                 $objallsavings->narration="Interest Repayment";
                 $objallsavings->loanint3=$interest*-1;
                 //$objallsavings->headerid=$objpurchaseheaders->id;
                // $objallsavings->save();
              }
              if($loanpdts->loanpdt=="loanpdt4"){
                 $objallsavings->narration="Interest Repayment";
                 $objallsavings->loanint4=$interest*-1;
                // $objallsavings->headerid=$objpurchaseheaders->id;
                 //$objallsavings->save();
              }
              if($loanpdts->loanpdt=="loanpdt5"){
                 $objallsavings->narration="Interest Repayment";
                 $objallsavings->loanint5=$interest*-1;
                // $objallsavings->headerid=$objpurchaseheaders->id;
                // $objallsavings->save();
              }
            
            // Emptying already filled up fields in the database
            loantrans::where('headerid','=',$headerid)->update([
                'memid'=>'',
                'interestcredit'=>'',
                'loancredit'=>'',
                'date'=>'',
                'paydet'=>'',
                'isActive'=>'',
                'narration'=>'',

            ]);
            loantrans::where('headerid','=',$headerid)->update([
                'memid'=>$memberid->clientid,
                'interestcredit'=>$interest*-1,
                'loancredit'=>$interest*-1,
                'date'=>date("Y-m-d", strtotime($request['date'])),
                'paydet'=>$request['paymentdetails'],
                'isActive'=>1,
                'narration'=>$memberid->client.' -Interest Repayment',
                'loan'=>0,
                'surcharge'=>$newsurcharge,

            ]);


            
          ####################### stopped here today for editing  11/09/2019  ###################################
          
 ###########################################################################################################
 //updating or emptying the fields in the database 
 accounttrans::where('purchaseheaderid','=',$headerid)->where('bracid','=',$branch)->update([
    'amount'=>'',
    'ttype'=>'',
    'total'=>'',
    'narration'=>'',
    'transdate'=>'',
    'bracid'=>auth()->user()->branchid,
    
    ]);
// inserting into accountrans  interest recivable 
accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',122)->where('bracid','=',$branch)->update([
'amount'=>$interest,
'total'=>$interest*-1,
'narration'=>$memberid->client.' -Interest Repayment',
'transdate'=>date("Y-m-d", strtotime($request['date'])),
'ttype'=>'C',
'bracid'=>auth()->user()->branchid,

]);

// Recieving Account                      
############################################# Cash Account ##########################################################   
            // inserting into accountrans  
            accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->disbursingac)->where('bracid','=',$branch)->update([
                'amount'=>$interest,
                'narration'=>$memberid->client.' -Interest Repayment',
                'total'=>$interest,
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                'ttype'=>'D',
                'bracid'=>auth()->user()->branchid,


            ]);

                                    // Dammy Account 
                                    accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->accountcode)->where('bracid','=',$branch)->update([
                                        'amount'=>'',
                                        'total'=>'',
                                        'narration'=>'',
                                        'ttype'=>'',
                                        'transdate'=>'',
                                        'bracid'=>auth()->user()->branchid,
                        
                                    ]);
         

#######################################################################################################

                                     }else if($interest>0 && $loan >0 ){
                                        if($loanpdts->loanpdt=="loanpdt1"){
                                            $objallsavings->narration="Interest & Loan Repayment";
                                            $objallsavings->loanint1=$interest*-1;
                                            $objallsavings->loanpdt1=$loan*-1;
                                            //$objallsavings->headerid=$objpurchaseheaders->id;
                                            //$objallsavings->save();
                                         }
                                         if($loanpdts->loanpdt=="loanpdt2"){
                                            $objallsavings->narration="Interest & Loan Repayment";
                                            $objallsavings->loanint2=$interest*-1;
                                            $objallsavings->loanpdt2=$loan*-1;
                                            //$objallsavings->headerid=$objpurchaseheaders->id;
                                            //$objallsavings->save();
                                         }   if($loanpdts->loanpdt=="loanpdt3"){
                                            $objallsavings->narration="Interest & Loan Repayment";
                                            $objallsavings->loanint3=$interest*-1;
                                            $objallsavings->loanpdt3=$loan*-1;
                                            //$objallsavings->headerid=$objpurchaseheaders->id;
                                            //$objallsavings->save();
                                         }
                                         if($loanpdts->loanpdt=="loanpdt4"){
                                            $objallsavings->narration="Interest & Loan Repayment";
                                            $objallsavings->loanint4=$interest*-1;
                                            $objallsavings->loanpdt4=$loan*-1;
                                            //$objallsavings->headerid=$objpurchaseheaders->id;
                                           // $objallsavings->save();
                                         }
                                         if($loanpdts->loanpdt=="loanpdt5"){
                                            $objallsavings->narration="Interest & Loan Repayment";
                                            $objallsavings->loanint5=$interest*-1;
                                            $objallsavings->loanpdt5=$loan*-1;
                                            //$objallsavings->headerid=$objpurchaseheaders->id;
                                            //$objallsavings->save();
                                         } 
            
                // purchaseing into purchae headers 
               loantrans::where('headerid','=',$headerid)->where('branchno','=',$branch)->update([
                    'memid'=>'',
                    'interestcredit'=>'',
                    'loancredit'=>'',
                    'date'=>'',
                    'paydet'=>'',
                    'isActive'=>'',
                    'narration'=>'',
                    'loan'=>'',
    
                ]);
               

########################################################################################################
            
           // $newloan=$request['amount']-$memberid->interestcredit;
           // echo $newloan;
           
           //$newloan=$request['amount']-$newinterest;
            loantrans::where('headerid','=',$headerid)->where('branchno','=',$branch)->update([
                'memid'=>$memberid->clientid,
                'interestcredit'=>$interest*-1,
                'loancredit'=>$interest*-1+$loan*-1,
                'date'=>date("Y-m-d", strtotime($request['date'])),
                'isRepayment'=>1,
                'narration'=>'Interest & Loan Repayment',
                'paydet'=>$request['paymentdetails'],
                'loan'=>$loan*-1,
                'isActive'=>1,
                'surcharge'=>$newsurcharge,


            ]);
     
            accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->accountcode)->where('bracid','=',$branch)->update([
                'amount'=>$loan,
                'ttype'=>'C',
                'total'=>$loan*-1,
                'narration'=>$memberid->client.' -Loan  Repayment',
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                'bracid'=>auth()->user()->branchid,
                
                ]);
         
             // Inserting into  cash account 
             accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->disbursingac)->whereNull('cat')->where('bracid','=',$branch)->update([
                 'amount'=>abs($interest*-1+$loan*-1),
                 'total'=>abs($interest*-1+$loan*-1),
                 'narration'=>$memberid->client.' -Loan and Interest Repayment',
                 'ttype'=>'D',
                 'transdate'=>date("Y-m-d", strtotime($request['date'])),
                 'bracid'=>auth()->user()->branchid,



             ]);
            
             // Inserting into income account
             accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',122)->where('bracid','=',$branch)->update([
                'amount'=>abs($interest*-1),
                'total'=>abs($interest*-1)*-1,
                'narration'=>$memberid->client.' -Interest Repayment',
                'ttype'=>'C',
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                'bracid'=>auth()->user()->branchid,



            ]);
          
             // inserting / reducing loan account

             accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->accountcode)->where('bracid','=',$branch)->update([
                'amount'=>abs($loan*-1),
                'total'=>abs($loan*-1)*-1,
                'narration'=>$memberid->client.' -Loan Repayment',
                'ttype'=>'C',
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                'bracid'=>auth()->user()->branchid,



            ]);

             }
        else if($loan>0 && $interest<=0){
            if($loanpdts->loanpdt=="loanpdt1"){
                $objallsavings->narration="Loan Repayment";
                $objallsavings->loanpdt1=$loan*-1;
                //$objallsavings->headerid=$objpurchaseheaders->id;
                //$objallsavings->save();
             }
             if($loanpdts->loanpdt=="loanpdt2"){
                $objallsavings->narration="Loan Repayment";
                $objallsavings->loanpdt2=$loan*-1;
                //$objallsavings->headerid=$objpurchaseheaders->id;
                //$objallsavings->save();
             }
             if($loanpdts->loanpdt=="loanpdt3"){
                $objallsavings->narration="Loan Repayment";
                $objallsavings->loanpdt3=$loan*-1;
                //$objallsavings->headerid=$objpurchaseheaders->id;
               // $objallsavings->save();
             }
             if($loanpdts->loanpdt=="loanpdt4"){
                $objallsavings->narration="Loan Repayment";
                $objallsavings->loanpdt4=$loan*-1;
                //$objallsavings->headerid=$objpurchaseheaders->id;
                //$objallsavings->save();
             }
             if($loanpdts->loanpdt=="loanpdt5"){
                $objallsavings->narration="Loan Repayment";
                $objallsavings->loanpdt5=$loan*-1;
                //$objallsavings->headerid=$objpurchaseheaders->id;
                //$objallsavings->save();
             }
            loantrans::where('headerid','=',$headerid)->where('branchno','=',$branch)->update([
                'memid'=>'',
                'interestcredit'=>'',
                'loancredit'=>'',
                'date'=>'',
                'paydet'=>'',
                'isActive'=>'',
                'narration'=>'',

            ]);          
############################################################################################################ 
             

           // $newloan=$request['amount']-$memberid->interestcredit;
            //$newloan=$request['amount']-$newinterest;
            loantrans::where('headerid','=',$headerid)->where('branchno','=',$branch)->update([
                'memid'=>$memberid->clientid,
                'loan'=>$interest*-1+$loan*-1,
                'loancredit'=>$interest*-1+$loan*-1,
                'date'=>date("Y-m-d", strtotime($request['date'])),
                'paydet'=>$request['paymentdetails'],
                'isActive'=>1,
                'narration'=>$memberid->client.' -Loan Repayment',
                'surcharge'=>$newsurcharge,

            ]);
           

            accounttrans::where('purchaseheaderid','=',$headerid)->where('bracid','=',$branch)->update([
                'amount'=>'',
                'ttype'=>'',
                'total'=>'',
                'narration'=>'',
                'transdate'=>'',
                'bracid'=>auth()->user()->branchid,
                
                ]);
             // Inserting into  cash account 

             accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->disbursingac)->where('bracid','=',$branch)->update([
                'amount'=>abs($interest*-1+$loan*-1),
                'total'=>abs($interest*-1+$loan*-1),
                'narration'=>$memberid->client.' -Loan Repayment',
                'ttype'=>'D',
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                'bracid'=>auth()->user()->branchid,
            ]);
          
             //inserting into loan account
               // Inserting into  cash account 
               accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->accountcode)->where('bracid','=',$branch)->update([
                'amount'=>abs($loan*-1),
                'total'=>abs($loan*-1)*-1,
                'narration'=>$memberid->client.' -Loan Repayment',
                'ttype'=>'C',
                'transdate'=>date("Y-m-d", strtotime($request['date'])),
                'bracid'=>auth()->user()->branchid,
            ]);

                        // Dammy Account 
                        accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=','122')->where('bracid','=',$branch)->update([
                            'amount'=>'',
                            'total'=>'',
                            'narration'=>'',
                            'ttype'=>'',
                            'transdate'=>'',
                            'bracid'=>auth()->user()->branchid,
            
                        ]);
            

        }
              // Updateing surcharge
      if(str_replace( ',', '',$request['surcharge'])>0){
        accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',21)->where('cat','=','surcharge')->where('bracid','=',$branch)->update([
            'amount'=>str_replace( ',', '',$request['surcharge']),
            'total'=>str_replace( ',', '',$request['surcharge']),
            'narration'=>$memberid->client.' -Surcharge Payments',
            'ttype'=>'D',
            'transdate'=>date("Y-m-d", strtotime($request['date'])),
            'bracid'=>auth()->user()->branchid,
        ]);
        accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',128)->where('bracid','=',$branch)->update([
            'amount'=>str_replace( ',', '',$request['surcharge']),
            'total'=>str_replace( ',', '',$request['surcharge']),
            'narration'=>$memberid->client.' -Surcharge Payments',
            'ttype'=>'C',
            'transdate'=>date("Y-m-d", strtotime($request['date'])),
            'bracid'=>auth()->user()->branchid,
        ]);
      }else{
          // if nothing Empty
          accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',21)->where('cat','=','surcharge')->where('bracid','=',$branch)->update([
            'amount'=>'',
            'total'=>'',
            'narration'=>$memberid->client.' ',
            'ttype'=>'D',
            'transdate'=>date("Y-m-d", strtotime($request['date'])),
            'bracid'=>auth()->user()->branchid,
        ]);
        accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',128)->where('bracid','=',$branch)->update([
            'amount'=>'',
            'total'=>'',
            'narration'=>$memberid->client.' -',
            'ttype'=>'C',
            'transdate'=>date("Y-m-d", strtotime($request['date'])),
            'bracid'=>auth()->user()->branchid,
        ]);
      }
    }else{
        //If nothing delete everthing
        loantrans::where('headerid','=',$headerid)->where('branchno','=',$branch)->update([
            'memid'=>$memberid->clientid,
            'loan'=>0,
            'loancredit'=>0,
            'interestcredit'=>0,
            'date'=>date("Y-m-d", strtotime($request['date'])),
            'paydet'=>$request['paymentdetails'],
            'isActive'=>1,
            //'narration'=>$memberid->client.' -Loan Repayment',
            'surcharge'=>$newsurcharge,

        ]);
        $objallsavings->loanpdt1=0;
        $objallsavings->loanint1=0;
        $objallsavings->narration="surcharge payment";
    }
  ########################################################### SURCHARGE ##############################
if(str_replace( ',', '',$request['surcharge'])>0){
    if(str_replace(',','',$request['amount'])<1){
        loantrans::where('headerid','=',$headerid)->where('branchno','=',$branch)->update([
            'memid'=>$memberid->clientid,
            'loan'=>0,
            'loancredit'=>0,
            'date'=>date("Y-m-d", strtotime($request['date'])),
            'paydet'=>$request['paymentdetails'],
            'isActive'=>1,
            'narration'=>$memberid->client.' -Surcharge Payment',
            'surcharge'=>str_replace( ',', '',$request['surcharge']),

        ]);
        // Deleting empty 
        accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->disbursingac)->whereNull('cat')->where('bracid','=',$branch)->update([
            'amount'=>'',
            'total'=>'',
            'narration'=>$memberid->client." -Loan Repayment",
            'ttype'=>'D',
            'transdate'=>date("Y-m-d", strtotime($request['date'])),
            'bracid'=>auth()->user()->branchid,
        ]);
                                        //inserting into loan account
                                          // Inserting into  cash account 
        accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',$loanpdts->accountcode)->where('bracid','=',$branch)->update([
            'amount'=>'',
            'total'=>'',
            'narration'=>$memberid->client." -Loan Repayment",
            'ttype'=>'C',
            'transdate'=>date("Y-m-d", strtotime($request['date'])),
            'bracid'=>auth()->user()->branchid,
        ]);
                                          //$objaccountrans->save();
                           
 ######################## Dammy Account for Editing #############################################

        accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',122)->where('bracid','=',$branch)->update([
            'amount'=>'',
            'total'=>'',
            'narration'=>$memberid->client." -Surcharge Payment",
            'ttype'=>'C',
            'transdate'=>date("Y-m-d", strtotime($request['date'])),
            'bracid'=>auth()->user()->branchid,
        ]);
    }

// Inserting into Surcharge Recievables 
accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',128)->where('bracid','=',$branch)->update([
    'amount'=>str_replace( ',', '',$request['surcharge']),
    'total'=>str_replace( ',', '',$request['surcharge'])*-1,
    'narration'=>$memberid->client." -Surcharge Payment",
    'ttype'=>'C',
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    'bracid'=>auth()->user()->branchid,
]);
// Inserting into Surcharge Cash at Hand 
accounttrans::where('purchaseheaderid','=',$headerid)->where('accountcode','=',21)->where('cat','=','surcharge')->where('bracid','=',$branch)->update([
    'amount'=>str_replace( ',', '',$request['surcharge']),
    'total'=>str_replace( ',', '',$request['surcharge'])*-1,
    'narration'=>$memberid->client." -Surcharge Payment",
    'ttype'=>'D',
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    'bracid'=>auth()->user()->branchid,
]);
$objaccountrans5=new accounttrans;
//$objaccountrans5->purchaseheaderid=$objpurchaseheaders->id;


}
$objallsavings->surcharge=$newsurcharge*-1;
$objallsavings->save();

    }


}catch(\Exception $e){
    echo "Failed ".$e;
    DB::rollback();
}
DB::commit();
}
 public function destroy(Request $request, $headerid,$delloan,$isdelsec,$idloan){
     DB::beginTransaction();
     try{
     $user=auth()->user()->name;
   // Deleting from interest
    DB::delete("delete from purchaseheaders where id='$headerid'");
    DB::delete("delete from accounttrans where purchaseheaderid='$headerid'");
    DB::delete("delete from loantrans where headerid='$headerid'");
    DB::delete("delete from allsavings where headerid='$headerid'");
   
     }catch(\Exception $e){
         echo "Failed ".$e;
         DB::rollback();

     }
     DB::commit();
  
  



    }

public function viewcombo(){


    return companynames::all();
}

public function loanrepayments($where){
    $results=array();
    $bra=auth()->user()->branchid;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select COUNT(*) as count  from loantrans inner join customers on loantrans.memid=customers.id   where isRepayment=1 and loantrans.isActive=1 and branchno=$bra $where ");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select format(abs(loancredit),0) as amount, format(surcharge,0)as surcharge,loantrans.id as lnid,loantrans.loanid as idloan,DATE_FORMAT(date,'%d-%m-%Y') as date,memid,loanid,customers.name,paydet,narration,format(abs(loan),0) as loan,format(abs(interestcredit),0) as interestcredit,format(abs(loancredit)+surcharge,0) as loancredit,headerid from loantrans inner join customers on loantrans.memid=customers.id   where isRepayment=1 and loantrans.isActive=1 and branchno=$bra $where  limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
        //Showing The footer and totals 
   $footer =  DB::getPdo()->prepare("select format(sum(surcharge),0) as surcharge, format(sum(abs(loan)),0) as loan,format(sum(abs(interestcredit)),0) as interestcredit,format(sum(abs(loancredit)+surcharge),0) as loancredit from loantrans inner join customers on loantrans.memid=customers.id   where isRepayment=1 and loantrans.isActive=1 and branchno=$bra $where ");
   $footer->execute();
   $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
   $results['footer']=$foots;
   echo json_encode($results);
}


public function getInterestRBal($loanId,$interestBal,$creditinterest,$loanBa){
    $loandet2=DB::select("select intrunbal,loanrunbal from loanrepayments inner join loaninfos  on loanrepayments.loanid=loaninfos.id where loanid=$loanId  order by loanrepayments.id ");
    foreach($loandet2 as $loandet){
       // return $loandet->intrunbal. "the last";

        if($interestBal==$loandet->intrunbal&& $loandet->loanrunbal!=$loanBa ){ //&& $loandet->intrunbal>$interestBal

            return true;
            break; 
           // }
           }
           if($interestBal!=$loandet->intrunbal && $loandet->intrunbal>$interestBal){
               return ($loandet->intrunbal-$interestBal);
           }

}
}
public function getLoanRBal($loanId,$loanBal){
    $loandet2=DB::select("select intrunbal,loanrunbal from loanrepayments inner join loaninfos  on loanrepayments.loanid=loaninfos.id where loanid=$loanId  order by loanrepayments.id ");
    foreach($loandet2 as $loandet){
        if($loanBal==$loandet->loanrunbal){ //&& $loandet->intrunbal>$interestBal
            return $loandet->loanrunbal;
            break; 
           }
           if($loanBal!=$loandet->loanrunbal && $loandet->loanrunbal>$loanBal){
               return ($loandet->loanrunbal);
           }
}
}
public function getintRBal($loanId,$loanBal){
    $loandet2=DB::select("select intrunbal,loanrunbal from loanrepayments inner join loaninfos  on loanrepayments.loanid=loaninfos.id where loanid=$loanId  order by loanrepayments.id ");
    foreach($loandet2 as $loandet){
        if($loanBal==$loandet->intrunbal){ //&& $loandet->intrunbal>$interestBal
            return $loandet->intrunbal;
            break; 
           }
           if($loanBal!=$loandet->intrunbal && $loandet->intrunbal>$loanBal){
               return ($loandet->intrunbal);
           }
}
}
public function getPosition($loanbal,$loanrun,$loanid,$type){
   if($type=="loan"){
    if($loanbal==$loanrun){
        return ($this->getLoanRBal($loanid,$loanbal)+1);
    }else{
        return $this->getLoanRBal($loanid,$loanbal);
    }
} if ($type=="interest"){
    if($loanbal==$loanrun){
        return ($this->getintRBal($loanid,$loanbal)+1);
    }else{
        return $this->getintRBal($loanid,$loanbal);
    }  
}
}
 }