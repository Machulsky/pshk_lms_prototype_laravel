<?php

namespace App\FileAttachments;

use Yoelpc4\LaravelAttachment\Contracts\FileAttachment;
use Yoelpc4\LaravelAttachment\Utils\AttachmentFilesystem;

class CourseMediaAttachment implements FileAttachment
{
    use AttachmentFilesystem;

    /**
     * Get name
     *
     * @return string
     */
    public static function getName()
    {
        //
    }

    /**
     * Get validation rules
     *
     * @return string|array
     */
    public function getValidationRules()
    {
        return [
            'file', 'max:2048', 'mimes:jpeg,jpg,png,gif,svg,bmp,pdf,doc,docx,xls,xlsx,txt,mp4'
        ];
    }
}
