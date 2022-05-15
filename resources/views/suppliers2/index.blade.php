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
<input id="officername" hidden  value="{{$officername}}" />
<input id="officerid" hidden  value="{{$officeid}}" />
<div class='easyui-dialog'  style='width:55%;height:140%;padding:5px;' closed='true'  id='dlgsuppliers' data-options="iconCls:'icon-save',resizable:true,modal:true" toolbar='#suppliers'>
<form id='loans'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Name</label></div><input  required class='easyui-combobox form-control' style="height:34px;width:100%;" 
@if(Auth::user()->branchid==1)
 name='memid'  id='name'
@else
data-options="url:'customerscombo',method:'get',valueField:'id',textField:'name'" name='memid'  id='name'
@endif
 /></div>
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
<div><label>Loan Purpose</label></div><input required class='easyui-textbox form-control'  style="height:34px;width:100%;" name='guanter' 
 id='purpose' /></div>
</div>
<div class='col-lg-6'>
    <div class='form-group'>
    <div><label>Loan Amount</label></div><input required class='easyui-textbox form-control'  style="height:34px;width:100%;" id='amount' name='loancredit' /> 
  
    </div>
    
    </div>
    <div class='col-lg-6'>
<div class='form-group'>
<div><label>Interest Method</label></div><input style="height:34px;width:100%" readonly required class='easyui-combobox form-control'  name='method' 
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
 id='repay' /><input style="height:34px;width:50%" required class='easyui-combobox form-control' readonly data-options="url:'combomodes',method:'get',valueField:'name',textField:'name'" name='mode' 
 id='mode' />
 </div>
</div>



<div class='col-lg-6'>
<div class='form-group'>
<div><label>Details of Security</label></div><input type='text' required style="height:34px;width:100%"  class='easyui-textbox form-control' name='collateral' 
 id='collateral' /></div>
</div>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>is Loan Application Fee ?</label></div><select  required style="height:34px;width:100%"  class='easyui-combobox form-control' name='isApplication' 
 id='isApplication' >
 <option value="1">Yes</option>
 <option value="2">No</option>
 </select> </div>
</div>

@foreach($loanfees as $fees)
<div class='col-lg-6'>
<div class='form-group'>
<div><label>{{$fees->name}}</label></div><input required class='easyui-textbox form-control'  style="height:34px;width:100%;" name="{{$fees->feevar}}"
 id="{{$fees->feevar}}" /></div>
</div>
@endforeach
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Sme Officer</label></div><input style="height:34px;width:100%" required class='easyui-textbox form-control'  name='loanofficer' 
 id='loanofficer' readonly /></div>
</div>
<!--<center> Loan Fees
<center> Attachments</center></center>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Guarantors Agreement</label></div>
 <div id="form-attachmen">
   <input  name="agreement" id="agreement"   style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Proof of Business </label></div>
 <div id="form-attachmen">
   <input  name="proof" id="proof"   style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Chairman Consent </label></div>
 <div id="form-attachmen">
   <input  name="chairman" id="chairman"   style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Verified Security</label></div>
 <div id="form-attachmen">
   <input  name="security" id="security"   style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>

<input type="hidden" id="headerno" name='headno'/>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>National ID</label></div>
 <div id="form-attachmen">
   <input  name="nationalid" id="nationalid"  style="height:34px;width:100%" class="easyui-filebox form-control" />
</div>
</div>
</div>


<hr>
<input type="hidden" id="memid" name="memid"/>

</div>

