<?php

namespace Impalago\Ytb\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Impalago\Ytb\Services\GoogleLogin;

/**
 * Class for working with data Youtube
 *
 */
class YoutubeController extends Controller
{


    public function __construct()
    {
        $this->youtube = \App::make('youtube');
    }

    /**
     * A method of retrieving the list of videos
     *
     * @param \Impalago\Ytb\Services\GoogleLogin $gl
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(GoogleLogin $gl)
    {
        if (!$gl->isLoggedIn()) {
            return redirect(route('ytb.login'));
        }

        $options = ['chart' => 'mostPopular', 'maxResults' => 8, 'videoCategoryId' => '10'];
        if (Input::has('page')) {
            $options['pageToken'] = Input::get('page');
        }

        $videos = $this->youtube->videos->listVideos('id, snippet', $options);
        return view(config('ytb.views.list'), [
            'videos' => $videos
        ]);
    }

    /**
     * More information about the video
     *
     * @param \Impalago\Ytb\Services\GoogleLogin $gl
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getVideo(GoogleLogin $gl, $id)
    {

        if (!$gl->isLoggedIn()) {
            return redirect(route('ytb.login'));
        }

        // Getting information about a video
        $video = $this->youtube->videos->listVideos('id, snippet, player, contentDetails, statistics, status',
            ['maxResults' => 1, 'id' => $id]);

        if (!count($video->getItems())) {
            return redirect(route('ytb.index'));
        }

        $video = $video[0];
        $listComments = [];

        // Getting comments to the current video
        if ($video["statistics"]["commentCount"]) {
            $comments = $this->youtube->commentThreads->listCommentThreads('snippet',
                ['videoId' => $id, 'textFormat' => 'plainText']);

            $listComments = array_map(function ($comment) {
                return $comment['snippet']['topLevelComment']['snippet'];
            }, $comments['modelData']['items']);
        }

        return view(config('ytb.views.video'), ['video' => $video, 'comments' => $listComments]);
    }

    /**
     * Show info channel adn playlists channel
     *
     * @param GoogleLogin $gl
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getChannelPlaylist(GoogleLogin $gl, $id)
    {
        if (!$gl->isLoggedIn()) {
            return redirect(route('ytb.login'));
        }

        $channel = $this->youtube->channels->listChannels('snippet', ['id' => $id]);
        $channelInfo = $channel->getItems();

        $options = ['channelId' => $id, 'maxResults' => 20];
        if (Input::has('page')) {
            $options['pageToken'] = Input::get('page');
        }
        $playlists = $this->youtube->playlists->listPlaylists('snippet,contentDetails', $options);

        if (count($channelInfo) == 0) {
            abort(404);
        }

        return view('ytb::channel', [
            'channelInfo' => $channelInfo[0]['snippet'],
            'playlists' => $playlists
        ]);
    }

    /**
     * Get the list of videos to the playlist
     *
     * @param GoogleLogin $gl
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getVideoPlaylist(GoogleLogin $gl, $id)
    {

        if (!$gl->isLoggedIn()) {
            return redirect(route('ytb.login'));
        }

        $playlist = $this->youtube->playlists->listPlaylists('snippet', ['id' => $id]);

        $options = ['maxResults' => 8, 'playlistId' => $id];
        if (Input::has('page')) {
            $options['pageToken'] = Input::get('page');
        }
        $videos = $this->youtube->playlistItems->listPlaylistItems('id, snippet', $options);
        return view(config('ytb.views.list'), [
            'videos' => $videos,
            'pageInfo' => $playlist
        ]);
    }

    public function getSubscriptionsPage($pageToken)
    {
        $options = ['mine' => true, 'maxResults' => '20'];
        if ($pageToken) {
            $options['pageToken'] = $pageToken;
        }
        $subscriptions = $this->youtube->subscriptions->listSubscriptions('id, snippet', $options);

        return view('ytb::blocks.ajax-load-subscriptions', ['subscriptions' => $subscriptions]);
    }

}
