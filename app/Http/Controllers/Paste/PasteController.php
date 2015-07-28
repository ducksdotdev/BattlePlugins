<?php namespace App\Http\Controllers\Paste;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use App\Models\ShortUrl;
use App\Tools\Misc\UserSettings;
use App\Tools\URL\SlugGenerator;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasteController extends Controller {

    function __construct() {
        $this->middleware('auth', ['except' => ['getPaste', 'getRawPaste', 'downloadPaste']]);
    }

    public function createPaste(Request $request) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_PASTE)) {
            $content = $request->get('content');

            if (!$content)
                return redirect("/")->with('error', 'Do not leave the content field blank.');

            $slug = SlugGenerator::generate();

            ShortUrl::create([
                'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $slug,
                'slug' => $slug
            ]);

            file_put_contents(storage_path() . "/app/pastes/$slug.txt", str_limit($content, env("PASTE_MAX_LEN",
                500000)));

            Paste::create([
                'slug' => $slug,
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'public' => $request->has('public')
            ]);

            return redirect('/' . $slug);
        }
    }

    public function editPaste(Request $request) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_PASTE)) {
            $content = $request->get('content');

            if (!$content)
                return redirect("/");

            $paste = Paste::find($request->id);

            if ($paste->user_id == Auth::user()->id) {
                $slug = $paste->slug;

                file_put_contents(storage_path() . "/app/pastes/$slug.txt", str_limit($content, env("PASTE_MAX_LEN",
                    500000)));

                $paste->updated_at = Carbon::now();
                $paste->save();
            }

            return redirect('/' . $slug);
        }
    }

    public function getPaste($slug) {
        $paste = Paste::whereSlug($slug)->first();

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->user_id))
            return abort(403);

        $file = storage_path() . "/app/pastes/" . $paste->slug . ".txt";
        if (!file_exists($file)) {
            Paste::whereSlug($slug)->delete();
            return abort(404);
        }

        $content = file_get_contents($file);

        $lines_arr = preg_split('/\n/', $content);
        $lines = count($lines_arr);

        $words = explode('.', $paste->title);
        if (count($words) > 1) {
            $pos = count($words) - 1;
            $lang = strtoupper($words[$pos]);
            if (!in_array($lang, config('paste')))
                $lang = 'txt';
        } else
            $lang = 'txt';

        return view('paste.paste', [
            'paste' => $paste,
            'url' => ShortUrl::whereSlug($slug)->first(),
            'lines' => $lines,
            'content' => $content,
            'lang' => $lang
        ]);
    }

    public function getRawPaste($slug) {
        $paste = Paste::whereSlug($slug)->first();

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->user_id))
            return abort(403);

        $content = file_get_contents(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
        return view('paste.raw', ['content' => $content]);
    }

    public function deletePaste($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_PASTE)) {
            $paste = Paste::find($id);

            if ($paste->user_id == Auth::user()->id) {
                ShortUrl::whereSlug($paste->slug)->delete();
                unlink(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
                $paste->delete();
            }

            return redirect("/");
        }
    }

    public function downloadPaste($slug) {
        $paste = Paste::whereSlug($slug)->first();

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->user_id))
            return abort(403);

        return response()->download(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
    }

    public function togglePublic($id) {
        $paste = Paste::find($id);

        if ($paste->user_id == Auth::user()->id) {
            $paste->public = !$paste->public;
            $paste->save();
        }

        return redirect('/' . $paste->slug);
    }

}
