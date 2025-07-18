<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Upload Images to Album: {{ $album->name }}</h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">
       
            <form action="{{ route('admin.albums.images.store', $album) }}" method="POST" enctype="multipart/form-data">
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
            </script>
            
    </div>
</x-app-layout>
