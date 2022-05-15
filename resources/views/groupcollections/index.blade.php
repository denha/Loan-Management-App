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
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlggroupcollections' toolbar='#groupcollections'><form id='frmgroupcollections'>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><input style="height:34px;width:100%" required type='text' data-options="onSelect:validateDate,fixComplete" class='easyui-datebox form-control' name='date' 
 id='date' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Group Name</label></div><input style="height:34px;width:100%" required type='text' class='easyui-combobox form-control' name='groupid' 
 id='groupid' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Amount <b>&nbsp;&nbsp;Bal :</b><b id="bal"> </b><b>&nbsp;&nbsp;&nbsp;Weekly :</b><b id="install"> </b></label></div><input type='text' style="height:34px;width:100%" required class='easyui-textbox form-control' name='amount' 
 id='amount' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Surcharge <b>&nbsp;&nbsp;Bal :</b><b id="sur"></b></label></div><input type='text' class='easyui-textbox form-control'  required style="height:34px;width:100%" name='surcharge' 
 id='surcharge' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Payment Details</label></div><input type='text' style="height:34px;width:100%" required class='easyui-textbox form-control' name='paymentdet' 
 id='paymentdet' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Proof of Payment </label></div>
 <div id="form-attachmen">
   <input  name="proof" id="proof"  style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Bankslip </label></div>
 <div id="form-attachmen">
   <input  name="paymentdet" id="paymentdet"  style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>
<input type="hidden" id="headno" name="headno"/>

<div style='padding:5px;' id='groupcollections' /><a href='javascript:void(0)' class='btn btn-primary'id='savegroupcollections'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' showFooter='true' rowNumbers='true' striped='true' title='Group Loan Collections' iconCls='fa fa-table' singleSelect='true' url='viewgroupcollections' pagination='true' id='gridgroupcollections' method='get' fitColumns='true' style='width:100%' toolbar='#groupcollectionstoolbar'>
<thead><tr>
<th field='id' hidden width='100'>id</th>
<th field='date' width='100'>Date</th>
<th field='groupid' hidden width='200'>Group</th>
<th field='name' width='200'>Group</th>
<th field='paymentdet' hidden width='100'>Payment Details</th>
<th field='amount' width='80'>Amount</th>
<th field='surcharge' width='80'>Surcharge</th>
<th field='total' width='80'>Total</th>
<th field='headno' hidden width='100'>HeaderNo</th>


</tr></thead>
</table>
<div id='groupcollectionstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newgroupcollections' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editgroupcollections' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletegroupcollections' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a>
&nbsp;<label>Date</label>
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
 id="loansch" name="find"><i class="fa fa-calendar"></i> View</a></div>

{{csrf_field()}}
<script>
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
 var url;
 var validate=false;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
$('#proof').filebox({
    accept: 'image/*'
});
$('#paymentdet').filebox({
    accept: 'image/*'
});
   $('#newgroupcollections').click(function(){
       validate=true;
       $('#dlggroupcollections').dialog('open').dialog('setTitle','New groupcollections');
url='/savegroupcollections';
$('#frmgroupcollections').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editgroupcollections').click(function(){
       validate=false;
 var row=$('#gridgroupcollections').datagrid('getSelected');
       $('#dlggroupcollections').dialog('open').dialog('setTitle','Edit groupcollections');

       $('#frmgroupcollections').form('load',row);
       url='/editgroupcollections/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savegroupcollections').click(function(){ 
var id=$('#id').val();
var groupid=$('#groupid').val();
var amount=$('#amount').val();
var surcharge=$('#surcharge').val();
var paymentdet=$('#paymentdet').next().find('.textbox-value');
var date=$('#date').val();
var headno=$('#headno').val();
var proof = $('#proof').next().find('.textbox-value');
var form_data = new FormData();
form_data.append('id',id);
form_data.append('groupid',groupid);
form_data.append('amount',amount);
form_data.append('surcharge',surcharge);
form_data.append('paymentdet',paymentdet[0].files[0]);
form_data.append('date',date);
form_data.append('headno',headno);
form_data.append('proof', proof[0].files[0]);
form_data.append('_token', $('input[name=_token]').val());
$('#frmgroupcollections').form('submit',{
				
				onSubmit:function(){

                    
					if($(this).form('validate')==true){
                        if(validate==true){
                            if(typeof proof[0].files[0]==='undefined'){
                                $.messager.alert('Warning','You must attach the proof of payment or Fund','warning');
                            }
                            else if(typeof paymentdet[0].files[0]==='undefined'){
                                $.messager.alert('Warning','You must attach bankslip or payment slip','warning');     
                            }else{
                                $.ajax({
cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'Post',
/*url:url,
method:'POST',
data:{'headno':headno,'id':id,'groupid':groupid,'amount':amount,'surcharge':surcharge,'paymentdet':paymentdet,'date':date,'updated_at':updated_at,'created_at':created_at,'_token':$('input[name=_token]').val()},*/
success:function(data){
    if(data.Loan=='No'){
        $.messager.alert('Warning','You are supposed to pay a total of '+data.figure+'... Please input the correct amount','warning');
    }else if(data.surcharge=='No'){
        $.messager.alert('Warning','You are supposed to pay a surcharge of '+data.figures+' Please input the correct amount','warning');
    }else if(data.half=='No'){
        $.messager.alert('Warning','The amount entered is not enough.. change or enter the exact amount','warning');
    }else{
    $('#dlggroupcollections').dialog('close');
  
$('#gridgroupcollections').datagrid('reload');
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
/*url:url,
method:'POST',
data:{'headno':headno,'id':id,'groupid':groupid,'amount':amount,'surcharge':surcharge,'paymentdet':paymentdet,'date':date,'updated_at':updated_at,'created_at':created_at,'_token':$('input[name=_token]').val()},*/
success:function(data){
    if(data.Loan=='No'){
        $.messager.alert('Warning','You are supposed to pay a total of '+data.figure+'... Please input the correct amount','warning');
    }else if(data.surcharge=='No'){
        $.messager.alert('Warning','You are supposed to pay a surcharge of '+data.figures+' Please input the correct amount','warning');
    }else if(data.half=='No'){
        $.messager.alert('Warning','The amount entered is not enough.. change or enter the exact amount','warning');
    }else{
    $('#dlggroupcollections').dialog('close');
  
$('#gridgroupcollections').datagrid('reload');
    }
}
});
                }
  
                    }
                }
});

});

//Auto generated code for deleting
$('#deletegroupcollections').click(function(){

    var a=$('#gridgroupcollections').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridgroupcollections').datagrid('getSelected');
                $.ajax({
                 url:'/destroygroupcollections/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridgroupcollections').datagrid('reload');
                 }
                });
              
            }

});
}
});
$('#amounts').textbox({
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
$('#groupid').combobox({
url:'/combogroups',
method:'get',
valueField:'id',
textField:'name',
onChange:function(){
    $.getJSON('groupbalance/'+$(this).combobox('getValue'),function(data){
        $('#bal').text(data.loanbal);
        $('#install').text(data.installments);
        $('#sur').text(data.surcharge);
    });   
}
});

$('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
   // var product=$('#product').val();
   // var branch=$('#branche').val();
    var branch=$('#company').val();
$('#gridgroupcollections').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2,branch:branch}

});

});
$('#loansch').click(function(){
    var a=$('#gridgroupcollections').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Info','Please select a Recored to View');
        
    }else{
    window.open('/paymentdetails/'+a.id);
    }

});
});
</script>