<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\{ User, Post, Comment };
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index(Post $post, User $user, Comment $comment)
    {
        $users = isRole('admin') ? $this->getUnreads($user) : null;
        $posts = isRole('admin') ? $this->getUnreads($post) : null;
        $comments = $this->getUnreads($comment, isRole('redac'));
        return view('back.index', compact('posts', 'users','comments'));
    }

    /**
     * get unread notification
     * @param $model
     * @param $redac
     * @return mixed
     */
    protected function getUnreads($model, $redac = null)
    {
        $query = $redac ?
            $model->whereHas('post.user', function ($query) {
                $query->where('users.id', auth()->id());
            }) :
            $model->newQuery();
        return $query->has('unreadNotifications')->count();
    }

    /**
     * purge read notifications
     * @param $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purge($model)
    {
        $model = 'App\Models\\' . ucfirst($model);
        DB::table('notifications')->where('notifiable_type', $model)->delete();
        return back();
    }
}
