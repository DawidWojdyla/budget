<script type="text/javascript">

var date = new Date();
var lastChosenMonth = null;
var lastChosenYear = null;
var limit = null;
var lastChosenCategorySum = null;
var lastChosenCategoryId = null;

$(document).ready(function(){
	
  $("#expenseDate").change(function(){
	getCategorySumOfChosenMonthIfNecessary();
  });
  
    $("#amount").change(function(){
	showLimitInfo();
  });
  
});

function updateAmount()
{
	showLimitInfo();
}

function showLimitInfoIfRequired(chosenCategoryLimit)
{
	
	if (chosenCategoryLimit !== '')
	{
		limit = parseFloat(chosenCategoryLimit);
		if(lastChosenCategoryId != $('input[name=category]:checked').val())
		{
			lastChosenYear = null;
			lastChosenCategoryId = $('input[name=category]:checked').val();
		}
		getCategorySumOfChosenMonthIfNecessary();
	}
	else
	{
		hideLimitInfo();
		limit = null;
	}
	
}

function getCategorySumOfChosenMonthIfNecessary()
{
	if(limit !== null && $('#expenseDate').val() !== '')
	{
		date = new Date($('#expenseDate').val());
		
		if((date.getMonth()+1) !== lastChosenMonth || date.getFullYear() !== lastChosenYear)
		{
			lastChosenMonth = date.getMonth()+1;
			lastChosenYear = date.getFullYear();
			
			var ajaxRequest = $.ajax({
				url: "index.php?action=returnExpenseCategorySumOfChosenPeriod",
				type: "post",
				data: {
					categoryId : lastChosenCategoryId,
					month: lastChosenMonth,
					year: lastChosenYear
				}
			});
			
			ajaxRequest.done(function (response){
				lastChosenCategorySum = parseFloat(response);
				showLimitInfo();
			});
			
			ajaxRequest.fail(function (){
				lastChosenMonth = null;
			});
	 
				//ajaxRequest.always(function(){
				//});
		}
		else
		{
			showLimitInfo();
		}
	}
	else
	{
		hideLimitInfo();
	}
}

function showLimitInfo()
{
	if(limit != null)
	{
		var amount = $('input[name=amount]').val();
		if(amount ==="") 	amount = 0.00;
		else 						amount = parseFloat(amount);
		var leftToSpend = limit - lastChosenCategorySum;
		if(leftToSpend < 0) 
			leftToSpend = 0;
		leftToSpend = leftToSpend.toFixed(2);
		
		var sum = lastChosenCategorySum+amount;
		
		var limitInfo= '<div class="attributes limitInfo ';
		if(leftToSpend < amount) limitInfo += 'red';
			
		limitInfo+='"><div class="row" style="margin-left:-5px; margin-right: 5px;"><div class="col-xs-4"><div>wydano:</div><div>'+lastChosenCategorySum.toFixed(2)+'</div></div><div class="col-xs-4"><div>pozostało:</div><div>'+leftToSpend+'</div></div><div class="col-xs-4"><div>kwota+wydano:</div><div>'+sum+'</div></div></div></div>';
		$('#limitInfo').html(limitInfo);
		$('#limitInfo').fadeIn();
	}
}

function hideLimitInfo()
{
	$('#limitInfo').fadeOut();
	//$('#limitInfo').html('');
}	

</script>