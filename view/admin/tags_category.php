<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tag and Category Management</title>
    <script src="https://unpkg.com/htmx.org@1.7.0"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Add Tags (Mass Insert)</h2>
        <form id="mass-insert-form" hx-post="../../controller/admin/add-tags.php" hx-target="#tags-message" hx-swap="outerHTML">
            <div class="mb-4">
                <label for="tags" class="block text-gray-700">Tags (comma-separated):</label>
                <input type="text" id="tags" name="tags" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <button name="add_tag" type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-all">Add Tags</button>
        </form>
        <div id="tags-message" class="mt-4"></div>
        <div id="tags-list" class="mt-4">
            <!-- Tags will be loaded here -->
        </div>
    </div>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
        <h2 class="text-2xl font-bold mb-4">Add Category</h2>
        <form id="category-form" hx-post="../../controller/admin/add-tags.php" hx-target="#category-message" hx-swap="outerHTML">
            <div class="mb-4">
                <label for="category" class="block text-gray-700">Category Name:</label>
                <input type="text" id="category" name="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="description" placeholder="Description"></textarea>
            </div>
            <button name="add_category" type="submit" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 transition-all">Add Category</button>
        </form>
        <div id="category-message" class="mt-4"></div>
        <div id="categories-list" class="mt-4">
            
        </div>
    </div>

    <script>
        function loadTags(page = 1) {
            fetch(`get-tags.php?page=${page}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('tags-list').innerHTML = html;
                });
        }

        function loadCategories(page = 1) {
            fetch(`get-categories.php?page=${page}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('categories-list').innerHTML = html;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadTags();
            loadCategories();
        });
    </script>
</body>
</html>