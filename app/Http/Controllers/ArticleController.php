<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Eventviva\ImageResize;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $article;
    protected $image1 = '';

    public function __construct()
    {
        $this->article = new Article();
    }

    public function index(Request $request)
    {
        $data['title'] = 'บทความ';
        $data['topic'] = $request->input('topic');

        $article = $this->article->where('id', '<>', '');
        if ($data['topic']) {
            $article->where('topic', $data['topic']);
        }
        $data['article'] = $article->orderBy('creation_date')->get();
        return view('article.list', $data);
    }

    public function add($id = null)
    {
        $data = array('id' => $id, 'topic' => '', 'detail' => '', 'pic1' => '');
        $data['title'] = 'เพิ่มบทความ';
        $data['description'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';

        if ($id) {
            $article = $this->article->where('id', $id)->get();
            foreach ($article as $row) {
                $data['topic'] = $row->topic;
                $data['detail'] = $row->detail;
                $data['pic1'] = $row->pic1;
            }
        }

        return view('article.add', $data);
    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $topic = $request->input('topic');
        $detail = $request->input('detail');
        $pic1 = $request->file('pic1');
        $pic1_val = $request->input('pic1_val');
        $running = 'article' . rand(1111111111, 9999999999);

        if ($pic1_val) {
            $this->image1 = $pic1_val;
        }

        if (!empty($pic1)) {
            $this->image1 = new ImageResize($pic1);
            $this->image1->resize(150, 100);
            $this->image1->save(env("THUMBNAIL_PATH") . $running . '.jpg');
            $this->image1->resize(600, 400);
            $this->image1->save(env("IMAGE_PATH") . $running . '.jpg');
            $this->image1 = $running . '.jpg';
        }

        try {
            if (!$id) { // Insert
                $this->article->insertGetId([
                    'topic' => $topic,
                    'detail' => $detail,
                    'pic1' => $this->image1,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);
            } else { // Update
                $this->article->where('id', $id)->update([
                    'topic' => $topic,
                    'detail' => $detail,
                    'pic1' => $this->image1,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);
            }

            return redirect('article/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function remove($id = null)
    {
        try {
            $this->article->where('id', $id)->delete();
            return redirect('article/list');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}