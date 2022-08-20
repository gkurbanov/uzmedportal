<?php

namespace api\modules\v1\controllers;

use common\models\Brand;
use common\models\Category;
use common\models\CategoryAttribute;
use common\models\CategoryAttributeRow;
use common\models\CategoryAttributeValue;
use common\models\CategoryCharacteristicRow;
use common\models\Color;
use common\models\DiscountBlock;
use common\models\enum\MerchantStatus;
use common\models\Feature;
use common\models\MainSetting;
use common\models\PageBlock;
use common\models\PhoneRamRom;
use common\models\Product;
use common\models\ProductCategoryAttributeValue;
use common\models\ProductStock;
use common\models\User;
use DateTime;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `Module` module
 */
class DefaultController extends ActiveController
{

    public const ONDA_URL = "https://onda.uz/";
    public const MAGAZINOFF_URL = "https://magazinoff.uz/";

    public const BASE_URL = "https://dev.onda.uz/";
    public $modelClass = MainSetting::class;
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Allow-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Max-Age' => 3600, // Cache (seconds)
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page']
                ],

            ],
        ];
    }

    public function actionGetVisitorAddress()
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        /*Get user ip address details with geoplugin.net*/
        $geopluginURL = 'http://www.geoplugin.net/php.gp?ip=' . $ip_address;
        $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
        /*Get City name by return array*/
        $city = $addrDetailsArr['geoplugin_city'];
        /*Get Country name by return array*/
        $country = $addrDetailsArr['geoplugin_countryName'];


        if (!$city) {
            $city = 'Not Define';
        }
        if (!$country) {
            $country = 'Not Define';
        }

        return array(
            "city" => $city,
            "country" => $country,
        );
    }

    //Search input
    public function actionSearchProduct()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isPost) {
            $search = $_POST["search_keyword"];


            $headers = Yii::$app->request->headers;
            $lang = $headers->get('Accept-Language');
            if ($search) {

                $productIds = array();
                $categoryIds = array();

                if (isset($_POST["category_id"])) {
                    $category_id = $_POST["category_id"];
                    if ($category_id) {
                        $category = Category::findOne($category_id);

                        $second_level_categories = Category::find()
                            ->where([
                                'parent_id' => $category->id,
                                'level' => 2,
                            ])
                            ->all();

                        foreach ($second_level_categories as $second_level_category) {
                            $third_level_categories = Category::find()->where([
                                'parent_id' => $second_level_category->id,
                                'level' => 3,
                            ])
                                ->all();

                            foreach ($third_level_categories as $third_level_category) {
                                array_push($categoryIds, $third_level_category->id);
                            }
                        }
                    }
                }


//            Get by product name
                $query = Product::find()
                    ->select(['id', 'category_id'])
                    ->where(['like', 'product_name_ru', $search]);
                if ($categoryIds) {
                    $query->andWhere(['category_id' => $categoryIds]);
                }
                $query->asArray()->all();


                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $products = $query->offset($pages->offset)->limit($pages->limit)->all();

                foreach ($products as $product) {
                    array_push($productIds, $product["id"]);
                }

                $query = ProductStock::find()
                    ->with([
                        'product' => function (Query $query) {
                            $query->select(['id', 'product_name_ru', 'product_name_uz', 'alias', 'category_id', 'brand_id']);
                        }
                    ])
                    ->with(['images'])
                    ->andWhere(['>=', 'product_qty', 1])
                    ->andWhere(['>=', 'product_price', 1])
                    ->andWhere(['in', 'product_id', $productIds])
                    ->asArray()
                    ->distinct()
                    ->orderBy(['id' => SORT_DESC])
                    ->groupBy(['product_id']);

                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 16, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $products = $query->offset($pages->offset)->limit($pages->limit)->all();

                $items = array();
                foreach ($products as $product) {
                    //                Product_name
                    $product_name = "";
                    if ($lang == "ru") {
                        $product_name = $product["product"]["product_name_ru"];
                    } else if ($lang == "uz") {
                        $product_name = $product["product"]["product_name_uz"];
                    }

                    //                Product image
                    $imageUrl = "";
                    if ($product["images"]) {
                        $imageUrl = $product["images"][0]["image_name"];
                    }

//                    Category
                    $category = Category::findOne($product["product"]["category_id"]);
                    $category_name = "";
                    if ($lang == "ru") {
                        $category_name = $category->category_title_ru;
                    } else if ($lang == "uz") {
                        $category_name = $category->category_title_uz ? $category->category_title_uz : $category->category_title_ru;
                    }

                    array_push(
                        $items,
                        array(
                            "id" => $product["product"]["id"],
                            "product_name" => $product_name,
                            "imageUrl" => $imageUrl,
                            "image_url" => self::BASE_URL . "backend/web/uploads/products/product_" . $product["product"]["id"] . "/gallery/" . $imageUrl,
                            "category" => array(
                                "id" => $product["product"]["category_id"],
                                "category_name" => $category_name,
                            ),

                        )
                    );
                }
                return $items;
            }

            return $search;
        } else {
            Yii::$app->response->statusCode = 400;
            return ["message" => "Incorrect request"];
        }
    }

    //Search page
    public function actionSearchPage($search_keyword = null, $category_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isGet) {
            $search = $search_keyword;

            $headers = Yii::$app->request->headers;
            $lang = $headers->get('Accept-Language');
            if ($search) {

                $productIds = array();
                $categoryIds = array();

                if (isset($category_id)) {
                    if ($category_id) {
                        $category = Category::findOne($category_id);

                        $second_level_categories = Category::find()
                            ->where([
                                'parent_id' => $category->id,
                                'level' => 2,
                            ])
                            ->all();

                        foreach ($second_level_categories as $second_level_category) {
                            $third_level_categories = Category::find()->where([
                                'parent_id' => $second_level_category->id,
                                'level' => 3,
                            ])
                                ->all();

                            foreach ($third_level_categories as $third_level_category) {
                                array_push($categoryIds, $third_level_category->id);
                            }
                        }
                    }
                }


//            Get by product name
                $query = Product::find()
                    ->select(['id', 'category_id'])
                    ->where(['like', 'product_name_ru', $search]);
                if ($categoryIds) {
                    $query->andWhere(['category_id' => $categoryIds]);
                }
                $query->asArray()->all();


                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $products = $query->offset($pages->offset)->limit($pages->limit)->all();

                foreach ($products as $product) {
                    array_push($productIds, $product["id"]);
                }

                $query = ProductStock::find()
                    ->with([
                        'product' => function (Query $query) {
                            $query->select(['id', 'product_name_ru', 'product_name_uz', 'alias', 'category_id', 'brand_id']);
                        }
                    ])
                    ->with(['images'])
                    ->joinWith(['category'])
                    ->andWhere(['>=', 'product_qty', 1])
                    ->andWhere(['>=', 'product_price', 1])
                    ->andWhere(['in', 'product_id', $productIds])
                    ->asArray()
                    ->distinct()
                    ->orderBy(['id' => SORT_DESC])
                    ->groupBy(['product_id']);

                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 16, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $products = $query->offset($pages->offset)->limit($pages->limit)->all();

                $items = array();
                foreach ($products as $product) {
                    //                Product_name
                    $product_name = "";
                    if ($lang == "ru") {
                        $product_name = $product["product"]["product_name_ru"];
                    } else if ($lang == "uz") {
                        $product_name = $product["product"]["product_name_uz"];
                    }

                    //                Product price
                    $price = 0;
                    if ($product) {
                        $price = $product["product_price"];
                    }

                    //                Product image
                    $imageUrl = "";
                    if ($product["images"]) {
                        $imageUrl = $product["images"][0]["image_name"];
                    }

//                    Get brand
                    $brand = Brand::findOne($product["product"]["brand_id"]);


//                    Detect sale price
                    $sale_price = "";
                    $integer_date = new DateTime();
                    $currentDate = date_timestamp_get($integer_date);
                    if ($product["sale_start_date"] && $product["sale_end_date"] && $product["product_sale_price"]) {
                        if ($currentDate >= $product["sale_start_date"] && $currentDate <= $product["sale_end_date"]) {
                            $sale_price = $product["product_sale_price"];
                        }
                    }

//                    Is new label
                    $is_new = 0;
                    $weekAgoDate = date('jS F Y H:i.s', strtotime('-1 week'));
                    $weekAgoDateInteger = strtotime($weekAgoDate);
                    if ($weekAgoDate >= $product["first_created"]) {
                        $is_new = 1;
                    }

                    $columns = array();
//        Вытаскиваю все колонки для данной категории
                    $rows = CategoryAttributeRow::find()
                        ->where(['in', 'category_id', $product["product"]["category_id"]])
                        ->orderBy(['order' => SORT_ASC])
                        ->asArray()
                        ->all();

                    if ($rows) {
                        $i = 0;
                        foreach ($rows as $row) {
                            if ($i == 0) {
                                $row_title = array();
                                if ($lang == "ru") {
                                    $row_title = array(
                                        "column_name" => $row["value_uz"]
                                    );
                                } else if ($lang == "uz") {
                                    $row_title = array(
                                        "column_name" => $row["value_ru"]
                                    );
                                }


                                $attributeIdsArray = array();
                                if (isset($row["category_attribute"])) {
                                    $attributeIdsArray = explode(',', $row["category_attribute"]);
                                    $attribute = CategoryAttribute::find()
                                        ->where(['in', 'id', $attributeIdsArray])
                                        ->asArray()
                                        ->all();
                                }

                                $attributeArray = array();
                                foreach ($attribute as $attr) {
                                    $attributeValue = ProductCategoryAttributeValue::find()
                                        ->where(['category_attribute_id' => $attr["id"]])
                                        ->andWhere(['product_id' => $product["product"]["id"]])
                                        ->asArray()
                                        ->all();

//                Нужно вытащить именно те значения которые были выбраны для данного товара
                                    $arrayValues = array();
                                    if ($attr["input_type"] == "1") {
                                        $attributeIdValuesArray = array();
                                        if (isset($attributeValue[0]["category_attribute_value_id"])) {
                                            $attributeIdValuesArray = explode('^', $attributeValue[0]["category_attribute_value_id"]);
                                            $values = CategoryAttributeValue::find()
                                                ->where(['in', 'id', $attributeIdValuesArray])
                                                ->asArray()
                                                ->all();

                                            foreach ($values as $value) {
                                                $valueArray = array();
                                                if ($lang == "ru") {
                                                    $valueArray = array(
                                                        "value" => $value["value_ru"]
                                                    );
                                                } else if ($lang == "uz") {
                                                    $valueArray = array(
                                                        "value" => $value["value_uz"]
                                                    );
                                                }

                                                array_push($arrayValues, $valueArray);
                                            }

                                        }
                                    } else {
                                        $custom_array_value = array();
                                        if ($lang == "ru") {
                                            $custom_array_value = array(
                                                "value" => $attributeValue[0]["value_ru"] ? $attributeValue[0]["value_ru"] : "",
                                            );
                                        } else if ($lang == "uz") {
                                            $custom_array_value = array(
                                                "value" => $attributeValue[0]["value_uz"] ? $attributeValue[0]["value_uz"] : "",
                                            );
                                        }

                                        array_push($arrayValues, $custom_array_value);

                                    }

                                    $columnAttributeName = "";
                                    if ($lang == "ru") {
                                        $columnAttributeName = $attr["category_attribute_ru"];
                                    } else if ($lang == "uz") {
                                        $columnAttributeName = $attr["category_attribute_uz"];
                                    }

                                    $attributeColumnsValues = array(
                                        'rows' => array(
                                            'column_name' => $columnAttributeName,
                                        ),
                                        'values' => $arrayValues,
                                    );
                                    array_push($attributeArray, $attributeColumnsValues);
                                }
                                $singleColumn = array(
                                    'row' => $row_title,
                                    'attribute' => $attributeArray,
                                );
                                array_push($columns, $singleColumn);
                            }
                            $i++;
                        }
                    }

                    //                Is feature
                    $is_feature = $this->actionIsFeature($product["product"]["id"]);
                    //Get credit percentages
                    $credit_percentages = $this->actionGetPercentage($product["product"]["category_id"]);

                    $stock = $this->actionGetProductStock($product["product"]["category_id"], $product["id"], $product["first_attribute_id"], $product["second_attribute_id"]);


                    if ($product["product"]["is_offer"] == "1") {
                        array_push($popular_offer_array, array(
                            "id" => $product["product"]["id"],
                            "product_name" => $product_name,
                            "price" => $price,
                            "sale_price" => $sale_price,
                            "credit_percentage" => $credit_percentages,
                            "image_url" => self::BASE_URL . "backend/web/uploads/products/product_" . $product["product"]["id"] . "/gallery/" . $imageUrl,
                        ));
                    }

                    array_push(
                        $items,
                        array(
                            "id" => $product["product"]["id"],
                            "is_new" => $is_new,
                            "is_feature" => $is_feature,
                            "product_name" => $product_name,
                            "price" => $price,
                            "sale_price" => $sale_price,
                            "credit_percentage" => $credit_percentages,
                            "stock" => $stock,
                            "imageUrl" => $imageUrl,
                            "image_url" => self::BASE_URL . "backend/web/uploads/products/product_" . $product["product"]["id"] . "/gallery/" . $imageUrl,
                            "brand" => array(
                                "id" => $brand->id,
                                "brand_title" => $brand->brand_title,
                                "brand_logo" => self::BASE_URL . "backend/web/uploads/brands/brand" . $brand->id . "/" . $brand->brand_logo

                            ),

                            "properties" => $columns,
                        )
                    );
                }
                return $items;
            } else {
                Yii::$app->response->statusCode = 400;
                return ["message" => "No search keyword"];
            }

        } else {
            Yii::$app->response->statusCode = 400;
            return ["message" => "Incorrect request"];
        }
    }

    public function actionGetDiscountBlocks()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isGet) {

            $current_date = date('Y-m-d');

            $discount_blocks = DiscountBlock::find()
                ->where(["is_active" => "1"])
                ->andWhere(['<=', 'start_date', $current_date])
                ->andWhere(['>=', 'end_date', $current_date])
                ->orderBy(["id" => SORT_DESC])
                ->all();


            $items = array();

            foreach ($discount_blocks as $discount_block){
                $headers = Yii::$app->request->headers;
                $lang = $headers->get('Accept-Language');

                $title = "";
                $image_url = "";
                if ($lang == "ru") {
                    $title = $discount_block->title_ru;
                    $image_url = self::BASE_URL . "backend/web/uploads/discount_blocks/discount_block{$discount_block->id}/"  . $discount_block->image_uz;
                } else if ($lang == "uz") {
                    $title = $discount_block->title_uz ? $discount_block->title_uz : $discount_block->title_ru;
                    $image_url = self::BASE_URL . "backend/web/uploads/discount_blocks/discount_block{$discount_block->id}/"  . $discount_block->image_ru;

                }

                array_push($items, array(
                    "id" => $discount_block->id,
                    "alias" => $discount_block->alias,
                    "title" => $title,
                    "image" => $image_url,
                    "date_start" => $discount_block->start_date,
                    "date_end" => $discount_block->end_date,
                ));
            }

            return $items;

        } else {
            Yii::$app->response->statusCode = 400;
            return ["message" => "Incorrect request"];
        }
    }

    public function actionGetDiscountBlockProducts($id, $page_number = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isGet) {
            $discount_block = DiscountBlock::findOne($id);
            if ($discount_block) {
                $headers = Yii::$app->request->headers;
                $lang = $headers->get('Accept-Language');

                $title = "";
                if ($lang == "ru") {
                    $title = $discount_block->title_ru;
                } else if ($lang == "uz") {
                    $title = $discount_block->title_uz ? $discount_block->title_uz : $discount_block->title_ru;
                }


                //                Query products
                $products_per_page_qty = 16;
                if ($page_number == "") {
                    $page_number = 1;
                }

                $categoryIds = array();
                $third_level_categories = Category::find()->where([
                    'parent_id' => $discount_block->category_id,
                    'level' => 3,
                ])
                    ->all();

                foreach ($third_level_categories as $third_level_category) {
                    array_push($categoryIds, $third_level_category->id);
                }

                $integer_date = new DateTime();
                $currentDate = date_timestamp_get($integer_date);

                $query = ProductStock::find()
                    ->joinWith(['images'])
                    ->joinWith([
                        'product' => function (Query $query) {
                            $query->select(['id', 'product_name_ru', 'product_name_uz', 'alias', 'category_id', 'brand_id', 'is_offer']);
                        }
                    ])
                    ->joinWith(['b'])
                    ->where(['not', ['sale_start_date' => null]])
                    ->andWhere(['<=', 'sale_start_date', $currentDate])
                    ->andWhere(['>=', 'sale_end_date', $currentDate])
                    ->andWhere(['>=', 'product_qty', 1])
                    ->andWhere(['merchant_id' => 28])
                    ->andWhere(['in', 'product.category_id', $categoryIds])
                    ->asArray()
                    ->distinct()
                    ->orderBy(['id' => SORT_DESC])
                    ->groupBy(['product_id']);

                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => $products_per_page_qty, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $products = $query->offset(($page_number - 1) * $products_per_page_qty)->limit($pages->limit)->all();


                $items = array();
                foreach ($products as $product) {
                    //                Product_name
                    $product_name = "";
                    if ($lang == "ru") {
                        $product_name = $product["product"]["product_name_ru"];
                    } else if ($lang == "uz") {
                        $product_name = $product["product"]["product_name_uz"];
                    }

                    //                Product price
                    $price = 0;
                    if ($product) {
                        $price = $product["product_price"];
                    }

                    //                Product image
                    $imageUrl = "";
                    if ($product["images"]) {
                        $imageUrl = $product["images"][0]["image_name"];
                    }

//                    Get brand
                    $brand = Brand::findOne($product["product"]["brand_id"]);


//                    Detect sale price
                    $sale_price = "";
                    $integer_date = new DateTime();
                    $currentDate = date_timestamp_get($integer_date);
                    if ($product["sale_start_date"] && $product["sale_end_date"] && $product["product_sale_price"]) {
                        if ($currentDate >= $product["sale_start_date"] && $currentDate <= $product["sale_end_date"]) {
                            $sale_price = $product["product_sale_price"];
                        }
                    }

//                    Is new label
                    $is_new = 0;
                    $weekAgoDate = date('jS F Y H:i.s', strtotime('-1 week'));
                    $weekAgoDateInteger = strtotime($weekAgoDate);
                    if ($weekAgoDate >= $product["first_created"]) {
                        $is_new = 1;
                    }

                    $columns = array();
//        Вытаскиваю все колонки для данной категории
                    $rows = CategoryAttributeRow::find()
                        ->where(['in', 'category_id', $product["product"]["category_id"]])
                        ->orderBy(['order' => SORT_ASC])
                        ->asArray()
                        ->all();

                    if ($rows) {
                        $i = 0;
                        foreach ($rows as $row) {
                            if ($i == 0) {
                                $row_title = array();
                                if ($lang == "ru") {
                                    $row_title = array(
                                        "column_name" => $row["value_uz"]
                                    );
                                } else if ($lang == "uz") {
                                    $row_title = array(
                                        "column_name" => $row["value_ru"]
                                    );
                                }


                                $attributeIdsArray = array();
                                if (isset($row["category_attribute"])) {
                                    $attributeIdsArray = explode(',', $row["category_attribute"]);
                                    $attribute = CategoryAttribute::find()
                                        ->where(['in', 'id', $attributeIdsArray])
                                        ->asArray()
                                        ->all();
                                }

                                $attributeArray = array();
                                foreach ($attribute as $attr) {
                                    $attributeValue = ProductCategoryAttributeValue::find()
                                        ->where(['category_attribute_id' => $attr["id"]])
                                        ->andWhere(['product_id' => $product["product"]["id"]])
                                        ->asArray()
                                        ->all();

//                Нужно вытащить именно те значения которые были выбраны для данного товара
                                    $arrayValues = array();
                                    if ($attr["input_type"] == "1") {
                                        $attributeIdValuesArray = array();
                                        if (isset($attributeValue[0]["category_attribute_value_id"])) {
                                            $attributeIdValuesArray = explode('^', $attributeValue[0]["category_attribute_value_id"]);
                                            $values = CategoryAttributeValue::find()
                                                ->where(['in', 'id', $attributeIdValuesArray])
                                                ->asArray()
                                                ->all();

                                            foreach ($values as $value) {
                                                $valueArray = array();
                                                if ($lang == "ru") {
                                                    $valueArray = array(
                                                        "value" => $value["value_ru"]
                                                    );
                                                } else if ($lang == "uz") {
                                                    $valueArray = array(
                                                        "value" => $value["value_uz"]
                                                    );
                                                }

                                                array_push($arrayValues, $valueArray);
                                            }

                                        }
                                    } else {
                                        $custom_array_value = array();
                                        if ($lang == "ru") {
                                            $custom_array_value = array(
                                                "value" => $attributeValue[0]["value_ru"] ? $attributeValue[0]["value_ru"] : "",
                                            );
                                        } else if ($lang == "uz") {
                                            $custom_array_value = array(
                                                "value" => $attributeValue[0]["value_uz"] ? $attributeValue[0]["value_uz"] : "",
                                            );
                                        }

                                        array_push($arrayValues, $custom_array_value);

                                    }

                                    $columnAttributeName = "";
                                    if ($lang == "ru") {
                                        $columnAttributeName = $attr["category_attribute_ru"];
                                    } else if ($lang == "uz") {
                                        $columnAttributeName = $attr["category_attribute_uz"];
                                    }

                                    $attributeColumnsValues = array(
                                        'rows' => array(
                                            'column_name' => $columnAttributeName,
                                        ),
                                        'values' => $arrayValues,
                                    );
                                    array_push($attributeArray, $attributeColumnsValues);
                                }
                                $singleColumn = array(
                                    'row' => $row_title,
                                    'attribute' => $attributeArray,
                                );
                                array_push($columns, $singleColumn);
                            }
                            $i++;
                        }
                    }

                    //                Is feature
                    $is_feature = $this->actionIsFeature($product["product"]["id"]);
                    //Get credit percentages
                    $credit_percentages = $this->actionGetPercentage($product["product"]["category_id"]);

                    $stock = $this->actionGetProductStock($product["product"]["category_id"], $product["id"], $product["first_attribute_id"], $product["second_attribute_id"]);


                    $category = Category::findOne($product["product"]["category_id"]);
                    $category_title = "";
                    if ($lang == "ru") {
                        $category_title = $category->category_title_ru;
                    } else if ($lang == "uz") {
                        $category_title = $category->category_title_uz ? $category->category_title_uz : $category->category_title_ru;
                    }


                    array_push(
                        $items,
                        array(
                            "id" => $product["product"]["id"],
                            "is_new" => $is_new,
                            "is_feature" => $is_feature,
                            "product_name" => $product_name,
                            "price" => $price,
                            "sale_price" => $sale_price,
                            "credit_percentage" => $credit_percentages,
                            "stock" => $stock,
                            "imageUrl" => $imageUrl,
                            "image_url" => self::BASE_URL . "backend/web/uploads/products/product_" . $product["product"]["id"] . "/gallery/" . $imageUrl,
                            "brand" => array(
                                "id" => $brand->id,
                                "brand_title" => $brand->brand_title,
                                "brand_logo" => self::BASE_URL . "backend/web/uploads/brands/brand" . $brand->id . "/" . $brand->brand_logo

                            ),
                            "category" => array(
                                "id" => $category->id,
                                "category_name" => $category_title,
                                "level" => $category->level
                            ),
                            "properties" => $columns,
                        )
                    );
                }

                return array(
                    "block" => array(
                        "id" => $discount_block->id,
                        "title" => $title,
                    ),
                    "items" => $items,
                    "pages" => ceil($pages->totalCount / $products_per_page_qty),
                    "current_page" => (int)$page_number,

                );

            } else {
                Yii::$app->response->statusCode = 400;
                return ["message" => "Incorrect request"];
            }
        } else {
            Yii::$app->response->statusCode = 400;
            return ["message" => "Incorrect request"];
        }
    }

    //Search page
    public function actionSearchProductPage($category_id = null, $search_keyword = null, $page_number = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isGet) {
            $headers = Yii::$app->request->headers;
            $lang = $headers->get('Accept-Language');

            $search = $search_keyword;

            if ($search) {
                $productIds = array();
                $categoryIds = array();
                if ($category_id) {
                    if ($category_id) {
                        $category = Category::findOne($category_id);

                        $second_level_categories = Category::find()
                            ->where([
                                'parent_id' => $category->id,
                                'level' => 2,
                            ])
                            ->all();

                        foreach ($second_level_categories as $second_level_category) {
                            $third_level_categories = Category::find()->where([
                                'parent_id' => $second_level_category->id,
                                'level' => 3,
                            ])
                                ->all();

                            foreach ($third_level_categories as $third_level_category) {
                                array_push($categoryIds, $third_level_category->id);
                            }
                        }
                    }
                }

//            Get by product name
                $query = Product::find()
                    ->select(['id', 'category_id'])
                    ->where(['like', 'product_name_ru', $search]);
                if ($categoryIds) {
                    $query->andWhere(['category_id' => $categoryIds]);
                }
                $query->asArray()->all();

                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $products = $query->offset($pages->offset)->limit($pages->limit)->all();

                foreach ($products as $product) {
                    array_push($productIds, $product["id"]);
                }

                //                Query products
                $products_per_page_qty = 16;
                if ($page_number == "") {
                    $page_number = 1;
                }

                $query = ProductStock::find()
                    ->with([
                        'product' => function (Query $query) {
                            $query->select(['id', 'product_name_ru', 'product_name_uz', 'alias', 'category_id', 'brand_id']);
                        }
                    ])
                    ->with(['images'])
                    ->andWhere(['>=', 'product_qty', 1])
                    ->andWhere(['>=', 'product_price', 1])
                    ->andWhere(['in', 'product_id', $productIds])
                    ->asArray()
                    ->distinct()
                    ->orderBy(['id' => SORT_DESC])
                    ->groupBy(['product_id']);

                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 16, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $products = $query->offset($pages->offset)->limit($pages->limit)->all();

                $items = array();
                foreach ($products as $product) {
                    //                Product_name
                    $product_name = "";
                    if ($lang == "ru") {
                        $product_name = $product["product"]["product_name_ru"];
                    } else if ($lang == "uz") {
                        $product_name = $product["product"]["product_name_uz"];
                    }

                    //                Product price
                    $price = 0;
                    if ($product) {
                        $price = $product["product_price"];
                    }

                    //                Product image
                    $imageUrl = "";
                    if ($product["images"]) {
                        $imageUrl = $product["images"][0]["image_name"];
                    }

//                    Get brand
                    $brand = Brand::findOne($product["product"]["brand_id"]);


//                    Detect sale price
                    $sale_price = "";
                    $integer_date = new DateTime();
                    $currentDate = date_timestamp_get($integer_date);
                    if ($product["sale_start_date"] && $product["sale_end_date"] && $product["product_sale_price"]) {
                        if ($currentDate >= $product["sale_start_date"] && $currentDate <= $product["sale_end_date"]) {
                            $sale_price = $product["product_sale_price"];
                        }
                    }

                    $category_name = "";
                    $category = Category::findOne($product["product"]["category_id"]);
                    if ($lang == "ru") {
                        $category_name = $category->category_title_ru;
                    } else if ($lang == "uz") {
                        $category_name = $category->category_title_uz;
                    }


//                    Is new label
                    $is_new = 0;
                    $weekAgoDate = date('jS F Y H:i.s', strtotime('-1 week'));
                    $weekAgoDateInteger = strtotime($weekAgoDate);
                    if ($weekAgoDate >= $product["first_created"]) {
                        $is_new = 1;
                    }

                    //                Is feature
                    $is_feature = $this->actionIsFeature($product["product"]["id"]);
                    //Get credit percentages
                    $credit_percentages = $this->actionGetPercentage($product["product"]["category_id"]);

                    $stock = $this->actionGetProductStock($product["product"]["category_id"], $product["id"], $product["first_attribute_id"], $product["second_attribute_id"]);


                    $columns = array();
//        Вытаскиваю все колонки для данной категории
                    $rows = CategoryAttributeRow::find()
                        ->where(['in', 'category_id', $product["product"]["category_id"]])
                        ->orderBy(['order' => SORT_ASC])
                        ->asArray()
                        ->all();

                    if ($rows) {
                        $i = 0;
                        foreach ($rows as $row) {
                            if ($i == 0) {
                                $row_title = array();
                                if ($lang == "ru") {
                                    $row_title = array(
                                        "column_name" => $row["value_uz"]
                                    );
                                } else if ($lang == "uz") {
                                    $row_title = array(
                                        "column_name" => $row["value_ru"]
                                    );
                                }


                                $attributeIdsArray = array();
                                if (isset($row["category_attribute"])) {
                                    $attributeIdsArray = explode(',', $row["category_attribute"]);
                                    $attribute = CategoryAttribute::find()
                                        ->where(['in', 'id', $attributeIdsArray])
                                        ->asArray()
                                        ->all();
                                }

                                $attributeArray = array();
                                foreach ($attribute as $attr) {
                                    $attributeValue = ProductCategoryAttributeValue::find()
                                        ->where(['category_attribute_id' => $attr["id"]])
                                        ->andWhere(['product_id' => $product["product"]["id"]])
                                        ->asArray()
                                        ->all();

//                Нужно вытащить именно те значения которые были выбраны для данного товара
                                    $arrayValues = array();
                                    if ($attr["input_type"] == "1") {
                                        $attributeIdValuesArray = array();
                                        if (isset($attributeValue[0]["category_attribute_value_id"])) {
                                            $attributeIdValuesArray = explode('^', $attributeValue[0]["category_attribute_value_id"]);
                                            $values = CategoryAttributeValue::find()
                                                ->where(['in', 'id', $attributeIdValuesArray])
                                                ->asArray()
                                                ->all();

                                            foreach ($values as $value) {
                                                $valueArray = array();
                                                if ($lang == "ru") {
                                                    $valueArray = array(
                                                        "value" => $value["value_ru"]
                                                    );
                                                } else if ($lang == "uz") {
                                                    $valueArray = array(
                                                        "value" => $value["value_uz"]
                                                    );
                                                }

                                                array_push($arrayValues, $valueArray);
                                            }

                                        }
                                    } else {
                                        $custom_array_value = array();
                                        if ($lang == "ru") {
                                            $custom_array_value = array(
                                                "value" => $attributeValue[0]["value_ru"] ? $attributeValue[0]["value_ru"] : "",
                                            );
                                        } else if ($lang == "uz") {
                                            $custom_array_value = array(
                                                "value" => $attributeValue[0]["value_uz"] ? $attributeValue[0]["value_uz"] : "",
                                            );
                                        }

                                        array_push($arrayValues, $custom_array_value);

                                    }

                                    $columnAttributeName = "";
                                    if ($lang == "ru") {
                                        $columnAttributeName = $attr["category_attribute_ru"];
                                    } else if ($lang == "uz") {
                                        $columnAttributeName = $attr["category_attribute_uz"];
                                    }

                                    $attributeColumnsValues = array(
                                        'rows' => array(
                                            'column_name' => $columnAttributeName,
                                        ),
                                        'values' => $arrayValues,
                                    );
                                    array_push($attributeArray, $attributeColumnsValues);
                                }
                                $singleColumn = array(
                                    'row' => $row_title,
                                    'attribute' => $attributeArray,
                                );
                                array_push($columns, $singleColumn);
                            }
                            $i++;
                        }
                    }

                    array_push(
                        $items,
                        array(
                            "id" => $product["product"]["id"],
                            "is_new" => $is_new,
                            "is_feature" => $is_feature,
                            "product_name" => $product_name,
                            "price" => $price,
                            "sale_price" => $sale_price,
                            "credit_percentage" => $credit_percentages,
                            "stock" => $stock,
                            "imageUrl" => $imageUrl,
                            "image_url" => self::BASE_URL . "backend/web/uploads/products/product_" . $product["product"]["id"] . "/gallery/" . $imageUrl,
                            "brand" => array(
                                "id" => $brand->id,
                                "brand_title" => $brand->brand_title,
                                "brand_logo" => self::BASE_URL . "backend/web/uploads/brands/brand" . $brand->id . "/" . $brand->brand_logo

                            ),
                            "category" => array(
                                "id" => $category->id,
                                "category_name" => $category_name,
                            ),
                            "properties" => $columns,
                        )
                    );
                }

                return array(
                    "pages" => ceil($pages->totalCount / $products_per_page_qty),
                    "current_page" => (int)$page_number,
                    "products" => $items,
                );
            } else {
                Yii::$app->response->statusCode = 400;
                return ["message" => "No search keyword"];
            }


        } else {
            Yii::$app->response->statusCode = 400;
            return ["message" => "Incorrect request"];
        }
    }


    //    For main page
    public function actionGetCategoryBlocks()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isGet) {
            $language = Yii::$app->request->headers->get('Accept-Language');

            $blocks = PageBlock::find()
                ->where(['is_active_ru' => '1'])
                ->with(['category'])
                ->orderBy(['order' => SORT_ASC])
                ->all();

            $items = array();
            foreach ($blocks as $block) {
//          Block title
                $block_name = "";
                if ($language == "ru") {
                    $block_name = $block->block_title_ru;
                } else if ($language == "uz") {
                    $block_name = $block->block_title_uz;
                }

//          Category name
                $category_name = "";
                if ($language == "ru") {
                    $category_name = $block->category->category_title_ru;
                } else if ($language == "uz") {
                    $category_name = $block->category->category_title_uz;
                }

                $products = array();
                $query = ProductStock::find()
                    ->with(['images'])
                    ->with([
                        'product' => function (Query $query) {
                            $query->select(['id', 'product_name_ru', 'alias', 'category_id', 'brand_id']);
                        }
                    ])
                    ->joinWith(['merchant'])
                    ->andWhere([
                        'merchant.merchant_status' => MerchantStatus::ACTIVE_MERCHANT,
                    ])
                    ->where(['product_category_id' => $block->category->id])
                    ->andWhere(['>=', 'product_qty', 1])
                    ->andWhere(['>=', 'product_price', 1])
                    ->distinct()
                    ->limit(12)
                    ->orderBy(['id' => SORT_DESC])
                    ->groupBy(['product_id'])
                    ->all();

                foreach ($query as $q) {
                    //          Category name
                    $product_name = "";
                    if ($language == "ru") {
                        $product_name = $q->product->product_name_ru;
                    } else if ($language == "uz") {
                        $product_name = $q->product->product_name_ru;
                    }

//                Product price
                    $product_price = 0;
                    if ($q) {
                        $product_price = $q->product_price;
                    }
                    $sale_price = 0;
                    $integer_date = new DateTime();
                    $currentDate = date_timestamp_get($integer_date);
                    if ($q->sale_start_date && $q->sale_end_date && $q->product_sale_price) {
                        if ($currentDate >= $q->sale_start_date && $currentDate <= $q->sale_end_date) {
                            $sale_price = $q->product_sale_price;
                        }
                    }

                    // Category
                    $category = Category::findOne($q->product->category->id);

                    $credit_percentages = $this->actionGetPercentage($q->product->category->id);
                    $is_feature = $this->actionIsFeature($q->product->id);
                    $stock = $this->actionGetProductStock($q->product->category->id, $q->id, $q->first_attribute_id, $q->second_attribute_id);


//                Image Url
                    $imageUrl = 0;
                    if (isset($q->images)) {
                        $imageUrl = $q->images[0]->image_name;
                    }

                    array_push($products, array(
                        "id" => $q->product->id,
                        "product_id" => $q->product->id,
                        "category" => array(
                            "id" => $category->id,
                            "category_name" => $category_name,
                        ),
                        "alias" => $q->product->alias,
                        "credit_percentages" => $credit_percentages,
                        "is_feature" => $is_feature,
                        "stock" => $stock,
                        "product_name" => $product_name,
                        "product_price" => $product_price,
                        "sale_price" => $sale_price,
                        "image_url" => self::BASE_URL . 'backend/web/uploads/products/product_' . $q->product->id . '/gallery/' . $imageUrl,
                    ));
                }


                array_push($items, array(
                    "id" => $block->id,
                    "block_title" => $block_name,
                    "category_name" => $category_name,
                    "category_link" => $block->category->category_alias,
                    "category_level" => $block->category->level,
                    "category_url" => $block->category->category_alias,
                    "category_id" => $block->category->id,
                    "products" => $products
                ));
            }

            return $items;
        }
    }

