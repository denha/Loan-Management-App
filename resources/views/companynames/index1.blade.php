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
<div class='easyui-dialog'   style='width:50%;padding:5px;' closed='true' id='dlgcompanynames' toolbar='#companynames'>
<form id='frmcompanynames'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><input  style="height:34px;width:100%" data-options="onSelect:validateDate,fixComplete" required class='easyui-datebox form-control' name='date' 
 id='date' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Name</label></div><input style="height:34px;width:100%" required class='easyui-combobox form-control' data-options="url:'customerscombo',method:'get',valueField:'id',textField:'name'" name='name' 
 id='name' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Reciept No</label></div><input   required style="height:34px;width:100%" class='easyui-textbox form-control' name='paydet' 
 id='paydet' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Amount&nbsp;&nbsp; &nbsp;&nbsp;<b>LoanBal :</b><b id="loan"></b>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<b>Interest :</b> <b id="inter"></b></label></div><input   required style="height:34px;width:100%" class='easyui-textbox form-control' name='amount' 
 id='amount' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Surcharge&nbsp;&nbsp; &nbsp;&nbsp;<b>Surcharge :</b><b id="sur"></b></label></div><input   required style="height:34px;width:100%" class='easyui-textbox form-control' name='surcharge' 
 id='surcharge' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Group Name</label></div><input style="height:34px;width:100%" required type='text' class='easyui-combobox form-control' name='groupid' 
 id='groupid' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Proof of Payment </label></div>
 <div id="form-attachmen">
   <input  name="proof" id="proof"  style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>
<input type="hidden" id="memid" name="memid"/>
<input type="hidden"  id="lnid"   name="lnid"/><!--id-->
<input type="hidden"  id="loanid"   name="loanid"/>  


</form>
<div style='padding:5px;' id='companynames' /><a href='javascript:void(0)' class='btn btn-primary'id='savecompanynames'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table   showFooter="true" striped="true"  rowNumbers="true" class='easyui-datagrid' title='Loan Repayments' iconCls='fa fa-table' singleSelect='true' url='viewcompanynames' pagination='true' id='gridcompanynames' method='get' fitColumns='true' style='width:100%' toolbar='#companynamestoolbar'>
<thead><tr>
<th field='lnid' hidden  width='100' >id</th>
<th field='date' width='100'>Transcation Date</th>
<th field='name' width='230'>Name</th>
<th field='gname' width='250'>Group</th>
<th field='paydet' width='100'>Payment Details</th>
<th field='narration' width='230'>Particular</th>
<th field='loan' width='100'>Loan</th>
<th field='interestcredit' width='100'>Interest</th>
<th field='surcharge' width='100'>Surcharge</th>
<th field='loancredit' width='100'>Total</th>
<th field='memid' hidden="true" width='100'>Memember</th>
<th field='deleteloan' hidden  width='100'>Delloan</th>
<th  hidden="true" field='loanid' > loanId</th>
<th  hidden="true"  field='headerid' >Header</th>
<th field="isdelsec" hidden> DelSec </th>
<th field="idloan" hidden> Loanid </th>
<th field="gip" hidden>Group</th>

</tr></thead>
</table>
<div id='companynamestoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newcompanynames' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editcompanynames' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletecompanynames' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a>
<label>Date</label>
<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>&nbsp;
<!--<input class="easyui-combobox" id="branche" name="branche" data-options="url:'combobranches',valueField:'id',textField:'branchname',method:'get' "/>-->
&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="loansch" name="find"><i class="fa fa-calendar"></i> View</a> </div>

{{csrf_field()}}
<script>
 var url;
 
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
/*$('#groupid').combobox({
url:'/combogroups',
method:'get',
valueField:'id',
textField:'name',
onChange:function(){
    $.getJSON('groupbalance/'+$(this).combobox('getValue'),function(data){
        //$('#bal').text(data.loanbal);
       // $('#install').text(data.installments);
        //$('#sur').text(data.surcharge);
    });   
}
});*/
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
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newcompanynames').click(function(){
       fixComplete();
       $('#dlgcompanynames').dialog('open').dialog('setTitle','New Loan Repayments');
