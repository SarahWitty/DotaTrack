$(document).ready(function() {
	var example = [
		{matchId: 012345, kills: 50},
		{matchId: 012346, kills: 13},
		{matchId: 012347, kills: 1}
	];
	var data = transformData(example, "kills");
	constructGraph("#cows", data);
});

/**
 * Transforms raw data from the server get_statistics into NVD3 graph data.
 *
 * @param data The data from get_statistics as a javascript array of objects
 * containing key/value pairs to represent each field.
 * @param yColumn The name of the field that should be used as the y values.
 * @param xColumn The name of the field that should be used as the x values.
 *
 * @return An array containing a single datum for a NVD3 graph.
 */
function transformData(data, yColumn, xColumn)
{
	var valueArray = [];
	var yFieldName = yColumn;

	// Iterate over each of the data elements
	$.each(data, function(index, element) {
		valueArray.push({});
		// Iterate over each of the properties of element
		$.each(element, function(name, property) {
			// If this is the field we've designated as the y values or if we haven't designated a y value field
			if((yColumn && yColumn == name) || !yColumn)
			{
				valueArray[valueArray.length-1].y = property;

				// If no field was designated as the y values, then store the field name
				if(!yColumn)
				{
					yFieldName = name;
				}

				// If no field was designated as the x values, use the index of the element
				if(!xColumn)
				{
					valueArray[valueArray.length-1].x = index;
				}
			}
			// If this is the field we've designated as the x values
			else if(xColumn && xColumn == name)
			{
				valueArray[valueArray.length-1].x = property;
			}
		});
	});

	return [{
		key: yFieldName,
		values: valueArray,
		color: "#ff0000"
	}];
}

/**
 * Constructs a basic line graph using the given data, placing it in the html
 * element with the given id.
 *
 * @param selector The css selector of an SVG element which will contain the graph.
 * @param data The data which will construct the graph.
 */
function constructGraph(selector, data)
{
	nv.addGraph(function() {
		var chart = nv.models.lineChart();

		chart.xAxis
			.axisLabel("Matches");

		chart.yAxis
			.axisLabel(data[0].key)
			.tickFormat(d3.format("d"));

		d3.select(selector)
			.datum(data)
			.transition().duration(500).call(chart);

		nv.utils.windowResize(function() {
			chart.update();
		});

		return chart;
	});
}
