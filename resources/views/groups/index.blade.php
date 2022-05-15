@include('layouts/header')
\<style>
.datagrid-row-alt{
    background-color: #d9f2e7;

}
.datagrid-row-selected {
  background: #009900;
  color: white;
}

</style>

<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlggroups' toolbar='#groups'><form id='frmgroups'>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Group Name</label></div><input required style="width:100%;height:34px;" class='easyui-textbox form-control' name='name' 
 id='name' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Group leader</label></div><input required  style="width:100%;height:34px;" class='easyui-textbox form-control' name='leader' 
 id='leader' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Members</label></div><input required style="width:100%;height:34px;" class='easyui-combobox form-control' name='memberid' 
 id='memberid' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Collector</label></div><input style="width:100%;height:34px;"' class='easyui-textbox form-control' name='collector' 
 id='collector' /></div>
</div>-->

<div style='padding:5px;' id='groups' /><a href='javascript:void(0)' class='btn btn-primary'id='savegroups'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='Borrowers Group ' striped="true" rowNumbers="true" iconCls='fa fa-table' singleSelect='true' url='viewgroups' pagination='true' id='gridgroups' method='get' fitColumns='true' style='width:100%' toolbar='#groupstoolbar'>
<thead><tr>
<th field='id' hidden  width='100'>id</th>
<th field='name' width='40'> Group Name</th>
<th field='leader' width='50'>Group Leader</th>
<th field='memberid' hidden  width='100'>memberid</th>
<th field='collector' width='200'>Group Members</th>
<th field="viewbtn" hidden width='10'> Action</th>
<th field="total" hidden  width='10'> Action</th>

</tr></thead>
</table>
<div id='groupstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newgroups' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editgroups' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletegroups' iconCls='icon-remove' > Delete</a>
<a href='javascript:void(0)' class='btn btn-primary' id='viewgroups' iconCls='icon-remove' > View</a> 
@if(Auth::user()->branchid==1)

&nbsp;&nbsp;<label>Branch </label>&nbsp;<input  class='easyui-combobox ' style="width:20%;height:34px;" data-options="url:'combocompanys',method:'get',valueField:'id',textField:'name'" name='company' 
id='company' />
<input type="hidden" id="adminset" value="1"/>
<a href='javascript:void(0)' class='btn btn-primary ' id='find' ><i class="fa fa-search" aria-hidden="true"></i>Find</a>
@endif
 </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
    $('#gridgroups').datagrid({
    rowStyler:function (index, row) {
      
        
			if (parseInt(row.total)>1) {
                
				return 'background-color:rgb(255, 0, 71);';//rgb(209, 91, 71)
			}
		}
});

$('#gridgroups').datagrid({
        pageSize:150,
        pageList:[30,60,90,120,150],


    });
//Auto Generated code for New Entry Code
$('#memberid').combobox({
	url:'/customerscombo',
	valueField:'id',
	textField:'name',
    multiple:'true',
    'method':'get',
   



});
   $('#newgroups').click(function(){


var ans= $('#adminset').val();
var company=$('#company').val();

if(ans==1){
    if(company==''){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Please Select the Branch'});

    }else{
        $('#dlggroups').dialog('open').dialog('setTitle','New groups');
        @if(Auth::user()->branchid==1)
var bra=$('#company').val();
$('#memberid').combobox({
url:'/customerscomboBranch/'+bra,
method:'get',
textField:'name',
valueField:'id',


});
      @endif
url='/savegroups';
$('#frmgroups').form('clear');
    }
    }else{
        $('#dlggroups').dialog('open').dialog('setTitle','New groups');
        @if(Auth::user()->branchid==1)
var bra=$('#company').val();
$('#memberid').combobox({
url:'/customerscomboBranch/'+bra,
method:'get',
textField:'name',
valueField:'id',

});
      @endif
url='/savegroups';
$('#frmgroups').form('clear');
    }
});

       //Auto Generated code for Edit Code
 $('#editgroups').click(function(){

 var row=$('#gridgroups').datagrid('getSelected');
       $('#dlggroups').dialog('open').dialog('setTitle','Edit groups');
       @if(Auth::user()->branchid==1)
var bra=$('#company').val();
$('#memberid').combobox({
url:'/customerscomboBranch/'+bra,
method:'get',
textField:'name',
valueField:'id',

});
      @endif
       $('#frmgroups').form('load',row);
       url='/editgroups/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savegroups').click(function(){ 
var id=$('#id').val();
var name=$('#name').val();
var leader=$('#leader').val();
var memberid=$('#memberid').val();
var collector=$('#collector').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
var branch=$('#company').val();

$('#frmgroups').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){
$.ajax({
url:url,
method:'POST',
data:{'branch':branch,'id':id,'name':name,'leader':leader,'memberid':memberid,'collector':collector,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(data){
    if(data.result=="exits"){
        $.messager.alert({title:'Warning',icon:'warning',msg:'One of the Member selected Exists in another group, Select and try again'});
    }else{
        $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
      $('#gridgroups').datagrid('reload');
    }
    //$('#gridgroups').datagrid('reload');
}
});
  
$('#dlggroups').dialog('close');
  
                    }
                }
});
});
//Auto generated code for deleting
$('#deletegroups').click(function(){

    var a=$('#gridgroups').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridgroups').datagrid('getSelected');
                $.ajax({
                 url:'/destroygroups/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridgroups').datagrid('reload');
                 }
                });
                
            }

});
}
});
$('.view').click(function(){
alert('yes');

});

// Button for view
$('#viewgroups').click(function(){
    var a=$('#gridgroups').datagrid('getSelected');
    window.location='viewgroup/'+a.id;
})
$('#find').click(function(){
    var findname=$('#findname').val();
    var branch=$('#company').val();
$('#gridgroups').datagrid({
method:'get',
queryParams:{findname:findname,branch:branch}

});

});
});
</script>