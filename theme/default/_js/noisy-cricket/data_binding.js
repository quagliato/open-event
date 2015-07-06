/*
 *        name: bindForm
 *        desc: It binds form's inputs into an array.
 * paramaeters: form : jQuery Object
                values : Array
 *     returns: JS array (the key is the property name, the value is the value)
 *
 */
function bindData(form, values) {
    var accepted_types = [
        "checkbox",
        "date", 
        "datetime", 
        "datetime-local", 
        "email", 
        "file", 
        "hidden", 
        "month", 
        "number", 
        "password", 
        "range", 
        "search", 
        "tel", 
        "text", 
        "time", 
        "url", 
        "week"
    ];

    if (values == null) {
        values = {};
    }

    form.children().each(function() {
        var name = $(this).attr('name');
        if (name == null || name == "") {
            // error
        }

        if ($(this).is('input')) { // if it's an input
            if (accepted_types.indexOf($(this).attr('type')) > -1) {
                if ($(this).attr('type') == "checkbox") { // checkbox has an special treatment
                    if ($(this).is(':checked')) { // get its value only if it's checked
                        var checkboxes = new Array();
                        if (values[name] != null) { // already exists an array of values for this name
                            checkboxes = values[name];
                        }
                        checkboxes[checkboxes.length] = $(this).attr("value"); // adds the new value to the array
                        values[name] = checkboxes; // add the array with the new value into the values array
                    }
                } else {
                    
                    if (values[name] != null) {
                        var newValues = null;
                        if (values[name].constructor === Array) {
                            newValues = values[name];
                        } else {
                            newValues = new Array();
                            newValues[0] = values[name];
                        }
                        newValues[newValues.length] = $(this).val();
                        values[name] = newValues;
                    } else {
                        values[name] = $(this).val();
                    }
                }
            }

        } else if ($(this).is('select')) { // if it's a select

            $(this).children().each(function(){
                if ($(this).is(':selected') && $(this).is('option')) { // if it's the selected option
                    values[name] = $(this).attr('value');
                }
            });

        } else if ($(this).is('textarea')) { // it it's a textarea
            if ($(this).hasClass('tinymce')) {
                values[name] = $(this).val();
            } else {
               values[name] = $(this).val();
            }
        } else {
            values = bindData($(this), values);
        }
    });

    if (values != null) {
        return values;
    }

    return false;
}
