<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Contract\Repositories\JournalRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, JournalRepositoryInterface $journalRepository)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $report = $journalRepository->getJournalEntriesByDateRange($from, $to);

        return Inertia::render('Admin/Dashboard/Index', [
            'report' => $report,
        ]);
    }
}
