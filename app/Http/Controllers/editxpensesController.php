<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\accounttrans;
use App\purchaseheaders;
use App\allsavings;
use App\loantrans;


 class editxpensesController extends Controller{

   public function editexpenses(Request $request){

    $code=$request['accountcode'];

    //Updating expenses Account
$accounttrans=accounttrans::where('id','=',$request['id'])->update(['amount'=>$request['amount'],'narration'=>$request['narration'],
'accountcode'=>$code]
);
//Updating Cash Account
$accounttrans=accounttrans::where('id','=',$request['id'])->where('ttype','=','C')->update(['amount'=>$request['amount'],'accountcode'=>$request['accountcode2'],
'narration'=>$request['narration']]
);


   }


   public function editincomes(Request $request){
    $code=$request['accountcode'];

    //Updating expenses Account
$accounttrans=accounttrans::where('id','=',$request['id'])->update(['amount'=>$request['amount'],'narration'=>$request['narration'],
'accountcode'=>$code]
);
//Updating Cash Account
$accounttrans=accounttrans::where('id','=',$request['id'])->where('ttype','=','D')->update(['amount'=>$request['amount'],'accountcode'=>$request['accountcode2'],
'narration'=>$request['narration']]
);


   }


   public function deleteincome2(Request $request){
     $accounttransObj= accounttrans::find($request['id']);
     $accounttransObj->delete();


   }

   public function delincome1($id){
     DB::beginTransaction();
     try{
    $purno= purchaseheaders::find($id);
    $purno->delete();
    accounttrans::where('purchaseheaderid',$id)->delete();

    $surcharge=DB::select("select * from allsavings where headerid=$id");
    if(count($surcharge)>0){
      allsavings::where('headerid','=',$id)->delete();
      loantrans::where('headerid','=',$id)->delete();
    }
    
  }catch(\Exception $e){
    echo "Failed to Delete".$e;
    DB::rollBack();
  }
DB::commit();

   }

 }