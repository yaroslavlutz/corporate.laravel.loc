<?php
//dump();
?>

<!-- Contacts Section -->
<div id="contacts_anchor_section" class="contacts-section" style="margin-top:145px;">
    <div class="container-fluid">
        <h1 class="wow slideInLeft" data-wow-duration="2.5s" data-wow-delay="0.3s" data-wow-offset="120">
            <a href="" style="text-transform:uppercase; color:gray; text-decoration:none;"> <?=( App::getLocale() == 'en' ) ? 'Contacts' : trans('custom_ru.contacts');?>: </a>
        </h1>
        <p class="wow slideInLeft" data-wow-duration="3.5s" data-wow-delay="0.5s" data-wow-offset="120" style="font-size:15px;">
            <?=( App::getLocale() == 'en' ) ? 'Write us a letter' : trans('custom_ru.write_us_a_letter');?>:
        </p>

        <div class="col-lg-12 col-md-12 text-center">
            <!-- Вывод ошибок Валидации списком. Вывод ошибок конкретно для каждого input`a прописана непосредственно под input`ом -->
            @if( count($errors) > 0 )
                <div class="alert alert-danger">
                    <img src="<?=asset('img/attention.png');?>" alt="" style="display:inline-block; float:left;">
                    <ul style="display:inline-block; text-align:left;"> @foreach( $errors->all() as $error ) <li>{{ $error }}</li> @endforeach </ul>
                </div>
            @endif
            <!-- Вывод flash-сообщения из сесии об успешной отправки письма, если оно успешно отправлено -->
            @if( session()->has('status_success_send_mail') )
                <div class="alert alert-success">
                    <i class="fa fa-check" style="font-size:48px; color:green; display:inline-block;"></i>
                    <ul style="display:inline-block;"> <li>{{ session('status_success_send_mail') }}</li> </ul>
                </div>
            @endif

            <form class="form-horizontal" name="contact_us_home_form" action="{{ route('contacts.store') }}" method="post" novalidate> <!-- <?//='/contact');?> Or <?//=route('contact');?> -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                        <input type="text" class="form-control <?=($errors->has('your_name')) ? 'input-error' : '';?>" name="your_name" id="your_name" placeholder="Your Name *" value="{{ old('your_name') }}">
                        @if ($errors->has('your_name')) <span class="help-block" style="color:darkred;"> {{ $errors->first('your_name') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                        <input type="email" class="form-control <?=($errors->has('your_email')) ? 'input-error' : '';?>" name="your_email" id="your_email" placeholder="Your E-mail *" value="{{ old('your_email') }}">
                        @if ($errors->has('your_email')) <span class="help-block" style="color:darkred;"> {{ $errors->first('your_email') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                        <textarea class="form-control <?=($errors->has('your_comment')) ? 'input-error' : '';?>" rows="5" name="your_comment" id="your_comment" placeholder="Your Message">
                            {{ old('your_comment') }}
                        </textarea>
                        @if ($errors->has('your_comment')) <span class="help-block" style="color:darkred;"> {{ $errors->first('your_comment') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                        <button type="submit" class="btn btn-lg btn-danger" name="btn_submit_contact_us_home_form" id="btn_submit_contact_us_home_form">SEND MESSAGE</button>
                    </div>
                </div>
            </form>
        </div>

    </div> <!--/.container-fluid-->
</div> <!--/#portfoliolist_anchor_section-->
<!--/Contacts Section -->