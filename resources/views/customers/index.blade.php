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
<input value={{$bra}} hidden id="company1" />
<div class='easyui-dialog' style='width:80%;padding:5px;' closed='true' id='dlgcustomers' toolbar='#customers'><form id='frmcustomers'>
<center><h4> Personal Information</h4> </center>
<hr>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Name </label></div><input type='text' required class='easyui-combobox form-control' name='name' 
 id='name' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Sex</label></div><select required class='easyui-combobox form-control' name='sex' 
 id='sex'>
 <option value='F'>Female </option>
 <option value='M'>Male</option>
 <option value='O'>Other</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Identification No</label></div><input  required type='text' class='easyui-textbox form-control' name='acno' 
 id='acno' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Date of Birth</label></div><input required type='text' class='easyui-datebox form-control' name='dob' 
 id='dob' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Village</label></div><input required type='text' class='easyui-textbox form-control' name='address' 
 id='address' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Telephone 1</label></div><input required type='text' mask="(999) 999-999999" class='easyui-maskedbox form-control' name='telephone1' 
 id='telephone1' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Telephone 2</label></div><input  type='text' mask="(999) 999-999999" class='easyui-maskedbox form-control' name='telephone2' 
 id='telephone2' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Email Address</label></div><input required type='text' class='easyui-textbox form-control' name='email' 
 id='email' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>District</label></div><input type='text' required class='easyui-textbox form-control' name='district' 
 id='district' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Subcounty</label></div><input required type='text' class='easyui-textbox form-control' name='subcounty' 
 id='subcounty' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Parish</label></div><input type='text' required class='easyui-textbox form-control' name='parish' 
 id='parish' /></div>
</div>
<!--<div class='col-lg-4'>
<div class='form-group'>
<div><label>Village</label></div><input type='text' class='easyui-textbox form-control' name='village' 
 id='village' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Religion</label></div><input type='text' class='easyui-textbox form-control' name='religion' 
 id='religion' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Church</label></div><input type='text' class='easyui-textbox form-control' name='church' 
 id='church' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Education</label></div><input type='text' class='easyui-textbox form-control' name='education' 
 id='education' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Occupation</label></div><input type='text' class='easyui-textbox form-control' name='occupation' 
 id='occupation' /></div>
</div>-->
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Marital Status</label></div><input type='text' required class='easyui-combobox form-control' data-options="url:'combomaritals',method:'get',valueField:'id',textField:'name'" name='marital' 
 id='marital' /></div>
</div>
<!--
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Number of children</label></div><input style="height:80px" type='text' multiline="true" class='easyui-textbox form-control' name='nochildren' 
 id='nochildren' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Name of children</label></div><input type='text' style="height:80px" multiline="true" class='easyui-textbox form-control' name='namechildren' 
 id='namechildren' /></div>
</div>-->
<!--<center><h4>Next of Kin </h4></center>-->

<!--<div class='col-lg-4'>
<div class='form-group'>
<div><label>Next of Kin Name</label></div><input type='text' class='easyui-textbox form-control' name='kinname' 
 id='kinname' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Sex</label></div><select  class='easyui-combobox form-control' name='kinsex' 
 id='kinsex'>
 <option value='F'>Female </option>
 <option value='M'>Male</option>
 <option value='O'>Other</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Date of Birth </label></div><input type='text' class='easyui-datebox form-control' name='kindob' 
 id='kindob' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Occupation</label></div><input type='text' class='easyui-textbox form-control' name='kinoccupation' 
 id='kinoccupation' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Contact Address </label></div><input type='text' class='easyui-textbox form-control' name='contactadd' 
 id='contactadd' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Email </label></div><input type='text' class='easyui-textbox form-control' name='kinemail' 
 id='kinemail' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Telephone 1</label></div><input type='text' mask="(999) 999-999999" class='easyui-maskedbox form-control' name='kintelephone1' 
 id='kintelephone1' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Telephone 2</label></div><input type='text' mask="(999) 999-999999" class='easyui-maskedbox form-control' name='kintelephone2' 
 id='kintelephone2' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Witness Name</label></div><input type='text' class='easyui-textbox form-control' name='witnessname' 
 id='witnessname' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Witness Date</label></div><input type='text' class='easyui-datebox form-control' name='witnessdate' 
 id='witnessdate' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Registration Date</label></div><input type='text' class='easyui-datebox form-control' name='registrationdate' 
 id='registrationdate' /></div>
