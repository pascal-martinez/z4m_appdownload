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
 * Last update: 05/29/2025
 */

namespace z4m_appdownload\mod;

/**
 * Build a ZIP archive containing App's code
 */
class AppCodeArchive extends AppArchive {
    protected $filePath;
    protected $appConfigRelativePath = 'applications/' . ZNETDK_APP_NAME . '/app/config.php';
    protected $rootHtaccessFilePath = ZNETDK_ROOT . '.htaccess';
    protected $excludedDirectories = [
        ZNETDK_ROOT . 'applications/' . ZNETDK_APP_NAME . '/documents',
        ZNETDK_ROOT . 'engine/log'
    ];
    protected $configConstantsWithPassword = ['CFG_SQL_APPL_PWD'];
    
    /**
     * Creates the archive
     */
    public function __construct() {
        $this->filePath = tempnam(sys_get_temp_dir(), 'z4m_appdownload_code');
        parent::__construct($this->filePath);
        $this->setExcludedPaths($this->excludedDirectories);
        $this->setExcludedFiles([
            ZNETDK_ROOT . $this->appConfigRelativePath,
            $this->rootHtaccessFilePath
        ]);
    }
    
    /**
     * Generates the ZIP archive of the App's code.
     * The 'applications/default/documents' and 'engine/log' directories are
     * excluded from the archive.
     * The root '.htaccess' file is renamed 'htaccess_copy' as it will be
     * recreated the first time the App will be executed on the new hosting.
     */
    public function generate() {
        $this->copyDirectoryToArchive(realpath(ZNETDK_ROOT), '');
        $this->createDirectoryInArchive('engine/log');
        $this->addConfigScriptWithoutPasswords();
        $this->addFileToArchive($this->rootHtaccessFilePath, '', 'htaccess_copy');
        $this->close();
        // Archive removed once session is closed
        register_shutdown_function('unlink', $this->filePath);
    }
    
    /**
     * Returns archive absolute file path.
     * @return string file path.
     */
    public function getFilePath() {
        return $this->filePath;
    }    
    
    /**
     * Adds to the archive the 'config.php' script after clearing password for
     * the CFG_SQL_APPL_PWD constant.
     * @throws \Exception Error reading 'config.php' script or writing its new
     * version in the archive. 
     */
    protected function addConfigScriptWithoutPasswords() {
        $configScriptPath = ZNETDK_ROOT . $this->appConfigRelativePath;
        if (!file_exists($configScriptPath)) {
            throw new \Exception("Unable to read the APP's config.php file.");
        }
        $scriptContent = file_get_contents($configScriptPath);
        if ($scriptContent === FALSE) {
            throw new \Exception("Unable to read content of the App's config.php file.");
        }
        
        foreach ($this->configConstantsWithPassword as $phpConstant) {
            self::clearPassword($scriptContent, $phpConstant);
        }
        
        $archiveConfigScriptPath = $this->appConfigRelativePath;
        if ($this->zipArchiveObj->addFromString($archiveConfigScriptPath, $scriptContent) === FALSE) {
            throw new \Exception("Unable to write App's config.php file in archive.");
        }
    }
    
    static protected function clearPassword(&$content, $parameterName, $position = 0) {
        $foundPos = strpos($content, $parameterName, $position);
        if ($foundPos === FALSE) {
            return;
        }
        $currentPos = $foundPos + strlen($parameterName) + 1;
        $valueSeparator = NULL;
        $valueSeparatorStart = NULL;
        while ($currentPos < strlen($content) && $content[$currentPos] !== "\n") {
            $currentChar = $content[$currentPos];
            if (is_null($valueSeparator) && ($currentChar === '"' || $currentChar === "'")) {
                    $valueSeparator = $currentChar;
                    $valueSeparatorStart = $currentPos;
            } elseif ($currentChar === $valueSeparator) {
                $content = substr($content, 0, $valueSeparatorStart+1)
                        . '####' . substr($content, $currentPos);
                break;
            }
            $currentPos++;
        }
        self::clearPassword($content, $parameterName, $currentPos);
    }
    
}
