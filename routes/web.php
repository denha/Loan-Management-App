<?php
use App\Stock;
use App\modules;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
    //return view('welcome');
//});

//Route::get('/abouts/{id}/{name}',function ($id,$name){

    //return $id. $name;
//});

//Route::get('/denis','PagesController@index');
//Route::get('/services','PagesController@services');
//Route::get('/about','PagesController@about');



Route::get('users','StocksController@fetch');

Route::post('/list','StocksController@store');
/*Route::post('/list',function(Request $request){
return response()->json(['message'=>$request['text1']])->name('list');
});*/
Route::post('edit/{id}','StocksController@update');
Route::post('delete/{id}','StocksController@destroy');


Route::get('/CodeGenerator','CodeGeneratorsController@index');
Route::get('CodeGenerator/tblnames','CodeGeneratorsController@gettblnames');
Route::post('CodeGenerator/send','CodeGeneratorsController@buildcode');
// Auto generated Routes for table modules 
Route::get('/modules','modulesController@index');
Route::get('/viewmodules','modulesController@view');
Route::post('/savemodules','modulesController@save');
Route::post('/editmodules/{id}','modulesController@update');
Route::post('/destroymodules/{id}','modulesController@destroy');
Route::get('/menu','modulesController@sidemenu');
Route::get('/combomodules','modulesController@combomodules');

// Auto generated Routes for table suppliers 
Route::get('/suppliers','suppliersController@index');
Route::get('/viewsuppliers','suppliersController@view');
Route::get('/viewsupplierstrails','TrailsController@view');
Route::post('/savesuppliers','suppliersController@save');
Route::post('/editsuppliers/{id}/{headerid}','suppliersController@update');
Route::post('/destroysuppliers/{id}/{headerid}','suppliersController@destroy');
Route::get('/supplierscombo','suppliersController@viewcombo');

// Auto generated Routes for table suppliers 
Route::get('/oldloans','oldloansController@index');
Route::get('/viewoldloans','oldloansController@view');
Route::get('/viewoldloanstrails','TrailsController@view');
Route::post('/saveoldloans','oldloansController@save');
Route::post('/editoldloans/{id}','oldloansController@update');
Route::post('/destroyoldloans/{id}','oldloansController@destroy');
Route::get('/oldloanscombo','oldloansController@viewcombo');

// Auto generated Routes for table requirements 
Route::get('/requirements','requirementsController@index');
Route::get('/viewrequirements','requirementsController@view');
Route::post('/saverequirements','requirementsController@save');
Route::post('/editrequirements/{id}','requirementsController@update');
Route::post('/destroyrequirements/{id}','requirementsController@destroy');
// Auto generated Routes for table requirements 
Route::get('/requirements','requirementsController@index');
Route::get('/viewrequirements','requirementsController@view');
Route::post('/saverequirements','requirementsController@save');
Route::post('/editrequirements/{id}','requirementsController@update');
Route::post('/destroyrequirements/{id}','requirementsController@destroy');
// Auto generated Routes for table requirements 
Route::get('/requirements','requirementsController@index');
Route::get('/viewrequirements','requirementsController@view');
Route::post('/saverequirements','requirementsController@save');
Route::post('/editrequirements/{id}','requirementsController@update');
Route::post('/destroyrequirements/{id}','requirementsController@destroy');
// Auto generated Routes for table categories 
Route::get('/categories','categoriesController@index');
Route::get('/viewcategories','categoriesController@view');
Route::post('/savecategories','categoriesController@save');
Route::post('/editcategories/{id}','categoriesController@update');
Route::post('/destroycategories/{id}','categoriesController@destroy');
Route::get('/categoriescombo','categoriesController@viewcombo');
// Auto generated Routes for table subcategories 
Route::get('/subcategories','subcategoriesController@index');
Route::get('/viewsubcategories','subcategoriesController@view');
Route::post('/savesubcategories','subcategoriesController@save');
Route::post('/editsubcategories/{id}','subcategoriesController@update');
Route::post('/destroysubcategories/{id}','subcategoriesController@destroy');
Route::get('/subcategoriescombo','subcategoriesController@viewcombo');
// Auto generated Routes for table uoms 
Route::get('/uoms','uomsController@index');
Route::get('/viewuoms','uomsController@view');
Route::post('/saveuoms','uomsController@save');
Route::post('/edituoms/{id}','uomsController@update');
Route::post('/destroyuoms/{id}','uomsController@destroy');
Route::get('/uomscombo','uomsController@viewcombo');

