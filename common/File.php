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

    protected static function getFile(string $name) : array
    {
        $part_of_an_array = strpos($name, '.') > 0;
        $names_array = $part_of_an_array ? explode('.', $name) : [];

        if ($part_of_an_array) {
            $first_name = $names_array[0];
            $second_name = $names_array[1];

            return [
                'name' => $_FILES[$first_name]['name'][$second_name],
                'type' => $_FILES[$first_name]['type'][$second_name],
                'tmp_name' => $_FILES[$first_name]['tmp_name'][$second_name],
                'error' => $_FILES[$first_name]['error'][$second_name],
                'size' => $_FILES[$first_name]['size'][$second_name],
            ];
        }

        return isset($_FILES[$name]) ? $_FILES[$name] : [];
    }

    // TODO: Throw erors if the file upload is not successful
    public static function storeImage(string $name, string $destination = '', bool $generate_file_name = true) : string
    {
        // Build the $file variable if the file is part of an array
        $file = self::getFile($name);

        // Check if the file exists
        if (sizeof($file) === 0) {
            return '';
        }

        // Check if the file is an image
        if (strpos($file['type'], 'image') !== 0) {
            return '';
        }

        $destination = $destination === '' ? static::$image_destination : $destination;
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
