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
 * Build a ZIP archive containing the documents of the application
 */
class AppDocsArchive extends AppArchive {
    protected $filePath;
    
    /**
     * Creates the archive
     * @throws \Exception The documents subdirectory is missing
     */
    public function __construct() {
        if (!self::doesDocumentsSubFolderExists()) {
            throw new \Exception('The document folder does not exist.');
        }
        $this->filePath = tempnam(sys_get_temp_dir(), 'z4m_appdownload_docs');
        parent::__construct($this->filePath);
    }
    
    static public function doesDocumentsSubFolderExists() {
        return is_dir(CFG_DOCUMENTS_DIR);
    }
    
    /**
     * Generates the ZIP archive of the application.
     */
    public function generate() {
        $documentsRelativePath = 'applications/' . ZNETDK_APP_NAME . '/documents';
        $this->copyDirectoryToArchive(CFG_DOCUMENTS_DIR, $documentsRelativePath);
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
    
}
