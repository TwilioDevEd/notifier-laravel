<?php

namespace App\Notifications\Subscribers;


class Subscriber
{

    private $_id;

    private $_phoneNumber;

    private $_movies;

    /**
     * Subscriber constructor.
     *
     * @param $_id
     * @param $_number
     * @param $_movies
     */
    public function __construct($_id, $_number, $_movies)
    {
        $this->_id = $_id;
        $this->_phoneNumber = $_number;
        $this->_movies = $_movies ? $_movies : [];
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getPhoneNumber()
    {
        return $this->_phoneNumber;
    }

    public function getMovies()
    {
        return $this->_movies;
    }

    public function addMovie($movie)
    {
        if (!in_array($movie, $this->_movies)) {
            $this->_movies[] = $movie;
            return true;
        }
        return false;
    }

}