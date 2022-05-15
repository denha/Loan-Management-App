@include('layouts/header')
<style>
.datagrid-row-alt{
    background-color: #d9f2e7;

}
.datagrid-row-selected {
  background: #009900;
  color: white;
}
</style>
<div class='easyui-dialog'  style='width:50%;padding:5px;' closed='true' id='dlgsuppliers' toolbar='#suppliers'>
<form id='loans'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Name</label></div><input  required class='easyui-combobox form-control' style="height:34px;width:100%;" data-options="url:'',method:'get',valueField:'id',textField:'name'" name='name' 
 id='name' /></div>
</div>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><input required class='easyui-datebox form-control' data-options="onSelect:validateDate" style="height:34px;width:100%;" name='date' 
 id='date' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Loan Category</label></div><input style="height:34px;width:100%" required class='easyui-combobox form-control'  name='loancat' 
 id='loancat' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Loan Purpose</label></div><input required class='easyui-textbox form-control'  style="height:34px;width:100%;" name='paydet' 
 id='paydet' /></div>
</div>-->
<div class='col-lg-6'>
    <div class='form-group'>
    <div><label>Loan Amount</label></div><input required readonly  class='easyui-textbox form-control'  style="height:34px;width:100%;" id='amount' name='loancredit' /> 
  
    </div>
    
    </div>
    <div class='col-lg-6'>
<div class='form-group'>
<div><label>Interest Method</label></div><input style="height:34px;width:100%" required class='easyui-combobox form-control' data-options="url:'/combointerestmethods',method:'get',valueField:'id',textField:'name'" name='method' 
 id='method' readonly />
 </div>
</div>
    <div class='col-lg-6'>
<div class='form-group'>
<div><label>Loan Interest %</label></div><input required  class='easyui-numberbox form-control'  style="height:34px;width:100%;" name='loaninterest' 
 id='interestrate' readonly /></div>
</div>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Repay Period</label></div><input required class='easyui-numberbox form-control'  style="height:34px;width:50%;" name='loanrepay' 
 id='repay' readonly /><input style="height:34px;width:50%" required class='easyui-combobox form-control' data-options="url:'combomodes',method:'get',valueField:'name',textField:'name'" name='mode' 
 id='mode' readonly />
 </div>
</div>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Compulsory Savings</label></div><input required  class='easyui-textbox form-control'  style="height:34px;width:100%;" name='savings' 
 id='savings'  /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Proof of Payment</label></div><input   class='easyui-filebox form-control'  style="height:34px;width:100%;" name='paydet' 
 id='paydet' /></div>
</div>
<input type="hidden" class="easyui-textbox" id="appid" />
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Collateral</label></div><input required class='easyui-textbox form-control'  style="height:34px;width:100%;" name='collateral' 
 id='security' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Guarantor</label></div><input required  class='easyui-combobox form-control'  style="height:34px;width:100%;" name='guanter' 
 id='guaranter' /></div>
 
</div>-->

<hr>
<input type="hidden" id="memid" name="memid"/>
</div>
</form>

<div style='padding:5px;' id='suppliers' /><a href='javascript:void(0)' class='btn btn-primary'id='savesuppliers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' striped="true" showFooter="true" title='Loan Disbursement' iconCls='fa fa-table' singleSelect='true' url='viewsuppliers' pagination='true' id='gridsuppliers' method='get' fitColumns='true'  rownumbers='true' style='width:100%' toolbar='#supplierstoolbar'>
<thead><tr>

<th field='date' width='40'>Date</th>
<th field='name' width='100'>Name</th>
<th field='paydet'hidden width='70'>Reciept No</th>
<th field='loaninterest' width='40'>InterestRate</th>
<th field='loanrepay' width='40'>RepayPeriod</th>
<th field='loa' hidden width='40'>Mode</th>
<th field='loancredit' width='50'>LoanAmount</th>
<th field='loanid'  hidden="true" width='10'>Loanid</th>
<th field='memid' hidden="true" width='10'>Loanid</th>
<th field="headerid" hidden="true"  >Headerid </th>

</tr></thead>
</table>
<div id='supplierstoolbar'>

 <a href='javascript:void(0)' class='btn btn-primary' id='newsuppliers'  ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editsuppliers' iconCls='icon-edit' > <i class="fa fa-pencil" aria-hidden="true"></i>  Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletesuppliers' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a> 
<label>Date</label>
<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>&nbsp;
@if(Auth::user()->branchid==1)

&nbsp;&nbsp;<label>Branch </label>&nbsp;<input  class='easyui-combobox ' style="width:20%;height:34px;" data-options="url:'combocompanys',method:'get',valueField:'id',textField:'name'" name='company' 
id='company' />
<input type="hidden" id="adminset" value="1"/>

