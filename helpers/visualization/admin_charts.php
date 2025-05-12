<!-- doughnut_chart.php -->
<script>
    const chartColors = {
        background: '#81d4fa',
        datalessRegion: '#f8bbd0',
        default: '#f5f5f5'
    };

    document.addEventListener('DOMContentLoaded', () => {
        const chartElement = document.getElementById('doughnutChart');
        if (chartElement) {
            const ctx = chartElement.getContext('2d');
            const doughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Administrator', 'Landlord', 'Tenant'],
                    datasets: [{
                        data: [<?php echo $total_admin ?>, <?php echo $total_landlords ?>, <?php echo $total_tenants ?>],
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>
<!-- Area chart annual rent collected -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chartElement = document.getElementById('areaChart');
        if (chartElement) {
            const ctx = chartElement.getContext('2d');
            const areaChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [{
                        label: <?php echo json_encode('Annual Collected Rent ' . date('Y')); ?>,
                        data: <?php echo json_encode($total_successful_payments); ?>,
                        backgroundColor: 'rgba(48, 110, 180, 0.2)',
                        borderColor: 'rgb(100, 195, 224)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        }
    });
</script>
<!-- Line chart for tenant and landlord registration -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chartElement = document.getElementById('lineChart');
        if (chartElement) {
            const ctx = chartElement.getContext('2d');
            const lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [{
                            label: <?php echo json_encode('Tenants Registered on ' . date('Y')); ?>,
                            data: <?php echo json_encode($total_tenants_registered); ?>,
                            backgroundColor: 'rgba(221, 224, 221, 0.2)',
                            borderColor: 'rgb(152, 6, 189)',
                            borderWidth: 1
                        },
                        {
                            label: <?php echo json_encode('Landlords Registered on ' . date('Y')); ?>,
                            data: <?php echo json_encode($total_landlords_registered); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        }
    });
</script>

<!-- visualization chart -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        const chartElement = document.getElementById('geochart-markers');
        if (!chartElement) return;

        google.charts.load('current', {
            packages: ['geochart'],
           
        });

        google.charts.setOnLoadCallback(drawMarkersMap);

        let isChartDrawn = false;

        function drawMarkersMap() {
            if (isChartDrawn) return;

            const locationData = <?php
                                    echo json_encode($locationData);
                                    ?>;

            const data = new google.visualization.DataTable();
            data.addColumn('string', 'UserID');
            data.addColumn('number', 'Latitude');
            data.addColumn('number', 'Longitude');

            locationData.forEach(loc => {
                data.addRow([loc.user_id, loc.latitude, loc.longitude]);
            });

            const options = {
                displayMode: 'markers',
                colorAxis: {
                    colors: ['green', 'blue']
                },
                backgroundColor: '#81d4fa',
                datalessRegionColor: '#f8bbd0',
                defaultColor: '#f5f5f5'
            };

            const chart = new google.visualization.GeoChart(chartElement);
            chart.draw(data, options);
            isChartDrawn = true;
        }
    });
</script>