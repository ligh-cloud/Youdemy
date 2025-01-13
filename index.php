<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Plateforme d'apprentissage innovante</title>
    <!-- CSS Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notyf/3.10.0/notyf.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css">
    
    <!-- Custom Styles -->
    <style>
        .loading-skeleton {
            animation: skeleton-loading 1s linear infinite alternate;
        }
        
        @keyframes skeleton-loading {
            0% { background-color: #e5e7eb; }
            100% { background-color: #f3f4f6; }
        }

        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .tag-cloud span {
            transition: all 0.3s ease;
        }

        .tag-cloud span:hover {
            transform: scale(1.1);
        }

        .category-filter {
            transition: all 0.3s ease;
        }

        .category-filter:hover {
            background-color: #e5e7eb;
        }

        .category-filter.active {
            background-color: #3b82f6;
            color: white;
        }

        #progressBar {
            transition: width 0.3s ease;
        }

        .modal {
            transition: opacity 0.3s ease;
        }

        .dropdown-content {
            transition: transform 0.2s ease, opacity 0.2s ease;
            transform-origin: top right;
        }

        .dropdown-content.hidden {
            transform: scale(0.95);
            opacity: 0;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1 z-50">
        <div id="progressBar" class="h-full bg-blue-600 w-0"></div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="/api/placeholder/40/40" alt="Logo" class="h-10 w-10 rounded-lg mr-2">
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 text-transparent bg-clip-text">Youdemy</h1>
                    </div>
                    <div class="hidden lg:flex lg:space-x-8 ml-10">
                        <a href="#" class="nav-link active" data-section="home">Accueil</a>
                        <a href="#" class="nav-link" data-section="courses">Cours</a>
                        <a href="#" class="nav-link student-only hidden" data-section="my-courses">Mes Cours</a>
                        <a href="#" class="nav-link teacher-only hidden" data-section="manage">Gérer</a>
                        <a href="#" class="nav-link teacher-only hidden" data-section="stats">Statistiques</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="hidden md:block relative">
                        <input type="search" 
                               id="search-input"
                               class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Rechercher un cours...">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <!-- Auth Buttons -->
                    <div id="auth-buttons">
                        <button class="login-btn px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                        <a href="view/signup.php"> Connexion</a>
                        </button>
                        <button class="register-btn ml-2 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                           <a href="view/signup.php"> Inscription</a>
                        </button>
                    </div>

                    <!-- User Menu (Hidden by default) -->
                    <div id="user-menu" class="hidden relative">
                        <button class="user-menu-btn flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-full hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <img src="/api/placeholder/32/32" alt="Profile" class="w-8 h-8 rounded-full">
                            <span class="hidden md:inline" id="user-name">John Doe</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-content hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Mon Profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Paramètres
                                </a>
                                <hr class="my-1">
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Button -->
    <div class="lg:hidden fixed bottom-4 right-4 z-50">
        <button id="mobile-menu-btn" class="p-4 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden fixed inset-0 z-40 bg-black bg-opacity-50">
        <div class="fixed inset-y-0 right-0 w-64 bg-white shadow-xl">
            <div class="flex flex-col h-full">
                <div class="p-4 border-b">
                    <button id="close-mobile-menu" class="float-right text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="text-lg font-medium">Menu</h3>
                </div>
                <div class="flex-1 overflow-y-auto py-4">
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Accueil</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Cours</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 student-only hidden">Mes Cours</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 teacher-only hidden">Gérer</a>
                    <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 teacher-only hidden">Statistiques</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1">
        <!-- Hero Section -->
        <section id="hero" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6" data-aos="fade-up">
                        Apprenez à votre rythme
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-blue-100" data-aos="fade-up" data-aos-delay="100">
                        Des milliers de cours pour développer vos compétences
                    </p>
                    <div class="flex justify-center space-x-4" data-aos="fade-up" data-aos-delay="200">
                        <button class="px-8 py-3 bg-white text-blue-600 rounded-full font-medium hover:bg-gray-100 transition-all duration-300">
                            Commencer
                        </button>
                        <button class="px-8 py-3 bg-transparent border-2 border-white rounded-full font-medium hover:bg-white hover:text-blue-600 transition-all duration-300">
                            En savoir plus
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-8 text-center" data-aos="fade-up">Catégories populaires</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="categories-grid">
                    <!-- Categories will be dynamically inserted here -->
                </div>
            </div>
        </section>

        <!-- Courses Section -->
        <section class="py-12" id="courses-section">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <h2 class="text-3xl font-bold mb-4 md:mb-0" data-aos="fade-right">Cours disponibles</h2>
                    <div class="flex flex-wrap gap-2" data-aos="fade-left">
                        <button class="category-filter active px-4 py-2 rounded-full text-sm">Tous</button>
                        <button class="category-filter px-4 py-2 rounded-full text-sm">Développement</button>
                        <button class="category-filter px-4 py-2 rounded-full text-sm">Design</button>
                        <button class="category-filter px-4 py-2 rounded-full text-sm">Business</button>
                    </div>
                </div>

                <!-- Course Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="courses-grid">
                    <!-- Courses will be dynamically inserted here -->
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center space-x-2" id="pagination">
                    <!-- Pagination will be dynamically inserted here -->
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">À propos</h3>
                    <p class="text-gray-400">Youdemy est une plateforme d'apprentissage en ligne innovante qui connecte les étudiants aux meilleurs enseignants.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cours</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Enseignants</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> contact@youdemy.com</li>
                        <li><i class="fas fa-phone mr-2"></i> +33 1 23 45 67 89</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Paris, France</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; 2024 Youdemy. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Course Preview Modal -->
    <div id="course-preview-modal" class="modal hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Modal content will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notyf/3.10.0/notyf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <!-- Main JavaScript -->
    <script>
        // Initialize libraries
        AOS.init({
            duration: 800,
            once: true
        });

        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' }
        });

        // Global state
        const state = {
            currentPage: 1,
            itemsPerPage: 9,
            currentCategory: 'all',
            courses: [],
            isLoading: false,
            user: null
        };

        // Course data management
        class CourseManager {
            static async fetchCourses() {
                state.isLoading = true;
                updateUI();

                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1000));

                state.courses = Array(20).fill(null).map((_, index) => ({
                    id: index + 1,
                    title: `Cours ${index + 1}`,
                    description: 'Une description détaillée du cours...',
                    teacher: 'John Doe',
                    category: ['Développement', 'Design', 'Business'][Math.floor(Math.random() * 3)],
                    rating: (Math.random() * 2 + 3).toFixed(1),
                    students: Math.floor(Math.random() * 1000),
                    price: Math.floor(Math.random() * 100) + 9.99,
                    image: `/api/placeholder/400/250`
                }));

                state.isLoading = false;
                updateUI();
            }

            static filterCourses() {
                const searchTerm = document.getElementById('search-input').value.toLowerCase();
                return state.courses.filter(course => {
                    const matchesSearch = course.title.toLowerCase().includes(searchTerm) ||
                                        course.description.toLowerCase().includes(searchTerm);
                    const matchesCategory = state.currentCategory === 'all' || 
                                          course.category.toLowerCase() === state.currentCategory;
                    return matchesSearch && matchesCategory;
                });
            }
        }

        // UI management
        class UIManager {
            static renderCourseCard(course) {
                return `
                    <div class="course-card bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up">
                        <img src="${course.image}" alt="${course.title}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    ${course.category}
                                </span>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="ml-1 text-gray-600">${course.rating}</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">${course.title}</h3>
                            <p class="text-gray-600 mb-4">${course.description}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="/api/placeholder/32/32" alt="Teacher" class="w-8 h-8 rounded-full">
                                    <span class="ml-2 text-sm text-gray-600">${course.teacher}</span>
                                </div>
                                <span class="text-lg font-bold text-blue-600">${course.price}€</span>
                            </div>
                            <button onclick="previewCourse(${course.id})" 
                                    class="mt-4 w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Voir le détail
                            </button>
                        </div>
                    </div>
                `;
            }

            static renderSkeletonCard() {
                return `
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="w-full h-48 loading-skeleton"></div>
                        <div class="p-6">
                            <div class="w-1/3 h-6 loading-skeleton mb-2"></div>
                            <div class="w-full h-4 loading-skeleton mb-2"></div>
                            <div class="w-2/3 h-4 loading-skeleton"></div>
                        </div>
                    </div>
                `;
            }

            static updatePagination() {
                const filteredCourses = CourseManager.filterCourses();
                const totalPages = Math.ceil(filteredCourses.length / state.itemsPerPage);
                const pagination = document.getElementById('pagination');
                
                let paginationHTML = '';
                
                if (totalPages > 1) {
                    paginationHTML += `
                        <button onclick="changePage(${Math.max(1, state.currentPage - 1)})" 
                                class="px-3 py-1 rounded-md ${state.currentPage === 1 ? 'bg-gray-100 text-gray-400' : 'bg-white hover:bg-gray-50'}">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    `;

                    for (let i = 1; i <= totalPages; i++) {
                        paginationHTML += `
                            <button onclick="changePage(${i})" 
                                    class="px-3 py-1 rounded-md ${i === state.currentPage ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-50'}">
                                ${i}
                            </button>
                        `;
                    }

                    paginationHTML += `
                        <button onclick="changePage(${Math.min(totalPages, state.currentPage + 1)})" 
                                class="px-3 py-1 rounded-md ${state.currentPage === totalPages ? 'bg-gray-100 text-gray-400' : 'bg-white hover:bg-gray-50'}">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    `;
                }

                pagination.innerHTML = paginationHTML;
            }
        }

        // Event handlers
        function updateUI() {
            const coursesGrid = document.getElementById('courses-grid');
            
            if (state.isLoading) {
                coursesGrid.innerHTML = Array(6).fill(UIManager.renderSkeletonCard()).join('');
                return;
            }

            const filteredCourses = CourseManager.filterCourses();
            const start = (state.currentPage - 1) * state.itemsPerPage;
            const end = start + state.itemsPerPage;
            const coursesToShow = filteredCourses.slice(start, end);

            coursesGrid.innerHTML = coursesToShow.map(UIManager.renderCourseCard).join('');
            UIManager.updatePagination();
        }

        function changePage(page) {
            state.currentPage = page;
            updateUI();
            window.scrollTo({ top: document.getElementById('courses-section').offsetTop - 100, behavior: 'smooth' });
        }

        function previewCourse(courseId) {
            const course = state.courses.find(c => c.id === courseId);
            if (!course) return;

            const modal = document.getElementById('course-preview-modal');
            const modalContent = modal.querySelector('.sm\\:p-6');

            modalContent.innerHTML = `
                <div class="space-y-6">
                    <div class="relative">
                        <img src="${course.image}" alt="${course.title}" class="w-full h-64 object-cover rounded-lg">
                        <span class="absolute top-4 right-4 px-4 py-2 bg-blue-600 text-white rounded-full">
                            ${course.price}€
                        </span>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold">${course.title}</h2>
                        <p class="text-gray-600">${course.description}</p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span>${course.rating}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users text-gray-400 mr-1"></i>
                                <span>${course.students} étudiants</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <img src="/api/placeholder/48/48" alt="${course.teacher}" class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="font-medium">${course.teacher}</h3>
                                <p class="text-sm text-gray-500">Instructeur</p>
                            </div>
                        </div>
                        <button class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            S'inscrire au cours
                        </button>
                    </div>
                </div>
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-500" onclick="closeCoursePreview()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCoursePreview() {
            const modal = document.getElementById('course-preview-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', () => {
            CourseManager.fetchCourses();

            // Scroll progress
            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                document.getElementById('progressBar').style.width = scrolled + '%';
            });

            // Search input
            let searchTimeout;
            document.getElementById('search-input').addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    state.currentPage = 1;
                    updateUI();
                }, 300);
            });

            // Category filters
            document.querySelectorAll('.category-filter').forEach(button => {
                button.addEventListener('click', () => {
                    document.querySelectorAll('.category-filter').forEach(b => b.classList.remove('active'));
                    button.classList.add('active');
                    state.currentCategory = button.textContent.toLowerCase();
                    state.currentPage = 1;
                    updateUI();
                });
            });

            // Mobile menu
            document.getElementById('mobile-menu-btn').addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.remove('hidden');
            });

            document.getElementById('close-mobile-menu').addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });

            // Course preview modal close on outside click
            document.getElementById('course-preview-modal').addEventListener('click', (e) => {
                if (e.target === e.currentTarget) {
                    closeCoursePreview();
                }
            });
        });
    </script>
</body>
</html>