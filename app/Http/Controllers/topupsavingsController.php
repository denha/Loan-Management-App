<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\topupsavings;
use App\allsavings;
use App\accounttrans;

 class topupsavingsController extends Controller{

public function post(){
    DB::beginTransaction();
    try{
    $loan_results= DB::select("select * from loantrans where isDisbursement =1 and narration ='Loan Disbursement'");
    foreach($loan_results as $loan){

        $Objtopupsavings = new topupsavings();
        $Objtopupsavings->headerid= $loan->headerid;
        $Objtopupsavings->loanid = $loan->loanid;
        $Objtopupsavings->intialSavings= ($loan->loancredit*0.2);
        $Objtopupsavings->save();
        

    }
    $savings=DB::select("select allsavings.branchno as bra, allsavings.date as date,name,isFunded, allsavings.id as id, loanid,client_no,allsavings.headerid,loanpdt1 from allsavings inner join loantrans on loantrans.memid=allsavings.client_no inner join customers on customers.id = allsavings.client_no where loanpdt1<0 group by allsavings.id");
    foreach($savings as $say){
        if($say->loanid>0){
            if($say->isFunded==1){
               $loans= DB::select("select loan from loantrans where memid=$say->client_no and narration ='Loan Disbursement'");
               foreach($loans as $ln){
            $Objtopupsavings = new topupsavings();
            $Objtopupsavings->headerid= $say->headerid;
            $Objtopupsavings->loanid = $say->loanid;
            $Objtopupsavings->savingpayment= ($ln->loan*0.2)/16;
            $Objtopupsavings->save();
                echo $ln->loan." ".$say->name."<br>";
            //compulsoy savings 
            $update= allsavings::find($say->id);
            $update->savingpdt1=($ln->loan*0.2)/16;
            $update->save();

            // compulsary savings 
            $objaccountrans7=new accounttrans;
            $objaccountrans7->purchaseheaderid=$say->headerid;
            $objaccountrans7->amount=($ln->loan*0.2)/16;
            $objaccountrans7->total=($ln->loan*0.2)/16;
            $objaccountrans7->accountcode="400";//$loanpdts->disbursingac;// Disburing Account
            $objaccountrans7->narration=$say->name." -savings";
            $objaccountrans7->ttype="C";
            $objaccountrans7->transdate=date("Y-m-d", strtotime($say->date));
            $objaccountrans7->bracid=$say->bra;
           // $objaccountrans->save();
            // Inserting into income account
            $objaccountrans8=new accounttrans;
            $objaccountrans8->purchaseheaderid=$say->headerid;
            $objaccountrans8->amount=($ln->loan*0.2)/16;
            $objaccountrans8->accountcode=21;
            $objaccountrans8->ttype="D";
            $objaccountrans8->total=($ln->loan*0.2)/16;
            $objaccountrans8->narration=$say->name." -savngs";
            $objaccountrans8->transdate=date("Y-m-d", strtotime($say->date));
            $objaccountrans8->bracid=$say->bra;

            $objaccountrans7->save();
            $objaccountrans8->save();
               }
            }
            
        }
    }
}catch(\Exception $e){
    echo "Failed ".$e;
    DB::rollback();

}
DB::commit();
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from topupsavings ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from topupsavings limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objtopupsavings=new topupsavings();
$Objtopupsavings->id=$request['id'];
$Objtopupsavings->headerid=$request['headerid'];
$Objtopupsavings->loanid=$request['loanid'];
$Objtopupsavings->intialSavings=$request['intialSavings'];
$Objtopupsavings->savingpayment=$request['savingpayment'];
$Objtopupsavings->created_at=$request['created_at'];
$Objtopupsavings->updated_at=$request['updated_at'];
$Objtopupsavings->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objtopupsavings=topupsavings::find($id);

$Objtopupsavings->id=$request['id'];
$Objtopupsavings->headerid=$request['headerid'];
$Objtopupsavings->loanid=$request['loanid'];
$Objtopupsavings->intialSavings=$request['intialSavings'];
$Objtopupsavings->savingpayment=$request['savingpayment'];
$Objtopupsavings->created_at=$request['created_at'];
$Objtopupsavings->updated_at=$request['updated_at'];
$Objtopupsavings->save();
}
 public function destroy($id){
        $Objtopupsavings=topupsavings::find($id);
        $Objtopupsavings->delete();



    }

public function viewcombo(){


    return topupsavings::all();
}
}