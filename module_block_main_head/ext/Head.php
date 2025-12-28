<?php

/**
 * @author Project Pulse Team
 */

namespace app\modules\module_block_main_head\ext;

class Head
{
    public $Db;
    public $General;
    public $Translate;
    public $Modules;
    public $Router;
    public $Notifications;


    public function __construct($Db, $General, $Translate, $Modules, $Router, $Notifications)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Router = $Router;
        $this->Notifications = $Notifications;
    }

    public function getBanners()
    {
        return empty($this->Modules->get_settings_modules('module_block_main_head', 'settings')) ? [] : $this->Modules->get_settings_modules('module_block_main_head', 'settings');
    }

    public function addBanner(array $post)
    {
        $fields = [
            'url',
            'title',
            'description',
            'color_text',
            'color_bg_start',
            'color_bg_end'
        ];

        if (!$this->General->validatePOST($fields)) {
            return ['status' => 'error', 'text' => 'Not all data is filled in'];
        }

        $uploadPath = MODULES . 'module_block_main_head/assets/img/';
        $maxSize = 2 * 1024 * 1024;
        $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        $filePathForDB = 'null-image.svg';

        $file = $_FILES['file'] ?? null;

        if ($file && is_uploaded_file($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
            $mime = mime_content_type($file['tmp_name']);
            if ($file['size'] <= $maxSize && in_array($mime, $allowedMime, true)) {
                if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);
                $filePathForDB = $file['name'];
                if (!file_exists($uploadPath . $filePathForDB)) {
                    if (!move_uploaded_file($file['tmp_name'], $uploadPath . $filePathForDB)) {
                        return ['status' => 'error', 'text' => 'Error saving file'];
                    }
                }
            }
        } elseif (!empty($file)) {
            return ['status' => 'error', 'text' => 'Invalid file format or size'];
        }

        $banners = $this->getBanners();
        $nextId = !empty($banners) ? max(array_column($banners, 'id')) + 1 : 1;
        $nextSort = !empty($banners) ? max(array_column($banners, 'sort')) + 1 : 1;

        $banners[] = [
            'id' => $nextId,
            'sort' => $nextSort,
            'url' => $post['url'],
            'title' => $post['title'],
            'description' => $post['description'],
            'color_text' => $post['color_text'],
            'color_bg_start' => $post['color_bg_start'],
            'color_bg_end' => $post['color_bg_end'],
            'file' => $filePathForDB,
        ];

        $this->Modules->put_settings_modules('module_block_main_head', 'settings', $banners);

        return ['status' => 'success', 'text' => 'Successfully added'];
    }

    public function updateBanner($id, array $post)
    {
        $banners = $this->getBanners();
        $index = array_search($id, array_column($banners, 'id'));
        if ($index === false) {
            return ['status' => 'error', 'text' => 'Not found'];
        }

        $file = $_FILES['file'] ?? null;

        $uploadPath = MODULES . 'module_block_main_head/assets/img/';
        $maxSize = 2 * 1024 * 1024;
        $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        $filePathForDB = $banners[$index]['file'];

        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            if (is_uploaded_file($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
                $mime = mime_content_type($file['tmp_name']);
                if ($file['size'] <= $maxSize && in_array($mime, $allowedMime, true)) {
                    if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);
                    if (!file_exists($uploadPath . $file['name'])) {
                        if (move_uploaded_file($file['tmp_name'], $uploadPath . $file['name'])) {
                            $filePathForDB = $file['name'];
                        }
                    } else {
                        $filePathForDB = $file['name'];
                    }
                } else {
                    return ['status' => 'error', 'text' => 'Invalid file format or size'];
                }
            } else {
                return ['status' => 'error', 'text' => 'Error saving file'];
            }
        }

        $banners[$index] = array_merge($banners[$index], [
            'url' => $post['url'] ?? '',
            'title' => $post['title'] ?? '',
            'description' => $post['description'] ?? '',
            'color_text' => $post['color_text'] ?? '',
            'color_bg_start' => $post['color_bg_start'] ?? '',
            'color_bg_end' => $post['color_bg_end'] ?? '',
            'file' => $filePathForDB,
        ]);

        $this->Modules->put_settings_modules('module_block_main_head', 'settings', $banners);

        return ['status' => 'success', 'text' => 'Successfully updated'];
    }

    public function deleteBanner(int $id)
    {
        $banners = $this->getBanners();
        $banners = array_filter($banners, fn($b) => $b['id'] !== $id);
        $banners = array_values($banners);
        $this->Modules->put_settings_modules('module_block_main_head', 'settings', $banners);
        return ['status' => 'success', 'text' => 'Successfully deleted'];
    }

    public function sortBanners(array $sortedIds)
    {
        $banners = $this->getBanners();
        $indexed = [];

        foreach ($banners as $banner) {
            $indexed[$banner['id']] = $banner;
        }

        $sorted = [];
        $sort = 1;

        foreach ($sortedIds as $id) {
            if (isset($indexed[$id])) {
                $banner = $indexed[$id];
                $banner['sort'] = $sort++;
                $sorted[] = $banner;
            }
        }
        $this->Modules->put_settings_modules('module_block_main_head', 'settings', $sorted);
        return ['status' => 'success', 'text' => 'Successfully sorted'];
    }
}