<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting for Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-left-color: #2b6cb0;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <div class="spinner mx-auto mb-4"></div>
        <h2 class="text-2xl font-bold text-gray-700">Waiting for Approval</h2>
        <p class="text-gray-600">Your account is currently under review. Please wait for admin approval.</p>
    </div>
    <form method="POST" action="../../controller/public/AuthController.php" class="flex justify-center items-center p-4 bg-gray-100 rounded-lg shadow-md">
                        <button
                            name="logout"
                            type="submit"
                            class="px-4 py-2 bg-grey-500 text-white font-semibold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition-all">
                            Go Back
                        </button>
                    </form>
</body>
</html>