@endif
<!--<input class="easyui-combobox" id="branche" name="branche" data-options="url:'combobranches',valueField:'id',textField:'branchname',method:'get' "/>-->
&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="loansch" name="find"><i class="fa fa-calendar"></i> Loan Schedule</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="viewloan" name="find"><i class="fa fa-book"></i> View Loan</a>
 
 </div>

{{csrf_field()}}
<script>
 var url;
 var validate=false;
 function fixComplete(){
    $.getJSON('isComplete',function(data){
    $.each(data, function (index, value) {
        var countresults=value.count;
        if(countresults>0){
            $.messager.alert('Warning','There is an Incomplete Transaction, Click ok to fix this Issue','warning');  
        }
        }); 
    });  
}
function validateDate(date){
$.getJSON('activeyear',function(data){
if(data==''){
$.messager.alert('Warning','Financial Period Not Set..Please set it and try again','warning');
$('#date').datebox('setValue','');

}else{
	$.each(data, function (index, value) {
		
var start= new Date(value.startperiod).getTime()/1000;
var end =new Date(value.endperiod).getTime()/1000;
var inputdate=date.getTime()/1000;
if(inputdate<start || inputdate>end){
var a=$.messager.alert('Warning','You can not enter a date that is not with in the Active Financial Period '+value.startperiod+ ' AND '+value.endperiod,'warning');
$('#date').datebox('setValue', '');
}

});
}

});

}
 $(document).ready(function(){
    $('#paydet').filebox({
    accept: 'image/*'
});
     $('#viewloan').click(function(){
        var row=$('#gridsuppliers').datagrid('getSelected');
        window.open('/loandetails/'+row.appid);
     });
//Auto Generated code for New Entry Code
   $('#newsuppliers').click(function(){
       validate=true;
       fixComplete();
       var ans= $('#adminset').val();
var company=$('#company').val();

if(ans==1){
    if(company==''){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Please Select the Branch'});

    }else{
        $('#dlgsuppliers').dialog('open').dialog('setTitle','New Loan Disbursement');
        @if(Auth::user()->branchid==1)
var bra=$('#company').val();
$('#name').combobox({
url:'/customersapproved/'+bra,
method:'get',
valueField:'id',
textField:'name',
onChange:function(){
    $.getJSON('getApprovedAmt/'+$(this).combobox('getValue'),function(data){
    $.each(data, function (index, value) {
        $('#amount').textbox('setValue',value.approveamt);
        $('#method').textbox('setValue',value.intmethod);
        $('#interestrate').textbox('setValue',value.loaninterest);
        $('#repay').textbox('setValue',value.loanrepay);
        $('#mode').textbox('setValue',value.period);
        $('#appid').textbox('setValue',value.appid);
        var colsaving=(20/100)*value.approveamt.replace(/,/g,'');
        $('#savings').textbox('setValue',colsaving.toLocaleString());
        }); 
    });
    
}


});
      @endif
           url='/savesuppliers';
           $('#loans').form('clear');
    }
    }else{
        $('#dlgsuppliers').dialog('open').dialog('setTitle','New Loan Disbursement');
           
           url='/savesuppliers';
           $('#loans').form('clear');
    }

});

       //Auto Generated code for Edit Code
 $('#editsuppliers').click(function(){
       validate=false;
 var row=$('#gridsuppliers').datagrid('getSelected');
       $('#dlgsuppliers').dialog('open');
       $('#loans').form('load',row);
       url='/editsuppliers/'+row.loanid+'/'+row.headerid;
     
       
       
       });
/// getting customer names 
$('#name').combobox({
url:'/customersapproved',
method:'get',
valueField:'id',
textField:'name',
onChange:function(){
    $.getJSON('getApprovedAmt/'+$(this).combobox('getValue'),function(data){
    $.each(data, function (index, value) {
        $('#amount').textbox('setValue',value.approveamt);
        $('#method').textbox('setValue',value.intmethod);
        $('#interestrate').textbox('setValue',value.loaninterest);
        $('#repay').textbox('setValue',value.loanrepay);
        $('#mode').textbox('setValue',value.period);
        $('#appid').textbox('setValue',value.appid);
        var colsaving=(20/100)*value.approveamt.replace(/,/g,'');
        $('#savings').textbox('setValue',colsaving.toLocaleString());
        }); 
    });
    
}


});
//Auto Generated Code for Saving
$('#savesuppliers').click(function(){ 
var id=$('#id').val();
var name=$('#name').val();
var tel=$('#name').val();
var branch=$('#company').val();
var amount=$('#amount').val();
var mode=$('#mode').val();
var security=$('#security').val();
var interest=$('#interestrate').val();
var date=$('#date').val();
var repay=$('#repay').val();
var memid=$('#memid').val();
var gauranter=$('#guaranter').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
//ar paydet=$('#paydet').val();
var method=$('#method').val();
var loancat=1;$('#loancat').val();
var loanrepay=$('#loanrepay').val();
var loanfee1=$('#loanfee1').val();
var loanfee2=$('#loanfee2').val();
var loanfee3=$('#loanfee3').val();
var savingpdt1=$('#savings').val();
var paydet=$('#paydet').next().find('.textbox-value');
var appid=$('#appid').val();

// Form Data for posting
var form_data = new FormData();
form_data.append('id',id);
form_data.append('name',name);
form_data.append('tel',tel);
form_data.append('branch',branch);
form_data.append('amount',amount);
form_data.append('mode',mode);
form_data.append('security',security);
form_data.append('interest',interest);
form_data.append('date',date);
form_data.append('repay',repay);
form_data.append('memid', memid);

//form_data.append('guaranter',gauranter);
form_data.append('method',method);
form_data.append('loancat',loancat);
form_data.append('loanrepay',loanrepay);
form_data.append('loanfee1',loanfee1);
form_data.append('loanfee2', loanfee2);

form_data.append('loanfee3',loanfee3);
form_data.append('savings', savingpdt1);
form_data.append('appid', appid);
form_data.append('paydet', paydet[0].files[0]);
form_data.append('_token', $('input[name=_token]').val());

$('#loans').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){
                        if(validate==true){
                            if(typeof paydet[0].files[0]==='undefined'){
                                $.messager.alert('Warning','You must attached the proof of payment ','warning');
                            }else{
                                $.ajax({
                            cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'Post',
success:function(data){
    if(data.results=="true"){
    $.messager.alert("Info","This Person has an exiting Loan. Loan Cannot be Disbursed ");
    }else if(data.reject=='yes'){
        $.messager.alert('Warning',data.names+ " Loan Application (s) is reject.. Loan Cannot be disbursed for any of the other group members.",'warning'); 
        
        }else{
        
        $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
      $('#gridsuppliers').datagrid('reload');
      $('#dlgsuppliers').dialog('close');
    }
}
});
                            }
                        }else{
                        $.ajax({
                            cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'Post',
success:function(data){
    if(data.results=="true"){
    $.messager.alert("Info","This Person has an exiting Loan. Loan Cannot be Disbursed ");
    }
    else if(data.reject=='yes'){
        $.messager.alert('Warning',data.names+ " Loan Application (s) is reject.. Loan Cannot be disbursed for any of the other group members.",'warning'); 
        
        }
        else{
        
        $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
      $('#gridsuppliers').datagrid('reload');
      $('#dlgsuppliers').dialog('close');
    }
}
});
                        }

                    }
                }
});

});
// Loading data from loan categories 
$('#loancat').combobox({
	url:'/comboloanproducts',
	valueField:'id',
	textField:'name',
    'method':'get',
    onSelect:function(data){
       //interest.numberbox('setValue',data.interest);
       //console.log(data.interest);
       $('#interestrate').numberbox('setValue',data.interest);
    }


});
$('#guaranter').combobox({
	url:'/customerscombo',
	valueField:'name',
	textField:'name',
    multiple:'true',
    'method':'get',



});



