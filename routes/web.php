<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//gmail mail sign up

// Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
// Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

//end

Auth::routes();

Route::get('auth', 'UserController@login');

//filter by news category
Route::get('/news-category/{id}', 'NewsPostController@filterByCategory');
Route::post('subscribe', 'FrontendController@subscribe');

//content search
Route::POST('search','FrontendController@search');

Route::group(['middleware' => ['activity']], function () {
    Route::get('/discussion', 'DiscussionController@index');
    Route::get('/discussion/{id}', 'DiscussionController@show');

    Route::get('/blog', 'BlogController@index');
    Route::get('/blog/{id}', 'BlogController@show');
    Route::get('/news', 'NewsPostController@index');
    Route::get('/news/{id}', 'NewsPostController@show');
    Route::get('/publications', 'PublicationController@index');
    Route::get('/download-publication/{id}', 'PublicationController@file_download');
    Route::get('/publications/{id}', 'PublicationController@show');
    Route::get('/', 'FrontendController@index');
});

Route::group(['middleware' => ['auth', 'web', 'activity']], function () {
    Route::resource('roles', 'RoleController');
    Route::post('blog-comment', 'BlogController@comment');
    Route::get('/blog/{id}/edit', 'BlogController@edit');
    Route::put('update-blog/{id}', 'BlogController@update')->name('update-blog');
    Route::delete('delete-blog/{id}', 'BlogController@destroy')->name('delete-blog');

    Route::get('/publications/{id}/edit', 'PublicationController@edit');
    Route::get('/discussion/{id}/edit', 'DiscussionController@edit');

    Route::post('discussion/parent_comment', 'DiscussionController@parent_comment');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/blog-create', 'BlogController@create');
    Route::post('/publish-blog', 'BlogController@store')->name('publish-blog');
    Route::get('/publication-create', 'PublicationController@create');
    Route::post('upload-publication', 'PublicationController@store');

    Route::put('/update-publication/{id}', 'PublicationController@update')->name('update-publication');
    Route::delete('/delete-publication/{id}', 'PublicationController@destroy')->name('delete-publication');

    Route::get('/discussion-create', 'DiscussionController@create');
    Route::post('/publish-discussion', 'DiscussionController@store');
    Route::put('update-discussion/{id}', 'DiscussionController@update')->name('update-discussion');
    Route::delete('delete-discussion/{id}', 'DiscussionController@destroy')->name('delete-discussion');
    Route::resource('profile', 'ProfileController');
    Route::get('/search-tags', 'TagController@search');

    //backend
    Route::resource('users', 'UserController');
    Route::resource('news-feed', 'NewsPostController');
    Route::get('news-dashboard', 'NewsPostController@dashboard');
    Route::post('news-publish', 'NewsPostController@store')->name('news-publish');
    Route::resource('news-categories', 'PostCategoryController');
    Route::get('dash-discussion', 'DiscussionController@dash_discussions');
    Route::get('dash-discussion/{id}/dash_edit', 'DiscussionController@dash_edit');
    Route::put('dash-discussion-update/{id}', 'DiscussionController@dash_update')->name('dash-discussion-update');
    Route::delete('dash-discussion-delete/{id}', 'DiscussionController@dash_delete')->name('dash-discussion-delete');

    Route::get('blogs', 'BlogController@dash_blogs');

    Route::get('dash-publications', 'PublicationController@dash_publications');
    Route::get('dash-publications/{id}/dash_edit', 'PublicationController@dash_edit');
    Route::put('dash-publications-update/{id}', 'PublicationController@dash_update')->name('dash-publications-update');
    Route::delete('dash-publications-delete/{id}', 'PublicationController@dash_delete')->name('dash-publications-delete');

    Route::get('logs', 'BlogController@dash_blogs');
    Route::resource('countries', 'CountryController');

    Route::get('dash-blog/{id}/dash_edit', 'BlogController@dash_edit');
    Route::put('dash_update_blog/{id}', 'BlogController@dash_update')->name('dash_update_blog');
    Route::delete('dash_delete_blog/{id}', 'BlogController@dash_delete')->name('dash_delete_blog');
    Route::resource('pages', 'PageController');
});
