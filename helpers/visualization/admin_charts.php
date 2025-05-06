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