</form>
@foreach($loanfees as $fees)
<input type="hidden"  id="{{$fees->feevar}}1"  value="{{$fees->isPercent}}"/>
<input type="hidden"  id="{{$fees->feevar}}2"  value="{{$fees->amount}}"/>
@endforeach
<div style='padding:5px;' id='suppliers' /><a href='javascript:void(0)' class='btn btn-primary'id='savesuppliers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' id="close" class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' striped="true" showFooter="true" title='Loan Application' iconCls='fa fa-table' singleSelect='true' url='viewapplication' pagination='true' id='gridsuppliers' method='get' fitColumns='true'  rownumbers='true' style='width:100%' toolbar='#supplierstoolbar'>
<thead><tr>
<th field='id' hidden >ID</th>
<th field='date' width='40'>Date</th>
<th field='name' width='100'>Name</th>
<th field='gname' width='70'>Group Name</th>
<th field='loaninterest' width='30'>Rate (%)</th>
<th field='loanrepay' width='30'>Period</th>
<th field='loa' hidden width='40'>Mode</th>
<th field='collateral'hidden  width='40'>security</th>
<th field='guanter' hidden>Loan purpose</th>
<th field='status' width='40'>Status</th>
<th field='rejectrsn' width='50'>Reason</th>
<th field='loancredit' width='50'>LoanAmount</th>
<th field='approveamt' width='50'>Approved Amt</th>
<th field='loanid'  hidden="true" width='10'>Loanid</th>
<th field='memid' hidden="true" width='10'>Loanid</th>
<th field="headerid" hidden="true"  >Headerid </th>
<th field="loanofficer" hidden> </th>
<th field="proofofbiz" hidden  >Headerid </th>
<th field='headno' hidden>Hdno</th>

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
 id="loansch" name="find"><i class="fa fa-calendar"></i> View</a>
 </div>

{{csrf_field()}}
<script>

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
    $('#nationalid').filebox({
    accept: 'image/*'
});
$('#security').filebox({
    accept: 'image/*'
});
$('#chairman').filebox({
    accept: 'image/*'
});
$('#proof').filebox({
    accept: 'image/*'
});
$('#agreement').filebox({
    accept: 'image/*'
});
    var url;
    var validate=false;
    // Application changes
    $('#isApplication').combobox({
        onChange:function(){
            if(this.value==1){
               $('#loanfee1').textbox('setValue',2000); 
            }else{
                $('#loanfee1').textbox('setValue',0);     
            }
        }
    })
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
        $('#loans').form('clear');
        $('#dlgsuppliers').dialog('open').dialog('setTitle','New Loan Application');
        url='/saveloanapp';
var bra=$('#company').val();
$('#name').combobox({
url:'/customerscomboBranch/'+bra,
method:'get',
textField:'name',
valueField:'id',

});
$('#method').combobox({
url:'/combointerestmethods',
method:'get',
valueField:'id',
textField:'name',
onLoadSuccess:function(){
    $('#method').combobox('select',2);
}
    });
