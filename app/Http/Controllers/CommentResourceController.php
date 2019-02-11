<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

use App\Comment;

class CommentResourceController extends SiteMainController
{
    public function __construct() {
        parent::__construct();
    }

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */ public function index() {}


    /** Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */ public function show($id) {}


    /** Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
    */ public function create() {}


    /** Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        $data_of_post = $request->except('_token'); 
        if( Auth::check() ) { 
            $rules = [  
                'comment_user_text' =>'required|min:5|max:255', 
            ]; 
        }
        else {
            $rules = [ 
                'comment_user_name' => 'required|max:50',
                'comment_user_email' => 'required|email', 
                'comment_user_site' => 'required|max:100', 
                'comment_user_text' =>'required|min:5|max:255', 
            ];
        }
        $messages = [
            'required' => 'The `:attribute` field is required! +',
            'comment_user_text.max' => 'The `:attribute` may not be greater than 255 characters! +',
            'comment_user_text.min'  => 'The `:attribute` must be greater than 5 characters! +',
            'email' => 'The `:attribute` mast be real & correct e-mail address! +',
        ];
        $validator = Validator::make( $data_of_post, $rules, $messages );

        if( $validator->fails() ) { //IF VALIDATION FAILS:
            return Response::json( ['error' => $validator->errors()->all()] );
        }
        else { //IF VALIDATION SUCCESS:
            if( Auth::check() ) {
                $create_result = Comment::create([
                    'text' => $data_of_post['comment_user_text'],
                    'name' => '',
                    'email' => '',
                    'site' => '',
                    'user_id' => $data_of_post['comment_user_id'],
                    'article_id' => $data_of_post['comment_article_id'],
                    'parent_comment_id' => $data_of_post['comment_parent_comment_id']
                ]);
                $currentUserInfo = array();
                $currentUserInfo['id'] = Auth::user()->id;
                $currentUserInfo['name'] = Auth::user()->name;
                $currentUserInfo['email'] = Auth::user()->email;
            }
            else {
                $create_result = Comment::create([
                    'text' => $data_of_post['comment_user_text'],
                    'name' => $data_of_post['comment_user_name'],
                    'email' => $data_of_post['comment_user_email'],
                    'site' => $data_of_post['comment_user_site'],
                    'user_id' => $data_of_post['comment_user_id'],
                    'article_id' => $data_of_post['comment_article_id'],
                    'parent_comment_id' => $data_of_post['comment_parent_comment_id']
                ]);
            }
            $dataforViewOneCommentAjax = array();
            $dataforViewOneCommentAjax['article_id'] = $data_of_post['comment_article_id'];
            $dataforViewOneCommentAjax['this_comment_text'] = $data_of_post['comment_user_text'];
            $dataforViewOneCommentAjax['comment_parent_comment_id'] = $data_of_post['comment_parent_comment_id'];
            $dataforViewOneCommentAjax['this_comment_id'] = '_temporarily';
            $dataforViewOneCommentAjax['parent_comment_id'] = 0;
            $dataforViewOneCommentAjax['user_name'] = ( Auth::user() ) ? Auth::user()->name : $data_of_post['comment_user_name'];
            $dataforViewOneCommentAjax['user_email'] = ( Auth::user() ) ? Auth::user()->email : $data_of_post['comment_user_email'];
            $dataforViewOneCommentAjax['if_user_is_login'] = ( Auth::user() ) ? true : false;
            $viewOneCommentAjax = view('frontendsite.'.env('THEME').'.include.__comment_one_comment_ajax')
                ->with( 'dataforViewOneCommentAjax', $dataforViewOneCommentAjax )->render(); 
            return Response::json( ['success'=>TRUE, 'viewOneCommentAjax'=>$viewOneCommentAjax, 'dataforViewOneCommentAjax'=>$dataforViewOneCommentAjax] ); 
        }

    }


    /** Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function edit($id) {}

    /** Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */ public function update(Request $request, $id) {}

    /** Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */ public function destroy($id) {}

}
