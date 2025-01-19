<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting for Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .spinner {
            border: 3px solid rgba(59, 130, 246, 0.1);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border-top-color: #3B82F6;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl card-shadow p-8 max-w-md w-full mx-4">
        <div class="text-center space-y-6">
            <!-- Status Icon -->
            <div class="relative">
                <div class="spinner mx-auto"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fas fa-user-clock text-blue-500 text-xl"></i>
                </div>
            </div>

            <!-- Status Message -->
            <div class="space-y-3">
                <h2 class="text-2xl font-bold text-gray-800">Waiting for Approval</h2>
                <p class="text-gray-600 leading-relaxed">
                    Your account is currently under review. Our admin team will process your request shortly.
                </p>
            </div>

            <!-- Current Status -->
            <div class="bg-blue-50 rounded-lg p-4 flex items-center justify-center space-x-2">
                <div class="h-2 w-2 bg-blue-500 rounded-full pulse"></div>
                <span class="text-blue-600 font-medium">Review in Progress</span>
            </div>

            <!-- Timestamp -->
            <div class="text-sm text-gray-500">
                <p>Last Updated: <?php echo date('Y-m-d H:i:s'); ?></p>
                <p>User: <?php echo htmlspecialchars($_SESSION['nom']); ?></p>
            </div>

            <!-- Action Button -->
            <form method="POST" action="../../controller/public/AuthController.php" class="mt-6">
                <button
                    name="logout"
                    type="submit"
                    class="w-full px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg
                           hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 
                           focus:ring-offset-2 transform transition-all duration-200 
                           hover:scale-[1.02] active:scale-[0.98]">
                    <span class="flex items-center justify-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Return to Login</span>
                    </span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>