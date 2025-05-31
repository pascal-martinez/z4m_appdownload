<?php

/*
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://www.znetdk.fr
 * Copyright (C) 2025 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile App Download module class
 *
 * File version: 1.0
 * Last update: 05/31/2025
 */

namespace z4m_appdownload\mod;

/**
 * Build a ZIP archive
 */
class AppArchive {

    protected $zipArchiveObj;
    protected $excludedPaths = [];
    protected $excludedFiles = [];

    /**
     * Creates the ZIP archive for the specified file path.
     * @param string $filePath Absolute file path of the ZIP archive.
     * @throws \Exception ZIP Archive creation has failed.
     */
    public function __construct($filePath) {
        $this->zipArchiveObj = new \ZipArchive();
        if ($this->zipArchiveObj->open($filePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            throw new \Exception('Unable to create the zip archive.');
        }
    }

    /**
     * Sets the paths of directories to exclude from the archive when the
     * AppArchive::copyDirectoryToArchive() method is called.
     * @param array $excludedPaths The absolute paths to exclude.
     */
    public function setExcludedPaths(array $excludedPaths) {
        $this->excludedPaths = [];
        foreach ($excludedPaths as $path) {
            $this->excludedPaths [] = str_replace('/', DIRECTORY_SEPARATOR, $path);
        }
    }

    /**
     * Sets the files to exclude from the archive when the
     * AppArchive::copyDirectoryToArchive() method is called.
     * @param array $excludedFiles The absolute file paths to exclude.
     */
    public function setExcludedFiles(array $excludedFiles) {
        $this->excludedFiles = [];
        foreach ($excludedFiles as $path) {
            $this->excludedFiles [] = str_replace('/', DIRECTORY_SEPARATOR, $path);
        }
    }

    /**
     * Indicates whether the specified directory path is excluded or not.
     * @param string $path Absolute directory path
     * @return boolean Value TRUE if the specified path matches an excluded
     * path, FALSE otherwise.
     */
    protected function isExcludedPath($path) {
        return in_array($path, $this->excludedPaths);
    }

    /**
     * Indicates whether the specified file path is excluded or not.
     * @param string $filePath Absolute file path
     * @return boolean Value TRUE if the specified path matches an excluded
     * path, FALSE otherwise.
     */

    protected function isExcludedFile($filePath) {
        return in_array($filePath, $this->excludedFiles);
    }

    /**
     * Adds a new directory within the archive
     * @param string $directory Relative path of the directory to add.
     * @return bool Value TRUE if the directory is added to the archive, FALSE
     * otherwise.
     * @throws \Exception An error occurred while adding the directory.
     */
    protected function createDirectoryInArchive($directory) {
        if (empty($directory)) {
            return FALSE;
        } elseif ($this->zipArchiveObj->locateName($directory . '/') !== FALSE) {
            return FALSE;
        }
        $status = $this->zipArchiveObj->addEmptyDir($directory);
        if ($status === FALSE) {
            throw new \Exception("Unable to add the directory '{$directory}' to the archive.");
        }
        return TRUE;
    }

    /**
     * Adds a file to the archive.
     * @param string $sourceFilePath Absolute file path of the file to add to
     * the archive.
     * @param string $targetDirectory Optional, relative directory path of the
     * file added to the archive. If not specified, the file is added to the 
     * root directory of the archive.
     * @param string $targetFilename Optional, file name within the archive. If
     * not specified, the original filename is kept.
     * @throws \Exception An error occurred while adding the specified file.
     */
    protected function addFileToArchive($sourceFilePath,
            $targetDirectory = '', $targetFilename = NULL) {
        $filename = is_null($targetFilename) ? basename($sourceFilePath) : $targetFilename;
        $this->createDirectoryInArchive($targetDirectory);
        $filePathInArchive = empty($targetDirectory) ? $filename : $targetDirectory . '/' . $filename;
        $status = $this->zipArchiveObj->addFile($sourceFilePath, $filePathInArchive);
        if ($status === FALSE) {
            throw new \Exception("Unable to add the file '{$filename}' to the archive.");
        }
    }

    /**
     * Add the specified directory and its content to the archive.
     * @param string $sourceDirectory Absolute path of the directory to copy to
     * the archive.
     * @param string $targetDirectory Relative path of the directory added to 
     * the archive.
     */
    protected function copyDirectoryToArchive($sourceDirectory, $targetDirectory) {
        $this->createDirectoryInArchive($targetDirectory);
        $dirContent = array_diff(scandir($sourceDirectory, SCANDIR_SORT_ASCENDING), array('..', '.'));
        foreach ($dirContent as $filename) {
            $filePath = $sourceDirectory . DIRECTORY_SEPARATOR . $filename;
            if (is_file($filePath) && !$this->isExcludedFile($filePath)) {
                $this->addFileToArchive($filePath, $targetDirectory);
            } elseif (is_dir($filePath) && !$this->isExcludedPath($filePath)) {
                $targetSubDirectory = "{$targetDirectory}/{$filename}";
                $this->copyDirectoryToArchive($filePath, $targetSubDirectory);
            }
        }
    }

    /**
     * Closes the archive
     * @throws \Exception Archive closing has failed.
     */
    protected function close() {
        if ($this->zipArchiveObj->close() === FALSE) {
            throw new \Exception('Unable to close the archive.');
        }
    }
}
