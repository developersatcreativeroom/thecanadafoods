<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;

use App\Models\Category;
use App\Models\ProductCategory;
//use Hamcrest\Core\SetTest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Helper;
use Session;
use DB;
use Mail;
use Hash;
use Image;


class CategoryController extends Controller implements HasMiddleware
{
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'category';

    public function __construct()
    {
        // $this->middleware('admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    public function list(Request $request)
    {
        //$page = isset($request->page) ? $request->page : 1;
        $page = $request->page;

        $rows = Category::paginate($this->pagerecords, ['*'], 'page', $page);
        $data = array('rows' => $rows);
        return view($this->prefix . '.' . $this->folder . '.list')->with($data);
    }

public function add()
{
    $categories = Helper::getCategories();

    // Get all categories ordered by priority
    $priorityCategories = Category::orderBy('priority', 'asc')->get();

    // Next available priority
    $maxPriority = $priorityCategories->count() + 1;

    return view($this->prefix . '.' . $this->folder . '.form', [
        'categories'         => $categories,
        'priorityCategories' => $priorityCategories,
        'maxPriority'        => $maxPriority,
    ]);
}

public function edit($id)
{
    $row = Category::findOrFail($id);

    $categories = Helper::getCategories();

    // Get all categories ordered by priority
    $priorityCategories = Category::orderBy('priority', 'asc')->get();

    // Total priority options
    $maxPriority = $priorityCategories->count();

    return view($this->prefix . '.' . $this->folder . '.form', [
        'row'                => $row,
        'categories'         => $categories,
        'priorityCategories' => $priorityCategories,
        'maxPriority'        => $maxPriority,
    ]);
}
    // public function add()
    // {
    //     $categories = Helper::getCategories();
    //     $data = array('categories' => $categories);
    //     return view($this->prefix . '.' . $this->folder . '.form')->with($data);
    // }
    // public function edit($id)
    // {
    //     $row = Category::where('id', $id)->first();
    //     $categories = Helper::getCategories();
    //     $data = array('row' => $row, 'categories' => $categories);
    //     return view($this->prefix . '.' . $this->folder . '.form')->with($data);
    // }
    // public function postData(Request $request)
    // {
    //     $id = trim($request->input('id'));
    //     $name = trim($request->input('name'));
    //     $title_h1 = trim($request->input('title_h1'));
    //     $slug = trim($request->input('slug'));
    //     $short_description = trim($request->input('short_description'));
    //     $description = trim($request->input('description'));
    //     $categoryID = $request->input('parent_category_id') ? $request->input('parent_category_id') : null;
    //     $imageAlt = trim($request->input('image_alt'));
    //     $image = $request->file('image');
    //     $status = trim($request->input('status'));

    //     if ($categoryID != null) {
    //         $categoryDetails = Category::find($categoryID);
    //         if ($categoryDetails) {
    //             $level = $categoryDetails->level;
    //         } else {
    //             $level = 1;
    //         }
    //         $level++;
    //     } else {
    //         $level = 0;
    //     }

    //     //print $level; die;
    //     //die;

    //     $validationArray = array(
    //         'image' => 'image|mimes:jpeg,jpg,png,webp',
    //         'status' => 'required|boolean'
    //     );

    //     if (empty($id)) {
    //         //$validationArray['name'] = 'required|unique:categories,name,';  
    //         $validationArray['name'] = 'required|unique:categories,name,NULL,id,deleted_at,NULL';
    //         $validationArray['image'] = 'required|mimes:jpeg,jpg,png,webp';
    //     } else {
    //         //$validationArray['name'] = 'required|unique:categories,name,'.$id;
    //         $validationArray['name'] = 'required|unique:categories,name,' . $id . ',id,deleted_at,NULL';
    //         $validationArray['slug'] = 'required|alpha_dash|unique:categories,slug,' . $id;
    //         $validationArray['image'] = 'mimes:jpeg,jpg,png,webp';
    //     }

    //     $request->validate($validationArray);


    //     if (empty($id)) {
    //         $category = Category::create(['name' => $name, 'title_h1' => $title_h1,  'parent_category_id' => $categoryID, 'description' => $description, 'short_description' => $short_description, 'image_alt' => $imageAlt, 'level' => $level, 'status' => $status, 'is_approved' => true]);
    //     } else {
    //         $category = Category::find($id);
    //         $category->name = $name;
    //         $category->title_h1 = $title_h1;
    //         $category->slug = $slug;
    //         $category->parent_category_id = $categoryID;
    //         $category->short_description = $short_description;
    //         $category->description = $description;
    //         $category->image_alt = $imageAlt;
    //         $category->level = $level;
    //         $category->status = $status;
    //         $category->save();
    //     }

    //     $operation = empty($id) ? 'add' : 'update';

    //     if (isset($image)) {
    //         // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
    //         Helper::uploadImage($image, $category, 'categories', true, $operation, 'image', true, true, true, false);
    //     }

    //     if ($category) {
    //         Helper::flashMessage(true, 'Category added/updated successfully!');
    //         return to_route('admin.categories');
    //     } else {
    //         Helper::flashMessage(false, 'Something went wrong');
    //         return redirect()->back();
    //     }
    // }

 public function postData(Request $request)
{
    $id = trim($request->input('id'));
    $name = trim($request->input('name'));
    $title_h1 = trim($request->input('title_h1'));
    $slug = trim($request->input('slug'));
    $short_description = trim($request->input('short_description'));
    $description = trim($request->input('description'));
    $categoryID = $request->input('parent_category_id') ?: null;
    $imageAlt = trim($request->input('image_alt'));
    $image = $request->file('image');
    $status = $request->input('status');
    $priority = $request->input('priority');

    if ($categoryID) {
        $parentCategory = Category::find($categoryID);
        $level = $parentCategory ? ($parentCategory->level + 1) : 1;
    } else {
        $level = 0;
    }

    $validationArray = [
        'name' => 'required',
        'title_h1' => 'nullable|string|max:255',
        'slug' => 'required|alpha_dash',
        'parent_category_id' => 'nullable|exists:categories,id',
        'short_description' => 'nullable',
        'description' => 'nullable',
        'image_alt' => 'nullable|string|max:255',
        'priority' => 'required|integer|min:1',
        'status' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpeg,jpg,png,webp',
    ];

    if (empty($id)) {
        $validationArray['name'] = 'required|unique:categories,name,NULL,id,deleted_at,NULL';
        $validationArray['slug'] = 'required|alpha_dash|unique:categories,slug,NULL,id,deleted_at,NULL';
        $validationArray['priority'] = 'required|integer|min:1|unique:categories,priority,NULL,id,deleted_at,NULL';
        $validationArray['image'] = 'required|image|mimes:jpeg,jpg,png,webp';
    } else {
        $validationArray['name'] = 'required|unique:categories,name,' . $id . ',id,deleted_at,NULL';
        $validationArray['slug'] = 'required|alpha_dash|unique:categories,slug,' . $id . ',id,deleted_at,NULL';
        $validationArray['priority'] = 'required|integer|min:1|unique:categories,priority,' . $id . ',id,deleted_at,NULL';
    }

    $request->validate($validationArray);

    if (empty($id)) {

        $category = Category::create([
            'name' => $name,
            'title_h1' => $title_h1,
            'slug' => $slug,
            'parent_category_id' => $categoryID,
            'short_description' => $short_description,
            'description' => $description,
            'image_alt' => $imageAlt,
            'level' => $level,
            'priority' => $priority,
            'status' => $status,
            'is_approved' => true,
        ]);

    } else {

        $category = Category::findOrFail($id);

        $category->name = $name;
        $category->title_h1 = $title_h1;
        $category->slug = $slug;
        $category->parent_category_id = $categoryID;
        $category->short_description = $short_description;
        $category->description = $description;
        $category->image_alt = $imageAlt;
        $category->level = $level;
        $category->priority = $priority;
        $category->status = $status;

        $category->save();
    }

    $operation = empty($id) ? 'add' : 'update';

    if ($image) {
        Helper::uploadImage(
            $image,
            $category,
            'categories',
            true,
            $operation,
            'image',
            true,
            true,
            true,
            false
        );
    }

    Helper::flashMessage(true, 'Category added/updated successfully!');

    return redirect()->route('admin.categories');
}

    public function delete(Request $request)
    {
        $id = trim($request->id);
        $row = Category::find($id);
        //print 'a'; die;
        if (!$row) {
            return to_route('admin.categories');
        }

        $productCount = ProductCategory::where('category_id', $row->id)->count();
        if ($productCount > 0) {
            Helper::flashMessage(false, 'Product(s) added to the category, please remove prooduct from the category first');
            return redirect()->back();
        }

        $row->delete();

        if ($row) {
            Helper::flashMessage(true, 'Category deleted successfully!');
            return to_route('admin.categories');
        } else {
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'id'  => 'required|exists:categories,id',
            'col' => 'required|in:is_main_nav,is_top,is_trending',
        ]);

        $category = Category::findOrFail($request->id);

        $column = $request->col;

        $category->$column = !$category->$column;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $column)) . ' status updated successfully.',
            'status'  => (bool) $category->$column,
            'column'  => $column,
        ]);
    }
}
