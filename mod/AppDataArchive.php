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
 * Build a ZIP archive containing the data of the application in SQL format
 */
class AppDataArchive extends AppArchive {
    protected $filePath;
    
    /**
     * Creates the archive
     * @throws \Exception No database configured
     */
    public function __construct() {
        if (!self::isDatabaseConfigured()) {
            throw new \Exception('No database configured for the application.');
        }
        $this->filePath = tempnam(sys_get_temp_dir(), 'z4m_appdownload_data');        
        parent::__construct($this->filePath);
    }
    
    /**
     * Checks if a database is configured for the application.
     * @return boolean Value TRUE if database is configurer, FALSE otherwise.
     */
    static public function isDatabaseConfigured() {
        return !(CFG_SQL_APPL_DB === NULL || CFG_SQL_APPL_DB === NULL
                || CFG_SQL_APPL_DB === NULL || CFG_SQL_APPL_PWD === NULL);
    }
    
    /**
     * Generates the ZIP archive of the application.
     */
    public function generate() {
        $sqlFilePath = self::exportDatabase();
        $this->addFileToArchive($sqlFilePath, '', CFG_SQL_APPL_DB . '_database.sql');
        $this->close();
        // SQL file removed once archived is generated
        unlink($sqlFilePath);
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
     * Generates the password file required to export data in SQL format
     * @return string File path of the password file
     * @throws \Exception Password file creation has failed.
     */
    static protected function generatePasswordFile() {
        $pwdFilePath = tempnam(sys_get_temp_dir(), 'z4m_appdownload_pwdsql');
        if ($pwdFilePath === FALSE) {
            throw new \Exception('creation of the temporary password file failed!');
        }
        $fileContent = '[client]' . "\n" . 'password="' . CFG_SQL_APPL_PWD . '"';
        if (file_put_contents($pwdFilePath, $fileContent) === FALSE) {
            throw new \Exception('Update of the temporary password file failed!');
        }
        return $pwdFilePath;
    }
    
    /**
     * Exports database data in SQL format 
     * @return string SQL file path
     * @throws \Exception MOD_Z4M_APPDOWNLOAD_MYSQLDUMP_PATH not set properly,
     * SQL export has failed
     */
    static protected function exportDatabase() {
        // Database export as SQL file
        if (MOD_Z4M_APPDOWNLOAD_MYSQLDUMP_PATH === NULL) {
            throw new \Exception('MOD_Z4M_APPDOWNLOAD_MYSQLDUMP_PATH parameter is not properly set!');
        }
        $host = CFG_SQL_HOST; $user = CFG_SQL_APPL_USR; $dbname = CFG_SQL_APPL_DB;
        $pwdfile = self::generatePasswordFile();
        $sqlfile = tempnam(sys_get_temp_dir(), 'z4m_appdownload_sql');
        $command = MOD_Z4M_APPDOWNLOAD_MYSQLDUMP_PATH
                . " --defaults-file={$pwdfile} --host={$host} --user={$user} {$dbname} > {$sqlfile}";
        $output = ''; $returnValue = 0;
        exec($command, $output, $returnValue);
        // Remove password file
        unlink($pwdfile);
        // Check exported file
        if ($returnValue > 0 || filesize($sqlfile) === 0) {
            $outputString = implode("\n", $output);
            \General::writeErrorLog(__METHOD__, "The SQL export in command line failed: {$command}\n{$outputString}");
            throw new \Exception("SQL export failed (returned value = {$returnValue}).");
        }
        return $sqlfile;
    }
    
}
