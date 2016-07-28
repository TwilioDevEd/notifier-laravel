@extends('layouts.master')

@section('title', 'STAR WARS')

@section('content')
    <h3 class="title spaced">STAR WARS</h3>
    <p class="spaced">
        | Receive update, you must!
    </p>
    <div class="row">
        <div class="col-md-12">
            <form action="/notifications" class="form-horizontal" method="POST">
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Message</label>
                    <div class="col-md-10">
                        <textarea name="message" id="" cols="30" rows="10"
                                  class="form-control" maxlength="250" required></textarea>
                        <span class="text-primary" id="validation_message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Movie</label>
                    <div class="col-md-10">
                        <select name="movie" id="" class="form-control" required>
                            @foreach ($valid_movies as $movie_name => $movie_title)
                                <option value="{{ $movie_name }}">{{ $movie_title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-10 col-md-offset-2">
                        <button class="btn btn-primary">
                            <i class="fa fa-envelope"></i> Send Notifications
                        </button>
                        <a href="#" class="btn btn-danger" id="reset">
                            <i class="fa fa-close"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection