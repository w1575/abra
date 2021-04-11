<?php


namespace common\components\behaviors\ImageUploaderBehavior;


final class FileParamsValidatorFactory
{
    /**
     * Создает новый экземпляр класса и присваивает переданные атрибуты
     * @param $attributes
     * @return FileParamsValidator
     */
    public static function build($attributes)
    {
        $model = new FileParamsValidator();
        $model->load($attributes);
        return $model;
    }
}