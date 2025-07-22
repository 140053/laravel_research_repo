<?php

namespace App\Console\Commands;

use App\Models\ResearchPaper;
use App\Services\CsvImportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportResearchPapersFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:research-papers {file : Path to the CSV file} {--dry-run : Run without actually importing data} {--validate-only : Only validate the CSV file without importing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import research papers from a CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $dryRun = $this->option('dry-run');
        $validateOnly = $this->option('validate-only');

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Starting CSV validation and import from: {$filePath}");
        
        if ($validateOnly) {
            $this->warn("VALIDATION ONLY MODE - No data will be imported");
        } elseif ($dryRun) {
            $this->warn("DRY RUN MODE - No data will be imported");
        }

        try {
            // First, validate the CSV file
            $validationResult = $this->validateCsvFile($filePath);
            
            if (!$validationResult['is_valid']) {
                $this->error("CSV validation failed!");
                $this->error("Total errors found: " . count($validationResult['errors']));
                $this->error("Total warnings found: " . count($validationResult['warnings']));
                
                if (!empty($validationResult['errors'])) {
                    $this->error("\nErrors:");
                    foreach ($validationResult['errors'] as $error) {
                        $this->error("  - {$error}");
                    }
                }
                
                if (!empty($validationResult['warnings'])) {
                    $this->warn("\nWarnings:");
                    foreach ($validationResult['warnings'] as $warning) {
                        $this->warn("  - {$warning}");
                    }
                }
                
                if ($validateOnly) {
                    $this->info("\nValidation completed. Please fix the errors before importing.");
                    return 1;
                } else {
                    $this->warn("\nProceeding with import despite validation errors. Invalid rows will be skipped.");
                }
            }

            if ($validateOnly) {
                $this->info("CSV validation passed successfully!");
                $this->info("Total rows validated: {$validationResult['total_rows']}");
                $this->info("Valid rows: {$validationResult['valid_rows']}");
                $this->info("Invalid rows: {$validationResult['invalid_rows']}");
                
                if (!empty($validationResult['warnings'])) {
                    $this->warn("\nWarnings found:");
                    foreach ($validationResult['warnings'] as $warning) {
                        $this->warn("  - {$warning}");
                    }
                }

                // Display detailed invalid rows information
                if (!empty($validationResult['invalid_rows_details'])) {
                    $this->warn("\nDetailed Invalid Rows Information:");
                    $this->warn("=====================================");
                    
                    foreach ($validationResult['invalid_rows_details'] as $invalidRow) {
                        $this->warn("\nRow {$invalidRow['row_number']}:");
                        $this->warn("  Original Data: " . json_encode($invalidRow['original_data']));
                        $this->warn("  Cleaned Data: " . json_encode($invalidRow['cleaned_data']));
                        
                        if (!empty($invalidRow['errors'])) {
                            $this->error("  Errors:");
                            foreach ($invalidRow['errors'] as $error) {
                                $this->error("    - {$error}");
                            }
                        }
                        
                        if (!empty($invalidRow['warnings'])) {
                            $this->warn("  Warnings:");
                            foreach ($invalidRow['warnings'] as $warning) {
                                $this->warn("    - {$warning}");
                            }
                        }
                    }
                }
                
                return 0;
            }

            // Proceed with import
            $importService = new CsvImportService();
            $result = $importService->importResearchPapers($filePath, $dryRun);

            $this->info("Import completed successfully!");
            $this->info("Total rows processed: {$result['total']}");
            $this->info("Successfully imported: {$result['imported']}");
            $this->info("Skipped (duplicates/errors): {$result['skipped']}");

            if (!empty($result['errors'])) {
                $this->warn("Errors encountered:");
                foreach ($result['errors'] as $error) {
                    $this->error("  - {$error}");
                }
            }

            // Display detailed invalid rows information
            if (!empty($result['invalid_rows'])) {
                $this->warn("\nDetailed Invalid Rows Information:");
                $this->warn("=====================================");
                
                foreach ($result['invalid_rows'] as $invalidRow) {
                    $this->warn("\nRow {$invalidRow['row_number']}:");
                    $this->warn("  Original Data: " . json_encode($invalidRow['original_data']));
                    $this->warn("  Cleaned Data: " . json_encode($invalidRow['cleaned_data']));
                    
                    if (!empty($invalidRow['errors'])) {
                        $this->error("  Errors:");
                        foreach ($invalidRow['errors'] as $error) {
                            $this->error("    - {$error}");
                        }
                    }
                    
                    if (!empty($invalidRow['warnings'])) {
                        $this->warn("  Warnings:");
                        foreach ($invalidRow['warnings'] as $warning) {
                            $this->warn("    - {$warning}");
                        }
                    }
                }
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Import failed: " . $e->getMessage());
            Log::error("CSV import failed", [
                'file' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
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
            'warnings' => [],
            'invalid_rows_details' => []
        ];

        try {
            $handle = fopen($filePath, 'r');
            if (!$handle) {
                $result['errors'][] = "Cannot open file: {$filePath}";
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
                $result['warnings'][] = "File size is large ({$fileSize} bytes). Import may take a while.";
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
                    
                    // Add detailed invalid row information
                    $result['invalid_rows_details'][] = [
                        'row_number' => $rowNumber,
                        'original_data' => $row,
                        'cleaned_data' => $this->mapRowData($row, $headers, $columnMap),
                        'errors' => $rowValidation['errors'],
                        'warnings' => $rowValidation['warnings'] ?? []
                    ];
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
            if (!empty($typeValue) && !in_array($typeValue, ['Journal', 'Conference', 'Book', 'Thesis', 'Report', 'Research', 'Article'])) {
                $result['errors'][] = "Row {$rowNumber}: Invalid 'type' value '{$typeValue}'. Must be one of: Journal, Conference, Book, Thesis, Report, Research, Article";
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

        // Validate URL format
        if (isset($columnMap['external_link'])) {
            $urlValue = trim($row[$columnMap['external_link']] ?? '');
            if (!empty($urlValue) && !filter_var($urlValue, FILTER_VALIDATE_URL)) {
                $result['errors'][] = "Row {$rowNumber}: Invalid URL format '{$urlValue}'";
                $result['is_valid'] = false;
            }
        }

        // Validate abstract length
        if (isset($columnMap['abstract'])) {
            $abstractValue = trim($row[$columnMap['abstract']] ?? '');
            if (!empty($abstractValue) && strlen($abstractValue) > 65000) {
                $result['errors'][] = "Row {$rowNumber}: Abstract is too long (max 65000 characters)";
                $result['is_valid'] = false;
            }
        }

        // Check for invalid characters in text fields
        $textFields = ['title', 'authors', 'editors', 'abstract', 'citation', 'keyword', 'publisher', 'department'];
        foreach ($textFields as $field) {
            if (isset($columnMap[$field])) {
                $fieldValue = trim($row[$columnMap[$field]] ?? '');
                if (!empty($fieldValue)) {
                    // Check for invalid characters
                    if (preg_match('/[\x{FFFD}]/u', $fieldValue)) {
                        $result['errors'][] = "Row {$rowNumber}: Field '{$field}' contains invalid Unicode characters";
                        $result['is_valid'] = false;
                    }
                    
                    // Check for control characters
                    if (preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $fieldValue)) {
                        $result['errors'][] = "Row {$rowNumber}: Field '{$field}' contains control characters";
                        $result['is_valid'] = false;
                    }
                }
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
            'tm' => ['tm', 'TM', 'publication_status'],
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
                }

                $data[$dbColumn] = $value;
            }
        }

        return $data;
    }
} 