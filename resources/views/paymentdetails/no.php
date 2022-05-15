@include('layouts/header')
<style>
body{font-size:14px;}
</style>

<form method='POST' />


<table class='table table-striped table-bordered table-hover'>

<caption><center><b style="color:black;">PAYMENT DETAILS</b></center></caption>
@foreach($groupdata as $group)
<tr>
<th>Date</th><td>{{$group->date}}</td>
<th>Group Name </th><td>{{$group->name}}</td>
</tr>
<tr>
<th>Payment No</th><td>{{$group->paymentdet}}</td>
<th>Loan Amount </th><td>{{$group->amount}}</td>
</tr>
<th>Surcharge</th><td>{{$group->surcharge}}</td>
<th>Total Paid </th><td>{{$group->total}}</td>
</tr>
<!-- SECOND ROW -->
<table class='table table-striped table-bordered table-hover'>

<caption><center><b style="color:black;">PAYMENT PROOF</b></center></caption>
<tr>
<td>

<center><?php echo "<img class=nav-user-photo src='/images/$group->proof' alt=Jasons Photo height=1200px width=900px />"; ?></center>
							</td>

</tr>


</table>
<!-- SECOND ROW -->
<table class='table table-striped table-bordered table-hover'>

<caption><center><b style="color:black;">PAYMENT / BANKSLIP</b></center></caption>
<tr>
<td>

<center><?php echo "<img class=nav-user-photo src='/images/$group->bankslip' alt=Jasons Photo height=1200px width=900px />"; ?></center>
							</td>

</tr>


</table>
@endforeach

</table>
