# ChromeDriver Updater for Laravel Dusk

## Description
This PHP script automates the process of updating the ChromeDriver binaries for Laravel Dusk. It supports different operating systems and architectures, including Linux, macOS (both Intel and ARM architectures), and Windows. The script downloads the specified version of ChromeDriver, extracts it, and places it in the appropriate directory for Laravel Dusk.

## Features
- Supports multiple platforms: Linux, macOS (Intel and ARM), and Windows.
- Automatically downloads and extracts the correct ChromeDriver version.
- Cleans up old ChromeDriver files before updating.

## Prerequisites
- PHP environment setup.
- cURL extension enabled in PHP for downloading files.
- Write permissions in the target directories.

## Usage
1. Set the desired version of ChromeDriver in the `$version` variable.
2. Run the script in your PHP environment.

The script will download and update the ChromeDriver binaries for all supported platforms in the `vendor/laravel/dusk/bin` directory.

## Configuration
- `$version`: Set this variable to the desired version of ChromeDriver.
- `$files`: An associative array mapping the download paths to the corresponding driver filenames.

## Functions
- `output($message)`: Outputs a message to the console.
- `deletePath($dirPath)`: Deletes a file or recursively deletes a directory.
- `download($url, $output)`: Downloads a file from a URL.

## Note
- Ensure that your PHP environment has the necessary permissions to modify files and directories.
- The script uses cURL for downloading files and may require internet access.
- This script should be used with caution as it can overwrite existing files.

## Disclaimer
This script is provided as-is without any guarantees or warranty. The author is not responsible for any damage or losses of any kind caused by the use or misuse of the script.
