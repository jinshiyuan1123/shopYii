<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-05-18
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use Yii;
use yii\helpers\Json;
use common\components\ETActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $image
 * @property string $featured_image
 * @property string $image_small
 * @property string $image_medium
 * @property string $image_large
 * @property string $name
 * @property integer $sort
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $price 数据库的decimal类型自动生成string类型
 * @property string $featured_price
 * @property string $featured_position
 * @property integer $featured_position_sort
 * @property string $app_featured_home
 * @property integer $app_featured_home_sort
 * @property string $app_featured_image
 * @property string $short_description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $is_audit
 * @property string $remarks
 * @property string $featured
 * @property string $description
 * @property string $app_featured_topic
 * @property integer $app_featured_topic_sort
 * @property string $app_long_image1
 * @property string $app_long_image2
 * @property string $app_long_image3
 * @property string $app_long_image4
 * @property string $app_long_image5
 * @property integer $type_id 商品类型id，一个商品属于一种商品类型，商品类型关联规格值，来自ProductType::$id
 * @property integer $status
 * @property string $specs_json  选中的规格和规格值, 如:{"1":{"1":"标准","3":"加热"},"2":{"5":"大杯","6":"中杯"}}
 *      由于javascript不支持关联数组，所以json_encode()只将索引数组（indexed array）转为数组格式，而将关联数组（associative array）转为对象格式。
 *                      json解码后如下:
 *                               [sp_val] => Array
 *                               (
 *                                  [1] => Array        [1]为spec_id
 *                                  (
 *                                      [1] => 标准     [1]为spec_value_id, 标准为spec_value_name
 *                                      [2] => 标准
 *                                  )
 *                                  [2] => Array
 *                                  (
 *                                      [4] => 标准
 *                                      [5] => 大杯
 *                                  )
 *                               )
 * @property array $specsArray  $specs_json解码后的数组
 *
 * @property ProductCategory $category
 * @property ProductType $productType
 * @property ProductAttr[] $productAttrs
 * @property ProductSku[] $productSkus
 * @property ProductAttrItem[] $items
 */
class Product extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'category_id', 'specs_json'], 'required'],
            [['id', 'category_id', 'type_id', 'sort', 'created_at', 'created_by', 'updated_at', 'updated_by', 'featured_position_sort', 'app_featured_home_sort', 'app_featured_topic_sort', 'status'], 'integer'],
            [['price', 'featured_price'], 'number'],
            [['description'], 'string'],
            [['image', 'featured_image', 'image_small', 'name', 'featured_position', 'app_featured_image', 'short_description', 'meta_keywords', 'meta_description', 'remarks', 'app_long_image4', 'app_long_image5', 'specs_json'], 'string', 'max' => 255],
            [['app_featured_home', 'is_audit', 'featured', 'app_featured_topic'], 'string', 'max' => 1],
            [['image_medium', 'image_large', 'app_long_image1', 'app_long_image2', 'app_long_image3'], 'string', 'max' => 1000],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'image' => Yii::t('app', 'Image'),
            'featured_image' => Yii::t('app', 'Featured Image'),
            'image_small' => Yii::t('app', 'Image Small'),
            'name' => Yii::t('app', 'Name'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'price' => Yii::t('app', 'Price'),
            'featured_price' => Yii::t('app', 'Featured Price'),
            'featured_position' => Yii::t('app', 'Featured Position'),
            'featured_position_sort' => Yii::t('app', 'Featured Position Sort'),
            'app_featured_home' => Yii::t('app', 'App Featured Home'),
            'app_featured_home_sort' => Yii::t('app', 'App Featured Home Sort'),
            'app_featured_image' => Yii::t('app', 'App Featured Image'),
            'short_description' => Yii::t('app', 'Short Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'is_audit' => Yii::t('app', 'Is Audit'),
            'remarks' => Yii::t('app', 'Remarks'),
            'featured' => Yii::t('app', 'Featured'),
            'description' => Yii::t('app', 'Description'),
            'image_medium' => Yii::t('app', 'Image Medium'),
            'image_large' => Yii::t('app', 'Image Large'),
            'app_featured_topic' => Yii::t('app', 'App Featured Topic'),
            'app_featured_topic_sort' => Yii::t('app', 'App Featured Topic Sort'),
            'app_long_image1' => Yii::t('app', 'App Long Image1'),
            'app_long_image2' => Yii::t('app', 'App Long Image2'),
            'app_long_image3' => Yii::t('app', 'App Long Image3'),
            'type_id' => Yii::t('app', 'Product Type'),
            'app_long_image4' => Yii::t('app', 'App Long Image4'),
            'app_long_image5' => Yii::t('app', 'App Long Image5'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * 将$specs_json转为数组$specs_array
     *
     * @return array|mixed
     */
    public function getSpecsArray()
    {
        return $this->specs_json ? Json::decode($this->specs_json, true) : [];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrs()
    {
        return $this->hasMany(ProductAttr::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSkus()
    {
        return $this->hasMany(ProductSku::className(), ['product_id' => 'id'])
            ->where('status != :status', [':status'=>self::STATUS_DELETED]);
    }

    /**
     * 获得当前产品具体的ProductSku
     *
     * @param $sku_id
     * @return ProductSku|null
     */
    public function getProductSkuBy($sku_id)
    {
        if($this->productSkus){
            foreach($this->productSkus as $productSku){
                if($productSku->id == $sku_id){
                    return $productSku;
                }
            }
        }
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrItems()
    {
        return $this->hasMany(ProductAttrItem::className(), ['id' => 'item_id'])->viaTable('product_attr', ['product_id' => 'id']);
    }

    public static function listAllByCategoryId($category_id, $fields='*', $orderBy='sort asc', $status=1)
    {
        return self::find()
            ->select($fields)
            ->where('category_id = :category_id and status = :status',
                [':category_id' => $category_id, ':status' => $status])
            ->orderBy($orderBy);
    }

    /**
     * 转到商品的最终价格
     * @return string
     */
    public function turnToFinalPrice()
    {
        if($this->featured_price){
            return $this->featured_price;
        }else{
            return $this->price;
        }
    }
}
