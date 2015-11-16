<?php

namespace App\Http\Controllers\Google;

use App\Http\Services\GoogleLogin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class GoogleAnalyticsController extends Controller
{

    protected $analytics;

    public function __construct(App $analytics)
    {
        $this->analytics = App::make('analytics');
    }

    /**
     * Show List accounts
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $analytics = $this->analytics;
        try {
            $accounts = $analytics->management_accounts->listManagementAccounts();
        } catch (apiServiceException $e) {
            Session::flash('error', 'There was an Analytics API service error ' . $e->getCode() . ':' . $e->getMessage());
            return redirect('google.index');
        } catch (apiException $e) {
            Session::flash('error', 'There was a general API error ' . $e->getCode() . ':' . $e->getMessage());
            return redirect('google.index');
        }

        return view('control-panel/google/analytics.index', ['accounts' => $accounts->getItems()]);

    }

    /**
     * Get web property for one account (ajax request)
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAccount($id)
    {
        $analytics = $this->analytics;
        $webProperties = $analytics->management_webproperties->listManagementWebproperties($id);
        return view('control-panel/google/analytics.account', ['webProperties' => $webProperties->getItems()]);
    }

    /**
     * Show information web on site
     *
     * @param $idAccount
     * @param $idProperty
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getWebProperty($idAccount, $idProperty)
    {
        $analytics = $this->analytics;
        $date = Carbon::now();
        $profiles = $analytics->management_profiles
            ->listManagementProfiles($idAccount, $idProperty);
        $profiles = $profiles->getItems();
        $results = $analytics->data_ga->get(
            'ga:' . $profiles[0]->getId(),
            $date->year . '-' . $date->month . '-01',
            'today',
            'ga:visits,ga:pageviews',
            array('dimensions' => 'ga:date'));
        //dd($results->getRows());
        return view('control-panel/google/analytics.profile', ['results' => $results, 'profile' => $profiles[0]]);
    }

    /**
     * Show statistic for web property
     * Called AJAX
     *
     */
    public function getStatistic()
    {
        return 'ok!';
    }

}
