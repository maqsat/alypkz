<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\News;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{

    public function welcome()
    {
        $news = News::where('category_id',1)->orderBy('id', 'desc')->take(3)->get();
        return view('web.welcome', compact('news'));
    }

    public function product()
    {
        return view('web.products');
    }

    public function owners()
    {
        return view('web.owners');
    }

    public function marketing()
    {
        return view('web.marketing');
    }

    public function academy()
    {
        return view('web.academy');
    }

    public function webNews()
    {
        $news = News::where('category_id',1)->orderBy('id', 'desc')->get();
         return view('web.news', compact('news'));
    }


    public function webNewsInner($id)
    {
        $news = News::find($id);
        return view('web.news-inner', compact('news'));
    }



    public function reviews()
    {
        $this->lang();

        $user = Auth::user();
        $reviews = Review::with('user','user_likes')->where('approved', '=', 1)->get();
        return view('review.reviews', compact('reviews', 'user'));
    }

    private function lang() {
        if(!isset($_GET['lang']))
            $_GET['lang'] = 'ru';

        if (! in_array($_GET['lang'], ['en', 'ru', 'kz'])) {
            abort(400);
        }

        App::setLocale($_GET['lang']);
    }

    public function review($id)
    {
        $this->lang();

        $user = Auth::user();
        $review = Review::with('user','user_likes')->where('approved', '=', 1)->where('id', $id)->first();

        if(!$review)
            return response()->redirectTo('reviews');

        return view('review.review', compact('review', 'user'));
    }

    public function about()
    {
        return view('page.about');
    }

    public function products()
    {
        return view('page.products');
    }

    public function cert()
    {
        return view('page.cert');
    }

    public function faq()
    {
        $faq=Faq::where('is_admin','0')->get();
        return view('page.faq',compact('faq'));
    }
}
