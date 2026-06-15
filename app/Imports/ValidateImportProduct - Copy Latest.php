<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Tax;
use App\Models\Category;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

use App\Helper;
class ValidateImportProduct implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    // private array $relationErrorArray = [];

    // public function model(array $row)
    // {
    //     // return $rows; // Returns all rows
    // }

    public function collection(Collection $rows)
    {
        $this->data = $rows; // Store data in the class property
        // $this->relationErrorArray = []; // Store data in the class property

        // print '<pre>'; print_r($rows->toArray()); die;

        $relationErrorArray = [];
        foreach($rows as $key => $row){
            // print $key; die;
            // $row['tax'];
            // $row['brand'];
            // $row['color'];
            // $row['categories'];

            // $relationErrorArray
            $tempRelationError = array();

            $isTax = $this->validateTaxRelation($row['tax']);
            if(!$isTax){

                // if(is_array($searchedErrorRowError['value'])){
                //     $errorMessage .= '\''.ucfirst($searchedErrorRowError['attribute']).'\' does not have values ';
                //     foreach($searchedErrorRowError['value'] as $val){
                //         $errorMessage .= '\''.ucfirst($val).'\', ';
                //     }
                // }else{
                //     $errorMessage .= '\''.ucfirst($searchedErrorRowError['attribute']).'\' does not have value \''.$searchedErrorRowError['value'].'\'<br>';
                // }

                // $tempRelationError['relation_errors']['tax'] = $row['tax'];
                // $tempRelationError['relation_errors'][] = array('attribute' => 'tax', 'value' => $row['tax']);
                // $tempRelationError['errors'][] = 'The Tax does not have value '.$row['tax'];
                $relationErrorArray[] = array('errors' => ['The Tax does not have value '.$row['tax']], 'attribute' => 'tax', 'row' => $key + 2 );
            }

            $isBrand = $this->validateBrandRelation($row['brand']);
            if(!$isBrand){
                // $tempRelationError['relation_errors'][] = array('attribute' => 'brand', 'value' => $row['brand']);
                // $tempRelationError['errors'][] = 'The Brand does not have value '.$row['brand'];
                $relationErrorArray[] = array('errors' => ['The Brand does not have value '.$row['brand']], 'attribute' => 'brand', 'row' => $key + 2 );
            }

            $isColor = $this->validateColorRelation($row['color']);
            if(!$isColor){
                // $tempRelationError['relation_errors'][] = array('attribute' => 'color', 'value' => $row['color']);
                // $tempRelationError['errors'][] = 'The Color does not have value '.$row['color'];
                $relationErrorArray[] = array('errors' => ['The Color does not have value '.$row['color']], 'attribute' => 'color', 'row' => $key + 2 );
            }

            $categories = $this->validateCategoriesRelation($row['categories']);
            if(!$categories['result']){
                // $tempRelationError['relation_errors'][] = array('attribute' => 'categories', 'value' => $categories['categories']) ;
                 $message = 'The Categories does not have values ';

                foreach($categories['categories'] as $val){
                    $message .= '\''.ucfirst($val).'\', ';
                }
                // $tempRelationError['errors'][] = $message;
                $relationErrorArray[] = array('errors' => [$message], 'attribute' => 'categories', 'row' => $key + 2 );
            }

            // if(isset($tempRelationError) && count($tempRelationError) > 0){
            //     $tempRelationError['row'] = $key + 2;
            //     // $relationErrorArray[$key]['row'] = $key + 2;
            // }

            // $relationErrorArray[] = $tempRelationError;

        }

        // print '<pre>'; print_r($relationErrorArray); die;
        // if(count($relationErrorArray) > 0){

        // }
        $this->relationErrorArray = $relationErrorArray;
        // print '<pre>'; print_r($relationErrorArray); die;
        return $rows; // Returns all rows
        
    }

    // public function collection(Collection $rows)
    // {
    //     // return $rows; // Returns all rows
    // }

    public function rules(): array
    {
        return [
            'name'=>'required|unique:products,name',
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
                }
            ],
            // 'categories.*'=>'required|min:1',
            'short_description'=>'required',
            'description'=>'required',
            'tax'=>'required',
            'is_tax_included'=>'required|in:0,1',
            'brand'=>'required',
            'color'=>'required',
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
            }],
            

            'variant_prices' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $prices = explode(',', trim($value));
                        $prices = array_filter($prices, fn($value) => $value !== '');
                        // print_r($prices); die;
                        if (array_filter($prices, fn($v) => !is_numeric($v))) {
                            $fail("Variant prices must be valid numbers.");
                        }
                        $this->checkEqualVariantCounts('variant_prices', $prices, $fail);
                    }
                }
            ],

            'variant_old_prices' => [
                'nullable',
                // 'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $value = strtolower($value);  // Convert to lowercase for "na" check
                        $oldPrices = explode(',', trim($value));
                        $oldPrices = array_filter($oldPrices, fn($value) => $value !== '');
                        // print_r($oldPrices); die;
                        foreach ($oldPrices as $price) {
                            $price = trim($price);
                            if ($price !== 'na' && !is_numeric($price)) {
                                $fail("Variant old prices must be either 'na' or a valid number.");
                            }
                        }
                        $this->checkEqualVariantCounts('variant_old_prices', $oldPrices, $fail);
                    }
                }
            ],

            'variant_skus' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $skus = explode(',', trim($value));
                        $skus = array_filter($skus, fn($value) => $value !== '');
                        // print_r($skus); die;
                        if (count($skus) !== count(array_unique($skus))) {
                            $fail("Variant SKUs must be unique.");
                        }
                        $this->checkEqualVariantCounts('variant_skus', $skus, $fail);
                    }
                }
            ],

            'variant_stocks' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $stocks = explode(',', trim($value));
                        $stocks = array_filter($stocks, fn($value) => $value !== '');
                        if (array_filter($stocks, fn($v) => !is_numeric($v))) {
                            $fail("Variant stocks must be valid numbers.");
                        }
                        $this->checkEqualVariantCounts('variant_stocks', $stocks, $fail);
                    }
                }
            ],

            'variant_thresholds' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $thresholds = explode(',', trim($value));
                        $thresholds = array_filter($thresholds, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_thresholds', $thresholds, $fail);
                    }
                }
            ],

            'variant_lengths' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $lengths = explode(',', trim($value));
                        $lengths = array_filter($lengths, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_lengths', $lengths, $fail);
                    }
                }
            ],

            'variant_widths' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $widths = explode(',', trim($value));
                        $widths = array_filter($widths, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_widths', $widths, $fail);
                    }
                }
            ],

            'variant_heights' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $heights = explode(',', trim($value));
                        $heights = array_filter($heights, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_heights', $heights, $fail);
                    }
                }
            ],

            'variant_weights' => [
                // 'nullable',
                'required_if:is_variant,1', 
                function ($attribute, $value, $fail) {
                    if ($this->currentRowData['is_variant'] == 1) {
                        $weights = explode(',', trim($value));
                        $weights = array_filter($weights, fn($value) => $value !== '');
                        $this->checkEqualVariantCounts('variant_weights', $weights, $fail);
                    }
                }
            ],

            'price' => 'required_if:is_variant,0',
            'old_price' => 'nullable|gt:price',
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
            // 'specifications' => 'array',
            // 'specifications' => '',
            // 'specifications.*.specification' => 'required_with:specifications.*.value',
            // 'specifications.*.value' => 'required_with:specifications.*.specification',
            // 'specifications.*.units' => '',
            'specifications' => [
                'nullable',
                function ($attribute, $value, $fail) {
                // $this->validateSpecificationsFormat($attribute, $value, $fail);
                    $specs = explode(',', trim($value));
                    $specs = array_filter($specs, fn($value) => $value !== '');
                    // print_r($specs); die;
                    foreach ($specs as $spec) {
                        $spec = trim($spec);
                        if (!preg_match('/^[a-zA-Z0-9\s]+:[a-zA-Z0-9\s]+$/', $spec)) {
                            $fail("Invalid specification format in '{$spec}'. Expected format: `Size:Large` or `Width:10 cm`.");
                        }
                    }
                }],
            
            'status'=>'required',
            
        ];
        // die;

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
        
        // print '<pre>'; print_r($value); die;

        $groups = explode(',', $value);
        
        $attributePatterns = [];

        foreach ($groups as $group) {
            $attributes = explode(' ', trim($group));
            $pattern = [];

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

    private function validateSpecificationsFormat($attribute, $value, $fail)
    {
        if (!$value) return;
        
        // print '<pre>'; print_r($value); die;

        $groups = explode(',', trim($value));
        // print '<pre>'; print_r($groups); die;
        

        foreach ($groups as $k => $group) {
            $specifications = explode(' ', trim($group));
            
            // print '<pre>'; print $k; print_r($specifications);

            foreach ($specifications as $specification) {
                // if (!str_contains($specification, ':')) {
                //     return $fail("Invalid format in variants. Expected 'Key:Value' pairs.");
                // }
                $units = '';
                if (!str_contains($specification, ':')) {
                    $units = $specification;
                }

                if (str_contains($specification, ':')) {
                    [$specification, $value] = explode(':', $specification, 2);
                }
            }

        }

    }

    private $currentRowData;

    public function prepareForValidation($data)
    {
        $this->currentRowData = $data; // Store current row for validation functions
        return $data;
    }


    private function checkEqualVariantCounts($field, $values, $fail)
    {
        $variantCount = count(explode(',', $this->currentRowData['variants'] ?? ''));

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

    private function validateColorRelation($name)
    {
        $count = Color::where('name', $name)->count();
        return ($count > 0) ? true : false;
    }

    private function validateCategoriesRelation($categories)
    {
        $categoriesArray = explode(',', $categories);
        $array = array();
        $flag = true;
        foreach($categoriesArray as $categorySingle){
            $count = Category::where('name', trim($categorySingle))->count();
            if($count <= 0){
                $flag = false;
                $array[] = $categorySingle;
            }
        }
        // return $array;
        // print_r($array); die;
        return array('result' => $flag, 'categories' => $array);
        

    }


}
