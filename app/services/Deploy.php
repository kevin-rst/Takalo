<?php

namespace app\services;

class Deploy
{
    public static function upload($file)
    {
        $uploadDir =  __DIR__ . '/../../public/images/';
        $maxSize = 50 * 1024 * 1024;
        $allowedMimeTypes = ['image/jpeg', 'image/webp', 'image/jpg', 'image/png', 'image/img'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            die('Erreur lors de l’upload : ' . $file['error']);
        }

        if ($file['size'] > $maxSize) {
            die('Le fichier est trop volumineux.');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedMimeTypes)) {
            die('Type de fichier non autorisé : ' . $mime);
        }

        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = $originalName . '_' . uniqid() . '.' . $extension;

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
            die('Erreur lors du déplacement du fichier');
        }

        return $newName;
    }
}
