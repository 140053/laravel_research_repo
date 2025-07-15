<div class="space-y-4">
    <div>
        <label class="block font-semibold">Title</label>
        <input type="text" name="title" value="{{ old('title', $paper->title ?? '') }}" required class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold">Authors</label>
        <input type="text" name="authors" value="{{ old('authors', $paper->authors ?? '') }}" required class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold">Abstract</label>
        <textarea name="abstract" rows="4" required class="w-full p-2 border rounded">{{ old('abstract', $paper->abstract ?? '') }}</textarea>
    </div>

    <div>
        <label class="block font-semibold">Year</label>
        <input type="number" name="year" value="{{ old('year', $paper->year ?? '') }}" required class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold">Department</label>
        <input type="text" name="department" value="{{ old('department', $paper->department ?? '') }}" required class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold">External Link (optional)</label>
        <input type="url" name="external_link" value="{{ old('external_link', $paper->external_link ?? '') }}" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold">PDF File (optional)</label>
        <input type="file" name="pdf" class="w-full p-2 border rounded">
        @if(!empty($paper->pdf_path))
            <p class="text-sm mt-1">Current PDF: 
                <a href="{{ Storage::url($paper->pdf_path) }}" class="text-blue-600 underline" target="_blank">View</a>
            </p>
        @endif
    </div>

    <div>
        <label class="block font-semibold">Citation</label>
        <textarea name="citation" rows="3" class="w-full p-2 border rounded">{{ old('citation', $paper->citation ?? '') }}</textarea>
    </div>

    {{-- Editors --}}
    <div>
        <label class="block font-semibold">Editors (optional)</label>
        <input type="text" name="editors" value="{{ old('editors', $paper->editors ?? '') }}" class="w-full p-2 border rounded">
    </div>

    {{-- TM --}}
    <div>
        <label class="block font-semibold">TM</label>
        <select name="tm" class="w-full p-2 border rounded" required>
            <option value="P" {{ old('tm', $paper->tm ?? '') == 'P' ? 'selected' : '' }}>P</option>
            <option value="NP" {{ old('tm', $paper->tm ?? '') == 'NP' ? 'selected' : '' }}>NP</option>
        </select>
    </div>

    {{-- Type --}}
    <div>
        <label class="block font-semibold">Type</label>
        <select name="type" class="w-full p-2 border rounded" required>
            @foreach(['Journal', 'Conference', 'Book', 'Thesis', 'Report'] as $type)
                <option value="{{ $type }}" {{ old('type', $paper->type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>

    {{-- Publisher --}}
    <div>
        <label class="block font-semibold">Publisher (optional)</label>
        <input type="text" name="publisher" value="{{ old('publisher', $paper->publisher ?? '') }}" class="w-full p-2 border rounded">
    </div>

    {{-- ISBN --}}
    <div>
        <label class="block font-semibold">ISBN (optional)</label>
        <input type="text" name="isbn" value="{{ old('isbn', $paper->isbn ?? '') }}" class="w-full p-2 border rounded">
    </div>


    {{-- ✅ TAGS INPUT --}}
    <div>
        <label class="block font-semibold">Tags (comma-separated)</label>
        <input 
            type="text" 
            name="tags" 
            class="w-full p-2 border rounded" 
            placeholder="e.g. AI, Deep Learning, Robotics"
            value="{{ old('tags', isset($paper) ? $paper->tags_string : '') }}">
    </div>
</div>
