@extends('master_layout')

@section('title')
    | RSS Feed
@endsection

@section('content')
    <div class="container bg-white shadow">
        <div class="row">
            <div class="col-md-12">
                <h1>New York Times - Technology</h1>
                <hr>
                {{-- ToDo: Add success message when grabbing data from feed --}}
                {{-- ToDo: Add further logic to handle if no new data --}}
                {{-- ToDo: Grab categories, potentially filter by this field? --}}
                {{-- ToDo: Javascript button from requiements --}}
                {{-- ToDo: Use a dynamic logo for selected feed? --}}
                <div>
                    <form method="post" action="{{ route('feedReader') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">
                            Get Feed
                        </button>
                    </form>
                </div>

                <div>
                    <div class="container bg-white shadow">
                        <div class="row">
                            {{-- Output some basic data from db--}}
                            <table class="table table-strped">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Title</th>
{{--                                    <th scope="col">Link</th>--}}
{{--                                    <th scope="col">Guid</th>--}}
                                    <th scope="col">Description</th>
                                    <th scope="col">Published</th>
{{--                                    <th scope="col">Categories</th>--}}
                                </tr>
                                </thead>
                                {{-- ToDo: Validation and error handling --}}
                                @if ($feedData)
                                    @foreach ($feedData as $data)
                                        <tr>
                                            <td>
                                                {{ $data->title }}
                                            </td>
{{--                                            <td>--}}
{{--                                                {{ $data->link }}--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                {{ $data->guid }}--}}
{{--                                            </td>--}}
                                            <td>
                                                {{ $data->description }}
                                            </td>
                                            <td>
                                                {{ $data->pub_date }}
                                            </td>
{{--                                            <td>--}}
{{--                                                {{ $data->categories }}--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="centeredTitleText" colspan="9">
                                            No Data Found
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
