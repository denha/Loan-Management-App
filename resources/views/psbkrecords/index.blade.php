@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgpsbkrecords' toolbar='#psbkrecords'><form id='frmpsbkrecords'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>branch</label></div><input type='text' class='form-control' name='branch' 
 id='branch' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>pbkno</label></div><input type='text' class='form-control' name='pbkno' 
 id='pbkno' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>sn</label></div><input type='text' class='form-control' name='sn' 
 id='sn' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>isNew</label></div><input type='text' class='form-control' name='isNew' 
 id='isNew' /></div>
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
<div style='padding:5px;' id='psbkrecords' /><a href='javascript:void(0)' class='btn btn-primary'id='savepsbkrecords'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='psbkrecords' iconCls='fa fa-table' singleSelect='true' url='viewpsbkrecords' pagination='true' id='gridpsbkrecords' method='get' fitColumns='true' style='width:100%' toolbar='#psbkrecordstoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='branch' width='100'>branch</th>
<th field='pbkno' width='100'>pbkno</th>
<th field='sn' width='100'>sn</th>
<th field='isNew' width='100'>isNew</th>
<th field='created_at' width='100'>created_at</th>
<th field='updated_at' width='100'>updated_at</th>
</tr></thead>
</table>
<div id='psbkrecordstoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newpsbkrecords' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='editpsbkrecords' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deletepsbkrecords' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newpsbkrecords').click(function(){
       $('#dlgpsbkrecords').dialog('open').dialog('setTitle','New psbkrecords');
url='/savepsbkrecords';
$('#frmpsbkrecords').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editpsbkrecords').click(function(){
       
 var row=$('#gridpsbkrecords').datagrid('getSelected');
       $('#dlgpsbkrecords').dialog('open').dialog('setTitle','Edit psbkrecords');

       $('#frmpsbkrecords').form('load',row);
       url='/editpsbkrecords/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savepsbkrecords').click(function(){ 
var id=$('#id').val();
var branch=$('#branch').val();
var pbkno=$('#pbkno').val();
var sn=$('#sn').val();
var isNew=$('#isNew').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'branch':branch,'pbkno':pbkno,'sn':sn,'isNew':isNew,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlgpsbkrecords').dialog('close');
  
$('#gridpsbkrecords').datagrid('reload');
});
//Auto generated code for deleting
$('#deletepsbkrecords').click(function(){

    var a=$('#gridpsbkrecords').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridpsbkrecords').datagrid('getSelected');
                $.ajax({
                 url:'/destroypsbkrecords/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridpsbkrecords').datagrid('reload');
            }

});
}
});

});
</script>