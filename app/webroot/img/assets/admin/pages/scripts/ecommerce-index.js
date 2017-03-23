var EcommerceIndex = function () {
    
    function showTooltip(x, y, labelX, labelY) {
        $('<div id="tooltip" class="chart-tooltip">' + (labelY.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + '<\/div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 60,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#fff'
        }).appendTo("body").fadeIn(200);
    }

    var initChart1 = function (yakiniku) {
       //console.log(sushi);

        var data = [
            ['11', yakiniku.eleven],
            ['12', yakiniku.twelve],
            ['13', yakiniku.thirteen],
            ['14', yakiniku.fourteen],
            ['15', yakiniku.fifteen],
            ['16', yakiniku.sixteen],
            ['17', yakiniku.seventeen],
            ['18', yakiniku.eighteen],
            ['19', yakiniku.nineteen],
            ['20', yakiniku.twenty],
            ['21', yakiniku.twenty_one],
            ['22', yakiniku.twenty_two],
            ['23', yakiniku.twenty_three],
            ['24', yakiniku.twenty_four],
        ];

            var plot_statistics = $.plot(
                $("#statistics_1"), 
                [
                    {
                        data:data,
                        lines: {
                            fill: 0.6,
                            lineWidth: 0
                        },
                        color: ['#f89f9f']
                    },
                    {
                        data: data,
                        points: {
                            show: true,
                            fill: true,
                            radius: 5,
                            fillColor: "#f89f9f",
                            lineWidth: 3
                        },
                        color: '#fff',
                        shadowSize: 0
                    }
                ], 
                {

                    xaxis: {
                        tickLength: 0,
                        tickDecimals: 0,                        
                        mode: "categories",
                        min: 0,
                        font: {
                            lineHeight: 15,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    yaxis: {
                        ticks: 5,
                        tickDecimals: 0,
                        tickColor: "#f0f0f0",
                        font: {
                            lineHeight: 15,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    grid: {
                        backgroundColor: {
                            colors: ["#fff", "#fff"]
                        },
                        borderWidth: 1,
                        borderColor: "#f0f0f0",
                        margin: 0,
                        minBorderMargin: 0,
                        labelMargin: 20,
                        hoverable: true,
                        clickable: true,
                        mouseActiveRadius: 6
                    },
                    legend: {
                        show: false
                    }
                }
            );

            var previousPoint = null;

            $("#statistics_1").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

                        showTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1]);
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });

    }

    var initChart2 = function(sushi) {
        //console.log(sushi);

        var data = [
            ['11', sushi.eleven],
            ['12', sushi.twelve],
            ['13', sushi.thirteen],
            ['14', sushi.fourteen],
            ['15', sushi.fifteen],
            ['16', sushi.sixteen],
            ['17', sushi.seventeen],
            ['18', sushi.eighteen],
            ['19', sushi.nineteen],
            ['20', sushi.twenty],
            ['21', sushi.twenty_one],
            ['22', sushi.twenty_two],
            ['23', sushi.twenty_three],
            ['24', sushi.twenty_four],
        ];

            var plot_statistics = $.plot(
                $("#statistics_2"), 
                [
                    {
                        data:data,
                        lines: {
                            fill: 0.6,
                            lineWidth: 0
                        },
                        color: ['#BAD9F5']
                    },
                    {
                        data: data,
                        points: {
                            show: true,
                            fill: true,
                            radius: 5,
                            fillColor: "#BAD9F5",
                            lineWidth: 3
                        },
                        color: '#fff',
                        shadowSize: 0
                    }
                ], 
                {

                    xaxis: {
                        tickLength: 0,
                        tickDecimals: 0,                        
                        mode: "categories",
                        min: 0,
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    yaxis: {
                        ticks: 5,
                        tickDecimals: 0,
                        tickColor: "#f0f0f0",
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    grid: {
                        backgroundColor: {
                            colors: ["#fff", "#fff"]
                        },
                        borderWidth: 1,
                        borderColor: "#f0f0f0",
                        margin: 0,
                        minBorderMargin: 0,
                        labelMargin: 20,
                        hoverable: true,
                        clickable: true,
                        mouseActiveRadius: 6
                    },
                    legend: {
                        show: false
                    }
                }
            );

            var previousPoint = null;

            $("#statistics_2").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

                       showTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1]);
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });

    }

    return {

        //main function
        init: function (yakiniku, sushi) {
            initChart1(yakiniku);

            $('#statistics_amounts_tab').on('shown.bs.tab', function (e) {
                initChart2(sushi);
            });
        }

    };

}();