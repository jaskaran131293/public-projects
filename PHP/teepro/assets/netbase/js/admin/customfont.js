(function( $ ) {
    $(document).ready(function () {

        function upload_file(){
            $('.upload-custom-font').on( 'click', function() {

                var wrap = $(this).closest('.upload-font-block');
                var frame = new wp.media({
                    title: nbUpload.form_heading,
                    multiple: false,
                    button: {
                        text: nbUpload.button,
                    },
                });

                frame.open();

                var resultArray = [];
                var nameArray = [];

                frame.on('select', function() {

                    var fonts = frame.state().get('selection').toJSON();
                    var i;

                    for(i = 0; i < fonts.length; i++) {
                        resultArray.push(fonts[i].url);
                        nameArray.push(fonts[i].title);
                    }
                    
                    var name = [];

                    $.each(nameArray, function(i, e) {
                        if ($.inArray(e, name) == -1) name.push(e);
                    });


                    if(name.length === 1 ) {
                        resultArray.push(name);
                        wrap.find('.display-custom-font').val(resultArray[0]).trigger( 'change' );
                    }else {
                        alert("An error occurred, please try again!");
                    }               
                });
            });
        }
        upload_file();

        function output_value(){
            var inputSelector   = $('.customize-control-custom-font input[type=text]'); 
            inputSelector.on(
                'change',
                function() {
                    var outputValue     = '';
                    inputSelector.each(function (indexInArray, valueOfElement) { 
                        if($( this ).val() != '') {
                            if($( this ).attr('name') == 'font_name' ) {
                                var check_outputValue = $( this ).val().match(new RegExp("fontName:", "g")) || [].length;
                                if(check_outputValue.length == 1){
                                    outputValue += $( this ).val() + ',';
                                }else{
                                outputValue += 'fontName:' + $( this ).val() + ',';
                                }
                            }
                            else {
                                outputValue += $( this ).val() + ',';
                            }
                        }
                    });
                    outputValue = outputValue.slice(0, -1);
                    $( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( outputValue ).trigger( 'change' );
            });
        }
        output_value();

        if($('.remove-font').length <= 1){
            $('.remove-font').hide();
        }

        function remove_font(){
            $('.remove-font').on('click', function(){
                var index = $(this).data('index');
                upload_font_name = $('.upload-font-name[data-index='+index+']');
                upload_font_name.find("input:text").val("").trigger('change');
                upload_font_name.remove();

                clone_customfont_block = $('.clone-customfont-block[data-index='+index+']')
                clone_customfont_block.find("input:text").val("").trigger('change');
                clone_customfont_block.remove();
                
                $(this).remove();

                if($('.remove-font').length <= 1){
                    $('.remove-font').hide();
                }
            })
        }
        remove_font();

        $('.add-new-font').on('click', function(){
            data_index = $('.remove-font:last').data('index');
            data_index_number = Number(data_index) + 1;

            upload_font_name_new = $('.upload-font-name:last').last().clone();
            upload_font_name_new.attr('data-index', data_index_number);
            upload_font_name_new.find("input:text").val('').end().appendTo('.clone-customfont');

            clone_customfont_block_new = $('.clone-customfont-block:last').last().clone()
            clone_customfont_block_new.attr('data-index', data_index_number);
            clone_customfont_block_new.find("input:text").val("").end().appendTo('.clone-customfont');

            $('.remove-font:last').show();
            $('.remove-font:last').last().clone().attr('data-index', data_index_number).appendTo('.clone-customfont');

            upload_file();            
            output_value();
            remove_font();
        })   
    });
})( jQuery );

