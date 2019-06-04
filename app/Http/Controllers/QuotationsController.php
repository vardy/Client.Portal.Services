<?php

namespace App\Http\Controllers;

use App\Quotations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuotationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the quotations for the currently
     * logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('user-was-editing');
        $request->session()->forget('from-admin');

        //NOTE: DUPLICATED IN LoginController.php
        return view('quotations.index', [
            'quotes' => auth()->user()->quotations
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin','pm']);
        } else {
            return redirect('/login');
        }

        return view('quotations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'quoteLabel' => ['required', 'max:255'],
            'uploadedFile' => ['required', 'max:2999999']
        ]);

        $file = $request->file('uploadedFile');
        $fileName = $file->getClientOriginalName();

        // Setup quote object to commit to database.
        $quote = new Quotations();
        $quote->quotationLabel = $request->quoteLabel;
        if($request->session()->get('from-admin', false) === 'true') {
            $quote->user_id = $request->session()->get('user-was-editing');
        } else {
            $quote->user_id = auth()->user()->id;
        }
        $quote->originalFilename = $fileName;
        $quote->originalFileExtension = $file->getClientOriginalExtension();
        $quote->originalFileMime = $file->getClientMimeType();
        $quote->save(); // Commit

        $filePathToStore = '/clientportal/' . $quote->id;

        // Commit object to s3 with file path and contents of file (key:object)
        \Storage::disk('s3')->put($filePathToStore, file_get_contents($file));

        if($request->session()->pull('from-admin', 'false') === 'true') {

            $oldUser = $request->session()->pull('user-was-editing', 'false');
            if($oldUser !== 'false') {
                return redirect('/admin/user/' . $oldUser);
            } else {
                return redirect('/quotations');
            }
        } else {
            return redirect('/quotations');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quotations  $quotations
     * @return \Illuminate\Http\Response
     */
    public function show($quoteID, Quotations $quotations)
    {

        if(Quotations::findOrFail($quoteID)->user_id !== auth()->user()->id && !auth()->user()->authorizeRoles(['admin','pm'])) {
            // Checks if user has access to file download.
            // Not sure why being able to download the file overrides the redirect
            // authorizeRoles should be giving for those who do not have the admin
            // or pm role, but it does so it works.
        }

        $filePathExpected = '/clientportal/' . $quoteID;

        return response()->stream(function() use ($filePathExpected) {
            $stream = Storage::readStream($filePathExpected);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Type'          => Storage::mimeType($filePathExpected),
            'Content-Length'        => Storage::size($filePathExpected),
            'Content-Disposition'   => 'attachment; filename="' . Quotations::findOrFail($quoteID)->originalFilename . '"',
            'Pragma'                => 'public',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quotations  $quotations
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Quotations $quotations, Request $request)
    {
        $request->session()->forget('user-was-editing');
        $request->session()->forget('from-admin');

        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin','pm']);
        } else {
            return redirect('/login');
        }

        return view('quotations.edit', [
            'quote' => Quotations::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quotations  $quotations
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Quotations $quotations)
    {
        request()->validate([
            'quotationLabel' => ['required', 'max:255']
        ]);

        $quote = Quotations::findOrFail($id);
        $quote->quotationLabel = $request->quotationLabel;
        $quote->save();

        if($request->session()->pull('from-admin', 'false') === 'true') {

            $oldUser = $request->session()->pull('user-was-editing', 'false');
            if($oldUser !== 'false') {
                return redirect('/admin/user/' . $oldUser);
            } else {
                return redirect('/quotations');
            }
        } else {
            return redirect('/quotations');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quotations  $quotations
     * @return \Illuminate\Http\Response
     */
    public static function destroy($id, Request $request, Quotations $quotations)
    {

        Quotations::findOrFail($id)->delete();

        $s3FilePath = '/clientportal/' . $id;
        Storage::delete($s3FilePath);

        if($request->session()->pull('from-admin', 'false') === 'true') {

            $oldUser = $request->session()->pull('user-was-editing', 'false');
            if($oldUser !== 'false') {
                return redirect('/admin/user/' . $oldUser);
            } else {
                return redirect('/quotations');
            }
        } else {
            return redirect('/quotations');
        }
    }

    public function show_request_form(Request $request) {

        return view('quotations.request_form');
    }
}
