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
 * Last update: 05/29/2025
 */
$color = [
    'btn_action' => 'w3-theme-action'
];
if (is_array(MOD_Z4M_APPDOWNLOAD_COLOR_SCHEME)) {
    $color = MOD_Z4M_APPDOWNLOAD_COLOR_SCHEME;
} elseif (defined('CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME')) {
    $color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
}
$dataButtonDisabled = !z4m_appdownload\mod\AppDataArchive::isDatabaseConfigured() ? ' disabled' : '';
$docsButtonDisabled = !z4m_appdownload\mod\AppDocsArchive::doesDocumentsSubFolderExists() ? ' disabled' : '';
?>
<div id="z4m-app-download-buttons" class="w3-content w3-margin-top" data-url="<?php echo General::getURIforDownload('Z4MAppDownloadCtrl'); ?>">
    <p><?php echo MOD_Z4M_APPDOWNLOAD_INTRO_TEXT; ?></p>
    <button class="w3-button w3-mobile w3-margin-top <?php echo $color['btn_action']; ?>" type="button" data-file="code">
        <i class="fa fa-download"></i>
        <?php echo MOD_Z4M_APPDOWNLOAD_SOFTWARE_CODE_BUTTON_LABEL; ?>
    </button>
    <button class="w3-button w3-mobile w3-margin-top <?php echo $color['btn_action']; ?>" type="button" data-file="data"<?php echo $dataButtonDisabled; ?>>
        <i class="fa fa-download"></i>
        <?php echo MOD_Z4M_APPDOWNLOAD_DATA_BUTTON_LABEL; ?>
    </button>
    <button class="w3-button w3-mobile w3-margin-top <?php echo $color['btn_action']; ?>" type="button" data-file="documents"<?php echo $docsButtonDisabled; ?>>
        <i class="fa fa-download"></i>
        <?php echo MOD_Z4M_APPDOWNLOAD_DOCUMENTS_BUTTON_LABEL; ?>
    </button>
    <div class="w3-section w3-padding-16">
        <a class="show-instructions" href="#"><?php echo MOD_Z4M_APPDOWNLOAD_SEE_PROCEDURE; ?></a>
        <div class="instructions-container"></div>
    </div>
</div>
<script>
(function(){
    const url = $('#z4m-app-download-buttons').data('url');
    $('#z4m-app-download-buttons').on('click', 'button', function(){
        const allowedFileTypes = ['code', 'data', 'documents'],
            fileType = $(this).data('file');
        if (allowedFileTypes.indexOf(fileType) > -1) {
            z4m.file.display(url + '&file_type=' + fileType);
        }
    });
    $('#z4m-app-download-buttons a.show-instructions').on('click', function(event){
        event.preventDefault();
        z4m.ajax.loadView('z4m_appdownload_instructions', $('#z4m-app-download-buttons .instructions-container'), function(){
            $('#z4m-app-download-buttons a.show-instructions').addClass('w3-hide');
        });
    });
})();
</script>