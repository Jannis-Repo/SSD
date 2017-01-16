$(function() {

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{ label: "1 Day", value: 321 },
            { label: "2 Days", value: 270 },
            { label: "3 to 6 Days", value: 75 },
            { label: "2 to 3 Weeks", value: 30 }],
        resize: true,
        colors: ['#87d6c6', '#54cdb4','#1ab394','#1ab33f'],
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{ y: 'Week', a: 15},
            { y: 'Month', a: 94},
            { y: 'Year', a: 859} ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Series A'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#1ab394'],
    });
});