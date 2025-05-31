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
 * ZnetDK 4 Mobile APP Download module JS view
 * 
 * File version: 1.0
 * Last update: 05/30/2025
 */
?>
<h2>Application Transfer Procedure</h2>
<ol>
    <li>Download the application's software code, data, and documents by clicking the three buttons above.</li>
    <li>Using file transfer software (Filezilla, etc.), upload the ZIP archives containing the software code, data, and documents to the new web hosting site where the application will be installed.</li>
    <li>Extract the contents of the archive containing the software code into the appropriate web publishing folder.<br>
        For example, using the Linux SSH command line:<br>
        <code class="w3-tag w3-light-grey">unzip -d /var/www/myapp/ code_20250530_221516.zip</code>
    </li>
    <li>Extract the contents of the archive containing the documents into the <code class="w3-tag w3-light-grey">applications/default/</code> subfolder.<br>
        For example, using the Linux SSH command line:<br>
        <code class="w3-tag w3-light-grey">unzip -d /var/www/myapp/ documents_20250530_221516.zip</code>
    </li>
    <li>Load the application data into the new web hosting database after extracting it from the ZIP archive.<br>
        For example, using the Linux SSH command line:<br>
        <code class="w3-tag w3-light-grey">unzip -d /temp/ data_20250530_221516.zip</code><br>
        <code class="w3-tag w3-light-grey">mysql --user=mydbaccount --password=mydbpassword --database=mynewdbname < /temp/mydbname_database.sql</code>
    </li>
    <li>Edit the <code class="w3-tag w3-light-grey">applications/default/app/config.php</code> script and modify the connection parameters to the new web hosting database.<br>
        The PHP constants to customize are <code class="w3-tag w3-light-grey">CFG_SQL_HOST</code>, <code class="w3-tag w3-light-grey">CFG_SQL_PORT</code>, <code class="w3-tag w3-light-grey">CFG_SQL_APPL_DB</code>, <code class="w3-tag w3-light-grey">CFG_SQL_APPL_USR</code> and <code class="w3-tag w3-light-grey">CFG_SQL_APPL_PWD</code>.
    </li>
    <li>From a web browser, enter in the address bar the URL to access the application on the new web hosting.</li>
    <li>Check that the <code class="w3-tag w3-light-grey">.htaccess</code> file has been generated in the application's root installation directory.</li>
    <li>Delete the original <code class="w3-tag w3-light-grey">htaccess_copy</code> file if its contents have not been customized for the application's specific needs.<br>
        For example, using the Linux SSH command line:<br>
        <code class="w3-tag w3-light-grey">rm -i /var/www/myapp/htaccess_copy</code>
    </li>
</ol>