// Auto generated Routes for table stocks 
Route::get('/stocks','stocksController@index');
Route::get('/viewstocksbranch','stocksController@view');
Route::post('/savestocks','stocksController@save');
//Route::get('/viewstockbranch','stocksController@view');
Route::post('//viewstock/ocks','stocksController@save');
Route::post('/editstocks/{id}','stocksController@update');
Route::post('/destroystocks/{id}','stocksController@destroy');
Route::get('/stockscombo/{id}','stocksController@viewcombo');
Route::get('/bybranch','stocksController@bybranch');
// Auto generated Routes for table posts 
Route::get('/posts','postsController@index');
Route::get('/viewposts','postsController@view');
Route::post('/saveposts','postsController@save');
Route::post('/editposts/{id}','postsController@update');
Route::post('/destroyposts/{id}','postsController@destroy');
Route::get('/comboposts','postsController@viewcombo');
// Auto generated Routes for table purchaseheaders 
Route::get('/purchaseheaders','purchaseheadersController@index');
Route::get('/viewpurchaseheaders','purchaseheadersController@view');
Route::post('/savepurchaseheaders','purchaseheadersController@save');
Route::post('/editpurchaseheaders/{id}','purchaseheadersController@update');
Route::post('/destroypurchaseheaders/{id}','purchaseheadersController@destroy');
Route::get('/combopurchaseheaders','purchaseheadersController@viewcombo');
Route::get('/maxnumber','purchaseheadersController@maximum');
Route::get('/purchasesales','purchaseheadersController@salesindex');
Route::post('/savesales','purchaseheadersController@savesales');
Route::post('/savestransfers','purchaseheadersController@savetransfers');
Route::post('/savetransfertrans','purchaseheadersController@savetransfertrans');
// Auto generated Routes for table modeofpayments 
Route::get('/modeofpayments','modeofpaymentsController@index');
Route::get('/viewmodeofpayments','modeofpaymentsController@view');
Route::post('/savemodeofpayments','modeofpaymentsController@save');
Route::post('/editmodeofpayments/{id}','modeofpaymentsController@update');
Route::post('/destroymodeofpayments/{id}','modeofpaymentsController@destroy');
Route::get('/combomodeofpayments','modeofpaymentsController@viewcombo');
// Auto generated Routes for table stocktrans 
Route::get('/stocktrans','stocktransController@index');
Route::get('/viewstocktrans','stocktransController@view');
Route::post('/savestocktrans','stocktransController@save');
Route::post('/savesalespurchases','stocktransController@savesales');
Route::post('/editstocktrans/{id}','stocktransController@update');
Route::post('/destroystocktrans/{id}','stocktransController@destroy');
Route::get('/combostocktrans','stocktransController@viewcombo');
Route::get('viewstock/{id}','stocktransController@viewstock');
Route::get('/viewstocks','stocksController@viewstocks');
//Route for reports
Route::get('/salesreport','reportsController@index');
Route::get('/viewdaily','reportsController@viewdaily');
Route::get('/purchasereport','reportsController@purchasereport');
Route::get('/stockreport','reportsController@stockreport');
Route::get('/viewdailypurchase','reportsController@viewdailypurchase');
Route::get('/viewdailystock','reportsController@viewdailystock');
Route::get('/pdtbranch/{id}/{bra}','reportsController@productavailable');

Route::get('/outstandings','outstandingsController@index');
Route::get('/outstandingcusto','reportsController@outstandingcusto');
Route::get('/pending','pendingsController@index');
Route::get('pendingreport','reportsController@pending');

// Auto generated Routes for table branches 
Route::get('/branches','branchesController@index');
Route::get('/viewbranches','branchesController@view');
Route::post('/savebranches','branchesController@save');
Route::post('/editbranches/{id}','branchesController@update');
Route::post('/destroybranches/{id}','branchesController@destroy');
Route::get('/combobranches','branchesController@viewcombo');
// stock Transfers
Route::get('/stocktransfers','stocktransfersController@index');
Route::post('/stockquantity','stocktransController@stocktransfer');


