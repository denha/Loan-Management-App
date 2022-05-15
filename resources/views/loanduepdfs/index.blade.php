<style>
.tabs{
  border-top: 2px solid black;
}

</style>
<div style="font-size:18px;font-weight: bold;">
@foreach($company as $companys)
{{$companys->name}}<br>
{{$companys->location}} {{$companys->boxno}}<br>
Tel :{{$companys->phone}}<br>
Email:{{$companys->email}}<br><br>
<?php echo "<img src='images/$companys->logo' style='position:absolute;left:880px;top:-14px;' width='140px' alt='' />"; ?>
@endforeach
</div>
<center><h4>Loan Due Report As of {{$display}}</h4> </center>
<hr>
<table class="loandata" border="0" width="100%" >

<tr><th height="20">Issue Date</th><th>Maturity Date</th><th>Account #</th><th>Name</th><th>Loan Bal</th><th>Loan</th><th>Interest Bal</th><th>Total</th></tr>
@foreach($loansdue as $due)

<tr><td>{{$due->date}}</td><td>{{$due->maturity}}</td><td>{{$due->acno}}</td><td>{{$due->name}}</td><td>{{$due->loan}}</td><td>{{$due->loancredit}}</td><td>{{$due->interest}}</td><td>{{$due->total}}</td></tr>
@endforeach
<tr class="border">

@foreach($total as $total)
<th class="tabs" rowspan='3'>Total </th> <th class="tabs"></th><th class="tabs"></th><th class="tabs"></th><th class="tabs"></th><th class="tabs"></th><th class="tabs"></th><th class="tabs">{{$total->total}}</th>

@endforeach

</tr>

</table>


</table>