<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PremiumPostController extends Controller
{
    /**
     * The PostRepository instance.
     *
     * @var \App\Repositories\PostRepository
     */
    protected $postRepository;

    /**
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Create a new PremiumController instance.
     *
     * @param  \App\Repositories\PostRepository $postRepository
     * @return void
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->middleware('auth');
        $this->postRepository = $postRepository;
        $this->nbrPages = 6;
    }

    /**
     * Display a listing of the premium posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->getPremiumOrderByDate($this->nbrPages);
        $plans = Plan::get();
        return view('front.membership', compact('posts', 'plans'));
    }
}
