@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgcycles' toolbar='#cycles'><form id='frmcycles'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>cycle</label></div><input type='text' class='form-control' name='cycle' 
 id='cycle' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>memid</label></div><input type='text' class='form-control' name='memid' 
 id='memid' /></div>
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
<div style='padding:5px;' id='cycles' /><a href='javascript:void(0)' class='btn btn-primary'id='savecycles'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='cycles' iconCls='fa fa-table' singleSelect='true' url='viewcycles' pagination='true' id='gridcycles' method='get' fitColumns='true' style='width:100%' toolbar='#cyclestoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='cycle' width='100'>cycle</th>
<th field='memid' width='100'>memid</th>
<th field='created_at' width='100'>created_at</th>
<th field='updated_at' width='100'>updated_at</th>
</tr></thead>
</table>
<div id='cyclestoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newcycles' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='editcycles' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deletecycles' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newcycles').click(function(){
       $('#dlgcycles').dialog('open').dialog('setTitle','New cycles');
url='/savecycles';
$('#frmcycles').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editcycles').click(function(){
       
 var row=$('#gridcycles').datagrid('getSelected');
       $('#dlgcycles').dialog('open').dialog('setTitle','Edit cycles');

       $('#frmcycles').form('load',row);
       url='/editcycles/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savecycles').click(function(){ 
var id=$('#id').val();
var cycle=$('#cycle').val();
var memid=$('#memid').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'cycle':cycle,'memid':memid,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlgcycles').dialog('close');
  
$('#gridcycles').datagrid('reload');
});
//Auto generated code for deleting
$('#deletecycles').click(function(){

    var a=$('#gridcycles').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridcycles').datagrid('getSelected');
                $.ajax({
                 url:'/destroycycles/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridcycles').datagrid('reload');
            }

});
}
});

});
</script>