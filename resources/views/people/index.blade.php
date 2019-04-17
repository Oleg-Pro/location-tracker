@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">People</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="add-button-container">
                        <a href="{{ route('people.create')}}" class="btn btn-primary">Add person</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>City</td>
                                <td>Email</td>
                                <td>Phone</td>
                                <td colspan="2">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($people as $person)
                            <tr>
                                <td>{{$person->fullName}}</td>
                                <td>{{$person->city->name}}</td>
                                <td>{{$person->email}}</td>
                                <td>{{$person->phone}}</td>
                                <td><a href="{{ route('people.edit',$person->id)}}" class="btn btn-primary">Edit</a></td>
                                <td>
                                    <form action="{{ route('people.destroy', $person->id)}}" class="delete" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                             </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if ($paginated)
                    {{ $people->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.delete').submit(function() {
        return (confirm("Do you want to delete this record?"));
    });
});
</script>

@endsection