</div>-->

<center><h4> Business Information</h4> </center>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Business Name </label></div><input  required type='text'  class='easyui-textbox form-control' name='bname' 
 id='bname' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Business Address</label></div><input required  type='text' class='easyui-textbox form-control' name='baddress' 
 id='baddress' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Belong to Any Co-operative</label></div><select required  class='easyui-combobox form-control' name='iscop' 
 id='cop'>
 <option value='1'>Yes </option>
 <option value='0'>No</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Period at Current Business Address</label></div><input required  type='text' class='easyui-textbox form-control' name='bperiod' 
 id='cbperiod' /></div>
</div>

<!--<div class='col-lg-4'>
<div class='form-group'>
<div><label>Personal Image</label></div>
 <div id="form-attachmen">
   <input  name="logo" id="logo" required style="width:90%;"  class="easyui-filebox form-control" />
</div>
</div>-->
</div>

</div>
<div style='padding:5px;' id='customers' /><a href='javascript:void(0)' class='btn btn-primary'id='savecustomers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid'  striped='true' rowNumbers="true" title='Funded Members' iconCls='fa fa-table' singleSelect='true' url='viewcustomers' pagination='true' id='gridcustomers' method='get' fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
<!--<thead><tr>
<th field='id' hidden width='100'>id</th>
<th field='name' width='260'>Name</th>
<th field='sex' width='40'>sex</th>
<th field='acno' width='100'>Account #</th>
<th field='dob' hidden width='100'>Date of Birth</th>
<th field='address' width='100'>Address</th>
<th field='telephone1' width='120'>Telephone 1</th>
<th field='telephone2' hidden width='100'>Telephone 2</th>
<th field='email' width='180'>Email</th>
<th field='district' width='100'>District</th>
<th field='subcounty' width='100'>Subcounty</th>
<th field='parish' width='100'>Parish</th>
<th field='village' hidden width='100'>Village</th>
<th field='religion' hidden width='100'>Religion</th>
<th field='church'  hidden width='100'>Church</th>
<th field='education' hidden width='100'>Education</th>
<th field='occupation' hidden  width='100'>Occupation</th>
<th field='marital' hidden width='100'>Marital</th>
<th field='nochildren' hidden width='100'>nochildren</th>
<th field='namechildren' hidden width='100'>namechildren</th>
<th field='kinname' hidden  width='100'>kinname</th>
<th field='kinsex' hidden  width='100'>kinsex</th>
<th field='kindob'hidden  width='100'>kindob</th>
<th field='kinoccupation' hidden  width='100'>kinoccupation</th>
<th field='contactadd' hidden  width='100'>contactadd</th>
<th field='kinemail' hidden  width='100'>kinemail</th>
<th field='kintelephone1' hidden width='100'>kintelephone1</th>
<th field='kintelephone2' hidden  width='100'>kintelephone2</th>
<th field='witnessname' hidden  width='100'>witnessname</th>
<th field='witnessdate' hidden  width='100'>witnessdate</th>
<th field='registrationdate' hidden  width='100'>registrationdate</th>


</tr></thead>-->
</table>
<div id='customerstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary ' id='newcustomers'  ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary ' id='editcustomers'  ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary ' id='deletecustomers' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a>
&nbsp;&nbsp;

@if(Auth::user()->branchid!=1)
 <!--<input style="width:20%" required class='easyui-combobox form-control' data-options="url:'customerscombo',method:'get',valueField:'id',textField:'name'" name='findname' 
 id='findname' />-->
 @endif&nbsp;

 @if(Auth::user()->branchid==1)

 &nbsp;<label>Branch </label>&nbsp;<input  class='easyui-combobox ' style="width:20%" data-options="url:'combocompanys',method:'get',valueField:'id',textField:'name'" name='company' 
 id='company' />
 <input type="hidden" id="adminset" value="1"/>
 <a href='javascript:void(0)' class='btn btn-primary ' id='findsearch' ><i class="fa fa-search" aria-hidden="true"></i> Search</a>
 @endif

 @if(Auth::user()->branchid!=1)
