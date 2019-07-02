(function($){
    var url = window.location.href;

    $('#btn_reg').click(function() {
        var formData = $('#reg_form').serializeArray();
        console.log(formData);
        
            
        if($.post( "http://192.168.0.15/~user14/REST/client/api/user/user/", { arr: formData } )){
            console.log("Horrey)");
        }
    });

    $('#btn_log').click(function() {

    });
    
    ajaxJson(window.location.href+'api/shop/cars', function(data) {
        document.getElementById("carsId").innerHTML = data["carsId"];
        var html = "";
        if(Array.isArray(data)){
            for (var i=0; i < data.length; i++) {
                html += '<a href=html/auto.html?auto_id=' + data[i]["id"] + '> <button name="btn_car" class="btn btn-secondary"><h5>' + data[i]["brand"]+ " " + data[i]["model"] + "</h5></button></a>";
            }                        
        }else{
            html += "There is some problems. Please, try again later!";
        }
        document.getElementById("carsId").innerHTML = html;
    });
                

    $('#btn_search').click(function() {
        valid = true;
        if ( document.contact_form.name.year_issue == "" )
        {
            
            alert ( "Please, fill the field Year issue.");
            valid = false;
        }
        if(valid){
            //$("div#carsSearch").toggle(); 
            var brand = document.getElementById('brand').value;
            var model = document.getElementById('model').value;
            var color = document.getElementById('color').value;
            if(brand == ""){
                brand="1";
            }if(model == ""){
                model="1";
            }if(color == ""){
                color="1";
            }
            
            var year_issue = document.getElementById('year_issue').value;
            var engin_capacity = document.getElementById('engin_capacity').value;
            var max_speed = document.getElementById('max_speed').value;
            var price_from = document.getElementById('price_from').value;
            var price_to = document.getElementById('price_to').value;

            ajaxJson(window.location.href+'api/shop/searchResult/'+brand+'/'+model+'/'+year_issue+'/'+engin_capacity+'/'+max_speed+'/'+color+'/'+price_from+'/'+price_to, function(data) {
                document.getElementById("carsSearch").innerHTML = data["carsSearch"];
                var html = "";
                if(Array.isArray(data)){
                    for (var i=0; i < data.length; i++) {
                        html += '<a href=html/auto.html?auto_id=' + data[i]["id"] + '> <button name="btn_car" class="btn btn-secondary"><h5>' + data[i]["brand"]+ " " + data[i]["model"] + "</h5></button></a>";
                    }                        
                }else{
                    html += "There is some problems. Please, change your data!";
                }
                document.getElementById("carsSearch").innerHTML = html;
            });
        }
    });

    function ajaxJson(url, callback) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log('responseText:' + xmlhttp.responseText);
                try {
                    var data = JSON.parse(xmlhttp.responseText);
                } catch(err) {
                    console.log(err.message + " in " + xmlhttp.responseText);
                    return;
                }
                callback(data);
            }
        };
    
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

}(jQuery))