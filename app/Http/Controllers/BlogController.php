<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    /**
     * プログ一覧を表示
     *
     * @return view
     */
    public function showList()
    {
        $blogs = Blog::all();

        // dd($blogs);

        return view('blog.list',
        ['blogs' => $blogs]);
    }
     /**
     * プログ詳細を表示
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg','データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.detail',
        ['blog' => $blog]);
    }

     /**
     * プログ詳細を表示
     * 
     * @return view
     */
    public function showCreate() {
        return view('blog.form');
    }

       /**
     * プログを登録する
     * 
     * @return view
     */
    public function exeStore(BlogRequest $request) {
        // ブログのデータを受け取る
        $inputs = $request->all();

        \DB::beginTransaction();
        
        try {
            // ブログを登録
            Blog::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        
        \Session::flash('err_msg','ブログを登録しました');
            return redirect(route('blogs'));
    }
}
