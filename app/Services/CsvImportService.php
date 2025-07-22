<?php

namespace App\Services;

use App\Models\ResearchPaper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CsvImportService
{
    /**
     * Import research papers from CSV file
     *
     * @param string $filePath
     * @param bool $dryRun
     * @return array
     */
    public function importResearchPapers(string $filePath, bool $dryRun = false): array
    {
        $result = [
            'total' => 0,
            'imported' => 0,
            'skipped' => 0,
            'errors' => [],
            'invalid_rows' => []
        ];

        if (!file_exists($filePath)) {
            throw new \Exception("File not found: {$filePath}");
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \Exception("Cannot open file: {$filePath}");
        }

        // Read header row
        $headers = fgetcsv($handle);
        if (!$headers) {
            throw new \Exception("Cannot read CSV headers");
        }

        // Map CSV headers to database columns
        $columnMap = $this->getColumnMap($headers);

        $rowNumber = 1; // Start from 1 since we already read the header
        $batchSize = 100;
        $batch = [];

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            $result['total']++;

            try {
                $data = $this->mapRowData($row, $headers, $columnMap);
                
                $validationResult = $this->validateRowData($data, $rowNumber);
                
                if ($validationResult['is_valid']) {
                    if (!$dryRun) {
                        $batch[] = $data;
                        
                        // Process batch when it reaches the batch size
                        if (count($batch) >= $batchSize) {
                            $this->processBatch($batch);
                            $result['imported'] += count($batch);
                            $batch = [];
                        }
                    } else {
                        $result['imported']++;
                    }
                } else {
                    $result['skipped']++;
                    $result['errors'][] = "Row {$rowNumber}: " . implode(', ', $validationResult['errors']);
                    $result['invalid_rows'][] = [
                        'row_number' => $rowNumber,
                        'original_data' => $row,
                        'cleaned_data' => $data,
                        'errors' => $validationResult['errors'],
                        'warnings' => $validationResult['warnings'] ?? []
                    ];
                }
            } catch (\Exception $e) {
                $result['skipped']++;
                $result['errors'][] = "Row {$rowNumber}: " . $e->getMessage();
                $result['invalid_rows'][] = [
                    'row_number' => $rowNumber,
                    'original_data' => $row,
                    'cleaned_data' => [],
                    'errors' => [$e->getMessage()],
                    'warnings' => []
                ];
            }
        }

        // Process remaining batch
        if (!empty($batch) && !$dryRun) {
            $this->processBatch($batch);
            $result['imported'] += count($batch);
        }

        fclose($handle);
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
     * Map row data from CSV to database columns
     *
     * @param array $row
     * @param array $headers
     * @param array $columnMap
     * @return array
     */
    private function mapRowData(array $row, array $headers, array $columnMap): array
    {
        $data = [];

        foreach ($columnMap as $dbColumn => $csvIndex) {
            if (isset($row[$csvIndex])) {
                $value = trim($row[$csvIndex]);
                
                // Handle empty values
                if ($value === '' || $value === null) {
                    $value = null;
                } else {
                    // Clean the data before insertion
                    $value = $this->cleanInputData($value, $dbColumn);
                }

                $data[$dbColumn] = $value;
            }
        }

        return $data;
    }

    /**
     * Clean and sanitize input data
     *
     * @param string $value
     * @param string $fieldName
     * @return string
     */
    private function cleanInputData(string $value, string $fieldName): string
    {
        // Remove null bytes and other control characters
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value);
        
        // Remove invalid Unicode characters (including replacement character)
        $value = preg_replace('/[\x{FFFD}]/u', '', $value);
        
        // Remove other common invalid characters
        $value = preg_replace('/[\x{0000}-\x{001F}\x{007F}-\x{009F}]/u', '', $value);
        
        // Remove specific problematic characters
        $value = str_replace(['', '', '', '', '', '', '', '', '', '', '', ''], '', $value);
        
        // Decode HTML entities
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Remove extra whitespace
        $value = preg_replace('/\s+/', ' ', $value);
        $value = trim($value);
        
        // Handle specific field types
        switch ($fieldName) {
            case 'title':
                $value = $this->cleanTitle($value);
                break;
            case 'authors':
            case 'editors':
                $value = $this->cleanAuthors($value);
                break;
            case 'abstract':
                $value = $this->cleanAbstract($value);
                break;
            case 'citation':
                $value = $this->cleanCitation($value);
                break;
            case 'keyword':
                $value = $this->cleanKeywords($value);
                break;
            case 'publisher':
                $value = $this->cleanPublisher($value);
                break;
            case 'department':
                $value = $this->cleanDepartment($value);
                break;
            case 'external_link':
                $value = $this->cleanUrl($value);
                break;
            case 'pdf_path':
                $value = $this->cleanFilePath($value);
                break;
            case 'isbn':
                $value = $this->cleanIsbn($value);
                break;
            case 'year':
                $value = $this->cleanYear($value);
                break;
            case 'tm':
                $value = $this->cleanTm($value);
                break;
            case 'type':
                $value = $this->cleanType($value);
                break;
            case 'status':
            case 'restricted':
                $value = $this->cleanBoolean($value);
                break;
        }
        
        return $value;
    }

    /**
     * Clean title field
     *
     * @param string $value
     * @return string
     */
    private function cleanTitle(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Capitalize first letter of each word (title case)
        $value = ucwords(strtolower($value));
        
        // Handle special cases for scientific names
        $value = preg_replace('/\b([A-Z][a-z]+)\s+([a-z]+)\b/', '$1 $2', $value);
        
        return $value;
    }

    /**
     * Clean authors field
     *
     * @param string $value
     * @return string
     */
    private function cleanAuthors(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Handle multiple authors separated by commas
        $authors = array_map('trim', explode(',', $value));
        $cleanAuthors = [];
        
        foreach ($authors as $author) {
            if (!empty($author)) {
                // Clean individual author names
                $author = $this->cleanAuthorName($author);
                $cleanAuthors[] = $author;
            }
        }
        
        return implode(', ', $cleanAuthors);
    }

    /**
     * Clean individual author name
     *
     * @param string $author
     * @return string
     */
    private function cleanAuthorName(string $author): string
    {
        // Remove extra spaces and normalize
        $author = preg_replace('/\s+/', ' ', trim($author));
        
        // Handle "Ed." or "Editor" patterns
        if (strpos($author, 'Ed.') !== false) {
            $author = str_replace(['(Ed.)', '(Editor)'], 'Ed.', $author);
        }
        
        return $author;
    }

    /**
     * Clean abstract field
     *
     * @param string $value
     * @return string
     */
    private function cleanAbstract(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Remove invalid characters specific to abstracts
        $value = $this->removeInvalidChars($value);
        
        // Remove excessive line breaks and normalize
        $value = preg_replace('/\n+/', ' ', $value);
        $value = preg_replace('/\r+/', ' ', $value);
        $value = preg_replace('/\t+/', ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value);
        
        // Fix common text issues
        $value = $this->fixTextIssues($value);
        
        // Truncate if too long (max 65535 characters for longText)
        if (strlen($value) > 65000) {
            $value = substr($value, 0, 65000) . '...';
        }
        
        return $value;
    }

    /**
     * Remove invalid characters from text
     *
     * @param string $value
     * @return string
     */
    private function removeInvalidChars(string $value): string
    {
        // Remove Unicode replacement character and other invalid chars
        $value = preg_replace('/[\x{FFFD}]/u', '', $value);
        
        // Remove other Unicode control characters
        $value = preg_replace('/[\x{0000}-\x{001F}\x{007F}-\x{009F}\x{00AD}\x{0600}-\x{0603}\x{06DD}\x{200B}-\x{200F}\x{2028}-\x{202E}\x{2060}-\x{2064}\x{206A}-\x{206F}\x{FEFF}\x{FFF9}-\x{FFFB}]/u', '', $value);
        
        // Remove zero-width characters
        $value = preg_replace('/[\x{200B}\x{200C}\x{200D}\x{2060}\x{FEFF}]/u', '', $value);
        
        // Remove common problematic characters using hex codes
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value);
        
        return $value;
    }

    /**
     * Fix common text issues
     *
     * @param string $value
     * @return string
     */
    private function fixTextIssues(string $value): string
    {
        // Fix common spacing issues
        $value = preg_replace('/\s+([.,;:!?])/', '$1', $value);
        $value = preg_replace('/([.,;:!?])\s+/', '$1 ', $value);
        
        // Fix common word issues
        $value = str_replace(['  ', '   ', '    '], ' ', $value);
        
        return $value;
    }

    /**
     * Clean citation field
     *
     * @param string $value
     * @return string
     */
    private function cleanCitation(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Remove invalid characters specific to citations
        $value = $this->removeInvalidChars($value);
        
        // Normalize citation format
        $value = preg_replace('/\s+/', ' ', $value);
        
        // Fix common text issues
        $value = $this->fixTextIssues($value);
        
        return $value;
    }

    /**
     * Clean keywords field
     *
     * @param string $value
     * @return string
     */
    private function cleanKeywords(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Split by common separators and clean each keyword
        $keywords = preg_split('/[,;|]/', $value);
        $cleanKeywords = [];
        
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            if (!empty($keyword)) {
                // Convert to lowercase for consistency
                $keyword = strtolower($keyword);
                $cleanKeywords[] = $keyword;
            }
        }
        
        return implode(', ', $cleanKeywords);
    }

    /**
     * Clean publisher field
     *
     * @param string $value
     * @return string
     */
    private function cleanPublisher(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Normalize publisher names
        $value = preg_replace('/\s+/', ' ', $value);
        
        return $value;
    }

    /**
     * Clean department field
     *
     * @param string $value
     * @return string
     */
    private function cleanDepartment(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Normalize department names
        $value = preg_replace('/\s+/', ' ', $value);
        
        return $value;
    }

    /**
     * Clean URL field
     *
     * @param string $value
     * @return string
     */
    private function cleanUrl(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Validate URL format
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            // Try to fix common URL issues
            if (!preg_match('/^https?:\/\//', $value)) {
                $value = 'https://' . $value;
            }
        }
        
        return $value;
    }

    /**
     * Clean file path field
     *
     * @param string $value
     * @return string
     */
    private function cleanFilePath(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Normalize file paths
        $value = str_replace('\\', '/', $value);
        $value = preg_replace('/\/+/', '/', $value);
        
        return $value;
    }

    /**
     * Clean ISBN field
     *
     * @param string $value
     * @return string
     */
    private function cleanIsbn(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Extract ISBN from text if it contains "ISBN"
        if (strpos($value, 'ISBN') !== false) {
            preg_match('/ISBN\s*([0-9\-]+)/i', $value, $matches);
            if (isset($matches[1])) {
                $value = 'ISBN ' . $matches[1];
            }
        }
        
        return $value;
    }

    /**
     * Clean year field
     *
     * @param string $value
     * @return string
     */
    private function cleanYear(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Extract 4-digit year
        if (preg_match('/(\d{4})/', $value, $matches)) {
            $year = (int)$matches[1];
            if ($year >= 1900 && $year <= date('Y') + 1) {
                return (string)$year;
            }
        }
        
        return '';
    }

    /**
     * Clean tm (publication status) field
     *
     * @param string $value
     * @return string
     */
    private function cleanTm(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Normalize to P or NP
        $value = strtoupper($value);
        if (in_array($value, ['P', 'NP'])) {
            return $value;
        }
        
        // Default to P if invalid
        return 'P';
    }

    /**
     * Clean type field
     *
     * @param string $value
     * @return string
     */
    private function cleanType(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Normalize type values
        $value = ucfirst(strtolower($value));
        $validTypes = ['Journal', 'Conference', 'Book', 'Thesis', 'Report', 'Research', 'Article'];
        
        if (in_array($value, $validTypes)) {
            return $value;
        }
        
        // Default to Journal if invalid
        return 'Journal';
    }

    /**
     * Clean boolean fields
     *
     * @param string $value
     * @return string
     */
    private function cleanBoolean(string $value): string
    {
        // Remove quotes at the beginning and end
        $value = trim($value, '"\'');
        
        // Convert to boolean
        $value = strtolower($value);
        if (in_array($value, ['true', '1', 'yes', 'y', 'on'])) {
            return '1';
        }
        
        return '0';
    }

    /**
     * Validate row data
     *
     * @param array $data
     * @param int $rowNumber
     * @return array
     */
    private function validateRowData(array $data, int $rowNumber): array
    {
        $errors = [];
        $warnings = [];
        $is_valid = true;

        // Check if title exists (required)
        if (empty($data['title'])) {
            $errors[] = "Title is required for row {$rowNumber}";
            $is_valid = false;
        }

        // Validate enum values
        if (isset($data['tm']) && !in_array($data['tm'], ['P', 'NP'])) {
            $data['tm'] = 'P'; // Default to Published
        }

        if (isset($data['type']) && !in_array($data['type'], ['Journal', 'Conference', 'Book', 'Thesis', 'Report', 'Research', 'Article'])) {
            $data['type'] = 'Journal'; // Default to Journal
        }

        // Validate year
        if (isset($data['year']) && !is_numeric($data['year'])) {
            $errors[] = "Publication year must be a valid number for row {$rowNumber}";
            $is_valid = false;
        }

        // Convert boolean fields
        if (isset($data['status'])) {
            $data['status'] = $this->parseBoolean($data['status']);
        }

        if (isset($data['restricted'])) {
            $data['restricted'] = $this->parseBoolean($data['restricted']);
        }

        return [
            'is_valid' => $is_valid,
            'errors' => $errors,
            'warnings' => $warnings
        ];
    }

    /**
     * Parse boolean value from various formats
     *
     * @param mixed $value
     * @return bool
     */
    private function parseBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (bool) $value;
        }

        if (is_string($value)) {
            $value = strtolower(trim($value));
            return in_array($value, ['true', '1', 'yes', 'y', 'on']);
        }

        return false;
    }

    /**
     * Process a batch of records
     *
     * @param array $batch
     * @return void
     */
    private function processBatch(array $batch): void
    {
        DB::beginTransaction();
        try {
            foreach ($batch as $data) {
                // Check for duplicates based on title and authors
                $existing = ResearchPaper::where('title', $data['title'])
                    ->where('authors', $data['authors'] ?? '')
                    ->first();

                if (!$existing) {
                    ResearchPaper::create($data);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Batch import failed", [
                'error' => $e->getMessage(),
                'batch_size' => count($batch)
            ]);
            throw $e;
        }
    }
} 