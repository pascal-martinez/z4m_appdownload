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
<h2>Procédure de transfert de l'application</h2>
<ol>
    <li>Télécharger le code logiciel, les données et les documents de l'application en cliquant sur les 3 boutons ci-dessus.</li>
    <li>A l'aide d'un logiciel de transfert de fichiers (Filezilla, ...), charger les archives ZIP du code logiciel, des données et des documents sur le nouvel hébergement internet où doit être installée l'application.</li>
    <li>Extraire le contenu de l'archive contenant le code logiciel dans le dossier de publication web qui convient.<br>
        Par exemple en ligne de commande SSH Linux :<br>
        <code class="w3-tag w3-light-grey">unzip -d /var/www/myapp/ code_20250530_221516.zip</code>
    </li>
    <li>Extraire le contenu de l'archive contenant les documents dans le sous-dossier <code class="w3-tag w3-light-grey">applications/default/</code>.<br>
        Par exemple en ligne de commande SSH Linux :<br>
        <code class="w3-tag w3-light-grey">unzip -d /var/www/myapp/ documents_20250530_221516.zip</code>
    </li>
    <li>Charger les données de l'application dans la base de données du nouvel hébergement internet après les avoir extraites de l'archive ZIP.<br>
        Par exemple en ligne de commande SSH Linux :<br>
        <code class="w3-tag w3-light-grey">unzip -d /temp/ data_20250530_221516.zip</code><br>
        <code class="w3-tag w3-light-grey">mysql --user=mydbaccount --password=mydbpassword --database=mynewdbname < /temp/mydbname_database.sql</code>
    </li>
    <li>Editer le script <code class="w3-tag w3-light-grey">applications/default/app/config.php</code> et modifier les paramètres de connexion à la base de données du nouvel hebérgement internet.<br>
        Les constantes PHP à personnaliser sont <code class="w3-tag w3-light-grey">CFG_SQL_HOST</code>, <code class="w3-tag w3-light-grey">CFG_SQL_PORT</code>, <code class="w3-tag w3-light-grey">CFG_SQL_APPL_DB</code>, <code class="w3-tag w3-light-grey">CFG_SQL_APPL_USR</code> et <code class="w3-tag w3-light-grey">CFG_SQL_APPL_PWD</code>.
    </li>
    <li>Depuis un navigateur internet, saisir dans la barre d'adresse l'URL d'accès à l'application sur le nouvel hébergement internet.</li>
    <li>Vérifier que le fichier <code class="w3-tag w3-light-grey">.htaccess</code> a bien été généré dans le répertoire racine d'installation de l'application.</li>
    <li>Supprimer alors la copie originale <code class="w3-tag w3-light-grey">htaccess_copy</code> si son contenu n'a pas été personnalisé pour des besoins spécifiques de l'application.<br>
        Par exemple en ligne de commande SSH Linux :<br>
        <code class="w3-tag w3-light-grey">rm -i /var/www/myapp/htaccess_copy</code>
    </li>
</ol>

