<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Categories;
use Session;
use Image;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //var_dump(\Auth::user());
        //var_dump(Auth::check());
        //var_dump(auth()->check());

        //exit;
        if(Auth::check()){
        	
        }else{
        	return redirect('/login');
        }
        parent::__construct();
    }

    function seoUrl($string) {
        $string = strtolower($string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
    
	public function index(Request $request){
		$request->user()->authorizeRoles('admin');
    	return view('admin.categories.view_category');
    }

    public function addCategory(Request $request){
    	$request->user()->authorizeRoles('admin');
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$category = new Categories;
            $category->name = $data['name'];
            $category->alias = '';
    		$category->status = 1;
    		$category->description = $data['description'];
            if($data['parent_id'] == ""){
                $category->parent_id = 0;
            }else{
                $category->parent_id = $data['parent_id'];
            }
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = str_replace(" ", "-", $data['name']).''.rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/categories/large/'.$filename;
                    $medium_image_path = 'images/categories/medium/'.$filename;
                    $small_image_path = 'images/categories/small/'.$filename;     
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                    $category->image_path = $filename;
                }
            }
    		if($category->save()){
                $category = Categories::find($category->id);
                $category->alias = $this->seoUrl(str_replace(" ", "-", $data['name'])).'-'.$category->id;
                $category->save();
				return redirect('/admin/categories')->with('success', 'Category Created Successfully');
    		}else{
				return redirect('/admin/categories/new')->with('error', 'Error cccured when creating category, kindly try again.');
    		}
    	}
    	$categoyList = Categories::pluck('name','id');
    	return view('admin.categories.add_category')->with(compact('categoyList'));
    }
	

	public function editCategory(Request $request, $id=null){
		$request->user()->authorizeRoles('admin');
		if($request->isMethod('post')){
    		$data = $request->all();
    		if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = str_replace(" ", "-", $data['name']).''.rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/categories/large/'.$filename;
                    $medium_image_path = 'images/categories/medium/'.$filename;
                    $small_image_path = 'images/categories/small/'.$filename;     
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                    //$category->image_path = $filename;
                    if($data['parent_id'] == Null){
                        $updated = Categories::where(['id'=>$id])->update(['name'=>$data['name'], 'description'=>$data['description'], 'parent_id'=>0, 'image_path'=>$filename]);
                    }else{
                        $updated = Categories::where(['id'=>$id])->update(['name'=>$data['name'], 'description'=>$data['description'], 'parent_id'=>$data['parent_id'], 'image_path'=>$filename]);    
                    }
                }
            }else{
                if($data['parent_id'] == Null){
                    $updated = Categories::where(['id'=>$id])->update(['name'=>$data['name'], 'description'=>$data['description'], 'parent_id'=>0]);
                }else{
                    $updated = Categories::where(['id'=>$id])->update(['name'=>$data['name'], 'description'=>$data['description'], 'parent_id'=>$data['parent_id']]);    
                }
            }
    		if($updated){
				return redirect('/admin/categories')->with('success', 'Category Updated Successfully');
    		}else{
				return redirect('/admin/categories')->with('error', 'Error cccured when updating category, kindly try again.');
    		}
    	}

		$categoryDetails = Categories::where(['id'=> $id])->first();
		//$categories = Category::query();
		$categoyList = Categories::pluck('name','id');
		//var_dump($categoyList);exit;
    	return view('admin.categories.edit_category')->with(compact('categoyList', 'categoryDetails'));
    }

    public function deleteCategory(Request $request, $id=null){
		//$request->user()->authorizeRoles('admin');
		if(!empty($id)){
    		$data = $request->all();
    		$deleted = Categories::where(['id'=>$id])->delete();
    		if($deleted){
				return redirect('/admin/categories')->with('success', 'Category Deleted Successfully');
    		}else{
				return redirect('/admin/categories')->with('error', 'Error cccured when deleting category, kindly try again.');
    		}
    	}

		$categoryDetails = Category::where(['id'=> $id])->first();
		//$categories = Category::query();
		$categoyList = Category::pluck('name','id');
		//var_dump($categoyList);exit;
    	return view('admin.categories.edit_category')->with(compact('categoyList', 'categoryDetails'));
    }

    public function categoryData(){
    	$categories = Categories::query();
        //return $categories;

        return Datatables::of($categories)
        		->addColumn('action', function($categories){
        			return '<a href="/admin/edit-category/'.$categories->id.'" class="btn btn-primary btn-sm">Edit</a> <a href="/admin/delete-category/'.$categories->id.'" class="btn btn-danger btn-sm">Delete</a>';
        		})
                ->addColumn('image_path', function($categories){
                    if($categories->image_path != ""){
                        return '<img src="/images/categories/small/'.$categories->image_path.'" class="datatable-img" />';
                    }else{
                       return '<img src="/images/categories/small/noimage.jpg" class="datatable-img" />'; 
                    }
                })
                ->rawColumns(['image_path', 'action'])
        		->editColumn('id', 'ID: {{$id}}')
        		->make(true);
    }

}
