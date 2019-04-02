@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit person</div>

                    <div class="card-body">
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                 </ul>
                                </div><br />
                        @endif

                        <form method="post" action="{{ route('people.update', $person->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">

                                <label for="country_id">City:</label>
                                <select class="form-control" name="city_id">
                                    @foreach ($cities as $city)
                                        <option {{ ($city->id == $person->city->id) ?  'selected': ''}} value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="last name">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $person->last_name }}"/>
                            </div>

                            <div class="form-group">
                                <label for="first name">First Name:</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $person->first_name }}"/>
                            </div>

                            <div class="form-group">
                                <label for="second name">Second Name:</label>
                                <input type="text" class="form-control" name="second_name" value="{{ $person->second_name }}"/>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" value="{{ $person->email }}"/>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" name="phone" value="{{ $person->phone }}"/>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection