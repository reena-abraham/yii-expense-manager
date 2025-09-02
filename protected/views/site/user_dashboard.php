<div class="container mt-5">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h2>User Dashboard</h2>
        <p>Welcome, <?php echo CHtml::encode($user->name); ?>!</p>
    </div>

    <div class="row mt-4">
        <!-- Summary Column -->
        <?php if (!empty($totalSpent) || !empty($mostExpensiveCategory)): ?>
            <div class="col-md-6">
                <div class="card summary-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($totalSpent)): ?>
                            <h4>Total spent this month:</h4>
                            <p class="text-success">$<?= $totalSpent ?></p>
                        <?php endif; ?>
                        <?php if (!empty($mostExpensiveCategory)): ?>
                            <h4>Most expensive category:</h4>
                            <p class="text-info"><?= $mostExpensiveCategory ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- Pie Chart Column -->
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Example data (replace with your dynamic data from Yii)
            //var labels = ['Food', 'Travel', 'Entertainment', 'Utilities']; // Category names
            //var data = [30, 60, 10, 5]; // Amount spent per category
            var labels = <?php echo json_encode($labels); ?>;
            var data = <?php echo json_encode($data); ?>;

            const colors = ['red', 'blue', 'green', 'orange', 'purple'];
            // Pie chart configuration

            var ctx = document.getElementById('pieChart').getContext('2d');
            var pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': $' + tooltipItem.raw.toFixed(2);
                            }
                        }
                    }
                }
            });
        });
    </script>