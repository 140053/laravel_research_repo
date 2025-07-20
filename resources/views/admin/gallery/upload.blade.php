<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
            Upload Images to Album: {{ $album->name }}
        </h2>
    </x-slot>

    <div class="container p-6 max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded shadow">
        <form id="upload-form" enctype="multipart/form-data">
            @csrf

            <div id="image-fields" class="space-y-4">
                <div class="image-group border border-gray-300 dark:border-gray-600 p-4 rounded">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image File</label>
                    <input type="file" name="images[]" class="w-full file:border file:rounded file:p-2 file:bg-gray-100 dark:file:bg-gray-700" required>

                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4 mb-1">Caption</label>
                    <input type="text" name="captions[]" class="w-full rounded border-gray-300 dark:border-gray-600 shadow-sm" placeholder="Enter a caption..." required>
                </div>
            </div>

            <div class="mt-6 flex gap-4 flex-wrap">
                <button type="button" onclick="addImageField()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    + Add Another Image
                </button>

                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Upload
                </button>
            </div>

            {{-- Progress bar --}}
            <div class="mt-6">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded h-4 overflow-hidden">
                    <div id="progress-bar" class="bg-green-500 h-4 w-0 transition-all duration-300"></div>
                </div>
                <p id="progress-text" class="text-sm mt-2 text-gray-600 dark:text-gray-400">0%</p>
            </div>
        </form>

        {{-- JS --}}
        <script>
            function addImageField() {
                const container = document.getElementById('image-fields');
                const div = document.createElement('div');
                div.classList.add('image-group', 'border', 'border-gray-300', 'dark:border-gray-600', 'p-4', 'rounded', 'space-y-2');
                div.innerHTML = `
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image File</label>
                    <input type="file" name="images[]" class="w-full file:border file:rounded file:p-2 file:bg-gray-100 dark:file:bg-gray-700" required>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Caption</label>
                    <input type="text" name="captions[]" class="w-full rounded border-gray-300 dark:border-gray-600 shadow-sm" placeholder="Enter a caption..." required>
                `;
                container.appendChild(div);
            }

            document.getElementById('upload-form').addEventListener('submit', function (e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('admin.albums.images.store', $album) }}", true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        document.getElementById('progress-bar').style.width = percent + '%';
                        document.getElementById('progress-text').textContent = percent + '%';
                    }
                });

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert('Upload complete!');
                        document.getElementById('progress-bar').style.width = '0%';
                        document.getElementById('progress-text').textContent = '0%';
                        form.reset();
                        document.getElementById('image-fields').innerHTML = `
                            <div class="image-group border border-gray-300 dark:border-gray-600 p-4 rounded">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image File</label>
                                <input type="file" name="images[]" class="w-full file:border file:rounded file:p-2 file:bg-gray-100 dark:file:bg-gray-700" required>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4 mb-1">Caption</label>
                                <input type="text" name="captions[]" class="w-full rounded border-gray-300 dark:border-gray-600 shadow-sm" placeholder="Enter a caption..." required>
                            </div>
                        `;
                    } else {
                        alert('Upload failed. Please try again.');
                    }
                };

                xhr.onerror = function () {
                    alert('An error occurred while uploading.');
                };

                xhr.send(formData);
            });
        </script>
    </div>
</x-app-layout>
