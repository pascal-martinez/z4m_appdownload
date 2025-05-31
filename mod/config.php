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
 * Parameters of the ZnetDK 4 Mobile App Download module
 * 
 * File version: 1.0
 * Last update: 05/31/2025
 */

/**
 * Path of the mysqldump utility.
 * For example on Windows: 'C:\\mysql\\bin\\mysqldump.exe'
 * For example on Linux: '/mysql/bin/mysqldump'
 * @return string The absolute path.
 */
define('MOD_Z4M_APPDOWNLOAD_MYSQLDUMP_PATH', 'mysqldump');

/**
 * Color scheme applied to the DB Export view.
 * @var array|NULL Colors used to display the DB Export view. The expected array
 * keys is 'btn_action'.
 * If NULL, default color CSS classes are applied.
 */
define('MOD_Z4M_APPDOWNLOAD_COLOR_SCHEME', NULL);

/**
 * Module version number
 * @return string Version
 */
define('MOD_Z4M_APPDOWNLOAD_VERSION_NUMBER','1.0');
/**
 * Module version date
 * @return string Date in W3C format
 */
define('MOD_Z4M_APPDOWNLOAD_VERSION_DATE','2025-05-31');