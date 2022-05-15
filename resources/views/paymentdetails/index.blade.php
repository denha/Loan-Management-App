@include('layouts/header')
<style>
body{font-size:14px;}
</style>

<form method='POST' />


<table class='table table-striped table-bordered table-hover'>

<caption><center><b style="color:black;">PAYMENT PROOF</b></center></caption>
@foreach($groupdata as $group)
<!--<tr>
<th>Date</th><td></td>
<th>Group Name </th><td></td>
</tr>
<tr>
<th>Payment No</th><td></td>
<th>Loan Amount </th><td></td>
</tr>
<th>Surcharge</th><td></td>
<th>Total Paid </th><td></td>
</tr>-->
<!-- SECOND ROW -->
<table class='table table-striped table-bordered table-hover'>

<!--<caption><center><b style="color:black;">PAYMENT PROOF</b></center></caption>-->
<tr>
<td>

<center><?php echo "<img class=nav-user-photo src='/images/$group->proof' alt=Jasons Photo height=1200px width=900px />"; ?></center>
							</td>

</tr>


</table>
<!-- SECOND ROW -->

@endforeach

</table>
