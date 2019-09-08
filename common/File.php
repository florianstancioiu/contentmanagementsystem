<?php

namespace Common;

// TODO: Implement file storage class
class File
{
    protected static $image_destination = 'images';

    protected static $default_image_type = 'png';

    protected static $allowed_image_types = [
        'jpg',
        'jpeg',
        'png',
        'gif',
    ];

    public static function storeImage(string $name, string $destination = '', bool $generate_file_name = true) : string
    {
        $file = $_FILES[$name];

        // make sure the file exists
        if (! is_array($file)) {
            return '';
        }

        // make sure the file is an image
        if (strpos($file['type'], 'image') !== 0) {
            return '';
        }

        $destination = $destination === '' ? static::$image_destination : '';
        $temp_file_name = $file['tmp_name'];
        $file_name = basename($file['name']);
        $error = $file['error'];
        $storage_destination = STORAGE_PATH . DS . $destination;

        if (! file_exists($storage_destination)) {
            mkdir($storage_destination);
        }

        if ($generate_file_name) {
            $file_name = password_hash($file_name, PASSWORD_BCRYPT);
        }

        if (UPLOAD_ERR_OK != $error) {
            return '';
        }

        $file_name = substr(str_slug($file_name), 0, 40);
        $file_extension = self::getImageExtension($file);
        // the storage destination for database usage
        $storage_location = "$destination/$file_name.$file_extension";
        // the full filesystem location for upload
        $file_location = "$storage_destination/$file_name.$file_extension";

        if (move_uploaded_file($temp_file_name, $file_location)) {
            return $storage_location;
        }

        return '';
    }

    public static function getImageExtension(array $file) : string
    {
        $file_type = $file['type'];
        $default_type = self::$default_image_type;

        // make sure the file is an image
        if (strpos($file_type, 'image') !== 0) {
            return $default_type;
        }

        $type = explode($file_type, '/');

        return isset($type[1]) ? strtolower($type[1]) : $default_type;
    }
}
