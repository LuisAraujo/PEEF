function setChat(idchart, labels_chart, data_chart, label) {


    const data = {
        labels: labels_chart,
        datasets: [{
            label: label,
            backgroundColor: 'rgb(120, 120, 200)',
            data: data_chart,
        }]
    };


    const config = {
        type: 'line',
        data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: ''
                }
            }
        },
    };

    new Chart(
        document.getElementById(idchart),
        config
    );

}

function setBarChat(idchart, labels_chart, data_chart,label) {

    const data = {
        labels: labels_chart,
        datasets: [
            {
                label: label,
                data: data_chart,
                borderColor: 'rgb(50, 38, 75)',
                backgroundColor: 'rgb(120, 120, 200)',
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: ''
                }
            }
        },
    };


    new Chart(
        document.getElementById(idchart),
        config
    );

}

function setStackedBar(idchart,labels_chart, datapassed,datafaill, label1, label2) {

    const data = {
        labels: labels_chart,
        datasets: [
            {
                label: label1,
                data: datapassed,
                backgroundColor: 'rgb(77,204,60)',
            },
            {
                label: label2,
                data: datafaill,
                backgroundColor: 'rgb(204, 77,60)',
            },

        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Testes Passed/Faill'
                },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        }
    };


    new Chart(
        document.getElementById(idchart),
        config
    );

}
function setPieBar(idchart,labels_chart, data_chart) {


    const data = {
        labels: labels_chart,
        datasets: [
            {
                label: 'Test',
                data: data_chart,
                backgroundColor: ['rgb(77,204,60)', 'rgb(255,76,57)']
            }
        ]
    };


    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        },
    };


    new Chart(
        document.getElementById(idchart),
        config
    );



}