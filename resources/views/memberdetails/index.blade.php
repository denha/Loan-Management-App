@include('layouts/header')
<style>
body{font-size:14px;}
</style>



<form method='POST' />
<table class='table table-striped table-bordered table-hover'>
@foreach($details as $detail)
<caption><center><b style="color:black;">MEMBERSHIP DETAILS</b></center></caption>
<tr><td colspan='8'><center> <?php echo "<img id='bank' src='/images/$detail->photo' width='90' height='90'  />";?></center></td></tr>
<tr>
<th>Name </th><td>{{$detail->names}}</td>
<th>Gender </th><td>{{$detail->gender}}</td>
<th>Martial Status </th><td>{{$detail->marital}}</td>
<th>No of Dependents </th><td>{{$detail->dependents}}</td>
</tr>
<!-- SECOND ROW -->
<tr>
<th>Spouse Name</th><td>{{$detail->spousename}}</td>
<th>Education Level </th><td>{{$detail->education}}</td>
<th>Business Class </th><td>{{$detail->busclass}}</td>
<th>Business Type </th><td>{{$detail->bustype}}</td>
</tr>

<!-- THIRD ROW -->
<tr>
<th>Business Location</th><td>{{$detail->buslocation}}</td>
<th>Period in Business </th><td>{{$detail->lengthinbus}}</td>
<th>Ownership </th><td>{{$detail->ownership}}</td>
<th>Place of Residence </th><td>{{$detail->placeofresidence}}</td>
</tr>
<!-- FOURTH ROW -->
<tr>
<th>Next of Kin</th><td>{{$detail->nxtkinname}}</td>
<th>Next of Kin Contact </th><td>{{$detail->nxtofkinconc}}</td>
<th>R/ship Next of Kin </th><td>{{$detail->nxtkinrship}}</td>
<th>Nin of Next of Kin </th><td>{{$detail->nxtkinnin}}</td>
</tr>
<!-- FIFTH ROW -->
<tr>
<th>Source of Income</th><td>{{$detail->sourceofinc}}</td>
<th>Challenges </th><td>{{$detail->challenges}}</td>
<th>Borrowed Money from Bank ? </th><td>{{$detail->borrowedfrombank}}</td>
<th>Pending Loan ? </th><td>{{$detail->pendingloan}}</td>
</tr>
<!-- SIXTH ROW -->
<tr>
<th>How much Pending Loan</th><td>{{$detail->howmuch}}</td>
<th>Daily Business Earning ?</th><td>{{$detail->busearn}}</td>
<th>Membership Date  </th><td>{{$detail->memdate}}</td>
<th>isFunded   </th><td> @if($detail->isFunded==1)
Yes
@else
No
@endif

</td>
</tr>
@if($detail->isFunded==1)
<tr>
<th>Donnor Name </th> <td>{{$detail->donorname}} </td>
</tr>
@endif
</table>
</table><table class='table table-striped table-bordered table-hover'>
<caption><center><b style="color:black;">@if($detail->isFunded==1)
 PROOF OF BENEFICIARY ELIGBILITY PAGE 1 
 @else
 PROOF OF PAYMENT
@endif</b></center></caption>
<tr>
<td>


						<center><?php echo "<img class='nav-user-photo' src='/images/$detail->proofpayment'  height='1200px' width='900px' />"; ?></center>
							</td>

</tr>
</table>
@if($detail->isFunded==1)
</table><table class='table table-striped table-bordered table-hover'>
<caption><center><b style="color:black;">PROOF OF BENEFICIARY ELIGBILITY PAGE 2</b></center></caption>
<tr>
<td>


						<center><?php echo "<img class='nav-user-photo' src='/images/$detail->proofpayment2'  height='1200px' width='900px' />"; ?></center>
							</td>

</tr>
</table>

</table><table class='table table-striped table-bordered table-hover'>
<caption><center><b style="color:black;">PROOF OF BENEFICIARY ELIGBILITY PAGE 3</b></center></caption>
<tr>
<td>


						<center><?php echo "<img class='nav-user-photo' src='/images/$detail->proofpayment3'  height='1200px' width='900px' />"; ?></center>
							</td>

</tr>
</table>
</table><table class='table table-striped table-bordered table-hover'>
<caption><center><b style="color:black;">PROOF OF BENEFICIARY ELIGBILITY PAGE 4</b></center></caption>
<tr>
<td>


						<center><?php echo "<img class='nav-user-photo' src='/images/$detail->proofpayment4'  height='1200px' width='900px' />"; ?></center>
							</td>

</tr>
</table>


@endif
</table><table class='table table-striped table-bordered table-hover'>
<caption><center><b style="color:black;">MEMBERSHIP FORM PAGE 1</b></center></caption>
<tr>
<td>


						<center><?php echo "<img class='nav-user-photo' src='/images/$detail->formphoto'  height='1200px' width='900px' />"; ?></center>
							</td>

</tr>
</table>

</table><table class='table table-striped table-bordered table-hover'>
<caption><center><b style="color:black;">MEMBERSHIP FORM PAGE 2</b></center></caption>
<tr>
<td>


						<center><?php echo "<img class='nav-user-photo' src='/images/$detail->formphoto2'  height='1200px' width='900px' />"; ?></center>
							</td>

</tr>
</table>
</table><table class='table table-striped table-bordered table-hover'>
<caption><center><b style="color:black;">MEMBERSHIP FORM PAGE 3</b></center></caption>
<tr>
<td>


						<center><?php echo "<img class='nav-user-photo' src='/images/$detail->formphoto3'  height='1200px' width='900px' />"; ?></center>
							</td>

</tr>
</table>
@endforeach