@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add person</div>

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

                        <form method="post" action="{{ route('people.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="city_id">City:</label>
                                <select class="form-control" name="city_id">
                                    @foreach ($cities as $city)
                                        <option {{ ($city->id == old('city_id'))  ?  'selected': ''}} value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="last name" class="required">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}"/>
                            </div>


                            <div class="form-group">
                                <label for="first name" class="required">First Name:</label>
                                <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}"/>
                            </div>

                            <div class="form-group">
                                <label for="second name">Second Name:</label>
                                <input type="text" class="form-control" name="second_name" value="{{old('second_name')}}"/>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" value="{{old('email')}}"/>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}"/>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection