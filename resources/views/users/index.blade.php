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
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgusers' toolbar='#users'><form id='frmusers'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Username</label></div><input required  type='text' class='easyui-textbox form-control' name='name' 
 id='name' style="width:100%;height:36px;"/></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Email</label></div><input  required type='text' class='easyui-textbox form-control' name='email' 
 id='email' style="width:100%;height:36px;" /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Password</label></div><input required  type='text' class='easyui-passwordbox form-control' name='password3' 
 id='password' style="width:100%;height:36px;" /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Confirm Password</label></div><input required  type='text' class='easyui-passwordbox form-control' name='cpassword' 
 id='cpassword' style="width:100%;height:36px;" /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>User Roles</label></div><input  required  class='easyui-combobox form-control' name='admin' 
 id='roles' data-options="url:'/comboroles',method:'get',valueField:'id',textField:'name'" style="width:100%;height:36px;" />

 </div>
</div>
@if(Auth::user()->branchid==1)
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Branch</label></div>
<input required style="width:100%;height:36px" class='easyui-combobox form-control' style="width:20%;height:34px;" data-options="url:'combocompanys',method:'get',valueField:'id',textField:'name'" name='company' 
id='company' /></div>
</div>
@endif
 
<span style="color:red">  </span>
 </div>
 
</div>

<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>created_at</label></div><input type='text' class='form-control' name='created_at' 
 id='created_at' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>updated_at</label></div><input type='text' class='form-control' name='updated_at' 
 id='updated_at' /></div>
</div>-->
<div style='padding:5px;' id='users' /><a href='javascript:void(0)' class='btn btn-primary'id='saveusers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table  striped="true" rowNumbers="true"class='easyui-datagrid' title='User Management' iconCls='fa fa-table' singleSelect='true' url='viewusers' pagination='true' id='gridusers' method='get' fitColumns='true' style='width:100%' toolbar='#userstoolbar'>
<thead><tr>
<th field='userid' hidden="true" width='100'>Userid</th>
<th field="id" hidden> id </th>
<th field='name' width='100'>Name</th>
<th field='email' width='100'>Email</th>
<th field='level'  width='100'>Level</th>
@if(Auth::user()->branchid==1)
<th field='cname'  width='100'>Branch Name</th>
@endif

</tr></thead>
</table>
<div id='userstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newusers' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i>  New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editusers' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deleteusers' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a> </div>

{{csrf_field()}}
<script>
function isUpper(str) {
    return !/[a-z]/.test(str) || /[A-Z]/.test(str);
}
function hasNumbers(t)
{
var regex = /\d/g;
return regex.test(t);
}
function Nonnumerical(x){
return  !isNaN(parseFloat(x)) && !isNaN(n-0);
   
}
function checkPasswordComplexity(pwd) {
    if(pwd.match(/[^a-z0-9]+/i)==null){
return false;
    }else{
        return true;
    }
}
function isUpperCase(c) {
    return !!c && c != c.toLocaleLowerCase();
}
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newusers').click(function(){
       $('#dlgusers').dialog('open').dialog('setTitle','New users');
url='/saveusers';
$('#frmusers').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editusers').click(function(){
       
 var row=$('#gridusers').datagrid('getSelected');
       $('#dlgusers').dialog('open').dialog('setTitle','Edit users');

       $('#frmusers').form('load',row);
       url='/editusers/'+row.id;
       
       
       });
       /*("input", $("#password").next("span")).mouseleave(function () {
        //console.log($(this).find('input').last().val());
        var password=$('#password').val();
      
       /* if(password.length<9 && password!=''){
            alert('passwords must be 6 characters long');
        }else if(isUpper(password)==false && password!=''){
            alert('You must include a Capital letter in your Password');
        }else if(hasNumbers(password)==false && password!=''){
            alert('Your password must contain atleast one number');
        }
    });*/
//Auto Generated Code for Saving
$('#saveusers').click(function(){ 
var id=$('#id').val();
var name=$('#name').val();
var email=$('#email').val();
var password=$('#password').val();
var cpassword=$('#cpassword').val();
var roles=$("#roles").val();
var remember_token=$('#remember_token').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
var branch=$('#company').val();
//alert(roles);

if(password!=cpassword){
$.messager.alert('Warning','Passwords dont match, Please try again', 'warning');
}
else if(password.length<6){
    $.messager.alert('Warning','Password must be atleast 6 characters long, Please try again', 'warning');
}
else if(isUpperCase(password)==false){
    $.messager.alert('Warning','Password must contain atleast one capital letter, Please try again', 'warning');
}
else if(hasNumbers(password)==false){
    $.messager.alert('Warning','Password must contain atleast one number, Please try again', 'warning');
}
else if(checkPasswordComplexity(password)==false){
$.messager.alert('Warning','Password must contain atleast one Non-numerical character , Please try again', 'warning');
 }else{
    $('#frmusers').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){
                        
$.ajax({
url:url,
method:'POST',
data:{'cpassword':cpassword,'id':id,'name':name,'email':email,'password':password,'roles':roles,'branch':branch,'remember_token':remember_token,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(data){
    if(data.email=='exist'){
        $.messager.alert('Warning','Email Address is already in use, Please  use another email and try again', 'warning');

    }else{
    $('#gridusers').datagrid('reload');
    $('#dlgusers').dialog('close');
    }
}
});
                        
  

                    
                    }
                }
    });


  
 }
});
//Auto generated code for deleting
$('#deleteusers').click(function(){

    var a=$('#gridusers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridusers').datagrid('getSelected');
                $.ajax({
                 url:'/destroyusers/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridusers').datagrid('reload');

                 }
                });
               
            }

});
}
});

});
</script>