//    For main page
    public function actionGetMainBanner()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isGet) {
            $language = Yii::$app->request->headers->get('Accept-Language');
            $main_settings = MainSetting::findOne(1);

            if ($main_settings->main_banner_image_url) {
                $url_link = "";
                if ($language == "ru") {
                    $url_link = $main_settings->main_banner_image_link_url_ru;
                } else if ($language == "uz") {
                    $url_link = $main_settings->main_banner_image_link_url_uz;
                }
                return array(
                    "url_link" => $url_link,
                    "image_link" => self::BASE_URL . 'backend/web/uploads/main_image/' . $main_settings->main_banner_image_url,
                );
            } else {
                return array("");
            }

        } else {
            Yii::$app->response->statusCode = 400;
            return ["message" => "Incorrect request"];
        }
    }

//    Main ads
    public function actionGetAdsBanner()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isGet) {
            $language = Yii::$app->request->headers->get('Accept-Language');
            $main_settings = MainSetting::findOne(1);

            $ads_banner_array = array();

            $banner_image_1 = "";
            $banner_image_1_url = "";

            $banner_image_2 = "";
            $banner_image_2_url = "";

            if ($language == "ru") {
                if ($main_settings->banner_image_1) {
                    array_push($ads_banner_array, array(
                        "image_url" => self::BASE_URL . 'backend/web/uploads/main_image/' . $main_settings->banner_image_1,
                        "banner_url" => $main_settings->banner_image_1_url_ru,
                    ));
                }

                if ($main_settings->banner_image_2) {
                    array_push($ads_banner_array, array(
                        "image_url" => self::BASE_URL . 'backend/web/uploads/main_image/' . $main_settings->banner_image_2,
                        "banner_url" => $main_settings->banner_image_2_url_ru,
                    ));
                }

            } else if ($language == "uz") {
                if ($main_settings->banner_image_1) {
                    array_push($ads_banner_array, array(
                        "image_url" => self::BASE_URL . 'backend/web/uploads/main_image/' . $main_settings->banner_image_1,
                        "banner_url" => $main_settings->banner_image_1_url_uz,
                    ));
                }

                if ($main_settings->banner_image_2) {
                    array_push($ads_banner_array, array(
                        "image_url" => self::BASE_URL . 'backend/web/uploads/main_image/' . $main_settings->banner_image_2,
                        "banner_url" => $main_settings->banner_image_2_url_uz,
                    ));
                }
            }

            return $ads_banner_array;

        } else {
            Yii::$app->response->statusCode = 400;
            return ["message" => "Incorrect request"];
        }
    }

    //Get percentage for product
    public function actionGetPercentage($category_id)
    {
        $credit_percentages = array();
        $category = Category::findOne($category_id);
        //                3 month
        if ($category->is_3_month) {
            array_push($credit_percentages, array(
                "month" => 3,
                "percentage" => $category->three_month_percentage,
            ));
        }
//              6 month
        if ($category->is_6_month) {
            array_push($credit_percentages, array(
                "month" => 6,
                "percentage" => $category->six_month_percentage,
            ));
        }

        //              9 month
        if ($category->is_9_month) {
            array_push($credit_percentages, array(
                "month" => 9,
                "percentage" => $category->nine_month_percentage,
            ));
        }

        //              12 month
        if ($category->is_12_month) {
            array_push($credit_percentages, array(
                "month" => 12,
                "percentage" => $category->twelve_month_percentage,
            ));
        }

        //              18 month
        if ($category->is_18_month) {
            array_push($credit_percentages, array(
                "month" => 18,
                "percentage" => $category->eighteen_month_percentage,
            ));
        }

        //              24 month
        if ($category->is_24_month) {
            array_push($credit_percentages, array(
                "month" => 24,
                "percentage" => $category->twenty_four_month_percentage,
            ));
        }

        //              36 month
        if ($category->is_36_month) {
            array_push($credit_percentages, array(
                "month" => 24,
                "percentage" => $category->thirty_six_month_percentage,
            ));
        }

        return $credit_percentages;
    }

