var lineData, myLineChart;

$.lineChart = function (date, data) {
    lineData = {
        labels: date,
        datasets: [
            {
                label: "活跃用户",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: data,
                spanGaps: false
            }
        ]
    };

    myLineChart = new Chart(document.getElementById("myLineChart"), {
        type: 'line',
        data: lineData,
        options: {
            showLines : true,
            spanGaps : false
        }
    });
};

$.donutChart = function (platform, platformCount) {
    var donutData = {
        labels: platform,
        datasets: [
            {
                data: platformCount,
                backgroundColor: [
                    "#dd4b39",
                    "#0073b7",
                    "#FFCE56",
                    "#00a65a"
                ],
                hoverBackgroundColor: [
                    "#dd4b39",
                    "#0073b7",
                    "#FFCE56",
                    "#00a65a"
                ]
            }]
    };

    var myDonutChart = new Chart(document.getElementById("myDonutChart"), {
        type: 'doughnut',
        data: donutData
    });
};

$('input[name="datefilter"]').daterangepicker({
    locale: {
        format: 'YYYY-MM-DD'
    }
});

$('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
    var date = picker.startDate.format('YYYY/MM/DD') + ' ~ ' + picker.endDate.format('YYYY/MM/DD');
    $(this).val(date);

    var dates = new Array();
    var counts = new Array();

    $.ajax({
        url: 'search',
        data: {
            date: date
        },
        type: 'get',
        async: false,
        success: function(data){
            var jsonData = JSON.parse(data);

            for(var item in jsonData){
                dates.push(item);
                counts.push(jsonData[item]);
            }

            lineData.labels = dates;
            lineData.datasets[0].data = counts;
            myLineChart.update();
        }
    });
});

$('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});

