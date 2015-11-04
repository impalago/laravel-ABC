<?php

namespace App\Http\Controllers\Facebook;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Services\FacebookLogin;
use Carbon\Carbon;

class FacebookController extends Controller
{

    protected $fb;

    public function __construct(FacebookLogin $fb)
    {
        $this->fb = $fb;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->listPages();
        return view('control-panel/facebook.index', ['pages' => $pages]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listPages()
    {
        $fb = $this->fb->getSetting();
        $user_id = \Auth::user()->facebook_id;
        if (\Auth::user()->facebook_token) {
            $fb->setDefaultAccessToken(\Auth::user()->facebook_token);
        } else {
            redirect(route('auth.login'));
        }

        $request = $fb->request(
            'GET',
            '/' . $user_id . '/accounts'
        );
        $response = $fb->getClient()->sendRequest($request);
        $graphObj = $response->getDecodedBody();

        return $graphObj['data'];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPage($id)
    {

        $pages = $this->listPages();
        $fb = $this->fb->getSetting();
        if (\Auth::user()->facebook_token) {
            $fb->setDefaultAccessToken(\Auth::user()->facebook_token);
        } else {
            redirect(route('auth.login'));
        }


        $requestPage = $fb->sendRequest(
            'GET',
            '/' . $id
        );
        $page = $requestPage->getDecodedBody();
        $pageName = $page['name'];

        $request = $fb->sendRequest(
            'GET',
            '/' . $id . '/feed',
            ['fields' => 'id,message,attachments,created_time,from']
        );
        $graphObj = $request->getDecodedBody();
        //dd($graphObj);
        foreach ($graphObj['data'] as $key => $post) {
            $pagePosts[$key]['message'] = isset($post['message']) ? $post['message'] : '';
            $pagePosts[$key]['from'] = isset($post['from']['name']) ? $post['from']['name'] : '';
            $pagePosts[$key]['id'] = isset($post['id']) ? $post['id'] : '';
            $pagePosts[$key]['created_time'] = isset($post['created_time']) ? Carbon::parse($post['created_time'])->timezone('Europe/Moscow')->format('d F Y H:i') : '';

            if (empty($post['attachments']['data'])) {
                continue;
            }

            foreach ($post['attachments']['data'] as $attach) {
                if (isset($attach['subattachments']['data'])) {
                    $pagePosts[$key]['files'] = $attach['subattachments']['data'];
                } else {
                    $pagePosts[$key]['files'] = array(0 => array('media' => array('image' => array('src' => $attach['media']['image']['src']))));
                }
            }
        }

        return view('control-panel/facebook.page', [
            'pages' => $pages,
            'posts' => $pagePosts,
            'page_name' => $pageName,
            'page_id' => $id
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPostPage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $fb = $this->fb->getSetting();
        $pageInfo = $fb->sendRequest(
            'GET',
            '/' . $request->page_id,
            [
                'fields' => 'access_token',
                'access_token' => \Auth::user()->facebook_token
            ]
        );
        $pageToken = $pageInfo->getDecodedBody();

        if (empty($request->image)) {

            $fb->post('/' . $request->page_id . '/feed',
                [
                    'access_token' => $pageToken['access_token'],
                    'message' => $request->message
                ]
            );

        } else {

            $fb->post('/' . $request->page_id . '/photos',
                [
                    'access_token' => $pageToken['access_token'],
                    'message' => $request->message,
                    'source' => $fb->fileToUpload($request->file('image')->getRealPath())
                ]
            );

        }
        
        return redirect()->back();
    }


    /**
     * Delete post
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePostPage($id) {

        $fb = $this->fb->getSetting();
        $fb->setDefaultAccessToken(\Auth::user()->facebook_token);
        $fb->delete('/'.$id);

        return redirect()->back();
    }


}