//    is product feature
    public function actionIsFeature($product_id)
    {
        //                Is feature
        $is_feature = 0;
        $token = substr(Yii::$app->request->headers->get('Authorization'), 7);
        if ($token) {
            $user = User::findOne(['auth_token' => $token]);
            if ($user) {
                $feature = Feature::findOne([
                    "product_id" => $product_id,
                    "user_id" => $user->id,
                ]);

                if ($feature) {
                    $is_feature = 1;
                }
            }
        }

        return $is_feature;
    }

    public function actionGetProductStock($category_id, $stock_id, $first = null, $second = null)
    {
        $category_characteristic_rows = CategoryCharacteristicRow::find()
            ->where(['category_id' => $category_id])
            ->asArray()
            ->all();

        $first_attribute_id = "";
        $first_attribute_name = "";

        if ($category_characteristic_rows[0]["data_type"] == 0) {
            $item = Color::findOne($first);
            $first_attribute_id = $item->id;
            $first_attribute_name = $item->color_name_en;
        }

        //Это для телефона ОЗУ / ПЗУ
        $second_attribute_id = "";
        $second_attribute_name = "";
        $second_array = array();
        if ($second) {
            if ($category_characteristic_rows[1]["data_type"] == 1) {
                $item = PhoneRamRom::findOne($second);
                $second_attribute_id = $item->id;
                $second_attribute_name = $item->title;
            }

            $second_array = array(
                "second_attribute_id" => $second_attribute_id,
                "second_attribute_name" => $second_attribute_name,
            );
        }

        return array(
            "stock_id" => $stock_id,
            "first" => array(
                "first_attribute_id" => $first_attribute_id,
                "first_attribute_name" => $first_attribute_name,
            ),
            "second" => $second_array,

        );
    }
}
