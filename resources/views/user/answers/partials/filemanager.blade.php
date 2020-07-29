
@component('laravel-attachment::components.dropzone', [
            'name' => 'answer_media',
            'label' => 'Прикрепленне файлы',
            'hint' => 'Allowed extensions (pdf) | Accept 10 files | Max. file size 2MB',
            'removeable' => true,
            'extensions' => '.jpeg,.jpg,.png,.gif,.svg,.bmp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.mp4,.ppt,.pptx,.dwg',
            'maxFiles' => $task->answerType->max_files,
            'maxFileSize' => 2800,
            'attachments' => isset($myAnswer) ? ($myAnswer->attachments()->exists() ? $myAnswer->attachments : []) : [],
            'attachable_type' => 'answer',
            'attachable_id' => isset($myAnswer) ? $myAnswer->id : '',
            'file_attachment' => 'answer_media'
        ])
@endcomponent

