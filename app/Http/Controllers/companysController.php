<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\companys;
use App\users;
use App\chartofaccounts;
use App\savingdefinations;
use App\retainedearnings;
use App\purchaseheaders;
use App\accounttrans;
use App\loanproducts;
use App\savingsproducts;
use App\loanfees;

 class companysController extends Controller{

public function index(){
    return view('companys/index');
}
public function view(){
    $bra=auth()->user()->branchid;
    if($bra==1){
        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $bra=auth()->user()->branchid;
        $krows = DB::select("select COUNT(*) as count from companys where id!=1 ");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from companys where id!=1  limit $offset,$rows");
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
        $bra=auth()->user()->branchid;
        $krows = DB::select("select COUNT(*) as count from companys where id=$bra ");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from companys where id=$bra limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);
    }


    
}
public function save(Request $request){

DB::beginTransaction();
try{

$Objcompanys=new companys();
$Objcompanys->name=$request['name'];
$Objcompanys->location=$request['location'];
$Objcompanys->boxno=$request['boxnumber'];
$Objcompanys->phone=$request['phone'];
$Objcompanys->email=$request['email'];
$Objcompanys->logo="PA.png";
$Objcompanys->save();

$chart= new chartofaccounts();
$chart->accountcode="21";
$chart->accountname="Cash at Hand";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="21";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save(); 

$chart= new chartofaccounts();
$chart->accountcode="7100";
$chart->accountname="Capital";
$chart->accounttype=5;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="7100";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

########## MEMBERSHIP FEES ###############
$chart= new chartofaccounts();
$chart->accountcode="604";
$chart->accountname="Membership Fees";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="604";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
#####################

########## ANNUAL SUB  ###############
$chart= new chartofaccounts();
$chart->accountcode="603";
$chart->accountname="Annual Subscription";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="603";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
#####################

$chart= new chartofaccounts();
$chart->accountcode="31";
$chart->accountname="Petty Cash";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="31";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Savings Interest Expense 
$chart= new chartofaccounts();
$chart->accountcode="701";
$chart->accountname="Savings Interest Expenses";
$chart->accounttype=7;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="701";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
// Savings Interest Liablity
$chart= new chartofaccounts();
$chart->accountcode="404";
$chart->accountname="Savings Interest Payable";
$chart->accounttype=3;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="404";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

$chart= new chartofaccounts();
$chart->accountcode="600";
$chart->accountname="Loan Interest Income";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=6;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="600";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Insurance Recievalbe
$chart= new chartofaccounts();
$chart->accountcode="199";
$chart->accountname="Loan Insurance Receivable";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=6;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="199";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Loan Insurance income
$chart= new chartofaccounts();
$chart->accountcode="621";
$chart->accountname="Loan Insurance Income";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=6;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="621";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();


$chart= new chartofaccounts();
$chart->accountcode="122";
$chart->accountname="Loan Interest Recievable";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="122";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

$chart= new chartofaccounts();
$chart->accountcode="602";
$chart->accountname="Withdraw Fees";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="602";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

$chart= new chartofaccounts();
$chart->accountcode="301";
$chart->accountname="Shares";
$chart->accounttype=5;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="301";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
// Retained Earning
$chart= new chartofaccounts();
$chart->accountcode="308";
$chart->accountname="Retained Earning";
$chart->accounttype=5;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// Fixed Deposits
$chart= new chartofaccounts();
$chart->accountcode="401";
$chart->accountname="Fixed Deposits";
$chart->accounttype=3;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="401";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Loans
$chart= new chartofaccounts();
$chart->accountcode="121";
$chart->accountname="Loans";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="121";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Loan Application fees
$chart= new chartofaccounts();
$chart->accountcode="619";
$chart->accountname="Loan Application fees";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="619";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

//compuslory savings
$chart= new chartofaccounts();
$chart->accountcode="400";
$chart->accountname="Compulsory Savings";
$chart->accounttype=3;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="400";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

//Surcharge income 
$chart= new chartofaccounts();
$chart->accountcode="617";
$chart->accountname="Surcharge Income";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="617";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Surcharge income Recivable 
$chart= new chartofaccounts();
$chart->accountcode="128";
$chart->accountname="Surcharge Income Recievable";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="128";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Posting passbooks fees
$chart= new chartofaccounts();
$chart->accountcode="620";
$chart->accountname="PassBook Fees";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// Posting passbooks fees
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="620";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
//Definations
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Share Amt";
$Objdefinations->interest="Interest"; 
$Objdefinations->savingpdt="shares";
$Objdefinations->operatingac="21";
$Objdefinations->savingac="301";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
//compulsory savings
$Objdefinations->save();
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Compulsory Savings";
$Objdefinations->interest="Interest"; 
$Objdefinations->savingpdt="savingpdt1";
$Objdefinations->intpdt="intpdt1";
$Objdefinations->savingac="400";
$Objdefinations->operatingac="21";
$Objdefinations->isActive=1;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
$Objdefinations->save();
// Fixed deposits
$Objdefinations->save();
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Fixed Deposits";
$Objdefinations->interest="Interest"; 
$Objdefinations->savingpdt="savingpdt5";
$Objdefinations->intpdt="intpdt5";
$Objdefinations->savingac="401";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
$Objdefinations->save();
// Annual Subscription
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Annual Sub";
$Objdefinations->interest=""; 
$Objdefinations->savingpdt="ansub";
$Objdefinations->savingac="603";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
$Objdefinations->save();
// Membership fees
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Membership";
$Objdefinations->interest=""; 
$Objdefinations->savingpdt="memship";
$Objdefinations->savingac="604";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
$Objdefinations->save();
// Retained 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->inter="2";
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="308";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
// loans
$objloanpdt= new loanproducts();
$objloanpdt->name="Loans";
$objloanpdt->accountcode='121';
$objloanpdt->disbursingac='21';
$objloanpdt->loanpdt='loanpdt1';
$objloanpdt->intpdt='loanint1';
$objloanpdt->interest=5;
$objloanpdt->branchno=$Objcompanys->id;
$objloanpdt->isActive=1;
$objloanpdt->save();
$objsavingpdt= new savingsproducts();
$objsavingpdt->name="Compulsory Savings";
$objsavingpdt->accountcode=400;
$objsavingpdt->minbal=0;
$objsavingpdt->interest=0;
$objsavingpdt->charge=0;
$objsavingpdt->isActive=1;
$objsavingpdt->branchno=$Objcompanys->id;
$objsavingpdt->save();

// Loan Processing Fees
$objloanfees=new loanfees;
$objloanfees->name="Loan Application Fees";
$objloanfees->code=619;
$objloanfees->amount=2000;
$objloanfees->savingac=400;
$objloanfees->feevar="loanfee1";
$objloanfees->branchno=$Objcompanys->id;
$objloanfees->isActive=1;
$objloanfees->save();
}catch(\Exception $e){
    DB::rollBack();
    echo "Failed ".$e;
}
DB::commit();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objcompanys=companys::find($id);
        $file=$request->file('logo');
        $destinationPath="images";
        if($file!=Null){
            $filename=$file->getClientOriginalName();
            //moving it to the folder
            $file->move($destinationPath,$filename);
            $Objcompanys->logo=$filename;
    
        }
//$Objcompanys->id=$request['id'];
$Objcompanys->name=$request['name'];
$Objcompanys->location=$request['location'];
$Objcompanys->boxno=$request['boxno'];
$Objcompanys->phone=$request['phone'];
$Objcompanys->email=$request['email'];
$Objcompanys->created_at=$request['created_at'];
$Objcompanys->updated_at=$request['updated_at'];
$Objcompanys->save();
}
 public function destroy($id){
     DB::beginTransaction();
     try{

        $Objcompanys=companys::find($id);
        $Objcompanys->delete();
        chartofaccounts::where('branchno','=',$id)->delete();
        savingdefinations::where('branchno','=',$id)->delete();
        retainedearnings::where('branchid','=',$id)->delete();
        accounttrans::where('bracid','=',$id)->delete();
        loanproducts::where('branchno','=',$id)->delete();
        savingsproducts::where('branchno','=',$id)->delete();
        users::where('branchid','=',$id)->delete();


     }catch(\Exception $e){
         echo "Failed ".$e;
         DB::rollBack();
     }
     DB::commit();



    }

