<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProduct implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Product::all();
        // $products = Product::with('attributes')->get();

        $products = Product::select('products.*','brands.name as brand_name', 'taxes.name as tax_name', 'colors.name as color_name')->with(['categories' => function($query){
            $query->select('product_categories.product_id','product_categories.category_id','categories.name')->leftjoin('categories', 'categories.id','=','product_categories.category_id');
        },'attributes.details' => function($query){
            $query->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_option_name');
            $query->join('attributes', 'attributes.id', '=', 'product_attribute_details.attribute_id');
            $query->join('attribute_options', 'attribute_options.id', '=', 'product_attribute_details.attribute_option_id');
        },'specifications'])
        ->leftjoin('brands', 'brands.id','=','products.brand_id')
        ->leftjoin('taxes','taxes.id','=','products.tax_id')
        ->leftjoin('colors','colors.id','=','products.color_id')
        ->get();

        // print '<pre>'; print_R($products->toArray()); die;

        $abc = $products->map(function ($product) {
            return [
                'Name' => $product->name,
                'Short Description' => $product->short_description,
                'Description' => $product->description,
                // 'Image' => $product->image,
                // 'Hover Image' => $product->hover_image,
                
                'Tax' => $product->tax_name,

                'Is Tax Included' => $product->is_tax_included ? '1' : '0',
                'Brand' => $product->brand_name,
                'Color' => $product->color_name,
                'Is Featured' => $product->is_featured ? '1' : '0',
                'Is Sample' => $product->is_sample ? '1' : '0',
                'Is Sale' => $product->is_sale ? '1' : '0',
                'Is New' => $product->is_new ? '1' : '0',
                'Is Hot' => $product->is_hot ? '1' : '0',
                'Is Best Sell' => $product->is_best_sell ? '1' : '0',
                'Is Variant' => $product->is_variant ? '1' : '0',

                // non variant data starts
                'Price' => $product->price,
                'Old Price' => $product->old_price,
                'SKU' => $product->sku,
                'Stock' => $product->stock,
                'Threshold' => $product->threshold,
                'Length' => $product->length,
                'Width' => $product->width,
                'Height' => $product->height,
                'Weight' => $product->weight,
                // non variant data ends

                // variant data starts
                
                // 'Variants' => $product->attributes->pluck('name')->implode(', '), // Combine variants in one column

                'Variants' => $product->attributes->map(function ($row) {
                    return $row->details->map(function ($row1) {
                        return $row1->attribute_name.':'.$row1->attribute_option_name ?? 'na';
                    })->implode(' ');
                })->implode(', '),

                'Variant Prices' => $product->attributes->map(function ($row) {
                    return $row->price ?? 'na';
                })->implode(', '),

                'Variant Old Prices' => $product->attributes->map(function ($row) {
                    return $row->old_price ?? 'na';
                })->implode(', '),

                'Variant SKUs' => $product->attributes->map(function ($row) {
                    return $row->sku ?? 'na';
                })->implode(', '),

                'Variant Stocks' => $product->attributes->map(function ($row) {
                    return $row->stock ?? 'na';
                })->implode(', '),

                'Variant Thresholds' => $product->attributes->map(function ($row) {
                    return $row->threshold ?? 'na';
                })->implode(', '),

                'Variant Lengths' => $product->attributes->map(function ($row) {
                    return $row->length ?? 'na';
                })->implode(', '),

                'Variant Widths' => $product->attributes->map(function ($row) {
                    return $row->width ?? 'na';
                })->implode(', '),

                'Variant Heights' => $product->attributes->map(function ($row) {
                    return $row->height ?? 'na';
                })->implode(', '),

                'Variant Weights' => $product->attributes->map(function ($row) {
                    return $row->weight ?? 'na';
                })->implode(', '),

                // 'Variant Prices' => $product->attributes->map(function ($row) {
                //     // return $row->attribute_name.':'.$row->attribute_option_name;
                //     return $row->details->map(function ($row1) {
                //         return $row1->attribute_name.':'.$row1->attribute_option_name;
                //     });
                // }),

                // 'Variants' => $product->attributes->pluck('name')->implode(', '),
                                

                'Categories' => $product->categories->pluck('name')->implode(', '),
                // 'Specifications' => $product->specifications->pluck('name')->implode(', '),
                'Specifications' => $product->specifications->map(function ($row) {
                    return $row->specification.':'.$row->value.' '.$row->units;
                })->implode(', '),

                // 'Tags' => $product->tags,
                'Tags' => ($product->tags != null) ? collect(json_decode($product->tags))->map(function ($row) {
                    return $row;
                })->implode(', ') : '',
                'Seo Title' => $product->seo_title,
                'Seo Description' => $product->seo_description,
                'Seo Keywords' => $product->seo_keywords,
                'Status' => $product->status,
                'Slug' => $product->slug,
                'Link' => route('product', $product->slug),
                
                
                // 'Variants' => $product->attributes->pluck('name')->implode(', '), // Combine variants in one column
                // 'Variant SKUs' => $product->attributes->pluck('sku')->implode(', '),
                // 'Variant Prices' => $product->attributes->pluck('price')->implode(', '),
            ];
        });

        // print '<pre>'; print_R($abc); die;

        return $abc;

    }

    public function headings(): array
    {
        return [

            "Name *",
            "Short Description *",
            "Description *",
            // "Image",
            // "Hover Image",
            "Tax *",
            "Is Tax Included",
            "Brand *",
            "Color *",
            "Is Featured",
            "Is Sample",
            "Is Sale",
            "Is New",
            "Is Hot",
            "Is Best Sell",
            "Is Variant",
            "Price *",
            "Old Price",
            "SKU *",
            "Stock *",
            "Threshold",
            "Length",
            "Width",
            "Height",
            "Weight",
            "Variants *",
            "Variant Prices *",
            "Variant Old Prices *",
            "Variant SKUs *",
            "Variant Stocks *",
            "Variant Thresholds",
            "Variant Lengths",
            "Variant Widths",
            "Variant Heights",
            "Variant Weights",
            "Categories *",
            "Specifications",
            "Tags",
            "Seo Title",
            "Seo Description",
            "Seo Keywords",
            "Status *",
            "Slug",
            "Link",
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (headers)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'], // White text
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '217346'], // Blue background
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],
        ];
    }
}
