<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\groups;
use App\groupmembers;
use App\purchaseheaders;
use App\accounttrans;
use App\loanproducts;
use App\loaninfo;
use App\loanschedules;
use App\allsavings;
use App\savings;
use App\loanfees;
use App\regmembers;
use App\grouppenaltys;
 class groupsController extends Controller{

public function index(){
    return view('groups/index');
}
public function view(){
    if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['branch'])){
        $bra=$_GET['branch'];
        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select COUNT(*) as count from (select  groups.*,sum(surcharge) as total from groups inner join groupmembers on groupmembers.groupid=groups.id left outer join allsavings on allsavings.client_no=groupmembers.memberid where branchid=$bra group by groups.id order by name asc ) t ");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select groups.*,sum(surcharge) as total from groups inner join groupmembers on groupmembers.groupid=groups.id left outer join allsavings on allsavings.client_no=groupmembers.memberid where branchid=$bra group by groups.id order by name asc limit $offset,$rows");
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
        $krows = DB::select("select COUNT(*) as count from (select  groups.*,sum(surcharge) as total from groups inner join groupmembers on groupmembers.groupid=groups.id left outer join allsavings on allsavings.client_no=groupmembers.memberid where branchid=$bra group by groups.id order by name asc ) t ");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select groups.*,sum(surcharge) as total from groups inner join groupmembers on groupmembers.groupid=groups.id left outer join allsavings on allsavings.client_no=groupmembers.memberid where branchid=$bra group by groups.id order by name asc limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);  
    }
    
}
public function save(Request $request){
    DB::beginTransaction();
    try{
    $Objgroups=new groups();
$Objgroups->id=$request['id'];
$Objgroups->name=$request['name'];
$Objgroups->leader=$request['leader'];
$Objgroups->memberid=$request['memberid'];
$Objgroups->collector=$this->getNames($request['memberid']);
$Objgroups->created_at=$request['created_at'];
$Objgroups->updated_at=$request['updated_at'];
$Objgroups->branchid=auth()->user()->branchid==1?$request['branch']:auth()->user()->branchid;;
$result=$Objgroups->save();


//saving to group members
 if($this->saveGrpMembers($request['memberid'],$Objgroups->id)){
return ['result'=>'exits'];
 }else{
     DB::commit();
 }
//return ['result'=>$result];
    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();
    }
   

}
//Auto generated code for updating
public function update(Request $request,$id){
    DB::beginTransaction();
    try{
        $Objgroups=groups::find($id);

//$Objgroups->id=$request['id'];
$Objgroups->name=$request['name'];
$Objgroups->leader=$request['leader'];
$Objgroups->memberid=$request['memberid'];
$Objgroups->collector=$this->getNames($request['memberid']);
$Objgroups->created_at=$request['created_at'];
$Objgroups->updated_at=$request['updated_at'];
$Objgroups->branchid=auth()->user()->branchid==1?$request['branch']:auth()->user()->branchid;;;
$Objgroups->save();
DB::delete("delete from groupmembers where groupid=$Objgroups->id");

//saving to group members
$this->saveGrpMembers($request['memberid'],$Objgroups->id);
    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();
    }
    DB::commit();
}
 public function destroy($id){
     DB::beginTransaction();
     try{
        $Objgroups=groups::find($id);
        groupmembers::where('groupid','=',$Objgroups->id)->delete();
        $Objgroups->delete();

     }catch(\Exception $e){
         echo "Failed ".$e;
         DB::rollBack();

     }
     DB::commit();



    }

