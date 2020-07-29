<?php

namespace App\FileAttachments;

use Yoelpc4\LaravelAttachment\Contracts\FileAttachment;
use Yoelpc4\LaravelAttachment\Utils\AttachmentFilesystem;

class AnswerMediaAttachment implements FileAttachment
{
    use AttachmentFilesystem;

    /**
     * Get name
     *
     * @return string
     */
    public static function getName()
    {
        return 'answer_media';
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
            'file', 'max:100596', 'mimes:jpeg,jpg,png,gif,svg,bmp,pdf,doc,docx,xls,xlsx,txt,mp4,ppt,pptx,dwg'
        ];
    }
}
