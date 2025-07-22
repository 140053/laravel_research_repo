# CSV Import Guide for Research Papers

This guide explains how to import research papers from a CSV file into the database.

## Overview

The import system consists of:
- **Artisan Command**: `ImportResearchPapersFromCsv` - Handles the import process
- **Service Class**: `CsvImportService` - Contains the import logic and validation
- **Model**: `ResearchPaper` - The Eloquent model for research papers

## Usage

### Basic Import

```bash
php artisan import:research-papers path/to/your/file.csv
```

### Dry Run (Test without importing)

```bash
php artisan import:research-papers path/to/your/file.csv --dry-run
```

## CSV Format

### Required Columns

- **title** (required): The title of the research paper

### Optional Columns

The system supports flexible column naming. Here are the supported variations:

| Database Column | Supported CSV Headers |
|----------------|---------------------|
| `title` | title, Title, TITLE, paper_title, Paper Title |
| `authors` | authors, Authors, AUTHORS, author, Author |
| `editors` | editors, Editors, EDITORS, editor, Editor |
| `tm` | tm, TM, status, Status, publication_status |
| `type` | type, Type, TYPE, paper_type, Paper Type |
| `publisher` | publisher, Publisher, PUBLISHER |
| `isbn` | isbn, ISBN, isbn_number |
| `abstract` | abstract, Abstract, ABSTRACT, summary, Summary |
| `year` | year, Year, YEAR, publication_year, Publication Year |
| `department` | department, Department, DEPARTMENT, dept |
| `pdf_path` | pdf_path, PDF Path, pdf, PDF, file_path |
| `external_link` | external_link, External Link, link, Link, url, URL |
| `citation` | citation, Citation, CITATION, cite |
| `keyword` | keyword, Keyword, KEYWORD, keywords, Keywords, KEYWORDS, tags, Tags |
| `status` | status, Status, STATUS, in_collection |
| `restricted` | restricted, Restricted, RESTRICTED, featured |

### Data Types and Validation

#### Enum Fields
- **tm**: Must be 'P' (Published) or 'NP' (Not Published). Defaults to 'P' if invalid.
- **type**: Must be 'Journal', 'Conference', 'Book', 'Thesis', or 'Report'. Defaults to 'Journal' if invalid.

#### Boolean Fields
- **status**: Accepts various formats (true/false, 1/0, yes/no, y/n, on/off)
- **restricted**: Same as status field

#### Numeric Fields
- **year**: Must be a valid number. Invalid values are set to null.

#### Text Fields
- All text fields support long text content
- Empty strings are converted to null

## Features

### Duplicate Detection
The system checks for duplicates based on:
- Title
- Authors

If a paper with the same title and authors already exists, it will be skipped.

### Batch Processing
- Processes records in batches of 100 for better performance
- Uses database transactions for data integrity

### Error Handling
- Detailed error reporting for each row
- Continues processing even if individual rows fail
- Logs errors for debugging

### Validation
- Validates required fields (title)
- Validates enum values
- Converts data types appropriately
- Handles empty/null values

## Example CSV File

```csv
title,authors,editors,tm,type,publisher,isbn,abstract,year,department,pdf_path,external_link,citation,keyword,status,restricted
"Machine Learning Applications in Healthcare","John Doe, Jane Smith","Dr. Robert Johnson","P","Journal","IEEE Transactions","978-1234567890","This paper explores the application of machine learning algorithms in healthcare diagnostics and treatment planning.","2023","Computer Science","/storage/papers/ml_healthcare.pdf","https://example.com/paper","Doe, J., & Smith, J. (2023). Machine Learning Applications in Healthcare. IEEE Transactions.","machine learning, healthcare, diagnostics, AI","1","0"
```

## Output

The command will display:
- Total rows processed
- Number of successfully imported records
- Number of skipped records (duplicates/errors)
- List of errors encountered

## Troubleshooting

### Common Issues

1. **File not found**: Ensure the CSV file path is correct
2. **Permission denied**: Check file permissions
3. **Invalid CSV format**: Ensure proper CSV formatting with headers
4. **Database errors**: Check database connection and table structure

### Debugging

- Use `--dry-run` to test without importing
- Check Laravel logs for detailed error information
- Verify CSV file encoding (UTF-8 recommended)

## Performance Tips

- For large files (>10,000 rows), consider splitting into smaller files
- Ensure adequate memory allocation for PHP
- Monitor database performance during import
- Use SSD storage for better I/O performance 