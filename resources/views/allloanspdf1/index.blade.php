

<div style="font-size:18px;font-weight: bold;">
@foreach($company as $companys)
{{$companys->name}}<br>
{{$companys->location}} {{$companys->boxno}}<br>
Tel :{{$companys->phone}}<br>
Email:{{$companys->email}}<br><br><br>
<?php echo "<img src='images/$companys->logo' style='position:absolute;left:580px;top:-14px;' width='140px' alt='' />"; ?>
@endforeach
</div>
<hr>
<center><b>Loan Disbursement Report</b> </center>
<hr>
<table  width="100%">

<tr><th>Date</th><th>Name </th><th>Client No</th><th>Interest Rate</th><th>Repay</th><th>Loan Amount</th></tr>
@foreach($loans as $loans)

<tr><td>{{$loans->date}}</td><td>{{$loans->name}}</td><td>{{$loans->acno}}</td><td>{{$loans->loaninterest}}</td><td>{{$loans->loanrepay}}</td><td>{{$loans->loancredit}}</td></tr>
@endforeach
<tr>
@foreach($total as $total)
<td  style="border-style:solid; border-width:2px 0px 0px 0px"> </td> <td style="border-style:solid; border-width:2px 0px 0px 0px"> </td> <td style="border-style:solid; border-width:2px 0px 0px 0px"> </td> <td style="border-style:solid; border-width:2px 0px 0px 0px"></td> <td style="border-style:solid; border-width:2px 0px 0px 0px"> </td> <td style="border-style:solid; border-width:2px 0px 0px 0px">{{$total->loancredit}}</td> 
@endforeach
</tr>

</table>

