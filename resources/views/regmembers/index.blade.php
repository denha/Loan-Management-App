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

<input type="hidden" value="{{$bra}}" id="company1"/>
<div class='easyui-dialog' style='width:60%;padding:5px;' closed='true' id='dlgregmembers' toolbar='#regmembers'>
<form id='frmregmembers'>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>-->
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Name</label></div><input type='text' required   class='easyui-textbox form-control' name='name' 
 id='name' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Gender</label></div><select required class='easyui-combobox form-control' name='gender' 
 id='gender' >
 <option value='male'>Male</option>
 <option value='female'>Female</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Marital status</label></div><select  required class='easyui-combobox form-control' name='marital' 
 id='marital' >
 <option value='married'>Married</option>
 <option value='single'>Single</option>
 <option value='divorced'>Divorced</option>
 <option value='Widow'>Widow</option>
 <option value='singleparent'>Single Parent</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>No of Dependents</label></div><input type='text'  required class='easyui-textbox form-control' name='dependents' 
 id='dependents' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Telephone</label></div><input type='text'  mask="(999) 999-999999" required class='easyui-maskedbox form-control' name='tel' 
 id='tel' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Spouse Name</label></div><input type='text'  required class='easyui-textbox form-control' name='spousename' 
 id='spousename' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Education Level</label></div><select required  class='easyui-combobox form-control' name='education' 
 id='education' >
 <option value='None'>None</option>
 <option value='Primary'>Primary</option>
 <option value='Secondary'>Secondary</option>
 <option value='tertially'>Tertially Institute</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Business Classification</label></div><select required  class='easyui-combobox form-control' name='busclass' 
 id='busclass' >
 <option value='retail'>Retail</option>
 <option value='service'>Service</option>
 <option value='wholesale'>wholesale</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Business Type</label></div><input type='text' required  class='easyui-textbox form-control' name='bustype' 
 id='bustype' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Business Location</label></div><input type='text' required  class='easyui-textbox form-control' name='buslocation' 
 id='buslocation' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Period in Business</label></div><input type='text' required class='easyui-textbox form-control' name='lengthinbus' 
 id='lengthinbus' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Ownership</label></div><select  required class='easyui-combobox form-control' name='ownership' 
 id='ownership' >
 <option value='sole'>Sole proprietorship</option>
 <option value='spouse'>Partnership with spouse</option>
 <option value='other'>Partnership with other</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Place of residence</label></div><input type='text' required class='easyui-textbox form-control' name='placeofresidence' 
 id='placeofresidence' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Name of Next of Kin</label></div><input type='text' required class='easyui-textbox form-control' name='nxtkinname' 
 id='nxtkinname' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Next of kin Contact</label></div><input type='text' required class='easyui-textbox form-control' name='nxtofkinconc' 
 id='nxtofkinconc' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Relationship to Next of kin</label></div><input  required type='text' class='easyui-textbox form-control' name='nxtkinrship' 
 id='nxtkinrship' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Nin</label></div><input type='text' required  class='easyui-textbox form-control' name='nxtkinnin' 
 id='nxtkinnin' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Source of Income</label></div><input type='text' required class='easyui-textbox form-control' name='sourceofinc' 
 id='sourceofinc' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Challenges Besides Finance</label></div><input  required type='text' class='easyui-textbox form-control' multiline="true"  name='challenges' 
 id='challenges' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label> Borrowed Money from the bank ?</label></div><select required  class='easyui-combobox form-control' name='borrowedfrombank' 
 id='borrowedfrombank' >
 <option>Yes</option>
 <option>No</option>
 </select>
 </div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Do you stil have a pending loan ?</label></div><select  required class='easyui-combobox form-control' name='pendingloan' 
 id='pendingloan' >
 <option>Yes</option>
 <option>No</option>
 </select></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>How much is it</label></div><input type='text' required class='easyui-textbox form-control' name='howmuch' 
 id='howmuch' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Daily Business Earnings ?</label></div><input  required type='text' class='easyui-textbox form-control' name='busearn' 
 id='busearn' /></div>
</div>

