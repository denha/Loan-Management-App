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
<center><h4>Group Details</h4></center>
<table  style="border:10px; width:400px; font-size:13px;" >
@foreach($details as $detail)
<tr>
<th><h5 ><b>Name &nbsp;&nbsp;&nbsp;:</b></h5> </th><th><h5>{{$detail->name}}</h5></th>
</tr>
<tr>
<th><h5><b>Leader&nbsp; :</b></h5></th><th><h5>{{$detail->leader}}</h5></th>
</tr>
@endforeach
</table>


<table class='easyui-datagrid' title=' ' striped="true" showFooter='true' rowNumbers="true"  singleSelect='true' url="/viewmembers/{{$id}}" pagination='true' id='gridgroups' method='get' fitColumns='true' style='width:100%' toolbar='#groupstoolbar'>
<thead><tr>
<th field='id' hidden  width='100'>id</th>
<th field='name' width='150'>Name</th>
<th field='memno' hidden width="20">memid</th>
<th field='bustype' width='150'>Business</th>
<th field='tel'   width='90'>Telephone</th>
<th field='loan' width='50'>Loan</th>
<th field='interestcredit' width='50'>Interest</th>
<th field='surcharge' width='50'>Surcharge</th>
<th field="loancredit"  width='50'>Total</th>

</tr></thead>
</table>
<div id='groupstoolbar'>
  </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
     
//Auto Generated code for New Entry Code
$('#memberid').combobox({
	url:'/customerscombo',
	valueField:'id',
	textField:'name',
    multiple:'true',
    'method':'get',



});
   $('#newgroups').click(function(){
       $('#dlggroups').dialog('open').dialog('setTitle','New groups');
url='/savegroups';
$('#frmgroups').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editgroups').click(function(){
       
 var row=$('#gridgroups').datagrid('getSelected');
       $('#dlggroups').dialog('open').dialog('setTitle','Edit groups');

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
$.ajax({
url:url,
method:'POST',
data:{'id':id,'name':name,'leader':leader,'memberid':memberid,'collector':collector,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(){
    $('#gridgroups').datagrid('reload');
}
});
  
$('#dlggroups').dialog('close');
  

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
$('#gridgroups').datagrid({
    
    onDblClickRow:function(){
        var a=$('#gridgroups').datagrid('getSelected');
        window.location='/viewgroupind/'+a.memno;
    }
})
// Button for view
$('#viewgroups').click(function(){
    var a=$('#gridgroups').datagrid('getSelected');
    window.location='viewgroup/'+a.id;
})
});
</script>