public function viewcombo(){
    $bra=auth()->user()->branchid;

    return groups::where('branchid','=',$bra)->get();
}
public function groupbranches($id){

}
public function getNames($memid){
    $name='';
    $arr = explode (",", str_replace("'", "", $memid));
foreach ($arr as $elem) 
   $array[] = trim($elem) ;
   foreach($array as $s){
    $customers=DB::select("select name from customers where id=$s");
    foreach($customers as $cust){
        $name.=$cust->name.", ";
    }
   }
   return $name;
}
public function saveGrpMembers($memid,$groupid){
    $arr = explode (",", str_replace("'", "", $memid));

foreach ($arr as $elem) 
   $array[] = trim($elem) ;
   foreach($array as $s){
    $results=DB::select("select * from groupmembers where memberid=$s");
    if(count($results)>0){
return true;
    }else{
        $Objgroup= new groupmembers();
        $Objgroup->groupid=$groupid;
        $Objgroup->memberid=$s;
        $Objgroup->save();
    }


   }
  
}
public function viewgroup($id){
    $details=DB::select("select * from groups where id=$id");
    return  view('groupviews/index')->with('id',$id)->with('details',$details);
}
public function viewmembers($id){
    //return $id;
 // return  DB::select("select  if(sum(interestcredit) is Null,0,format(sum(interestcredit),0)) as interestcredit, if(sum(loan) is null,0,format(sum(loan),0)) as loan,if(sum(loancredit) is null,0,format(sum(loancredit),0)) as loancredit, customers.name,groups.name as gname,occupation,telephone1 from customers inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid left outer join  loantrans on loantrans.memid=customers.id where groups.id=$id group by customers.id");
 $results=array();
 $branch=auth()->user()->branchid;
 $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
 $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
 $offset = ($page-1)*$rows;
 $rs =DB::getPdo();
 $bra=auth()->user()->branchid;
 $admin=auth()->user()->isAdmin;
// if($admin==0){
 $krows = DB::select("select COUNT(*) as count from customers inner join loaninfos on loaninfos.memeberid=customers.id  inner join loanproducts on loanproducts.id=loaninfos.loancat inner join interestmethods on interestmethods.id=loaninfos.intmethod inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid where isApprove=0 and groups.branchid=$branch");
 $results["total"]=$krows[0]->count;
 
 $sth =  DB::getPdo()->prepare("select bustype,tel,customers.id as memno, format(sum(surcharge),2) as surcharge, if(sum(interestcredit) is Null,0,format(sum(interestcredit),2)) as interestcredit, if(sum(loan) is null,0,format(sum(loan-surcharge),2)) as loan,if(sum(loancredit) is null,0,format(sum(loancredit),2)) as loancredit, customers.name,groups.name as gname from customers inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid left outer join  loantrans on loantrans.memid=customers.id where groups.id=$id group by customers.id limit $offset,$rows");
 $sth->execute();
    $dogs = $sth->fetchAll(\PDO::FETCH_OBJ);
 $results["rows"]=$dogs;

              //Showing The footer and totals 
//$footer =  DB::getPdo()->prepare("select format(sum(loancredit),0) as loancredit  from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join loantrans on loantrans.loanid=loaninfos.id inner join users on users.branchid=customers.branchnumber  where   isLoan=1 and isDisbursement=1 and loantrans.isActive=1 AND loantrans.branchno=$branch $where limit $offset,$rows");
$footer =  DB::getPdo()->prepare("select format(sum(surcharge),2) as surcharge, if(sum(interestcredit) is Null,0,format(sum(interestcredit),2)) as interestcredit, if(sum(loan) is null,0,format(sum(loan-surcharge),2)) as loan,if(sum(loancredit) is null,0,format(sum(loancredit),2)) as loancredit from customers inner join groupmembers on groupmembers.memberid=customers.id inner join groups on groups.id=groupmembers.groupid left outer join  loantrans on loantrans.memid=customers.id where groups.id=$id");
$footer->execute();
$foots=$footer->fetchAll(\PDO::FETCH_OBJ);
$results['footer']=$foots;
echo json_encode($results);
}
public function applicationdetails($id){
//$loaninfos=DB::select("select *,maritals.name as mstatus,customers.name as name,format(amount,0) as amount,DATE_FORMAT(dob,'%d-%m-%Y') dob from customers inner join loaninfos on loaninfos.memeberid=customers.id left outer join maritals on maritals.id=customers.marital where loaninfos.id=$id");
$loaninfos=DB::select("select *,loaninfos.id as id,groups.name as gname,maritals.name as mstatus,customers.name as name,format(amount,0) as amount from customers inner join loaninfos on loaninfos.memeberid=customers.id left outer join maritals on maritals.id=customers.marital inner join groupmembers on  customers.id=groupmembers.memberid inner join groups on groups.id=groupmembers.groupid where loaninfos.id=$id");
    return view('applicationdetails/index')->with('details',$loaninfos);
}
public function loandetails($id){
    $proof=DB::select("select * from loaninfos where appid =$id");
    //$loaninfos=DB::select("select *,maritals.name as mstatus,customers.name as name,format(amount,0) as amount,DATE_FORMAT(dob,'%d-%m-%Y') dob from customers inner join loaninfos on loaninfos.memeberid=customers.id left outer join maritals on maritals.id=customers.marital where loaninfos.id=$id");
    $loaninfos=DB::select("select *,loaninfos.id as id,groups.name as gname,maritals.name as mstatus,customers.name as name,format(amount,0) as amount from customers inner join loaninfos on loaninfos.memeberid=customers.id left outer join maritals on maritals.id=customers.marital inner join groupmembers on  customers.id=groupmembers.memberid inner join groups on groups.id=groupmembers.groupid where loaninfos.id=$id");
        return view('loandetails/index')->with('details',$loaninfos)->with('proof',$proof);
    }
