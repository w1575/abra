<?php


namespace frontend\components\behaviors;


class ModelFileBehavior extends \yii\base\Behavior
{
    /**
     * @var string директория, в которой будут храниться удаленные файлы
     * @example  '@frontend/web/uploads/deleted'
     */
    public $trashFolder;
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
     * @param $fileName
     */
    public function softDeleteFile($fileAttribute)
    {
        $this->checkSettings();

        foreach ($this->filesList as $currentFileName => $filePath) {
            if ($currentFileName == $fileAttribute) {

            }
        }
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

        if ($this->trashFolder === null) {
            throw new \Exception('Поведение настроено неверно: необходимо указать путь к "корзине".');
        }
    }
}