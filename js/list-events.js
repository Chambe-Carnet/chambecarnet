jQuery(document).ready(function($) {
    /**
     * Si on est sur la liste des événements
     */
    var list_events = $('body.events-list #tribe-events-content-wrapper');
    if (list_events.length > 0) {
        maj_style_articles(list_events);
        list_events.bind('DOMNodeInserted DOMNodeRemoved', function() {
            maj_style_articles($(this));
        });
        function maj_style_articles(list_events) {
            $('article', list_events).each(function() {
                var article = $(this);
                var div_event = $('.evenenemt', article);
                var div_meta = $('.tribe-events-event-meta', div_event);
                if (div_event.height() > div_meta.height()) {
                    $('> div', div_meta).css('position', 'absolute');
                }
            });
        }
    }
});