// End of load data from loan categories


//Auto generated code for deleting
$('#deletesuppliers').click(function(){

    var a=$('#gridsuppliers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridsuppliers').datagrid('getSelected');
                $.ajax({
                 url:'/destroysuppliers/'+row.loanid+'/'+row.headerid,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridsuppliers').datagrid('reload');
                 }
                });
                
            }

});
}
});
//Querying for the loans
$('#loansch').click(function(){
    var a=$('#gridsuppliers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Info','Please select a Recored to View');
        
    }else{
    window.open('/loanschedule/'+a.loanid);
    }

});
$('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
   // var product=$('#product').val();
    var branch=$('#company').val();
    
$('#gridsuppliers').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2,branch:branch}

});

});


$('#date').datebox({
        formatter : function(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
        },
        parser : function(s){

            if (!s) return new Date();
            var ss = s.split('-');
            var y = parseInt(ss[2],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[0],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d)
            } else {
                return new Date();
            }
        }

    });
    // setting up percentage amount

        $('#amount').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
              var cleanamount=$(this).val().split(",").join("");
              if($('#loanfee11').val()==1){
                  var percentage=($('#loanfee12').val()/100)*cleanamount;
                  $('#loanfee1').textbox('setValue',percentage);
              }else{
                $('#loanfee1').textbox('setValue',$('#loanfee12').val()); 
              }
              if($('#loanfee21').val()==1){
                  var percentage=($('#loanfee22').val()/100)*cleanamount;
                  $('#loanfee2').textbox('setValue',percentage);
              }else{
                $('#loanfee2').textbox('setValue',$('#loanfee22').val());
              }
              if($('#loanfee31').val()==1){
                  var percentage=($('#loanfee32').val()/100)*cleanamount;
                  $('#loanfee3').textbox('setValue',percentage);
              }else{
                $('#loanfee3').textbox('setValue',$('#loanfee32').val());
              }
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
$('#loanfee1').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
$('#loanfee2').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
$('#savings').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
$('#loanfee3').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
});
</script>