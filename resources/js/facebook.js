$(function() {

    /**
     * Confirm the deletion of the post
     *
     **/
    $('a.delete-post').confirm({
        theme: 'hololight',
        confirmButton: 'Yes',
        cancelButton: 'No',
        title: 'Are you sure?',
        content: 'The post will be deleted without possibility to restore!',
    });

});