<?php

namespace App\Http\Controllers;

use App\Services\CsvImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CsvImportController extends Controller
{
    protected $csvImportService;

    public function __construct(CsvImportService $csvImportService)
    {
        $this->csvImportService = $csvImportService;
    }

    /**
     * Show the import form
     */
    public function showImportForm()
    {
        return view('admin.csv-import.form');
    }

    /**
     * Handle CSV file upload and import
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ]);

        try {
            // Store the uploaded file temporarily
            $file = $request->file('csv_file');
            $fileName = 'import_' . time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('temp', $fileName);

            // Get the full path to the stored file
            $fullPath = Storage::path($filePath);

            // Validate the CSV file first
            $validationResult = $this->validateCsvFile($fullPath);
            
            if (!$validationResult['is_valid']) {
                // Clean up the temporary file
                Storage::delete($filePath);
                
                return response()->json([
                    'success' => false,
                    'message' => 'CSV validation failed',
                    'errors' => $validationResult['errors'],
                    'warnings' => $validationResult['warnings']
                ], 400);
            }

            // Perform the import
            $result = $this->csvImportService->importResearchPapers($fullPath);

            // Clean up the temporary file
            Storage::delete($filePath);

            return response()->json([
                'success' => true,
                'message' => 'Import completed successfully!',
                'data' => $result,
                'validation' => [
                    'total_rows' => $validationResult['total_rows'],
                    'valid_rows' => $validationResult['valid_rows'],
                    'warnings' => $validationResult['warnings']
                ],
                'invalid_rows' => $result['invalid_rows'] ?? []
            ]);

        } catch (\Exception $e) {
            Log::error('CSV import failed via web interface', [
                'error' => $e->getMessage(),
                'file' => $request->file('csv_file')->getClientOriginalName()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate CSV file before import
     *
     * @param string $filePath
     * @return array
     */
    private function validateCsvFile(string $filePath): array
    {
        $result = [
            'is_valid' => true,
            'total_rows' => 0,
            'valid_rows' => 0,
            'invalid_rows' => 0,
            'errors' => [],
            'warnings' => []
        ];

        try {
            $handle = fopen($filePath, 'r');
            if (!$handle) {
                $result['errors'][] = "Cannot open file";
                $result['is_valid'] = false;
                return $result;
            }

            // Check file size
            $fileSize = filesize($filePath);
            if ($fileSize === 0) {
                $result['errors'][] = "File is empty";
                $result['is_valid'] = false;
                fclose($handle);
                return $result;
            }

            if ($fileSize > 50 * 1024 * 1024) { // 50MB limit
                $result['warnings'][] = "File size is large. Import may take a while.";
            }

            // Read and validate headers
            $headers = fgetcsv($handle);
            if (!$headers) {
                $result['errors'][] = "Cannot read CSV headers";
                $result['is_valid'] = false;
                fclose($handle);
                return $result;
            }

            $headerValidation = $this->validateHeaders($headers);
            if (!$headerValidation['is_valid']) {
                $result['errors'] = array_merge($result['errors'], $headerValidation['errors']);
                $result['warnings'] = array_merge($result['warnings'], $headerValidation['warnings']);
                $result['is_valid'] = false;
            }

            // Validate data rows
            $rowNumber = 1;
            $columnMap = $this->getColumnMap($headers);
            
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                $result['total_rows']++;

                // Check for empty rows
                if (empty(array_filter($row))) {
                    $result['warnings'][] = "Row {$rowNumber}: Empty row (skipped)";
                    continue;
                }

                // Validate row data
                $rowValidation = $this->validateRowData($row, $headers, $columnMap, $rowNumber);
                if ($rowValidation['is_valid']) {
                    $result['valid_rows']++;
                } else {
                    $result['invalid_rows']++;
                    $result['errors'] = array_merge($result['errors'], $rowValidation['errors']);
                }

                // Check for too many rows
                if ($rowNumber > 100000) {
                    $result['warnings'][] = "File contains more than 100,000 rows. Consider splitting into smaller files.";
                    break;
                }
            }

            fclose($handle);

            // Final validation checks
            if ($result['total_rows'] === 0) {
                $result['errors'][] = "No data rows found in CSV file";
                $result['is_valid'] = false;
            }

            if ($result['invalid_rows'] > $result['total_rows'] * 0.5) {
                $result['errors'][] = "More than 50% of rows have errors. Please check your CSV format.";
                $result['is_valid'] = false;
            }

        } catch (\Exception $e) {
            $result['errors'][] = "File validation error: " . $e->getMessage();
            $result['is_valid'] = false;
        }

        return $result;
    }

    /**
     * Validate CSV headers
     *
     * @param array $headers
     * @return array
     */
    private function validateHeaders(array $headers): array
    {
        $result = [
            'is_valid' => true,
            'errors' => [],
            'warnings' => []
        ];

        // Check for required headers
        $requiredHeaders = ['title'];
        $foundHeaders = array_map('strtolower', array_map('trim', $headers));
        
        foreach ($requiredHeaders as $required) {
            if (!in_array($required, $foundHeaders)) {
                $result['errors'][] = "Missing required header: '{$required}'";
                $result['is_valid'] = false;
            }
        }

        // Check for duplicate headers
        $duplicates = array_diff_assoc($headers, array_unique($headers));
        if (!empty($duplicates)) {
            $result['errors'][] = "Duplicate headers found: " . implode(', ', array_unique($duplicates));
            $result['is_valid'] = false;
        }

        // Check for empty headers
        $emptyHeaders = array_filter($headers, function($header) {
            return empty(trim($header));
        });
        if (!empty($emptyHeaders)) {
            $result['warnings'][] = "Found empty header columns";
        }

        // Check for unrecognized headers
        $recognizedHeaders = [
            'title', 'Title', 'TITLE', 'paper_title', 'Paper Title',
            'authors', 'Authors', 'AUTHORS', 'author', 'Author',
            'editors', 'Editors', 'EDITORS', 'editor', 'Editor',
            'tm', 'TM', 'status', 'Status', 'publication_status',
            'type', 'Type', 'TYPE', 'paper_type', 'Paper Type',
            'publisher', 'Publisher', 'PUBLISHER',
            'isbn', 'ISBN', 'isbn_number',
            'abstract', 'Abstract', 'ABSTRACT', 'summary', 'Summary',
            'year', 'Year', 'YEAR', 'publication_year', 'Publication Year',
            'department', 'Department', 'DEPARTMENT', 'dept',
            'pdf_path', 'PDF Path', 'pdf', 'PDF', 'file_path',
            'external_link', 'External Link', 'link', 'Link', 'url', 'URL',
            'citation', 'Citation', 'CITATION', 'cite',
            'keyword', 'Keyword', 'KEYWORD', 'keywords', 'Keywords', 'KEYWORDS', 'tags', 'Tags',
            'status', 'Status', 'STATUS', 'in_collection',
            'restricted', 'Restricted', 'RESTRICTED', 'featured'
        ];

        $unrecognizedHeaders = array_filter($headers, function($header) use ($recognizedHeaders) {
            return !in_array(trim($header), $recognizedHeaders);
        });

        if (!empty($unrecognizedHeaders)) {
            $result['warnings'][] = "Unrecognized headers (will be ignored): " . implode(', ', $unrecognizedHeaders);
        }

        return $result;
    }

    /**
     * Validate row data
     *
     * @param array $row
     * @param array $headers
     * @param array $columnMap
     * @param int $rowNumber
     * @return array
     */
    private function validateRowData(array $row, array $headers, array $columnMap, int $rowNumber): array
    {
        $result = [
            'is_valid' => true,
            'errors' => []
        ];

        // Check if title exists (required)
        $titleIndex = $columnMap['title'] ?? null;
        if ($titleIndex === null) {
            $result['errors'][] = "Row {$rowNumber}: Missing title column";
            $result['is_valid'] = false;
            return $result;
        }

        $title = trim($row[$titleIndex] ?? '');
        if (empty($title)) {
            $result['errors'][] = "Row {$rowNumber}: Title is required but empty";
            $result['is_valid'] = false;
        }

        // Validate enum values
        if (isset($columnMap['tm'])) {
            $tmValue = trim($row[$columnMap['tm']] ?? '');
            if (!empty($tmValue) && !in_array($tmValue, ['P', 'NP'])) {
                $result['errors'][] = "Row {$rowNumber}: Invalid 'tm' value '{$tmValue}'. Must be 'P' or 'NP'";
                $result['is_valid'] = false;
            }
        }

        if (isset($columnMap['type'])) {
            $typeValue = trim($row[$columnMap['type']] ?? '');
            if (!empty($typeValue) && !in_array($typeValue, ['Journal', 'Conference', 'Book', 'Thesis', 'Report'])) {
                $result['errors'][] = "Row {$rowNumber}: Invalid 'type' value '{$typeValue}'. Must be one of: Journal, Conference, Book, Thesis, Report";
                $result['is_valid'] = false;
            }
        }

        // Validate year
        if (isset($columnMap['year'])) {
            $yearValue = trim($row[$columnMap['year']] ?? '');
            if (!empty($yearValue)) {
                if (!is_numeric($yearValue)) {
                    $result['errors'][] = "Row {$rowNumber}: Invalid year '{$yearValue}'. Must be a number";
                    $result['is_valid'] = false;
                } elseif ($yearValue < 1900 || $yearValue > date('Y') + 1) {
                    $result['errors'][] = "Row {$rowNumber}: Year '{$yearValue}' seems unrealistic";
                    $result['is_valid'] = false;
                }
            }
        }

        // Validate boolean fields
        if (isset($columnMap['status'])) {
            $statusValue = trim($row[$columnMap['status']] ?? '');
            if (!empty($statusValue) && !in_array(strtolower($statusValue), ['true', 'false', '1', '0', 'yes', 'no', 'y', 'n', 'on', 'off'])) {
                $result['errors'][] = "Row {$rowNumber}: Invalid 'status' value '{$statusValue}'. Must be a boolean value";
                $result['is_valid'] = false;
            }
        }

        if (isset($columnMap['restricted'])) {
            $restrictedValue = trim($row[$columnMap['restricted']] ?? '');
            if (!empty($restrictedValue) && !in_array(strtolower($restrictedValue), ['true', 'false', '1', '0', 'yes', 'no', 'y', 'n', 'on', 'off'])) {
                $result['errors'][] = "Row {$rowNumber}: Invalid 'restricted' value '{$restrictedValue}'. Must be a boolean value";
                $result['is_valid'] = false;
            }
        }

        return $result;
    }

    /**
     * Get column mapping from CSV headers to database columns
     *
     * @param array $headers
     * @return array
     */
    private function getColumnMap(array $headers): array
    {
        $possibleMappings = [
            'title' => ['title', 'Title', 'TITLE', 'paper_title', 'Paper Title'],
            'authors' => ['authors', 'Authors', 'AUTHORS', 'author', 'Author'],
            'editors' => ['editors', 'Editors', 'EDITORS', 'editor', 'Editor'],
            'tm' => ['tm', 'TM', 'status', 'Status', 'publication_status'],
            'type' => ['type', 'Type', 'TYPE', 'paper_type', 'Paper Type'],
            'publisher' => ['publisher', 'Publisher', 'PUBLISHER'],
            'isbn' => ['isbn', 'ISBN', 'isbn_number'],
            'abstract' => ['abstract', 'Abstract', 'ABSTRACT', 'summary', 'Summary'],
            'year' => ['year', 'Year', 'YEAR', 'publication_year', 'Publication Year'],
            'department' => ['department', 'Department', 'DEPARTMENT', 'dept'],
            'pdf_path' => ['pdf_path', 'PDF Path', 'pdf', 'PDF', 'file_path'],
            'external_link' => ['external_link', 'External Link', 'link', 'Link', 'url', 'URL'],
            'citation' => ['citation', 'Citation', 'CITATION', 'cite'],
            'keyword' => ['keyword', 'Keyword', 'KEYWORD', 'keywords', 'Keywords', 'KEYWORDS', 'tags', 'Tags'],
            'status' => ['status', 'Status', 'STATUS', 'in_collection'],
            'restricted' => ['restricted', 'Restricted', 'RESTRICTED', 'featured']
        ];

        $columnMap = [];
        foreach ($headers as $index => $header) {
            $header = trim($header);
            foreach ($possibleMappings as $dbColumn => $possibleHeaders) {
                if (in_array($header, $possibleHeaders)) {
                    $columnMap[$dbColumn] = $index;
                    break;
                }
            }
        }

        return $columnMap;
    }

    /**
     * Download sample CSV template
     */
    public function downloadTemplate()
    {
        // Relative path in storage/app/public
        $relativePath = 'templates/research_papers_template.csv';
        $storageDisk = 'public'; // Use the 'public' disk

        // If file doesn't exist, create it
        if (!Storage::disk($storageDisk)->exists($relativePath)) {
            $template = "title,authors,editors,tm,type,publisher,isbn,abstract,year,department,pdf_path,external_link,citation,keyword,status,restricted\n";
            $template .= "\"Sample Research Paper Title\",\"Author Name\",\"Editor Name\",\"P\",\"Journal\",\"Publisher Name\",\"978-1234567890\",\"Sample abstract text here.\",\"2023\",\"Department Name\",\"/path/to/file.pdf\",\"https://example.com\",\"Citation format here\",\"keyword1, keyword2\",\"1\",\"0\"";

            // Ensure the directory exists and create file
            Storage::disk($storageDisk)->makeDirectory('templates');
            Storage::disk($storageDisk)->put($relativePath, $template);
        }

        // Get full path to the file
        $absolutePath = Storage::disk($storageDisk)->path($relativePath);

        // Return file as download response
        return response()->download($absolutePath, 'research_papers_template.csv');
    }
} 