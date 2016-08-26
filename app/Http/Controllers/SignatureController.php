<?php

namespace App\Http\Controllers;

use App\Events\SignatureIsFinished;
use App\Events\SignatureIsGettingRunned;
use App\Events\SignaturesUpdated;
use Event;
use Auth;
use App\Models\Signature;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use App\Models\Option;
use Carbon\Carbon;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class SignatureController extends Controller
{
    public function updateSigs(Request $request)
    {
        $this->validate($request, [
            'signatures' => 'required'
        ]);

        //Signatures
        $lines = explode(PHP_EOL, $request->input('signatures'));

        //current not finished sigs
        $currSigs = Signature::where('status', '!=', 'finished')->where('status', '!=', 'despawned')->get();
        $newSigs = collect();

        foreach ($lines as $line)
        {
            $segments = explode("\t", $line);

            //Only working with combat sites atm
            if ($segments[1] != 'Cosmic Anomaly' && $segments[2] != 'Combat Site')
                continue;

            $sigID = $segments[0];
            $type = $segments[3];

            //Check for existing or new sigs
            if ($currSigs->contains('sig_id', $sigID))
            {
                //not new, still existing. Adding to collection of sigs that SHALL exist
                $sig = $currSigs->where('sig_id', $sigID);
                $newSigs->push($sig);

            }
            else
            {
                //new signature
                $sig = new Signature();
                $sig->sig_id = $sigID;
                $sig->type = $type;
                $sig->save();

                //push to collection for check of despawned sites
                $newSigs->push($sig);
            }
        }

        //Flatten to be able to use .contains functions
        $flatNewSigs = $newSigs->flatten();

        //mark disappeared sites as despawned
        //first get all current "free" sites
        $oldSigs = $currSigs->where('status', 'free');

        //go though each old sig thats "free"
        foreach ($oldSigs as $oSig)
        {
            //if oldSig doesn't exist in newsig, it's despawned
            if (!$flatNewSigs->contains('sig_id', $oSig->sig_id))
            {
                //newSigs doesn't have this free sig in list, so that sig must be despawned as status is free and not running/finished
                Signature::where('sig_id', '=', $oSig->sig_id)->update(['status' => 'despawned']);
            }
        }

        //Update time for lastupdated
        $now = Carbon::now();
        Option::where('key', '=', 'sigs_last_updated')->update(['value' => $now->toDateTimeString()]);

        //Fire Update events
        Event::fire(new SignaturesUpdated(true));

        return redirect()->route('home');
    }

    public function getLastUpdateTime()
    {
        $lastUpdate = Option::where('key', 'sigs_last_updated')->get();

        return response()->json($lastUpdate);
    }

    public function getUpdatedTables()
    {
        $htmlFree = View::make('home.partials.FreeSigTable')->render();
        $htmlOwn = View::make('home.partials.OwnSigTable')->render();

        return response()->json(['htmlFree' => $htmlFree, 'htmlOwn' => $htmlOwn]);
    }

    public function runSite(Request $request)
    {
        //Find selected site and mark it as getting run by current pilot
        $this->validate($request, [
            'sig_id' => 'required|numeric'
        ]);

        try {

        $sig = Signature::where('id', $request->input('sig_id'))->get()->first();

        $sig->FK_pilot = Auth::user()->id;
        $sig->startTime = Carbon::now();
        $sig->status = "running";
        $sig->save();

        }
        catch (\Exception $ex)
        {
            //do nothing
        }

        //Fire event to move sig
        Event::fire(new SignatureIsGettingRunned($sig));
    }

    public function finishSite(Request $request)
    {
        //Find selected site and mark it as getting run by current pilot
        $this->validate($request, [
            'sig_id' => 'required|numeric'
        ]);

        try {

            $sig = Signature::where('id', $request->input('sig_id'))->get()->first();

            $sig->FK_pilot = Auth::user()->id;
            $sig->finishTime = Carbon::now();
            $sig->status = "finished";
            $sig->save();

        }
        catch (\Exception $ex)
        {
            //do nothing
        }

        //Fire event to move sig
        Event::fire(new SignatureIsFinished($sig));
    }
}
