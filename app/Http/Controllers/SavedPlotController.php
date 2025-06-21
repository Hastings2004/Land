<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $plot = Plot::findOrFail($request->plot_id);

        if (!$user->savedPlots()->where('plot_id', $plot->id)->exists()) {
            $user->savedPlots()->attach($plot->id);
            return back()->with('success', 'Plot saved successfully.');
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
