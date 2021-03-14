//alert("food-script.js");
$("#food-message").hide();
$("#food").on("blur", function(){

    let food = $("#food").val();
    //alert (food);

    $.post("lookup", { food : food }, function(result) {
        //alert(result);

        //Display message if food is not found
        if(result == 0) {
            $("#food-message").show();
        }
        else {
            $("#food-message").hide();
        }
    });
});