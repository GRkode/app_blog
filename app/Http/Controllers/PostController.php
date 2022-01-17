<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Http\Controllers\Controller;
use App\Models\{ Category, User, Tag };
use Illuminate\Http\Request;

class PostController extends Controller
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
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\PostRepository $postRepository
     * @return void
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->nbrPages = 6;
    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->getActiveOrderByDate($this->nbrPages);
        $heros = $this->postRepository->getHeros();

        return view('front.index', compact('posts', 'heros'));
    }

    /**
     * Display the specified post by slug.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $post = $this->postRepository->getPostBySlug($slug);

        return view('front.post', compact('post'));
    }
}
