@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Send SMS</div>

                <div class="panel-body">
                    @if (session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form role="form" method="POST" action="{{ route('sms.send') }}">
                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        <div class="form-group {{ $errors->has('number') ? 'has-error' : '' }}">
                            <label for="number" class="control-label">Phone Number</label>
                            <input type="text" name="number" class="form-control" value="{{ old('number') }}">
                            <span class="help-block">{{ $errors->first('number') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label for="message" class="control-label">Message</label>
                            <textarea name="message" class="form-control">{{ old('message') }}</textarea>
                            <span class="help-block">{{ $errors->first('message') }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
