<?php
session_start();
require "../../model/statistic.php";

$stats = new Statistics();
$teacherId = $_SESSION['user_id'];


$totalStudents = $stats->getTeacherTotalStudents($teacherId);
$topCourses = $stats->getTopPerformingCourses($teacherId);
$monthlyEnrollments = $stats->getMonthlyEnrollments($teacherId);


$labels = [];
$data = [];
foreach ($monthlyEnrollments as $enrollment) {
    $labels[] = $enrollment['month'];
    $data[] = $enrollment['enrollment_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">


    <div class="flex min-h-screen">
      

        <div class="flex-1 p-8">
            <!-- Analytics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Students</h3>
                    <p class="text-3xl font-bold"><?php echo $totalStudents; ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Course Completion Rate</h3>
                    <p class="text-3xl font-bold">78%</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Active Courses</h3>
                    <p class="text-3xl font-bold"><?php echo count($topCourses); ?></p>
                </div>
            </div>

            <!-- Enrollment Trends Chart -->
            <div class="bg-white p-6 rounded-lg shadow mb-8">
                <h2 class="text-xl font-bold mb-4">Monthly Enrollment Trends</h2>
                <canvas id="enrollmentChart"></canvas>
            </div>

            <!-- Top Performing Courses -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Top Performing Courses</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollments</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($topCourses as $course): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($course['title']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $course['enrollment_count']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
   
        const ctx = document.getElementById('enrollmentChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Monthly Enrollments',
                    data: <?php echo json_encode($data); ?>,
                    borderColor: 'rgb(147, 51, 234)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>