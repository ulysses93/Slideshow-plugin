jQuery(document).ready(function($) {
    var frame;
    
    $('#myslideshow-add-images').on('click', function(event) {
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        // Create the media frame.
        frame = wp.media({
            title: 'Select Images for Slideshow',
            button: {
                text: 'Add to Slideshow'
            },
            multiple: true // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        frame.on('select', function() {
            var attachments = frame.state().get('selection').map(function(attachment) {
                attachment = attachment.toJSON();
                return attachment;
            });

            var imageList = $('#myslideshow-image-list');
            var imageUrls = $('#myslideshow-images-input').val().split(',').filter(Boolean);

            attachments.forEach(function(attachment) {
                imageList.append('<li><img src="' + attachment.url + '" style="max-width:100px; height:auto;"/><button class="remove-image">Remove</button></li>');
                imageUrls.push(attachment.url);
            });

            $('#myslideshow-images-input').val(imageUrls.join(','));
        });

        // Finally, open the modal.
        frame.open();
    });

    // Remove image from list and update hidden input value
    $('#myslideshow-image-list').on('click', '.remove-image', function(event) {
        event.preventDefault();
        $(this).closest('li').remove();

        var imageUrls = $('#myslideshow-image-list img').map(function() {
            return $(this).attr('src');
        }).get();

        $('#myslideshow-images-input').val(imageUrls.join(','));
    });
});
