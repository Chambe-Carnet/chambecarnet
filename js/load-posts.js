jQuery(document).ready(function($) {
    if ($('body.home').length === 1) {
        // The number of the next page to load (/page/x/).
        var pageNum = parseInt(pbd_alp.startPage) + 1;

        // The maximum number of pages the current query can return.
        var max = parseInt(pbd_alp.maxPages);

        // The link of the next page of posts.
        var nextLink = pbd_alp.nextLink;

        /**
         * Replace the traditional navigation with our own,
         * but only if there is at least one page of new posts to load.
         */
        if (pageNum <= max) {
            // Insert the "More Posts" link.
            $('#main').addClass('pbd-alp-placeholder-'+ pageNum )
                .append('<p id="pbd-alp-load-posts"><a href="#">Load More Posts</a></p>');

            // Remove the traditional navigation.
            $('.navigation').remove();
        }


        /**
         * Load new posts when the link is clicked.
         */
        $('#pbd-alp-load-posts a').click(function(e) {
            e.preventDefault();
            var main = $('#main');
            var link = $(this);
            // Are there more posts to load?
            if (pageNum <= max) {

                // Show that we're working.
                $(this).text('Loading posts...');

                $.ajax({
                    type:'POST',
                    url : nextLink
                }).
                done(function(data) {
                    var html = $(data).find('#main').html();
                    main.append(html);
                    $('.navigation', main).remove();
                    link.parent().appendTo(main);
                    pageNum++;
                    nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);

                    // Add a new placeholder, for when user clicks again.
                    main.removeClass('pbd-alp-placeholder-'+(pageNum-1))
                        .addClass('pbd-alp-placeholder-'+pageNum);

                    // Update the button message.
                    if (pageNum <= max) {
                        link.text('Load More Posts');
                    } 
                    else {
                        link.remove();
                    }
                });
            }
            else {
                link.remove();
            }	

        });
    }
});