<?php
session_start();
require "../../model/statistics.php";

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-2xl font-bold tracking-wider">
                    <i class="fas fa-chart-line mr-2"></i>Course Analytics
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-lg">
                        <i class="fas fa-user-circle text-xl"></i>
                        <span class="font-medium"><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom']; ?></span>
                    </div>
                    <form method="POST" action="../../controller/public/AuthController.php">
                        <button name="logout" type="submit" 
                                class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg 
                                       hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 
                                       focus:ring-offset-2 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-xl">
            <div class="p-6">
                <div class="space-y-1">
                    <a href="teacher_dashboard.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="get_my_courses.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="#" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-users"></i>
                        <span>Students</span>
                    </a>
                    <a href="statistics.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-50 
                              transition-all duration-200 text-blue-600">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </div>
            </div>
        </div>


        <div class="flex-1 p-8">
     
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Analytics Overview</h1>
                <p class="text-sm text-gray-600 mt-1">Track your course performance and student engagement</p>
            </div>

  
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-600 font-medium">Total Students</h3>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $totalStudents; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-pie text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-600 font-medium">Completion Rate</h3>
                            <p class="text-3xl font-bold text-gray-800">78%</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-600 font-medium">Active Courses</h3>
                            <p class="text-3xl font-bold text-gray-800"><?php echo count($topCourses); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
             
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Monthly Enrollment Trends</h2>
                    <div class="h-80">
                        <canvas id="enrollmentChart"></canvas>
                    </div>
                </div>

           
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Top Performing Courses</h2>
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Course
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Enrollments
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($topCourses as $course): ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($course['title']); ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?php echo $course['enrollment_count']; ?> students
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
                    borderColor: 'rgb(37, 99, 235)',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: 'rgb(37, 99, 235)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

    <style>
        body {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</body>
</html>