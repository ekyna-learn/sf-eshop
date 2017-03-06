(function($) {
    var $collectionHolder;

    // setup an "add image" link
    var $addImageLink = $('<a href="#" class="btn btn-success">Add image</a>');
    var $newLinkLi = $('<li></li>').append($addImageLink);

    $(document).ready(function() {
        // Get the ul that holds the collection of images
        $collectionHolder = $('ul#product_images');

        $collectionHolder.find('li').each(function() {
            addImageFormDeleteLink($(this));
        });

        // add the "add image" anchor and li to the images ul
        $collectionHolder.append($newLinkLi);

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addImageLink.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // add a new image form (see next function)
            addImageForm($collectionHolder, $newLinkLi);
        });
    });

    function addImageForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add image" link li
        var $newFormLi = $('<li></li>').append(newForm);

        addImageFormDeleteLink($newFormLi);

        $newLinkLi.before($newFormLi);
    }

    function addImageFormDeleteLink($imageFormLi) {
        var $removeFormA = $('<a href="#" class="btn btn-xs btn-danger pull-right">Delete image</a>');
        $imageFormLi.append($removeFormA);

        $removeFormA.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the image form
            $imageFormLi.remove();
        });
    }

})(jQuery);
