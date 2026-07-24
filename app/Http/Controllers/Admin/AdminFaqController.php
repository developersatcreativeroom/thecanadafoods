<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Faq;
use App\Helper;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminFaqController extends Controller
{
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'faq';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function list(Request $request){
        $page = (int) ($request->page ?? 1);
        $page = $page > 0 ? $page : 1;
        $perPage = $this->pagerecords;

        $query = Faq::select('type', 'type_id')
            ->selectRaw('COUNT(*) as total_faqs')
            ->selectRaw('MAX(created_at) as added_on')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_count')
            ->groupBy('type', 'type_id')
            ->orderByRaw('MAX(created_at) desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $allGroups = $query->get();

        foreach ($allGroups as $group) {
            if ($group->type === 'category') {
                $entity = Category::find($group->type_id);
                $group->entity_name = $entity->name ?? '(Deleted Category)';
            } elseif ($group->type === 'blog') {
                $entity = Blog::find($group->type_id);
                $group->entity_name = $entity->title ?? '(Deleted Blog)';
            } elseif ($group->type === 'product') {
                $entity = Product::find($group->type_id);
                $group->entity_name = $entity->name ?? '(Deleted Product)';
            } else {
                $group->entity_name = '-';
            }
        }

        $currentItems = $allGroups->slice(($page - 1) * $perPage, $perPage)->values();
        $rows = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $allGroups->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(Request $request){
        $data=array();
        $categorys = Category::where('status', 1)->get();
        $data['categorys'] = $categorys;
        $blogs = Blog::where('status', 1)->get();
        $data['blogs'] = $blogs;
        $products = Product::where('status', 1)->select('id', 'name')->orderBy('name')->get();
        $data['products'] = $products;

        $type = $request->query('type');
        $type_id = $request->query('type_id');
        $data['selectedType'] = $type;
        $data['selectedTypeId'] = $type_id;

        $rows = collect();
        if(!empty($type) && !empty($type_id)){
            $rows = Faq::where('type', $type)->where('type_id', $type_id)->orderBy('serial')->orderBy('id')->get();
        }
        $data['rows'] = $rows;

        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function edit($id){
        $row = Faq::find($id);
        if($row == null){
            return to_route('admin.faqs');
        }

        return to_route('admin.faq', ['type' => $row->type, 'type_id' => $row->type_id]);
    }

    public function postData(Request $request){
        $type = trim((string) $request->input('type'));
        $type_id = trim((string) $request->input('type_id'));
        $faqs = $request->input('faqs', []);

        $validationArray = array(
            'type' => 'required',
            'type_id' => 'required',
            'faqs' => 'required|array|min:1',
            'faqs.*.question' => 'required',
            'faqs.*.answer' => 'required',
        );
        $request->validate($validationArray);

        DB::beginTransaction();
        try {
            $existingIds = Faq::where('type', $type)->where('type_id', $type_id)->pluck('id')->all();
            $submittedIds = [];

            foreach ($faqs as $index => $faqRow) {
                $id = trim((string) ($faqRow['id'] ?? ''));
                $question = trim((string) ($faqRow['question'] ?? ''));
                $answer = trim((string) ($faqRow['answer'] ?? ''));
                $status = !empty($faqRow['status']) ? 1 : 0;

                if(empty($id)){
                    $faq = Faq::create([
                        'question' => $question,
                        'answer' => $answer,
                        'type' => $type,
                        'type_id' => $type_id,
                        'status' => $status,
                        'serial' => $index,
                    ]);
                }else{
                    $faq = Faq::where('id', $id)->where('type', $type)->where('type_id', $type_id)->first();
                    if($faq){
                        $faq->question = $question;
                        $faq->answer = $answer;
                        $faq->status = $status;
                        $faq->serial = $index;
                        $faq->save();
                    }
                }

                if($faq){
                    $submittedIds[] = $faq->id;
                }
            }

            $idsToDelete = array_diff($existingIds, $submittedIds);
            if(!empty($idsToDelete)){
                Faq::whereIn('id', $idsToDelete)->delete();
            }

            DB::commit();
            Helper::flashMessage(true, 'Faqs saved successfully!');
            return to_route('admin.faq', ['type' => $type, 'type_id' => $type_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back()->withInput();
        }
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Faq::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.faqs');
        }

        $row->delete();

        if($row){
            Helper::flashMessage(true, 'Faq deleted successfully!');
            return to_route('admin.faqs');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

    public function deleteGroup(Request $request){
        $type = trim((string) $request->type);
        $type_id = trim((string) $request->type_id);

        if(empty($type) || empty($type_id)){
            return to_route('admin.faqs');
        }

        Faq::where('type', $type)->where('type_id', $type_id)->delete();

        Helper::flashMessage(true, 'Faqs deleted successfully!');
        return to_route('admin.faqs');
    }
}
