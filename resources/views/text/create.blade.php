@extends('layouts.app')
@include('partials.libraries')
@section('content')

    <div class="container" xmlns="http://www.w3.org/1999/html">

        <div class="row">
            <div class="col-lg-8">
                <h3>{{ trans('general.new_text') }}</h3>
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <strong> There was some problems with the input</strong>
                <ul>
                    @foreach($errors as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <!-- <div class="col-md-12" style="margin-top: 10px;" id="upload-btns">
                <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Uplaod file
                </button>
                <div class="dropdown-menu" id="dropdownMenu">
                <a class="dropdown-item" href="#"><i class="fab fa-google-drive"></i>Google Drive </a>
                <a class="dropdown-item" href="#" id="dropbox"></a>
                <div class="dropdown-divider"></div>
                </div>
                </div>
            </div>           -->
            
                <input type="file" name="filename" id="myFile" hidden="true" onchange="readFile(event)" accept=".docx, .pdf, .txt">
                <label class="btn btn-sm btn-primary" for="myFile"><i class="fa fa-upload"></i></label>

        <form action="{{route('text.store')}}" method="post" onsubmit="return getContent()" id="storeForm">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                <div class="col-md-12">
                    <!-- <strong>{{ trans('general.text_title') }}</strong> -->
                        
                    <input type="text" name="lastId" hidden="true" id="lastId">
                    <input class="form-control" placeholder="{{ trans('general.input_placeholder') }}" name="titel" required id="custom-text" onkeyup="AutoSave()"/>
                </div>

                <div class="col-md-12" align="center">
                    <div class="loading">
                    </div>
                </div>
    
                <div class="col-md-12">
                  <div id='viewer' style="display: none;"></div>

                    <!--because div element_doesn't submit values, I use a hidden textarea to submit its content see getContent function -->
                    <!-- <div id="toolbar-container"></div> -->

                    <div name="content" id="editor1" class="ck-editor__editable" contenteditable="true">
                        </div>

                    <div id="editor" contenteditable="true" required  style="display:none;max-height:209px;overflow:auto;" onkeyup="AutoSave()"></div>
                    <textarea id="editorContentHTML" style="display:none" name="html_data"></textarea>
                    <textarea id="editorContentText" style="display:none" name="text_data"></textarea>

                </div>
        </form>

                <div class="col-md-12 right" >
                    <a href="{{route('text.index')}}" class="btn btn-sm btn-success"> <i class="fas fa-arrow-left"></i></a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                    <a href="javascript:void(0)" id="download" class="btn btn-sm btn-primary" onclick="getFile()" download> <i class="fas fa-download"></i></a>
                    
                </div>

            </div>
                <div class="col-lg-4">

                    @section('editorconrols')
                        @include('partials.editorcontrols')
                    @endsection

                    <script type="javascript" src="{{asset('js/mdb.js')}}"></script>
                    @endsection
                </div>
            </div>

        <script>
            $j(document).ready(function () { 
                var content_editor = CKEDITOR.instances['editor1'];
//                document.getElementById('cke_1_bottom')
                content_editor.on('change', function () {
                    localStorage.setItem('html_code',document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML);
                    //edit editor1-data
                    change_page = true;
                    var contentTEXT = content_editor.getData();
                    console.log(contentTEXT)
                    contentTEXT = contentTEXT.replace(/(\<style type=\"text\/css\"\>)([\s\S]*)(\<\/style\>)/, "")
                    contentTEXT = contentTEXT.replace("&nbsp;", " ");
                    contentTEXT = contentTEXT.replace("\n", "&nbsp;");
                    var dom = document.createElement("DIV");
                    dom.innerHTML = contentTEXT
                    var plain_text = (dom.textContent || dom.innerText);
                    editor.innerText = plain_text                      
                    AutoSave()
                });

            });


            function getContent() {
                var editor = document.getElementById("editor");
                var editorHTML = document.getElementById("editorContentHTML");
                var editorText = document.getElementById("editorContentText");
                editorHTML.value = editor.innerHTML;
                editorText.value = document.getElementById("editor").innerText;
            }
            // $('#storeForm').parsley();
        </script>
    </div>
