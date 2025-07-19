<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Upload Images to Album: {{ $album->name }}</h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">
        <form id="upload-form" enctype="multipart/form-data">
            @csrf
            
            <div id="image-fields">
                <div class="mb-4 image-group">
                    <input type="file" name="images[]" required>
                    <input type="text" name="captions[]" class="border p-2 mt-2" placeholder="Caption" required>
                </div>
            </div>

            <button type="button" onclick="addImageField()" class="bg-blue-500 text-white px-4 py-2 rounded">Add Another Image</button>

            <br><br>
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">Upload</button>

            {{-- Progress bar --}}
            <div class="mt-6">
                <div class="w-full bg-gray-300 rounded h-4">
                    <div id="progress-bar" class="bg-green-500 h-4 w-0 rounded transition-all duration-300"></div>
                </div>
                <p id="progress-text" class="text-sm mt-2 text-gray-600">0%</p>
            </div>
        </form>

        <script>
            function addImageField() {
                const container = document.getElementById('image-fields');
                const div = document.createElement('div');
                div.classList.add('mb-4', 'image-group');
                div.innerHTML = `
                    <input type="file" name="images[]" required>
                    <input type="text" name="captions[]" class="border p-2 mt-2" placeholder="Caption" required>
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
                        // Optionally clear dynamic fields
                        document.getElementById('image-fields').innerHTML = `
                            <div class="mb-4 image-group">
                                <input type="file" name="images[]" required>
                                <input type="text" name="captions[]" class="border p-2 mt-2" placeholder="Caption" required>
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
