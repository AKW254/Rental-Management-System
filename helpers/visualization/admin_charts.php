<!-- doughnut_chart.php -->
<script>
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