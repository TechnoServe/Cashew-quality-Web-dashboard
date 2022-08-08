$(function (){
    $(document).on("click", ".form-reset-button", function (){
        $(this).closest("form").find("select").val(null).trigger("change");
        $(this).closest("form").find("input[type=text]").val(null).trigger("change");
        $(this).closest("form").submit();
    })
})