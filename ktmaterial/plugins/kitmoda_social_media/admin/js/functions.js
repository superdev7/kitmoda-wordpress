(function($) {
    $(function() {
        $('.action_remove').click(function(e) {
            e.preventDefault();
            console.log((this));
            $(this).closest('li.image_item').remove();
        })
    });
}(jQuery))