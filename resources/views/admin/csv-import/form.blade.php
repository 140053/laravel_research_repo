<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Import CSV File
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Import Research Papers</h1>
            
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Instructions</h2>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Upload a CSV file with research paper data</li>
                    <li>First row should contain column headers</li>
                    <li>Title is required, other fields are optional</li>
                    <li>Maximum file size: 10MB</li>
                </ul>
            </div>

            <div class="mb-6">
                <a href="{{ route('admin.csv-import.template') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Template
                </a>
            </div>

            <form id="csvImportForm" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Select CSV File
                    </label>
                    <input type="file" 
                           id="csv_file" 
                           name="csv_file" 
                           accept=".csv,.txt"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                           required>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" 
                            id="submitBtn"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Import Data
                    </button>
                    
                    <div id="loadingSpinner" class="hidden">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"></div>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            <div id="results" class="mt-6 hidden">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Import Results</h3>
                    <div id="resultsContent"></div>
                </div>
            </div>

            <!-- Error Section -->
            <div id="error" class="mt-6 hidden">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-red-900 mb-2">Import Error</h3>
                    <p id="errorMessage" class="text-red-700"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('csvImportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const results = document.getElementById('results');
    const error = document.getElementById('error');
    const resultsContent = document.getElementById('resultsContent');
    
    // Show loading state
    submitBtn.disabled = true;
    loadingSpinner.classList.remove('hidden');
    results.classList.add('hidden');
    error.classList.add('hidden');
    
    fetch('{{ route("admin.csv-import.process") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        loadingSpinner.classList.add('hidden');
        submitBtn.disabled = false;
        
        if (data.success) {
            let resultsHtml = `
                <div class="space-y-4">
                    <div class="text-green-600 font-medium">✅ ${data.message}</div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">Total Processed:</span> ${data.data.total}
                        </div>
                        <div>
                            <span class="font-medium">Successfully Imported:</span> ${data.data.imported}
                        </div>
                        <div>
                            <span class="font-medium">Skipped:</span> ${data.data.skipped}
                        </div>
                    </div>
            `;
            
            // Add validation summary if available
            if (data.validation) {
                resultsHtml += `
                    <div class="mt-4">
                        <h4 class="font-medium text-gray-900 mb-2">Validation Summary:</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium">Total Rows Validated:</span> ${data.validation.total_rows}
                            </div>
                            <div>
                                <span class="font-medium">Valid Rows:</span> ${data.validation.valid_rows}
                            </div>
                        </div>
                `;
                
                if (data.validation.warnings && data.validation.warnings.length > 0) {
                    resultsHtml += `
                        <div class="mt-2">
                            <h5 class="font-medium text-yellow-700">Warnings:</h5>
                            <ul class="list-disc list-inside text-sm text-yellow-600 mt-1">
                                ${data.validation.warnings.map(warning => `<li>${warning}</li>`).join('')}
                            </ul>
                        </div>
                    `;
                }
                
                resultsHtml += `</div>`;
            }
            
            // Add detailed invalid rows information if available
            if (data.invalid_rows && data.invalid_rows.length > 0) {
                resultsHtml += `
                    <div class="mt-4">
                        <h4 class="font-medium text-gray-900 mb-2">Detailed Invalid Rows Information:</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 border-b text-left">Row #</th>
                                        <th class="px-3 py-2 border-b text-left">Original Data</th>
                                        <th class="px-3 py-2 border-b text-left">Cleaned Data</th>
                                        <th class="px-3 py-2 border-b text-left">Errors</th>
                                        <th class="px-3 py-2 border-b text-left">Warnings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.invalid_rows.map(row => `
                                    <tr class="border-b">
                                        <td class="px-3 py-2">${row.row_number}</td>
                                        <td class="px-3 py-2">
                                            <pre class="text-xs bg-gray-100 p-2 rounded overflow-auto max-h-32">${JSON.stringify(row.original_data, null, 2)}</pre>
                                        </td>
                                        <td class="px-3 py-2">
                                            <pre class="text-xs bg-gray-100 p-2 rounded overflow-auto max-h-32">${JSON.stringify(row.cleaned_data, null, 2)}</pre>
                                        </td>
                                        <td class="px-3 py-2">
                                            ${row.errors.map(error => `<div class="text-red-600 text-xs mb-1">• ${error}</div>`).join('')}
                                        </td>
                                        <td class="px-3 py-2">
                                            ${row.warnings.map(warning => `<div class="text-yellow-600 text-xs mb-1">• ${warning}</div>`).join('')}
                                        </td>
                                    </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            }
            
            // Add errors if any
            if (data.data.errors && data.data.errors.length > 0) {
                resultsHtml += `
                    <div class="mt-4">
                        <h4 class="font-medium text-yellow-700">Errors:</h4>
                        <ul class="list-disc list-inside text-sm text-yellow-600 mt-1">
                            ${data.data.errors.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    </div>
                `;
            }
            
            resultsHtml += `</div>`;
            resultsContent.innerHTML = resultsHtml;
            results.classList.remove('hidden');
        } else {
            let errorHtml = `
                <div class="space-y-2">
                    <p class="text-red-600 font-medium">❌ Import Failed</p>
                    <p class="text-red-700">${data.message}</p>
            `;
            
            if (data.errors && data.errors.length > 0) {
                errorHtml += `
                    <div class="mt-2">
                        <h5 class="font-medium text-red-700">Errors:</h5>
                        <ul class="list-disc list-inside text-sm text-red-600 mt-1">
                            ${data.errors.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    </div>
                `;
            }
            
            if (data.warnings && data.warnings.length > 0) {
                errorHtml += `
                    <div class="mt-2">
                        <h5 class="font-medium text-yellow-700">Warnings:</h5>
                        <ul class="list-disc list-inside text-sm text-yellow-600 mt-1">
                            ${data.warnings.map(warning => `<li>${warning}</li>`).join('')}
                        </ul>
                    </div>
                `;
            }
            
            errorHtml += `</div>`;
            document.getElementById('errorMessage').innerHTML = errorHtml;
            error.classList.remove('hidden');
        }
    })
    .catch(error => {
        loadingSpinner.classList.add('hidden');
        submitBtn.disabled = false;
        document.getElementById('errorMessage').textContent = 'An unexpected error occurred. Please try again.';
        error.classList.remove('hidden');
        console.error('Error:', error);
    });
});
</script>
</x-app-layout>