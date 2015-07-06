function openNotification(type, content) {
    $('#notification_spot').removeClass().addClass('notification');
    switch (type.toLowerCase()) {
        case "error":
            $('#notification_spot').addClass('error');
            break;
        case "message":
            $('#notification_spot').addClass('message');
            break;

    }
    $('#notification_spot #notification_content').html(content);
    $('#notification_spot').slideDown();
}

function closeNotification() {
    $('#notification_spot').slideUp();
}