public function applicationlist($id){
    $officeid=auth()->user()->id;
    $officername=auth()->user()->name;
    $loaninfos=DB::select("select *,loaninfos.id as id,groups.name as gname,maritals.name as mstatus,customers.name as name,format(amount,0) as amount from customers inner join loaninfos on loaninfos.memeberid=customers.id left outer join maritals on maritals.id=customers.marital inner join groupmembers on  customers.id=groupmembers.memberid inner join groups on groups.id=groupmembers.groupid where loaninfos.id=$id");
        return view('applicationlist/index')->with('details',$loaninfos)->with('officername',$officername)->with('officeid',$officeid);
    }
public function applicationlistfinal($id){
    
    $officeid=auth()->user()->id;
    $officername=auth()->user()->name;
        $loaninfos=DB::select("select *,loaninfos.id as id,groups.name as gname,maritals.name as mstatus,customers.name as name,format(approveamt,0) as amount from customers inner join loaninfos on loaninfos.memeberid=customers.id left outer join maritals on maritals.id=customers.marital inner join groupmembers on  customers.id=groupmembers.memberid inner join groups on groups.id=groupmembers.groupid where loaninfos.id=$id");
            return view('applicationlistfinal/index')->with('details',$loaninfos)->with('officername',$officername)->with('officeid',$officeid);
}
public function loanapproval(){
    return view('loanapproval/index');
}
public function finalloanapproval(){
    return view('finalloanapproval/index');
}
public function updateapprove(Request $request){
    DB::beginTransaction();
    try{
        echo $request['pid'];
    $amount=str_replace( ',', '',$request['loanamt']);
    DB::update("update loaninfos set rejectrsn='$request[reasonapproval]', approveamt=$amount,isApprove=2,approved1=$request[loanofficerid] where id=$request[pid] ");
    }catch(\Exception $e){
        echo "failed ".$e;
        DB::rollBack();
    }
DB::commit();
}
public function updateapprovefinal(Request $request){
    DB::beginTransaction();
    try{
        echo $request['pid'];
    $amount=str_replace( ',', '',$request['loanamt']);
    DB::update("update loaninfos set rejectrsn='$request[reasonapproval]', approveamt=$amount,isApprove=4,approved2=$request[loanofficerid] where id=$request[pid] ");
    }catch(\Exception $e){
        echo "failed ".$e;
        DB::rollBack();
    }
DB::commit();
}
public function updatereject(Request $request){
    DB::beginTransaction();
    try{
    $reason=$request['reason'];
    DB::update("update loaninfos set rejectrsn='$reason',isApprove=3,approved1=$request[loanofficerid],approveamt=0 where id=$request[pid] ");
    }catch(\Exception $e){
        echo "Failed to update ".$e;
        DB::rollBack();
    }
    DB::commit();
}
public function updaterejectfinal(Request $request){
    DB::beginTransaction();
    try{
    $reason=$request['reason'];
    DB::update("update loaninfos set rejectrsn='$reason',isApprove=3,approved2=$request[loanofficerid],approveamt=0 where id=$request[pid] ");
    }catch(\Exception $e){
        echo "Failed to update ".$e;
        DB::rollBack();
    }
    DB::commit();
}
public function customersapproved(){
    $bra=auth()->user()->branchid;
    return DB::select("select name,customers.id as id from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join passbooks on passbooks.memid=customers.id  where isApprove=4 and branchnumber=$bra group by passbooks.memid");
}
public function customersapprovedbra($id){
    $bra=$id;
    return DB::select("select name,customers.id as id from customers inner join loaninfos on loaninfos.memeberid=customers.id inner join passbooks on passbooks.memid=customers.id  where isApprove=4 and branchnumber=$bra group by passbooks.memid");
}
public function getApprovedAmt($id){
    return DB::select("select id as  appid, format(approveamt,0)approveamt,intmethod,mode,period,loanrepay,loaninterest from loaninfos where memeberid=$id and isApprove=4 order by appid asc limit 1");
}
public function saveloanapp(Request $request){
    DB::beginTransaction();
    
    try{
        
        $memberid=$request['name'];
        $funded=DB::select("select * from regmembers where id=$memberid and isActive=2");
       $pgmembers= DB::select("select * from groupmembers where memberid=$memberid");
       if(count($pgmembers)<1){
return ['member'=>'No'];
       }
   /*    else if(count($funded)>0){
return ['funded'=>'yes'];
       }    */
       else{
        $clientname="";
        $id=DB::select("select customers.name as client,sum(loan) as loan from loantrans inner join customers on loantrans.memid=customers.id where loantrans.isActive=1 and memid=$memberid");
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
            $branch=auth()->user()->branchid==1?$request['branch']:auth()->user()->branchid;
             
            // Inserting into Loaninfos 
            $objloaninfo= new loaninfo();
            $objloaninfo->loanrepay=$request['repay'];
            $objloaninfo->headno=$objheaders->id;
            $objloaninfo->period=$request['mode'];
            $objloaninfo->applicationdate=date("Y-m-d", strtotime($request['date']));
            $objloaninfo->loaninterest=$request['interest'];
            $objloaninfo->loanofficer=$request['loanofficer'];
            $objloaninfo->mode=$request['branch'];
            $objloaninfo->collateral=$request['security'];
            $objloaninfo->guanter=$request['purpose'];
            $objloaninfo->memeberid=$request['name'];
            $objloaninfo->collateral=$request['collateral'];
            $objloaninfo->intmethod=$request['method'];
            $objloaninfo->amount=str_replace( ',', '',$request['amount']);
            $objloaninfo->loancat=$request['loancat'];
            $objloaninfo->loanfee1=$request['loanfee1'];
            $objloaninfo->loanfee2=$request['loanfee2'];
            $objloaninfo->loanfee3=$request['loanfee3'];
            $objloaninfo->status=1;
            $objloaninfo->isApprove=0;
            $objloaninfo->loanappofficerid=$request['officerid'];
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
            $file=$request->file('agreement4');
            $destinationPath="images";
            if($file!=Null){
                $filename=$file->getClientOriginalName();
                //moving it to the folder
                $file->move($destinationPath,$filename);
                $objloaninfo->agreement4=$filename;
        
            }
            $file=$request->file('agreement5');
            $destinationPath="images";
            if($file!=Null){
                $filename=$file->getClientOriginalName();
                //moving it to the folder
                $file->move($destinationPath,$filename);
                $objloaninfo->agreement5=$filename;
        
            }
            $file=$request->file('agreement');
            $destinationPath="images";
            if($file!=Null){
                $filename=$file->getClientOriginalName();
                //moving it to the folder
                $file->move($destinationPath,$filename);
                $objloaninfo->agreement=$filename;
        
            }
            $file=$request->file('agreement2');
            $destinationPath="images";
            if($file!=Null){
                $filename=$file->getClientOriginalName();
                //moving it to the folder
                $file->move($destinationPath,$filename);
                $objloaninfo->agreement2=$filename;
        
            }
            $file=$request->file('agreement3');
            $destinationPath="images";
            if($file!=Null){
                $filename=$file->getClientOriginalName();
                //moving it to the folder
                $file->move($destinationPath,$filename);
                $objloaninfo->agreement3=$filename;
        
            }
            $file=$request->file('proof');
            $destinationPath="images";
            if($file!=Null){
                $filename=$file->getClientOriginalName();
                //moving it to the folder
                $file->move($destinationPath,$filename);
                $objloaninfo->proofofbiz=$filename;
        
            }
           
            $objloaninfo->save();

             ########################################## If no processing fees ###################################################
 $loanfees=loanfees::where('isActive','=',1)->where('branchno','=',$branch)->get();
 $loanaccounts=loanproducts::find($request['loancat']);
// echo $loanfees->count();
 if($loanfees->count()<1){

 }else{
     ###########################################  LOAN FEESS #########################
$resultfees=DB::select("select * from loanfees where branchno=$branch");
$resultz=DB::select("select * from loanfees where isSavings=1 and branchno=$branch");
if(count($resultz)>0){// if deduct from savings
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$objheaders->id;
$objaccountrans->amount=str_replace( ',', '',$request['amount']);
$objaccountrans->total=str_replace( ',', '',$request['amount'])*-1;
$objaccountrans->accountcode=$loanaccounts->disbursingac;
$objaccountrans->narration=$finalid->client." -Loan Disbursement- "."($loanaccounts->name)";
$objaccountrans->ttype="C";
$objaccountrans->transdate=date("Y-m-d", strtotime($request['date']));
$objaccountrans->bracid=auth()->user()->branchid==1?$request['branch']:auth()->user()->branchid;;
$objaccountrans->save();
// selecting loan fees
foreach($resultz as $rs){
    if($rs->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
        // Loan Fee1 
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee1']),str_replace( ',', '',$request['loanfee1']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])),$branch);
        // Savings Ac
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee1']),str_replace( ',', '',$request['loanfee1'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])),$branch);
    }
    if($rs->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
        // Loan Fee2 
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee2']),str_replace( ',', '',$request['loanfee2']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])),$branch);
        // Savings Ac
        $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee2']),str_replace( ',', '',$request['loanfee2'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])),$branch);
    }
    if($rs->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
                // Loan Fee1 
     $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee3']),str_replace( ',', '',$request['loanfee3']),$rs->code,$clientname."-".$rs->name,'C',date("Y-m-d", strtotime($request['date'])),$branch);
                // Savings Ac
     $this->isSavingDeduct($objheaders->id,str_replace( ',', '',$request['loanfee3']),str_replace( ',', '',$request['loanfee3'])*-1,$rs->savingac,$clientname."-".$rs->name,'D',date("Y-m-d", strtotime($request['date'])),$branch);
    }

}


}else{
$resultscount=DB::select("select  sum(if(isDeduct=1,isDeduct,0)) as Deductnew,sum(if(isDeduct=0,isDeduct,0)) as Nodeductnew from loanfees where branchno=$branch");
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
            $this->deductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee1",$branch);
        }
        if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
            if($fees->isDeduct==0){  
                $answer="No";   
            }else{
                $answer="Yes";
            }
            $this->deductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee2",$branch);
        }
        if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
            if($fees->isDeduct==0){  
                $answer="No";   
            }else{
                $answer="Yes";
            }
            $this->deductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,$answer,"loanfee3",$branch);
        }
        if($number==1){
            $this->cashaccount($request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount'])-$totalamount,date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct",$branch);
            }
            //echo "Both ";
}
    else if($fees->isDeduct==0){
        if($number==1){
        $this->cashaccount($request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct",$branch);
        }
        if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
            $this->deductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee1",$branch);
        }
        if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
            $this->deductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee2",$branch);
        }
        if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
            $this->deductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"No","loanfee3",$branch);
        }
       // echo "NOt Deducted";
    }else if($fees->isDeduct==1){
            if($fees->feevar=="loanfee1" && str_replace( ',', '',$request['loanfee1'])>0){
                $this->deductions(str_replace( ',', '',$request['loanfee1']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee1",$branch);
            }
            if($fees->feevar=="loanfee2" && str_replace( ',', '',$request['loanfee2'])>0){
                $this->deductions(str_replace( ',', '',$request['loanfee2']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee2",$branch);
            }
            if($fees->feevar=="loanfee3" && str_replace( ',', '',$request['loanfee3'])>0){
                $this->deductions(str_replace( ',', '',$request['loanfee3']),$request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount']),date("Y-m-d", strtotime($request['date'])),$clientname,$fees,"Yes","loanfee3",$branch);
            }
            if($number==1){
                $this->cashaccount($request['loancat'],$objheaders->id,str_replace( ',', '',$request['amount'])-$totalamount,date("Y-m-d", strtotime($request['date'])),$clientname,"Deduct",$branch);
                }
               // echo "Deducted";
    }

    $number=$number+1;
}
}
 }
    }
 }
}
        }catch(\Exception $e){
            echo "Failed ".$e;
            DB::rollBack();
        }
        
        DB::commit();
}

