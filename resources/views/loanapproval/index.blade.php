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
<div class='easyui-dialog'  style='width:55%;height:140%;padding:5px;' closed='true'  id='dlgsuppliers' data-options="iconCls:'icon-save',resizable:true,modal:true" toolbar='#suppliers'>
<form id='loans'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Name</label></div><input  required class='easyui-combobox form-control' style="height:34px;width:100%;" data-options="url:'customerscombo',method:'get',valueField:'id',textField:'name'" name='name' 
 id='name' /></div>
</div>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><input required class='easyui-datebox form-control' data-options="onSelect:validateDate" style="height:34px;width:100%;" name='date' 
 id='date' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Loan Category</label></div><input style="height:34px;width:100%" required class='easyui-combobox form-control'  name='loancat' 
 id='loancat' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Loan Purpose</label></div><input required class='easyui-textbox form-control'  style="height:34px;width:100%;" name='gauranter' 
 id='gauranter' /></div>
</div>
<div class='col-lg-6'>
    <div class='form-group'>
    <div><label>Loan Amount</label></div><input required class='easyui-textbox form-control'  style="height:34px;width:100%;" id='amount' name='loancredit' /> 
  
    </div>
    
    </div>
    <div class='col-lg-6'>
<div class='form-group'>
<div><label>Interest Method</label></div><input style="height:34px;width:100%" required class='easyui-combobox form-control' data-options="url:'combointerestmethods',method:'get',valueField:'id',textField:'name'" name='method' 
 id='method' />
 </div>
</div>
    <div class='col-lg-6'>
<div class='form-group'>
<div><label>Loan Interest %</label></div><input required  class='easyui-numberbox form-control'  style="height:34px;width:100%;" name='interestrate' 
 id='interestrate' /></div>
</div>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Repay Period</label></div><input required class='easyui-numberbox form-control'  style="height:34px;width:50%;" name='loanrepay' 
 id='repay' /><input style="height:34px;width:50%" required class='easyui-combobox form-control' data-options="url:'combomodes',method:'get',valueField:'name',textField:'name'" name='mode' 
 id='mode' />
 </div>
</div>

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
<table class='easyui-datagrid' striped="true" showFooter="true" title='Loan Approvals' iconCls='fa fa-table' singleSelect='true' url='listloanapproval' pagination='true' id='gridsuppliers' method='get' fitColumns='true'  rownumbers='true' style='width:100%' toolbar='#supplierstoolbar'>
<thead><tr>
<th field='id' hidden>ID</th>
<th field='date' width='40'>Date</th>
<th field='name' width='100'>Name</th>
<th field='gname' width='70'>Group Name</th>
<th field='loaninterest' width='40'>InterestRate</th>
<th field='loanrepay' width='40'>RepayPeriod</th>
<th field='loa' hidden width='40'>Mode</th>
<!--<th field='collateral' width='40'>security</th>-->
<th field='status' hidden width='50'>Status</th>
<th field='loancredit' width='50'>LoanAmount</th>
<th field='loanid'  hidden="true" width='10'>Loanid</th>
<th field='memid' hidden="true" width='10'>Loanid</th>
<th field="headerid" hidden="true"  >Headerid </th>

</tr></thead>
</table>
<div id='supplierstoolbar'>


<label>Date</label>
<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>&nbsp;
@if(Auth::user()->branchid==1)

&nbsp;&nbsp;<label>Branch </label>&nbsp;<input  class='easyui-combobox ' style="width:20%;height:34px;" data-options="url:'combocompanys',method:'get',valueField:'id',textField:'name'" name='company' 
id='company' />

@endif
<!--<input class="easyui-combobox" id="branche" name="branche" data-options="url:'combobranches',valueField:'id',textField:'branchname',method:'get' "/>-->
&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="loansch" name="find"><i class="fa fa-calendar"></i> View</a>
 </div>

{{csrf_field()}}
<script>
 var url;
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
//Auto Generated code for New Entry Code
   $('#newsuppliers').click(function(){
       fixComplete();
       $('#dlgsuppliers').dialog('open').dialog('setTitle','New Loan Application');
      // $("#dlgsuppliers").panel("move",{top:$(document).scrollTop()+($(window).height()-height)*0.5});
           
url='/savesuppliers';
$('#loans').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editsuppliers').click(function(){
       
 var row=$('#gridsuppliers').datagrid('getSelected');
       $('#dlgsuppliers').dialog('open');
       $('#loans').form('load',row);
       url='/editsuppliers/'+row.loanid+'/'+row.headerid;
     
       
       
       });

//Auto Generated Code for Saving
$('#savesuppliers').click(function(){ 

var form_data = new FormData();
form_data.append('_token', $('input[name=_token]').val());

$('#loans').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){

$.ajax({
    dataType:'Text',
    cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'post',
success:function(data){
    if(data.results=="true"){
    $.messager.alert("Info","This Person has an exiting Loan. Loan Cannot be Disbursed ");
    }else{
        
        $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
      $('#gridsuppliers').datagrid('reload');
    }
}
});

$('#dlgsuppliers').dialog('close');
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
    window.open('/applicationlist/'+a.id);
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



});
</script>