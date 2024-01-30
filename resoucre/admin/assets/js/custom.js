function makeAjaxRequest(url, targetElementId) {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        data: {},
        beforeSend: function() {},
        success: function(data) {
            $('#' + targetElementId).html(data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        },
        complete: function() {}
    });
}
$(document).ready(function() {
    makeAjaxRequest('/ajax-tablespinhome', 'ShowBangXepHang');
    makeAjaxRequest('/ajax-tablespinhtruser', 'ShowBangXepHangUser');
});