<?php


namespace App\Imports;

use App\Models\ResearchPaper;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str; 

class ResearchPaperImport implements ToModel, WithHeadingRow, WithValidation
{
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
            'D' => 'Dissertation',
            'R' => 'Report',           
            'A' => 'Article ',
            default => 'J', // Default to 'Journal' if the abbreviation is not recognized
        };

        //dd($row);
        return new ResearchPaper([
            'title'         => $row['title'] ?? 'Untitled',
            'authors'       => $row['author'] ?? 'Unknown',
            'editors'       => $row['editor'] ?? null,
            'tm'            => match (strtoupper(trim($row['tm'] ?? ''))) {
                'P', 'NP' => strtoupper(trim($row['tm'])),
                'P NP', 'NP P' => 'P', // Or 'NP' based on your needs
                default => 'P', // fallback value
            },          
            'year'          => is_numeric($row['year'] ?? null) ? (int) $row['year'] : null,
            'publisher'     => $row['publisher'] ?? null,
            'citation'      => $row['citation'] ?? null,
            'keyword'       => $row['keyword'] ?? null,
            'abstract'      => $row['abstract'] ?? 'No abstract available',
            'external_link' => $row['links'] ?? null,
            'isbn'          => $row['isbn'] ?? null,
            'department'    => 'Uncategorized',
            'type'          => $formattedType,
        ]);
    }

    public function rules(): array
    {
        return [
            'title'  => 'required|string',
            'author' => 'required|string',
            'year'   => 'nullable|integer|min:1500|max:' . now()->year,
        ];
    }
}