// Auto generated Routes for table accounttypes 
Route::get('/accounttypes','accounttypesController@index');
Route::get('/viewaccounttypes','accounttypesController@view');
Route::post('/saveaccounttypes','accounttypesController@save');
Route::post('/editaccounttypes/{id}','accounttypesController@update');
Route::post('/destroyaccounttypes/{id}','accounttypesController@destroy');
Route::get('/comboaccounttypes','accounttypesController@viewcombo');
// Auto generated Routes for table chartofaccounts 
Route::get('/chartofaccounts','chartofaccountsController@index');
Route::get('/viewchartofaccounts','chartofaccountsController@view');
Route::post('/savechartofaccounts','chartofaccountsController@save');
Route::post('/editchartofaccounts/{id}','chartofaccountsController@update');
Route::post('/destroychartofaccounts/{id}','chartofaccountsController@destroy');
Route::get('/combochartofaccounts/{id}','chartofaccountsController@viewcombo');
Route::get('/combochartofaccounts','chartofaccountsController@viewcombo1');
// Auto generated Routes for table accounttrans 
Route::get('/accounttrans','accounttransController@index');
Route::get('/viewaccounttrans','accounttransController@view');
Route::post('/saveaccounttrans','accounttransController@save');
Route::post('/editaccounttrans/{id}','accounttransController@update');
Route::post('/destroyaccounttrans/{id}','accounttransController@destroy');
Route::get('/comboaccounttrans','accounttransController@viewcombo');

Route::get('/expenses','accounttransController@viewexpenses');
Route::post('/saveexpenses','accounttransController@saveexpenses');
Route::get('/viewtrans/{id}/{id2}','accounttransController@viewtrans');
Route::post('/updatebranch','accounttransController@updatebranch');
Route::post('/updatebranch1','accounttransController@updatebranch1');
Route::get('/viewexpenses/{id}','accounttransController@editexpenses');
Route::get('/viewtotals/{id}','accounttransController@viewincomes');


Route::get('/ledgers','accountingreportsController@index');
Route::get('/ledgerrports','accountingreportsController@ledger');

Route::get('/totalexpenses','expensesController@totalexpensesindex');
Route::get('/allexpenses','accountingreportsController@totalexpense');

Route::get('/trialbalance','accountingreportsController@indextrialbalance');
Route::get('/trialbalancerpt','accountingreportsController@trialbalance');

Route::get('/balancesheet','accountingreportsController@indexbalancesheet');
Route::get('/balancesheetrpt','accountingreportsController@balancesheet');

Route::get('/otherincomes','accounttransController@viewotherincomes');

Route::post('/saveotherincomes','accounttransController@saveotherincomes');

Route::get('/incomestats','accountingreportsController@viewincomestats');
Route::get('/incomestatementrpt','accountingreportsController@incomestatement');

Route::get('/inventorysettings','chartofaccountsController@inventorysettings');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Auto generated Routes for table companynames 
Route::get('/companynames','companynamesController@index');
Route::get('/viewcompanynames','companynamesController@view');
Route::post('/savecompanynames','companynamesController@save');
Route::post('/editcompanynames/{headerid}/{deleteloan}','companynamesController@update');
Route::post('/destroycompanynames/{headerid}/{delloan}/{isdelsec}/{idloan}','companynamesController@destroy');
Route::POST('/destroyindu/{head}','companynamesController@destroyindu');
Route::get('/combocompanynames','companynamesController@viewcombo');
Auth::routes();
Route::get('/','LoginController@Index');
//Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware'=>'auth'],function(){
    Route::get('/dash','dashboardsController@index')->name('dashboard');



});

Route::get('/totalincome','accountingreportsController@indextotalincome');
Route::get('/allincomes','accountingreportsController@totalincome');
Route::get('registers','LoginController@registerindex');

// Auto generated Routes for table users 
Route::get('/users','usersController@index');
Route::get('/viewusers','usersController@view');
Route::post('/saveusers','usersController@save');
Route::post('/editusers/{id}','usersController@update');
Route::post('/destroyusers/{id}','usersController@destroy');
Route::get('/combousers','usersController@viewcombo');
// Auto generated Routes for table financialyears 
Route::get('/financialyears','financialyearsController@index');
Route::get('/viewfinancialyears','financialyearsController@view');
Route::post('/savefinancialyears','financialyearsController@save');
Route::post('/editfinancialyears/{id}','financialyearsController@update');
Route::post('/destroyfinancialyears/{id}','financialyearsController@destroy');
Route::get('/combofinancialyears','financialyearsController@viewcombo');
Route::get('/activeyear','financialyearsController@activeyear');
Route::get('/itemprofits','reportsController@indexprofit');
Route::get('/totalprofits','reportsController@totalprofits');
Route::get('/fundtransfers','fundtransfersController@index');
Route::post('/savetransferheaders','fundtransfersController@savetransferheaders');
Route::get('/journels','journelsController@index');
Route::post('/journelsave','journelsController@journelsave');
Route::post('/journelheader','journelsController@journelheader');
Route::post('/importstock','stocksController@importstock');
Route::post('/savebalance','stockbalancesController@stockbalance');
Route::post('/savebalance2','stockbalancesController@pendingpayments');
Route::post('/destroysalesrecord/{id}','stocktransController@destorys');
Route::post('/upDateUrl','stocktransController@updaterow');
Route::post('/deletesales','stocktransController@deletesales');
Route::post('/updatepurchase','stocktransController@updatepurchase');
Route::post('/editxpenses','editxpensesController@editexpenses');
Route::post('editincome','editxpensesController@editincomes');
Route::post('deleteincome2','editxpensesController@deleteincome2');
Route::post('destroysincome1/{id}','editxpensesController@delincome1');
Route::post('/destroysexpense1/{id}','editxpensesController@delexpense1');
Route::get('/dashboardhome','dashboardsController@index');
Route::get('/dashboardhome1','dashboardsController@totaloutstanding');


