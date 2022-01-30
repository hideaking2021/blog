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

    /**
     * プログフォーム詳細を表示
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg','データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.edit',
        ['blog' => $blog]);
    }

       /**
     * プログを登録する
     * 
     * @return view
     */
    public function exeUpdate(BlogRequest $request) {
        // ブログのデータを受け取る
        $inputs = $request->all();


        \DB::beginTransaction();
        
        try {
            // ブログを更新する
            $blog = Blog::find($inputs
            ['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content']
            ]);
            $blog->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        
        \Session::flash('err_msg','ブログを更新しました');
            return redirect(route('blogs'));
    }

    /**
     * プログ削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id)
    {

        if (empty($id)) {
            \Session::flash('err_msg','データがありません。');
            return redirect(route('blogs'));
        }
        
        try {
            // ブログを登録
            Blog::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }
        
        \Session::flash('err_msg','データがありません。');
        return redirect(route('blogs'));
    }

}
