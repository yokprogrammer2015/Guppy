<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Eventviva\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    private $article;
    protected $image1 = '';
    protected $setData = [];

    public function __construct()
    {
        $this->article = new Article();
    }

    public function index(Request $request)
    {
        $data['title'] = 'บทความเกี่ยวกับปลาหางนกยูง';
        $data['keywords'] = 'วิธีการเลี้ยงปลาหางนกยูง, สายพันธุ์ปลาหางนกยูง, การอนุบาลลูกปลา, คัดเลือกพ่อพันธุ์แม่พันธุ์, ช่องทางการจัดจำหน่ายปลา, อาหารปลา, สาระความรู้เรื่องปลาหางนกยูง';
        $data['description'] = 'แหล่งรวบรวมความรู้เกี่ยวกับปลาหางนกยูงทั้งสายพันธุ์ในประเทศ และต่างประเทศ เปิดเว็ปเดียวรู้ทุกเรื่องของปลาหางนกยูง';
        $data['topic'] = $request->input('topic');

        $article = $this->article->where('id', '<>', '');
        if ($data['topic']) {
            $article->where('topic', 'like', '%' . $data['topic'] . '%');
        }
        $data['article'] = $article->orderBy('creation_date')->get();
        return view('article.list', $data);
    }

    public function detail($id = null)
    {
        try {
            $article = $this->article->where('id', $id)->first();
            if ($article->id) {
                $data['title'] = $article->topic;
                $data['keywords'] = $article->keywords;
                $data['description'] = $article->topic;
                $data['topic'] = $article->topic;
                $data['detail'] = $article->detail;
                $data['pic1'] = $article->pic1;
                return view('article.detail', $data);
            }
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function add($id = null)
    {
        $data = array('id' => $id, 'topic' => '', 'detail' => '', 'pic1' => '', 'pic1_val' => '', 'keywords' => '');
        $data['title'] = 'เพิ่มบทความ';
        $data['description'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';

        if ($id) {
            $article = $this->article->where('id', $id)->get();
            foreach ($article as $row) {
                $data['topic'] = $row->topic;
                $data['detail'] = $row->detail;
                $data['pic1'] = $row->pic1;
                $data['pic1_val'] = $row->pic1;
                $data['keywords'] = $row->keywords;
            }
        }

        return view('article.add', $data);
    }

    public function getImage(Request $request)
    {
        $id = $request->input('articleId');

        $article = $this->article->where('id', $id)->get();
        foreach ($article as $k => $row) {
            $this->setData['data'][$k]['topic'] = $row->topic;
            $this->setData['data'][$k]['detail'] = $row->detail;
            $this->setData['data'][$k]['pic1'] = env('IMAGE_PATH') . $row->pic1;
        }

        return response()->json($this->setData);
    }

    public function save(ArticleRequest $request)
    {
        $id = $request->input('id');
        $topic = $request->topic;
        $detail = $request->detail;
        $pic1 = $request->file('pic1');
        $pic1_val = $request->input('pic1_val');
        $keywords = $request->input('keywords');
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
                    'keywords' => $keywords,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);
            } else { // Update
                $this->article->where('id', $id)->update([
                    'topic' => $topic,
                    'detail' => $detail,
                    'pic1' => $this->image1,
                    'keywords' => $keywords,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);
            }

            Log::info('Invoice Save : ' . serialize($request->all()));
            return redirect('article/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::info('Article Save : ', $exception->getTrace());
            return redirect('article/list')->with('message', 'Successful!');
        }
    }

    public function remove($id = null)
    {
        try {
            $article = $this->article->where('id', $id)->first();
            if ($article) {
                $file = env('IMAGE_PATH') . $article->pic1;
                @unlink($file);
            }

            $this->article->where('id', $id)->delete();
            return redirect('article/list');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}