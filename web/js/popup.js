$(function() {
    $('.popupss').on('click', function(event)  {
        event.preventDefault();
        $.colorbox({
            href: event.target.href,
            onComplete: function(){
                $("#locationlist").on("change",function(event) {
                    url = "../ajax/sensors?locationid=" + ($(this).val()).toString();
                    $.getJSON(url, function(response, newOptions) {
                        var newOptions = response;
                        $("#catchmentdescription").text(newOptions.description);
                        var $el = $("#sensorslist");
                        $el.empty();
                        $.each(newOptions.sensors, function(value,key) {
                          $ali = $("<a></a>").attr("href", "sensor?sensorid="+value).text("" + key);
                          $el.append($ali);
                          $ali.wrap("<li></li>");
                        });                        
                    });
                });

            $.colorbox.resize({
                width: ($(window).width() < 800) ? '100%' :'800',
                height: ($(window).height() < 600) ? '100%' :'600',
                });

            }
        });
    });


    $("#uploaddataform-catchmentid").on("change",function(event) {
        url = "../ajax/sensors?locationid=" + ($(this).val()).toString();
        $.getJSON(url, function(response, newOptions) {
            var newOptions = response;
            var $el = $("#uploaddataform-sensorid");
            $el.empty();
            $.each(newOptions, function(value,key) {
              $el.append($("<option></option>")
                 .attr("value", value).text(key));
            });
        });
      });

   

});

