@extends('main')

@section('title', '| Contact')

@section('content')

        <div class="row">
            <div class="md-col-12">
                <h1>Contact Us</h1>
                <hr>
                <form>
                  <div class="form-group">
                    <label name="email">Email:</label>
                    <input id="email" name="email" class="form-control">
                  </div>
                  <div class="form-group">
                    <label name="email">Subject:</label>
                    <input id="subject" name="subject" class="form-control">
                  </div>
                  <div class="form-group">
                    <label name="email">Subject:</label>
                    <textarea id="message" name="message" class="form-control">Type your message here...</textarea> 
                  </div>
                  <input type="submit" name="send" value="Send Message" class="btn btn-success">
                </form>
            </div>
        </div>

@endsection