Route::get('/memberinfos','memberinfosController@index');

Route::get('/viewmemberinfos','memberinfosController@view');

Route::post('/savememberinfos','memberinfosController@save');
//new updates 
Route::get('/viewstatements','statementsController@viewstatements');
Route::get('/allstate','statementsController@allsavingproductsrpt');
Route::get('/statements','statementsController@index');
Route::get('/allsavingproducts','statementsController@allsavingproducts');
Route::get('/defaulters','defaultersController@index');
Route::get('/default','defaultersController@defaulters');
Route::get('/savingdeposits','savingsController@savingsindex');
Route::Post('/savings','savingsController@savesavings');
Route::get('/viewdeposits','savingsController@view');
Route::post('/editsavings/{id}','savingsController@update');
Route::post('/deletesavings/{id}','savingsController@destroy');
Route::get('/withdrawals','withdrawsController@withdrawsindex');
Route::Post('/savingswithdraws','withdrawsController@savewithdraws');
Route::get('/viewwithdraws','withdrawsController@view');
Route::post('/editwithdraws/{id}','withdrawsController@update');
Route::post('/deletewithdraws/{id}','withdrawsController@destroy');
Route::get('/journelreports','journelsController@journelreports');
Route::get('/viewjournel','journelsController@viewjournelreport');
Route::post('/destroyjournel/{id}','journelsController@destroy');
Route::get('/sms','smsController@sms');
Route::get('/memberstatement/{id}','memberstatementsController@memberstatement');
Route::get("/loanschedule/{id}","loanschedulesController@loanindex");
Route::get("/viewloanschedule/{id}","loanschedulesController@viewschedule");
Route::get("/date","loanschedulesController@getdate");
Route::get("/date1","loanschedulesController@getdate1");
Route::get("/allloans","loanschedulesController@allloans");
Route::get("/loansdue","loanschedulesController@loansdueindex");
Route::get("/viewloandue","loanschedulesController@viewloandue");
Route::get("/viewloans","viewloansController@viewloans");
Route::post('/delxp/{id}','stocktransController@delxp');
Route::post('/expenseedit','accounttransController@expenseedit');
Route::get('/viewexp/{id}','accountingreportsController@viewexp');
Route::get('/viewInc/{id}','accountingreportsController@viewInc');
// PDF report Routes
Route::get("/loanschedulepdf/{id}","loanreportpdfsController@scheduleindex");
Route::get("/loanarrearspdf","loanreportpdfsController@loanarrears");
Route::get("/allloanspdf","loanreportpdfsController@allloanspdfs");
Route::get("/allloanspdf/{date1}/{date2}","loanreportpdfsController@allloanspdfs");
Route::get("/summary","statementsController@viewsummary");
Route::get("/viewsummary","statementsController@summary");

// Auto generated Routes for table savingsproducts 
Route::get('/savingsproducts','savingsproductsController@index');
Route::get('/viewsavingsproducts','savingsproductsController@view');
Route::post('/savesavingsproducts','savingsproductsController@save');
Route::post('/editsavingsproducts/{id}','savingsproductsController@update');
Route::post('/destroysavingsproducts/{id}','savingsproductsController@destroy');
Route::get('/combosavingsproducts','savingsproductsController@viewcombo');

