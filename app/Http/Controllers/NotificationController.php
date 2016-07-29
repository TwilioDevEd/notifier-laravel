<?php

namespace App\Http\Controllers;

use App\Notifications\NotificationsManager;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $_notificationsManager;

    public function __construct(NotificationsManager $notificationsManager)
    {
        $this->_notificationsManager = $notificationsManager;
    }

    /**
     * Show the notification form
     *
     * @return Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("notifications", $this->_getViewParams());
    }

    /**
     * Store a new notification.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse Redirects to the form
     */
    public function store(Request $request)
    {
        $message = $request->input("message");
        $movie = $request->input("movie");

        $msg = $this->_getViewParams();

        if ($this->_notificationsManager->createNotification($movie, $message)) {
            $msg = "Well done! The force is strong with you.";
        } else {
            $msg = "The notification could not be sent.";
        }

        return redirect()->route("notification..index")->with("message", $msg);
    }

    private function _getViewParams()
    {
        $validMovies = config("app.valid_movies");

        return [
            "flash" => [],
            "valid_movies" => $validMovies
        ];
    }

}