<input  type="file"  style="float:right;    border: 1px solid #ccc;
    display: inline-block;
    padding: 5px 10px;
    cursor: pointer;" id="files" />
 <a href='javascript:void(0)' style="float:right;" class='btn btn-primary' id='import'  ><i class="fa fa-upload" aria-hidden="true"></i>
 Import</a> 
 @endif
  </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){

    $('#gridcustomers').datagrid({
    title:'Funded Members',
    remoteSort:false,
    singleSelect:true,
    nowrap:false,
    rownumbers:true,
    fitColumns:true,
    url:'/viewcustomers',
    striped:true,
    method:'get',
    columns:[[
        {field:'id' ,hidden:true,width:100},
        {field:'name',width:210,title:'Name'},
        {field:'acno',hidden:true,width:110,title:'Account #'},
        {field:'address',title:'Address',width:100},
        {field:'telephone1',title:'Telephone 1',width:150},
        {field:'email',title:'Email Address',width:190,sortable:true},
        {field:'district',title:'District',width:190,sortable:true},
        {field:'subcounty',title:'Sub-County',width:190,sortable:true},
        {field:'parish',title:'Parish',width:190,sortable:true},
        {field:'bname',hidden:true,title:'bname',width:190,sortable:true},
        {field:'baddress',title:'baddress',width:190,sortable:true,hidden:true},
        {field:'bperiod',title:'bperiod',width:190,sortable:true,hidden:true},
        {field:'iscop',title:'cop',width:190,sortable:true,hidden:true},
        {field:'marital',title:'cop',width:190,sortable:true,hidden:true},
        {field:'dob',title:'cop',width:190,sortable:true,hidden:true},
     
       
    ]],
    view: detailview,
				detailFormatter: function(rowIndex, rowData){
					return '<table><tr>' +
							'<td rowspan=2 style="border:0"><img src="images/' + rowData.photo + '" style="height:200px;width:200px;"></td>' +
							'<td style="border:0">' +
							 
							'</td>' +
							'</tr></table>';
				}
});
//Auto Generated code for New Entry Code
$('#logo').filebox({
    accept: 'image/*'
});
$('#import').click(function(){
        var file_data =$('#files').prop('files')[0]; //$('#file')[0].files;
var form_data = new FormData();
form_data.append('files', file_data);
form_data.append('_token', $('input[name=_token]').val());
//$.messager.progress({title:'Importing',msg:"Importing ...."});
//alert(file_data);
$.ajax({
    dataType:'Text',
    cache:false,
url:'importnames',
data:form_data,
contentType:false,
processData:false,
method:'post',
success:function(data){
    $('#gridcustomers').datagrid('reload');
}
});
     });
     
   $('#newcustomers').click(function(){
    $.extend($.fn.dialog.methods, {
    mymove: function(jq, newposition){
        return jq.each(function(){
            $(this).dialog('move', newposition);
        });
    }
});


$('#dlgcustomers').dialog('move', {
  // left: 280,
   //top: 290
});
         

var ans= $('#adminset').val();
var company=$('#company').val();

if(ans==1){
    if(company==''){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Please Select the Branch'});

    }else{
        $('#frmcustomers').form('clear');
        $('#dlgcustomers').dialog('open').dialog('setTitle','New Client');
        url='/savecustomers';
$('#name').combobox({
url:'/fundedmembers/'+company,
method:'get',
valueField:'id',
textField:'name',
    });

    }

}else{
    $('#dlgcustomers').dialog('open').dialog('setTitle','New Client');
       //$('#dlgcustomers').dialog('open').dialog('setTitle','New customers').dialog({position:'top'});
url='/savecustomers';
$('#frmcustomers').form('clear');
$('#name').combobox({
url:'/fundedmembers/'+$('#company1').val(),
method:'get',
valueField:'id',
textField:'name',
    });
}
});
   
$('#gridcustomers').datagrid({
        pageSize:50,
        pageList:[10,20,30,40,50],


    });
       //Auto Generated code for Edit Code
 $('#editcustomers').click(function(){
       
 var row=$('#gridcustomers').datagrid('getSelected');
      // $('#dlgcustomers').dialog('open').dialog('setTitle','Edit customers');
     
$('#dlgcustomers').dialog('open').dialog('setTitle','Edit Client');

       $('#frmcustomers').form('load',row);
       url='/editcustomers/'+row.id;
       
       
       });
      /* $('#findbranch').click(function(){
    var branch=$('#company').val();
$('#gridcustomers').datagrid({
method:'get',
queryParams:{branch:branch}

});
});*/
//Auto Generated Code for Saving
$('#savecustomers').click(function(){ 
    var form_data = new FormData();
    //var f = $('#logo').next().find('.textbox-value');
    form_data.append('id',$('#id').val());
    form_data.append('company',$('#company').val());
    form_data.append('name',$('#name').val());
    form_data.append('sex',$('#sex').val());
    form_data.append('dob',$('#dob').val());
    form_data.append('address',$('#address').val());
    form_data.append('telephone1',$('#telephone1').val());
    form_data.append('telephone2',$('#telephone2').val());
    form_data.append('email',$('#email').val());
    form_data.append('district',$('#district').val());
    form_data.append('subcounty',$('#subcounty').val());
    form_data.append('parish',$('#parish').val());
    form_data.append('village',$('#village').val());
    form_data.append('religion',$('#religion').val());
    form_data.append('church',$('#church').val());
    form_data.append('education',$('#education').val());
    form_data.append('occupation',$('#occupation').val());
    form_data.append('marital',$('#marital').val());
    form_data.append('nochildren',$('#nochildren').val());
    form_data.append('namechildren',$('#namechildren').val());
    form_data.append('kinname',$('#kinname').val());
    form_data.append('kinsex',$('#kinsex').val());
    form_data.append('kindob',$('#kindob').val());
    form_data.append('kinoccupation',$('#kinoccupation').val());
    form_data.append('contactadd',$('#contactadd').val());
    form_data.append('kinemail',$('#kinemail').val());
    form_data.append('kintelephone1',$('#kintelephone1').val());
    form_data.append('kintelephone2',$('#kintelephone2').val());
    form_data.append('witnessname',$('#witnessname').val());
    form_data.append('witnessdate',$('#witnessdate').val());
    form_data.append('registrationdate',$('#registrationdate').val());
    form_data.append('acno',$('#acno').val());
    form_data.append('branchnumber',$('#branchnumber').val());
    form_data.append('bname',$('#bname').val());
    form_data.append('baddress',$('#baddress').val());
    form_data.append('cop',$('#cop').val());
    form_data.append('cbperiod',$('#cbperiod').val());
    form_data.append('isActive',$('#isActive').val());
    //form_data.append('logo',f[0].files[0]);
    form_data.append('_token', $('input[name=_token]').val());
   
$('#frmcustomers').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){

                        $.ajax({
   // dataType:'json',
cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'post',
success:function(data){
    if(data.checkacno=='exists'){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Operation Failed, Account Number is already in Use. Please it change and try again...'});
    }else{
    $('#gridcustomers').datagrid('reload');
    $.messager.progress('close');
	  $.messager.show({title:'Saving',msg:'Transcation succesfully Saved'});
     // alert('yes');
    }

}
});
$('#dlgcustomers').dialog('close');
}
}
});
  

  

});
//Auto generated code for deleting
$('#deletecustomers').click(function(){

    var a=$('#gridcustomers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridcustomers').datagrid('getSelected');
                $.ajax({
                 url:'/destroycustomers/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(data){
                    if(data.isdelete=='No'){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Operation Failed,This Account Number or Client  has data associated with it. '});
    }else{
        $('#gridcustomers').datagrid('reload');
    }
                 }
                });
                
            }

});
}
});
$('#dob').datebox({
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
    $('#kindob').datebox({
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
    $('#witnessdate').datebox({
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
    $('#registrationdate').datebox({
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

    $('#findsearch').click(function(){
    var findname=$('#findname').val();
    var branch=$('#company').val();
$('#gridcustomers').datagrid({
method:'get',
queryParams:{findname:findname,branch:branch}

});

});
});
</script>