<?php

use App\Http\Controllers\ProfileController;
use App\Models\Ghost;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => false && Route::has('login'),
        'canRegister' => false && Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route to the RSVP page /invite/invitee_code
Route::get('/invite/{invitee_code}', function ($invitee_code) {
    // get the RSVP record from the database based on the invitee_code
    $rsvp = App\Models\Rsvp::where('invitee_code', $invitee_code)->first();
    // if the RSVP record does not exist, return a 404 response
    if (!$rsvp) {
        abort(404);
    }

    if ($rsvp->status === 'yes') {
        return redirect()->route('ghost-selection', ['invitee_code' => $rsvp->invitee_code]);
    }

    // return the Inertia view with the RSVP record
    return Inertia::render('OcularisInfernum', [
        'rsvp' => $rsvp,
    ]);
})->name('ocularis-infernum-rsvp');

// Ghost selection page
Route::get('/invite/{invitee_code}/ghost-selection', function ($invitee_code) {
    // get the RSVP record from the database based on the invitee_code
    $rsvp = App\Models\Rsvp::where('invitee_code', $invitee_code)->first();
    // if the RSVP record does not exist, return a 404 response
    if (!$rsvp) {
        abort(404);
    }

    if ($rsvp->ghost) {
        return redirect()->route('selected-ghost', ['rsvp_id' => $rsvp->id]);
    }

    // get list of ghosts not selected by other guests
    $availableGhosts = App\Models\Ghost::whereNull('rsvp_id')->orWhere('name', '=', 'Guest')->get();

    // return the Inertia view with the RSVP record
    return Inertia::render('GhostSelection', [
        'rsvp' => $rsvp,
        'availableGhosts' => $availableGhosts,
    ]);
})->name('ghost-selection');

Route::get('/invite/{rsvp_id}/selected-ghost', function ($rsvp_id) {
    // get the RSVP record from the database based on the invitee_code
    $rsvp = App\Models\Rsvp::find($rsvp_id)->load('ghost');
    // if the RSVP record does not exist, return a 404 response
    if (!$rsvp) {
        abort(404);
    }

    return Inertia::render('SelectedGhost', [
        'rsvp' => $rsvp,
    ]);
})->name('selected-ghost');

// Route to handle the ghost selection form submission that passes the rsvp_id as a parameter
Route::post('/invite/{rsvp_id}/ghost-selection', function ($rsvp_id) {
    // get the RSVP record from the database based on the rsvp_id
    $rsvp = App\Models\Rsvp::find($rsvp_id);
    // if the RSVP record does not exist, return a 404 response
    if (!$rsvp) {
        abort(404);
    }

    $isGhostSelectionGuest = request()->has('ghost_id') && request('ghost_id') === 'guest';

    if (!$isGhostSelectionGuest) {
        // validate the request data ghost exists
        $data = request()->validate([
            'ghost_id' => 'required|exists:ghosts,id',
        ]);
    
        // get the ghost record based on the ghost_id
        $ghost = App\Models\Ghost::find($data['ghost_id']);
        // if the ghost record does not exist, return a 404 response
        if (!$ghost) {
            abort(404);
        }
    
        // set the ghost_id on the RSVP record
        $rsvp->ghost_id = $ghost->id;
        // save the RSVP record
        $rsvp->save();
    
        // set the rsvp_id on the ghost record
        $ghost->rsvp_id = $rsvp->id;
        // save the ghost record
        $ghost->save();
    } else {
        $rsvp->ghost_id = null;
        $rsvp->save();
    }


    // redirect back to the RSVP page with a success message
    return redirect()->route('ocularis-infernum-rsvp', ['invitee_code' => $rsvp->invitee_code]);
});

// Route to handle the RSVP form submission that passes the rsvp_id as a parameter
Route::post('/invite/{rsvp_id}', function ($rsvp_id) {
    // get the RSVP record from the database based on the rsvp_id
    $rsvp = App\Models\Rsvp::find($rsvp_id);
    // if the RSVP record does not exist, return a 404 response
    if (!$rsvp) {
        abort(404);
    }

    // validate the request data
    $data = request()->validate([
        'status' => 'required|in:yes,no,maybe',
    ]);

    $rsvp->status = $data['status'];

    // if no or maybe, set the ghost_id to null
    if ($data['status'] !== 'yes') {
        $rsvp->ghost_id = null;
    }

    // update the RSVP record with the submitted data
    $rsvp->save();

    if ($data['status'] === 'yes') {
        // redirect to the ghost selection page if the status is yes
        return redirect()->route('ghost-selection', ['invitee_code' => $rsvp->invitee_code]);
    }

    // redirect back to the RSVP page with a success message
    return redirect()->back();
});

// Route to reset the rsvp status and ghost selection and redirect back to the RSVP page
Route::post('/invite/{rsvp_id}/resend', function ($rsvp_id) {
    // get the RSVP record from the database based on the rsvp_id
    $rsvp = App\Models\Rsvp::find($rsvp_id);
    // if the RSVP record does not exist, return a 404 response
    if (!$rsvp) {
        abort(404);
    }

    // reset the status and ghost_id
    $rsvp->status = null;

    if ($rsvp->ghost_id) {
        $ghost = Ghost::find($rsvp->ghost_id);
        $ghost->rsvp_id = null;
        $ghost->save();
        $rsvp->ghost_id = null;
    }
    $rsvp->save();

    // redirect back to the RSVP page with a success message
    return redirect()->route('ocularis-infernum-rsvp', ['invitee_code' => $rsvp->invitee_code]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