// setting Default Repayment period to months
$('#mode').combobox({
url:'/combomodes',
method:'get',
valueField:'id',
textField:'name',
onLoadSuccess:function(){
    $('#mode').combobox('select',"Month");
}
    });

    }
    }else{
        $('#loans').form('clear');
        $('#dlgsuppliers').dialog('open').dialog('setTitle','New Loan Application');
url='/saveloanapp';
        var bra=$('#company').val();
$('#name').combobox({
    url:'/customerscomboBranch/'+bra,
method:'get',
textField:'name',
valueField:'id',

});
$('#close').click(function(){
$('#dlgsuppliers').dialog('close');
});
$('#method').combobox({
url:'/combointerestmethods',
method:'get',
valueField:'id',
textField:'name',
onLoadSuccess:function(){
    $('#method').combobox('select',2);
}
    });
// setting Default Repayment period to months
$('#mode').combobox({
url:'/combomodes',
method:'get',
valueField:'id',
textField:'name',
onLoadSuccess:function(){
    $('#mode').combobox('select',"Month");
}
    });
    }
    $('#loanofficer').textbox('setValue',$('#officername').val());
});

       //Auto Generated code for Edit Code
       $('#editsuppliers').click(function(){
           validate=false;
        $('#dlgsuppliers').dialog('move', {
   //left: 280,
   top: 100
});
        var row=$('#gridsuppliers').datagrid('getSelected');
        url='/updateapp/'+row.id;
       
             $('#dlgsuppliers').dialog('open');
             $('#loans').form('load',row);

             });
             $('#dlgsuppliers').dialog('move', {
   //left: 280,
   top: 100
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
var purpose=$('#purpose').val();
var collateral=$('#collateral').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
var paydet=$('#paydet').val();
var method=$('#method').val();
var loancat=$('#loancat').val();
var loanrepay=$('#loanrepay').val();
var headerno=$('#headerno').val();
var loanfee1=$('#loanfee1').val();
var loanfee2=$('#loanfee2').val();
var loanfee3=$('#loanfee3').val();
var loanofficer=$('#loanofficer').val();
var officerid=$('#officerid').val();
var form_data = new FormData();
var agr = $('#agreement').next().find('.textbox-value');
var pro = $('#proof').next().find('.textbox-value');
var cha = $('#chairman').next().find('.textbox-value');
var sec = $('#security').next().find('.textbox-value');
var nat = $('#nationalid').next().find('.textbox-value');
form_data.append('agreement', agr[0].files[0]);
form_data.append('proof', pro[0].files[0]);
form_data.append('chairman', cha[0].files[0]);
form_data.append('security', sec[0].files[0]);
form_data.append('nationalid', nat[0].files[0]);
form_data.append('id', id);
form_data.append('name', name);
form_data.append('branch', branch);
form_data.append('amount', amount);
form_data.append('mode', mode);
form_data.append('security', security);
form_data.append('interest', interest);
form_data.append('date', date);
form_data.append('repay', repay);
form_data.append('memid', memid);
form_data.append('purpose', purpose);
form_data.append('paydet', paydet);
form_data.append('method', method);
form_data.append('collateral',collateral);
form_data.append('loancat', loancat);
form_data.append('loanrepay', loanrepay);
form_data.append('loanfee1', loanfee1);
form_data.append('loanfee2', loanfee2);
form_data.append('loanfee3', loanfee3);
form_data.append('loanofficer',loanofficer);
form_data.append('officerid',officerid);
form_data.append('headerno',headerno);
form_data.append('_token', $('input[name=_token]').val());

$('#loans').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){
                        if(validate==true){
                            if(typeof agr[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Agreement must be attached','warning');
                            }else if(typeof pro[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Business Proof must be attached ','warning');
                            }
                            else if(typeof cha[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Chairment consent must be attached ','warning');
                            }
                            else if(typeof sec[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Verified security must be attached ','warning');
                            }
                            else if(typeof nat[0].files[0]==='undefined'){
                                $.messager.alert('Warning','National ID must be attached ','warning');
                            }else{

                                $.ajax({
   // dataType:'json',
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
    else if(data.member=="No"){
        $.messager.alert({title:'Warning',icon:'warning',msg:'This Person doesnot belong to any Group. Assign Him / Her then try again..'});
           // $.messager.alert("Info","This Person doesnot belong to any Group. Assign Him / Her then try again..");
        }
        else if(data.funded=="yes"){
            $.messager.alert({title:'Warning',icon:'warning',msg:'This Person was entered as Funded, Please first enter His / Her Personal Information to continue'});    
        }
        else if(data.rights=="no"){
            $.messager.alert({title:'Warning',icon:'warning',msg:'You have no rights to edit a submitted Application.'});    
        }
        else{
        $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
	  
$('#dlgsuppliers').dialog('close');
      $('#gridsuppliers').datagrid('reload');
        }
        
      
    
}
});
                            }
                        }else{

$.ajax({
   // dataType:'json',
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
    else if(data.member=="No"){
        $.messager.alert({title:'Warning',icon:'warning',msg:'This Person doesnot belong to any Group. Assign Him / Her then try again..'});
           // $.messager.alert("Info","This Person doesnot belong to any Group. Assign Him / Her then try again..");
        }
        else if(data.funded=="yes"){
            $.messager.alert({title:'Warning',icon:'warning',msg:'This Person was entered as Funded, Please first enter His / Her Personal Information to continue'});    
        }
        else if(data.rights=="no"){
            $.messager.alert({title:'Warning',icon:'warning',msg:'You have no rights to edit a submitted Application.'});    
        }
        else{
        $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
	  
$('#dlgsuppliers').dialog('close');
      $('#gridsuppliers').datagrid('reload');
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
                 url:'/delapplication',
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(data){
                     if(data.del=='No'){
                        $.messager.alert("Warning","You cannot delete an Application which has been Approved",'Warning');
                     }
                     else if(data.rights=="no"){
        $.messager.alert({title:'Warning',icon:'warning',msg:'You dont have enough rights to delete this record '});
           // $.messager.alert("Info","This Person doesnot belong to any Group. Assign Him / Her then try again..");
        }else{
                        $('#gridsuppliers').datagrid('reload');
                     }
                    
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
    window.open('/applicationdetails/'+a.id);
    }

});
$('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
   // var product=$('#product').val();
   // var branch=$('#branche').val();
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