public function viewcombo(){


   // return companys::where('id','!=',1)->get();
return DB::select("select * from companys");
}

public function createcompany(Request $request){
    $validator=\Validator::make($request->all(),[
        'name'=>'required',
        'location'=>'required',
        'phone'=>'required',
        'email'=>'required',
        'phone'=>'required'
    ]);
    if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $this->validate($request, [
        
        'email'   => 'required|email',
        
       // 'password'  => 'min:6|required_with:password_confirmation|same:confirm',
        'password' => 'required|confirmed|min:6'
       ]);
       DB::beginTransaction();
       try{

$Objcompanys=new companys();
$Objcompanys->name=$request['name'];
$Objcompanys->location=$request['location'];
$Objcompanys->boxno=$request['boxnumber'];
$Objcompanys->phone=$request['phone'];
$Objcompanys->email=$request['email'];
$Objcompanys->save();

$objusers= new users();
$objusers->name=$request['contactname'];
$objusers->email=$request['email'];
$objusers->password=bcrypt($request->password);
$objusers->branchid=$Objcompanys->id;
$objusers->branchname=$request['name'];
$objusers->admin=1;
$objusers->save();

$chart= new chartofaccounts();
$chart->accountcode="21";
$chart->accountname="Cash at Hand";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="21";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save(); 

$chart= new chartofaccounts();
$chart->accountcode="7100";
$chart->accountname="Capital";
$chart->accounttype=5;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="7100";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

########## MEMBERSHIP FEES ###############
$chart= new chartofaccounts();
$chart->accountcode="604";
$chart->accountname="Membership Fees";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="604";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
#####################

########## ANNUAL SUB  ###############
$chart= new chartofaccounts();
$chart->accountcode="603";
$chart->accountname="Annual Subscription";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="603";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
#####################

$chart= new chartofaccounts();
$chart->accountcode="3700";
$chart->accountname="Petty Cash";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="3700";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

// Savings Interest Expense 
$chart= new chartofaccounts();
$chart->accountcode="701";
$chart->accountname="Savings Interest Expenses";
$chart->accounttype=7;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="701";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
// Savings Interest Liablity
$chart= new chartofaccounts();
$chart->accountcode="4300";
$chart->accountname="Savings Interest Payable";
$chart->accounttype=3;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="4300";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

$chart= new chartofaccounts();
$chart->accountcode="4000";
$chart->accountname="Loan Interest Income";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=6;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="4000";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

$chart= new chartofaccounts();
$chart->accountcode="5000";
$chart->accountname="Loan Interest Recievable";
$chart->accounttype=1;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="5000";
$account->ttype="D";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

$chart= new chartofaccounts();
$chart->accountcode="6003";
$chart->accountname="Withdraw Fees";
$chart->accounttype=6;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save(); 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="6003";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

$chart= new chartofaccounts();
$chart->accountcode="7000";
$chart->accountname="Shares";
$chart->accounttype=5;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="7000";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();
// Retained Earning
$chart= new chartofaccounts();
$chart->accountcode="9000";
$chart->accountname="Retained Earning";
$chart->accounttype=5;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// Fixed Deposits
$chart= new chartofaccounts();
$chart->accountcode="8000";
$chart->accountname="Fixed Deposits";
$chart->accounttype=3;
$chart->branchno=$Objcompanys->id;
$chart->isActive=1;
$chart->save();
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="8000";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();

//Definations
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Share Amt";
$Objdefinations->interest="Interest"; 
$Objdefinations->savingpdt="shares";
$Objdefinations->operatingac="21";
$Objdefinations->savingac="7000";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
// Fixed deposits
$Objdefinations->save();
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Fixed Deposits";
$Objdefinations->interest="Interest"; 
$Objdefinations->savingpdt="savingpdt5";
$Objdefinations->intpdt="intpdt5";
$Objdefinations->savingac="8000";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
$Objdefinations->save();
// Annual Subscription
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Annual Sub";
$Objdefinations->interest=""; 
$Objdefinations->savingpdt="ansub";
$Objdefinations->savingac="603";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
$Objdefinations->save();
// Membership fees
$Objdefinations= new savingdefinations();
$Objdefinations->productname="Membership";
$Objdefinations->interest=""; 
$Objdefinations->savingpdt="memship";
$Objdefinations->savingac="604";
$Objdefinations->isActive=0;
$Objdefinations->intActive=0;
$Objdefinations->branchno=$Objcompanys->id;
$Objdefinations->save();
// Retained 
// posting to purchase headers;
$objpurchase= new purchaseheaders();
$objpurchase->inter="2";
$objpurchase->branch_id=$Objcompanys->id;
$objpurchase->save();
$account= new accounttrans();
$account->accountcode="9000";
$account->ttype="C";
$account->purchaseheaderid=$objpurchase->id;
$account->bracid=$Objcompanys->id;
$account->cat="isFirst";
$account->save();




       }catch(\Exception $e){
           DB::rollBack();
           echo "Failed ".$e;
       }
       DB::commit();
       return redirect('login')->with('status', 'Company Created Successfully, Please Login !!!');
}
}
