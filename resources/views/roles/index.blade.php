@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgroles' toolbar='#roles'><form id='frmroles'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>name</label></div><input type='text' class='form-control' name='name' 
 id='name' /></div>
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
<div style='padding:5px;' id='roles' /><a href='javascript:void(0)' class='btn btn-primary'id='saveroles'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='roles' iconCls='fa fa-table' singleSelect='true' url='viewroles' pagination='true' id='gridroles' method='get' fitColumns='true' style='width:100%' toolbar='#rolestoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='name' width='100'>name</th>
<th field='created_at' width='100'>created_at</th>
<th field='updated_at' width='100'>updated_at</th>
</tr></thead>
</table>
<div id='rolestoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newroles' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='editroles' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deleteroles' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newroles').click(function(){
       $('#dlgroles').dialog('open').dialog('setTitle','New roles');
url='/saveroles';
$('#frmroles').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editroles').click(function(){
       
 var row=$('#gridroles').datagrid('getSelected');
       $('#dlgroles').dialog('open').dialog('setTitle','Edit roles');

       $('#frmroles').form('load',row);
       url='/editroles/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#saveroles').click(function(){ 
var id=$('#id').val();
var name=$('#name').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'name':name,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlgroles').dialog('close');
  
$('#gridroles').datagrid('reload');
});
//Auto generated code for deleting
$('#deleteroles').click(function(){

    var a=$('#gridroles').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridroles').datagrid('getSelected');
                $.ajax({
                 url:'/destroyroles/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridroles').datagrid('reload');
            }

});
}
});

});
</script>