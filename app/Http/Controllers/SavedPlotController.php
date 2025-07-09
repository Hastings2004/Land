<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SavedPlotController extends Controller
{
    public function index()
    {
        $savedPlots = Auth::user()->savedPlots()->latest()->paginate(10);
        return view('users.saved_plots', compact('savedPlots'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $isAjax = $request->expectsJson() || $request->ajax();
        if ($isAjax) {
            Log::info('AJAX save plot request', [
                'user_id' => $user ? $user->id : null,
                'plot_id' => $request->plot_id,
                'authenticated' => $user ? true : false,
            ]);
        }
        if (!$user) {
            if ($isAjax) {
                Log::warning('AJAX save plot failed: not authenticated');
                return response()->json(['success' => false, 'message' => 'You must be logged in to save a plot.'], 401)
                    ->header('X-Debug-Info', 'auth-fail');
            }
            return redirect()->route('login')->with('error', 'You must be logged in to save a plot.');
        }
        $plot = Plot::find($request->plot_id);
        if (!$plot) {
            if ($isAjax) {
                Log::warning('AJAX save plot failed: plot not found', ['plot_id' => $request->plot_id]);
                return response()->json(['success' => false, 'message' => 'Plot not found.'], 404)
                    ->header('X-Debug-Info', 'plot-not-found');
            }
            return back()->with('error', 'Plot not found.');
        }
        if (!$user->savedPlots()->where('plot_id', $plot->id)->exists()) {
            $user->savedPlots()->attach($plot->id);
            if ($isAjax) {
                Log::info('AJAX save plot success', ['user_id' => $user->id, 'plot_id' => $plot->id]);
                return response()->json(['success' => true, 'message' => 'Plot saved successfully.'])
                    ->header('X-Debug-Info', 'plot-saved');
            }
            return back()->with('success', 'Plot saved successfully.');
        }
        if ($isAjax) {
            Log::info('AJAX save plot already saved', ['user_id' => $user->id, 'plot_id' => $plot->id]);
            return response()->json(['success' => false, 'message' => 'You have already saved this plot.'])
                ->header('X-Debug-Info', 'already-saved');
        }
        return back()->with('info', 'You have already saved this plot.');
    }

    public function destroy($plot_id)
    {
        $user = Auth::user();
        $plot = Plot::findOrFail($plot_id);

        if ($user->savedPlots()->where('plot_id', $plot->id)->exists()) {
            $user->savedPlots()->detach($plot->id);
            return back()->with('success', 'Plot removed from saved list.');
        }

        return back()->with('error', 'Plot not found in your saved list.');
    }
}
