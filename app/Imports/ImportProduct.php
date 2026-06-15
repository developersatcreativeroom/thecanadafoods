<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Brand;
// use App\Models\Color;
use App\Models\Tax;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helper;

class ImportProduct implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {

        $importFields = [
            'name' => $row['name'],
            'short_description' => $row['short_description'],
            'description' => $row['description'],
            'is_tax_included' => $row['is_tax_included'],
            
            // images not done yet starts
                // 'image' => $row['image'],
                // 'hover_image' => $row['hover_image'],
                // 'gallery' => $row['gallery'],
            // images not done yet ends
            
            // foriegn key handling starts
            'brand_id' => $this->parseBrand($row['brand']),
            // 'color_id' => $this->parseColor($row['color']),
            'tax_id' => $this->parseTax($row['tax']),
            // foriegn key handling ends

            'is_featured' => $row['is_featured'],
            'is_sample' => $row['is_sample'],
            'is_sale' => $row['is_sale'],
            'is_new' => $row['is_new'],
            'is_hot' => $row['is_hot'],
            'is_best_sell' => $row['is_best_sell'],
            'is_variant' => $row['is_variant'],
            
            'product_type' => 'physical',
            'affiliate_link' => null,
            'licence_name' => null,
            'licence_key' => null,
            'file_type' => null,
            'link' => null,
            'file' => null,
        ];

        if(!$row['is_variant']){
            $importFields['price'] = $row['price'];
            $importFields['old_price'] = $row['old_price'];
            $importFields['sku'] = $row['sku'];
            $importFields['stock'] = $row['stock'];
            $importFields['threshold'] = $row['threshold'];
            $importFields['length'] = $row['length'];
            $importFields['width'] = $row['width'];
            $importFields['height'] = $row['height'];
            $importFields['weight'] = $row['weight'];
        }else{

            // $importFields['variants'] = '';
            // $importFields['variant_prices'] = '';
            // $importFields['variant_old_prices'] = '';
            // $importFields['variant_skus'] = '';
            // $importFields['variant_stocks'] = '';
            // $importFields['variant_threshold'] = '';
            // $importFields['variant_length'] = '';
            // $importFields['variant_width'] = '';
            // $importFields['variant_height'] = '';
            // $importFields['variant_weight'] = '';
        }

        // array handling starts
        $importFields['categories'] = $this->parseCategories($row['categories']);
        $importFields['specifications'] = $this->parseSpecifications($row['specifications']);
        $importFields['tags'] = $this->parsetags($row['tags']);
        // array handling ends

        $importFields['seo_title'] = $row['seo_title'];
        $importFields['seo_description'] = $row['seo_description'];
        $importFields['seo_keywords'] = $row['seo_keywords'];
        $importFields['is_imported'] = true;
        $importFields['status'] = $row['status'];

        // Create or find the main product
        // $product = Product::firstOrCreate([
        //     'name'  => $row['name']
        // ], $importFields);
        $product = Product::create($importFields);


        // // Handle Variants
        if ($row['is_variant'] && !empty($row['variants'])) {
            $variants = $this->parseVariants($row);
            $attributes = $this->parseVariantDetails($variants);

            foreach ($attributes as $attribute) {
                $attributeDB = $product->attributes()->create(['price'=>$attribute['price'], 'old_price'=>isset($attribute['old_price']) ? $attribute['old_price'] : null, 'stock'=>$attribute['stock'], 'sku'=>$attribute['sku'], 'min_quantity'=>isset($attribute['min_quantity']) ? $attribute['min_quantity'] : null, 'threshold'=>$attribute['threshold'], 'length'=>$attribute['length'], 'width'=>$attribute['width'], 'height'=>$attribute['height'], 'weight'=>$attribute['weight']]);

                foreach($attribute['attributes']['details'] as $detailKey=>$detail){
                    $attributeDB->details()->create(['product_id'=>$product->id, 'product_attribute_id'=>$attributeDB->id, 'attribute_id'=>$detail['attribute'], 'attribute_option_id'=>$detail['option']]);
                }

            }

        }

        if ($importFields['categories'] && !empty($importFields['categories'])) {
            foreach($importFields['categories'] as $category){
                $product->categories()->create(['category_id'=>$category]);
            }
        }

        
        if ($importFields['specifications'] && !empty($importFields['specifications'])) {
            foreach($importFields['specifications'] as $specification){
                if($specification['specification'] && $specification['value']){
                    $product->specifications()->create(['specification' => $specification['specification'], 'value' => $specification['value'], 'units' => isset($specification['units']) ? $specification['units'] : null ]);
                }
            }
        }

