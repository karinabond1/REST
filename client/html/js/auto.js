(function ($) {

    var str = window.location.search;
    var strArray = str.split('=');
    $('input[type=text]#id_hidden').val(sessionStorage.getItem("id"));
    $('#btn_buy').click(function () {
        valid = true;
        var radioValue = $("input[name='payment']:checked").val();
        if (!radioValue) {
            alert("Please, choose the way of payment!");
            valid = false;
        }else if(sessionStorage.getItem("user")=='offline'){
            alert("Please, go on HOME page and be registered or log in!");
            valid = false;
        }
        if (valid) {
            $('#myForm').attr('action', 'thank.html');
            $('#btn_buy').attr('type', 'submit');
            var formData = $('#myForm').serialize();
            console.log(formData);

            request = $.ajax({
                url: "http://gfl:8070/REST/server/api/shop/buy/",
                type: "post",
                data: formData
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
                // Log a message to the console
                console.log("Hooray, it worked!");
                console.log(response);

                console.log(textStatus);
                console.log(jqXHR);
            });
            request.fail(function (jqXHR, textStatus, errorThrown) {
                // Log the error to the console
                console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                );
            });

        }
    });


    ajaxJson('http://gfl:8070/REST/client/api/shop/car/' + strArray[1], "GET", function (data) {
        document.getElementById("carsId").innerHTML = data["carsId"];
        var html = "";
        if (Array.isArray(data)) {
            //for (var i=0; i < data.length; i++) {
            html += '<p> Brand - ' + data[0]["brand"] + '</p>';
            html += '<p> Model - ' + data[0]["model"] + '</p>';
            html += '<p> Year issue - ' + data[0]["year_issue"] + '</p>';
            html += '<p> Engine capacity - ' + data[0]["engin_capacity"] + '</p>';
            html += '<p> Max speed - ' + data[0]["max_speed"] + '</p>';
            html += '<p> Price - ' + data[0]["price"] + '</p>';
            html += '<p> Color - ' + data[1]["color"] + '</p>';
            //}
        } else {
            html += "There is some problems. Please, try again later!";
        }
        document.getElementById("carsId").innerHTML = html;
    });


    function ajaxJson(url, method, callback) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log('responseText:' + xmlhttp.responseText);
                try {
                    var data = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    console.log(err.message + " in " + xmlhttp.responseText);
                    return;
                }
                callback(data);
            }
        };

        xmlhttp.open(method, url, true);
        xmlhttp.send();
    }


}(jQuery))