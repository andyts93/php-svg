# ToothColor SVG Processor

This PHP script processes an SVG file, colors specific elements (representing teeth) by their IDs, and either outputs the modified SVG or saves it as a new file.

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
    - [Arguments](#arguments)
    - [Output Modes](#output-modes)
- [Exceptions](#exceptions)
- [Example](#example)

## Requirements

- PHP 7.4+
- Composer (for installing the necessary dependencies)

## Installation

1. Clone this repository or download the script.

2. Install the required dependencies using Composer:
   ```bash
   composer install
   ```
   
## Usage
### Arguments
- `$svgFile`: The path to the SVG file you want to process. **(Required)**
- `$outputMode`: The output mode, which determines whether the result is printed to the browser or saved to a file. **(Required)**
  - `'O'` (output): Outputs the modified SVG directly to the browser.
  - `'F'` (file): Saves the modified SVG to the storage/filled/ directory.
- `...$args`: One or more IDs of the teeth elements you want to color. **(Optional)**
### Output modes
- **O (Output)**: Sends the modified SVG directly to the browser with the `Content-Type: image/svg+xml` header.
- **F (File)**: Saves the modified SVG to the `storage/filled/` directory with a unique filename and returns the file path.

## Example
You can use `index.php` file in this repository for some quick examples.
To try the `F` mode you can start a PHP server with `php -S localhost:8000` and navigate to http://localhost:8000
```php
require 'path/to/toothColor.php';

try {
    // Output mode: O (direct to browser)
    toothColor('path/to/teeth.svg', 'O', 1, 3, 5);

    // Output mode: F (save to file)
    $savedFilePath = toothColor('path/to/teeth.svg', 'F', 1, 3, 5);
    echo "File saved to: " . $savedFilePath;

} catch (FileNotFoundException $e) {
    echo "Error: SVG file not found!";
} catch (FileNotValidException $e) {
    echo "Error: The provided file is not a valid SVG!";
} catch (OutputModeNotValidException $e) {
    echo "Error: Output mode is invalid!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Exceptions
The following exceptions may be thrown by the script:
- `FileNotFoundException`: Thrown when the provided SVG file cannot be found.
- `FileNotValidException`: Thrown when the provided file is not a valid SVG.
- `OutputModeNotValidException`: Thrown when an invalid output mode is provided (valid modes are 'O' and 'F').
- `Exception`: Thrown if there is an error when attempting to save the SVG in `F` mode.