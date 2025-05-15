jQuery.noConflict();
jQuery(document).ready(function($){
    $("#showmore").click(function(){
        
        $(".showContent").removeClass("d-none");
        $(".showContent").addClass("d-block");
        $("#showmore").removeClass("d-block");
        $("#showmore").addClass("d-none");

    });
    $("#showless").click(function(){
        
        $(".showContent").removeClass("d-block");
        $(".showContent").addClass("d-none");
        $("#showmore").removeClass("d-none");
        $("#showmore").addClass("d-block");

    })
})
