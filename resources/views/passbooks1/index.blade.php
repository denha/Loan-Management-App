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
<input  type="hidden" value="{{$bra}}" id="company1" name="company1" />
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgpassbooks' toolbar='#passbooks'><form id='frmpassbooks'>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><input type='text' style="height:34px;width:100%" data-options="onSelect:validateDate,fixComplete" required class='easyui-datebox form-control' name='pdate' 
 id='pdate' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Name</label></div><input type='text' style="height:34px;width:100%" required class='easyui-combobox form-control' name='memid' 
 id='memid' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>headerid</label></div><input type='text' class='form-control' name='headerid' 
 id='headerid' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>is New PassBook ?</label></div><select style="height:34px;width:100%" required class='easyui-combobox form-control' name='isNew' 
 id='isNew' >
 <option value=1>Yes </option>
 <option value=0>No</option>
 </select></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>is Funded ?</label></div><select style="height:34px;width:100%" required class='easyui-combobox form-control' name='isFunded' 
 id='isFunded' >
 <option value=1>Yes </option>
 <option value=0>No</option>
 </select></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Amount</label></div><input type='text' style="height:34px;width:100%" required class='easyui-textbox form-control' name='amount' 
 id='amount' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Passbook S/N</label></div><input type='text' style="height:34px;width:100%" required class='easyui-textbox form-control' name='pbsn' 
 id='pbsn' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Payment No</label></div><input type='text' style="height:34px;width:100%" required class='easyui-textbox form-control'  name='paymentno' 
 id='paymentno' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Proof of Payment </label></div>
 <div id="form-attachmen">
   <input  name="proof" id="proof"   style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>
<input id="headerid" type="hidden" name="headerid"/>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>created_at</label></div><input type='text' class='form-control' name='created_at' 
 id='created_at' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>updated_at</label></div><input type='text' class='form-control' name='updated_at' 
 id='updated_at' /></div>-->
 <input type="hidden" id="adminset" value="1"/>
</div>
<div style='padding:5px;' id='passbooks' /><a href='javascript:void(0)' class='btn btn-primary'id='savepassbooks'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' rowNumbers='true' showFooter="true"  striped='true' title='Passbook Issuance' iconCls='fa fa-table' singleSelect='true' url='viewpassbooks' pagination='true' id='gridpassbooks' method='get' fitColumns='true' style='width:100%' toolbar='#passbookstoolbar'>
<thead><tr>
<th field='id' hidden width='100'>id</th>
<th field='pdate' width='100'>Date</th>
<th field='memid'  hidden width='20'>Name</th>
<th field='name' width='180'>Name</th>
<th field='headerid' hidden  width='100'>headerid</th>
<th field='paymentno' width='50'>Payment No</th>
<th field='pbsn' width='50'>Passbk #</th>
<th field='isNew' hidden width='50'>isNew ?</th>
<th field='isNewB' width='50'>isNew ?</th>
<th field='isFunded' hidden width='50'>isFunded ?</th>
<th field='isFundedB' width='50'>isFunded ?</th>
<th field='amount' width='50'>Amount</th>

</tr></thead>
</table>
<div id='passbookstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newpassbooks' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editpassbooks' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletepassbooks' iconCls='icon-remove' > <i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a>
<label>Date</label>
<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>&nbsp;
@if(Auth::user()->branchid==1)

&nbsp;&nbsp;<label>Branch </label>&nbsp;<input  class='easyui-combobox ' style="width:20%;height:34px;" data-options="url:'combocompanys',method:'get',valueField:'id',textField:'name'" name='company' 
id='company' />
<input type="hidden" id="adminset" value="1"/>

&nbsp;
@endif 
<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find">Find</a> &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="loansch" name="find"><i class="fa fa-calendar"></i> View</a></div> </div>


