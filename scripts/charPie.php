<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		
<script type="text/javascript">

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

	var data = google.visualization.arrayToDataTable([
	  ['Wydatki', 'PLN per period']
	  <?PHP foreach ($expenseCategorySum as $categoryName => $amount ):?>
		 , ['<?=$categoryName?>', <?=$amount?>]
	  <?PHP endforeach; ?>
		]);

	var options = {
	  'backgroundColor': 'transparent', is3D: true,'width': 300, 'height':150, 'forceIFrame':true, 'chartArea':{width:'100%',height:'100%'}, 'sliceVisibilityThreshold': 0, 'legend': {position: 'labeled'}, 'pieSliceText':'label'
	};

	var chart = new google.visualization.PieChart(document.getElementById('piechart'));

	chart.draw(data, options);
  }
  
</script>