
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = require('axios');

// set dropzone globally
window.Dropzone = require('dropzone');

// disable dropzone auto discover to prevent it from declared twice
Dropzone.autoDiscover = false;
Dropzone.prototype.defaultOptions.dictDefaultMessage
//  = "Drop files here to upload";
  = "Перетащите файлы для загрузки в это поле";
Dropzone.prototype.defaultOptions.dictFallbackMessage
//  = "Your browser does not support drag'n'drop file uploads.";
  = "К сожалению, ваш браузер не поддерживает Drag'n'Drop";
Dropzone.prototype.defaultOptions.dictFallbackText
//  = "Please use the fallback form below to upload your files like in the olden days.";
  = "Пожалуйста, воспользуйтесь старой доброй формой для загрузки";
Dropzone.prototype.defaultOptions.dictFileTooBig
//  = "File is too big ({{filesize}}MB). Max filesize: {{maxFilesize}}MB.";
  = "Файл слишком большой({{filesize}}MB). Максимальный допустимый размер файла {{maxFilesize}}MB";
Dropzone.prototype.defaultOptions.dictInvalidFileType
//  = "You can't upload files of this type.";
  = "Вы не можете загружать файлы этого типа.";
Dropzone.prototype.defaultOptions.dictResponseError
//  = "Server responded with {{statusCode}} code.";
  = "Произошла ошибка при загрузке файла. Попробуйте еще раз. Если ошибка будет повторяться - передайте эту информацию администратору сайта: Код ошибки {{statusCode}}";
Dropzone.prototype.defaultOptions.dictCancelUpload
//  = "Cancel upload";
  = "Отменить загрузку";
Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation
//  = "Are you sure you want to cancel this upload?";
  = "Уверены, что хотите прервать загрузку?";
Dropzone.prototype.defaultOptions.dictRemoveFile
//  = "Remove file";
  = "Удалить файл";
Dropzone.prototype.defaultOptions.dictRemoveFileConfirmation
//  = null;
  = null;
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded
//  = "You can only upload {{maxFiles}} files.";
= "Превышен лимит количества файлов. Вы можете загрузить не более {{maxFiles}} ";

// init tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

// set attachment manager globally
window.attachmentManager = {
    bindOpenInNewTab(file, url) {
        // unbind default click handler
        $(file.previewElement).unbind('click');

        // on thumbnail click create url from file
        $(file.previewElement).on('click', function () {
            window.open(url, '_blank');
        });
    },
    getIcon(file) {
        // get the last word after dot
        let ext = file.name.split('.').pop().toLowerCase();

        let icon = 'txt';

        if (ext === 'docx' || ext === 'doc') {
            icon = 'doc';
        } else if (ext === 'xlsx' || ext === 'xls') {
            icon = 'xls';
        } else if (ext === 'pdf') {
            icon = 'pdf';
        } else if (ext === 'csv') {
            icon = 'csv';
        }

        return `/storage/images/icons/${icon}.svg`;
    },
    update(dropzone, uploadedFiles, uploadInputs) {
        uploadedFiles.content.forEach(attachment => {
            // define the mock file
            const mockFile = {
                id: attachment.id,
                name: attachment.name,
                size: attachment.size,
                type: attachment.type,
                dataURL: attachment.url || attachment.dataURL,
                accepted: true
            };

            // trigger addedfile event by mock file
            dropzone.emit('addedfile', mockFile);

            // determine whether file is image
            if (mockFile.type.match(/image*/)) {
                // download image then resize it to create the thumbnail
                dropzone.createThumbnailFromUrl(
                    mockFile,
                    dropzone.options.thumbnailWidth,
                    dropzone.options.thumbnailHeight,
                    dropzone.options.thumbnailMethod,
                    true,
                    thumbnail => dropzone.emit('thumbnail', mockFile, thumbnail)
                );
            } else {
                // get icon to create the thumbnail
                dropzone.emit('thumbnail', mockFile, this.getIcon(mockFile));
            }

            // trigger complete event by mock file
            dropzone.emit('complete', mockFile);

            // this line needed to ensure max files exceeded event is working
            dropzone.files.push(mockFile);

            // create a new input hidden with value is mock file's id
            uploadInputs.create(mockFile.id);

            this.bindOpenInNewTab(mockFile, mockFile.dataURL);
        });
    }
};

//Dropzone.autoDiscover = false;
// document.onload = function(){
//     CKEDITOR.replace( 'description' )
// }


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
