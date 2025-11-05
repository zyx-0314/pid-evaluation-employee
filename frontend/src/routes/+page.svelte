<script>
	// PID Employee Evaluation System - User Interface
	// Clean code: Simple, readable component structure
</script>

<svelte:head>
	<title>PID Employee Evaluation - User Portal</title>
</svelte:head>

<div class="min-h-screen bg-gray-100">
	<!-- Navigation -->
	<nav class="bg-blue-600 text-white p-4 shadow-lg">
		<div class="container mx-auto flex justify-between items-center">
			<h1 class="text-2xl font-bold">Employee Evaluation Portal</h1>
			<div class="space-x-4">
				<a href="/" class="hover:text-blue-200">Home</a>
				<a href="/evaluations" class="hover:text-blue-200">My Evaluations</a>
				<a href="/profile" class="hover:text-blue-200">Profile</a>
			</div>
		</div>
	</nav>

	<!-- Main Content -->
	<main class="container mx-auto mt-8 px-4">
		<div class="bg-white rounded-lg shadow-md p-8">
			<h2 class="text-3xl font-bold text-gray-800 mb-6">Welcome to the Employee Portal</h2>
			
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				<!-- My Evaluations Card -->
				<div class="bg-blue-50 border border-blue-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
					<div class="text-blue-600 text-4xl mb-4">📊</div>
					<h3 class="text-xl font-semibold text-gray-800 mb-2">My Evaluations</h3>
					<p class="text-gray-600 mb-4">View your performance evaluations and feedback</p>
					<a href="/evaluations" 
					   class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
						View Evaluations
					</a>
				</div>

				<!-- Profile Card -->
				<div class="bg-green-50 border border-green-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
					<div class="text-green-600 text-4xl mb-4">👤</div>
					<h3 class="text-xl font-semibold text-gray-800 mb-2">My Profile</h3>
					<p class="text-gray-600 mb-4">Update your personal information and settings</p>
					<a href="/profile" 
					   class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
						View Profile
					</a>
				</div>

				<!-- Goals Card -->
				<div class="bg-purple-50 border border-purple-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
					<div class="text-purple-600 text-4xl mb-4">🎯</div>
					<h3 class="text-xl font-semibold text-gray-800 mb-2">My Goals</h3>
					<p class="text-gray-600 mb-4">Track your progress and achievements</p>
					<a href="/goals" 
					   class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
						View Goals
					</a>
				</div>
			</div>

			<!-- Info Section -->
			<div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
				<h3 class="text-lg font-semibold text-gray-800 mb-2">📝 System Information</h3>
				<ul class="space-y-2 text-gray-700">
					<li><strong>Frontend:</strong> SvelteKit with Tailwind CSS</li>
					<li><strong>Backend:</strong> YII2 PHP Framework</li>
					<li><strong>Database:</strong> MySQL (simulating AWS RDS)</li>
					<li><strong>Storage:</strong> LocalStack S3 (simulating AWS S3)</li>
				</ul>
			</div>
		</div>
	</main>

	<!-- Footer -->
	<footer class="mt-16 py-8 bg-gray-800 text-white text-center">
		<p>&copy; {new Date().getFullYear()} PID Employee Evaluation System</p>
		<p class="text-sm text-gray-400 mt-2">Built with clean code principles and KISS methodology</p>
	</footer>
</div>
