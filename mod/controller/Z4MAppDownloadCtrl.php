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
 * ZnetDK 4 Mobile App Download module Controller class
 * 
 * File version: 1.0
 * Last update: 05/29/2025
 */

namespace z4m_appdownload\mod\controller;

use z4m_appdownload\mod\AppCodeArchive;
use z4m_appdownload\mod\AppDataArchive;
use z4m_appdownload\mod\AppDocsArchive;

/**
 * App controller to download the App's code, database data and documents
 */
class Z4MAppDownloadCtrl extends \AppController {
    
    /**
     * Evaluates whether action is allowed or not.
     * When authentication is required, action is allowed if connected user has
     * full menu access or if has a profile allowing access to the
     * 'z4m_appdownload' view.
     * If no authentication is required, action is allowed if the expected view
     * menu item is declared in the 'menu.php' script of the application.
     * @param string $action Action name
     * @return Boolean TRUE if action is allowed, FALSE otherwise
     */
    static public function isActionAllowed($action) {
        $status = parent::isActionAllowed($action);
        if ($status === FALSE) {
            return FALSE;
        }
        $actionView = [
            'download' => 'z4m_appdownload'
        ];
        $menuItem = key_exists($action, $actionView) ? $actionView[$action] : NULL;
        return CFG_AUTHENT_REQUIRED === TRUE
            ? \controller\Users::hasMenuItem($menuItem) // User has right on menu item
            : \MenuManager::getMenuItem($menuItem) !== NULL; // Menu item declared in 'menu.php'
    }
    
    /**
     * Controller action called for downloading code, data or documents.
     * POST parameters:
     * - file_type = 'code', 'data' or 'documents'.
     * @return \Response file in ZIP format.
     */
    static protected function action_download() {
        $request = new \Request();
        $response = new \Response();
        if (!in_array($request->file_type, ['code', 'data', 'documents'])) {
            $response->doHttpError(500, 'App download', 'unknown file type.');
        }
        try {
            switch ($request->file_type) {
                case 'code':
                    $archive = new AppCodeArchive();
                    break;
                case 'data':
                    $archive = new AppDataArchive();
                    break;
                case 'documents':
                    $archive = new AppDocsArchive();
                    break;
            }            
            $archive->generate();
            $filepath = $archive->getFilePath();
            $exportDate = (new \DateTime('now'))->format('Ymd_His');
            $filename = "{$request->file_type}_{$exportDate}.zip";            
            $response->setFileToDownload($filepath, FALSE, $filename);
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->doHttpError(500, 'App download', "An error occured while downloading data.");
        }
        return $response;
    }
    
}
