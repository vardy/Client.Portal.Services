@extends('layouts.main')

@section('title', 'Files')

@section('sub_content')
    <div>
        <a href="/files/upload">Upload a file.</a>

        <ul>
            @foreach($files as $file)
                <li style="margin-bottom: 15px">
                    {{ $file->fileName }}<br>
                    <form method="POST" action="/files/{{ $file->id }}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}

                        <a href="#" onclick="if(confirm('Are you sure you want to delete?')){parentNode.submit()}">Delete</a>
                    </form>
                    <a href="/files/{{ $file->id }}/edit">
                        Edit
                    </a><br>
                    <a href="/files/{{ $file->id }}">
                        Download
                    </a><br>
                    <a target="_blank" rel="noopener noreferrer" href="/files/{{ $file->id }}/view">
                        View
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection