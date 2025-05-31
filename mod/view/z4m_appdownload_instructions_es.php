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
<h2>Procedimiento de transferencia de la aplicación</h2>
<ol>
    <li>Descargue el código de software, los datos y los documentos de la aplicación haciendo clic en los tres botones de arriba.</li>
    <li>Con un software de transferencia de archivos (Filezilla, etc.), sube los archivos ZIP que contienen el código de software, los datos y los documentos al nuevo hosting donde se instalará la aplicación.</li>
    <li>Extraiga el contenido del archivo que contiene el código de software en la carpeta de publicación web correspondiente.<br>
        Por ejemplo, usando la línea de comandos SSH de Linux:<br>
        <code class="w3-tag w3-light-grey">unzip -d /var/www/myapp/ code_20250530_221516.zip</code>
    </li>
    <li>Extraiga el contenido del archivo que contiene los documentos en la subcarpeta <code class="w3-tag w3-light-grey">applications/default/</code>.<br>
        Por ejemplo, usando la línea de comandos SSH de Linux:<br>
        <code class="w3-tag w3-light-grey">unzip -d /var/www/myapp/ documents_20250530_221516.zip</code>
    </li>
    <li>Cargue los datos de la aplicación en la base de datos del nuevo hosting después de extraerlos del archivo ZIP.<br>
        Por ejemplo, usando la línea de comandos SSH de Linux:<br>
        <code class="w3-tag w3-light-grey">unzip -d /temp/ data_20250530_221516.zip</code><br>
        <code class="w3-tag w3-light-grey">mysql --user=mydbaccount --password=mydbpassword --database=mynewdbname < /temp/mydbname_database.sql</code>
    </li>
    <li>Edite el script <code class="w3-tag w3-light-grey">applications/default/app/config.php</code> y modifique los parámetros de conexión a la base de datos del nuevo hosting web.<br>
        Las constantes PHP que se deben personalizar son <code class="w3-tag w3-light-grey">CFG_SQL_HOST</code>, <code class="w3-tag w3-light-grey">CFG_SQL_PORT</code>, <code class="w3-tag w3-light-grey">CFG_SQL_APPL_DB</code>, <code class="w3-tag w3-light-grey">CFG_SQL_APPL_USR</code> y <code class="w3-tag w3-light-grey">CFG_SQL_APPL_PWD</code>.
    </li>
    <li>Desde un navegador web, introduzca en la barra de direcciones la URL para acceder a la aplicación en el nuevo hosting.</li>
    <li>Verifique que el archivo <code class="w3-tag w3-light-grey">.htaccess</code> se haya generado en el directorio raíz de instalación de la aplicación.</li>
    <li>Elimine el archivo original <code class="w3-tag w3-light-grey">htaccess_copy</code> si su contenido no se ha adaptado a las necesidades específicas de la aplicación.<br>
        Por ejemplo, usando la línea de comandos SSH de Linux:<br>
        <code class="w3-tag w3-light-grey">rm -i /var/www/myapp/htaccess_copy</code>
    </li>
</ol>
