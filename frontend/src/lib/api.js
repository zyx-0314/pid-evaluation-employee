/**
 * API Service for Frontend
 * 
 * Simple API client following KISS principle
 * Connects SvelteKit frontend to YII2 backend
 */

const API_BASE_URL = import.meta.env.PUBLIC_API_URL || 'http://localhost:8080';

/**
 * Fetch employees from API
 */
export async function getEmployees() {
	try {
		const response = await fetch(`${API_BASE_URL}/api/employees`);
		const data = await response.json();
		return data;
	} catch (error) {
		console.error('Error fetching employees:', error);
		return { success: false, error: error.message };
	}
}

/**
 * Fetch single employee
 */
export async function getEmployee(id) {
	try {
		const response = await fetch(`${API_BASE_URL}/api/employees/${id}`);
		const data = await response.json();
		return data;
	} catch (error) {
		console.error('Error fetching employee:', error);
		return { success: false, error: error.message };
	}
}

/**
 * Fetch evaluations from API
 */
export async function getEvaluations() {
	try {
		const response = await fetch(`${API_BASE_URL}/api/evaluations`);
		const data = await response.json();
		return data;
	} catch (error) {
		console.error('Error fetching evaluations:', error);
		return { success: false, error: error.message };
	}
}

/**
 * Fetch single evaluation
 */
export async function getEvaluation(id) {
	try {
		const response = await fetch(`${API_BASE_URL}/api/evaluations/${id}`);
		const data = await response.json();
		return data;
	} catch (error) {
		console.error('Error fetching evaluation:', error);
		return { success: false, error: error.message };
	}
}

/**
 * Login user
 */
export async function login(username, password) {
	try {
		const formData = new FormData();
		formData.append('username', username);
		formData.append('password', password);

		const response = await fetch(`${API_BASE_URL}/site/login`, {
			method: 'POST',
			body: formData
		});

		return { success: response.ok };
	} catch (error) {
		console.error('Error logging in:', error);
		return { success: false, error: error.message };
	}
}
