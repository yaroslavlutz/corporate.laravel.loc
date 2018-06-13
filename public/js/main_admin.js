console.log('test string for checking native js');
//___________________________________________________________________________________________________________________
jQuery(document).ready(function(){  console.log('test string for checking jQuery');

    /** For work Tooltip by `Bootstrap` */
    jQuery('[data-toggle="tooltip"]').tooltip();

    /** For work CKEDITOR-library(ckeditor-4.0.8-standart) */
    var article_text_input_ckeditor = document.getElementById('article_text_input_ckeditor');
    if(article_text_input_ckeditor){ CKEDITOR.replace('article_text_input_ckeditor'); }

    /** For work jQuery UI(jquery-ui-1.12.1.custom) on `resources/views/backendsite/include/_form_add_menu.blade.php`*/
    jQuery("#accordion").accordion({
        active: false, //св-во отвечает за то,какая вкладка окажется открыта.Если указать false,то все вкладки будут закрыты изначально //active:'3'
        heightStyle: "content",  //высота секций аккордиона будет по контенту в этих секциях
        //heightStyle: "fill"  //высота секций аккордиона одинакова,вне зависимости от контента в нем и,если,контента больше,чем высота секции, будет полоса вертик.прокрутки
        collapsible: true, //позволяет открытой секции(в данный момент) закрываться при клике. Если не устанавливать это з-е в TRUE,то такого не будет

        //Ф-я,кот.будет вызываться в момент открытия вкладки аккордиона,и мы в ней можем что-то делать для активной вкладки
        activate: function(event,obj) {
            jQuery("#accordion input[type=radio]").each( function(){
                jQuery(this).attr('checked',false);
            }); //проходимся по всем радиокнопкав в аккордтоне и снимаем атрибут 'checked', если он присвоен
            obj.newPanel.prev().find('input[type=radio]').attr('checked',true); //обращаемся к радиокнопке в заголовке открытой(кликнутой) вкладки аккордиона и активируем ее
        }

    });



}); //__/(document).ready
