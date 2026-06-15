<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Tax;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeOption;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

use Illuminate\Validation\Rule;

use App\Helper;
class ValidateImportProduct implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    // public function model(array $row)
    // {
    //     // return $rows; // Returns all rows
    // }

    public function collection(Collection $rows)
    {
        $this->data = $rows; // Store data in the class property

        // $relationErrorArray = [];
        // foreach($rows as $key => $row){
            
        //     $isTax = $this->validateTaxRelation($row['tax']);
        //     if(!$isTax){
        //         $relationErrorArray[] = array('errors' => ['The Tax does not have value '.$row['tax']], 'attribute' => 'tax', 'row' => $key + 2 );
        //     }

        //     $isBrand = $this->validateBrandRelation($row['brand']);
        //     if(!$isBrand){
        //         $relationErrorArray[] = array('errors' => ['The Brand does not have value '.$row['brand']], 'attribute' => 'brand', 'row' => $key + 2 );
        //     }

        //     $isColor = $this->validateColorRelation($row['color']);
        //     if(!$isColor){
        //         $relationErrorArray[] = array('errors' => ['The Color does not have value '.$row['color']], 'attribute' => 'color', 'row' => $key + 2 );
        //     }

        //     $categories = $this->validateCategoriesRelation($row['categories']);
        //     if(!$categories['result']){
        //          $message = 'The Categories does not have value(s) ';

        //         foreach($categories['categories'] as $val){
        //             $message .= '\''.ucfirst($val).'\', ';
        //         }
        //         $relationErrorArray[] = array('errors' => [$message], 'attribute' => 'categories', 'row' => $key + 2 );
        //     }

        // }
        // $this->relationErrorArray = $relationErrorArray;
        
        return $rows; // Returns all rows
        
    }

    // public function collection(Collection $rows)
    // {
    //     // return $rows; // Returns all rows
    // }

    public function rules(): array
    {
        return [
            // 'name'=>'required|unique:products,name',
            'name'=>'required',
            // 'categories'=>'required|array',
            'categories' => [
                'required',
                function ($attribute, $value, $fail) {
                    $categories = array_map('trim', explode(',', trim($value)));
                    $categories = array_filter($categories, fn($value) => $value !== '');
                    // print_r($categories); die;
                    if (empty($categories)) {
                        $fail("Categories cannot be empty.");
                    }

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    $categoriesRelation = $this->validateCategoriesRelation($this->currentRowData[$rowIndex]['categories']);
                    if(!$categoriesRelation['result']){
                        $message = "The Categories does not have value(s) ";
                        foreach($categoriesRelation['categories'] as $val){
                            $message .= "'".ucfirst(trim($val))."', ";
                        }
                        $message = rtrim($message, ", ");
                        $fail($message);
                    }

                }
            ],
            // 'categories.*'=>'required|min:1',
            'short_description'=>'required',
            'description'=>'required',
            'tax' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    $isTax = $this->validateTaxRelation($this->currentRowData[$rowIndex]['tax']);
                    if(!$isTax){
                        // $relationErrorArray[] = array('errors' => ['The Tax does not have value '.$this->currentRowData['tax']], 'attribute' => 'tax', 'row' => $key + 2 );
                        $fail("The Tax does not have value '".$this->currentRowData[$rowIndex]['tax']."'");
                    }
                }
            ],
            'is_tax_included'=>'required|in:0,1',
            'brand' => [
                'required',
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;


                    $isBrand = $this->validateBrandRelation($this->currentRowData[$rowIndex]['brand']);
                    if(!$isBrand){
                        $fail("The Brand does not have value '".$this->currentRowData[$rowIndex]['brand']."'");
                    }
                }
            ],
            // 'color' => [
            //     'required',
            //     function ($attribute, $value, $fail) {

            //         // Extract row index from the attribute (e.g., "2.some_column" → row 2)
            //         $rowIndex = explode('.', $attribute)[0] - 2;


            //         $isColor = $this->validateColorRelation($this->currentRowData[$rowIndex]['color']);
            //         if(!$isColor){
            //             $fail("The Color does not have value '".$this->currentRowData[$rowIndex]['color']."'");
            //         }
            //     }
            // ],
            'is_featured'=>'required|in:0,1',
            'is_sample'=>'required|in:0,1',
            'is_sale'=>'required|in:0,1',
            'is_new'=>'required|in:0,1',
            'is_hot'=>'required|in:0,1',
            'is_best_sell'=>'required|in:0,1',

            'is_variant'=>'required|in:0,1',
            'variants' => [
                // 'nullable',
                'required_if:is_variant,1',
                function ($attribute, $value, $fail) {
                $this->validateVariantsFormat($attribute, $value, $fail);
                
                $rowIndex = explode('.', $attribute)[0] - 2;

                $categoriesRelation = $this->validateVariantsRelation($this->currentRowData[$rowIndex]['variants']);
                // print '<pre>'; print_r($categoriesRelation); die;
                if(!$categoriesRelation['result']){
                    // $message = "The Variants have following error(s) ";
                    $message = "";
                    if(count($categoriesRelation['attributes']) > 0){
                        $message .= "Attribute does not have value(s) ";
                        foreach($categoriesRelation['attributes'] as $attribute){
                            $message .= "'".ucfirst(trim($attribute))."', ";
                        }
                        $message = rtrim($message, ", ");
                        $message .= "<br>";
                    }
                    
                    if(count($categoriesRelation['options']) > 0){
                        $message .= "Attribute option does not have value(s) ";
                        foreach($categoriesRelation['options'] as $option){
                            $message .= "'".ucfirst(trim($option))."', ";
                        }
                        $message = rtrim($message, ", ");
                    }
                    // print_r('--'.$message.'--'); die;
                    $fail($message);
                }
            }
        ],
            

            'variant_prices' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;


                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $prices = explode(',', trim($value));
                        $prices = array_filter($prices, fn($value) => $value !== '');
                        // print_r($prices); die;
                        if (array_filter($prices, fn($v) => !is_numeric($v))) {
                            $fail("Variant prices must be valid numbers.");
                        }
                        $this->checkEqualVariantCounts('variant_prices', $prices, $fail, $rowIndex);
                    }
                }
            ],

            'variant_old_prices' => [
                'nullable',
                // 'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $value = strtolower($value);  // Convert to lowercase for "na" check
                        $oldPrices = explode(',', trim($value));
                        $oldPrices = array_filter($oldPrices, fn($value) => $value !== '');
                        // print_r($oldPrices); die;

                        $pricesVal = $this->currentRowData[$rowIndex]['variant_prices'];
                        $prices = explode(',', trim($pricesVal));
                        $prices = array_filter($prices, fn($value) => $value !== '');
                        // print_r($prices); die;
                        
                        foreach ($oldPrices as $k => $oldPrice) {
                            $oldPrice = trim($oldPrice);
                            $price = trim($prices[$k]);
                            if ($oldPrice !== 'na' && !is_numeric($oldPrice)) {
                                $fail("Variant old prices must be either 'na' or a valid number.");
                            }elseif (((float) $oldPrice <= (float) $price) && $oldPrice !== 'na'  && is_numeric($oldPrice)) {
                                $fail("Variant old price ({$oldPrice}) must be greater than the corresponding variant price ({$price}).");
                            }
                        }
                        $this->checkEqualVariantCounts('variant_old_prices', $oldPrices, $fail, $rowIndex);
                    }
                }
            ],

            'variant_skus' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $skus = explode(',', trim($value));
                        $skus = array_filter($skus, fn($value) => $value !== '');
                        // print_r($skus); die;
                        if (count($skus) !== count(array_unique($skus))) {
                            $fail("Variant SKUs must be unique.");
                        }
                        $this->checkEqualVariantCounts('variant_skus', $skus, $fail, $rowIndex);
                    }
                }
            ],

            'variant_stocks' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $stocks = explode(',', trim($value));
                        $stocks = array_filter($stocks, fn($value) => $value !== '');
                        if (array_filter($stocks, fn($v) => !is_numeric($v))) {
                            $fail("Variant stocks must be valid numbers.");
                        }
                        $this->checkEqualVariantCounts('variant_stocks', $stocks, $fail, $rowIndex);
                    }
                }
            ],

            'variant_thresholds' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $thresholds = explode(',', trim($value));
                        $thresholds = array_filter($thresholds, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_thresholds', $thresholds, $fail, $rowIndex);
                    }
                }
            ],

            'variant_lengths' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $lengths = explode(',', trim($value));
                        $lengths = array_filter($lengths, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_lengths', $lengths, $fail, $rowIndex);
                    }
                }
            ],

            'variant_widths' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $widths = explode(',', trim($value));
                        $widths = array_filter($widths, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_widths', $widths, $fail, $rowIndex);
                    }
                }
            ],

            'variant_heights' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;

                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $heights = explode(',', trim($value));
                        $heights = array_filter($heights, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_heights', $heights, $fail, $rowIndex);
                    }
                }
            ],

            'variant_weights' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {

                    // Extract row index from the attribute (e.g., "2.some_column" → row 2)
                    $rowIndex = explode('.', $attribute)[0] - 2;
                    
                    if ($this->currentRowData[$rowIndex]['is_variant'] == 1) {
                        $weights = explode(',', trim($value));
                        $weights = array_filter($weights, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_weights', $weights, $fail, $rowIndex);
                    }
                }
            ],

            'price' => 'required_if:is_variant,0|numeric|nullable',
            'old_price' => ['nullable', 'numeric', function ($attribute, $value, $fail) {
                $rowIndex = explode('.', $attribute)[0] - 2;
                
                if ($value <= floatval($this->currentRowData[$rowIndex]['price'])) {
                    $fail('The old price must be greater than the price.');
                }
            }],
            'sku' => 'required_if:is_variant,0',
            'stock' => 'required_if:is_variant,0',
            'threshold' => '',
            'length' => '',
            'width' => '',
            'height' => '',
            'weight' => '',

            'seo_title'=>'',
            'seo_description'=>'',
            'seo_keywords'=>'',
            // 'tags'=>'array',
            'tags' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $tags = array_map('trim', explode(',', trim($value)));
                    if (count($tags) !== count(array_unique($tags))) {
                        $fail("Tags must be unique.");
                    }
                }
            ],
            
            'specifications' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $specs = explode(',', trim($value));
                    $specs = array_filter($specs, fn($value) => $value !== '');
                    foreach ($specs as $spec) {
                        $spec = trim($spec);
                        if (!preg_match('/^[a-zA-Z0-9\s]+:[a-zA-Z0-9\s]+$/', $spec)) {
                            $fail("Invalid specification format in '{$spec}'. Expected format: `Size:Large` or `Width:10 cm`.");
                        }
                    }
                }],
            
            'status'=>'required',
            
        ];

    }


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


    private function validateVariantsFormat($attribute, $value, $fail)
    {
        if (!$value) return;
        
        $groups = explode(',', $value);
        
        $attributePatterns = [];
        // print '<pre>'; print_R($groups);
        foreach ($groups as $group) {
            $attributes = explode('|', trim($group));
            $pattern = [];
            // print '<pre>'; print_R($attributes); die;
            foreach ($attributes as $attr) {
                if (!str_contains($attr, ':')) {
                    return $fail("Invalid format in variants. Expected 'Key:Value' pairs.");
                }

                [$key, $val] = explode(':', $attr, 2);
                $pattern[] = trim($key);
            }

            $attributePatterns[] = implode('|', $pattern);
        }

        if (count(array_unique($attributePatterns)) > 1) {
            return $fail("All attribute groups in 'variants' must follow the same attribute order.");
        }
    }


    private $currentRowData = array();

    public function prepareForValidation($data)
    {
        // print '<pre>'; print_r($data);
        $this->currentRowData[] = $data; // Store current row for validation functions
        return $data;
    }


    private function checkEqualVariantCounts($field, $values, $fail, $rowIndex)
    {
        $variantCount = count(explode(',', $this->currentRowData[$rowIndex]['variants'] ?? ''));

        if (count($values) !== $variantCount) {
            $fail("The number of values in {$field} must match the number of variants ({$variantCount}).");
        }
    }

    private function validateTaxRelation($name)
    {
        $count = Tax::where('name', $name)->count();
        return ($count > 0) ? true : false;
    }

    private function validateBrandRelation($name)
    {
        $count = Brand::where('name', $name)->count();
        return ($count > 0) ? true : false;
    }

    // private function validateColorRelation($name)
    // {
    //     $count = Color::where('name', $name)->count();
    //     return ($count > 0) ? true : false;
    // }

    private function validateCategoriesRelation($categories)
    {
        $categoriesArray = explode(',', trim($categories));
        $categoriesArray = array_filter($categoriesArray, fn($value) => $value !== '');
        // print_r($categoriesArray); die;
        $array = array();
        $flag = true;
        foreach($categoriesArray as $categorySingle){
            $count = Category::where('name', trim($categorySingle))->count();
            if($count <= 0){
                $flag = false;
                $array[] = $categorySingle;
            }
        }

        return array('result' => $flag, 'categories' => $array);

    }

    private function validateVariantsRelation($variants)
    {
        // print '<pre>'; print_r($variants); die;
        $variantsArray = explode(',', trim($variants));
        $variantsArray = array_filter($variantsArray, fn($value) => $value !== '');
        // print_r($variantsArray); die;
        $attributesArray = array();
        $optionsArray = array();
        $attrbuteFlag = true;
        $optionFlag = true;
        foreach($variantsArray as $variantsArraySingle){
            // print_r($variantsArraySingle); die;
            // [$attrbute, $option] = explode(':', $variantsArraySingle, 2);
            [$attrbute, $option] = array_map('trim', explode(':', $variantsArraySingle, 2));
            // print_r($option); die;
            $attrbuteCount = Attribute::where('name', trim($attrbute))->count();
            if($attrbuteCount <= 0){
                $attrbuteFlag = false;
                $attributesArray[] = trim($attrbute);
            }
            $attributesArray = array_unique($attributesArray);
            $optionCount = AttributeOption::where('name', trim($option))->count();
            if($optionCount <= 0){
                $optionFlag = false;
                $optionsArray[] = trim($option);
            }
            $optionsArray = array_unique($optionsArray);
        }
        return array('result' => $attrbuteFlag == true ? ($optionFlag == true ? true : false) : false, 'attributes' => $attributesArray, 'options' => $optionsArray);

    }


}