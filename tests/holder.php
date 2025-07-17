
<?php



namespace App\Imports;

use App\Models\ResearchPaper;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str; // For string manipulation

class ResearchPaperImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        

        // Get the type value from the row, convert to uppercase and trim whitespace
        $rawType = strtoupper(trim($row['type'] ?? ''));

        // Map the single-letter abbreviation to the full enum value
        $formattedType = match ($rawType) {
            'J' => 'Journal',
            'C' => 'Conference',
            'B' => 'Book',
            'T' => 'Thesis',
            'R' => 'Report',
            default => 'J', // Default to 'Journal' if the abbreviation is not recognized
        };

        return new ResearchPaper([
            'title'         => $row['title'] ?? 'Untitled',
            // Maps 'author' column from Excel to 'authors' field in database
            'authors'       => $row['author'] ?? 'Unknown',
            'editors'       => $row['editor'] ?? null,
            'tm'            => match (strtoupper(trim($row['tm'] ?? ''))) {
                'P', 'NP' => strtoupper(trim($row['tm'])),
                // If 'P NP' or 'NP P' is found, default to 'P' (Published)
                'P NP', 'NP P' => 'P',
                default => 'P', // fallback value if tm is not recognized
            },           
            'year'          => is_numeric($row['year'] ?? null) ? (int) $row['year'] : null,
            'publisher'     => $row['publisher'] ?? null,
            'citation'      => $row['citation'] ?? null,
            'keyword'       => $row['keyword'] ?? null,
            'abstract'      => $row['abstract'] ?? 'No abstract available',
            // Maps 'links' column from Excel to 'external_link' field in database
            'external_link' => $row['links'] ?? null,
            'isbn'          => $row['isbn'] ?? null,
            // Use 'department' from Excel if available, otherwise default to 'Uncategorized'
            //'department'    => $row['department'] ?? 'Uncategorized',
            // 'pdf_path' remains as it was not excluded
            //'pdf_path'      => $row['pdf_path'] ?? null, // Assuming an 'pdf_path' column in Excel
            // 'status' and 'restricted' fields are now excluded as per your request.
            // They will default to their values defined in the migration (false for both).
            'type'          => $formattedType, // Use the mapped type
        ]);
    }

    /**
     * Define validation rules for the import.
     * These rules apply to the column names as they appear in the Excel heading row.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'      => 'required|string|max:255',
            'author'     => 'required|string|max:65535', // 'authors' field is TEXT, so larger max
            'editor'     => 'nullable|string|max:65535', // 'editors' field is TEXT
            'tm'         => 'required|in:P,NP',
            // Updated 'type' validation to accept single-letter abbreviations
            //'type'       => 'required|in:J,C,B,T,R',
            'year'       => 'nullable|integer|min:1500|max:' . (date('Y') + 5), // Allowing slightly future years for drafts/forthcoming
            'publisher'  => 'nullable|string|max:255',
            'isbn'       => 'nullable|string|max:255',
            'abstract'   => 'nullable|string|max:65535', // 'abstract' field is TEXT
            'links'      => 'nullable|url|max:255', // Assuming 'links' column for external_link
            'citation'   => 'nullable|string|max:65535', // 'citation' field is TEXT
            'keyword'    => 'nullable|string|max:65535', // 'keyword' field is TEXT
            //'department' => 'nullable|string|max:255',
            //'pdf_path'   => 'nullable|string|max:255',
            // 'status' and 'restricted' validation rules are now excluded as per your request.
             'type'       => 'required|in:J,C,B,T,R',
        ];
    }

    /**
     * Custom validation messages for better user feedback.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'tm.in' => 'The :attribute must be either "P" (Published) or "NP" (Not Published).',
            // Updated message for 'type' validation
            'type.in' => 'The :attribute must be one of: J (Journal), C (Conference), B (Book), T (Thesis), R (Report).',
            'year.max' => 'The :attribute cannot be in the far future.',
            'links.url' => 'The :attribute must be a valid URL.',
        ];
    }
}
