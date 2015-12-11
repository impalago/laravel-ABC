<?php
namespace Impalago\Ytb\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Input;

class SubscriptionsComposer {

    public function __construct() {
        $this->youtube = \App::make('youtube');
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
        $options = ['mine' => true, 'maxResults'=>'20'];
        if (Input::has('page')) {
            $options['pageToken'] = Input::get('page');
        }
        $subscriptions = $this->youtube->subscriptions->listSubscriptions('id, snippet', $options);
        if($subscriptions) {
            $view->with('subscriptions', $subscriptions);
        } else {
            return;
        }

    }

}