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
		if(amount ==="") 	amount = 0;
		else 						amount = parseFloat(amount);
		var leftToSpend = limit - lastChosenCategorySum;
		if(leftToSpend < 0) leftToSpend = 0;
		
		var limitInfo= '<div class="row"><div class="col-sm-3"><div>limit:</div><div>'+limit+'</div></div><div class="col-sm-3"><div>wydano:</div><div>'+lastChosenCategorySum+'</div></div><div class="col-sm-3"><div>pozostało:</div><div>'+leftToSpend+'</div></div><div class="col-sm-3"><div>kwota+wydano:</div><div>'+(lastChosenCategorySum+amount)+'</div></div></div>';
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