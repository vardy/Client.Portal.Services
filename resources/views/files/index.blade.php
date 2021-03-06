@extends('layouts.main')

@section('title', 'Files')

@section('sub_css_imports')
    <script src="{{ mix('/js/sorttable.js') }}"></script>
    <link rel="stylesheet" href="{{ mix('/css/files.css') }}" type="text/css">
@endsection

@section('uploads_btn_style', 'color: rgb(0, 174, 199);')

@section('sub_content')

        @include('files.file-nav-buttons', ['current' => 'index'])

        <div class="flavour-text-container">
            <div class="flavour-text">
                <p>Welcome to Lexallo's <b>secure file server</b>. This is where you upload
                    and download working files for your projects. <br><br>To protect the confidentiality
                    of your materials, all files will be
                    automatically removed two weeks after being uploaded.</p>
            </div>
        </div>

        <div class="file-table-container">
            <div class="card">
                <h2>
                    Client files
                </h2>

                @if($filesUser->isNotEmpty())
                    <table class="file-table sortable">
                        <tr class="heading-row">
                            <th class="heading-name">
                                File Name
                            </th>
                            <th class="heading-size">
                                Size
                            </th>
                            <th class="heading-date td-right">
                                Date Uploaded
                            </th>
                        </tr>

                        @foreach($filesUser as $file)
                            <tr class="normal-row">
                                <td>
                                    <span class="truncate-span">
                                        <a href="/files/{{ $file->id }}" title="Download file">
                                            <i class="fas fa-cloud-download-alt"></i>
                                        </a>
                                        <a href="/files/{{ $file->id }}/edit" title="Edit file">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{ $file->fileName }}
                                    </span>
                                </td>
                                <td>
                                    <span class="truncate-span">{{ substr(strval((int) $file->fileSize / 1000000), 0, 5) }} MB</span>
                                </td>
                                <td class="td-right">
                                    <span>{{ substr($file->created_at, 0, 16) }}</span>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                @else
                    <div class="no-files-container">
                        <p class="no-files-message">Doesn't look like you have any files! You can start by clicking 'Upload a file'.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="file-table-container">
            <div class="card">
                <h2>
                    Deliverables
                </h2>

                @if($filesDeliverable->isNotEmpty())
                    <table class="file-table sortable">
                        <tr class="heading-row">
                            <th class="heading-name">
                                File Name
                            </th>
                            <th class="heading-size">
                                Size
                            </th>
                            <th class="heading-date td-right">
                                Date Uploaded
                            </th>
                        </tr>

                        @foreach($filesDeliverable as $file)
                            <tr class="normal-row">
                                <td>
                                    <span class="truncate-span">
                                        <a href="/files/{{ $file->id }}" title="Download file">
                                            <i class="fas fa-cloud-download-alt"></i>
                                        </a>
                                        {{ $file->fileName }}
                                    </span>
                                </td>
                                <td>
                                    <span class="truncate-span">{{ substr(strval((int) $file->fileSize / 1000000), 0, 5) }} MB</span>
                                </td>
                                <td class="td-right">
                                    <span>{{ substr($file->created_at, 0, 16) }}</span>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                @else
                    <div class="no-files-container">
                        <p class="no-files-message">Doesn't look like you have any deliverables!</p>
                    </div>
                @endif
            </div>
        </div>
@endsection