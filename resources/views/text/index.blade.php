@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        </div>
        <br>

        <div class="col-sm-4 ">
            <a class="btn btn-sm btn-success" href="{{route('text.create')}}">
                <i class="fas fa-file-alt" style="font-size:14px;"></i>
            &nbsp;&nbsp;
            {{ trans('general.create_text') }}</a>
            &nbsp;
<!--             <a class="btn btn-sm btn-success" href="{{route('upload')}}">
                <i class="fas fa-file-upload" style="font-size:14px;"></i>
                {{ trans('general.upload_file') }}
                
                </a>
 -->
        </div>

        <br>
        @if($message= Session::get('success'))
            <div class="alert alert-success">
                <p>{{$message}}</p>
            </div>
        @endif

        <table class="table table-hover table-sm">
            <tr>
                <th width="50px"></th>
                <th width="50px"><b>No.</b></th>
                <th width="300px"><b>Titel</b></th>
                <th width="300px"><b>Text Data</b></th>
            </tr>

            @foreach ($texts as $text)
                <tr>
                    <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{$text->id}}" name="selectionFilter"
                            value="" onchange="setValue('{{$text->id}}')">
                        <label class="custom-control-label" for="{{$text->id}}"></label>
                    </div>                    
                    </td>
                    <td><b>{{++$i}}.</b></td>
                    <td>{{$text->titel}}</td>
                    <td>{{ substr($text->text_data, 0, 30) }}</td>
                    <td>
                        <form action="{{ route('text.destroy', $text->id) }}" method="post">
{{--                            <a class="btn btn-sm btn-success" href="{{route('text.show',$text->id)}}">Show</a>--}}
                            <a class="btn btn-sm btn-warning" href="{{route('text.edit',$text->id)}}"><i class="fas fa-edit" style="font-size:14px;"></i>&nbsp;
                            {{ trans('general.edit') }}
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick = "if (! confirm('delete element ?')) { return false; }">
                                <i class="fas fa-trash-alt" style="font-size:14px;"></i>&nbsp;&nbsp;
                                  {{ trans('general.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $texts->links() !!}
        <div class="col-sm-4 ">
                        <form action="{{ route('text.destroy_s') }}" method="post">
                            @csrf
                            <input type="hidden" value="" id="elements" name="elements">    
                            <button type="submit" class="btn btn-sm btn-danger" 
                            onclick = "check()">
                                <i class="fas fa-trash-alt" style="font-size:14px;"></i>&nbsp;&nbsp;
                                  delete selected
                            </button>
                        </form>

        </div>        

    </div>
    <script>
    function check(){
        if($j('#elements').val()==""){
            alert('no element selected')
            return false;
        }else{
            if (! confirm('delete element ?')) { return false; }            
        }
    }
        function setValue(ident){
            array = $j('#elements').val().split(',');
            if(array.indexOf(ident)==-1){
               array.push(""+ident)

            }else{

                array.splice(array.indexOf(ident), 1);
            }

            $j('#elements').val(array.join(','))
        }
    </script>
@endsection