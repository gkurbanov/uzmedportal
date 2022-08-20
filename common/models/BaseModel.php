<?php


namespace common\models;


use Intervention\Image\ImageManager;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;

class BaseModel extends Model
{

    public $file;

    PUBLIC CONST HIGH_IMAGE_QUALITY = 90;

    /**
     * Function debug
     *
     * @property array $data
     */
    public static function debug($data)
    {
        echo '<pre>' . var_export($data, true) . '</pre>';
    }

    /**
     * Function to convert cyr to lat
     *
     * @property string $keyword
     */
    public static function convertToLatinLowerCase($convertWords)
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya'
        ];

        $convertedWords = str_replace($cyr, $lat, $convertWords);
        $lowerCaseWords = mb_strtolower($convertedWords, "UTF-8");
        $name = preg_replace('/\s+/', '-', $lowerCaseWords);

        return preg_replace('/[^A-Za-z0-9\-+~!@#$%&]/', '', $name);
    }

    public static function functionMessage($boolean)
    {
        if ($boolean == true) {
            return array(
                "code" => 1,
                "message" => "success"
            );
        } else {
            return array(
                "code" => 1,
                "message" => "error"
            );
        }
    }

    /**
     * Comment for upload Post Image function
     *
     * @property object $model
     * @property object $image_url
     * @property string $table_name
     * @property string $column_name
     * @property string $title
     */
    public static function uploadPostImage($model, $image_url, $table_name, $column_name, $title)
    {
        if ($image_url->name) {
            $path = Yii::getAlias('@backend') . "/web/media/{$table_name}/{$table_name}_{$model->id}/";
            FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

            //Image converter
            $manager = new ImageManager();
            $image = trim(self::convertToLatinLowerCase($title) . "_$column_name." . $image_url->extension);
            $image_url->saveAs($path . "/" . $image);

            $webPImage = trim(self::convertToLatinLowerCase($title) . "_$column_name.") . "webp";
            $manager->make($path . "/" . $image)
                ->save($path . "/" . $webPImage, self::HIGH_IMAGE_QUALITY);

            //Remove origin file
            unlink($path . "/" . $image);
            Yii::$app->db->createCommand()->update($table_name,
                [$column_name => $webPImage],
                ['id' => $model->id])->execute();
        }
    }

    //Function to remove images from publications
    public static function removeImage($table_name, $column, $record_id, $value)
    {
        if ($table_name && $column && $record_id) {
            $path = Yii::getAlias('@backend') . "/web/media/{$table_name}/{$table_name}_{$record_id}/{$value}";
            if (!empty($path)) {
                try {
                    unlink($path);
                    Yii::$app->db->createCommand()->update($table_name,
                        [$column => null],
                        ['id' => $record_id])->execute();
                    return true;
                } catch (\Exception $exception) {
                    return $exception;
                }
            }
            return false;
        } else {
            return false;
        }
    }
}