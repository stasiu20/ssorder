<?php

namespace common\validators;

use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use yii\validators\FileValidator;

/**
 * Yii2 has not yet published solution for bug #19243
 *
 * This is workaround for PHP 8.1
 *
 * @link https://github.com/yiisoft/yii2/commit/7b8c29d87468bb2a8270768df90c62abed1c1d37
 */
class FilePHP81Validator extends FileValidator
{
    protected function validateExtension($file)
    {
        $extension = mb_strtolower($file->extension, 'UTF-8');

        if ($this->checkExtensionByMimeType) {
            $mimeType = self::getMimeType($file->tempName, null, false);
            if ($mimeType === null) {
                return false;
            }

            $extensionsByMimeType = FileHelper::getExtensionsByMimeType($mimeType);

            if (!in_array($extension, $extensionsByMimeType, true)) {
                return false;
            }
        }

        if (!empty($this->extensions)) {
            foreach ((array) $this->extensions as $ext) {
                if ($extension === $ext || StringHelper::endsWith($file->name, ".$ext", false)) {
                    return true;
                }
            }
            return false;
        }

        return true;
    }

    /**
     * Determines the MIME type of the specified file.
     * This method will first try to determine the MIME type based on
     * [finfo_open](https://www.php.net/manual/en/function.finfo-open.php). If the `fileinfo` extension is not installed,
     * it will fall back to [[getMimeTypeByExtension()]] when `$checkExtension` is true.
     * @param string $file the file name.
     * @return string|null the MIME type (e.g. `text/plain`). Null is returned if the MIME type cannot be determined.
     * @throws InvalidConfigException when the `fileinfo` PHP extension is not installed.
     */
    public static function getMimeType($file)
    {
        $info = finfo_open(FILEINFO_MIME_TYPE);

        if ($info) {
            $result = finfo_file($info, $file);
            finfo_close($info);

            if ($result !== false) {
                return $result;
            }
        }

        return FileHelper::getMimeTypeByExtension($file);
    }
}
