<div>
    
    <form action="{{ route('.research.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="authors" placeholder="Authors" required>
        <textarea name="abstract" placeholder="Abstract" required></textarea>
        <input type="number" name="year" placeholder="Year" required>
        <input type="text" name="department" placeholder="Department" required>
        <input type="file" name="pdf">
        <input type="url" name="external_link" placeholder="External Link">
        <input type="text" name="tags[]" placeholder="Comma-separated tags">
        <button type="submit">Submit</button>
    </form>
    

</div>