// Auto generated Routes for table savingdefinations 
Route::get('/savingdefinations','savingdefinationsController@index');
Route::get('/viewsavingdefinations','savingdefinationsController@view');
Route::post('/savesavingdefinations','savingdefinationsController@save');
Route::post('/editsavingdefinations/{id}','savingdefinationsController@update');
Route::post('/destroysavingdefinations/{id}','savingdefinationsController@destroy');
Route::get('/combosavingdefinations','savingdefinationsController@viewcombo');
// Auto generated Routes for table allsavings 
Route::get('/allsavings','allsavingsController@index');
Route::get('/viewallsavings','allsavingsController@view');
Route::post('/saveallsavings','allsavingsController@save');
Route::post('/editallsavings/{id}','allsavingsController@update');
Route::post('/destroyallsavings/{id}','allsavingsController@destroy');
Route::get('/comboallsavings','allsavingsController@viewcombo');
// Auto generated Routes for table fixeddeposits 
Route::get('/fixeddeposits','fixeddepositsController@index');
Route::get('/viewfixeddeposits','fixeddepositsController@view');
Route::post('/savefixeddeposits','fixeddepositsController@save');
Route::post('/editfixeddeposits/{id}/{headerid}','fixeddepositsController@update');
Route::post('/destroyfixeddeposits/{id}','fixeddepositsController@destroy');
Route::get('/combofixeddeposits','fixeddepositsController@viewcombo');
// Auto generated Routes for table fixedtypes 
Route::get('/fixedtypes','fixedtypesController@index');
Route::get('/viewfixedtypes','fixedtypesController@view');
Route::post('/savefixedtypes','fixedtypesController@save');
Route::post('/editfixedtypes/{id}','fixedtypesController@update');
Route::post('/destroyfixedtypes/{id}','fixedtypesController@destroy');
Route::get('/combofixedtypes','fixedtypesController@viewcombo');
// Auto generated Routes for table loanproducts 
Route::get('/loanproducts','loanproductsController@index');
Route::get('/viewloanproducts','loanproductsController@view');
Route::post('/saveloanproducts','loanproductsController@save');
Route::post('/editloanproducts/{id}','loanproductsController@update');
Route::post('/destroyloanproducts/{id}','loanproductsController@destroy');
Route::get('/comboloanproducts','loanproductsController@viewcombo');
// Auto generated Routes for table interestmethods 
Route::get('/interestmethods','interestmethodsController@index');
Route::get('/viewinterestmethods','interestmethodsController@view');
Route::post('/saveinterestmethods','interestmethodsController@save');
Route::post('/editinterestmethods/{id}','interestmethodsController@update');
Route::post('/destroyinterestmethods/{id}','interestmethodsController@destroy');
Route::get('/combointerestmethods','interestmethodsController@viewcombo');
// Auto generated Routes for table modes 
Route::get('/modes','modesController@index');
Route::get('/viewmodes','modesController@view');
Route::post('/savemodes','modesController@save');
Route::post('/editmodes/{id}','modesController@update');
Route::post('/destroymodes/{id}','modesController@destroy');
Route::get('/combomodes','modesController@viewcombo');
// Auto generated Routes for table loanfees 
Route::get('/loanfees','loanfeesController@index');
Route::get('/viewloanfees','loanfeesController@view');
Route::post('/saveloanfees','loanfeesController@save');
Route::post('/editloanfees/{id}','loanfeesController@update');
Route::post('/destroyloanfees/{id}','loanfeesController@destroy');
Route::get('/comboloanfees','loanfeesController@viewcombo');
// Auto generated Routes for table loanrepayments 
Route::get('/loanrepayments','loanrepaymentsController@index');
Route::get('/viewloanrepayments','loanrepaymentsController@view');
Route::post('/saveloanrepayments','loanrepaymentsController@save');
Route::post('/editloanrepayments/{id}','loanrepaymentsController@update');
Route::post('/destroyloanrepayments/{id}','loanrepaymentsController@destroy');
Route::get('/comboloanrepayments','loanrepaymentsController@viewcombo');
Route::get("/shares","statementsController@sharesindex");
Route::get("/viewshares","statementsController@shares");
Route::get("/example","statementsController@example");
// Auto generated Routes for table savingcals 
Route::get('/savingcals','savingcalsController@index');
Route::get('/viewsavingcals','savingcalsController@view');
Route::post('/savesavingcals','savingcalsController@save');
Route::post('/editsavingcals/{id}','savingcalsController@update');
Route::post('/destroysavingcals/{id}','savingcalsController@destroy');
Route::get('/combosavingcals','savingcalsController@viewcombo');
Route::get("/loan","statementsController@computeloans");
Route::get('/ledgerpdf/{acode}/{date1}/{date2}/{day1}/{day2}','workersController@ledger');
//Route::get('/ledgerpdf/{id}/{date1}/{date2}','workersController@ledger1');
Route::get('/allsavingpdf/{id}','workersController@allsavings');
Route::get('/allsavepdt','workersController@allsavepdt');
Route::get("/statementpdf/{id}/{pdt}","workersController@statementpdf");
Route::get('/trialbalancepdf/{date1}/{date2}/{day1}/{day2}','workersController@trialbalancepdfs');
Route::get('/summarypdf','workersController@summarypdf');
Route::post('/incomeedit','accounttransController@incomeedit');
// Auto generated Routes for table companys 
Route::get('/companys','companysController@index');
Route::get('/viewcompanys','companysController@view');
Route::post('/savecompanys','companysController@save');
Route::post('/editcompanys/{id}','companysController@update');
Route::post('/destroycompanys/{id}','companysController@destroy');
Route::get('/combocompanys','companysController@viewcombo');
Route::post('/createcompany','companysController@createcompany');
// Auto generated Routes for table retainedearnings 
Route::get('/retainedearnings','retainedearningsController@index');
Route::get('/viewretainedearnings','retainedearningsController@view');
Route::post('/saveretainedearnings','retainedearningsController@save');
Route::post('/editretainedearnings/{id}','retainedearningsController@update');
Route::post('/destroyretainedearnings/{id}','retainedearningsController@destroy');
Route::get('/comboretainedearnings','retainedearningsController@viewcombo');
route::post('/importnames','customersController@importnames');
Route::post("/importsavings","importwithdrawsControllers@importwithdraws");
Route::get("/incomestatepdf/{date1}/{date2}/{day1}/{day2}","retainedearningsController@incomestatepdf");
Route::get("/chartofaccountpreview","chartofaccountsController@chartofaccountpreview");
Route::post("/importchartofaccounts","chartofaccountsController@importchartofaccount");
Route::post("/editjournel","journelsController@editjournel");
Route::get("/viewjournelfooters/{id}","journelsController@viewjournelfooters");
Route::get("/bsheetpdf/{date1}/{date2}/{date3}","workersController@bsheetpdf");
Route::get('/isComplete','purchaseheadersController@isComplete');
// Auto generated Routes for table memberships 
Route::get('/memberships','membershipsController@index');
Route::get('/viewmemberships','membershipsController@view');
Route::post('/savememberships','membershipsController@save');
Route::post('/editmemberships/{id}','membershipsController@update');
Route::post('/destroymemberships/{id}','membershipsController@destroy');
Route::get('/combomemberships','membershipsController@viewcombo');
Route::get('checkBal/{clientno}','withdrawsController@checkBal');
Route::get('checkBalAll/{clientno}','withdrawsController@checkBalAll');
Route::get('checkBalLn/{clientno}','withdrawsController@checkBalLn');
Route::get('/fixeddepositconfigs','fixeddepositsController@fixeddepositconfigs');
// Auto generated Routes for table fixeddepositconfigs 
Route::get('/fixeddepositconfigs','fixeddepositconfigsController@index');
Route::get('/viewfixeddepositconfigs','fixeddepositconfigsController@view');
Route::post('/savefixeddepositconfigs','fixeddepositconfigsController@save');
Route::post('/editfixeddepositconfigs/{id}','fixeddepositconfigsController@update');
Route::post('/destroyfixeddepositconfigs/{id}','fixeddepositconfigsController@destroy');
Route::get('/combofixeddepositconfigs','fixeddepositconfigsController@viewcombo');
Route::get('/computefixedDeposit','fixeddepositsController@computefixedDeposit');
Route::get('/fixedwithdraws','fixeddepositsController@fixedwithdraws');
Route::get('/getcheckpay/{id}','fixeddepositsController@getcheckpay');
Route::post("/paycheck","fixeddepositsController@paycheck");
Route::get("viewfixedwithdraws","fixeddepositsController@viewfixedwithdraws");
Route::post('/destroyfixedwithdraws/{id}/{headerid}','fixeddepositsController@destroyfixedwithdraws');
Route::post('/paycheckedit/{id}/{headerid}','fixeddepositsController@paycheckedit');
Route::get('/fixedcertificate/{id}','fixeddepositsController@fixedcertificate');
Route::get('/sharepdfs','statementsController@sharepdfs');
// Auto generated Routes for table customers 
Route::get('/customers','customersController@index');
Route::get('/viewcustomers','customersController@view');
Route::post('/savecustomers','customersController@save');
Route::post('/editcustomers/{id}','customersController@update');
Route::post('/destroycustomers/{id}','customersController@destroy');
Route::get('/customerscombo','customersController@viewcombo');
Route::get('/customerscomboBranch/{id}','customersController@viewcomboBranch');
// Auto generated Routes for table maritals 
Route::get('/maritals','maritalsController@index');
Route::get('/viewmaritals','maritalsController@view');
Route::post('/savemaritals','maritalsController@save');
Route::post('/editmaritals/{id}','maritalsController@update');
Route::post('/destroymaritals/{id}','maritalsController@destroy');
Route::get('/combomaritals','maritalsController@viewcombo');
Route::get("/loanduepdf/{date}","loanreportpdfsController@loanduepdf");
route::get("/help","accounttransController@help");
// Auto generated Routes for table sharesettings 
Route::get('/sharesettings','sharesettingsController@index');
Route::get('/viewsharesettings','sharesettingsController@view');
Route::post('/savesharesettings','sharesettingsController@save');
Route::post('/editsharesettings/{id}','sharesettingsController@update');
Route::post('/destroysharesettings/{id}','sharesettingsController@destroy');
Route::get('/combosharesettings','sharesettingsController@viewcombo');
// Auto generated Routes for table sharetransfers 
Route::get('/sharetransfers','sharetransfersController@index');
Route::get('/viewsharetransfers','sharetransfersController@view');
Route::post('/savesharetransfers','sharetransfersController@save');
Route::post('/editsharetransfers/{id}','sharetransfersController@update');
Route::post('/destroysharetransfers/{id}','sharetransfersController@destroy');
Route::get('/combosharetransfers','sharetransfersController@viewcombo');

