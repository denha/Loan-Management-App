@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlggroupmembers' toolbar='#groupmembers'><form id='frmgroupmembers'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>groupid</label></div><input type='text' class='form-control' name='groupid' 
 id='groupid' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>memberid</label></div><input type='text' class='form-control' name='memberid' 
 id='memberid' /></div>
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
<div style='padding:5px;' id='groupmembers' /><a href='javascript:void(0)' class='btn btn-primary'id='savegroupmembers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='groupmembers' iconCls='fa fa-table' singleSelect='true' url='viewgroupmembers' pagination='true' id='gridgroupmembers' method='get' fitColumns='true' style='width:100%' toolbar='#groupmemberstoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='groupid' width='100'>groupid</th>
<th field='memberid' width='100'>memberid</th>
<th field='created_at' width='100'>created_at</th>
<th field='updated_at' width='100'>updated_at</th>
</tr></thead>
</table>
<div id='groupmemberstoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newgroupmembers' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='editgroupmembers' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deletegroupmembers' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newgroupmembers').click(function(){
       $('#dlggroupmembers').dialog('open').dialog('setTitle','New groupmembers');
url='/savegroupmembers';
$('#frmgroupmembers').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editgroupmembers').click(function(){
       
 var row=$('#gridgroupmembers').datagrid('getSelected');
       $('#dlggroupmembers').dialog('open').dialog('setTitle','Edit groupmembers');

       $('#frmgroupmembers').form('load',row);
       url='/editgroupmembers/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savegroupmembers').click(function(){ 
var id=$('#id').val();
var groupid=$('#groupid').val();
var memberid=$('#memberid').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'groupid':groupid,'memberid':memberid,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlggroupmembers').dialog('close');
  
$('#gridgroupmembers').datagrid('reload');
});
//Auto generated code for deleting
$('#deletegroupmembers').click(function(){

    var a=$('#gridgroupmembers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridgroupmembers').datagrid('getSelected');
                $.ajax({
                 url:'/destroygroupmembers/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridgroupmembers').datagrid('reload');
            }

});
}
});

});
</script>