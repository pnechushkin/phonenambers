$(document).ready(function () {
    $('.rate_btn').click(function () {
        $('.rate_btn').removeClass('active');
        $('#rate').val($(this).val());
        $(this).addClass('active');
    });
    $('.call_type_brn').click(function () {
        $('.call_type_brn').removeClass('active');
        $('#call_type').val($(this).val());
        $(this).addClass('active');
    });
});