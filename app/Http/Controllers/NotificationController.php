<?php

namespace App\Http\Controllers;

use app\Notifications\NotificationsManager;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

        $viewParams = $this->_getViewParams();

        if ($this->_notificationsManager->createNotification($movie, $message)) {
            $viewParams["flash"] = "Well done! The force is strong with you.";
        } else {
            throw new ValidationException(
                "Wrong input! Please check your form data"
            );
        }
        return redirect()->route("notification..index");
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
