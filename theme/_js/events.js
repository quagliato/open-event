/*
 *        name: setEvents
 *        desc: Stage all events.
 * paramaeters: none
 *     returns: none
 *
 */
function setEvents() {
    setSubmitEvents();
    setNotificationEvents();
    setClickEvents();
 }

/*
 *        name: setSubmitEvents
 *        desc: Stage all non-standard submit events actions.
 * paramaeters: none
 *     returns: none
 *
 */
function setSubmitEvents() {

    $('form.new_submit').submit(function(event){
        event.preventDefault();

        var values = bindData($(this));
        if (!values) {
            alert('NENHUM VALOR!');
            // ERROR - No values to submit
        }

        var action = $(this).attr('action');
        if (action == null || action == "") {
            alert('ACTION VAZIO OU NULO!');
            // ERROR - Every form needs an action
        }

        // Make this block better
        /**********************************************************************/
        var method = $(this).attr('method');
        if ((method == null || action == "")) {
            method = "POST"; // Default method will be 'POST'
        }

        method = method.toUpperCase();
        if (method != 'POST' && method != 'GET') {
            alert('METHOD NÃO É POST NEM GET!');
            // ERROR - Method should be a POST or a GET
        }
        /**********************************************************************/

        genericSubmit(action, method, values);
    });

    $('a.post').bind('click', function(event){
        event.preventDefault();

        var href = $(this).attr('href');
        var id = $(this).attr('id');

        var values = {};
        values['id'] = id;

        genericSubmit(href, 'POST', values);
    });
}

function setNotificationEvents() {
    $('#close_btn').bind('click', function(event) {
        event.preventDefault();

        closeNotification();
    });
}

  function setClickEvents(){
    $('.lightbox-open').bind('click', function(event) {
        event.preventDefault();
        openLightbox($(this).attr("href"));
    });

    $('#lightbox #close').bind('click', function(event) {
        event.preventDefault();
        closeLightbox();
    });

    $('#lightbox_overlay').bind('click', function(event) {
        event.preventDefault();
        closeLightbox();
    });

    $('.cancel').bind('click', function(event) {
        event.preventDefault();
        history.back();
    });

    // Every element with the class .fade-block should have an attribute
    // data-target that specifies the selector of another element that will be
    // fade in or fade out.
    $('.fade-block').bind('click', function(event){
        event.preventDefault();
        var target = $($(this).attr("data-target"));
        target.each(function(){
            if ($(this).hasClass("shown")) {
                $(this).removeClass("shown").removeClass("hidden").slideUp();
            } else {
                $(this).addClass("shown").slideDown();
            }
        });
    });
 }
