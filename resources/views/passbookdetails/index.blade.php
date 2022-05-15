@include('layouts/header')
<style>
body{font-size:14px;}
</style>

<form method='POST' />


<table class='table table-striped table-bordered table-hover'>

<caption><center><b style="color:black;">PASSBOOK DETAILS</b></center></caption>
@foreach($passbooks as $group)
<tr>
<th>Date</th><td>{{$group->pdate}}</td>
<th>Name </th><td>{{$group->name}}</td>
</tr>
<tr>
<th>Passbook #</th><td>{{$group->pbsn}}</td>
@if($group->isFunded==0)
<th>Amount </th><td>{{$group->amount}}</td>
@else
<th>Status </th><td>Funded</td>
@endif
</tr>

<!-- SECOND ROW -->
<table class='table table-striped table-bordered table-hover'>
@if($group->isFunded==0)
<caption><center><b style="color:black;">PAYMENT PROOF</b></center></caption>
@else
<caption><center><b style="color:black;">PROOF OF FUND</b></center></caption>
@endif
<tr>
<td>

<center><?php echo "<img class=nav-user-photo src='/images/$group->proof' alt=Jasons Photo height=1200px width=900px />"; ?></center>
							</td>

</tr>


</table>
@endforeach

</table>