Route::get("/threemonths","allsavingsController@threemonths");
Route::get("/threemonthsview","allsavingsController@threemonthsview");
Route::get("/three","dashboardsController@three");
// Auto generated Routes for table fixednotes 
Route::get('/fixednotes','fixednotesController@index');
Route::get('/viewfixednotes','fixednotesController@view');
Route::post('/savefixednotes','fixednotesController@save');
Route::post('/editfixednotes/{id}','fixednotesController@update');
Route::post('/destroyfixednotes/{id}','fixednotesController@destroy');
Route::get('/combofixednotes','fixednotesController@viewcombo');
Route::get("/expensepreview/{date1}/{date2}","workersController@expensepreview");
Route::get("/incomepreview/{date1}/{date2}","workersController@incomepreview");
// Auto generated Routes for table groups 
Route::get('/groups','groupsController@index');
Route::get('/viewgroups','groupsController@view');
Route::post('/savegroups','groupsController@save');
Route::post('/editgroups/{id}','groupsController@update');
Route::post('/destroygroups/{id}','groupsController@destroy');
Route::get('/combogroups','groupsController@viewcombo');
Route::get("viewgroup/{id}","groupsController@viewgroup");
Route::get("viewmembers/{id}","groupsController@viewmembers");
// Auto generated Routes for table groupmembers 
Route::get('/groupmembers','groupmembersController@index');
Route::get('/viewgroupmembers','groupmembersController@view');
Route::post('/savegroupmembers','groupmembersController@save');
Route::post('/editgroupmembers/{id}','groupmembersController@update');
Route::post('/destroygroupmembers/{id}','groupmembersController@destroy');
Route::get('/combogroupmembers','groupmembersController@viewcombo');
Route::get('viewapplication','suppliersController@viewapplication');
Route::get('applicationdetails/{id}','groupsController@applicationdetails');
Route::get('applicationlist/{id}','groupsController@applicationlist');
Route::get('applicationlistfinal/{id}','groupsController@applicationlistfinal');
Route::get('/loanapproval','groupsController@loanapproval');
Route::get('/listloanapproval','suppliersController@listloanapproval');
Route::get('/listloanapprovalfinal','suppliersController@listloanapprovalfinal');
Route::post('/updateapprove','groupsController@updateapprove');
Route::post('/updateapprovefinal','groupsController@updateapprovefinal');
Route::post('/updatereject','groupsController@updatereject');
Route::post('/updaterejectfinal','groupsController@updaterejectfinal');
Route::get('/loandisburse','suppliersController@loandisburse');
Route::get("/customersapproved","groupsController@customersapproved");
Route::get("/customersapproved/{id}","groupsController@customersapprovedbra");
Route::get('/getApprovedAmt/{id}','groupsController@getApprovedAmt');
Route::POST('/saveloanapp','groupsController@saveloanapp');
Route::POST('/delapplication','groupsController@delapplication');
Route::post('/updateapp/{id}','groupsController@updateapp');
Route::get('/penalty','groupsController@penalty');
Route::get("/computepenalty","groupsController@computepenalty");