<div class='col-lg-4'>
<div class='form-group'>
<div><label>Membership Eligible ?</label></div>
<select required  id="isNew" name="isNew" style="width:95%"  class="easyui-combobox">
<option value="1"> Yes</option>
<option value="0"> No </option>
</select>
</div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>is Funded ?</label></div><select type='text'   required class='easyui-combobox form-control' name='isFunded' 
 id='isFunded' >
 <option value='1'>YES</option>
 <option value='0'>NO</option>
 </select></div>
</div>

<div class='col-lg-4'>
<div class='form-group'>
<div><label>Memebership Fees</label></div><input type='text' required class='easyui-textbox form-control' name='memfees' 
 id='memfees' /></div>
</div>

<!--<div class='col-lg-4'>
<div class='form-group'>
<div><label>Photo</label></div><input  type='hidden'  class='easyui-filebox form-control' name='photopic' 
 id='photopic' /></div>
</div>-->

<div class='col-lg-4'>
<div class='form-group'>
<div><label id="labelt"></label></div><input type='text'  style="width:93%" class='easyui-filebox form-control' name='photo' 
 id='proofofpayment' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Form Photo Page 1</label></div><input type='text'   class='easyui-filebox form-control' style="width:93%" name='memform' 
 id='memform' /></div>
 </div>
 <div class='col-lg-4'>
<div class='form-group'>
<div><label>Form Photo Page 2</label></div><input type='text'   class='easyui-filebox form-control' style="width:93%" name='memform2' 
 id='memform2' /></div>
 </div>
 <div class='col-lg-4'>
<div class='form-group'>
<div><label>Form Photo Page 3</label></div><input type='text'   class='easyui-filebox form-control' style="width:93%" name='memform2' 
 id='memform3' /></div>
 </div>
 <div class='col-lg-4'>
<div class='form-group'>
<div><label>Passport Photo</label></div><input type='text'   class='easyui-filebox form-control' style="width:93%" name='photo' 
 id='photo' /></div>
 </div>
 <input type="hidden"  id="header" name="header"/>
 <div class='col-lg-4'>
<div class='form-group'>
<div><label>Memebership Date</label></div><input type='text'  data-options="onSelect:validateDate,fixComplete" required class='easyui-datebox form-control' name='memdate' 
 id='memdate' /></div>
</div>

<div id="fundspace">
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Donor Name</label></div><input type='text'  class='easyui-textbox form-control' name='donorname' 
 id='donorname' /></div>
</div>
<div class='col-lg-4'>
<div class='form-group'>
<div><label>Proof of Beneficiary Eligbility Page 2</label></div><input type='text'   class='easyui-filebox form-control' style="width:93%" name='memform2' 
 id='proofofpayment2' /></div>
 </div>
 <div class='col-lg-4'>
<div class='form-group'>
<div><label>Proof of Beneficiary Eligbility Page 3</label></div><input type='text'   class='easyui-filebox form-control' style="width:93%" name='memform2' 
 id='proofofpayment3' /></div>
 </div>
 <div class='col-lg-4'>
<div class='form-group'>
<div><label>Proof of Beneficiary Eligbility Page 4</label></div><input type='text'   class='easyui-filebox form-control' style="width:93%" name='memform2' 
 id='proofofpayment4' /></div>
 </div>
</div>
</div>



</div>

 </div>




</form>

<div style='padding:5px;' id='regmembers' /><a href='javascript:void(0)' class='btn btn-primary'id='saveregmembers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary' id="closebtn">Close</a>
</div></div>
<table class='easyui-datagrid' rowNumbers='true' striped='true' title='Members' iconCls='fa fa-table' singleSelect='true'  pagination='true' id='gridregmembers' method='get' fitColumns='true' style='width:100%' toolbar='#regmemberstoolbar'>

</table>
<div id='regmemberstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newregmembers' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editregmembers' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"> Edit </i></a> 
<a href='javascript:void(0)' class='btn btn-primary' id='deleteregmembers' iconCls='icon-remove' > <i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a> 

@if(Auth::user()->branchid==1)

&nbsp;&nbsp;<label>Branch </label>&nbsp;<input  class='easyui-combobox ' style="width:20%;height:34px;" data-options="url:'combocompanys',method:'get',valueField:'id',textField:'name'" name='company' 
id='company' />
<input type="hidden" id="adminset" value="1"/>

&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find">Find</a>
@endif
&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="viewmember" name="find"><i class="fa fa-calendar"></i> View</a> </div>

