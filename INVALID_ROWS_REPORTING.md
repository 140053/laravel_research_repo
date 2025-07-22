# Invalid Rows Reporting Guide

This guide explains the enhanced invalid rows reporting functionality that provides detailed information about invalid rows and their specific invalid values.

## 🔍 **Enhanced Error Reporting Features**

### **Detailed Invalid Rows Information**
- ✅ **Row Number**: Shows the exact row number where the error occurred
- ✅ **Original Data**: Displays the raw CSV data as it was read
- ✅ **Cleaned Data**: Shows the data after cleaning and processing
- ✅ **Specific Errors**: Lists the exact validation errors for each row
- ✅ **Warnings**: Shows any warnings associated with the row

### **Validation Error Types**

#### **Data Type Validation**
- **Invalid Enum Values**: Reports invalid values for `tm` (must be 'P' or 'NP') and `type` fields
- **Invalid Boolean Values**: Reports invalid boolean values for `status` and `restricted` fields
- **Invalid Year Format**: Reports non-numeric or unrealistic year values
- **Invalid URL Format**: Reports malformed URLs in `external_link` field

#### **Content Validation**
- **Missing Required Fields**: Reports empty required fields like `title`
- **Invalid Characters**: Reports problematic Unicode characters including ``
- **Control Characters**: Reports control characters in text fields
- **Length Validation**: Reports overly long abstracts (max 65,000 characters)

## 📊 **Command Line Output Example**

```bash
$ php artisan import:research-papers test_file.csv

Starting CSV validation and import from: test_file.csv
CSV validation failed!
Total errors found: 7
Total warnings found: 0

Errors:
  - Row 3: Invalid 'tm' value 'INVALID'. Must be 'P' or 'NP'
  - Row 4: Invalid 'type' value 'InvalidType'. Must be one of: Journal, Conference, Book, Thesis, Report
  - Row 5: Invalid year 'INVALID_YEAR'. Must be a number
  - Row 6: Invalid URL format 'invalid-url-format'
  - Row 7: Invalid 'status' value 'INVALID_STATUS'. Must be a boolean value
  - Row 9: Title is required but empty

Proceeding with import despite validation errors. Invalid rows will be skipped.

Import completed successfully!
Total rows processed: 8
Successfully imported: 6
Skipped (duplicates/errors): 2

Errors encountered:
  - Row 5: Publication year must be a valid number for row 5
  - Row 9: Title is required for row 9

Detailed Invalid Rows Information:
=====================================

Row 5:
  Original Data: ["Paper with Invalid Year","Valid Author","Valid Editor","P","Journal","Valid Publisher","ISBN 123-456-789","This abstract is valid.","INVALID_YEAR","Valid Department","","","Valid Citation","valid keywords","1","0"]
  Cleaned Data: {"title":"Paper With Invalid Year","authors":"Valid Author","editors":"Valid Editor","tm":"P","type":"Journal","publisher":"Valid Publisher","isbn":"ISBN 123-456-789","abstract":"This abstract is valid.","year":"","department":"Valid Department","pdf_path":null,"external_link":null,"citation":"Valid Citation","keyword":"valid keywords","status":"1","restricted":"0"}
  Errors:
    - Publication year must be a valid number for row 5

Row 9:
  Original Data: ["","Valid Author","Valid Editor","P","Journal","Valid Publisher","ISBN 123-456-789","This abstract is valid but title is empty.","2023","Valid Department","","","Valid Citation","valid keywords","1","0"]
  Cleaned Data: {"title":null,"authors":"Valid Author","editors":"Valid Editor","tm":"P","type":"Journal","publisher":"Valid Publisher","isbn":"ISBN 123-456-789","abstract":"This abstract is valid but title is empty.","year":"2023","department":"Valid Department","pdf_path":null,"external_link":null,"citation":"Valid Citation","keyword":"valid keywords","restricted":"0"}
  Errors:
    - Title is required for row 9
```

## 🌐 **Web Interface Output**

The web interface provides a detailed table showing:

| Column | Description |
|--------|-------------|
| **Row #** | The row number in the CSV file |
| **Original Data** | Raw CSV data as read from the file |
| **Cleaned Data** | Data after cleaning and processing |
| **Errors** | Specific validation errors for the row |
| **Warnings** | Any warnings associated with the row |

## 🛠️ **Technical Implementation**

### **Enhanced Service Class**
- `CsvImportService::importResearchPapers()` now returns detailed invalid rows information
- Each invalid row includes:
  - `row_number`: The CSV row number
  - `original_data`: Raw CSV data
  - `cleaned_data`: Processed data after cleaning
  - `errors`: Array of specific error messages
  - `warnings`: Array of warning messages

### **Enhanced Command Class**
- `ImportResearchPapersFromCsv::handle()` displays detailed invalid rows information
- Shows original data, cleaned data, and specific errors
- Provides comprehensive error reporting

### **Enhanced Web Controller**
- `CsvImportController::import()` returns invalid rows data to frontend
- Web interface displays detailed table of invalid rows
- Provides user-friendly error reporting

## 📋 **Error Categories**

### **Data Type Errors**
- **Enum Validation**: Invalid values for `tm` and `type` fields
- **Boolean Validation**: Invalid boolean values for `status` and `restricted`
- **Numeric Validation**: Invalid year values
- **URL Validation**: Malformed URLs

### **Content Errors**
- **Required Fields**: Missing required fields like `title`
- **Invalid Characters**: Unicode replacement characters and control characters
- **Length Validation**: Overly long content

### **Format Errors**
- **CSV Parsing**: Issues with CSV structure
- **Encoding Issues**: Character encoding problems
- **File Format**: Malformed CSV files

## 🚀 **Benefits**

1. **Detailed Debugging**: Shows exactly what data caused the error
2. **Easy Fixing**: Original data helps identify the source of problems
3. **Comprehensive Reporting**: Both command line and web interface support
4. **User-Friendly**: Clear error messages with specific details
5. **Data Quality**: Helps identify patterns in data issues
6. **Process Transparency**: Shows both original and cleaned data

## 📝 **Usage Examples**

### **Command Line**
```bash
# Validate only
php artisan import:research-papers file.csv --validate-only

# Import with detailed reporting
php artisan import:research-papers file.csv

# Dry run with detailed reporting
php artisan import:research-papers file.csv --dry-run
```

### **Web Interface**
- Upload CSV file through web form
- View detailed invalid rows table
- Download template for correct format
- See both original and cleaned data

## 🔧 **Configuration**

The invalid rows reporting is automatically enabled and provides:
- Detailed error messages with row numbers
- Original vs cleaned data comparison
- Specific field-level error reporting
- Comprehensive validation coverage 