//console.log('test string for checking native js');
//___________________________________________________________________________________________________________________
jQuery(document).ready(function(){  //console.log('test string for checking jQuery');

    /** ___________________________________________________ #PORTFOLIO SECTION in HOME page*/
    var portfolioSection = document.getElementById('portfolio_anchor_section');
    if( portfolioSection ) { //если мы находимся на странице HOME и у нас есть DOM с `var portfolioSection`
        var portfolioFiltersBlock = portfolioSection.querySelectorAll('div.portfolio-filters-block');
        var collectionBtnPortfolioFilters = portfolioFiltersBlock[0].querySelectorAll('a.btn-portfolio-filter'), //DOM-collection of buttons filter
            lengthCollectionBtnPortfolioFilters = collectionBtnPortfolioFilters.length; //length of DOM-collection of buttons filter
        var collectionPortfolioBlocks = portfolioSection.querySelectorAll('li.portfolio-block'), //DOM-collection of Portfolio Blocks
            lengthCollectionPortfolioBlocks = collectionPortfolioBlocks.length; //length of DOM-collection of Portfolio Blocks
    }

    /** filter the blocks of the portfolio by the name of the filter (button-filter) */
    function getIdFromBtnPortfolioFilter(event) {
        event = event || window.event; //for cross-browser

        var idBtnPortfolioFilter = this.getAttribute('id'); //OR: this.getAttribute('href');  //filter_3

        for( var k=0; k < lengthCollectionBtnPortfolioFilters; ++k ){
            collectionBtnPortfolioFilters[k].classList.remove('button-portfolio-filter-active');
        } //end loop for
        this.classList.toggle('button-portfolio-filter-active');

        for( var i=0; i < lengthCollectionPortfolioBlocks; ++i ){
            if( collectionPortfolioBlocks[i].hasAttribute('data-filter') ) {
                if( collectionPortfolioBlocks[i].getAttribute('data-filter') == idBtnPortfolioFilter ){ //если значение `id` кликнутой кнопки фильтра совпадает с зн-ем data-атрибута('data-filter') блока с портфолио,то присваивае CSS-класс c "display:block"
                    collectionPortfolioBlocks[i].classList.add('show-portfolio-block');
                    collectionPortfolioBlocks[i].classList.remove('hide-portfolio-block');
                }
                else{ //если нет,- не совпадает, то всем остальным блокам с портфолио присваиваем CSS-класс c "display:none"
                    collectionPortfolioBlocks[i].classList.remove('show-portfolio-block');
                    collectionPortfolioBlocks[i].classList.add('hide-portfolio-block');
                }
                if( idBtnPortfolioFilter == 'filter_0') { //если значение `id` кликнутой кнопки фильтра 'filter_0' - то всем элементам блоков с портфолио присваиваем CSS-класс 'show-portfolio-block' и соответственно отображаются все что есть блоки
                    collectionPortfolioBlocks[i].classList.add('show-portfolio-block');
                    collectionPortfolioBlocks[i].classList.remove('hide-portfolio-block');
                }
            } //end if
        } //end loop for
    } //__/function getIdFromBtnPortfolioFilter(event)

    for( var i=0; i < lengthCollectionBtnPortfolioFilters; ++i ){
        collectionBtnPortfolioFilters[i].onclick = getIdFromBtnPortfolioFilter;
    }
    /** ____________________________________________ /#PORTFOLIO SECTION in HOME page */


    /** ____________________________________________ #COMMENTS Block in SINGLE ARTICLE page */
    var singleArticlePage = document.getElementById('singlearticle_anchor_section');
    if( singleArticlePage ) { //если мы находимся на странице SINGLE ARTICLE и у нас есть DOM с `var singleArticlePage`
        var $ul_article_comment = jQuery(singleArticlePage).find('ul#ul_article_comment'); //весь блок <ul> с Комментариями как родительского уровня так и дочернено
        var $commentForm = jQuery(singleArticlePage).find('form#comment_on_article_form'); //parent add comment form
        var $commentFormChild = jQuery(singleArticlePage).find('form#comment_on_article_form_ch'); //child add sub-comment form

        /* Event click and Ajax for parent comments Form */
        $commentForm.on('click', 'button[type="submit"]', function(event){
            event.preventDefault(); //отменяем стандартное поведение(т.е. отправку Формы POST`ом) кнопки submit Формы
            //console.log($commentForm);

            jQuery('.block-result-info') //информационный блок в кот.выводим Юзеру информацию об ошибках или отработке успешного сохранения Комментария
                .css({'color':'blue'}).text('Saving comment in process').fadeIn(900,function() {
                    var $data = $commentForm.serializeArray(); //serializeArray() - возвращает содержимое Формы в виде Массива  //console.dir($data);

                    jQuery.ajax({
                        url: jQuery($commentForm).attr('action'), //путь к обработчику данных этой Формы,которые будут отправлены на сервер. //Это то,что мы указали в атрибуте `action` Формы отправки
                        data: $data,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, //дополнительная защита запроса дополнительным 'CSRF-TOKEN' (кот.нах.`resources/views/layouts/main_layout_site_pink.blade.php` в метаполе с name="csrf-token")
                        type: "POST",
                        datatype: 'JSON', //в каком виде получаем данные. В виде json-объекта
                        success: function(response){  //Ф-я которая будет выполняться при успешном выполнении запроса и отработке ajax
                            //console.log(response.error[0]); //смотрим что тут
                            //console.log($data); //смотрим что тут

                            if( response.error ){ //если в работе скрипта и отправки данных есть ошибки(смотреть их только через`NetWork` браузера)
                                var errorValidation = response.error.join('\r'); //или '\n'
                                jQuery('.block-result-info') //информационный блок в кот.выводим Юзеру информацию об ошибках или отработке успешного сохранения Комментария
                                    .css({'color':'red', 'font-weight':'bold'}).text( errorValidation ).delay(3500).fadeOut(1000,function() {
                                        // if()
                                    });
                            }
                            else { //если в работе скрипта и отправки данных все OK и комментарий сохранен
                                jQuery('.block-result-info') //информационный блок в кот.выводим Юзеру информацию об ошибках или отработке успешного сохранения Комментария
                                    .css({'color':'green', 'font-weight':'bold'}).text('Your comment has been successful!').delay(2000).fadeOut(1000,function() {
                                        $ul_article_comment.append(response.viewOneCommentAjax);
                                    });
                                $commentForm[0].reset(); //Очищаем нашу форму(поля Формы) от введенных данных
                            }
                        },
                        error: function(){  //Ф-я которая будет выполняться при неудачном выполнении запроса и отработке ajax
                            //
                        }
                    }); //__/jQuery.ajax
                });
        });
        /*__/Event click and Ajax for parent comments Form */

        /* Event click and Aiax for child comments Form */
        $btnCloseModalWindowWithThisForm = $commentFormChild.parent().parent().parent().parent().find('button.close');
        $commentFormChild.on('click', 'button[type="submit"]', function(event){
            event.preventDefault(); //отменяем стандартное поведение(т.е. отправку Формы POST`ом) кнопки submit Формы
            $commentFormChildThis = $(this).parent(); //Form Comment
            //$btnCloseModalWindowWithThisForm = $commentFormChildThis = $(this).parent().parent().parent().parent().find('button.close');

            jQuery('.block-result-info').css({'color':'green'}).text('Saving comment').fadeIn(900, function() {
                    var $data = $commentFormChildThis.serializeArray(); //serializeArray() - возвращает содержимое Формы в виде Массива  //console.dir($data);

                    jQuery.ajax({
                        url: jQuery($commentFormChildThis).attr('action'), //путь к обработчику данных этой Формы,которые будут отправлены на сервер. //Это то,что мы указали в атрибуте `action` Формы отправки
                        data: $data,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: "POST",
                        datatype: 'JSON', //в каком виде получаем данные. В виде json-объекта
                        success: function(response){  //Ф-я которая будет выполняться при успешном выполнении запроса и отработке ajax
                            //console.log(response.error[0]); //смотрим что тут
                            //console.log(response);
                            //console.log(response.dataforViewOneCommentAjax.if_user_is_login);

                            if( response.error ){ //если в работе скрипта и отправки данных есть ошибки(смотреть их только через`NetWork` браузера)
                                var errorValidation = response.error.join('\r'); //или '\n'
                                jQuery('.block-result-info') //информационный блок в кот.выводим Юзеру информацию об ошибках или отработке успешного сохранения Комментария
                                    .css({'color':'red', 'font-weight':'bold'}).text( errorValidation ).delay(3500).fadeOut(1000,function() {
                                    // if()
                                });
                            }
                            else { //если в работе скрипта и отправки данных все OK и комментарий сохранен
                                if( response.dataforViewOneCommentAjax.if_user_is_login === true ){ var findNeedLi = $data[3].value; }
                                else { var findNeedLi = $data[6].value; }  //console.log(findNeedLi); //смотрим что тут

                                $btnCloseModalWindowWithThisForm.click(); //имитируем нажатие на закрытие Модального окна с Формой
                                jQuery('.block-result-info') //информационный блок в кот.выводим Юзеру информацию об ошибках или отработке успешного сохранения Комментария
                                    .css({'color':'green', 'font-weight':'bold'}).text('Your comment has been successful!').delay(2000).fadeOut(1000,function() {

                                    //Выбираем в DOM`e тот родительский комментарий на который ответили,чтобы иметь возможность добавить к нему этот ответный комментарий
                                    var parentComment = $ul_article_comment.find('li[data-comment-id="'+findNeedLi+'"]'); //в comment_parent_comment_id содержится зн-е ID комментария на который ответили
                                    parentComment.next().after('<ul id="" class="ul-article-subcomment">' +response.viewOneCommentAjax+ '</ul>');
                                });
                            }
                        },
                        error: function(){  //Ф-я которая будет выполняться при неудачном выполнении запроса и отработке ajax
                            jQuery('.block-result-info') //информационный блок в кот.выводим Юзеру информацию об ошибках или отработке успешного сохранения Комментария
                                .css({'color':'red', 'font-weight':'bold'}).text( 'ERROR Application! Sorry').delay(3500).fadeOut(1000,function() {
                                // if()
                            });
                        }
                    }); //__/jQuery.ajax
                });
        });
        /*__/Event click and Ajax for child comments Form */

    } //_/end if
    /** _____________________________________________/#COMMENTS Block in SINGLE ARTICLE page */

}); //__/(document).ready
