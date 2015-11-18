<?php

namespace App\Http\Controllers\Google;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;


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
     * @param $id
     * @return $this
     * @internal param Request $request
     */
    public function getStatistic($id)
    {
        $data = Input::all();
        $validate = Validator::make($data, array(
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d'
        ));

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }

        $analytics = $this->analytics;

        $visitByDay = $this->getVisitByDay($analytics, $id, $data['startDate'], $data['endDate']);
        $generalStatistics = $this->getGeneralStatistics($analytics, $id, $data['startDate'], $data['endDate']);
        //dd($generalStatistics);

        return response()->json(array('visitByDay' => $visitByDay, 'generalStatistics' => $generalStatistics));
    }

    /**
     * Get statistic visits by day for the selected period
     *
     * @param $analytics
     * @param $id
     * @param $startDate
     * @param $endDate
     * @return \Illuminate\Http\JsonResponse
     */
    private function getVisitByDay($analytics, $id, $startDate, $endDate) {
        $results = $analytics->data_ga->get(
            'ga:' . $id,
            $startDate,
            $endDate,
            'ga:sessions',
            array('dimensions' => 'ga:date')
        );
        $response = [];
        foreach($results->getRows() as $key => $row) {
            $response[$key] = array((strtotime($row[0]) * 1000), ((int) $row[1]));
        }

        return $response;
    }

    /**
     * Get general statistics for the selected period
     *
     * @param $analytics
     * @param $id
     * @param $startDate
     * @param $endDate
     * @return $results
     */
    private function getGeneralStatistics($analytics, $id, $startDate, $endDate) {
        $results = $analytics->data_ga->get(
            'ga:' . $id,
            $startDate,
            $endDate,
            'ga:sessions,ga:sessionDuration,ga:users,ga:newUsers,ga:pageviews'
        );
        return str_replace('ga:', '', $results->getTotalsForAllResults());
    }

}
