<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Components\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Tests\Iterator\MockFileListIterator;
use Symfony\Component\HttpFoundation\Response;
use Redirect;

class TextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard($tab)
    {
        $title = 'dashboard';

        //$texts = Text::where('user_id', auth()->id())->latest()->paginate(5);

        return view('text.dashboard',compact('tab','title'));

    }

    public function index()
    {
        $title = 'create';

        $texts = Text::where('user_id', auth()->id())->latest()->paginate(5);

        return view('text.index', compact('texts','title'))
            ->with('i', (request()->input('page',1) -1)*5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $title = 'create';

        return view('text.create',compact('title'));
    }


    public function upload()
    {   
        return view('text.upload');
    }  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'text_data' => 'required',
            'html_data' => 'required',
            'titel' => 'required'
        ]);

        Text::create([
            'text_data' => request('text_data'),
            'html_data' => request('html_data'),
            'titel' => request('titel'),
            'user_id' => auth()->id()
        ]);
        return redirect()->route('text.index')->with('sucess', 'new Text created successfully');
    }


//auto save function , store what user typed in textarea
    public function autosave(Request $request)
    {
       if($request->ajax()){
           
        $request->validate([
            'text_data' => 'required',
            'html_data' => 'required',
            'titel' => 'required'
        ]);
        //update data
        if ($request['lastId']!='') {
            //updating
            $text = Text::find($request['lastId']);
            $text->titel = $request['titel'];
            $text->text_data = $request['text_data'];
            $text->html_data = $request['html_data'];
            $text->save();            
            return response()->json(['server_id' =>$text->id,'server_title' => $text->titel,'server_text' => $text->text_data]);

        }else{
            //inserting
            $text = new Text();
            $text->html_data = $request['html_data'];
            $text->titel = $request['titel'];
            $text->text_data = $request['text_data'];
            $text->user_id =auth()->id();
            $text->save();
            return response()->json(['server_id' =>$text->id,'server_title' => $text->titel,'server_text' => $text->text_data]);

        }
      }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title='texts';
        $textdata = Text::find($id);
        return view('text.detail', compact('textdata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $textdata = Text::find($id);
        $title = 'edit';
        if (empty($textdata)) {
            return redirect('/text');
        }

        return view('text.edit', compact('textdata','title'));
    }


    public function editAndStore($id, Request $request)
    {
        $textdata = Text::find($id);

//        $request->validate([
//            'text_data' => 'required',
//            'titel' => 'required'
//        ]);

        $textdata->titel = request('titel');
        $textdata->text_data = request('text_data');
        $textdata->html_data = request('html_data');

        $textdata->save();
        return Redirect::to('/text');

//      return view('text.edit', compact('textdata'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'text_data' => 'required',
            'html_data' => 'required',
            'titel' => 'required'
        ]);

        $textdata = Text::find($id);
        $textdata->titel = $request->get('titel');
        $textdata->text_data = $request->get('text_data');
        $textdata->html_data = $request->get('html_data');
        $textdata->save();

        return redirect()->route('text.index')->with('success', 'value was updated');

    }


    public function download(){
        $fileContent = "baaaaaa";
        $response = response('File contents', 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="myfile.txt"',
        ]);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'foo.pdf'
        );



        return $response->headers->set('Content-Disposition',$disposition);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $textdata = Text::find($id);
        $textdata->delete();
        return redirect()->route('text.index')->with('success', 'value was deleted');
    }
    public function destroy_s(request $request)
    {  
        $elements = explode(',', $request['elements']);
        foreach ($elements as $key => $value){
            $textdata = Text::find($value);
            DB::table('texts')
            ->where('id',$value)
            ->delete();            
        }
     return redirect()->route('text.index')->with('success', 'value was deleted');
    }
    

    public function getfile(request $request)
    {
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $section = $phpWord->addSection();
            $html = '<h1>Adding element via HTML</h1>';
            $html .= '<p>Some well-formed HTML snippet needs to be used</p>';
            $html .= '<h2 style="align: center">centered title</h2>';

                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $request['html_code']);

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment;filename="HelloWorld.docx"');

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save('php://output');

    }

}
//collect shot 