        // return $product;
    }

    /**
     * Parse colon and comma-separated variants
     */
    private function parseVariants($row)
    {
        $variants = [];
        $pairs = explode(',', $row['variants']);

        $prices = explode(',', $row['variant_prices']);
        $oldPrices = explode(',', $row['variant_old_prices']);
        $skus = explode(',', $row['variant_skus']);
        $stocks = explode(',', $row['variant_stocks']);
        $thresholds = explode(',', $row['variant_thresholds']);
        $lengths = explode(',', $row['variant_lengths']);
        $widths = explode(',', $row['variant_widths']);
        $heights = explode(',', $row['variant_heights']);
        $weights = explode(',', $row['variant_weights']);

        $pairs = array_filter($pairs, fn($value) => $value !== '');
        $prices = array_filter($prices, fn($value) => $value !== '');
        $oldPrices = array_filter($oldPrices, fn($value) => $value !== '');
        $skus = array_filter($skus, fn($value) => $value !== '');
        $stocks = array_filter($stocks, fn($value) => $value !== '');
        $thresholds = array_filter($thresholds, fn($value) => $value !== '');
        $lengths = array_filter($lengths, fn($value) => $value !== '');
        $widths = array_filter($widths, fn($value) => $value !== '');
        $heights = array_filter($heights, fn($value) => $value !== '');
        $weights = array_filter($weights, fn($value) => $value !== '');
        
        foreach ($pairs as $key => $pair) {
            $pair = trim($pair);
            $variations = explode('|', trim($pair));
            $variations = array_filter($variations, fn($value) => $value !== '');
            if (is_array($variations)) {
                $temp = [];
                foreach($variations as $k => $variation){
                    $combos = explode(':', $variation);
                    $combos = array_filter($combos, fn($value) => $value !== '');
                    $temp[$combos[0]] = $combos[1];
                }
                $variants[$key]['attributes'] = $temp;
            }

            $variants[$key]['price'] = (trim($prices[$key]) != 'na') ? trim($prices[$key]) : null;
            $variants[$key]['old_price'] = (trim($oldPrices[$key]) != 'na') ? trim($oldPrices[$key]) : null;
            $variants[$key]['sku'] = (trim($skus[$key]) != 'na') ? trim($skus[$key]) : null;
            $variants[$key]['stock'] = (trim($stocks[$key]) != 'na') ? trim($stocks[$key]) : null;
            $variants[$key]['threshold'] = (trim($thresholds[$key]) != 'na') ? trim($thresholds[$key]) : null;
            $variants[$key]['length'] = (trim($lengths[$key]) != 'na') ? trim($lengths[$key]) : null;
            $variants[$key]['width'] = (trim($widths[$key]) != 'na') ? trim($widths[$key]) : null;
            $variants[$key]['height'] = (trim($heights[$key]) != 'na') ? trim($heights[$key]) : null;;
            $variants[$key]['weight'] = (trim($weights[$key]) != 'na') ? trim($weights[$key]) : null;
            
        }
        // print '<pre>'; print_R($variants); die;
        return $variants;
    }
    
    private function parseBrand($name)
    {
        $brand = Brand::where('name', $name)->first();
        return $brand->id;
    }

    // private function parseColor($name)
    // {
    //     $color = Color::where('name', $name)->first();
    //     return $color->id;
    // }

    private function parseTax($name)
    {
        $tax = Tax::where('name', $name)->first();
        return $tax->id;
    }

    private function parseCategories($categories)
    {
        $categoriesArray = explode(',', trim($categories));
        $categoriesArray = array_filter($categoriesArray, fn($value) => $value !== '');
        // print '<pre>'; print_r($categoriesArray); die;
        $array = array();
        foreach($categoriesArray as $categorySingle){
            $category = Category::where('name', trim($categorySingle))->first();
            if($category){
                $array[] = $category->id;
            }
        }
        return $array;
    }

    private function parseSpecifications($specifications)
    {
        $specificationsArray = explode(',', $specifications);
        $specificationsArray = array_filter($specificationsArray, fn($value) => $value !== '');

        $array = array();
        foreach($specificationsArray as $specificationsArraySingle){
            $explode1 = explode(':', $specificationsArraySingle);
            $explode1 = array_filter($explode1, fn($value) => $value !== '');
            
            if(isset($explode1[1])){
                $explode2 = explode(' ', trim($explode1[1]));
                $explode2 = array_filter($explode2, fn($value) => $value !== '');
                if(is_array($explode2) && count($explode2) > 1){
                    $array[] = array('specification' => trim($explode1[0]), 'value' => trim($explode2[0]), 'units' => trim($explode2[1]));
                }else{
                    $array[] = array('specification' => trim($explode1[0]), 'value' => trim($explode1[1]));
                }
            }
            
        }
        
        return $array;
    }

    private function parseVariantDetails($array)
    {
        foreach ($array as $key => $arraySingle) {
            // print '<pre>';print_r($arraySingle); die;
            $array[$key]['attributes']['details'] = $this->getImportKeyValueIDS($arraySingle['attributes']);
        }
        
        return $array;
    }

    private function parsetags($tags)
    {
        $array = explode(',', $tags);
        $array = array_filter($array, fn($value) => $value !== '');
        return count($array) > 0 ? json_encode($array) : null;
    }

    private static function getImportKeyValueIDS($variantPair){
        
        $array = [];
        // print_r($variantPair);
        foreach($variantPair as $attributeName => $optionName){
            $attribute = Attribute::
            where('name', trim($attributeName))->
            first();
            $attributeOption = $attribute->options()
            ->where('name', trim($optionName))
            ->first();
            $array[] = array('attribute' => $attribute->id, 'option' => $attributeOption->id);
        }
        return $array;
        
    }

    /**
     * Define validation rules
     */
    public function rules(): array
    {
        return [
            // 'name'     => 'required|unique:products,name',
            'name'     => 'required',
        //     'sku'      => 'required|string|max:100|unique:products,sku',
        //     'price'    => 'required|numeric|min:0',
        //     'stock'    => 'required|integer|min:0',
        //     'variants' => 'nullable|string', // Additional variant validation can be added
        ];
        // return [];
    }

    /**
     * Custom validation messages
     */
    // public function customValidationMessages()
    // {
    //     return [
    //         'name.required'  => 'The product name is required.',
    //         'sku.required'   => 'The SKU is required.',
    //         'sku.unique'     => 'This SKU already exists in the database.',
    //         'price.required' => 'The price must be provided.',
    //         'stock.required' => 'Stock count is mandatory.',
    //     ];
    // }
}

