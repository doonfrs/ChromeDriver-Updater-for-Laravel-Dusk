<?php
error_reporting(E_ALL);

$version = "120.0.6099.71";
$files = [
    'linux64/chromedriver-linux64.zip' => 'chromedriver-linux',
    'mac-arm64/chromedriver-mac-arm64.zip' => 'chromedriver-mac-arm',
    'mac-x64/chromedriver-mac-x64.zip' => 'chromedriver-mac-intel',
    'win64/chromedriver-win64.zip' => 'chromedriver-win',
];


foreach ($files as $driverUrlPath => $filename) { // Remove the existing chromedriver-linux file
    $vendorBinPath = "vendor/laravel/dusk/bin";
    $driverPath =  $vendorBinPath . '/' . $filename;
    $outputPath = $vendorBinPath . '/' . substr(basename($driverUrlPath), 0, -4);
    $outputZipFile = $outputPath . '.zip';
    $driverBinFile = "$vendorBinPath/$filename";

    output($outputPath);
    deletePath($outputPath);
    deletePath($outputZipFile);

    $driverUrl = "https://edgedl.me.gvt1.com/edgedl/chrome/chrome-for-testing/$version/$driverUrlPath";

    output("Downloading $driverUrl");
    download($driverUrl, $outputZipFile);

    output("Extracting $outputZipFile");
    // Unzip the file
    $zip = new ZipArchive;
    if ($zip->open($outputZipFile) === TRUE) {
        $zip->extractTo($vendorBinPath);
        $zip->close();
    } else {
        exit("Failed to open $outputZipFile\n");
    }

    $newDriverOutputPath = $outputPath . '/chromedriver';
    if (!is_file($newDriverOutputPath)) {
        $newDriverOutputPath .= '.exe';
        if (!is_file($newDriverOutputPath)) {
            exit("Failed to find $newDriverOutputPath\n");
        }
    }

    rename($newDriverOutputPath, $driverBinFile);

    deletePath($outputZipFile);
    deletePath($outputPath);
}

output("Done!");

function output($message)
{
    echo $message . "\n";
}

function deletePath($dirPath)
{
    if (!is_file($dirPath) && !is_dir($dirPath)) {
        return;
    }
    if (!is_dir($dirPath)) {
        unlink($dirPath);
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deletePath($file);
        } else {
            unlink($file);
        }
    }
    if (!is_file($dirPath) && !is_dir($dirPath)) {
        return;
    }
    rmdir($dirPath);
}


function download($url, $output)
{
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        exit(curl_error($ch));
    }
    curl_close($ch);
    file_put_contents($output, $data);
}
