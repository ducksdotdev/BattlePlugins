<?php namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\ShortUrl;
use App\Repositories\PasteRepository;
use App\Repositories\ShortUrlRepository;
use App\Tools\Domain;
use App\Tools\UserSettings;
use Auth;
use Illuminate\Http\Request;

/**
 * Class PasteController
 * @package App\Http\Controllers\Paste
 */
class PasteController extends Controller {

    /**
     *
     */
    function __construct() {
        $this->middleware('auth', ['except' => ['getPaste', 'getRawPaste', 'getDownloadPaste']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreatePaste(Request $request) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_PASTE)) {
            $content = $request->get('content');

            if (!$content)
                return redirect("/")->with('error', 'Do not leave the content field blank.');

            $slug = Domain::generateSlug();

            ShortUrl::create([
                'url'  => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $slug,
                'slug' => $slug
            ]);

            file_put_contents(storage_path() . "/app/pastes/$slug.txt", str_limit($content, env("PASTE_MAX_LEN",
                500000)));

            Paste::create([
                'slug'    => $slug,
                'user_id' => Auth::user()->id,
                'title'   => $request->title,
                'public'  => $request->has('public')
            ]);

            return redirect('/' . $slug);
        } else
            abort(403);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditPaste(Request $request) {
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
        } else
            abort(403);
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View|void
     */
    public function getPaste($slug) {
        $paste = PasteRepository::getBySlug($slug);

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->user_id))
            return abort(403);

        $file = storage_path() . "/app/pastes/" . $paste->slug . ".txt";
        if (!file_exists($file)) {
            PasteRepository::deleteBySlug($slug);
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
            'paste'   => $paste,
            'url'     => ShortUrlRepository::getBySlug($slug),
            'lines'   => $lines,
            'content' => $content,
            'lang'    => $lang
        ]);
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View|void
     */
    public function getRawPaste($slug) {
        $paste = PasteRepository::getBySlug($slug);

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->user_id))
            return abort(403);

        $content = file_get_contents(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
        return view('paste.raw', ['content' => $content]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDeletePaste($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_PASTE)) {
            $paste = Paste::find($id);

            if ($paste->user_id == Auth::user()->id)
                ShortUrlRepository::delete($id);

            return redirect("/");
        } else
            abort(403);
    }

    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|void
     */
    public
    function getDownloadPaste($slug) {
        $paste = PasteRepository::getBySlug($slug);

        if (!$paste)
            return abort(404);
        else if (!$paste->public && !(Auth::check() && Auth::user()->id == $paste->user_id))
            return abort(403);

        return response()->download(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public
    function postTogglePublic($id) {
        $paste = Paste::find($id);

        if ($paste->user_id == Auth::user()->id) {
            $paste->public = !$paste->public;
            $paste->save();
        }

        return redirect('/' . $paste->slug);
    }

    /**
     * @return \Illuminate\View\View
     */
    public
    function getIndex() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_PASTE)) {
            return view('paste.index', [
                'pastes' => auth()->user()->pastes
            ]);
        } else
            abort(403);
    }
}