public function deductions($loanfees,$loancategory,$headerid,$amount,$rdate,$client,$fees,$isDeduct,$catidentify,$Brac){
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
    $objaccountrans->bracid=$Brac;
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
    $objaccountrans->bracid=$Brac;
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
    $objaccountrans->bracid=$Brac;
    $objaccountrans->save();    
    }
}
public function cashaccount($loancategory,$headerid,$amount,$rdate,$client,$cashaccount,$Brac){
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
   $objaccountrans->bracid=$Brac;
  // $objaccountrans->save();
    }
}
public function isSavingDeduct($headerid,$amount,$total,$accountcode,$narration,$ttype,$tdate,$Brac){
$objaccountrans=new accounttrans;
$objaccountrans->purchaseheaderid=$headerid;
$objaccountrans->amount=$amount;
$objaccountrans->total=$total;
$objaccountrans->accountcode=$accountcode;
$objaccountrans->narration=$narration;
$objaccountrans->ttype=$ttype;
$objaccountrans->transdate=$tdate;
$objaccountrans->bracid=$Brac;
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
public function delapplication(Request $request){
    DB::beginTransaction();
    try{
        if(auth()->user()->admin==5){
            return ['rights'=>'no'];
        }else{
$del=DB::select("select appid from loaninfos where appid=$request[id]");
if(count($del)>0){
    return ['del'=>'No'];
}else{
$objloaninfo=loaninfo::find($request['id']);
$del=$objloaninfo->headno;
DB::delete("delete from accounttrans where purchaseheaderid=$del");
DB::delete("delete from purchaseheaders where id=$del");
$objloaninfo->delete();

}
        }
    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();
    }
    DB::commit();
}
public function updateapp(Request $request,$id){
DB::beginTransaction();
try{
    if(auth()->user()->admin==5){
        return ['rights'=>'no'];
    }else{
$headerid=$request['headerno'];
    $memberid=$request['name'];
    $branch=auth()->user()->branchid==1?$request['branch']:auth()->user()->branchid;
  $data=DB::select("select customers.name as client from customers inner join loaninfos on loaninfos.memeberid=customers.id where memeberid=$memberid limit 1");
  foreach($data as $finalid){
    $clientname=$finalid->client; 
      
        // Inserting into Loaninfos 
        $objloaninfo=  loaninfo::find($id);
        //return $objloaninfo;
       $objloaninfo->loanrepay=$request['repay'];
        $objloaninfo->period=$request['mode'];
        $objloaninfo->applicationdate=date("Y-m-d", strtotime($request['date']));
        $objloaninfo->loaninterest=$request['interest'];
        $objloaninfo->mode=$request['branch'];
        $objloaninfo->collateral=$request['security'];
        $objloaninfo->guanter=$request['purpose'];
        $objloaninfo->memeberid=$request['name'];
        $objloaninfo->collateral=$request['collateral'];
        $objloaninfo->intmethod=$request['method'];
        $objloaninfo->amount=str_replace( ',', '',$request['amount']);
        $objloaninfo->loancat=$request['loancat'];
        $objloaninfo->loanfee1=str_replace( ',', '',$request['loanfee1']);
        $objloaninfo->loanfee2=$request['loanfee2'];
        $objloaninfo->loanfee3=$request['loanfee3'];
        $objloaninfo->status=1;
        $objloaninfo->isApprove=0; 
        $objloaninfo->loanofficer=$request['loanofficer'];
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
        $file=$request->file('agreement4');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->agreement4=$filename;
    
        }
        $file=$request->file('agreement5');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->agreement5=$filename;
    
        }
        $file=$request->file('agreement');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->agreement=$filename;
    
        }
        $file=$request->file('agreement2');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->agreement2=$filename;
    
        }
        $file=$request->file('agreement3');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->agreement3=$filename;
    
        }
        $file=$request->file('proof');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $objloaninfo->proofofbiz=$filename;
    
        }
       
        $objloaninfo->save();
        $loanfees=loanfees::where('isActive','=',1)->get();
        