{{csrf_field()}}
<script>
function validateDate(date){
$.getJSON('activeyear',function(data){
if(data==''){
$.messager.alert('Warning','Financial Period Not Set..Please set it and try again','warning');
$('#memdate').datebox('setValue','');

}else{
	$.each(data, function (index, value) {
		
var start= new Date(value.startperiod).getTime()/1000;
var end =new Date(value.endperiod).getTime()/1000;
var inputdate=date.getTime()/1000;
if(inputdate<start || inputdate>end){
var a=$.messager.alert('Warning','You can not enter a date that is not with in the Active Financial Period '+value.startperiod+ ' AND '+value.endperiod,'warning');
$('#memdate').datebox('setValue', '');
}

});
}

});

}
function fixComplete(){
    $.getJSON('isComplete',function(data){
    $.each(data, function (index, value) {
        var countresults=value.count;
        if(countresults>0){
            $.messager.alert('Warning','There is an Incomplete Transaction, Click ok to fix this Issue','warning');  
        }
        }); 
    });  
}
 var url;
 var validate=false;
 $(document).ready(function(){
    $('#photo').filebox({
    accept: 'image/*'
});
$('#fundspace').hide();
$('#isNew').combobox({
onChange:function(){

   if(this.value==1){
$('#memfees').textbox('setValue','3,000');
$('#isFunded').combobox('setValue',0);
$('#donorname').textbox({
    required:false,
});
$('#fundspace').hide();

   }else{
    $('#memfees').textbox('setValue','0');
    $('#isFunded').combobox('setValue',1);
   }
   
}

});
$('#isFunded').combobox({
onChange:function(){
   if(this.value==1){
$('#memfees').textbox('setValue','0');
$('#labelt').html('Proof of Beneficiary Eligbility Page 1 ');
$('#donorname').textbox({
    required:true,
});
$('#fundspace').show();
   }else{
    $('#memfees').textbox('setValue','3,000');
    $('#labelt').html('Proof of Payment ');
    $('#fundspace').hide();
   }
   
}

});
    $('#gridregmembers').datagrid({
        
    title:'Members',
    remoteSort:false,
    singleSelect:true,
    nowrap:false,
    rownumbers:true,
    fitColumns:true,
    url:'/viewregmembers',
    striped:true,
    method:'get',
    columns:[[
        {field:'id' ,hidden:true,width:100},
        {field:'name',width:150,title:'Name',sortable:true},
        {field:'education',title:'Education',width:100},
        {field:'busclass',title:'Business Class',width:100},
        {field:'bustype',title:'Business Type',width:100,sortable:true},
        {field:'buslocation',title:'Location',width:100,sortable:true},
        {field:'lengthinbus',title:'Period',width:100,sortable:true},
        {field:'ownership',title:'Ownership',width:100,sortable:true},
        {field:'sourceofinc',hidden:false,title:'Source of Income',width:100,sortable:true},
        {field:'memdate',title:'Memship Date',width:100,sortable:true},
        {field:'isNew',hidden:true,title:'isNew ?',width:50,sortable:true},
        {field:'Newb',title:'isNew ?',width:50,sortable:true,},
        {field:'header',title:'header',width:190,sortable:true,hidden:true},
        {field:'regno' ,hidden:true,width:100},
        {field:'gender' ,hidden:true,width:100},
        {field:'martial' ,hidden:true,width:100},
        {field:'dependents' ,hidden:true,width:100},
        {field:'spousename' ,hidden:true,width:100},
        {field:'placeofresidence' ,hidden:true,width:100},
        {field:'nxtkiname' ,hidden:true,width:100},
        {field:'nxtofkinconc' ,hidden:true,width:100},
        {field:'nxtkinrship' ,hidden:true,width:100},
        {field:'nxtkinnin' ,hidden:true,width:100},
        {field:'challenges' ,hidden:true,width:100},
        {field:'borrowedfrombank' ,hidden:true,width:100},
        {field:'pendingloan' ,hidden:true,width:100},
        {field:'howmuch' ,hidden:true,width:100},
        {field:'busearn' ,hidden:true,width:100},
        {field:'photo' ,hidden:true,width:100},
        {field:'proofofpayment' ,hidden:true,width:100},
        {field:'proofofpayment2' ,hidden:true,width:100},
        {field:'proofofpayment3' ,hidden:true,width:100},
        {field:'proofofpayment4' ,hidden:true,width:100},
        {field:'formphoto' ,hidden:true,width:100},
        {field:'formphoto2' ,hidden:true,width:100},
        {field:'formphoto3' ,hidden:true,width:100},
        {field:'tel' ,hidden:true,width:100},
       

     
       
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
$('#gridregmembers').datagrid({
        pageSize:50,
        pageList:[10,20,30,40,50],


    });
     $('#closebtn').click(function(){

        $('#dlgregmembers').dialog('close'); 
     });
    $('#memform').filebox({
    accept: 'image/*'
});
$('#memform2').filebox({
    accept: 'image/*'
});
$('#proofofpayment').filebox({
    accept: 'image/*'
});

//Auto Generated code for New Entry Code
$('#viewmember').click(function(){
    var a=$('#gridregmembers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Info','Please select a Recored to View');
        
    }else{
    window.open('/memberdetails/'+a.id);
    }

});
   $('#newregmembers').click(function(){
validate=true;
      var ans= $('#adminset').val();
var company=$('#company').val();

if(ans==1){
    if(company==''){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Please Select the Branch'});

    }else{
        $('#dlgregmembers').dialog('open').dialog('setTitle','New regmembers');
        @if(Auth::user()->branchid==1)
var bra=$('#company').val();
/*$('#name').combobox({
url:'/approvedmember/'+bra,
method:'get',
textField:'name',
valueField:'id',


});*/
      @endif
url='/saveregmembers';
$('#frmregmembers').form('clear');
$('#memfees').textbox('setValue','3,000');
    }
    }else{
       
       $('#dlgregmembers').dialog('open').dialog('setTitle','New regmembers');
        url='/saveregmembers';
$('#frmregmembers').form('clear');
$('#memfees').textbox('setValue','3,000');
      
/*var bra=$('#company1').val();

$('#name').combobox({
url:'/approvedmember/'+bra,
method:'get',
textField:'name',
valueField:'id',


});*/


    }

});


$('#find').click(function(){
   
    var branch=$('#company').val();
$('#gridregmembers').datagrid({
method:'get',
queryParams:{branch:branch}

});

});

$('#memfees').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});

       //Auto Generated code for Edit Code
 $('#editregmembers').click(function(){
       validate=false;
 var row=$('#gridregmembers').datagrid('getSelected');
 $('#dlgregmembers').dialog('move', {
   //left: 280,
   top: 100
});
       $('#dlgregmembers').dialog('open').dialog('setTitle','Edit regmembers');

       $('#frmregmembers').form('load',row);
      
       url='/editregmembers/'+row.id;
       
       
       });

       $('#dlgregmembers').dialog('move', {
   //left: 280,
   top: 100
});
//Auto Generated Code for Saving
$('#saveregmembers').click(function(){ 
var branch=$('#company').val();
var id=$('#id').val();
var isNew=$('#isNew').val();
var isFunded=$('#isFunded').val();
var name=$('#name').val();
var gender=$('#gender').val();
var marital=$('#marital').val();
var dependents=$('#dependents').val();
var spousename=$('#spousename').val();
var education=$('#education').val();
var busclass=$('#busclass').val();
var bustype=$('#bustype').val();
var buslocation=$('#buslocation').val();
var lengthinbus=$('#lengthinbus').val();
var ownership=$('#ownership').val();
var placeofresidence=$('#placeofresidence').val();
var nxtkinname=$('#nxtkinname').val();
var nxtofkinconc=$('#nxtofkinconc').val();
var nxtkinrship=$('#nxtkinrship').val();
var nxtkinnin=$('#nxtkinnin').val();
var sourceofinc=$('#sourceofinc').val();
var challenges=$('#challenges').val();
var borrowedfrombank=$('#borrowedfrombank').val();
var pendingloan=$('#pendingloan').val();
var howmuch=$('#howmuch').val();
var busearn=$('#busearn').val();
var memdate=$('#memdate').val();
var memfees=$('#memfees').val();
var tel=$('#tel').val();
var header=$('#header').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
var proofofpayment1 = $('#proofofpayment').next().find('.textbox-value');
var proofofpayment2 = $('#proofofpayment2').next().find('.textbox-value');
var proofofpayment3 = $('#proofofpayment3').next().find('.textbox-value');
var proofofpayment4 = $('#proofofpayment4').next().find('.textbox-value');
var photo = $('#photo').next().find('.textbox-value');
var memform1 = $('#memform').next().find('.textbox-value');
var memform2 = $('#memform2').next().find('.textbox-value');
var memform3 = $('#memform3').next().find('.textbox-value');
var donorname=$('#donorname').val();

var form_data = new FormData();
form_data.append('photo', photo[0].files[0]);
form_data.append('proofofpayment', proofofpayment1[0].files[0]);
form_data.append('proofofpayment2', proofofpayment2[0].files[0]);
form_data.append('proofofpayment3', proofofpayment3[0].files[0]);
form_data.append('proofofpayment4', proofofpayment4[0].files[0]);
form_data.append('memform', memform1[0].files[0]);
form_data.append('memform2', memform2[0].files[0]);
form_data.append('memform3', memform3[0].files[0]);
form_data.append('name', name);
form_data.append('nxtkinnin',nxtkinnin);
form_data.append('tel',tel);
form_data.append('nxtkinrship',nxtkinrship);
form_data.append('nxtofkinconc',nxtofkinconc);
form_data.append('gender', gender);
form_data.append('marital', marital);
form_data.append('dependents', dependents);
form_data.append('spousename', spousename);
form_data.append('education', education);
form_data.append('busclass', busclass);
form_data.append('bustype', bustype);
form_data.append('buslocation', buslocation);
form_data.append('lengthinbus', lengthinbus);
form_data.append('ownership', ownership);
form_data.append('placeofresidence',placeofresidence);
form_data.append('nxtkinname',nxtkinname);
form_data.append('sourceofinc',sourceofinc);
form_data.append('challenges',challenges);
form_data.append('borrowedfrombank', borrowedfrombank);
form_data.append('pendingloan', pendingloan);
form_data.append('howmuch', howmuch);
form_data.append('busearn', busearn);
form_data.append('memdate', memdate);
form_data.append('memfees', memfees);
form_data.append('branch', branch);
form_data.append('header', header);
form_data.append('isNew',isNew);
form_data.append('donorname',donorname);
form_data.append('isFunded',isFunded);
form_data.append('_token', $('input[name=_token]').val());
$('#frmregmembers').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){
                        if(validate==true){
                            if(typeof photo[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Photo must be attached ','warning');
                            }else if(typeof proofofpayment1[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Payment Proof must be attached ','warning');
                            }
                            else if(typeof memform1[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Membership Form must be attached ','warning');
                            }
                            else if(typeof memform2[0].files[0]==='undefined'){
                                $.messager.alert('Warning','Membership Form must be attached ','warning');
                            }else{
                                $.ajax({
cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'Post',
url:url,
method:'POST',
success:function(data){
    if(data.exists=='true'){
        $.messager.alert('Warning','This Member Exists Already.. Please change the name and try again. ','warning');
    }else{
        $('#dlgregmembers').dialog('close');  
    $('#gridregmembers').datagrid('reload');
  
    }
}
});
                            }

                        }else{
                           
                       $.ajax({
cache:false,
url:url,
data:form_data,
contentType:false,
processData:false,
method:'Post',
url:url,
method:'POST',
success:function(data){
    if(data.exists=='true'){
        $.messager.alert('Warning','This Member Exists Already.. Please change the name and try again. ','warning');
    }else{
        $('#dlgregmembers').dialog('close');  
    $('#gridregmembers').datagrid('reload');
  
    }
}
});
}
                        
                }
                }
});

  

  
});
//Auto generated code for deleting
$('#deleteregmembers').click(function(){

    var a=$('#gridregmembers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridregmembers').datagrid('getSelected');
                $.ajax({
                 url:'/destroyregmembers/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(data){
                     if(data.failed==true){
                        $.messager.alert({title:'Warning',icon:'warning',msg:'You dont have priviledges to delete this record, Please contact the Administrator.'});
                     }
                     else if(data.hasRecords=='yes'){
                        $.messager.alert({title:'Warning',icon:'warning',msg:'You cannot delete a records that has other record its associated with.. '});  
                         }else{
                    $('#gridregmembers').datagrid('reload');
                     }
                   
                 }
                });
                
            }

});
}
});
$('#memdate').datebox({
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
});
</script>
