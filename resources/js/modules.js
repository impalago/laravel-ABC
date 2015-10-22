
var commonProperties = {

    'queryAjax' : function($elem, callback,dataType, data) {
        $.ajax({
            type: $elem.attr('method') ? $elem.attr('method') : $elem.data('method'),
            url: $elem.attr('action') ? $elem.attr('action') : $elem.data('action'),
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
    }
};
