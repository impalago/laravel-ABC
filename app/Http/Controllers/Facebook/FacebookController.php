<?php

namespace App\Http\Controllers\Facebook;

use App\Provider;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Services\FacebookLogin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{

    protected $fb;

    public function __construct(FacebookLogin $fb)
    {
        $this->fb = $fb;
        $this->providerInfo = Provider::where('user_id', Auth::user()->id)->where('provider', 'facebook')->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->listPages()) {
            $pages = $this->listPages();
        } else {
            return view('errors.auth', ['provider' => 'facebook']);
        }

        return view('control-panel/facebook.index', ['pages' => $pages]);
    }

    /**
     * Display a listing of the resource left menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function listPages()
    {

        if (isset($this->providerInfo['token'])) {
            $fb = $this->fb->getSetting();
            $fb->setDefaultAccessToken($this->providerInfo['token']);
        } else {
            return null;
        }


        $request = $fb->request(
            'GET',
            '/' . $this->providerInfo['provider_id'] . '/accounts'
        );
        $response = $fb->getClient()->sendRequest($request);
        $graphObj = $response->getDecodedBody();

        return $graphObj['data'];
    }

    /**
     * Get posts page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPage($id)
    {

        if ($this->listPages()) {
            $pages = $this->listPages();
        } else {
            return redirect()->route('auth.socialite', 'facebook');
        }

        if ($this->providerInfo) {
            $fb = $this->fb->getSetting();
            $fb->setDefaultAccessToken($this->providerInfo['token']);
        } else {
            return redirect()->route('auth.login');
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
            ['fields' => 'id,message,attachments,created_time,from,link']
        );
        $graphObj = $request->getDecodedBody();
        //dd($graphObj);
        foreach ($graphObj['data'] as $key => $post) {
            $pagePosts[$key]['message'] = isset($post['message']) ? $post['message'] : '';
            $pagePosts[$key]['from'] = isset($post['from']['name']) ? $post['from']['name'] : '';
            $pagePosts[$key]['id'] = isset($post['id']) ? $post['id'] : '';
            $pagePosts[$key]['link'] = isset($post['link']) ? $post['link'] : '';
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
     * Create post
     *
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
                'access_token' => $this->providerInfo['token']
            ]
        );
        $pageToken = $pageInfo->getDecodedBody();
        $fb->setDefaultAccessToken($pageToken['access_token']);
        if (empty($request->image)) {

            $fb->post('/' . $request->page_id . '/feed',
                [
                    'message' => $request->message,
                    'link' => $request->link
                ]
            );

        } else {

            $fb->post('/' . $request->page_id . '/photos',
                [
                    'message' => $request->message,
                    'link' => $request->link,
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
    public function deletePostPage($id)
    {

        $fb = $this->fb->getSetting();
        $fb->setDefaultAccessToken($this->providerInfo['token']);
        $fb->delete('/' . $id);

        return redirect()->back();
    }


}
