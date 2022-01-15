<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\Back\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ResourceController
{
    /**
 * Update the specified resource in storage.
 *
 * @param App\Http\Requests\Back\UserRequest  $request
 * @param  integer $id
 * @return \Illuminate\Http\Response
 */
    public function update($id)
    {
        $request = app()->make(UserRequest::class);

        $request->merge([
            'is_valid' => $request->has('is_valid'),
        ]);

        User::findOrFail($id)->update($request->all());

        return back()->with('ok', __('The user has been successfully updated'));
    }

    /**
     * Valid the user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function valid(User $user)
    {
        $user->is_valid = true;
        $user->save();

        return response()->json();
    }

    /**
     * Unvalid the user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function unvalid(User $user)
    {
        $user->is_valid = false;
        $user->save();

        return response()->json();
    }
}
