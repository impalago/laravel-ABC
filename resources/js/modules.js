
var commonProperties = {

    /**
     * Ajax Request
     *
     * @param The current element
     * @param Callback
     * @param dataType
     * @param data
     **/
    'queryAjax' : function($elem, callback,dataType, data) {
        $.ajax({
            type: $elem.data('method') ? $elem.data('method') : $elem.attr('method'),
            url: $elem.data('action') ? $elem.data('action') : $elem.attr('action'),
            data: data ? data : $elem.serialize(),
            dataType: dataType ? dataType : 'html',
            success: function(data) {
                if(typeof callback === 'function') {
                    callback(data);
                } else {
                    location.reload();
                }
            }
        });
    },

    /**
     * Ajax Preloader
     *
     **/
    'ajaxPreloader' : function() {
        $(document).ajaxStart(function() {
            $('#preloader').fadeIn('slow');
        }).ajaxComplete(function(){
            $('#preloader').fadeOut('slow');
        });
    }

};
