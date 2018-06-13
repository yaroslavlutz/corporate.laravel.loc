<?php
namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $request;

    public function __construct( Request $request ) {
        $this->request = $request;
    }
    //__________________________________________________________________________________________________________________

    /** Create new tag
     * @return \Illuminate\Http\Response
    */
    public function create() {
        $objectTag = new Tag();

        $request_all = $this->request->all();  //dd( $request_all['text'] );
        $objectTag->text = $request_all['text'];
        $objectTag->save();
    }

    /** Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id) {
        $response = Tag::find($id);
        if( !$response ) {
            return response()->json([
                'status' => 'error',
                'data' => ['message' => 'there is no record with ID = ' .$id. ' ID in the database']
            ]);
        }
        else {
            return response()->json([
                'status' => 'success',
                'data' => ['message' => $response]
            ]);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