$loanaccounts=loanproducts::find(1);

if($loanfees->count()>0){
// echo "denis";
 #####################    Accounts ##################################
// inserting into Loan Account
accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','D')->where('accountcode',
'=',$loanaccounts->disbursingac)->update(
     ['amount'=>str_replace( ',', '',$request['loanfee1']),
    'total'=>str_replace( ',', '',$request['loanfee1']),
    'narration'=>$finalid->client.'-Loan Application Fees',
    'transdate'=>date("Y-m-d", strtotime($request['date'])),   
    ]);
// Loan Processing Fees
$dara=loanfees::where('feevar','=','loanfee1')->where('branchno','=',$branch)->get();
foreach($dara as $d){
    accounttrans::where('purchaseheaderid','=',$headerid)->where('ttype','=','C')->where('accountcode',
    '=',$d->code)->update(
         ['amount'=>str_replace( ',', '',$request['loanfee1']),
        'total'=>str_replace( ',', '',$request['loanfee1']),
        'narration'=>$finalid->client.'-Loan Application Fees',
        'transdate'=>date("Y-m-d", strtotime($request['date'])),   
        ]);

}

    }
     
  }
    }
}catch(\Exception $e){
    echo "Failed ".$e;
    DB::rollBack();
}
DB::commit();
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
 public  function penalty(){
$groups=DB::select("select groupid from pen group by groupid");
foreach($groups as $groupz){
    $gid=$groupz->groupid;
    $grpmem=DB::select("select sum(penalty) as penz,groupid,scheduledate from pen where groupid=$gid order by loanid desc limit 5");

    foreach($grpmem as $mems){
        $newgid= $mems->groupid;
        // getting different total for diffrent groups 
        //geting payment made
       // echo $mems->penz;

    }
}

echo $this->currentPayment();
 }


 public function currentPayment(){
     DB::beginTransaction();
     try{
    $today=date('Y-m-d');
    $groups=DB::select("select groupid from pen group by groupid");
    foreach($groups as $groupz){
        $gid=$groupz->groupid;
        $grpmem=DB::select("select sum(penalty) as penz,groupid,count(groupid) as no ,scheduledate,expecteddate from pen where groupid=$gid order by loanid desc limit 5");
    
        foreach($grpmem as $mems){
            $newgid= $mems->groupid;
            // getting different total for diffrent groups 
            //geting payment mad
            if($mems->no==5){
            $payments=DB::select("select groupid,if(sum(abs(loancredit)) is null,0,sum(abs(loancredit))) loancredit,memid from loantrans inner join groupmembers on groupmembers.memberid=loantrans.memid where loancredit<0 and groupid=$newgid");
            foreach($payments as $pay){
                //echo $pay->loancredit;
                if($pay->loancredit<($mems->penz)*16){ //checking is loans are complete if not complete process
            if(strtotime($today)> strtotime($mems->expecteddate)){
                $days= (strtotime($today)-strtotime($mems->scheduledate))/86400;
                $newdays= ($days/7);
                echo "Total of what is paid ".($mems->penz)*16;
$newint= substr($newdays, 0, 2);
$news= str_replace( '.', '',$newint);

//echo $news;
// "The total ".$mems->penz*$news;
if($pay->loancredit<$news*$mems->penz){
    $objheaders= new purchaseheaders();
    $objheaders->transdates=date("Y-m-d", strtotime($today));
    $objheaders->isActive=1;
    $objheaders->save();
    //$branch=auth()->user()->branchid;
//calculating percentage for each person
$percentage=$mems->penz*0.1;
$groupmembers=DB::select("select memberid,branchnumber,customers.name as name from groupmembers inner join customers on customers.id=groupmembers.memberid where groupid=$newgid");
foreach($groupmembers as $members){
$objallsavings= new allsavings();
$objallsavings->date=date("Y-m-d", strtotime($today));
$objallsavings->client_no=$members->memberid;
$objallsavings->narration='Surcharge Computation';
$objallsavings->recieptno=date("Y-m-d", strtotime($today));
$objallsavings->branchno=$members->branchnumber;
$objallsavings->headerid=$objheaders->id;
$objallsavings->surcharge=$percentage;
$objallsavings->save();
// Inserting into Surcharge Recievables  
       $objaccountrans=new accounttrans;
       $objaccountrans->purchaseheaderid=$objheaders->id;
       $objaccountrans->amount=$percentage;
       $objaccountrans->accountcode=128;
       $objaccountrans->narration= $members->name."-Surcharge";
       $objaccountrans->ttype="D";
       $objaccountrans->total=$percentage;
       $objaccountrans->transdate=date("Y-m-d", strtotime($today));
       $objaccountrans->bracid=auth()->user()->branchid;
       $objaccountrans->save();
            // inserting into Surcharge Account 
              $objaccountrans=new accounttrans;
              $objaccountrans->purchaseheaderid=$objheaders->id;
              $objaccountrans->amount=$percentage;
              $objaccountrans->accountcode=617;
              $objaccountrans->narration= $members->name."-Surcharge";
              $objaccountrans->ttype="C";
              $objaccountrans->total=$percentage;
              $objaccountrans->transdate=date("Y-m-d", strtotime($today));
              $objaccountrans->bracid=auth()->user()->branchid;
              $objaccountrans->save();

}


}

//echo ($everything*$mems->penz)."<br>";
$newdate=date('Y-m-d',strtotime($mems->expecteddate ."+1 week"));
DB::update("update loanschedules set expecteddate='$newdate' where groupid=$newgid");
                }


            }else{
                //echo "No";


            }
        }
    
        }
    }
    }
}
 catch(\Exception $e){
echo "Failed to Save ".$e;
DB::rollBack();
 }
 DB::commit();
 }

 public function computepenalty(){

 }
 public function viewgroupind($id){
     
    return view("viewgroupind/index")->with('id',$id);
 }

 public function selectgroups(Request $request){

    echo $request['selected'];
 }

 public function approvedmember($id){

    return DB::select("select name,memeberid as id,branchnumber from loaninfos inner join customers on customers.id=loaninfos.memeberid where isApprove=1 and branchnumber=$id group by memeberid");
 }
}
