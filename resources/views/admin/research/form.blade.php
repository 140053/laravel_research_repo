<div class="space-y-4">
    <div>
        <label class="block font-semibold dark:text-gray-300">Title</label>
        <input type="text" name="title" value="{{ old('title', $paper->title ?? '') }}" required class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
    </div>

    <div>
        <label class="block font-semibold dark:text-gray-300">Authors</label>
        <input type="text" name="authors" value="{{ old('authors', $paper->authors ?? '') }}" required class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
        <p>
            <small class="text-gray-600">Separate multiple authors with commas.</small>
        </p>
    </div>
     {{-- Editors --}}
     <div>
        <label class="block font-semibold dark:text-gray-300">Editors (optional)</label>
        <input type="text" name="editors" value="{{ old('editors', $paper->editors ?? '') }}" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
    </div>

    <div>
        <label class="block font-semibold dark:text-gray-300">Abstract</label>
        <textarea name="abstract" rows="4" required class="w-full p-2 border rounded  h-80 dark:bg-gray-700 dark:text-gray-300">{{ old('abstract', $paper->abstract ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-4  gap-3">
        {{-- TM --}}
        <div>
            <label class="block font-semibold dark:text-gray-300">Material Type</label>
            <select name="tm" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300" required>
                <option class="dark:bg-gray-700 dark:text-gray-300" value="P" {{ old('tm', $paper->tm ?? '') == 'P' ? 'selected' : '' }}>Printed</option>
                <option class="dark:bg-gray-700 dark:text-gray-300" value="NP" {{ old('tm', $paper->tm ?? '') == 'NP' ? 'selected' : '' }}>Not Printed</option>
            </select>
        </div>

        {{-- Type --}}
        <div>
            <label class="block font-semibold dark:text-gray-300">Type</label>
            <select name="type" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300" required>
                @foreach(['Journal', 'Conference', 'Book', 'Thesis', 'Report'] as $type)
                    <option class="dark:bg-gray-700 dark:text-gray-300" value="{{ $type }}" {{ old('type', $paper->type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        {{-- ISBN --}}
        <div>
            <label class="block font-semibold dark:text-gray-300">ISBN (optional)</label>
            <input type="text" name="isbn" value="{{ old('isbn', $paper->isbn ?? '') }}" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
        </div>

        
        <div>
            <label class="block font-semibold dark:text-gray-300">Year</label>
            <input type="number" name="year" value="{{ old('year', $paper->year ?? '') }}" required class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
        </div>

    </div>




    
    <div class="hidden">
        <label class="block font-semibold dark:text-gray-300">Department</label>
        <input type="text" name="department" value="{{ old('department', $paper->department ?? '') }}" required class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
    </div>

    <div>
        <label class="block font-semibold dark:text-gray-300">External Link (optional)</label>
        <input type="url" name="external_link" value="{{ old('external_link', $paper->external_link ?? '') }}" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
    </div>

    

    <div>
        <label class="block font-semibold dark:text-gray-300">Citation</label>
        <textarea name="citation" rows="3" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">{{ old('citation', $paper->citation ?? '') }}</textarea>
    </div>


   
   
    <div class="grid grid-cols-2 gap-3">
    {{-- Publisher --}}
    <div>
        <label class="block font-semibold dark:text-gray-300">Publisher (optional)</label>
        <input type="text" name="publisher" value="{{ old('publisher', $paper->publisher ?? '') }}" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
    </div>



    {{-- ✅ TAGS INPUT --}}
    <div>
        <label class="block font-semibold dark:text-gray-300">Tags (comma-separated)</label>
        <input 
            type="text" 
            name="tags" 
            class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300" 
            placeholder="e.g. Animals, Plant, None"
            value="{{ old('tags', isset($paper) ? $paper->tags_string : '') }}">
    </div>


    </div>

   

    
    <div>
        <label class="block font-semibold dark:text-gray-300">PDF File (optional)</label>
        <input type="file" name="pdf" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-300">
        @if(!empty($paper->pdf_path))
            <p class="text-sm mt-1">Current PDF: 
                <a href="{{ Storage::url($paper->pdf_path) }}" class="text-blue-600 underline dark:text-blue-400" target="_blank">View</a>
            </p>
        @endif
    </div>

</div>