{{csrf_field()}}
<script>
function validateDate(date){
$.getJSON('activeyear',function(data){
if(data==''){
$.messager.alert('Warning','Financial Period Not Set..Please set it and try again','warning');
$('#pdate').datebox('setValue','');

}else{
	$.each(data, function (index, value) {
		
var start= new Date(value.startperiod).getTime()/1000;
var end =new Date(value.endperiod).getTime()/1000;
var inputdate=date.getTime()/1000;
if(inputdate<start || inputdate>end){
var a=$.messager.alert('Warning','You can not enter a date that is not with in the Active Financial Period '+value.startperiod+ ' AND '+value.endperiod,'warning');
$('#pdate').datebox('setValue', '');
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
$('#find').click(function(){
   
   var branch=$('#company').val();
   var date1=$('#date1').val();
    var date2=$('#date2').val();
$('#gridpassbooks').datagrid({
method:'get',
queryParams:{branch:branch,date1:date1,date2:date2}

});

});
$('#isNew').combobox({
onChange:function(){
   if(this.value==0){
       $('#amount').textbox('setValue',0);
       $('#pbsn').textbox('setValue','N/A');
       $('#paymentno').textbox('setValue','N/A');
   }else{
    var row=$('#gridpassbooks').datagrid('getSelected');
    if(row==null){
        $('#amount').textbox('setValue','3,000');
       $('#pbsn').textbox('setValue','');
       $('#paymentno').textbox('setValue','');        
    }  
   }
}

});
$('#isFunded').combobox({
onChange:function(){
   if(this.value==1){
       $('#amount').textbox('setValue',0);
      // $('#pbsn').textbox('setValue','N/A');
       $('#paymentno').textbox('setValue','N/A');
   }else{
    var row=$('#gridpassbooks').datagrid('getSelected');
    if(row==null){
        $('#amount').textbox('setValue','3,000');
       $('#pbsn').textbox('setValue','');
       $('#paymentno').textbox('setValue','');        
    }  
   }
}

});
   $('#newpassbooks').click(function(){
validate=true;     
var ans= $('#adminset').val();
var company=$('#company').val();

if(ans==1){
    if(company==''){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Please Select the Branch'});

    }else{
        
        @if(Auth::user()->branchid==1)
        $('#dlgpassbooks').dialog('open').dialog('setTitle','New passbooks');
var bra=$('#company').val();
$('#memid').combobox({
url:'/registeredMembers/'+bra,
method:'get',
textField:'name',
valueField:'id',
});
      @endif
      url='/savepassbooks';
$('#frmpassbooks').form('clear');
    }
    }
    else{
        
        
 $('#dlgpassbooks').dialog('open').dialog('setTitle','New passbooks');
 
var bra=$('#company1').val();
$('#memid').combobox({
url:'/registeredMembers/'+bra,
method:'get',
textField:'name',
valueField:'id',
});

      url='/savepassbooks';
$('#frmpassbooks').form('clear');
    }

});

       //Auto Generated code for Edit Code
 $('#editpassbooks').click(function(){
 validate=false;
        $('#dlgpassbooks').dialog('open').dialog('setTitle','Edit passbooks');
      var row=$('#gridpassbooks').datagrid('getSelected');
       $('#frmpassbooks').form('load',row);
       url='/editpassbooks/'+row.id;
   
       });
//Auto Generated Code for Saving
$('#savepassbooks').click(function(){ 
var id=$('#id').val();
var pdate=$('#pdate').val();
var memid=$('#memid').val();
var headerid=$('#headerid').val();
var amount=$('#amount').val();
var isNew=$('#isNew').val();
var isFunded=$('#isFunded').val();
var pbsn=$('#pbsn').val();
var branch=$('#company').val();
var paymentno=$('#paymentno').val();
var proof = $('#proof').next().find('.textbox-value');

// Form Data for posting
var form_data = new FormData();
form_data.append('id',id);
form_data.append('pdate',pdate);
form_data.append('memid',memid);
form_data.append('headerid',headerid);
form_data.append('amount',amount);
form_data.append('isNew',isNew);
form_data.append('isFunded',isFunded);
form_data.append('pbsn',pbsn);
form_data.append('company',branch);
form_data.append('paymentno',paymentno);
form_data.append('proof', proof[0].files[0]);
form_data.append('_token', $('input[name=_token]').val());
$('#frmpassbooks').form('submit',{
				
				onSubmit:function(){

                    
					if($(this).form('validate')==true){
                        if(validate==true){
                            if(typeof proof[0].files[0]==='undefined'){
                                $.messager.alert('Warning','You must attached the proof of payment or Fund','warning');
                            }else{
                                $.ajax({
    cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'Post',
success:function(){
    $('#dlgpassbooks').dialog('close');
  
$('#gridpassbooks').datagrid('reload');
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
success:function(){
    $('#dlgpassbooks').dialog('close');
  
$('#gridpassbooks').datagrid('reload');
}
});
                        }
                    }
                }
});  

});
$('#proof').filebox({
    accept: 'image/*'
});
//Auto generated code for deleting
$('#deletepassbooks').click(function(){

    var a=$('#gridpassbooks').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridpassbooks').datagrid('getSelected');
                $.ajax({
                 url:'/destroypassbooks/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridpassbooks').datagrid('reload');
                 }
                });
                
            }

});
}
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
$('#pdate').datebox({
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
    $('#date2').datebox({
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
    $('#date1').datebox({
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
    $('#loansch').click(function(){
    var a=$('#gridpassbooks').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Info','Please select a Recored to View');
        
    }else{
    window.open('/passbookdetails/'+a.id);
    }

});
});
</script>