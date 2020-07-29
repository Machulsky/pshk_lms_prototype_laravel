
@component('laravel-attachment::components.dropzone', [
            'name' => 'task_media',
            'label' => 'Прикрепленне файлы',
            'hint' => 'Allowed extensions (pdf) | Accept 10 files | Max. file size 2MB',
            'removeable' => true,
            'extensions' => '.jpeg,.jpg,.png,.gif,.svg,.bmp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.mp4,.ppt,.pptx,.dwg',
            'maxFiles' => 10,
            'maxFileSize' => 2800,
            'attachments' => isset($task) ? ($task->attachments()->exists() ? $task->attachments : []) : [],
            'attachable_type' => 'task',
            'attachable_id' => isset($task) ? $task->id : '',
            'file_attachment' => 'task_media'
        ])
@endcomponent