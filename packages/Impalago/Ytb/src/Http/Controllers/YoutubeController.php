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

        $subscriptions = $this->getSubscriptionsList();

        $subscriptionsItems = $subscriptions['subscriptionsItems'];
        $subscriptionsNextPage = $subscriptions['subscriptionsNextPage'];

        //dd($subscriptionsItems);

        $options = ['chart' => 'mostPopular', 'maxResults' => 15, 'videoCategoryId' => '10'];
        if (Input::has('page')) {
            $options['pageToken'] = Input::get('page');
        }

        $youtube = \App::make('youtube');
        //$videos = $youtube->videos->listVideos('id, snippet, statistics', $options);
        $videos = $youtube->videos->listVideos('id, snippet', $options);
        return view(config('ytb.views.list'), [
            'videos' => $videos,
            'subscriptionsItems' => $subscriptionsItems,
            'subscriptionsNextPage' => $subscriptionsNextPage
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

        $youtube = \App::make('youtube');

        // Getting information about a video
        $video = $youtube->videos->listVideos('id, snippet, player, contentDetails, statistics, status',
        ['maxResults' => 1, 'id' => $id]);

        if (!count($video->getItems())) {
            return redirect(route('ytb.index'));
        }

        $video = $video[0];
        $listComments = [];

        // Getting comments to the current video
        if ($video["statistics"]["commentCount"]) {
            $comments = $youtube->commentThreads->listCommentThreads('snippet',
            ['videoId' => $id, 'textFormat' => 'plainText']);

            $listComments = array_map(function($comment) {
                return $comment['snippet']['topLevelComment']['snippet'];
            }, $comments['modelData']['items']);
        }

        return view(config('ytb.views.video'), ['video' => $video, 'comments' => $listComments]);
    }

    /**
     * Get list subscriptions for left list in template
     *
     * @return array
     */
    private function getSubscriptionsList() {

        $youtube = \App::make('youtube');
        $subscriptions = $youtube->subscriptions->listSubscriptions('id, snippet', ['mine' => true, 'maxResults'=>'20']);
        //dd($subscriptions);
        $subscriptionsItems = $subscriptions->getItems();
        $subscriptionsNextPage = $subscriptions->getNextPageToken();

        return array(
            'subscriptionsItems' => $subscriptionsItems,
            'subscriptionsNextPage' => $subscriptionsNextPage
        );
    }

    /**
     * Show info channel adn playlists channel
     *
     * @param GoogleLogin $gl
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getChannelPlaylist(GoogleLogin $gl, $id) {

        if (!$gl->isLoggedIn()) {
            return redirect(route('ytb.login'));
        }

        $youtube = \App::make('youtube');

        $subscriptions = $this->getSubscriptionsList();
        $subscriptionsItems = $subscriptions['subscriptionsItems'];
        $subscriptionsNextPage = $subscriptions['subscriptionsNextPage'];

        $channel = $youtube->channels->listChannels('snippet', ['id' => $id]);
        $channelInfo = $channel->getItems();

        $playlists = $youtube->playlists->listPlaylists('snippet,contentDetails', ['channelId' => $id, 'maxResults' => 50]);
        $playlistsList = $playlists->getItems();

        if(count($channelInfo) == 0) {
            abort(404);
        }

        return view('ytb::channel', [
            'channelInfo' => $channelInfo[0]['snippet'],
            'playlistsList' => $playlistsList,
            'subscriptionsItems' => $subscriptionsItems,
            'subscriptionsNextPage' => $subscriptionsNextPage
        ]);
    }

    public function getVideoPlaylist () {
        return 'ok';
    }

}
