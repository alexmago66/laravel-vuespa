<?php

use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1', 'middleware' => 'api'], function () {
  Route::get('user-list', 'UserController@getUserList');
  Route::post('get-user-conversation', 'ChatController@getUserConversationById');
  Route::post('chat-save', 'ChatController@saveUserChat');
});
