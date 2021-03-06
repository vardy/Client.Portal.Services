@extends('layouts.main')

@section('title', 'Files/Create')

@section('sub_css_imports')
    <link rel="stylesheet" href="{{ mix('/css/files.css') }}" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
@endsection

@section('uploads_btn_style', 'color: rgb(0, 174, 199);')

@section('sub_content')

    @include('files.file-nav-buttons', ['current' => 'create'])

    <div class="upload-file-container">
        <div class="card">

            <h2>
                Upload
            </h2>

            <form id="form_create" method="POST" action="{{ route('files') }}" enctype=multipart/form-data>
                {{ csrf_field() }}

                <div>
                    <input type="hidden" name="locked" value="0">
                </div>

                <div>
                    <input type="file" id="fileselect" name="uploadedFiles[]" multiple required/>
                </div>

                <div id="filedrag">
                    <div class="filedrag-text">
                        <p>Or drag your files here...</p>
                    </div>
                </div>
            </form>

            @if($errors->any())
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p>
                If large or multiple files, it is recommended to zip (compress) the files and upload the archive,
                in order to reduce upload and download times.
            </p>

            <div>
                <a href="#" class="submit-button" id="form_submit" onclick="doSubmit();">
                    Upload
                </a>
            </div>

            <div id="upload-area" class="upload-area" style="display: none">
                <div class="progress">
                    <div class="bar"></div>
                </div>
                <span class="upload-text">Your file is being uploaded... This may take a while! Do not close this page.</span>
            </div>
        </div>
    </div>

    <!--
    Drag and drop file script
    -->
    <script type="text/javascript">

        function doSubmit() {
            document.getElementById('upload-area').style.display = 'block';
            document.getElementById('form_create').submit();
        }

        $(document).ready(function() {
            // getElementById
            function $id(id) {
                return document.getElementById(id);
            }

            // call initialization file
            if (window.File && window.FileList && window.FileReader) {
                Init();
            }

            // initialize
            function Init() {

                var fileselect = $id("fileselect"),
                    filedrag = $id("filedrag");

                // file select
                fileselect.addEventListener("change", FileSelectHandler, false);

                // is XHR2 available?
                var xhr = new XMLHttpRequest();

                if (xhr.upload) {
                    // file drop
                    filedrag.addEventListener("dragover", FileDragHover, false);
                    filedrag.addEventListener("dragleave", FileDragHover, false);
                    filedrag.addEventListener("drop", FileSelectHandler, false);
                    filedrag.style.display = "block";
                }
            }

            // file drag hover
            function FileDragHover(e) {
                e.stopPropagation();
                e.preventDefault();
                e.target.className = (e.type == "dragover" ? "hover" : "");
            }

            // file selection
            function FileSelectHandler(e) {
                // cancel event and hover styling
                FileDragHover(e);
                fileselect.files = e.dataTransfer.files;
                evt.preventDefault();
            }
        });
    </script>
@endsection