url='/savecompanynames';
$('#frmcompanynames').form('clear');
       
});
$('#loansch').click(function(){
    var a=$('#gridcompanynames').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Info','Please select a Recored to View');
        
    }else{
        
    window.open('/paymentdetails/'+a.gip+'/'+a.date);
    }

});

$('#name').combobox({
url:'/customerscombo',
method:'get',
valueField:'id',
textField:'name',
onChange:function(){
    $.getJSON('checkBalLn/'+$(this).combobox('getValue'),function(data){
    $.each(data, function (index, value) {
        $('#loan').text(value.loanpd1);
        $('#inter').text(value.loanin1);
        $('#sur').text(value.surcharge);


        }); 
    });
}


});
       //Auto Generated code for Edit Code
 $('#editcompanynames').click(function(){
      
 var row=$('#gridcompanynames').datagrid('getSelected');
 
       $('#dlgcompanynames').dialog('open').dialog('setTitle','Edit Loan Repayments');

       $('#frmcompanynames').form('load',row);
       url='/editcompanynames/'+row.headerid+'/'+row.deleteloan;
       
       
       });
//Auto Generated Code for Saving
$('#savecompanynames').click(function(){ 
    
var date=$('#date').val();
var name=$('#name').val();
var amount=$('#amount').val();
var paymentdetails=$('#paydet').val();
var surcharge=$('#surcharge').val();
var proof=$('#proof').next().find('.textbox-value');
//var groupid=$('#groupid').val();
var created_at="";
var updatated_at="";
var memid=$('#memid').val();
var lnid=$('#lnid').val();
var loanid=$('#loanid').val();
var form_data = new FormData();
form_data.append('date',date);
form_data.append('name',name);
form_data.append('paymentdetails',paymentdetails);
form_data.append('surcharge',surcharge);
form_data.append('amount',amount);
//form_data.append('groupid',groupid);
form_data.append('proof', proof[0].files[0]);
form_data.append('memid',memid);
form_data.append('lnid',lnid);
form_data.append('loanid',loanid);
form_data.append('_token', $('input[name=_token]').val());
$('#frmcompanynames').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){
                        $.ajax({
/*url:url,
method:'POST',
data:{'surcharge':surcharge,'date':date,'memid':memid,'lnid':lnid,'name':name,'amount':amount,'loanid':loanid,'paymentdetails':paymentdetails,'created_at':created_at,'updatated_at':updatated_at,'_token':$('input[name=_token]').val()},
*/
cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'Post',
success:function(data){
    if(data.groupinfo == true){
        $.messager.alert('Photo info','Attach a payment proof');
    }else{
        $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
    $('#gridcompanynames').datagrid('reload');
    }

}
});
  
$('#dlgcompanynames').dialog('close'); 
                    }
                }
            });

});
//Auto generated code for deleting
$('#deletecompanynames').click(function(){

    var a=$('#gridcompanynames').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridcompanynames').datagrid('getSelected');
                $('#frmcompanynames').form('load',row);
                $.ajax({
                 url:'/destroycompanynames/'+row.headerid+'/'+row.deleteloan+'/'+row.isdelsec+'/'+row.idloan,
                 method:'POST',
                 data:{'interestcredit':$('#interestcredit').val(),'id':row.lnid,'_token':$('input[name=_token]').val(),'isdelthird':$('#isdelthird').val(),'type1':$('#type1').val(),'type2':$('#type2').val(),'type3':$('#type3').val()},
                 success:function(data){
                    $('#gridcompanynames').datagrid('reload');

                 }
                });
                
            }

});
}
});
$('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
   // var product=$('#product').val();
    var branch=$('#branche').val();
$('#gridcompanynames').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2,branch:branch}

});
});
$('#amount').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
$('#surcharge').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
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
});
</script>