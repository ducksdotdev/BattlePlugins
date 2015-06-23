<?php namespace App\Http\Controllers\Paste;

use App\Http\Controllers\Controller;
use App\Tools\Models\Paste;
use App\Tools\Models\ShortUrl;
use App\Tools\Models\User;
use App\Tools\URL\SlugGenerator;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasteController extends Controller
{

    function __construct()
    {
        $this->middleware('auth', ['except' => ['getPaste', 'getRawPaste', 'downloadPaste']]);
    }

    public function createPaste(Request $request)
    {
        $content = $request->get('content');

        if (!$content || (strlen($content) > env("PASTE_MAX_LEN", 500000)))
            return redirect("/");

		$slug = SlugGenerator::generate();

	    ShortUrl::create([
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $slug,
            'path' => $slug
        ]);

        file_put_contents(storage_path() . "/app/pastes/$slug.txt", $content);

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
        $content = $request->get('content');

        if (!$content || (strlen($content) > env("PASTE_MAX_LEN", 500000)))
            return redirect("/");

        $paste = Paste::find($request->id);

        if ($paste->creator == Auth::user()->id) {
            $slug = $paste->slug;

            file_put_contents(storage_path() . "/app/pastes/$slug.txt", $content);

            $paste->updated_at = Carbon::now();
            $paste->save();
        }

        return redirect('/' . $slug);
    }

    public function getPaste($slug)
    {
        $paste = Paste::whereSlug($slug)->first();

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->creator))
            return abort(403);

	    $content = file_get_contents(storage_path() . "/app/pastes/" . $paste->slug . ".txt");

	    $lines_arr = preg_split('/\n/',$content);
	    $lines = count($lines_arr);

        return view('paste.paste', [
            'paste' => $paste,
            'author' => User::find($paste->creator)->displayname,
            'url' => ShortUrl::wherePath($slug)->first(),
	        'lines' => $lines,
            'content' => $content
        ]);
    }

    public function getRawPaste($slug)
    {
        $paste = Paste::whereSlug($slug)->first();

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->creator))
            return abort(403);

        $content = file_get_contents(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
        return view('paste.raw', ['content' => $content]);
    }

    public function deletePaste($id)
    {
        $paste = Paste::find($id);

        if ($paste->creator == Auth::user()->id) {
            ShortUrl::wherePath($paste->slug)->delete();
            unlink(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
            $paste->delete();
        }

        return redirect("/");
    }

    public function downloadPaste($slug)
    {
        $paste = Paste::whereSlug($slug)->first();

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->creator))
            return abort(403);

        return response()->download(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
    }

    public function togglePublic($id)
    {
        $paste = Paste::find($id);

        if ($paste->creator == Auth::user()->id) {
            $paste->public = !$paste->public;
            $paste->save();
        }

        return redirect('/' . $paste->slug);
    }

}
