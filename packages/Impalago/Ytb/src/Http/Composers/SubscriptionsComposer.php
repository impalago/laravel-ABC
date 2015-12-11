<?php
namespace Impalago\Ytb\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Input;
use Impalago\Ytb\Services\GoogleLogin;

class SubscriptionsComposer {

    public function __construct(GoogleLogin $gl) {
        $this->youtube = \App::make('youtube');
        $this->google = $gl;
    }

    /**
     * Bind data to the view.
     * Get list subscriptions for left list in template
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($this->google->isLoggedIn()) {
            $options = ['mine' => true, 'maxResults'=>'20'];
            if (Input::has('page')) {
                $options['pageToken'] = Input::get('page');
            }
            $subscriptions = $this->youtube->subscriptions->listSubscriptions('id, snippet', $options);
            $view->with('subscriptions', $subscriptions);
        }
    }

}