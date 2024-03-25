(function( $ ) {
    $(document).ready(function () {

        // var ggFonts = nbUpload.google_fonts;

        $('select[name="select-font-type"]').on('change', function() { 
            var wrap = $(this).closest('.customize-control-typography');
            var option = $(this).val();
            var fontFamily = "";
            if(option === 'google') {
                wrap.find('.google-fonts-wrap').slideDown('fast');
                wrap.find('.nb-custom-fonts').slideUp('fast');
                wrap.find('.nb-select-standard-wrap').slideUp('fast');
                fontFamily = wrap.find('.chosen-single').text();
            } else if(option === 'custom') {
                wrap.find('.google-fonts-wrap').slideUp('fast');
                wrap.find('.nb-custom-fonts').slideDown('fast');
                wrap.find('.nb-select-standard-wrap').slideUp('fast');
                fontFamily = wrap.find('select[name="custom-fonts-select"]').children("option").filter(":selected").text();
            } else {
                wrap.find('.google-fonts-wrap').slideUp('fast');
                wrap.find('.nb-custom-fonts').slideUp('fast');
                wrap.find('.nb-select-standard-wrap').slideDown('fast')
                fontFamily = wrap.find('select[name="standard-fonts-select"]').children("option").filter(":selected").text();
            }
            wrap.find('.font-holder').val(option +','+fontFamily).change();
        });

        $('.customize-control-typography select[name="google-fonts-select"]').on('change', function() {
            var wrap = $(this).closest('.customize-control-typography');
            var fontFamily = wrap.find('.chosen-single').text();

            wrap.find('.font-holder').val('google,' + fontFamily).change();
        });

        $('.customize-control-typography select[name="standard-fonts-select"]').on('change', function() {
            var wrap = $(this).closest('.customize-control-typography');
            var fontFamily = $(this).children("option").filter(":selected").text();

            wrap.find('.font-holder').val('standard,' + fontFamily).change();
        });
       
        $('.customize-control-typography select[name="custom-fonts-select"]').on('change', function() {
            var wrap = $(this).closest('.customize-control-typography');
            fontFamily =$(this).children("option").filter(":selected").text();
    
            wrap.find('.font-holder').val('custom,' + fontFamily).change();
        });
    } );


})( jQuery );

