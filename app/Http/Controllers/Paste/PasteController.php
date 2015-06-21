<?php namespace App\Http\Controllers\Paste;

use App\Http\Controllers\Controller;
use App\Tools\Models\Paste;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasteController extends Controller
{

    public function createPaste(Request $request)
    {
        $slug = str_random(6);

        while (Paste::where('slug', $slug)->first())
            $slug = str_random(6);

        file_put_contents(storage_path() . "/app/pastes/$slug.txt", $request->get('content'));

        Paste::create([
            'slug' => $slug,
            'creator' => Auth::user()->id,
            'title' => $request->title,
            'public' => $request->has('public')
        ]);

        return redirect('/' . $slug);
    }

    public function editPaste(Request $request)
    {
        $paste = Paste::find($request->id);
        $slug = $paste->slug;

        file_put_contents(storage_path() . "/app/pastes/$slug.txt", $request->get('content'));

        $paste->updated_at = Carbon::now();
        $paste->save();

        return redirect('/' . $slug);
    }

    public function getPaste($slug)
    {
        $paste = Paste::whereSlug($slug)->first();

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->creator))
            return abort(403);

        return view('paste.paste', [
            'paste' => $paste,
            'content' => file_get_contents(storage_path() . "/app/pastes/" . $paste->slug . ".txt")
        ]);
    }

    public function deletePaste($id)
    {
        $paste = Paste::find($id);

        unlink(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
        $paste->delete();

        return redirect("/");
    }

    public function togglePublic($id)
    {
        $paste = Paste::find($id);
        $paste->public = !$paste->public;
        $paste->save();

        return redirect('/' . $paste->slug);
    }

}
