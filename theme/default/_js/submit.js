/*
 *        name: genericSubmit
 *        desc: It submits info to the server
 * paramaeters: action : sting, method : string, values : array, success : function, fail : function, always : function
 *     returns: none
 *
 */
 function genericSubmit(action, method, values) {
    var success = function(data){
        var result = JSON.parse(data);

        result.forEach(function(entry){
            var originalAction = entry['Action'];
            var action = originalAction.toLowerCase();

            switch (action){
                case 'message':
                case 'error':
                    openNotification(action, entry[originalAction]);
                    break;
                case 'redir':
                    window.location.href = rootURL + entry[originalAction];
                    break;
            } // switch end
        }); // iteration end
    } // success end

    var fail = function() {
        alert('Seu submit falhou!');
    }

    var always = function() {
        alert('Seu form...');
    }

    var result = null;

    method = method.toUpperCase();
    switch (method) {
        case 'POST':
            result = $.post(action, values, success);
            break;
        case 'GET':
            result = $.post(action, values, success);
            break;
    } // switch end
 }
