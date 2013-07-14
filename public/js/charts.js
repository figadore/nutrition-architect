google.load('visualization', '1.0', {'packages':['corechart']});
google.setOnLoadCallback(drawChart);
function drawChart() 
{
	var data = new google.visualization.DataTable();
	data.addColumn("string", "Portion");
	data.addColumn("number", "Portions");
	data.addRows([
			["Eaten", 3],
			["Remaining", 9]
			]);
	var options = {"title":"Lasagna",
		"colors":["black", "white"],
		"width":400,
		"height":300};		
	var chart = new google.visualization.PieChart(
			document.getElementById('chart_div'));
	//chart.draw(data, options);

}
