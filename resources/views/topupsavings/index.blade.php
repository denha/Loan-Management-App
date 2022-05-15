@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgtopupsavings' toolbar='#topupsavings'><form id='frmtopupsavings'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>headerid</label></div><input type='text' class='form-control' name='headerid' 
 id='headerid' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>loanid</label></div><input type='text' class='form-control' name='loanid' 
 id='loanid' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>intialSavings</label></div><input type='text' class='form-control' name='intialSavings' 
 id='intialSavings' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>savingpayment</label></div><input type='text' class='form-control' name='savingpayment' 
 id='savingpayment' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>created_at</label></div><input type='text' class='form-control' name='created_at' 
 id='created_at' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>updated_at</label></div><input type='text' class='form-control' name='updated_at' 
 id='updated_at' /></div>
</div>
<div style='padding:5px;' id='topupsavings' /><a href='javascript:void(0)' class='btn btn-primary'id='savetopupsavings'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='topupsavings' iconCls='fa fa-table' singleSelect='true' url='viewtopupsavings' pagination='true' id='gridtopupsavings' method='get' fitColumns='true' style='width:100%' toolbar='#topupsavingstoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='headerid' width='100'>headerid</th>
<th field='loanid' width='100'>loanid</th>
<th field='intialSavings' width='100'>intialSavings</th>
<th field='savingpayment' width='100'>savingpayment</th>
<th field='created_at' width='100'>created_at</th>
<th field='updated_at' width='100'>updated_at</th>
</tr></thead>
</table>
<div id='topupsavingstoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newtopupsavings' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='edittopupsavings' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deletetopupsavings' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newtopupsavings').click(function(){
       $('#dlgtopupsavings').dialog('open').dialog('setTitle','New topupsavings');
url='/savetopupsavings';
$('#frmtopupsavings').form('clear');
});

       //Auto Generated code for Edit Code
 $('#edittopupsavings').click(function(){
       
 var row=$('#gridtopupsavings').datagrid('getSelected');
       $('#dlgtopupsavings').dialog('open').dialog('setTitle','Edit topupsavings');

       $('#frmtopupsavings').form('load',row);
       url='/edittopupsavings/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savetopupsavings').click(function(){ 
var id=$('#id').val();
var headerid=$('#headerid').val();
var loanid=$('#loanid').val();
var intialSavings=$('#intialSavings').val();
var savingpayment=$('#savingpayment').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'headerid':headerid,'loanid':loanid,'intialSavings':intialSavings,'savingpayment':savingpayment,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlgtopupsavings').dialog('close');
  
$('#gridtopupsavings').datagrid('reload');
});
//Auto generated code for deleting
$('#deletetopupsavings').click(function(){

    var a=$('#gridtopupsavings').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridtopupsavings').datagrid('getSelected');
                $.ajax({
                 url:'/destroytopupsavings/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridtopupsavings').datagrid('reload');
            }

});
}
});

});
</script>