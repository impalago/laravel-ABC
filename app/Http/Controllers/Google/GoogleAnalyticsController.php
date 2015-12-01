<?php

namespace App\Http\Controllers\Google;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\GoogleAnalytics;

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
            return view('control-panel/google/analytics.index')
                ->with('error', 'There was an Analytics API service error ' . $e->getCode() . ':' . $e->getMessage());
        } catch (apiException $e) {
            return view('control-panel/google/analytics.index')
                ->with('error', 'There was a general API error ' . $e->getCode() . ':' . $e->getMessage());
        } catch (\Exception $e) {
            return view('control-panel/google/analytics.index')
                ->with('error', 'There was a general API error ' . $e->getCode() . ': ' . $e->getMessage());
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

        $profiles = $analytics->management_profiles
            ->listManagementProfiles($idAccount, $idProperty);
        $profiles = $profiles->getItems();

        return view('control-panel/google/analytics.profile', ['profile' => $profiles[0]]);
    }


    /**
     * Show statistic for web property
     * Call AJAX
     *
     * @param GoogleAnalytics $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatistic(GoogleAnalytics $request, $id)
    {
        $analytics = $this->analytics;
        $visitByDay = $this->getVisitByDay($analytics, $id, $request->startDate, $request->endDate);
        $generalStatistics = $this->getGeneralStatistics($analytics, $id, $request->startDate, $request->endDate);

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
     * @return mixed $results
     */
    private function getGeneralStatistics($analytics, $id, $startDate, $endDate) {
        $results = $analytics->data_ga->get(
            'ga:' . $id,
            $startDate,
            $endDate,
            'ga:sessions,ga:avgSessionDuration,ga:users,ga:newUsers,ga:pageviews'
        );
        return str_replace('ga:', '', $results->getTotalsForAllResults());
    }

}
