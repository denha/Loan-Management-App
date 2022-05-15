@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlggrouppenaltys' toolbar='#grouppenaltys'><form id='frmgrouppenaltys'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>penalty</label></div><input type='text' class='form-control' name='penalty' 
 id='penalty' /></div>
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
<div><label>date</label></div><input type='text' class='form-control' name='date' 
 id='date' /></div>
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
<div style='padding:5px;' id='grouppenaltys' /><a href='javascript:void(0)' class='btn btn-primary'id='savegrouppenaltys'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='grouppenaltys' iconCls='fa fa-table' singleSelect='true' url='viewgrouppenaltys' pagination='true' id='gridgrouppenaltys' method='get' fitColumns='true' style='width:100%' toolbar='#grouppenaltystoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='penalty' width='100'>penalty</th>
<th field='groupid' width='100'>groupid</th>
<th field='memberid' width='100'>memberid</th>
<th field='date' width='100'>date</th>
<th field='created_at' width='100'>created_at</th>
<th field='updated_at' width='100'>updated_at</th>
</tr></thead>
</table>
<div id='grouppenaltystoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newgrouppenaltys' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='editgrouppenaltys' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deletegrouppenaltys' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newgrouppenaltys').click(function(){
       $('#dlggrouppenaltys').dialog('open').dialog('setTitle','New grouppenaltys');
url='/savegrouppenaltys';
$('#frmgrouppenaltys').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editgrouppenaltys').click(function(){
       
 var row=$('#gridgrouppenaltys').datagrid('getSelected');
       $('#dlggrouppenaltys').dialog('open').dialog('setTitle','Edit grouppenaltys');

       $('#frmgrouppenaltys').form('load',row);
       url='/editgrouppenaltys/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savegrouppenaltys').click(function(){ 
var id=$('#id').val();
var penalty=$('#penalty').val();
var groupid=$('#groupid').val();
var memberid=$('#memberid').val();
var date=$('#date').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'penalty':penalty,'groupid':groupid,'memberid':memberid,'date':date,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlggrouppenaltys').dialog('close');
  
$('#gridgrouppenaltys').datagrid('reload');
});
//Auto generated code for deleting
$('#deletegrouppenaltys').click(function(){

    var a=$('#gridgrouppenaltys').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridgrouppenaltys').datagrid('getSelected');
                $.ajax({
                 url:'/destroygrouppenaltys/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridgrouppenaltys').datagrid('reload');
            }

});
}
});

});
</script>