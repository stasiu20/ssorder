<?php

namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class VaadinUpload extends Widget
{
    /**
     * The server URL.
     *
     * The default value is an empty string, which means that window.location will be used.
     *
     * @var string
     */
    public $target;

    /**
     * Specifies the types of files that the server accepts.
     *
     * Syntax: a comma-separated list of MIME type patterns (wildcards are
     * allowed) or file extensions. Notice that MIME types are widely supported,
     * while file extensions are only implemented in certain browsers, so avoid
     * using it. Example: accept="video/*,image/tiff" or
     * accept=".pdf,audio/mp3"
     * @var string
     */
    public $accept;

    /**
     * Limit of files to upload, by default it is unlimited.
     *
     * If the value is set to one, native file browser will prevent selecting multiple files.
     *
     * @var int
     */
    public $maxFiles;

    /**
     * Specifies the 'name' property at Content-Disposition
     *
     * @var string
     */
    public $formDataName;

    public function run()
    {
        $options = [
            'target' => $this->target,
            'accept' => $this->accept,
            'max-files' => $this->maxFiles,
            'form-data-name' => $this->formDataName,
        ];
        return Html::tag('vaadin-upload', '', $options);
    }
}
