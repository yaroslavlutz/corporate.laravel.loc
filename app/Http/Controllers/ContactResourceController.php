<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactResourceController extends SiteMainController
{
    public function __construct() {
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index'; 
        $this->_bar_for_template_view = FALSE

        $this->_keywords = 'Contacts Page, Corporate site, LITTUS'; 
        $this->_meta_description = 'Contacts Page description text ...';
        $this->_title= 'CONTACTS';
    }

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__;
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info;
        $content_page = view('frontendsite.'.env('THEME').'.include._contacts');
        $this->_vars_for_template_view['page_content'] = $content_page;
        return $this->renderOutput();
    }


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
        if( $request->isMethod('post') ) {
            $rules = [
                'your_name' => 'required|max:30', 
                'your_email' => 'required|email', 
                'your_comment' =>'required|min:20', 
            ];

            $messages = [ 
                'required' => 'The `:attribute` field is required! +',
                'max' => 'The `:attribute` may not be greater than 30 characters! +',
                'email' => 'The `:attribute` mast be real & correct e-mail address! +',
                'min'  => 'The `:attribute` must be greater than 20 characters! +'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);  

            if( $validator->fails() ) { S:
                $request->flash(); 
                return redirect()->route('contacts')
                    ->withErrors($validator)->withInput($request->all());
            }
            else { //IF VALIDATION SUCCESS:
                $data_of_post = $request->except('_token'); 
                $mail_admin = 'littus@admin.gmail.com';
                $name_user = $request->your_name; 
                $email_user = $request->your_email; 
                $comment_user = $request->your_comment;

                Mail::to($mail_admin)->send( new OrderShipped($name_user, $email_user, $comment_user) ); 
                $request->session()->flash('status_success_send_mail', 'The +++ letter was successfully sent. Thank you!');
                return redirect()->route('contacts');
            }
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

}  //__/ContactResourceController
