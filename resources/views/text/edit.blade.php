@extends('layouts.app')
@include('partials.libraries')
@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-lg-8">
                <h3>{{ trans('general.edit_text') }}</h3>
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
       
                        
            <div class="col-md-12" style="margin-top: 10px;" id="upload-btns">
                <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Uplaod file
                </button>
                <div class="dropdown-menu" id="dropdownMenu">
                <a class="dropdown-item" href="#"><i class="fab fa-google-drive"></i>Google Drive </a>
                <a class="dropdown-item" href="#" id="dropbox"></a>
                <div class="dropdown-divider"></div>
                    <input type="file" name="filename" id="myFile" hidden="true" onchange="readFile(event)" accept=".docx, .pdf, .txt">
                    <label class="dropdown-item" for="myFile"">{{ trans('general.upload_file') }}</label>
                </div>
                </div>


            </div>          

        <form action="{{route('text.editAndStore', $textdata->id)}}" method="post" onsubmit="return getContent()">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="col-md-12">
                        <strong>Text titel</strong>
                        
                        <div id="html_data" style="display:none">
                        {{$textdata->html_data}}
                        </div>
                        <input type="text" name="lastId" hidden="true" id="lastId" value="{{$textdata->id}}">
                        <input class="form-control" placeholder="Type your titel here" value="{{$textdata->titel}}" name="titel" required id="custom-text" onkeyup="AutoSave()"/>
                    </div>
                    
                    <div class="col-md-12" align="center">
                        <div class="loading"></div>
                    </div>
                    
                    <div class="col-md-12">
                    <!--because div element_doesn't submit values, I use a hidden textarea to submit its content see getContent function -->
                    <div id="toolbar-container"></div>
                    <div name="content" id="editor1" class="ck-editor__editable" contenteditable="true" >
                        <!-- {{$textdata->html_data}} -->
                        </div>

                        <!-- because div element doesn't submit values, I use a hidden textarea to submit its content see getContent function -->
                        <div id="editor" contenteditable="true" required style="max-height:209px;overflow:auto;display:none;" onkeyup="AutoSave()"></div>
                        <textarea id="editorContentHTML" style="display:none" name="html_data"></textarea>
                        <textarea id="editorContentText" style="display:none" name="text_data"></textarea>
                    </div>

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
        </form>

        <script>

            $j(document).ready(function () {
                var waitCKEDITOR = setInterval(function() {
                    if (window.CKEDITOR) {
                        document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML =$('#html_data').text();                
                        clearInterval(waitCKEDITOR);
                    }
                }, 100/*milli*/);
                initializeTooltipNameOfPerson();
                var content_editor = CKEDITOR.instances['editor1'];
                content_editor.on('change', function () {

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


            function initializeTooltipNameOfPerson() {
                tippy('.namePerson', {
                    // content: document.querySelector('#template1').innerHTML,
                    delay: 100,
                    arrow: true,
                    arrowType: 'round',
                    size: 'large',
                    duration: 500,
                    animation: 'scale',
                    interactive: true,
                    theme: "light"
                });
            }

        </script>

        <script>
            function getContent() {
                document.getElementById("editorContentHTML").value = document.getElementById("editor").innerHTML;
                document.getElementById("editorContentText").value = document.getElementById("editor").innerText;
            }
        </script>

    </div>

    {{--Anwar Benhamada, 100$, 12 December in USA --}}