// Auto generated Routes for table grouppenaltys 
Route::get('/grouppenaltys','grouppenaltysController@index');
Route::get('/viewgrouppenaltys','grouppenaltysController@view');
Route::post('/savegrouppenaltys','grouppenaltysController@save');
Route::post('/editgrouppenaltys/{id}','grouppenaltysController@update');
Route::post('/destroygrouppenaltys/{id}','grouppenaltysController@destroy');
Route::get('/combogrouppenaltys','grouppenaltysController@viewcombo');
Route::get('/viewgroupind/{id}','groupsController@viewgroupind');
Route::get("viewindeport/{id}","reportsController@viewindeport");
// Auto generated Routes for table regmembers 
Route::get('/regmembers','regmembersController@index');
Route::get('/viewregmembers','regmembersController@view');
Route::post('/saveregmembers','regmembersController@save');
Route::post('/editregmembers/{id}','regmembersController@update');
Route::post('/destroyregmembers/{id}','regmembersController@destroy');
Route::get('/comboregmembers','regmembersController@viewcombo');
// Auto generated Routes for table roles 
Route::get('/roles','rolesController@index');
Route::get('/viewroles','rolesController@view');
Route::post('/saveroles','rolesController@save');
Route::post('/editroles/{id}','rolesController@update');
Route::post('/destroyroles/{id}','rolesController@destroy');
Route::get('/comboroles','rolesController@viewcombo');
Route::post("/selectgroups","groupsController@selectgroups");
Route::get("/approvedmember/{id}","groupsController@approvedmember");
// Auto generated Routes for table passbooks 
Route::get('/passbooks','passbooksController@index');
Route::get('/viewpassbooks','passbooksController@view');
Route::post('/savepassbooks','passbooksController@save');
Route::post('/editpassbooks/{id}','passbooksController@update');
Route::post('/destroypassbooks/{id}','passbooksController@destroy');
Route::get('/combopassbooks','passbooksController@viewcombo');
Route::get("/memberdetails/{id}","regmembersController@memberdetails");
Route::get("/currentPayment","dashboardsController@currentPayment");
route::get("/registeredMembers/{id}","regmembersController@registeredMembers");
// Auto generated Routes for table psbkrecords 
Route::get('/psbkrecords','psbkrecordsController@index');
Route::get('/viewpsbkrecords','psbkrecordsController@view');
Route::post('/savepsbkrecords','psbkrecordsController@save');
Route::post('/editpsbkrecords/{id}','psbkrecordsController@update');
Route::post('/destroypsbkrecords/{id}','psbkrecordsController@destroy');
Route::get('/combopsbkrecords','psbkrecordsController@viewcombo');
Route::get('/finalloanapproval','groupsController@finalloanapproval');
Route::get('/fundedmembers/{id}','customersController@fundedMembers');
// Auto generated Routes for table groupcollections 
Route::get('/groupcollections','groupcollectionsController@index');
Route::get('/viewgroupcollections','groupcollectionsController@view');
Route::post('/savegroupcollections','groupcollectionsController@save');
Route::post('/editgroupcollections/{id}','groupcollectionsController@update');
Route::post('/destroygroupcollections/{id}','groupcollectionsController@destroy');
Route::get('/combogroupcollections','groupcollectionsController@viewcombo');
Route::get("/groupbalance/{id}","groupcollectionsController@groupbalance");
Route::get("/paymentdetails/{id}/{data}","groupcollectionsController@paymentdetails");
Route::get("/passbookdetails/{id}","passbooksController@passbookdetails");
Route::get("/loandetails/{id}","groupsController@loandetails");
// Auto generated Routes for table indpayments 
Route::get('/indpayments','indpaymentsController@index');
Route::get('/viewindpayments','indpaymentsController@view');
Route::post('/saveindpayments','indpaymentsController@save');
Route::post('/editindpayments/{id}','indpaymentsController@update');
Route::post('/destroyindpayments/{id}','indpaymentsController@destroy');
Route::get('/comboindpayments','indpaymentsController@viewcombo');
// Auto generated Routes for table cycles 
Route::get('/cycles','cyclesController@index');
Route::get('/viewcycles','cyclesController@view');
Route::post('/savecycles','cyclesController@save');
Route::post('/editcycles/{id}','cyclesController@update');
Route::post('/destroycycles/{id}','cyclesController@destroy');
Route::get('/combocycles','cyclesController@viewcombo');
// Auto generated Routes for table topupsavings 
Route::get('/topupsavings','topupsavingsController@post');
Route::get('/viewtopupsavings','topupsavingsController@view');
Route::post('/savetopupsavings','topupsavingsController@save');
Route::post('/edittopupsavings/{id}','topupsavingsController@update');
Route::post('/destroytopupsavings/{id}','topupsavingsController@destroy');
Route::get('/combotopupsavings','topupsavingsController@viewcombo');