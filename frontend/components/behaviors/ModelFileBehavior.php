<?php


namespace frontend\components\behaviors;


use yii\helpers\FileHelper;

class ModelFileBehavior extends \yii\base\Behavior
{
    /**
     * @var string директория, в которой будут храниться удаленные файлы
     * @example  '@frontend/web/uploads/deleted'
     */
    public $trashFolder = '@frontend/web/uploads/deleted';
    /**
     * Массив вида
     * [
     *      'file_attribute' => [
     *              'frontend/web/uploads/folder_contains_file',
     *              'frontend/web/uploads/another_folder_contains_file'
     *      ],
     *      // можно указать несколько путей к файлу, например если есть превью картинок
     *      //
     * ]
     * @var array
     */
    public $filesList = [];

    /**
     * Удаление файла в "корзину"
     * @param $filePath
     * @return bool
     */
    private function softDelete($filePath, $name)
    {
        $trashFolderFullPath = \yii::getAlias($this->trashFolder);
        $fullPath = \yii::getAlias("@{$filePath}/{$name}");
        $newFolderPath = $trashFolderFullPath . "/{$filePath}";
        if (is_dir($newFolderPath) === false) {
            if (mkdir("{$newFolderPath}/", 0777, true) === false) {
                throw new \Exception('Не удалось создать директорию в корзине');
            }
        }
        if (file_exists($fullPath) === true) {
            return rename($fullPath, $newFolderPath . "/{$name}");
        }

        return true;
    }

    /**
     * @param $path
     * @return bool
     */
    private function hardDelete($path)
    {
        return unlink($path);
    }


    /**
     * @param $fileName
     */
    public function softDeleteFile($fileAttribute)
    {
        $this->checkSettings();

        if (isset($this->filesList[$fileAttribute])) {
            foreach ($this->filesList[$fileAttribute] as $index => $filePath) {
                    $fileName = $this->owner->$fileAttribute;
                    if ($this->trashFolder !== null) {
                        if ($this->softDelete($filePath, $fileName) === false) {
                            $this->owner->addError($fileAttribute, "Не удалось удалить файл {$fileName}");
                        }
                    } else {
                        $fullPath = \yii::getAlias("@{$filePath}/{$fileName}");
                        $this->hardDelete($fullPath);
                    }
                }
        }
//        foreach ($this->filesList as $currentFileName => $filePaths) {
//            if ($currentFileName == $this->owner->$fileAttribute) {
//                foreach ($filePaths as $index => $filePath) {
//                    if ($this->trashFolder !== null) {
//                        $this->softDelete();
//                    } else {
//                        $this->hardDelete();
//                    }
//                }
//
//            }
//        }
    }

    /**
     * Проверяет правльность настроек поведения
     * @throws \Exception
     */
    private function checkSettings()
    {
        if ($this->filesList === []) {
            throw new \Exception("Поведение настроено неверно: параметр 'Список файлов' пуст.");
        }

        foreach ($this->filesList as $index => $item) {
            if (!is_array($item)) {
                throw new \Exception('Поведение настроено неверно: параметр "Пути к файлу" должен быть массивом. ');
            }
        }

//        if ($this->trashFolder === null) {
//            throw new \Exception('Поведение настроено неверно: необходимо указать путь к "корзине".');
//        }
    }
}