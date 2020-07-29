@if(!is_array($lesson))
@component('laravel-attachment::components.dropzone', [
            'name' => 'lesson_media',
            'label' => 'Прикрепленне файлы',
            'hint' => 'Allowed extensions (pdf) | Accept 10 files | Max. file size 2MB',
            'removeable' => true,
            'extensions' => '.jpeg,.jpg,.png,.gif,.svg,.bmp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.mp4,.ppt,.pptx,.dwg',
            'maxFiles' => 10,
            'maxFileSize' => 2800,
            'attachments' => isset($lesson) ? ($lesson->attachments()->exists() ? $lesson->attachments : []) : [],
            'attachable_type' => 'lesson',
            'attachable_id' => isset($lesson) ? $lesson->id : '',
            'file_attachment' => 'lesson_media'
        ])
@endcomponent
@else
@component('laravel-attachment::components.dropzone', [
            'name' => 'lesson_media',
            'label' => 'Прикрепленне файлы',
            'hint' => 'Allowed extensions (pdf) | Accept 10 files | Max. file size 2MB',
            'removeable' => true,
            'extensions' => '.jpeg,.jpg,.png,.gif,.svg,.bmp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.mp4,.ppt,.pptx,.dwg',
            'maxFiles' => 10,
            'maxFileSize' => 2800,
            'attachments' =>  [],
            'attachable_type' => 'lesson',
            'attachable_id' => $count+1,
            'file_attachment' => 'lesson_media'
        ])
@endcomponent
@endif
