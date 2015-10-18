<?php

namespace Vendor\Ytb\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

/**
 * Class for working with data Youtube
 *
 */

class YoutubeController extends Controller {

    /**
     * A method of retrieving the list of videos
     *
     * @param \Vendor\Ytb\Services\GoogleLogin $gl
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index (\Vendor\Ytb\Services\GoogleLogin $gl){

        if(!$gl->isLoggedIn()) {
            return redirect('ytb/login');
        }

        $options = ['chart' => 'mostPopular', 'maxResults' => 15, 'videoCategoryId' => '10' ]; // 'regionCode' => 'RU'
        if(Input::has('page')) {
            $options['pageToken'] = Input::get('page');
        }

        $youtube = \App::make('youtube');
        $videos = $youtube->videos->listVideos('id, snippet, statistics', $options);
        //dump($videos);
        return view(config('ytb.views.list'), ['videos' => $videos]);
    }

    /**
     * More information about the video
     *
     * @param \Vendor\Ytb\Services\GoogleLogin $gl
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getVideo(\Vendor\Ytb\Services\GoogleLogin $gl, $id) {

        if(!$gl->isLoggedIn()) {
            return redirect('ytb/login');
        }

        $youtube = \App::make('youtube');

        // Getting information about a video
        $optionsVideo = ['maxResults' => 1, 'id' => $id];
        $video = $youtube->videos->listVideos('id, snippet, player, contentDetails, statistics, status', $optionsVideo);

        //dump($video);
        if(count($video->getItems()) == 0){
            return redirect('/ytb');
        }
        // Getting comments to the current video
        $optionsComment = ['videoId' => $id, 'textFormat' => 'plainText'];
        $comment = $youtube->commentThreads->listCommentThreads('snippet', $optionsComment);
        //dump($comment);

        return view(config('ytb.views.video'), ['video' => $video[0], 'comments' => $comment['items']]);

    }

}
